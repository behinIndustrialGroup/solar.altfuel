<?php

namespace InspectorCatalog\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use InspectorCatalog\Models\Inspector;
use App\Models\User;

class InspectorCatalogController
{
    public function index(): View
    {
        $inspectors = Inspector::query()
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('inspector-catalog::inspectors.index', compact('inspectors'));
    }

    public function create(): View
    {
        $provinces = Inspector::getProvinces();

        // کاربرانی که هنوز پروفایل بازرس ندارند
        $users = User::query()
            ->whereNotIn('id', Inspector::query()->pluck('user_id'))
            ->orderBy('name')
            ->get();

        return view('inspector-catalog::inspectors.create', compact('provinces', 'users'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'user_id'         => ['required', 'exists:users,id', 'unique:inspectors,user_id'],
            'inspector_code'  => ['required', 'string', 'max:50', 'unique:inspectors,inspector_code'],
            'first_name'      => ['required', 'string', 'max:100'],
            'last_name'       => ['required', 'string', 'max:100'],
            'national_id'     => ['required', 'string', 'size:10', 'unique:inspectors,national_id'],
            'mobile'          => ['required', 'string', 'size:11'],
            'phone'           => ['nullable', 'string', 'max:11'],
            'province'        => ['required', 'string', 'max:100'],
            'city'            => ['required', 'string', 'max:100'],
            'address'         => ['required', 'string'],
            'is_certificated' => ['nullable', 'boolean'],
        ], [
            'user_id.required'        => 'انتخاب کاربر الزامی است.',
            'user_id.exists'          => 'کاربر انتخاب شده وجود ندارد.',
            'user_id.unique'          => 'این کاربر قبلاً به عنوان بازرس ثبت شده است.',
            'inspector_code.required' => 'کد بازرس الزامی است.',
            'inspector_code.unique'   => 'این کد بازرس قبلاً ثبت شده است.',
            'first_name.required'     => 'نام الزامی است.',
            'last_name.required'      => 'نام خانوادگی الزامی است.',
            'national_id.required'    => 'کد ملی الزامی است.',
            'national_id.size'        => 'کد ملی باید ۱۰ رقم باشد.',
            'national_id.unique'      => 'این کد ملی قبلاً ثبت شده است.',
            'mobile.required'         => 'شماره همراه الزامی است.',
            'mobile.size'             => 'شماره همراه باید ۱۱ رقم باشد.',
            'province.required'       => 'استان الزامی است.',
            'city.required'           => 'شهر الزامی است.',
            'address.required'        => 'آدرس الزامی است.',
        ]);

        DB::transaction(function () use ($validated, $request) {
            // تنظیم نقش بازرس روی کاربر انتخاب شده
            $inspectorRole = DB::table('behin_roles')->where('name', 'بازرس')->first();
            if ($inspectorRole) {
                User::query()->where('id', $validated['user_id'])->update([
                    'role_id' => $inspectorRole->id,
                ]);
            }

            Inspector::query()->create([
                'user_id'         => $validated['user_id'],
                'inspector_code'  => $validated['inspector_code'],
                'first_name'      => $validated['first_name'],
                'last_name'       => $validated['last_name'],
                'national_id'     => $validated['national_id'],
                'mobile'          => $validated['mobile'],
                'phone'           => $validated['phone'] ?? null,
                'province'        => $validated['province'],
                'city'            => $validated['city'],
                'address'         => $validated['address'],
                'is_certificated' => (bool) ($validated['is_certificated'] ?? false),
            ]);
        });

        return redirect()
            ->route('inspector-catalog.index')
            ->with('success', 'اطلاعات بازرس با موفقیت ثبت شد.');
    }

    public function show(Inspector $inspector): View
    {
        $inspector->load('user');

        return view('inspector-catalog::inspectors.show', compact('inspector'));
    }

    public function edit(Inspector $inspector): View
    {
        $inspector->load('user');
        $provinces = Inspector::getProvinces();

        // کاربرانی که بازرس نیستند + کاربر فعلی این بازرس
        $users = User::query()
            ->where(function ($q) use ($inspector) {
                $q->whereNotIn('id', Inspector::query()->pluck('user_id'))
                  ->orWhere('id', $inspector->user_id);
            })
            ->orderBy('name')
            ->get();

        return view('inspector-catalog::inspectors.edit', compact('inspector', 'provinces', 'users'));
    }

    public function update(Request $request, Inspector $inspector): RedirectResponse
    {
        $validated = $request->validate([
            'user_id'         => ['required', 'exists:users,id', 'unique:inspectors,user_id,' . $inspector->id],
            'inspector_code'  => ['required', 'string', 'max:50', 'unique:inspectors,inspector_code,' . $inspector->id],
            'first_name'      => ['required', 'string', 'max:100'],
            'last_name'       => ['required', 'string', 'max:100'],
            'national_id'     => ['required', 'string', 'size:10', 'unique:inspectors,national_id,' . $inspector->id],
            'mobile'          => ['required', 'string', 'size:11'],
            'phone'           => ['nullable', 'string', 'max:11'],
            'province'        => ['required', 'string', 'max:100'],
            'city'            => ['required', 'string', 'max:100'],
            'address'         => ['required', 'string'],
            'is_certificated' => ['nullable', 'boolean'],
        ], [
            'user_id.required'       => 'انتخاب کاربر الزامی است.',
            'user_id.exists'         => 'کاربر انتخاب شده وجود ندارد.',
            'user_id.unique'         => 'این کاربر قبلاً به عنوان بازرس ثبت شده است.',
            'inspector_code.unique'  => 'این کد بازرس قبلاً ثبت شده است.',
            'national_id.size'       => 'کد ملی باید ۱۰ رقم باشد.',
            'national_id.unique'     => 'این کد ملی قبلاً ثبت شده است.',
            'mobile.size'            => 'شماره همراه باید ۱۱ رقم باشد.',
        ]);

        DB::transaction(function () use ($validated, $inspector) {
            // اگر کاربر عوض شد، نقش بازرس را از کاربر قبلی برنمی‌داریم
            // (ممکن است نقش دیگری داشته باشد) — فقط نقش کاربر جدید را تنظیم می‌کنیم
            if ((string) $validated['user_id'] !== (string) $inspector->user_id) {
                $inspectorRole = DB::table('behin_roles')->where('name', 'بازرس')->first();
                if ($inspectorRole) {
                    User::query()->where('id', $validated['user_id'])->update([
                        'role_id' => $inspectorRole->id,
                    ]);
                }
            }

            $inspector->update([
                'user_id'         => $validated['user_id'],
                'inspector_code'  => $validated['inspector_code'],
                'first_name'      => $validated['first_name'],
                'last_name'       => $validated['last_name'],
                'national_id'     => $validated['national_id'],
                'mobile'          => $validated['mobile'],
                'phone'           => $validated['phone'] ?? null,
                'province'        => $validated['province'],
                'city'            => $validated['city'],
                'address'         => $validated['address'],
                'is_certificated' => (bool) ($validated['is_certificated'] ?? false),
            ]);
        });

        return redirect()
            ->route('inspector-catalog.index')
            ->with('success', 'اطلاعات بازرس با موفقیت ویرایش شد.');
    }

    public function destroy(Inspector $inspector): RedirectResponse
    {
        // فقط پروفایل بازرس حذف می‌شود، حساب کاربری دست‌نخورده می‌ماند
        $inspector->delete();

        return redirect()
            ->route('inspector-catalog.index')
            ->with('success', 'پروفایل بازرس با موفقیت حذف شد.');
    }

    public function lastRecord(): JsonResponse
    {
        $inspector = Inspector::query()->latest()->first();

        return response()->json($inspector);
    }
}
