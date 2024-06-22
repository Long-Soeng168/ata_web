@extends('admin.layouts.admin')
@section('content')

<div>
    <x-page-header :value="__('DTC')"/>

    <div class="flex flex-col px-4 py-3 space-y-3 lg:flex-row lg:items-center lg:justify-between lg:space-y-0 lg:space-x-4">
        <div class="w-full md:w-1/2">
            <form class="flex items-center gap-4">
                <div class="relative w-full">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <input type="text" id="simple-search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Search...">
                </div>

            </form>
        </div>
        <div class="w-full md:w-auto flex flex-col md:flex-row space-y-2 md:space-y-0 items-stretch md:items-center justify-end md:space-x-3 flex-shrink-0">

            <x-primary-button href="{{ route('admin.dtcs.create') }}">
                <svg class="h-3.5 w-3.5 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path clip-rule="evenodd" fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
                </svg>
                Add
            </x-primary-button>


        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-4 py-3">No</th>
                    <th scope="col" class="px-4 py-3">DTC Code</th>
                    <th scope="col" class="px-4 py-3">Description EN</th>
                    <th scope="col" class="px-4 py-3">Description KH</th>
                    <th scope="col" class="text-center py-3">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($dtcs as $dtc)
                    <tr class="border-b dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700">
                        <td class="w-4 px-4 py-3">
                            {{ $loop->iteration }}
                        </td>
                        <x-table-data value="{{ $dtc->dtc_code }}"/>
                        <x-table-data value="{{ $dtc->description_en }}"/>
                        <x-table-data value="{{ $dtc->description_kh }}"/>

                        <td class="px-6 py-4">
                            <div class="flex items-start gap-3 justify-center">

                                <x-view-detail-button
                                identifier="{{ $dtc->id }}"
                                viewDetailUrl="{{ route('admin.dtcs.show', $dtc->id) }}"
                                tooltipText=" View item details"
                                />
                                <x-delete-confirm-button
                                identifier="{{ $dtc->id }}"
                                deleteUrl="{{ route('admin.dtcs.destroy', $dtc->id) }}"
                                message="Are you sure you want to delete this Item"
                                tooltipText="Delete item"
                                />
                                <x-edit-button
                                identifier="{{ $dtc->id }}"
                                editUrl="{{ route('admin.dtcs.edit', $dtc->id) }}"
                                tooltipText="Edit item"
                                />
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr >
                        <td class="px-4 py-4">No Type or Brand</td>
                    </tr>
                @endforelse


            </tbody>
        </table>

        <div class="p-4">
            {{ $dtcs->links() }}
        </div>
    </div>
</div>

@endsection
