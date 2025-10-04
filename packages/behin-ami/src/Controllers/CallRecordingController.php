<?php

namespace Behin\Ami\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CallRecordingController
{
    public function download(Request $request)
    {
        $token = $request->query('token');
        if (!$token) {
            abort(404);
        }

        $decoded = json_decode(base64_decode($token, true) ?: '', true);
        if (!is_array($decoded)) {
            abort(404);
        }

        $disk = $decoded['disk'] ?? null;
        $path = $decoded['path'] ?? null;

        if (!$path) {
            abort(404);
        }

        $fileName = $request->query('name') ?: basename($path);

        if ($disk) {
            $allowedDisk = config('behin-ami.recordings.disk');
            if (!$allowedDisk || $disk !== $allowedDisk) {
                abort(404);
            }

            if (!Storage::disk($disk)->exists($path)) {
                abort(404);
            }

            return Storage::disk($disk)->download($path, $fileName);
        }

        $basePath = config('behin-ami.recordings.base_path');
        if (!$basePath) {
            abort(404);
        }

        $baseReal = realpath($basePath);
        $fileReal = realpath($path);

        if (!$baseReal || !$fileReal || !str_starts_with($fileReal, $baseReal) || !is_file($fileReal)) {
            abort(404);
        }

        return response()->download($fileReal, $fileName);
    }
}
