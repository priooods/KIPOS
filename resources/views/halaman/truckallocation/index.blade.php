@extends('index')

@section('title')
    Support System
@endsection
@section('content')
    <section class="mt-6 px-5">
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
                            <a href="/allocation/{{base64_encode($item->id)}}" 
                                class="px-2 py-0.5 hover:text-white bg-blue-600 rounded-sm text-white hover:bg-blue-600">views</a>
                        </th>
                    </tr>
                @endforeach
            </tbody>
            </table>
    </section>
@endsection