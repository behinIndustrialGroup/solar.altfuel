@extends('behin-layouts.app')

@section('content')
    <div class="container mx-auto py-6">
        <div class="flex items-center justify-between mb-4">
            <h1 class="text-2xl font-bold">{{ __('پیام‌ها') }}</h1>
            <x-user-notifications::unread-indicator :count="$unreadCount" />
        </div>

        <div class="bg-white shadow rounded-lg overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('عنوان') }}</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('تاریخ ارسال') }}</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('وضعیت') }}</th>
                        <th class="px-6 py-3"></th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($notifications as $notification)
                        <tr class="{{ $notification->is_read ? '' : 'bg-blue-50' }}">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $notification->title }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ optional($notification->created_at)->format('Y/m/d H:i') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                @if($notification->is_read)
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">{{ __('خوانده شده') }}</span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">{{ __('خوانده نشده') }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-left text-sm font-medium">
                                <a href="{{ route('notifications.show', $notification) }}" class="text-indigo-600 hover:text-indigo-900">{{ __('مشاهده') }}</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-gray-500">{{ __('پیامی برای نمایش وجود ندارد.') }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $notifications->links() }}
        </div>
    </div>
@endsection
