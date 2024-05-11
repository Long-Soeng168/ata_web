@extends('admin.layouts.admin')

@section('content')

    <div class="p-4">
        <x-form-header :value="__('Update User')" />
        <div class="flex flex-col lg:flex-row px-7 lg:px-0 gap-4">
            <div class="flex-1 p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div>
                    @include('admin.users.partials.update-profile-information-form')
                </div>
            </div>

            <div class="flex-1 p-4 sm:p-8 bg-white shadow sm:rounded-lg mt-4 sm:mt-0">
                <div>
                    @include('admin.users.partials.update-password-form')
                </div>
            </div>
        </div>


    </div>

@endsection

