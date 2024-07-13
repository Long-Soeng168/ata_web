@extends('admin.layouts.admin')
@section('content')
    <div>
        @include('admin.components.success')
        <x-page-header :value="__('PDF')" />

        <div
            class="flex flex-col px-4 py-3 space-y-3 lg:flex-row lg:items-center lg:justify-between lg:space-y-0 lg:space-x-4">
            <div class="w-full md:w-1/2">
                <form class="flex items-center gap-4" action="{{ route('admin.pdfs.index') }}" method="GET" >
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

                <x-primary-button href="{{ route('admin.pdfs.create') }}">
                    <svg class="h-3.5 w-3.5 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"
                        aria-hidden="true">
                        <path clip-rule="evenodd" fill-rule="evenodd"
                            d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
                    </svg>
                    Add
                </x-primary-button>


            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <tr>


                    <th scope="col" class="px-4 py-3 uppercase">No</th>
                    <th scope="col" class="px-4 py-3 uppercase">Title</th>
                    <th scope="col" class="py-3 text-center">Action</th>
                </tr>
                </thead>
                <tbody>
                    @forelse ($pdfs as $pdf)
                        <tr class="border-b dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700">
                            <td class="w-4 px-4 py-3">
                                {{ $loop->iteration }}
                            </td>
                            <x-table-data value="{{ $pdf->title }}" />
                            <td class="px-6 py-4">

                                <div class="flex items-start justify-center gap-3">
                                    <a target="_blank" href="{{ route('admin.pdfs.stream', $pdf->id) }}" data-tooltip-target="tooltip-view-detail-{{ $pdf->id }}" >
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-eye">
                                            <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z" />
                                            <circle cx="12" cy="12" r="3" />
                                        </svg>
                                    </a>
                                    <x-delete-confirm-button identifier="{{ $pdf->id }}"
                                        deleteUrl="{{ route('admin.pdfs.destroy', $pdf->id) }}"
                                        message="Are you sure you want to delete this Item" tooltipText="Delete item" />
                                    <x-edit-button identifier="{{ $pdf->id }}"
                                        editUrl="{{ route('admin.pdfs.edit', $pdf->id) }}"
                                        tooltipText="Edit item" />
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="px-4 py-4">No video</td>
                        </tr>
                    @endforelse


                </tbody>
            </table>

            <div class="p-4">
                {{-- {{ $pdfs->links() }} --}}
                {{-- {{ $pdfs->appends(['sort_by' => $sortColumn, 'sort_direction' => $sortDirection])->links() }} --}}
            </div>
        </div>
    </div>
@endsection
