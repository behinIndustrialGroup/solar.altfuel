<?php

use App\Http\Controllers\InstallerRegistrationController;
use App\Models\User;
use BaleBot\Controllers\BotController;
use Behin\SimpleWorkflow\Controllers\Core\CaseController;
use Behin\SimpleWorkflow\Controllers\Core\PushNotifications;
use Behin\SimpleWorkflow\Controllers\Core\VariableController;
use Behin\SimpleWorkflow\Jobs\SendPushNotification;
use BehinInit\App\Http\Middleware\Access;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SmeRegistrationController;

Route::get('installer/apply', [InstallerRegistrationController::class, 'create'])->name('installers.apply');
Route::post('installer/apply', [InstallerRegistrationController::class, 'store'])->name('installers.store');

Route::get('', function(){
    if(Auth::check()){
        return redirect()->route('admin.dashboard');
    }
    return view('auth.login');
})->name('home');

require __DIR__.'/auth.php';
require __DIR__.'/services.php';

Route::prefix('admin')->name('admin.')->middleware(['web', 'auth', Access::class])->group(function(){
    Route::get('', function(){
        return view('admin.dashboard');
    })->name('dashboard');
});

Route::get('/pusher/beams-auth', function (Request $request) {
    $beamsClient = new PushNotifications([
        'instanceId' => config('broadcasting.pusher.instanceId'),
        'secretKey' => config('broadcasting.pusher.secretKey')
    ]);
    $userId = auth()->user()->id;
    $beamsToken = $beamsClient->generateToken('user-mobile-'.$userId);
    // $user = User::find($userId);
    return response()->json($beamsToken);
})->middleware('auth');

Route::get('send-notification', function () {
    SendPushNotification::dispatch(Auth::user()->id, 'test', 'test', route('admin.dashboard'));
    return 'تا دقایقی دیگر باید نوتیفیکیشن دریافت کنید';
})->name('send-notification');

Route::get('queue-work', function () {
    $limit = 5; // تعداد jobهای پردازش شده در هر درخواست
    $jobs = DB::table('jobs')->orderBy('id')->limit($limit)->get();

    foreach ($jobs as $job) {
        try {
            // دیکد کردن محتوای job
            $payload = json_decode($job->payload, true);
            $command = unserialize($payload['data']['command']);

            // اجرای job
            $command->handle();

            // حذف job پس از اجرا
            DB::table('jobs')->where('id', $job->id)->delete();

            // return 'Job processed: ' . $job->id;
        } catch (Exception $e) {
            // در صورت خطا، job را به جدول failed_jobs منتقل کنید
            DB::table('failed_jobs')->insert([
                'connection' => $job->connection ?? 'database',
                'queue' => $job->queue,
                'payload' => $job->payload,
                'exception' => (string) $e,
                'failed_at' => now()
            ]);

            DB::table('jobs')->where('id', $job->id)->delete();

            return 'Job failed: ' . $e->getMessage();
        }
    }
});

Route::get('build-app', function(){
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('view:clear');
    Artisan::call('migrate');
    return redirect()->back();
});

Route::get('migrate', function(){
    Artisan::call('migrate');
    return redirect()->back();
});

Route::get('migrate-catalogs', function(){
    $paths = [
        base_path('packages/inspector-catalog/src/Database/Migrations'),
        base_path('packages/panel-catalog/src/Database/Migrations'),
        base_path('packages/inverter-catalog/src/Database/Migrations'),
        base_path('packages/battery-catalog/src/Database/Migrations'),
        base_path('packages/contractor-catalog/src/Database/Migrations'),
        base_path('packages/solar-plant-equipment/src/Database/Migrations'),
    ];

    $logs = [];
    foreach ($paths as $path) {
        try {
            Artisan::call('migrate', ['--path' => str_replace(base_path().'/', '', $path), '--force' => true]);
            $logs[] = "✅ " . basename(dirname($path, 2)) . ":\n" . trim(Artisan::output());
        } catch (\Exception $e) {
            $logs[] = "❌ " . basename(dirname($path, 2)) . ": " . $e->getMessage();
        }
    }

    return response('<pre style="padding:20px; font-family:monospace; background:#f8f9fa;">' . implode("\n\n", $logs) . '</pre>');
});





Route::get('setup-packages', function(){
    try {
        $startTime = microtime(true);
        $logs = [];
        
        // 1. Dump Autoload (شبیه‌سازی composer dump-autoload)
        $logs[] = "🔄 در حال بارگذاری مجدد Autoload...";
        Artisan::call('clear-compiled');
        Artisan::call('optimize:clear');
        
        // 2. Clear all caches
        $logs[] = "🧹 پاک‌سازی Cache...";
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('route:clear');
        Artisan::call('view:clear');
        Artisan::call('event:clear');
        
        // 3. Run migrations
        $logs[] = "📊 اجرای Migrations...";
        Artisan::call('migrate', ['--force' => true]);
        $migrationOutput = Artisan::output();
        
        // 4. Create storage link if not exists
        if (!file_exists(public_path('storage'))) {
            $logs[] = "🔗 ایجاد Storage Link...";
            Artisan::call('storage:link');
        } else {
            $logs[] = "✓ Storage Link از قبل موجود است";
        }
        
        // 5. Optimize for production
        $logs[] = "⚡ بهینه‌سازی برای Production...";
        Artisan::call('config:cache');
        Artisan::call('route:cache');
        Artisan::call('view:cache');
        
        // 6. List all registered routes
        $logs[] = "\n📋 لیست Route های ثبت شده:";
        $routes = collect(Route::getRoutes())->filter(function($route){
            return str_contains($route->getName() ?? '', 'catalog') || 
                   str_contains($route->uri(), 'catalog');
        })->map(function($route){
            return "  - " . ($route->getName() ?? $route->uri()) . " → " . url($route->uri());
        })->values()->toArray();
        
        $logs = array_merge($logs, $routes);
        
        $endTime = microtime(true);
        $executionTime = round($endTime - $startTime, 2);
        
        // Format output
        $output = "✅ راه‌اندازی پکیج‌ها با موفقیت انجام شد!\n";
        $output .= "⏱️  زمان اجرا: {$executionTime} ثانیه\n";
        $output .= str_repeat("─", 60) . "\n\n";
        $output .= implode("\n", $logs);
        $output .= "\n\n" . str_repeat("─", 60) . "\n";
        $output .= "📝 خروجی Migration:\n" . trim($migrationOutput);
        $output .= "\n\n" . str_repeat("─", 60) . "\n";
        $output .= "✨ تمام پکیج‌ها آماده استفاده هستند!\n\n";
        $output .= "⚠️  توجه: اگر کلاس‌ها شناخته نشدند، از terminal سرور اجرا کنید:\n";
        $output .= "   composer dump-autoload";
        
        return response('<pre style="direction:rtl; text-align:right; padding:20px; background:#f8f9fa; border:1px solid #ddd; border-radius:5px; font-family:Tahoma; white-space:pre-wrap;">' . $output . '</pre>');
        
    } catch (\Exception $e) {
        $error = "❌ خطا در راه‌اندازی:\n\n";
        $error .= "پیام خطا: " . $e->getMessage() . "\n";
        $error .= "فایل: " . $e->getFile() . "\n";
        $error .= "خط: " . $e->getLine() . "\n\n";
        $error .= "Stack Trace:\n" . $e->getTraceAsString();
        
        return response('<pre style="direction:rtl; text-align:right; padding:20px; background:#fff3cd; border:1px solid #ffc107; border-radius:5px; font-family:Tahoma; white-space:pre-wrap;">' . $error . '</pre>');
    }
})->name('setup-packages');
