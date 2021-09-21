@extends('index')

@section('content')
    <div class="details container mx-auto" x-data="detail_gto()" x-init="init">
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
        @include('halaman.approval_gto.table_gto')
        
        <template x-if="showLoading">
            <div class="fixed top-0 left-0 right-0 bg-gray-500 bg-opacity-30 z-50 h-screen max-h-screen flex justify-center items-center">
                <p class="text-xs text-blue-500 font-semibold animate-bounce">Sedang mengirim permintaan ...</p>
            </div>
        </template>
    </div>
@endsection
@section('script')
    <script src="{{ url('js/approvalgto.js') }}" type="text/javascript"></script>
@endsection