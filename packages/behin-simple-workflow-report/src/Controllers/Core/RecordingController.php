<?php

namespace Behin\SimpleWorkflowReport\Controllers\Core;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\StreamedResponse;

class RecordingController extends Controller
{
    public function streamRecording($uniqueid)
    {
        // 1️⃣ پیدا کردن رکورد در دیتابیس CDR ایزابل
        $record = DB::connection('asterisk')->table('cdr')->where('uniqueid', $uniqueid)->first();
        if (!$record || empty($record->recordingfile)) {
            return response()->json([
                'success' => false,
                'message' => 'رکورد یا فایل ضبط یافت نشد.'
            ], 404);
        }

        $recordingFile = $record->recordingfile;
        $fileName = basename($recordingFile);

        // 2️⃣ ساخت URL کامل فایل (فرض بر اینه recordings از طریق وب سرو میشن)
        $baseUrl = config('behin-ami.recordings.base_url'); // مثلاً https://91.247.171.3/recordings/
        $url = rtrim($baseUrl, '/') . '/' . ltrim($recordingFile, '/');

        // 3️⃣ اگر ایزابل نیاز به Basic Auth دارد
        $username = env('AMI_WEB_USER', null);
        $password = env('AMI_WEB_PASSWORD', null);

        try {
            $http = Http::withOptions(['verify' => false]);
            if ($username && $password) {
                $http = $http->withBasicAuth($username, $password);
            }

            $response = $http->get($url);

            if ($response->failed()) {
                return response()->json([
                    'success' => false,
                    'message' => 'خطا در دانلود فایل از ایزابل.'
                ], 404);
            }

            // 4️⃣ استریم فایل به مرورگر
            return new StreamedResponse(function () use ($response) {
                echo $response->body();
            }, 200, [
                'Content-Type' => 'audio/wav',
                'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'خطا در دانلود یا استریم فایل',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
