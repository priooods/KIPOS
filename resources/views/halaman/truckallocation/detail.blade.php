@extends('index')

@section('content')
    <div class="details container mx-auto" x-data="details()" x-init="init">
        <div class="information mt-6 p-4 border">
            <div class="info-umum">
                <h3 class="font-bold text-sm uppercase">information Umum</h3>
                <div class="grid grid-cols-1 text-xs mt-3 md:grid-cols-3 gap-2">
                    <div class="grid-cols-2 grid shadow-xl">
                        <div class="text-white bg-indigo-900 py-1 flex items-center justify-center"><p>Project No</p></div>
                        <div class="py-1 border text-center flex justify-center items-center"><p>{{$detail->project_no}}</p></div>
                    </div>
                    <div class="grid-cols-2 grid shadow-xl">
                        <div class="text-white bg-indigo-900 py-1 flex items-center justify-center"><p>Vessel</p></div>
                        <div class="py-1 border text-center flex justify-center items-center"><p>{{$detail->vessel}}</p></div>
                    </div>
                    <div class="grid-cols-2 grid shadow-xl">
                        <div class="text-white bg-indigo-900 py-1 flex items-center justify-center"><p>Consignee</p></div>
                        <div class="py-1 border text-center flex justify-center items-center"><p>{{$detail->consignee}}</p></div>
                    </div>
                    <div class="grid-cols-2 grid shadow-xl">
                        <div class="text-white bg-indigo-900 py-1 flex items-center justify-center"><p>Truck Qty</p></div>
                        <div class="py-1 border text-center flex justify-center items-center"><p>{{$detail->truck_qty}}</p></div>
                    </div>
                    <div class="grid-cols-2 grid shadow-xl">
                        <div class="text-white bg-indigo-900 py-1 flex items-center justify-center"><p>Commodity</p></div>
                        <div class="py-1 border text-center flex justify-center items-center"><p>{{$detail->commodity}}</p></div>
                    </div>
                    <div class="grid-cols-2 grid shadow-xl">
                        <div class="text-white bg-indigo-900 py-1 flex items-center justify-center"><p>Truck Type</p></div>
                        <div class="py-1 border text-center flex justify-center items-center"><p>{{$detail->truck_type}}</p></div>
                    </div>
                    <div class="grid-cols-2 grid shadow-xl">
                        <div class="text-white bg-indigo-900 py-1 flex items-center justify-center"><p>Transportir</p></div>
                        <div class="py-1 border text-center flex justify-center items-center"><p>{{$detail->transportir}}</p></div>
                    </div>
                </div>
            </div>
        </div>

        <section class="mt-8">
            <div class="px-2.5 py-1.5 bg-gray-200 inline-flex text-gray-800 text-xs"><span>Add Form Truck</span></div>
            <div class="add-form p-4 container mx-auto border">
                <form class="mt-2">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 md:gap-x-12">
                        <div class="flex flex-col gap-2 mb-2">
                            <div class="flex-none grid md:grid-cols-4 gap-2 md:gap-4 form-group">
                                <label class="text-xs font-sans font-semibold my-auto" for="m_trucks_id">
                                    <span>Police Number</span>
                                    <span class="text-red-600">*</span>
                                </label>
                                <div class="col-span-3 flex">
                                    <div class="relative flex-1">
                                        <input x-model="police" type="text" class="appearance-none border-t border-l border-b rounded-tl rounded-bl w-full py-2 px-3 text-xs text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Police Number..">
                                        <template x-if="police_box && police">
                                            <div class="absolute top-9 z-20 w-full py-1 border-b border-r border-l text-xs bg-white" >
                                                <template x-for="item in list">
                                                    <p x-on:click="selectPolice(item.id,item.nopol,item.exp_date)" class="px-2 cursor-pointer py-0.5 hover:bg-blue-100" x-text="item.nopol"></p>
                                                </template>
                                            </div>
                                        </template>
                                    </div>
                                    <input x-model="expire_date" type="text" readonly class="flex-1 appearance-none border rounded-tr rounded-br bg-gray-100 text-center border cursor-not-allowed w-full py-2 text-xs text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Expire Date">
                                    {{-- <div id="btn_add" x-on:click="add_nopol()" class="flex-none bg-indigo-900 cursor-pointer inline-flex rounded-full text-white px-2.5 rounded-sm text-xs">
                                        <span class="text-xl">+</span>
                                    </div> --}}
                                </div>
                            </div>
                            <div class="grid md:grid-cols-4 flex-grow">
                                <div class="md:col-start-2 md:col-end-5 border rounded-sm bg-gray-100 px-2 py-1.5 w-full">
                                    <template x-for="(item,i) in list_nopol">
                                        <div class="inline-flex border rounded-md w-full pl-3 pr-1 mt-1 py-1 text-xs leading-tight bg-white shadow-sm">
                                            <div class="grid grid-cols-2 my-auto">
                                                <div x-text="item.nopol"></div>
                                                <div class="flex">
                                                    <div class="text-gray-400 mr-1">Exp. </div>
                                                    <div x-text="item.exp"> 2020-11-10 </div>
                                                </div>
                                            </div>
                                            <div class="ml-auto text-lg leading-none mb-1 px-2 text-gray-500 hover:text-red-600 cursor-pointer"
                                                 x-on:click="remove_nopol(i)">x</div>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 gap-y-2 flex-none">
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-2 md:gap-4 form-group">
                                <label class="text-xs font-sans font-semibold my-auto" for="consignee">
                                    <span>Consignee</span>
                                    <span class="text-red-600">*</span>
                                </label>
                                <div class="col-span-3 grid grid-cols-1 md:grid-cols-1 gap-2">
                                    <div class="inline-flex">
                                        <input value="{{$detail->consignee}}" type="text" readonly  class="appearance-none border truncate cursor-not-allowed bg-gray-100 border rounded w-full py-2 px-3 text-xs text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Description..">
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
                                <label class="text-xs font-sans font-semibold my-auto" for="valid_until">
                                    <span>Valid Until</span>
                                    <span class="text-red-600">*</span>
                                </label>
                                <div class="col-span-3 w-full relative">
                                    <input x-model="form.active_end" type="date" id="end_dats" class="appearance-none border rounded bg-white w-full py-2 px-3 text-xs text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Valid end.." name="active_end">
                                    <span class="absolute bg-white w-3/6 left-4 text-xs top-2.5" id="hide_end"></span>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-2 md:gap-4 form-group">
                                <label class="text-xs font-sans font-semibold my-auto" for="valid_form">
                                    <span>Valid Form</span>
                                    <span class="text-red-600">*</span>
                                </label>
                                <div class="col-span-3 w-full relative">
                                    <input x-model="form.active_start" id="form_dats" type="date" class="appearance-none border rounded bg-white w-full py-2 px-3 text-xs text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Valid form.." name="active_start">
                                    <span class="absolute bg-white w-3/6 left-4 text-xs top-2.5" id="hide_from"></span>
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
                        </div>
                    </div>
                    <div id="btn_submit" x-on:click="sending()" class="bg-indigo-900 cursor-pointer mt-6 inline-flex text-white px-3 py-1 rounded-sm text-xs">Simpan</div>
                    <template x-if="list_nopol.length > 0">
                        {{-- <div class="text-right"> --}}
                            <div id="btn_submit" x-on:click="list_nopol = []" class="bg-red-500 cursor-pointer inline-flex text-white px-3 py-1 rounded-sm text-xs">Hapus List Truck</div>
                        {{-- </div> --}}
                    </template>
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
                    <template x-if="validation == 3">
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
    <script src="{{ url('js/emkl/allocationtruck.js') }}" type="text/javascript"></script>
@endsection
