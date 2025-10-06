@extends('layouts.app')

@section('content')
    <div class="container mx-auto py-6">
        <div class="bg-white shadow rounded-lg p-6">
            <h1 class="text-2xl font-bold mb-4">{{ __('ارسال پیام جدید') }}</h1>

            <form action="{{ route('admin.notifications.store') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700">{{ __('عنوان پیام') }}</label>
                    <input type="text" name="title" value="{{ old('title') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                    @error('title')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">{{ __('متن پیام') }}</label>
                    <textarea name="message" rows="6" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>{{ old('message') }}</textarea>
                    @error('message')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('ارسال برای') }}</label>
                    <div class="space-y-2">
                        <label class="flex items-center space-x-2 space-x-reverse">
                            <input type="radio" name="recipient_type" value="user" {{ old('recipient_type') === 'user' ? 'checked' : '' }}>
                            <span>{{ __('یک کاربر خاص') }}</span>
                        </label>
                        <label class="flex items-center space-x-2 space-x-reverse">
                            <input type="radio" name="recipient_type" value="users" {{ old('recipient_type') === 'users' ? 'checked' : '' }}>
                            <span>{{ __('چند کاربر خاص') }}</span>
                        </label>
                        <label class="flex items-center space-x-2 space-x-reverse">
                            <input type="radio" name="recipient_type" value="roles" {{ old('recipient_type') === 'roles' ? 'checked' : '' }}>
                            <span>{{ __('یک یا چند نقش') }}</span>
                        </label>
                        <label class="flex items-center space-x-2 space-x-reverse">
                            <input type="radio" name="recipient_type" value="all" {{ old('recipient_type', 'all') === 'all' ? 'checked' : '' }}>
                            <span>{{ __('همه کاربران') }}</span>
                        </label>
                    </div>
                    @error('recipient_type')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div id="user-select" class="hidden">
                    <label class="block text-sm font-medium text-gray-700">{{ __('انتخاب کاربر') }}</label>
                    <select name="user_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">{{ __('انتخاب کنید') }}</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div id="users-select" class="hidden">
                    <label class="block text-sm font-medium text-gray-700">{{ __('انتخاب چند کاربر') }}</label>
                    <div class="max-h-56 overflow-y-auto border border-gray-200 rounded-md p-3 space-y-2">
                        @foreach($users as $user)
                            <label class="flex items-center space-x-2 space-x-reverse">
                                <input type="checkbox" name="user_ids[]" value="{{ $user->id }}" {{ in_array($user->id, old('user_ids', [])) ? 'checked' : '' }}>
                                <span>{{ $user->name }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div id="roles-select" class="hidden">
                    <label class="block text-sm font-medium text-gray-700">{{ __('انتخاب نقش‌ها') }}</label>
                    <div class="max-h-56 overflow-y-auto border border-gray-200 rounded-md p-3 space-y-2">
                        @forelse($roles as $role)
                            <label class="flex items-center space-x-2 space-x-reverse">
                                <input type="checkbox" name="role_ids[]" value="{{ $role->id }}" {{ in_array($role->id, old('role_ids', [])) ? 'checked' : '' }}>
                                <span>{{ $role->name }}</span>
                            </label>
                        @empty
                            <p class="text-sm text-gray-500">{{ __('هیچ نقشی یافت نشد.') }}</p>
                        @endforelse
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-md">{{ __('ارسال پیام') }}</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const typeInputs = document.querySelectorAll('input[name="recipient_type"]');
            const userSelect = document.getElementById('user-select');
            const usersSelect = document.getElementById('users-select');
            const rolesSelect = document.getElementById('roles-select');

            const toggle = () => {
                const value = document.querySelector('input[name="recipient_type"]:checked')?.value;
                userSelect.classList.toggle('hidden', value !== 'user');
                usersSelect.classList.toggle('hidden', value !== 'users');
                rolesSelect.classList.toggle('hidden', value !== 'roles');
            };

            typeInputs.forEach(input => input.addEventListener('change', toggle));
            toggle();
        });
    </script>
@endpush
