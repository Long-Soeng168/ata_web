@extends('admin.layouts.admin')
@section('content')
    <div>
        @include('admin.components.success')
        <x-page-header :value="__('Garage Posts')" />
        <div
            class="flex flex-col px-4 py-3 space-y-3 lg:flex-row lg:items-center lg:justify-between lg:space-y-0 lg:space-x-4">
            <div class="w-full md:w-1/2">
                <form action="{{ url('admin/garageposts') }}" class="flex items-center gap-4" method="GET">
                    @csrf
                    <div class="relative w-full">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor"
                                viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <input value="{{ request()->get('search') }}" name="search" type="text" id="simple-search"
                            class="block w-full p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            placeholder="Search...">
                    </div>

                </form>
            </div>
            <div
                class="flex flex-col items-stretch justify-end flex-shrink-0 w-full space-y-2 md:w-auto md:flex-row md:space-y-0 md:items-center md:space-x-3">

                <x-primary-button href="{{ route('admin.garageposts.create') }}">
                    <svg class="h-3.5 w-3.5 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"
                        aria-hidden="true">
                        <path clip-rule="evenodd" fill-rule="evenodd"
                            d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
                    </svg>
                    Add
                </x-primary-button>

                {{-- <div class="flex items-center w-full space-x-3 md:w-auto">
                <button id="filterDropdownButton" class="flex items-center justify-center w-full px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg md:w-auto focus:outline-none hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700" type="button">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-file-up">
                        <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z" />
                        <path d="M14 2v4a2 2 0 0 0 2 2h4" />
                        <path d="M12 12v6" />
                        <path d="m15 15-3-3-3 3" />
                    </svg>
                    Export
                </button>

            </div> --}}
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-4 py-3">No</th>
                        <th scope="col" class="px-4 py-3">Image</th>
                        <th scope="col" class="px-4 py-3">Name</th>
                        <th scope="col" class="px-4 py-3">Garage</th>
                        <th scope="col" class="px-4 py-3">Created By</th>
                        <th scope="col" class="px-4 py-3">Descriptions</th>

                        <th scope="col" class="py-3 text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($garageposts as $garagepost)
                        <tr class="border-b dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700">
                            <td class="w-4 px-4 py-3">
                                {{ $loop->iteration }}
                            </td>
                            <th scope="row"
                                class="flex items-center px-4 py-2 font-medium text-gray-900 dark:text-white">
                                <img src="{{ asset('assets/images/garageposts/thumb/' . $garagepost->image) }}"
                                    alt="iMac Front Image" class="object-contain h-10 mr-3 shadow aspect-video">
                            </th>
                            <x-table-data value="{{ $garagepost->name }}" />
                            <x-table-data value="{{ $garagepost->garages?->name }}" />
                            <x-table-data value="{{ $garagepost->user?->name }}" />
                            <td class = 'px-4 py-2 font-medium text-gray-900 tex-sm dark:text-white '>
                                {{ $garagepost->description }}
                            </td>


                            <td class="px-6 py-4">
                                <div class="flex items-start justify-center gap-3">
                                    <x-view-detail-button identifier="{{ $garagepost->id }}"
                                        viewDetailUrl="{{ route('admin.garageposts.show', $garagepost->id) }}"
                                        tooltipText=" View item details" />
                                    <x-delete-confirm-button identifier="{{ $garagepost->id }}"
                                        deleteUrl="{{ route('admin.garageposts.destroy', $garagepost->id) }}"
                                        message="Are you sure you want to delete this Item" tooltipText="Delete item" />
                                    <x-edit-button identifier="{{ $garagepost->id }}"
                                        editUrl="{{ route('admin.garageposts.edit', $garagepost->id) }}"
                                        tooltipText="Edit item" />
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="px-4 py-4">No Data...</td>
                        </tr>
                    @endforelse


                </tbody>
            </table>

            <div class="p-4">
                {{ $garageposts->links() }}
            </div>
        </div>
    </div>
@endsection
