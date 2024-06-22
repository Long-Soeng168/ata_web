@extends('admin.layouts.admin')

@section('content')
    <div class="p-4">
        <x-form-header :value="__('Garage Details')" class="p-4" />

        <div class="grid md:grid-cols-2 md:gap-6">
            <!-- Name -->
            <div>
                <x-input-label for="name" :value="__('Name')" />
                <p class="mt-1">{{ $garage->name }}</p>
            </div>
            <div>
                <x-input-label for="name" :value="__('Location')" />
                <p class="mt-1">{{ $garage->location }}</p>
            </div>
            <div class="mt-4">
                <x-input-label for="image" :value="__('Logo')" />
                @if ($garage->logo)
                    <div class="mt-1">
                        <img src="{{ asset('assets/images/garages/logo/' . $garage->logo) }}" alt="{{ $garage->logo }}"
                            class="max-w-full max-h-40" />
                    </div>
                @else
                    <p class="mt-1">No image available</p>
                @endif
            </div>
            <div class="mt-4">
                <x-input-label for="image" :value="__('Banner')" />
                @if ($garage->banner)
                    <div class="mt-1">
                        <img src="{{ asset('assets/images/garages/banner/' . $garage->banner) }}"
                            alt="{{ $garage->banner }}" class="max-w-full max-h-40" />
                    </div>
                @else
                    <p class="mt-1">No image available</p>
                @endif
            </div>
        </div>

        <div class="grid md:grid-cols-3 md:gap-6 mt-4">
            <!-- Code and like -->
            <div>
                <x-input-label for="code" :value="__('Create By')" />
                <p class="mt-1">{{ $garage->user->name }}</p>
            </div>

        </div>

        <div class="grid md:grid-cols-2 md:gap-6 mt-4">
            <div>
                <x-input-label for="like" :value="__('Like')" />
                <p class="mt-1">{{ $garage->like }}</p>
            </div>
            <div>
                <x-input-label for="unlike" :value="__('Unlike ')" />
                <p class="mt-1">{{ $garage->unlike }}</p>
            </div>
            <div>
                <x-input-label for="comment" :value="__('Comment ')" />
                <p class="mt-1">{{ $garage->comment }}</p>
            </div>
            <div>
                <x-input-label for="rate" :value="__('Rate ')" />
                <p class="mt-1">{{ $garage->rate }}</p>
            </div>
        </div>

        <!-- bio -->
        <div class="mt-4">
            <x-input-label for="bio" :value="__('bio')" />
            <p class="mt-1">{{ $garage->bio }}</p>
        </div>

        <div class="mt-4">
            <x-outline-button href="{{ route('admin.garages.index') }}">
                Go back
            </x-outline-button>
        </div>
    </div>
@endsection
