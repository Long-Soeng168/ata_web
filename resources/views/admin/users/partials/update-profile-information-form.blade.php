<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form method="post" action="{{ url('admin/users/'.$user->id) }}" class="mt-6 space-y-6">
        @csrf
        @method('PUT')

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="block w-full mt-1" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="block w-full mt-1" :value="old('email', $user->email)" required autocomplete="username" />
                <x-input-error class="mt-2" :messages="$errors->get('email')" />
                </div>

        <div>
            <x-input-label :value="__('User Roles')" />
            <div class="grid grid-cols-3 gap-2">
                @foreach ($roles as $role)
                <div class="flex items-center">
                    <input
                        type="checkbox"
                        id="permission_{{ $role->id }}"
                        name="roles[]"
                        value="{{ $role->name }}"
                        class="mr-2"
                        {{ in_array($role->id, $userRoles) ? 'checked' : '' }}
                    >
                    <label for="permission_{{ $role->id }}">{{ $role->name }}</label>
                </div>
                @endforeach
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('roles')" />
        </div>

        <div class="flex items-center gap-4">
            <button class = 'flex items-center justify-center px-4 py-2 text-sm font-medium text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800'>
                Save
            </button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
