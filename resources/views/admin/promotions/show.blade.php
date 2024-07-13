@extends('admin.layouts.admin')

@section('content')
<div class="p-4">
    <section class="antialiased bg-white dark:bg-gray-900">
        <div class="p-4 sm:gap-4 sm:items-center sm:flex ">
            <a
              href="{{ url()->previous() }}"
              title=""
              class="flex items-center justify-center py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700"
              role="button"
            >
              Back
            </a>

          </div>
        <div class="max-w-screen-xl px-4 mx-auto 2xl:px-0">
          <div class="lg:grid lg:grid-cols-2 lg:gap-8 xl:gap-16">
            <div class="max-w-md mx-auto shrink-0 lg:max-w-lg">
              <img class="object-cover w-full aspect-[1/1]" src="{{ asset('assets/images/promotions/' . $promotion->image) }}" alt="" />
            </div>

            <div class="mt-6 sm:mt-8 lg:mt-0">
              <h1
                class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white"
              >
                {{ $promotion->title }}
              </h1>
              <div class="mt-4 sm:items-center sm:gap-4 sm:flex">
              </div>



              <hr class="my-6 border-gray-200 md:my-8 dark:border-gray-800" />

              <p class="mb-6 text-gray-500 dark:text-gray-400">
                {!! $promotion->description !!}
              </p>
            </div>
          </div>
        </div>
      </section>
</div>
@endsection
