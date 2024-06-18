@extends('admin.layouts.admin')

@section('content')
<div class="p-4">
    <x-form-header :value="__('DTC Details')" class="p-4"/>

    <div class="grid md:grid-cols-2 md:gap-6">
        <!-- DTC CODE -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <p class="mt-1">{{ $dtc->dtc_code }}</p>
        </div>
    </div>
    <!-- Description -->
    <div class="mt-4">
        <x-input-label for="description_en" :value="__('Description EN')" />
        <p class="mt-1">{{ $dtc->description_en }}</p>
    </div>
    <div class="mt-4">
        <x-input-label for="description_kh" :value="__('Description KH')" />
        <p class="mt-1">{{ $dtc->description_kh }}</p>
    </div>

    <div class="mt-4">
        <x-outline-button href="{{ route('admin.dtcs.index') }}">
            Go back
        </x-outline-button>
    </div>
</div>
@endsection
