<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}

    {{-- Initailize Plugin --}}
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Moul&family=Siemreap&family=Poppins:wght@400;600;700&family=Noto+Serif:wght@400;600;700;800&family=Roboto:wght@400;500;700&display=swap" />
    <script src="{{ asset('assets/js/tailwindcss3.4.js') }}"></script>
    <script src="{{ asset('assets/js/tailwindConfig.js') }}"></script>
    <script src="{{ asset('assets/js/darkModeHead.js') }}"></script>
    <script defer src="{{ asset('assets/js/darkMode.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('/assets/css/no-tailwind.css') }}">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="{{ asset('/assets/css/glightbox.css') }}">


    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    {{-- Style PDF Popup View --}}
    <style>
        .popup-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 9999;
        }

        .popup-content {
            /* background-color: #fff; */
            padding: 20px;
            border-radius: 5px;
            /* width: 90%;
    height: 95%; */
            width: 100%;
            height: 100%;
            overflow: auto;
        }

        .close-btn {
            position: absolute;
            top: -10px;
            right: -10px;
            padding: 15px;
            color: white;
            cursor: pointer;
        }

        .close-btn-image {
            width: 35px;
            aspect-ratio: 1/1;
            object-fit: contain;
        }

        .popup-content-container {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            height: 100%;
        }
    </style>

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>

</head>

<body class="min-h-[100vh] font-body">
    <div class="antialiased min-h-[100vh] bg-gray-50 dark:bg-gray-800">
        <nav
            class="border-b border-gray-200 px-4 py-2.5 bg-white dark:bg-gray-800 dark:border-gray-700 fixed left-0 right-0 top-0 z-30">
            <div class="flex flex-wrap items-center justify-between">
                <div class="flex items-center justify-start">
                    <button data-drawer-target="drawer-navigation" data-drawer-toggle="drawer-navigation"
                        aria-controls="drawer-navigation"
                        class="p-2 mr-2 text-gray-600 rounded-lg cursor-pointer md:hidden hover:text-gray-900 hover:bg-gray-100 focus:bg-gray-100 dark:focus:bg-gray-700 focus:ring-2 focus:ring-gray-100 dark:focus:ring-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                        <svg aria-hidden="true" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h6a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <svg aria-hidden="true" class="hidden w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span class="sr-only">Toggle sidebar</span>
                    </button>
                    <a href="/" class="flex items-center justify-center mr-4">
                        <img src="{{ asset('assets/images/logo/tomato.png') }}" class="h-8 mr-3" alt="Flowbite Logo" />
                        <span
                            class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">Dashboard</span>
                    </a>

                </div>
                <div class="flex items-center lg:order-2">
                    <button type="button" data-drawer-toggle="drawer-navigation" aria-controls="drawer-navigation"
                        class="p-2 mr-1 text-gray-500 rounded-lg md:hidden hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-700 focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600">
                        <span class="sr-only">Toggle search</span>
                        <svg aria-hidden="true" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path clip-rule="evenodd" fill-rule="evenodd"
                                d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z">
                            </path>
                        </svg>
                    </button>
                    <!-- Notifications -->
                    <button type="button" data-dropdown-toggle="notification-dropdown"
                        class="p-2 mr-1 text-gray-500 rounded-lg hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-700 focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600">
                        <span class="sr-only">View notifications</span>
                        <!-- Bell icon -->
                        <svg aria-hidden="true" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z">
                            </path>
                        </svg>
                    </button>
                    <!-- Dropdown menu -->
                    <div class="z-50 hidden max-w-sm my-4 overflow-hidden text-base list-none bg-white divide-y divide-gray-100 rounded shadow-lg dark:divide-gray-600 dark:bg-gray-700 rounded-xl"
                        id="notification-dropdown">
                        <div
                            class="block px-4 py-2 text-base font-medium text-center text-gray-700 bg-gray-50 dark:bg-gray-600 dark:text-gray-300">
                            Notifications
                        </div>
                        <div>
                            <a href="#"
                                class="flex px-4 py-3 border-b hover:bg-gray-100 dark:hover:bg-gray-600 dark:border-gray-600">
                                <div class="flex-shrink-0">
                                    <img class="rounded-full w-11 h-11"
                                        src="https://flowbite.s3.amazonaws.com/blocks/marketing-ui/avatars/bonnie-green.png"
                                        alt="Bonnie Green avatar" />
                                    <div
                                        class="absolute flex items-center justify-center w-5 h-5 ml-6 -mt-5 border border-white rounded-full bg-primary-700 dark:border-gray-700">
                                        <svg aria-hidden="true" class="w-3 h-3 text-white" fill="currentColor"
                                            viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M8.707 7.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l2-2a1 1 0 00-1.414-1.414L11 7.586V3a1 1 0 10-2 0v4.586l-.293-.293z">
                                            </path>
                                            <path
                                                d="M3 5a2 2 0 012-2h1a1 1 0 010 2H5v7h2l1 2h4l1-2h2V5h-1a1 1 0 110-2h1a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V5z">
                                            </path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="w-full pl-3">
                                    <div class="text-gray-500 font-normal text-sm mb-1.5 dark:text-gray-400">
                                        New message from
                                        <span class="font-semibold text-gray-900 dark:text-white">Bonnie Green</span>:
                                        "Hey, what's up? All set for the presentation?"
                                    </div>
                                    <div class="text-xs font-medium text-primary-600 dark:text-primary-500">
                                        a few moments ago
                                    </div>
                                </div>
                            </a>
                            <a href="#"
                                class="flex px-4 py-3 border-b hover:bg-gray-100 dark:hover:bg-gray-600 dark:border-gray-600">
                                <div class="flex-shrink-0">
                                    <img class="rounded-full w-11 h-11"
                                        src="https://flowbite.s3.amazonaws.com/blocks/marketing-ui/avatars/jese-leos.png"
                                        alt="Jese Leos avatar" />
                                    <div
                                        class="absolute flex items-center justify-center w-5 h-5 ml-6 -mt-5 bg-gray-900 border border-white rounded-full dark:border-gray-700">
                                        <svg aria-hidden="true" class="w-3 h-3 text-white" fill="currentColor"
                                            viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6zM16 7a1 1 0 10-2 0v1h-1a1 1 0 100 2h1v1a1 1 0 102 0v-1h1a1 1 0 100-2h-1V7z">
                                            </path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="w-full pl-3">
                                    <div class="text-gray-500 font-normal text-sm mb-1.5 dark:text-gray-400">
                                        <span class="font-semibold text-gray-900 dark:text-white">Jese leos</span>
                                        and
                                        <span class="font-medium text-gray-900 dark:text-white">5 others</span>
                                        started following you.
                                    </div>
                                    <div class="text-xs font-medium text-primary-600 dark:text-primary-500">
                                        10 minutes ago
                                    </div>
                                </div>
                            </a>
                            <a href="#"
                                class="flex px-4 py-3 border-b hover:bg-gray-100 dark:hover:bg-gray-600 dark:border-gray-600">
                                <div class="flex-shrink-0">
                                    <img class="rounded-full w-11 h-11"
                                        src="https://flowbite.s3.amazonaws.com/blocks/marketing-ui/avatars/joseph-mcfall.png"
                                        alt="Joseph McFall avatar" />
                                    <div
                                        class="absolute flex items-center justify-center w-5 h-5 ml-6 -mt-5 bg-red-600 border border-white rounded-full dark:border-gray-700">
                                        <svg aria-hidden="true" class="w-3 h-3 text-white" fill="currentColor"
                                            viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd"
                                                d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="w-full pl-3">
                                    <div class="text-gray-500 font-normal text-sm mb-1.5 dark:text-gray-400">
                                        <span class="font-semibold text-gray-900 dark:text-white">Joseph Mcfall</span>
                                        and
                                        <span class="font-medium text-gray-900 dark:text-white">141 others</span>
                                        love your story. See it and view more stories.
                                    </div>
                                    <div class="text-xs font-medium text-primary-600 dark:text-primary-500">
                                        44 minutes ago
                                    </div>
                                </div>
                            </a>
                            <a href="#"
                                class="flex px-4 py-3 border-b hover:bg-gray-100 dark:hover:bg-gray-600 dark:border-gray-600">
                                <div class="flex-shrink-0">
                                    <img class="rounded-full w-11 h-11"
                                        src="https://flowbite.s3.amazonaws.com/blocks/marketing-ui/avatars/roberta-casas.png"
                                        alt="Roberta Casas image" />
                                    <div
                                        class="absolute flex items-center justify-center w-5 h-5 ml-6 -mt-5 bg-green-400 border border-white rounded-full dark:border-gray-700">
                                        <svg aria-hidden="true" class="w-3 h-3 text-white" fill="currentColor"
                                            viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd"
                                                d="M18 13V5a2 2 0 00-2-2H4a2 2 0 00-2 2v8a2 2 0 002 2h3l3 3 3-3h3a2 2 0 002-2zM5 7a1 1 0 011-1h8a1 1 0 110 2H6a1 1 0 01-1-1zm1 3a1 1 0 100 2h3a1 1 0 100-2H6z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="w-full pl-3">
                                    <div class="text-gray-500 font-normal text-sm mb-1.5 dark:text-gray-400">
                                        <span class="font-semibold text-gray-900 dark:text-white">Leslie
                                            Livingston</span>
                                        mentioned you in a comment:
                                        <span
                                            class="font-medium text-primary-600 dark:text-primary-500">@bonnie.green</span>
                                        what do you say?
                                    </div>
                                    <div class="text-xs font-medium text-primary-600 dark:text-primary-500">
                                        1 hour ago
                                    </div>
                                </div>
                            </a>
                            <a href="#" class="flex px-4 py-3 hover:bg-gray-100 dark:hover:bg-gray-600">
                                <div class="flex-shrink-0">
                                    <img class="rounded-full w-11 h-11"
                                        src="https://flowbite.s3.amazonaws.com/blocks/marketing-ui/avatars/robert-brown.png"
                                        alt="Robert image" />
                                    <div
                                        class="absolute flex items-center justify-center w-5 h-5 ml-6 -mt-5 bg-purple-500 border border-white rounded-full dark:border-gray-700">
                                        <svg aria-hidden="true" class="w-3 h-3 text-white" fill="currentColor"
                                            viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z">
                                            </path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="w-full pl-3">
                                    <div class="text-gray-500 font-normal text-sm mb-1.5 dark:text-gray-400">
                                        <span class="font-semibold text-gray-900 dark:text-white">Robert Brown</span>
                                        posted a new video: Glassmorphism - learn how to implement
                                        the new design trend.
                                    </div>
                                    <div class="text-xs font-medium text-primary-600 dark:text-primary-500">
                                        3 hours ago
                                    </div>
                                </div>
                            </a>
                        </div>
                        <a href="#"
                            class="block py-2 font-medium text-center text-gray-900 text-md bg-gray-50 hover:bg-gray-100 dark:bg-gray-600 dark:text-white dark:hover:underline">
                            <div class="inline-flex items-center">
                                <svg aria-hidden="true" class="w-4 h-4 mr-2 text-gray-500 dark:text-gray-400"
                                    fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                                    <path fill-rule="evenodd"
                                        d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                View all
                            </div>
                        </a>
                    </div>
                    <!-- Apps -->
                    <button type="button" data-dropdown-toggle="apps-dropdown"
                        class="p-2 text-gray-500 rounded-lg hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-700 focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600">
                        <span class="sr-only">View notifications</span>
                        <!-- Icon -->
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                            </path>
                        </svg>
                    </button>
                    <!-- Dropdown menu -->
                    <div class="z-50 hidden max-w-sm my-4 overflow-hidden text-base list-none bg-white divide-y divide-gray-100 rounded shadow-lg dark:bg-gray-700 dark:divide-gray-600 rounded-xl"
                        id="apps-dropdown">
                        <div
                            class="block px-4 py-2 text-base font-medium text-center text-gray-700 bg-gray-50 dark:bg-gray-600 dark:text-gray-300">
                            Apps
                        </div>
                        <div class="grid grid-cols-3 gap-4 p-4">
                            <a href="#"
                                class="block p-4 text-center rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600 group">
                                <svg aria-hidden="true"
                                    class="mx-auto mb-1 text-gray-400 w-7 h-7 group-hover:text-gray-500 dark:text-gray-400 dark:group-hover:text-gray-400"
                                    fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-.994.89l-1 9A1 1 0 004 18h12a1 1 0 00.994-1.11l-1-9A1 1 0 0015 7h-1V6a4 4 0 00-4-4zm2 5V6a2 2 0 10-4 0v1h4zm-6 3a1 1 0 112 0 1 1 0 01-2 0zm7-1a1 1 0 100 2 1 1 0 000-2z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <div class="text-sm text-gray-900 dark:text-white">Sales</div>
                            </a>
                            <a href="{{ route('admin.users.index') }}"
                                class="block p-4 text-center rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600 group">
                                <svg aria-hidden="true"
                                    class="mx-auto mb-1 text-gray-400 w-7 h-7 group-hover:text-gray-500 dark:text-gray-400 dark:group-hover:text-gray-400"
                                    fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z">
                                    </path>
                                </svg>
                                <div class="text-sm text-gray-900 dark:text-white">Users</div>
                            </a>
                            <a href="#"
                                class="block p-4 text-center rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600 group">
                                <svg aria-hidden="true"
                                    class="mx-auto mb-1 text-gray-400 w-7 h-7 group-hover:text-gray-500 dark:text-gray-400 dark:group-hover:text-gray-400"
                                    fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M5 3a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2V5a2 2 0 00-2-2H5zm0 2h10v7h-2l-1 2H8l-1-2H5V5z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <div class="text-sm text-gray-900 dark:text-white">Inbox</div>
                            </a>
                            <a href="#"
                                class="block p-4 text-center rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600 group">
                                <svg aria-hidden="true"
                                    class="mx-auto mb-1 text-gray-400 w-7 h-7 group-hover:text-gray-500 dark:text-gray-400 dark:group-hover:text-gray-400"
                                    fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <div class="text-sm text-gray-900 dark:text-white">
                                    Profile
                                </div>
                            </a>
                            <a href="#"
                                class="block p-4 text-center rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600 group">
                                <svg aria-hidden="true"
                                    class="mx-auto mb-1 text-gray-400 w-7 h-7 group-hover:text-gray-500 dark:text-gray-400 dark:group-hover:text-gray-400"
                                    fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <div class="text-sm text-gray-900 dark:text-white">
                                    Settings
                                </div>
                            </a>
                            <a href="#"
                                class="block p-4 text-center rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600 group">
                                <svg aria-hidden="true"
                                    class="mx-auto mb-1 text-gray-400 w-7 h-7 group-hover:text-gray-500 dark:text-gray-400 dark:group-hover:text-gray-400"
                                    fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M4 3a2 2 0 100 4h12a2 2 0 100-4H4z"></path>
                                    <path fill-rule="evenodd"
                                        d="M3 8h14v7a2 2 0 01-2 2H5a2 2 0 01-2-2V8zm5 3a1 1 0 011-1h2a1 1 0 110 2H9a1 1 0 01-1-1z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <div class="text-sm text-gray-900 dark:text-white">
                                    Products
                                </div>
                            </a>
                            <a href="#"
                                class="block p-4 text-center rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600 group">
                                <svg aria-hidden="true"
                                    class="mx-auto mb-1 text-gray-400 w-7 h-7 group-hover:text-gray-500 dark:text-gray-400 dark:group-hover:text-gray-400"
                                    fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z">
                                    </path>
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <div class="text-sm text-gray-900 dark:text-white">
                                    Pricing
                                </div>
                            </a>
                            <a href="#"
                                class="block p-4 text-center rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600 group">
                                <svg aria-hidden="true"
                                    class="mx-auto mb-1 text-gray-400 w-7 h-7 group-hover:text-gray-500 dark:text-gray-400 dark:group-hover:text-gray-400"
                                    fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M5 2a2 2 0 00-2 2v14l3.5-2 3.5 2 3.5-2 3.5 2V4a2 2 0 00-2-2H5zm2.5 3a1.5 1.5 0 100 3 1.5 1.5 0 000-3zm6.207.293a1 1 0 00-1.414 0l-6 6a1 1 0 101.414 1.414l6-6a1 1 0 000-1.414zM12.5 10a1.5 1.5 0 100 3 1.5 1.5 0 000-3z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <div class="text-sm text-gray-900 dark:text-white">
                                    Billing
                                </div>
                            </a>
                            <a href="{{ route('logout') }}"
                                class="block p-4 text-center rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600 group">
                                <svg aria-hidden="true"
                                    class="mx-auto mb-1 text-gray-400 w-7 h-7 group-hover:text-gray-500 dark:text-gray-400 dark:group-hover:text-gray-400"
                                    fill="currentColor" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1">
                                    </path>
                                </svg>
                                <div class="text-sm text-gray-900 dark:text-white">
                                    Logout
                                </div>
                            </a>
                        </div>
                    </div>
                    <button type="button"
                        class="flex mx-3 text-sm bg-gray-800 rounded-full md:mr-0 focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600"
                        id="user-menu-button" aria-expanded="false" data-dropdown-toggle="dropdown">
                        <span class="sr-only">Open user menu</span>
                        <img class="w-8 h-8 rounded-full"
                            src="https://flowbite.s3.amazonaws.com/blocks/marketing-ui/avatars/michael-gough.png"
                            alt="user photo" />
                    </button>
                    <!-- Dropdown menu -->
                    <div class="z-50 hidden w-56 my-4 text-base list-none bg-white divide-y divide-gray-100 rounded shadow dark:bg-gray-700 dark:divide-gray-600 rounded-xl"
                        id="dropdown">
                        <div class="px-4 py-3">
                            <span class="block text-sm font-semibold text-gray-900 dark:text-white">Neil Sims</span>
                            <span class="block text-sm text-gray-900 truncate dark:text-white">name@flowbite.com</span>
                        </div>
                        <ul class="py-1 text-gray-700 dark:text-gray-300" aria-labelledby="dropdown">
                            <li>
                                <a href="#"
                                    class="block px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-400 dark:hover:text-white">My
                                    profile</a>
                            </li>
                            <li>
                                <a href="#"
                                    class="block px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-400 dark:hover:text-white">Account
                                    settings</a>
                            </li>
                        </ul>
                        <ul class="py-1 text-gray-700 dark:text-gray-300" aria-labelledby="dropdown">
                            <li>
                                <a href="#"
                                    class="flex items-center px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"><svg
                                        class="w-5 h-5 mr-2 text-gray-400" fill="currentColor" viewBox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    My likes</a>
                            </li>
                            <li>
                                <a href="#"
                                    class="flex items-center px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"><svg
                                        class="w-5 h-5 mr-2 text-gray-400" fill="currentColor" viewBox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z">
                                        </path>
                                    </svg>
                                    Collections</a>
                            </li>
                            <li>
                                <a href="#"
                                    class="flex items-center justify-between px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                    <span class="flex items-center">
                                        <svg aria-hidden="true"
                                            class="w-5 h-5 mr-2 text-primary-600 dark:text-primary-500"
                                            fill="currentColor" viewBox="0 0 20 20"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd"
                                                d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 00-.613 3.58 2.64 2.64 0 01-.945-1.067c-.328-.68-.398-1.534-.398-2.654A1 1 0 005.05 6.05 6.981 6.981 0 003 11a7 7 0 1011.95-4.95c-.592-.591-.98-.985-1.348-1.467-.363-.476-.724-1.063-1.207-2.03zM12.12 15.12A3 3 0 017 13s.879.5 2.5.5c0-1 .5-4 1.25-4.5.5 1 .786 1.293 1.371 1.879A2.99 2.99 0 0113 13a2.99 2.99 0 01-.879 2.121z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        Pro version
                                    </span>
                                    <svg aria-hidden="true" class="w-5 h-5 text-gray-400" fill="currentColor"
                                        viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </a>
                            </li>
                        </ul>
                        <ul class="py-1 text-gray-700 dark:text-gray-300" aria-labelledby="dropdown">
                            <li>
                                <a href="{{ route('logout') }}"
                                    class="block px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Sign
                                    out</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Sidebar -->

        <aside
            class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full bg-white border-r border-gray-200 md:translate-x-0 dark:bg-gray-800 dark:border-gray-700"
            aria-label="Sidenav" id="drawer-navigation">
            <a href="/" class="flex items-center justify-center mt-4">
                <img src="{{ asset('assets/images/logo/tomato.png') }}" class="h-8 mr-3" alt="Flowbite Logo" />
                <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">Dashboard</span>
            </a>
            <div class="overflow-y-auto py-5 px-3 pb-[150px] h-full bg-white dark:bg-gray-800">

                <ul class="space-y-2">
                    <li>
                        <x-sidebar-item href="{{ route('admin.dashboard.index') }}"
                            class="{{ request()->is('admin/dashboard*') ? 'bg-slate-200 dark:bg-slate-500' : '' }}">
                            <img src="{{ asset('assets/icons/slide.png') }}" alt="icon"
                                class="object-contain w-8 h-8 p-0.5 bg-white dark:bg-gray-200 rounded">
                            <span class="ml-3">Dashboard</span>
                        </x-sidebar-item>
                    </li>

                    <li x-data="{
                        open: {{ request()->is('admin/users*') || request()->is('admin/roles*') || request()->is('admin/permissions*') ? 'true' : 'false' }},
                        init() {
                            if ({{ request()->is('admin/users*') || request()->is('admin/roles*') || request()->is('admin/permissions*') ? 'true' : 'false' }}) {
                                this.$nextTick(() => this.$refs.users.scrollIntoView({ behavior: 'smooth' }));
                            }
                        }
                    }" x-ref="users" class="pt-1">
                        <button type="button"
                            class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 {{ request()->is('admin/users*') ? 'bg-slate-200 dark:bg-slate-500' : '' }}"
                            :class="{ 'bg-slate-100 dark:bg-slate-700': open }"
                            @click="open = !open; if (open) $nextTick(() => $refs.users.scrollIntoView({ behavior: 'smooth' }))">
                            <img src="{{ asset('assets/icons/user.png') }}" alt="icon"
                                class="object-contain w-8 h-8 bg-white rounded dark:bg-gray-200">
                            <span class="flex-1 text-left ms-3 rtl:text-right whitespace-nowrap">Users</span>
                            <svg class="w-3 h-3 transition-transform duration-200 transform"
                                :class="{ 'rotate-180': open }" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 4 4 4-4" />
                            </svg>
                        </button>
                        <ul x-show="open" x-transition class="py-2 ml-2 space-y-2">
                            <li>
                                <a href="{{ url('admin/users') }}"
                                    class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 {{ request()->is('admin/users*') ? 'bg-slate-200 dark:bg-slate-500' : '' }}">
                                    Users
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('admin/roles') }}"
                                    class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 {{ request()->is('admin/roles*') ? 'bg-slate-200 dark:bg-slate-500' : '' }}">
                                    Roles
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('admin/permissions') }}"
                                    class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 {{ request()->is('admin/permissions*') ? 'bg-slate-200 dark:bg-slate-500' : '' }}">
                                    Permissions
                                </a>
                            </li>

                        </ul>
                    </li>

                </ul>
                <ul class="pt-5 mt-5 space-y-2 border-t border-gray-200 dark:border-gray-700">
                    <li>
                        <x-sidebar-item href="{{ route('admin.slides.index') }}"
                            class="{{ request()->is('admin/slides*') ? 'bg-slate-200 dark:bg-slate-500' : '' }}">
                            <img src="{{ asset('assets/icons/slide.png') }}" alt="icon"
                                class="object-contain w-8 h-8 p-0.5 bg-white dark:bg-gray-200 rounded">
                            <span class="ml-3">Slides</span>
                        </x-sidebar-item>
                    </li>
                    <li>
                        <x-sidebar-item href="{{ route('admin.appintros.index') }}"
                            class="{{ request()->is('admin/appintros*') ? 'bg-slate-200 dark:bg-slate-500' : '' }}">
                            <img src="{{ asset('assets/icons/appintro.png') }}" alt="icon"
                                class="object-contain w-8 h-8 p-0.5 bg-white dark:bg-gray-200 rounded">
                            <span class="ml-3">App Intro</span>
                        </x-sidebar-item>
                    </li>
                    <li>
                        <x-sidebar-item href="{{ route('admin.courses.index') }}"
                            class="{{ request()->is('admin/courses*') ? 'bg-slate-200 dark:bg-slate-500' : '' }}">
                            <img src="{{ asset('assets/icons/appintro.png') }}" alt="icon"
                                class="object-contain w-8 h-8 p-0.5 bg-white dark:bg-gray-200 rounded">
                            <span class="ml-3">Courses</span>
                        </x-sidebar-item>
                    </li>
                    {{-- <li>
                        <x-sidebar-item href="{{ route('admin.promotions.index') }}"
                        class="{{ request()->is('admin/promotions*') ? 'bg-slate-200 dark:bg-slate-500' : '' }}"
                        >
                        <img src="{{ asset('assets/icons/promotion.png') }}"
                        alt="icon"
                        class="object-contain w-8 h-8 p-0.5 bg-white dark:bg-gray-200 rounded">
                            <span class="ml-3">promotions</span>
                        </x-sidebar-item>
                    </li> --}}
                    <li>
                        <x-sidebar-item href="{{ route('admin.dtcs.index') }}"
                            class="{{ request()->is('admin/dtcs*') ? 'bg-slate-200 dark:bg-slate-500' : '' }}">
                            <img src="{{ asset('assets/icons/dtc.png') }}" alt="icon"
                                class="object-contain w-8 h-8 p-0.5 bg-white dark:bg-gray-200 rounded">
                            <span class="ml-3">DTC</span>
                        </x-sidebar-item>
                    </li>
                    {{-- <li>
                        <x-sidebar-item href="{{ route('admin.pdfs.index') }}"
                            class="{{ request()->is('admin/pdfs*') ? 'bg-slate-200 dark:bg-slate-500' : '' }}">
                            <img src="{{ asset('assets/icons/file.png') }}" alt="icon"
                                class="object-contain w-8 h-8 p-0.5 bg-white dark:bg-gray-200 rounded">
                            <span class="ml-3">PDFS</span>
                        </x-sidebar-item>
                    </li> --}}
                    {{-- <li>
                        <x-sidebar-item href="{{ url('/get_resources/documents') }}"
                            class="{{ request()->is('get_resources/documents*') ? 'bg-slate-200 dark:bg-slate-500' : '' }}">
                            <img src="{{ asset('assets/icons/folder.png') }}" alt="icon"
                                class="object-contain w-8 h-8 p-0.5 bg-white dark:bg-gray-200 rounded">
                            <span class="ml-3">documents</span>
                        </x-sidebar-item>
                    </li> --}}
                    <li>
                        <x-sidebar-item href="{{ url('/file-explorer') }}"
                            class="{{ request()->is('get_resources/documents*') ? 'bg-slate-200 dark:bg-slate-500' : '' }}">
                            <img src="{{ asset('assets/icons/folder.png') }}" alt="icon"
                                class="object-contain w-8 h-8 p-0.5 bg-white dark:bg-gray-200 rounded">
                            <span class="ml-3">Documents</span>
                        </x-sidebar-item>
                    </li>
                    <li x-data="{
                        open: {{ request()->is('admin/shop*') ||
                        request()->is('admin/products*') ||
                        request()->is('admin/categories*') ||
                        request()->is('admin/bodytypes*') ||
                        request()->is('admin/brands*') ||
                        request()->is('admin/models*')
                            ? 'true'
                            : 'false' }},
                        init() {
                            if ({{ request()->is('admin/shop*') ||
                            request()->is('admin/products*') ||
                            request()->is('admin/categories*') ||
                            request()->is('admin/bodytypes*') ||
                            request()->is('admin/brands*') ||
                            request()->is('admin/models*')
                                ? 'true'
                                : 'false' }}) {
                                this.$nextTick(() => this.$refs.products.scrollIntoView({ behavior: 'smooth' }));
                            }
                        }
                    }" x-ref="products" class="pt-1">
                        <button type="button"
                            class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 {{ request()->is('admin/products*') ? 'bg-slate-200 dark:bg-slate-500' : '' }}"
                            :class="{ 'bg-slate-100 dark:bg-slate-700': open }"
                            @click="open = !open; if (open) $nextTick(() => $refs.products.scrollIntoView({ behavior: 'smooth' }))">
                            <img src="{{ asset('assets/icons/ecommerce.png') }}" alt="icon"
                                class="object-contain w-8 h-8 p-0.5 bg-white dark:bg-gray-200 rounded">
                            <span class="flex-1 text-left ms-3 rtl:text-right whitespace-nowrap">
                                Shop
                            </span>
                            <svg class="w-3 h-3 transition-transform duration-200 transform"
                                :class="{ 'rotate-180': open }" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 4 4 4-4" />
                            </svg>
                        </button>
                        <ul x-show="open" x-transition class="py-2 ml-2 space-y-2">
                            <li>
                                <a href="{{ url('admin/shops') }}"
                                    class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white capitalize dark:hover:bg-gray-700 {{ request()->is('admin/shops') ? 'bg-slate-200 dark:bg-slate-500' : '' }}">
                                    shops
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('admin/products') }}"
                                    class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white capitalize dark:hover:bg-gray-700 {{ request()->is('admin/products') ? 'bg-slate-200 dark:bg-slate-500' : '' }}">
                                    products
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('admin/categories') }}"
                                    class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white capitalize dark:hover:bg-gray-700 {{ request()->is('admin/categories') ? 'bg-slate-200 dark:bg-slate-500' : '' }}">
                                    categories
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('admin/bodytypes') }}"
                                    class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 {{ request()->is('admin/bodytypes') ? 'bg-slate-200 dark:bg-slate-500' : '' }}">
                                    Body Types
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('admin/brands') }}"
                                    class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white capitalize dark:hover:bg-gray-700 {{ request()->is('admin/brands') ? 'bg-slate-200 dark:bg-slate-500' : '' }}">
                                    brands
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('admin/models') }}"
                                    class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white capitalize dark:hover:bg-gray-700 {{ request()->is('admin/models') ? 'bg-slate-200 dark:bg-slate-500' : '' }}">
                                    models
                                </a>
                            </li>

                        </ul>
                    </li>

                    <li x-data="{
                        open: {{ request()->is('admin/garages*') || request()->is('admin/garageposts*') ? 'true' : 'false' }},
                        init() {
                            if ({{ request()->is('admin/garages*') || request()->is('admin/garageposts*') ? 'true' : 'false' }}) {
                                this.$nextTick(() => this.$refs.garages.scrollIntoView({ behavior: 'smooth' }));
                            }
                        }
                    }" x-ref="garages" class="pt-1">
                        <button type="button"
                            class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 {{ request()->is('admin/garages*') ? 'bg-slate-200 dark:bg-slate-500' : '' }}"
                            :class="{ 'bg-slate-100 dark:bg-slate-700': open }"
                            @click="open = !open; if (open) $nextTick(() => $refs.garages.scrollIntoView({ behavior: 'smooth' }))">
                            <img src="{{ asset('assets/icons/garage.png') }}" alt="icon"
                                class="object-contain w-8 h-8 p-0.5 bg-white dark:bg-gray-200 rounded">
                            <span class="flex-1 text-left ms-3 rtl:text-right whitespace-nowrap">
                                Garage
                            </span>
                            <svg class="w-3 h-3 transition-transform duration-200 transform"
                                :class="{ 'rotate-180': open }" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 4 4 4-4" />
                            </svg>
                        </button>
                        <ul x-show="open" x-transition class="py-2 ml-2 space-y-2">
                            <li>
                                <a href="{{ url('admin/garages') }}"
                                    class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white capitalize dark:hover:bg-gray-700 {{ request()->is('admin/garages') ? 'bg-slate-200 dark:bg-slate-500' : '' }}">
                                    garages
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('admin/garageposts') }}"
                                    class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 {{ request()->is('admin/garageposts') ? 'bg-slate-200 dark:bg-slate-500' : '' }}">
                                    Garage Posts
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li x-data="{
                        open: {{ request()->is('admin/videos*') || request()->is('admin/video_categories*') ? 'true' : 'false' }},
                        init() {
                            if ({{ request()->is('admin/videos*') || request()->is('admin/video_categories*') ? 'true' : 'false' }}) {
                                this.$nextTick(() => this.$refs.videos.scrollIntoView({ behavior: 'smooth' }));
                            }
                        }
                    }" x-ref="videos" class="pt-1">
                        <button type="button"
                            class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 {{ request()->is('admin/videos*') ? 'bg-slate-200 dark:bg-slate-500' : '' }}"
                            :class="{ 'bg-slate-100 dark:bg-slate-700': open }"
                            @click="open = !open; if (open) $nextTick(() => $refs.videos.scrollIntoView({ behavior: 'smooth' }))">
                            <img src="{{ asset('assets/icons/video.png') }}" alt="icon"
                                class="object-contain w-8 h-8 p-0.5 bg-white dark:bg-gray-200 rounded">
                            <span class="flex-1 text-left ms-3 rtl:text-right whitespace-nowrap">
                                Video
                            </span>
                            <svg class="w-3 h-3 transition-transform duration-200 transform"
                                :class="{ 'rotate-180': open }" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 4 4 4-4" />
                            </svg>
                        </button>
                        <ul x-show="open" x-transition class="py-2 ml-2 space-y-2">
                            <li>
                                <a href="{{ url('admin/videos') }}"
                                    class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white capitalize dark:hover:bg-gray-700 {{ request()->is('admin/videos') ? 'bg-slate-200 dark:bg-slate-500' : '' }}">
                                    videos
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('admin/video_categories') }}"
                                    class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 {{ request()->is('admin/video_categories') ? 'bg-slate-200 dark:bg-slate-500' : '' }}">
                                    Video Play Lists
                                </a>
                            </li>
                        </ul>
                    </li>


                </ul>

            </div>
            <div class="absolute bottom-0 z-20 flex justify-center w-full p-4 space-x-4 bg-white dark:bg-gray-800">
                <button id="theme-toggle" type="button"
                    class="p-2 text-sm text-gray-600 rounded-lg hover:text-gray-500 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700">
                    <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                    </svg>
                    <svg id="theme-toggle-light-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"
                            fill-rule="evenodd" clip-rule="evenodd"></path>
                    </svg>
                </button>

                <a href="#" data-tooltip-target="tooltip-settings"
                    class="inline-flex justify-center p-2 text-gray-500 rounded cursor-pointer dark:text-gray-400 dark:hover:text-white hover:text-gray-900 hover:bg-gray-100 dark:hover:bg-gray-600">
                    <svg aria-hidden="true" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z"
                            clip-rule="evenodd"></path>
                    </svg>
                </a>
                <div id="tooltip-settings" role="tooltip"
                    class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip">
                    Settings page
                    <div class="tooltip-arrow" data-popper-arrow></div>
                </div>
                <button type="button" data-dropdown-toggle="language-dropdown"
                    class="inline-flex justify-center p-2 text-gray-500 rounded cursor-pointer dark:hover:text-white dark:text-gray-400 hover:text-gray-900 hover:bg-gray-100 dark:hover:bg-gray-600">
                    <svg aria-hidden="true" class="h-5 w-5 rounded-full mt-0.5" xmlns="http://www.w3.org/2000/svg"
                        xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 3900 3900">
                        <path fill="#b22234" d="M0 0h7410v3900H0z" />
                        <path d="M0 450h7410m0 600H0m0 600h7410m0 600H0m0 600h7410m0 600H0" stroke="#fff"
                            stroke-width="300" />
                        <path fill="#3c3b6e" d="M0 0h2964v2100H0z" />
                        <g fill="#fff">
                            <g id="d">
                                <g id="c">
                                    <g id="e">
                                        <g id="b">
                                            <path id="a"
                                                d="M247 90l70.534 217.082-184.66-134.164h228.253L176.466 307.082z" />
                                            <use xlink:href="#a" y="420" />
                                            <use xlink:href="#a" y="840" />
                                            <use xlink:href="#a" y="1260" />
                                        </g>
                                        <use xlink:href="#a" y="1680" />
                                    </g>
                                    <use xlink:href="#b" x="247" y="210" />
                                </g>
                                <use xlink:href="#c" x="494" />
                            </g>
                            <use xlink:href="#d" x="988" />
                            <use xlink:href="#c" x="1976" />
                            <use xlink:href="#e" x="2470" />
                        </g>
                    </svg>
                </button>
                <!-- Dropdown -->
                <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded shadow dark:bg-gray-700"
                    id="language-dropdown">
                    <ul class="py-1" role="none">
                        <li>
                            <a href="#"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:text-white dark:text-gray-300 dark:hover:bg-gray-600"
                                role="menuitem">
                                <div class="inline-flex items-center">
                                    <svg aria-hidden="true" class="h-3.5 w-3.5 rounded-full mr-2"
                                        xmlns="http://www.w3.org/2000/svg" id="flag-icon-css-us"
                                        viewBox="0 0 512 512">
                                        <g fill-rule="evenodd">
                                            <g stroke-width="1pt">
                                                <path fill="#bd3d44"
                                                    d="M0 0h247v10H0zm0 20h247v10H0zm0 20h247v10H0zm0 20h247v10H0zm0 20h247v10H0zm0 20h247v10H0zm0 20h247v10H0z"
                                                    transform="scale(3.9385)" />
                                                <path fill="#fff"
                                                    d="M0 10h247v10H0zm0 20h247v10H0zm0 20h247v10H0zm0 20h247v10H0zm0 20h247v10H0zm0 20h247v10H0z"
                                                    transform="scale(3.9385)" />
                                            </g>
                                            <path fill="#192f5d" d="M0 0h98.8v70H0z" transform="scale(3.9385)" />
                                            <path fill="#fff"
                                                d="M8.2 3l1 2.8H12L9.7 7.5l.9 2.7-2.4-1.7L6 10.2l.9-2.7-2.4-1.7h3zm16.5 0l.9 2.8h2.9l-2.4 1.7 1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7h2.9zm16.5 0l.9 2.8H45l-2.4 1.7 1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7h2.9zm16.4 0l1 2.8h2.8l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h3zm16.5 0l.9 2.8h2.9l-2.4 1.7 1 2.7L74 8.5l-2.3 1.7.9-2.7-2.4-1.7h2.9zm16.5 0l.9 2.8h2.9L92 7.5l1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7h2.9zm-74.1 7l.9 2.8h2.9l-2.4 1.7 1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7h2.9zm16.4 0l1 2.8h2.8l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h3zm16.5 0l.9 2.8h2.9l-2.4 1.7 1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7h2.9zm16.5 0l.9 2.8h2.9l-2.4 1.7 1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7H65zm16.4 0l1 2.8H86l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h3zm-74 7l.8 2.8h3l-2.4 1.7.9 2.7-2.4-1.7L6 24.2l.9-2.7-2.4-1.7h3zm16.4 0l.9 2.8h2.9l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h2.9zm16.5 0l.9 2.8H45l-2.4 1.7 1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7h2.9zm16.4 0l1 2.8h2.8l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h3zm16.5 0l.9 2.8h2.9l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h2.9zm16.5 0l.9 2.8h2.9L92 21.5l1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7h2.9zm-74.1 7l.9 2.8h2.9l-2.4 1.7 1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7h2.9zm16.4 0l1 2.8h2.8l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h3zm16.5 0l.9 2.8h2.9l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h2.9zm16.5 0l.9 2.8h2.9l-2.4 1.7 1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7H65zm16.4 0l1 2.8H86l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h3zm-74 7l.8 2.8h3l-2.4 1.7.9 2.7-2.4-1.7L6 38.2l.9-2.7-2.4-1.7h3zm16.4 0l.9 2.8h2.9l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h2.9zm16.5 0l.9 2.8H45l-2.4 1.7 1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7h2.9zm16.4 0l1 2.8h2.8l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h3zm16.5 0l.9 2.8h2.9l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h2.9zm16.5 0l.9 2.8h2.9L92 35.5l1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7h2.9zm-74.1 7l.9 2.8h2.9l-2.4 1.7 1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7h2.9zm16.4 0l1 2.8h2.8l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h3zm16.5 0l.9 2.8h2.9l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h2.9zm16.5 0l.9 2.8h2.9l-2.4 1.7 1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7H65zm16.4 0l1 2.8H86l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h3zm-74 7l.8 2.8h3l-2.4 1.7.9 2.7-2.4-1.7L6 52.2l.9-2.7-2.4-1.7h3zm16.4 0l.9 2.8h2.9l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h2.9zm16.5 0l.9 2.8H45l-2.4 1.7 1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7h2.9zm16.4 0l1 2.8h2.8l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h3zm16.5 0l.9 2.8h2.9l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h2.9zm16.5 0l.9 2.8h2.9L92 49.5l1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7h2.9zm-74.1 7l.9 2.8h2.9l-2.4 1.7 1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7h2.9zm16.4 0l1 2.8h2.8l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h3zm16.5 0l.9 2.8h2.9l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h2.9zm16.5 0l.9 2.8h2.9l-2.4 1.7 1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7H65zm16.4 0l1 2.8H86l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h3zm-74 7l.8 2.8h3l-2.4 1.7.9 2.7-2.4-1.7L6 66.2l.9-2.7-2.4-1.7h3zm16.4 0l.9 2.8h2.9l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h2.9zm16.5 0l.9 2.8H45l-2.4 1.7 1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7h2.9zm16.4 0l1 2.8h2.8l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h3zm16.5 0l.9 2.8h2.9l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h2.9zm16.5 0l.9 2.8h2.9L92 63.5l1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7h2.9z"
                                                transform="scale(3.9385)" />
                                        </g>
                                    </svg>
                                    English (US)
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:text-white dark:hover:bg-gray-600"
                                role="menuitem">
                                <div class="inline-flex items-center">
                                    <svg aria-hidden="true" class="h-3.5 w-3.5 rounded-full mr-2"
                                        xmlns="http://www.w3.org/2000/svg" id="flag-icon-css-de"
                                        viewBox="0 0 512 512">
                                        <path fill="#ffce00" d="M0 341.3h512V512H0z" />
                                        <path d="M0 0h512v170.7H0z" />
                                        <path fill="#d00" d="M0 170.7h512v170.6H0z" />
                                    </svg>
                                    Deutsch
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:text-white dark:hover:bg-gray-600"
                                role="menuitem">
                                <div class="inline-flex items-center">
                                    <svg aria-hidden="true" class="h-3.5 w-3.5 rounded-full mr-2"
                                        xmlns="http://www.w3.org/2000/svg" id="flag-icon-css-it"
                                        viewBox="0 0 512 512">
                                        <g fill-rule="evenodd" stroke-width="1pt">
                                            <path fill="#fff" d="M0 0h512v512H0z" />
                                            <path fill="#009246" d="M0 0h170.7v512H0z" />
                                            <path fill="#ce2b37" d="M341.3 0H512v512H341.3z" />
                                        </g>
                                    </svg>
                                    Italiano
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:text-white dark:text-gray-300 dark:hover:bg-gray-600"
                                role="menuitem">
                                <div class="inline-flex items-center">
                                    <svg aria-hidden="true" class="h-3.5 w-3.5 rounded-full mr-2"
                                        xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                        id="flag-icon-css-cn" viewBox="0 0 512 512">
                                        <defs>
                                            <path id="a" fill="#ffde00" d="M1-.3L-.7.8 0-1 .6.8-1-.3z" />
                                        </defs>
                                        <path fill="#de2910" d="M0 0h512v512H0z" />
                                        <use width="30" height="20" transform="matrix(76.8 0 0 76.8 128 128)"
                                            xlink:href="#a" />
                                        <use width="30" height="20"
                                            transform="rotate(-121 142.6 -47) scale(25.5827)" xlink:href="#a" />
                                        <use width="30" height="20"
                                            transform="rotate(-98.1 198 -82) scale(25.6)" xlink:href="#a" />
                                        <use width="30" height="20"
                                            transform="rotate(-74 272.4 -114) scale(25.6137)" xlink:href="#a" />
                                        <use width="30" height="20"
                                            transform="matrix(16 -19.968 19.968 16 256 230.4)" xlink:href="#a" />
                                    </svg>
                                    中文 (繁體)
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </aside>

        <main class="h-auto p-4 pt-20 md:ml-64 dark:bg-gray-800">
            <section class="dark:bg-gray-900">
                <div class="mx-auto max-w-screen-2xl ">
                    <div
                        class="relative overflow-hidden bg-white shadow-md dark:bg-gray-800 sm:rounded-lg  min-h-[80vh]">
                        @yield('content')
                    </div>
                </div>
            </section>
        </main>
    </div>

    <script src="{{ asset('assets/js/flowbite2.3.js') }}"></script>
    <script src="{{ asset('/assets/ckeditor/ckeditor4/ckeditor.js') }}"></script>
    <script>
        var options = {
            filebrowserImageBrowseUrl: '{{ asset('laravel-filemanager?type=Images') }}',
            filebrowserImageUploadUrl: '{{ asset('laravel-filemanager/upload?type=Images&_token=') }}',
            filebrowserBrowseUrl: '{{ asset('laravel-filemanager?type=Files') }}',
            filebrowserUploadUrl: '{{ asset('laravel-filemanager/upload?type=Files&_token=') }}'
        };
        // var areas = Array('details', 'description', 'description_kh','description_en');
        // areas.forEach(function(area) {
        //     CKEDITOR.replace(area, options);
        // });
    </script>
    <script src="{{ asset('assets/js/glightbox.js') }}"></script>
    <script>
        var lightbox = GLightbox();
        lightbox.on('open', (target) => {
            console.log('lightbox opened');
        });
        var lightboxDescription = GLightbox({
            selector: '.glightbox2'
        });
        var lightboxVideo = GLightbox({
            selector: '.glightbox3'
        });
        lightboxVideo.on('slide_changed', ({
            prev,
            current
        }) => {
            console.log('Prev slide', prev);
            console.log('Current slide', current);

            const {
                slideIndex,
                slideNode,
                slideConfig,
                player
            } = current;

            if (player) {
                if (!player.ready) {
                    // If player is not ready
                    player.on('ready', (event) => {
                        // Do something when video is ready
                    });
                }

                player.on('play', (event) => {
                    console.log('Started play');
                });

                player.on('volumechange', (event) => {
                    console.log('Volume change');
                });

                player.on('ended', (event) => {
                    console.log('Video ended');
                });
            }
        });

        var lightboxInlineIframe = GLightbox({
            selector: '.glightbox4'
        });

        /* var exampleApi = GLightbox({ selector: null });
        exampleApi.insertSlide({
            href: 'https://picsum.photos/1200/800',
        });
        exampleApi.insertSlide({
            width: '500px',
            content: '<p>Example</p>'
        });
        exampleApi.insertSlide({
            href: 'https://www.youtube.com/watch?v=WzqrwPhXmew',
        });
        exampleApi.insertSlide({
            width: '200vw',
            content: document.getElementById('inline-example')
        });
        exampleApi.open(); */
    </script>



</body>


</html>
