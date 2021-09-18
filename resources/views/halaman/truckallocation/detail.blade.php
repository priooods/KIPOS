@extends('index')

@section('content')
    <div class="details container mx-auto">
        <div class="information mt-6 p-4 border">
            <div class="info-umum">
                <h3 class="font-bold text-sm uppercase">information Umum</h3>
                <div class="grid grid-cols-1 text-xs mt-3 md:grid-cols-3 gap-2">
                    <div class="grid-cols-2 grid shadow-xl">
                        <div class="bg-indigo-900 text-white py-1 flex items-center justify-center"><p>Project No</p></div>
                        <div class="py-1 border text-center flex justify-center items-center"><p>{{$detail->project_no}}</p></div>
                    </div>
                    <div class="grid-cols-2 grid shadow-xl">
                        <div class="bg-indigo-900 text-white py-1 flex items-center justify-center"><p>Vessel</p></div>
                        <div class="py-1 border text-center flex justify-center items-center"><p>{{$detail->vessel}}</p></div>
                    </div>
                    <div class="grid-cols-2 grid shadow-xl">
                        <div class="bg-indigo-900 text-white py-1 flex items-center justify-center"><p>Consignee</p></div>
                        <div class="py-1 border text-center flex justify-center items-center"><p>{{$detail->consignee}}</p></div>
                    </div>
                    <div class="grid-cols-2 grid shadow-xl">
                        <div class="bg-indigo-900 text-white py-1 flex items-center justify-center"><p>Truck Qty</p></div>
                        <div class="py-1 border text-center flex justify-center items-center"><p>{{$detail->truck_qty}}</p></div>
                    </div>
                    <div class="grid-cols-2 grid shadow-xl">
                        <div class="bg-indigo-900 text-white py-1 flex items-center justify-center"><p>Commodity</p></div>
                        <div class="py-1 border text-center flex justify-center items-center"><p>{{$detail->commodity}}</p></div>
                    </div>
                    <div class="grid-cols-2 grid shadow-xl">
                        <div class="bg-indigo-900 text-white py-1 flex items-center justify-center"><p>Truck Type</p></div>
                        <div class="py-1 border text-center flex justify-center items-center"><p>{{$detail->truck_type}}</p></div>
                    </div>
                    <div class="grid-cols-2 grid shadow-xl">
                        <div class="bg-indigo-900 text-white py-1 flex items-center justify-center"><p>Transportir</p></div>
                        <div class="py-1 border text-center flex justify-center items-center"><p>{{$detail->transportir}}</p></div>
                    </div>
                </div>
            </div>
        </div>

        <section class="mt-8">
            <div class="px-2.5 py-1.5 bg-gray-200 inline-flex text-gray-800 text-xs"><span>Add Form Truck</span></div>
            <div class="add-form p-4 container mx-auto border">
                <form class="mt-2" x-data="forms()" x-init="init">
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
                            <div class="col-span-3 grid grid-cols-1 md:grid-cols-2 gap-2">
                                <div class="relative">
                                    <input x-model="consignee" type="text" class="appearance-none border rounded w-full py-2 px-3 text-xs text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Code..">
                                    <template x-if="consignee_box && consignee">
                                        <div class="absolute top-9 z-20 w-full py-1 border-b border-r border-l text-xs bg-white">
                                            <template x-for="item in list">
                                                <p x-on:click="selectConsigne(item.id,item.code,item.name)" class="px-2 cursor-pointer py-0.5 hover:bg-blue-100" x-text="item.code"></p>
                                            </template>
                                        </div>
                                    </template>
                                </div>
                                <div class="inline-flex">
                                    <p class="font-bold my-auto mr-1.5">-</p>
                                    <input x-model="desc_consignee" type="text" readonly  class="appearance-none border truncate cursor-not-allowed bg-gray-100 border rounded w-full py-2 px-3 text-xs text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Description..">
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
                            <div class="col-span-3 w-full">
                                <input x-model="form.active_end" type="date" value="" class="appearance-none border rounded w-full py-2 px-3 text-xs text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Valid end.." name="active_end">
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-2 md:gap-4 form-group">
                            <label class="text-xs font-sans font-semibold my-auto" for="valid_form">
                                <span>Valid Form</span>
                                <span class="text-red-600">*</span>
                            </label>
                            <div class="col-span-3 w-full">
                                <input x-model="form.active_start" type="date" value="" class="appearance-none border rounded w-full py-2 px-3 text-xs text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Valid form.." name="active_start">
                            </div>
                        </div>
                    </div>
                    <div id="btn_submit" x-on:click="sending()" class="bg-indigo-900 cursor-pointer mt-6 inline-flex text-white px-3 py-1 rounded-sm text-xs">Simpan</div>
                    <template x-if="validation">
                        <div :class="validation ? 'transition duration-700 ease-in-out' : ''" class="bg-red-100 text-red-500 w-full py-3 left-0 text-sm shadow-md fixed top-0" role="alert">
                            <div class="container mx-auto">
                                <strong>Form anda tidak valid !</strong>
                            </div>
                        </div>
                    </template>
                </form>
            </div>
        </section>

        @yield('table-detail')
    </div>
@endsection

@section('script')
    <script src="{{ url('js/formalocation.js') }}" type="text/javascript"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
@endsection