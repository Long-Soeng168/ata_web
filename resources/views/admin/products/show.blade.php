@extends('admin.layouts.admin')

@section('content')
    <div class="p-4">
        <div class ='flex items-center justify-between pb-4 pl-0 mb-4 border-b rounded-t sm:mb-5 dark:border-gray-600'>
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                {{ __('Product Details') }}
            </h3>
            <x-outline-button href="{{ url()->previous() }}">
                Go back
            </x-outline-button>
        </div>


        <div class="max-w-screen-xl px-2 mx-auto mt-6 lg:px-0">
            <div class="min-[840px]:flex">
                <div class="flex flex-col items-center px-2 mb-6 mr-2 lg-px-0">
                    <div class="max-w-[400px] flex flex-col gap-2">
                        <a href="{{ asset('assets/images/products/' . $product->image) }}" class="glightbox">
                            <img class="max-w-[400px] aspect-[1/1] object-cover rounded-md cursor-pointer"
                                src="{{ asset('assets/images/products/' . $product->image) }}" alt="Book Cover">
                        </a>
                        <div class="grid grid-cols-4 gap-2">
                            @foreach ($multi_images as $index => $image)
                                @if ($index < 3 || count($multi_images) == 4)
                                    <a href="{{ asset('assets/images/products/' . $image->image) }}" class="glightbox">
                                        <img class="w-full aspect-[1/1] hover:scale-110 transition-transform duration-500 ease-in-out object-cover rounded-md border shadow-md"
                                            src="{{ asset('assets/images/products/' . $image->image) }}">
                                    </a>
                                @elseif ($index == 3)
                                    <a href="{{ asset('assets/images/products/' . $image->image) }}"
                                    class="glightbox relative w-full aspect-[1/1] hover:scale-110 transition-transform duration-500 ease-in-out ">
                                        <div class="absolute flex items-center justify-center w-full h-full transition-all duration-300 border rounded-md shadow-md bg-gray-900/60 hover:bg-gray-900/20">
                                            <span class="text-xl font-medium text-white">
                                                +{{ count($multi_images) - 4 }}
                                            </span>
                                        </div>
                                        <img src="{{ asset('assets/images/products/' . $image->image) }}"
                                            class="rounded-lg w-full aspect-[1/1]">
                                    </a>
                                @else
                                    <a href="{{ asset('assets/images/products/' . $image->image) }}" class="glightbox">
                                        <img class="hidden w-full aspect-[1/1] hover:scale-110 transition-transform duration-500 ease-in-out object-cover rounded-md border shadow-md"
                                            src="{{ asset('assets/images/products/' . $image->image) }}">
                                    </a>
                                @endif
                            @endforeach







                        </div>
                    </div>
                </div>
                <div>
                    <div class="text-sm font-semibold tracking-wide text-blue-600 uppercase">
                        Product
                    </div>
                    <h1 class="block mt-1 mb-2 text-2xl font-medium leading-tight text-gray-800 dark:text-gray-100">
                        {{ $product->name }}
                    </h1>
                    <div class="flex flex-col gap-2">
                        <div class="flex nowrap">
                            <p
                                class="w-[123px] uppercase tracking-wide text-sm text-gray-500 dark:text-gray-300 font-semibold border-r border-gray-600 dark:border-gray-300 pr-5 mr-5">
                                {{ __('Code') }}
                            </p>
                            <p class="text-sm text-gray-600 dark:text-gray-200">
                                {{ $product->code }}
                            </p>
                        </div>
                        <div class="flex nowrap">
                            <p
                                class="w-[123px] uppercase tracking-wide text-sm text-gray-500 dark:text-gray-300 font-semibold border-r border-gray-600 dark:border-gray-300 pr-5 mr-5">
                                {{ __('Price') }}
                            </p>
                            <p class="text-sm text-gray-600 dark:text-gray-200">
                                {{ $product->price }}
                            </p>
                        </div>
                        <div class="flex nowrap">
                            <p
                                class="w-[123px] uppercase tracking-wide text-sm text-gray-500 dark:text-gray-300 font-semibold border-r border-gray-600 dark:border-gray-300 pr-5 mr-5">
                                {{ __('Discount % ') }}
                            </p>
                            <p class="text-sm text-gray-600 dark:text-gray-200">
                                {{ $product->discount_percent }}
                            </p>
                        </div>
                        <div class="flex nowrap">
                            <p
                                class="w-[123px] uppercase tracking-wide text-sm text-gray-500 dark:text-gray-300 font-semibold border-r border-gray-600 dark:border-gray-300 pr-5 mr-5">
                                {{ __('Brand') }}
                            </p>
                            <p class="text-sm text-gray-600 dark:text-gray-200">
                                {{ $product->brand?->name }}
                            </p>
                        </div>
                        <div class="flex nowrap">
                            <p
                                class="w-[123px] uppercase tracking-wide text-sm text-gray-500 dark:text-gray-300 font-semibold border-r border-gray-600 dark:border-gray-300 pr-5 mr-5">
                                {{ __('Model') }}
                            </p>
                            <p class="text-sm text-gray-600 dark:text-gray-200">
                                {{ $product->brand_model?->name }}
                            </p>
                        </div>
                        <div class="flex nowrap">
                            <p
                                class="w-[123px] uppercase tracking-wide text-sm text-gray-500 dark:text-gray-300 font-semibold border-r border-gray-600 dark:border-gray-300 pr-5 mr-5">
                                {{ __('Category') }}
                            </p>
                            <p class="text-sm text-gray-600 dark:text-gray-200">
                                {{ $product->categories?->name }}
                            </p>
                        </div>
                        <div class="flex nowrap">
                            <p
                                class="w-[123px] uppercase tracking-wide text-sm text-gray-500 dark:text-gray-300 font-semibold border-r border-gray-600 dark:border-gray-300 pr-5 mr-5">
                                {{ __('Body Type') }}
                            </p>
                            <p class="text-sm text-gray-600 dark:text-gray-200">
                                {{ $product->body_type?->name }}
                            </p>
                        </div>
                        <div class="flex nowrap">
                            <p
                                class="w-[123px] uppercase tracking-wide text-sm text-gray-500 dark:text-gray-300 font-semibold border-r border-gray-600 dark:border-gray-300 pr-5 mr-5">
                                Location
                            </p>
                            <p class="text-sm text-gray-600 dark:text-gray-200">
                                London, England
                            </p>
                        </div>
                    </div>

                    <div class="mt-8">
                        {!! $product->description !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
