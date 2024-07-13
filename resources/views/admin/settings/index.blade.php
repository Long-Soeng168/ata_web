@extends('admin.layouts.admin')
@section('content')

<div>
    @include('admin.components.success')
    <div class="w-full h-full p-3 overflow-auto">
        <div class="border-gray-200">
            <ul class="flex flex-wrap pt-1 text-sm font-medium text-center border rounded-md" id="default-tab" data-tabs-toggle="#default-tab-content" role="tablist">

                <li class="me-2" role="presentation">
                    <button class="inline-block px-5 py-3 border-b-2 rounded-t-lg hover:text-slate-800" id="dashboard-tab" data-tabs-target="#dashboard" type="button" role="tab" aria-controls="dashboard" aria-selected="false">
                        Shop
                    </button>
                </li>
                <li class="me-2" role="presentation">
                    <button class="inline-block px-5 py-3 border-b-2 rounded-t-lg hover:border-gray-300" id="settings-tab" data-tabs-target="#settings" type="button" role="tab" aria-controls="settings" aria-selected="false">
                        Currency & VAT
                    </button>
                </li>
                <li class="me-2" role="presentation">
                    <button class="inline-block px-5 py-3 border-b-2 rounded-t-lg hover:border-gray-300" id="payment-tab" data-tabs-target="#payment" type="button" role="tab" aria-controls="payment" aria-selected="false">
                        Payment
                    </button>
                </li>
            </ul>
        </div>
        <div id="default-tab-content">
            <div class="hidden p-4 rounded-lg" id="dashboard" role="tabpanel" aria-labelledby="dashboard-tab">
                <div class="pb-5 border-b">
                    <h1 class="text-2xl font-semibold">Shop</h1>
                    <p class="font-normal text-gray-500">
                        You can change Shop Information here.
                    </p>
                </div>
                @include('admin.settings.partials.edit-shop-form')
            </div>
            <div class="hidden p-4 rounded-lg" id="settings" role="tabpanel" aria-labelledby="settings-tab">
                <div class="pb-5 border-b">
                    <h1 class="text-2xl font-semibold">Currency & VAT</h1>
                    <p class="font-normal text-gray-500">
                        You can manage currency setting for the system here.
                    </p>
                </div>
                <div class="flex items-center gap-5 pt-5">
                    <form action="" class="w-full space-y-3">
                        <div class="flex items-center gap-5">
                            <label for="website-admin" class="w-[170px] block text-sm whitespace-nowrap font-medium text-gray-900">Exchange Rate:
                            </label>
                            <div class="flex w-full">
                                <span class="inline-flex text-xl items-center px-[18px] text-gray-900 bg-gray-200 border rounded-e-0 border-gray-300 rounded-s-md">
                                    ៛
                                </span>
                                <input type="text" id="website-admin" class="rounded-none rounded-e-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 max-w-[300px] text-sm border-gray-300 p-2.5" placeholder="4100" />
                            </div>
                        </div>
                        <div class="flex items-center gap-5">
                            <label for="website-admin" class="w-[170px] block text-sm font-medium text-gray-900">VAT:
                            </label>
                            <div class="flex w-full">
                                <span class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border border-gray-300 rounded-e-0 rounded-s-md">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-percent">
                                        <line x1="19" x2="5" y1="5" y2="19" />
                                        <circle cx="6.5" cy="6.5" r="2.5" />
                                        <circle cx="17.5" cy="17.5" r="2.5" />
                                    </svg>
                                </span>
                                <input type="text" id="website-admin" class="rounded-none rounded-e-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 max-w-[300px] text-sm border-gray-300 p-2.5" placeholder="4.00" />
                            </div>
                        </div>
                        <div class="pt-2">
                            <x-submit-button>
                                Save Changes
                            </x-submit-button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="hidden p-4 rounded-lg" id="payment" role="tabpanel" aria-labelledby="payment-tab">
                <div class="pb-5 border-b">
                    <h1 class="text-2xl font-semibold">Payments</h1>
                    <p class="font-normal text-gray-500">
                        You can manage currency setting for the system here.
                    </p>
                </div>
                <div class="flex items-center gap-5 pt-5">
                    <form action="" class="w-full space-y-3">
                        <div class="flex flex-col gap-5">
                            <div>
                                <!-- Modal toggle -->
                                <div class="flex items-center gap-14">
                                    <h1 class="text-sm font-semibold">Payments QRCode:</h1>
                                    <button data-modal-target="crud-modal" data-modal-toggle="crud-modal" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
                                        Add More
                                    </button>
                                </div>

                                <!-- Main modal -->
                                <div id="crud-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                    <div class="relative w-full max-w-md max-h-full p-4">
                                        <!-- Modal content -->
                                        <div class="relative bg-white rounded-lg shadow">
                                            <!-- Modal header -->
                                            <div class="flex items-center justify-between p-4 border-b rounded-t md:p-5">
                                                <h3 class="text-lg font-semibold text-gray-900">
                                                    Create New Payment
                                                </h3>
                                                <button type="button" class="inline-flex items-center justify-center w-8 h-8 text-sm text-gray-400 bg-transparent rounded-lg hover:bg-gray-200 hover:text-gray-900 ms-auto" data-modal-toggle="crud-modal">
                                                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                                    </svg>
                                                    <span class="sr-only">Close modal</span>
                                                </button>
                                            </div>
                                            <!-- Modal body -->
                                            <form class="w-full p-4 md:p-5">
                                                <div class="grid grid-cols-2 gap-4 px-4 mb-4">
                                                    <div class="col-span-2 py-2 sm:col-span-1">
                                                        <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Payment Name</label>
                                                        <input type="text" name="name" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" required="" />
                                                    </div>
                                                    <div class="col-span-2 py-2 sm:col-span-1">
                                                        <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Payment ID</label>
                                                        <input type="text" name="name" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" required="" />
                                                    </div>
                                                    <div class="col-span-2">
                                                        <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Payment ID</label>
                                                        <input type="text" name="name" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" required="" />
                                                    </div>
                                                    <div class="col-span-2 space-y-2">
                                                        <label class="block pr-1 text-sm font-medium text-gray-900 whitespace-nowrap" for="small_size">Shop Logo:
                                                        </label>
                                                        <input class="block w-full text-xs text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50" id="small_size" type="file" />
                                                    </div>
                                                </div>
                                                <div class="px-4 py-2">
                                                    <button type="submit" class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                                        <svg class="w-5 h-5 me-1 -ms-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                            <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path>
                                                        </svg>
                                                        Add new product
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="flex gap-2 ml-[175px]">
                                <div class="flex flex-col items-center space-y-1">
                                    <img src="./assets/aba.jpg" class="border rounded-md w-52 h-52" alt="" />
                                    <h1 class="font-semibold">ABA</h1>
                                    <p class="font-medium">087562627545</p>
                                </div>
                                <div class="flex flex-col items-center space-y-1">
                                    <img src="./assets/aba.jpg" class="border rounded-md w-52 h-52" alt="" />
                                    <h1 class="font-semibold">ABA</h1>
                                    <p class="font-medium">087562627545</p>
                                </div>
                                <div class="flex flex-col items-center space-y-1">
                                    <img src="./assets/aba.jpg" class="border rounded-md w-52 h-52" alt="" />
                                    <h1 class="font-semibold">ABA</h1>
                                    <p class="font-medium">087562627545</p>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function displaySelectedImage(event) {
        const fileInput = event.target;
        const file = fileInput.files[0];
        const imgElement = document.getElementById('selected-image');

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                imgElement.src = e.target.result;
                imgElement.classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        } else {
            imgElement.src = "#";
            imgElement.classList.add('hidden');
        }
    }

</script>

@endsection
