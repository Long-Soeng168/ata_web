@extends('admin.layouts.admin')
@section('content')
    <div class="px-4">
        <div class="flex items-center justify-between mt-2 border-b rounded-t sm:mb-5 dark:border-gray-600">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                {{ __('Documents') }}
            </h3>
            {{-- <x-outline-button href="{{ url()->previous() }}">
                Go back
            </x-outline-button> --}}
        </div>

        <!-- Breadcrumb -->
        @php
            $path = request()->path();
            $segments = $path !== 'get_resources' ? explode('/', str_replace('get_resources/', '', $path)) : [];
            $breadcrumbs = [];
            $url = url('get_resources');

            $breadcrumbs[] = [
                'title' => 'Documents',
                'url' => $url
            ];

            foreach ($segments as $segment) {
                $url .= '/' . $segment;
                $breadcrumbs[] = [
                    'title' => ucfirst($segment),
                    'url' => $url
                ];
            }
        @endphp

        <nav class="flex px-5 py-3 text-gray-700 border border-gray-200 rounded-lg bg-gray-50 dark:bg-gray-800 dark:border-gray-700" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                @foreach ($breadcrumbs as $index => $breadcrumb)
                    @if ($index == 0)
                        @continue
                    @endif

                    <li class="inline-flex items-center">
                        @if (!$loop->last)
                            <a href="{{ $breadcrumb['url'] }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                                {{ $breadcrumb['title'] }}
                            </a>
                        @else
                            <span class="text-sm font-medium text-gray-500 ms-1 md:ms-2 dark:text-gray-400">{{ $breadcrumb['title'] }}</span>
                        @endif
                    </li>
                    @if (!$loop->last)
                        <li>
                            <div class="flex items-center">
                                <svg class="block w-3 h-3 mx-1 text-gray-400 rtl:rotate-180 " aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="m1 9 4-4-4-4" />
                                </svg>
                            </div>
                        </li>
                    @endif
                @endforeach
            </ol>
        </nav>

        <div class="w-full p-6 mx-auto bg-white rounded-lg shadow-md">
            <ul>
                @foreach ($folders as $folder)
                    <li class="mb-2">
                        <a href="{{ url()->current() . '/' . $folder }}"
                            class="flex items-center text-blue-500 hover:underline">
                            <img class="w-6 h-6 mr-2" src="{{ asset('assets/icons/folder.png') }}" alt="">
                            {{ $folder }}
                        </a>
                    </li>
                @endforeach
            </ul>
            <ul class="mb-6">
                @php
                    $currentUrl = url()->current(); // Get the current URL
                    $removedGetUrl = str_replace('/get_resources/', '/', $currentUrl); // Remove /get/ from the URL
                @endphp
                @foreach ($files as $file)
                    <li class="mb-2">
                        <button onclick="openPdfPopup('{{ $removedGetUrl . '/' . $file }}')"
                            class="flex items-center text-blue-500 hover:underline">
                            <img class="w-6 h-6 mr-2" src="{{ asset('assets/icons/file.png') }}" alt="">
                            {{ $file }}
                        </button>
                    </li>
                @endforeach

                <!-- Popup Container -->
                <div class="popup-overlay" id="popupOverlay">
                    <div class="popup-content-container">
                        <div class="popup-content">
                            <span class="close-btn" onclick="closePdfPopup()">
                                <img src="{{ asset('assets/icons/cancel.png') }}" alt="" class="close-btn-image" />
                            </span>
                            <embed id="pdfEmbed" src="" width="100%" height="100%" />
                        </div>
                    </div>
                </div>

                {{-- Script PDF Popup View --}}
                <script>
                    function openPdfPopup(pdfUrl) {
                        var popupOverlay = document.getElementById("popupOverlay");
                        var pdfEmbed = document.getElementById("pdfEmbed");
                        pdfEmbed.src = pdfUrl; // Set PDF source
                        popupOverlay.style.display = "block";
                        // Add event listener to close popup when clicking outside of content
                        popupOverlay.addEventListener("click", closeIfOutside);
                    }

                    function closePdfPopup() {
                        var popupOverlay = document.getElementById("popupOverlay");
                        popupOverlay.style.display = "none";
                        // Remove event listener when popup is closed
                        popupOverlay.removeEventListener("click", closeIfOutside);
                    }

                    function closeIfOutside(event) {
                        var popupContent = document.querySelector(".popup-content");
                        // Check if click target is not inside popup content
                        if (!popupContent.contains(event.target)) {
                            closePdfPopup();
                        }
                    }
                </script>

            </ul>
        </div>
    </div>
@endsection
