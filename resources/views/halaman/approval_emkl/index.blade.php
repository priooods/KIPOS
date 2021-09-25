@extends('index')

@section('title')
    Support System | EMKL
@endsection
@section('content')
    <section class="mt-6 px-5">
        <div class="mb-2 flex justify-end">
            <form class="flex" action="/cari_mkl" method="POST">
                @csrf
                <input name="transportir" id="transportir" type="text" class="appearance-none border rounded w-full py-2 px-3 text-xs text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Cari transportir..">
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
                        <th class="border truncate py-2 text-xs border-dashed">
                            <a href="/mkl/detail/{{Session::getId()}}/{{base64_encode($item->id)}}" 
                                class="px-2 py-0.5 hover:text-white bg-blue-600 rounded-sm text-white hover:bg-blue-600">views</a>
                        </th>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </section>
@endsection
@section('script')
    <script src="{{ url('js/emkl/approvalemkl.js') }}" type="text/javascript"></script>
@endsection