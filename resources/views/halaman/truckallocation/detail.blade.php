@extends('index')

@section('content')
    <div class="details container mx-auto" x-data="details()" x-init="init">
        <div class="information mt-6 p-4 border">
            <div class="info-umum">
                <h3 class="font-bold text-sm uppercase">information Umum</h3>
                <div class="grid grid-cols-1 text-xs mt-3 md:grid-cols-3 gap-2">
                    <div class="grid-cols-2 grid shadow-xl" x-bind:class="!details_table.project_no ? 'animate-pulse bg-gray-300' : ''">
                        <div x-bind:class="!details_table.project_no ? 'animate-pulse bg-gray-300' : 'bg-indigo-900'" class="text-white py-1 flex items-center justify-center"><p>Project No</p></div>
                        <div x-show="details_table" class="py-1 border text-center flex justify-center items-center"><p x-text="details_table.project_no"></p></div>
                    </div>
                    <div class="grid-cols-2 grid shadow-xl" x-bind:class="!details_table.project_no ? 'animate-pulse bg-gray-300' : ''">
                        <div x-bind:class="!details_table.project_no ? 'animate-pulse bg-gray-300' : 'bg-indigo-900'" class="text-white py-1 flex items-center justify-center"><p>Vessel</p></div>
                        <div x-show="details_table" class="py-1 border text-center flex justify-center items-center"><p x-text="details_table.vessel"></p></div>
                    </div>
                    <div class="grid-cols-2 grid shadow-xl" x-bind:class="!details_table.project_no ? 'animate-pulse bg-gray-300' : ''">
                        <div x-bind:class="!details_table.project_no ? 'animate-pulse bg-gray-300' : 'bg-indigo-900'" class="text-white py-1 flex items-center justify-center"><p>Consignee</p></div>
                        <div x-show="details_table" class="py-1 border text-center flex justify-center items-center"><p x-text="details_table.consignee"></p></div>
                    </div>
                    <div class="grid-cols-2 grid shadow-xl" x-bind:class="!details_table.project_no ? 'animate-pulse bg-gray-300' : ''">
                        <div x-bind:class="!details_table.project_no ? 'animate-pulse bg-gray-300' : 'bg-indigo-900'" class="text-white py-1 flex items-center justify-center"><p>Truck Qty</p></div>
                        <div x-show="details_table" class="py-1 border text-center flex justify-center items-center"><p x-text="details_table.truck_qty"></p></div>
                    </div>
                    <div class="grid-cols-2 grid shadow-xl" x-bind:class="!details_table.project_no ? 'animate-pulse bg-gray-300' : ''">
                        <div x-bind:class="!details_table.project_no ? 'animate-pulse bg-gray-300' : 'bg-indigo-900'" class="text-white py-1 flex items-center justify-center"><p>Commodity</p></div>
                        <div x-show="details_table" class="py-1 border text-center flex justify-center items-center"><p x-text="details_table.commodity"></p></div>
                    </div>
                    <div class="grid-cols-2 grid shadow-xl" x-bind:class="!details_table.project_no ? 'animate-pulse bg-gray-300' : ''">
                        <div x-bind:class="!details_table.project_no ? 'animate-pulse bg-gray-300' : 'bg-indigo-900'" class="text-white py-1 flex items-center justify-center"><p>Truck Type</p></div>
                        <div x-show="details_table" class="py-1 border text-center flex justify-center items-center"><p x-text="details_table.truck_type"></p></div>
                    </div>
                    <div class="grid-cols-2 grid shadow-xl" x-bind:class="!details_table.project_no ? 'animate-pulse bg-gray-300' : ''">
                        <div x-bind:class="!details_table.project_no ? 'animate-pulse bg-gray-300' : 'bg-indigo-900'" class="text-white py-1 flex items-center justify-center"><p>Transportir</p></div>
                        <div x-show="details_table" class="py-1 border text-center flex justify-center items-center"><p x-text="details_table.transportir"></p></div>
                    </div>
                </div>
            </div>
        </div>

        <section class="mt-8">
            <div class="px-2.5 py-1.5 bg-gray-200 inline-flex text-gray-800 text-xs"><span>Add Form Truck</span></div>
            <div class="add-form p-4 container mx-auto border">
                <form class="mt-2">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 md:gap-x-12 gap-y-2">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-2 md:gap-4 form-group">
                            <label class="text-xs font-sans font-semibold my-auto" for="m_trucks_id">
                                <span>Police Number</span>
                                <span class="text-red-600">*</span>
                            </label>
                            <div class="col-span-3 grid grid-cols-1 md:grid-cols-2 gap-2">
                                <div class="relative">
                                    <input x-model="police" type="text" class="appearance-none border rounded w-full py-2 px-3 text-xs text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Police Number..">
                                    <template x-if="police_box && police">
                                        <div class="absolute top-9 z-20 w-full py-1 border-b border-r border-l text-xs bg-white" >
                                            <template x-for="item in list">
                                                <p x-on:click="selectPolice(item.id,item.nopol,item.exp_date)" class="px-2 cursor-pointer py-0.5 hover:bg-blue-100" x-text="item.nopol"></p>
                                            </template>
                                        </div>
                                    </template>
                                </div>
                                <input x-model="expire_date" type="text" readonly class="appearance-none border bg-gray-100 border rounded cursor-not-allowed w-full py-2 px-3 text-xs text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Expire Date">
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-2 md:gap-4 form-group">
                            <label class="text-xs font-sans font-semibold my-auto" for="consignee">
                                <span>Consignee</span>
                                <span class="text-red-600">*</span>
                            </label>
                            <div class="col-span-3 grid grid-cols-1 md:grid-cols-1 gap-2">
                                {{-- <input x-text="consignee" readonly type="text" class="appearance-none border rounded w-full py-2 px-3 text-xs text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Code.."> --}}
                                {{-- <div class="relative">
                                    <input x-model="consignee" readonly type="text" class="appearance-none border rounded w-full py-2 px-3 text-xs text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Code..">
                                    <template x-if="consignee_box && consignee">
                                        <div class="absolute top-9 z-20 w-full py-1 border-b border-r border-l text-xs bg-white">
                                            <template x-for="item in list">
                                                <p x-on:click="selectConsigne(item.id,item.code,item.name)" class="px-2 cursor-pointer py-0.5 hover:bg-blue-100" x-text="item.code"></p>
                                            </template>
                                        </div>
                                    </template>
                                </div> --}}
                                <div class="inline-flex">
                                    {{-- <p class="font-bold my-auto mr-1.5">-</p> --}}
                                    <input value="{{session('allocation_detail')->consignee}}" type="text" readonly  class="appearance-none border truncate cursor-not-allowed bg-gray-100 border rounded w-full py-2 px-3 text-xs text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Description..">
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-2 md:gap-4 form-group">
                            <label class="text-xs font-sans font-semibold my-auto" for="m_drivers_id">
                                <span>Driver</span>
                            </label>
                            <div class="relative col-span-3 w-full">
                                <input x-model="driver" type="text" class="appearance-none border rounded w-full py-2 px-3 text-xs text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Driver Name..">
                                <template x-if="driver_box && driver">
                                    <div class="absolute top-9 z-20 w-full py-1 border-b border-r border-l text-xs bg-white">
                                        <template x-for="item in list">
                                            <p x-on:click="selectDriver(item.id,item.name)" class="px-2 cursor-pointer py-0.5 hover:bg-blue-100" x-text="item.name"></p>
                                        </template>
                                    </div>
                                </template>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-2 md:gap-4 form-group">
                            <label class="text-xs font-sans font-semibold my-auto" for="routes">
                                <span>Routes</span>
                                <span class="text-red-600">*</span>
                            </label>
                            <div class="relative col-span-3 w-full">
                                <input x-model="routes" type="text"  class="appearance-none border truncate rounded w-full py-2 px-3 text-xs text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Routes..">
                                <template x-if="routes_box && routes">
                                    <div class="absolute top-9 z-20 w-full border-b border-r border-l text-xs bg-white">
                                        <template x-for="item in list">
                                            <p x-on:click="selectRoutes(item.id,item.description)" class="px-2 cursor-pointer py-0.5 hover:bg-blue-100" x-text="item.description"></p>
                                        </template>
                                    </div>
                                </template>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-2 md:gap-4 form-group">
                            <label class="text-xs font-sans font-semibold my-auto" for="ritase">
                                <span>Ritase</span>
                                <span class="text-red-600">*</span>
                            </label>
                            <div class="col-span-3 w-full">
                                <input x-model="form.ritase" type="number" class="appearance-none border rounded w-full py-2 px-3 text-xs text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Ritase.." name="ritase">
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-2 md:gap-4 form-group">
                            <label class="text-xs font-sans font-semibold my-auto" for="valid_until">
                                <span>Valid Until</span>
                                <span class="text-red-600">*</span>
                            </label>
                            <div class="col-span-3 w-full relative">
                                <input x-model="form.active_end" type="date" id="end_dats" class="appearance-none border rounded w-full py-2 px-3 text-xs text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Valid end.." name="active_end">
                                <span class="absolute bg-white w-3/6 left-4 text-xs top-2.5" id="hide_end"></span>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-2 md:gap-4 form-group">
                            <label class="text-xs font-sans font-semibold my-auto" for="valid_form">
                                <span>Valid Form</span>
                                <span class="text-red-600">*</span>
                            </label>
                            <div class="col-span-3 w-full relative">
                                <input x-model="form.active_start" id="form_dats" type="date" class="appearance-none border rounded w-full py-2 px-3 text-xs text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Valid form.." name="active_start">
                                <span class="absolute bg-white w-3/6 left-4 text-xs top-2.5" id="hide_from"></span>
                            </div>
                        </div>
                    </div>
                    <div id="btn_submit" x-on:click="sending()" class="bg-indigo-900 cursor-pointer mt-6 inline-flex text-white px-3 py-1 rounded-sm text-xs">Simpan</div>
                    <template x-if="validation == 1">
                        <div class="bg-red-100 z-50 text-red-500 w-full py-3 left-0 text-sm shadow-md fixed top-0 z-40" role="alert">
                            <div class="container mx-auto">
                                <strong>Form anda tidak valid !</strong>
                            </div>
                        </div>
                    </template>
                    <template x-if="validation == 2">
                        <div :class="error_code ? 'bg-red-100 text-red-500' : 'bg-green-100 text-green-500'" :class="validation == 2 ? 'transition duration-700 ease-in-out ' : ''" class="w-full py-3 z-50 left-0 text-sm shadow-md fixed z-40 top-0" role="alert">
                            <div class="container mx-auto">
                                <strong x-text="message"></strong>
                            </div>
                        </div>
                    </template>
                </form>
            </div>
        </section>
        @include('halaman.truckallocation.table_emkl')
        
        <template x-if="showLoading">
            <div class="fixed top-0 left-0 right-0 bg-gray-500 bg-opacity-30 z-50 h-screen max-h-screen flex justify-center items-center">
                <p class="text-xs text-blue-500 font-semibold animate-bounce">Sedang mengirim permintaan ...</p>
            </div>
        </template>
        <template x-if="popUpEmail">
            <div class="w-full bg-red-100 text-red-500 py-3 z-50 left-0 text-sm shadow-md fixed z-40 top-0" role="alert">
                <div class="container mx-auto">
                    <strong>Email aktif anda belum terdaftar di kami, permintaan anda tidak akan muncul pada notifikasi email kami !. Hubungi pemasaran untuk melengkapi data</strong>
                </div>
            </div>
        </template>
    </div>
@endsection
@section('script')
    <script src="{{ url('js/allocationtruck.js') }}" type="text/javascript"></script>
@endsection