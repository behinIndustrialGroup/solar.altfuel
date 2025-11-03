<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInstallerApplicationRequest;
use App\Models\InstallerApplication;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class InstallerRegistrationController extends Controller
{
    public function create(): View
    {
        return view('installer.apply');
    }

    public function store(StoreInstallerApplicationRequest $request): RedirectResponse
    {
        InstallerApplication::create($request->validated());

        return redirect()
            ->route('installers.apply')
            ->with('status', 'درخواست شما با موفقیت ثبت شد. همکاران ما به زودی با شما تماس می‌گیرند.');
    }
}
