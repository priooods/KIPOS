@extends('index')

@section('content')
    <div class="details container mx-auto" x-data="approvalemkls()" x-init="init">
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
        @if (count($dipakai) > 0)
            <div class="my-8">
                <p>Truck saat ini.</p>
                <table class="border-collapse table-fixed w-full whitespace-no-wrap bg-white table-striped relative">
                    <thead>
                        <tr class="text-center rounded-md text-xs font-semibold bg-blue-200">
                            <th class="border text-xs border-dashed py-1.5 w-1/4">No</th>
                            <th class="border text-xs border-dashed w-2/4">Nomor Polisi</th>
                            <th class="border text-xs border-dashed w-2/4">Project No</th>
                            <th class="border text-xs border-dashed w-2/4">Vessel Name</th>
                            <th class="border text-xs border-dashed w-2/4">Consignee</th>
                            <th class="border text-xs border-dashed w-2/4">Destination</th>
                            <th class="border text-xs border-dashed w-2/4">Commodity</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dipakai as $key => $item)
                            <tr class="text-center hover:bg-blue-50 font-semibold">
                                <th class="py-1.5 border truncate text-xs border-dashed">{{$key + 1}}</th>
                                <th class="border truncate text-xs border-dashed">{{$item->mkl_dipakai->trucks->nopol}}</th>
                                <th class="border truncate text-xs border-dashed">{{$item->mkl_dipakai->header_project->project_no}}</th>
                                <th class="border truncate text-xs border-dashed">{{$item->mkl_dipakai->header_project->vesel_scehedule->vesel_data->name}}</th>
                                <th class="border truncate text-xs border-dashed">{{$item->mkl_dipakai->detail_emkls->customer_data->name}}</th>
                                <th class="border truncate text-xs border-dashed">{{$item->destination}}</th>
                                <th class="border truncate text-xs border-dashed">{{$item->mkl_dipakai->commodity->desc}}</th>
                            </tr>
                        @endforeach
                    </tbody>
                    </table>
            </div>
        @endif
        @include('halaman.approval_emkl.table_emkl')
    </div>
@endsection
@section('script')
    <script src="{{ url('js/emkl/approvalemkl.js') }}" type="text/javascript"></script>
@endsection