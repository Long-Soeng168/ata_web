@extends('layouts.default')

@section('content')
<div class="bg-white">
    @if (session('status'))
    <div class="bg-blue-100 border border-blue-500 text-blue-700 px-4 py-3 relative" role="alert">
        <p>{{ session('status') }}</p>
    </div>

    @endif
    <div class="p-4 border-b border-gray-200">
        <h4 class="text-lg font-semibold">
            Role : {{ $role->name }}
            <a href="{{ url('roles') }}" class="bg-red-500 text-white px-4 rounded-md float-right">
                Back
            </a>
        </h4>
    </div>
    <div class="p-4">
        <form action='{{ url("roles/$role->id/give-permissions") }}' method="POST" class="max-w-3xl mx-auto">
            @csrf
            @method('PUT')

            <div class="mb-6">
                <div class="flex gap-10">
                    <label for="permissions" class="block mb-2 text-lg font-bold">Permissions</label>
                    <div class="flex items-center gap-2">
                        <input type="checkbox" id="toggle_all_permissions">
                        <label for="toggle_all_permissions">Give All Permissions</label>
                    </div>
                </div>

                <div class="grid grid-cols-4 gap-4" id="permissionsContainer">
                    @foreach ($permissions as $permission)
                    <div class="flex items-center">
                        <input
                            type="checkbox"
                            id="permission_{{ $permission->id }}"
                            name="permissions[]"
                            value="{{ $permission->name }}"
                            class="mr-2 permission-checkbox"
                            {{ in_array($permission->id, $rolePermissions) ? "checked" : '' }}
                        >
                        <label for="permission_{{ $permission->id }}">{{ $permission->name }}</label>
                    </div>
                    @endforeach
                </div>

                <x-input-error :messages="$errors->get('permissions')" class="mt-2" />

                <script>
                    document.addEventListener("DOMContentLoaded", function () {
                        var toggleAllCheckbox = document.getElementById('toggle_all_permissions');
                        var permissionCheckboxes = document.querySelectorAll('.permission-checkbox');

                        toggleAllCheckbox.addEventListener('change', function () {
                            permissionCheckboxes.forEach(function (checkbox) {
                                checkbox.checked = toggleAllCheckbox.checked;
                            });
                        });

                        permissionCheckboxes.forEach(function (checkbox) {
                            checkbox.addEventListener('change', function () {
                                var allChecked = true;
                                permissionCheckboxes.forEach(function (checkbox) {
                                    if (!checkbox.checked) {
                                        allChecked = false;
                                    }
                                });
                                toggleAllCheckbox.checked = allChecked;
                            });
                        });
                    });
                </script>

            </div>

            <div class="mb-6">
                <button type="submit" class="w-full px-4 py-2 text-white bg-blue-500 rounded-md hover:bg-blue-600 focus:outline-none focus:bg-blue-600">
                    Save
                </button>
            </div>
        </form>


    </div>
</div>
@endsection
