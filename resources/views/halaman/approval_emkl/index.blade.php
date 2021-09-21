@extends('index')

@section('title')
    Support System | EMKL
@endsection
@section('content')
    <section class="mt-6 px-5" x-data="approvalemkls()" x-init="init">
        <div class="mb-2 flex justify-end">
            <form class="flex" action="/cari_gto" method="POST">
                @csrf
                <input name="ppj" id="ppj" type="text" class="appearance-none border rounded w-full py-2 px-3 text-xs text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Cari PPJ..">
                <button type="submit" class="px-3 text-center uppercase flex items-center font-semibold bg-blue-400 text-xs text-white cursor-pointer"><p class="my-auto">cari</p></button>
            </form>
        </div>
        <table class="border-collapse table-auto w-full whitespace-no-wrap bg-white table-striped relative">
            <thead>
                <tr class="text-center rounded-md text-xs font-semibold bg-blue-200">
                    <th scope="col" class="py-1.5 px-2">No</th>
                    <th scope="col">Project No</th>
                    <th scope="col">Vessel</th>
                    <th scope="col">Consignee</th>
                    <th scope="col">Truck Qty</th>
                    <th scope="col">Commodity</th>
                    <th scope="col">Truck Type</th>
                    <th scope="col">Transportir</th>
                    <th scope="col" class="px-4">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($result as $key => $item)
                    <tr class="text-center hover:bg-blue-50 font-semibold">
                        <th class="py-1.5 border truncate text-xs border-dashed">{{$key + 1}}</th>
                        <th class="border truncate text-xs border-dashed">{{$item->project_no}}</th>
                        <th class="border truncate text-xs border-dashed">{{$item->vessel}}</th>
                        <th class="border truncate text-xs border-dashed">{{$item->consignee}}</th>
                        <th class="border truncate text-xs border-dashed">{{$item->truck_qty}}</th>
                        <th class="border truncate text-xs border-dashed">{{$item->commodity}}</th>
                        <th class="border truncate text-xs border-dashed">{{$item->truck_type}}</th>
                        <th class="border truncate text-xs border-dashed">{{$item->transportir}}</th>
                        <th class="border truncate grid grid-cols-2 gap-2 py-2 text-xs border-dashed px-2">
                            <div x-on:click='openPopupVerif({{$item}})' class="bg-indigo-900 w-full px-1.5 py-0.5 text-white text-xs text-center cursor-pointer rounded-sm"><p>Verif</p></div>
                            <div x-on:click='openPopupReject({{$item}})' class="bg-red-500 hover:bg-red-600 px-1.5 py-0.5 text-white text-xs text-center cursor-pointer rounded-sm">Reject</div>
                        </th>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <template x-if="popup">
            <div class="h-screen w-full flex items-center justify-center fixed top-0 z-50">
                <div class="flex w-2/6 border shadow-xl justify-center">
                    <div class="p-3 text-center bg-white rounded-md">
                        <p class="mb-3 font-semibold">Connfirmation !</p>
                        <div class="text-center"><span>Apakah anda yakin ingin melanjutkan validasi data ?. click kembali untuk membatalkan !</span></div>
                        <div class="mt-3 grid grid-cols-2 gap-3">
                            <template x-if="popup == 1">
                                <div x-on:click='Approved()' class="cursor-pointer bg-green-500 text-white font-semibold">Verif</div>
                            </template>
                            <template x-if="popup == 2">
                                <div x-on:click='Rejected()' class="cursor-pointer bg-green-500 text-white font-semibold">Rejected</div>
                            </template>
                            <div x-on:click='cancel()' class="cursor-pointer bg-red-500 text-white font-semibold">Batal</div>
                        </div>
                    </div>
                </div>
            </div>
        </template>
        <template x-if="showLoading">
            <div class="fixed top-0 left-0 right-0 bg-gray-500 bg-opacity-30 z-50 h-screen max-h-screen flex justify-center items-center">
                <p class="text-xs text-blue-500 font-semibold animate-bounce">Sedang mengirim permintaan ...</p>
            </div>
        </template>
    </section>
@endsection
@section('script')
    <script src="{{ url('js/emkl/approvalemkl.js') }}" type="text/javascript"></script>
@endsection