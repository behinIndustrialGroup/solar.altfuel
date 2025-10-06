@extends('behin-layouts.app')

@section('content')
    <div class="container mx-auto py-6">
        <div class="bg-white shadow rounded-lg p-6">
            <div class="flex items-start justify-between mb-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">{{ $notification->title }}</h1>
                    <p class="text-sm text-gray-500 mt-1">
                        {{ __('ارسال شده در :date', ['date' => optional($notification->created_at)->format('Y/m/d H:i')]) }}
                    </p>
                </div>
                @if(!$notification->is_read)
                    <form action="{{ route('notifications.mark', $notification) }}" method="POST">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md">{{ __('علامت به عنوان خوانده شده') }}</button>
                    </form>
                @endif
            </div>

            <div class="prose max-w-none leading-relaxed text-gray-700">
                {!! nl2br(e($notification->message)) !!}
            </div>

            <div class="mt-6">
                <a href="{{ route('notifications.index') }}" class="text-indigo-600 hover:text-indigo-800">{{ __('بازگشت به لیست پیام‌ها') }}</a>
            </div>
        </div>
    </div>
@endsection
