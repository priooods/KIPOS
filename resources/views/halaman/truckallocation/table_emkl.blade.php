@extends('index')


@section('table-detail')
    <section class="mt-6">
        <table class="table table-striped">
            @if($list)
                <thead class="font-semibold text-sm">
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Nomor Polisi</th>
                        <th scope="col">Driver</th>
                        <th scope="col">Ritase</th>
                        <th scope="col">Valid From</th>
                        <th scope="col">Valid Until</th>
                        <th scope="col">Consignee</th>
                        <th scope="col">Route</th>
                        <th scope="col">Status Request</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
            @endif
            <tbody>
                @foreach ($list as $key => $item)
                    <tr class="text-xs font-sans">
                        <th>{{$key + 1}}</th>
                        <th>{{$item->mobil->nopol}}</th>
                        <th>{{$item->driver->name}}</th>
                        <th>{{$item->ritase}}</th>
                        <th>{{$item->active_start}}</th>
                        <th>{{$item->active_end}}</th>
                        <th>{{$item->consigne->name}}</th>
                        <th>{{$item->route->description}}</th>
                        <th>
                            @switch($item->status_request)
                                @case(0)
                                    Belum Dikirim
                                @break
                                @case(1)
                                    Available
                                @break
                                @case(2)
                                    Non Available
                                @break
                                @case(3)
                                    Approved by GTO 
                                @break
                                @case(4)
                                    Rejected by GTO
                                @break
                                @case(5)
                                    Approved by EMKL
                                @break
                                @case(6)
                                    Rejected by EMKL
                                @break
                            @endswitch
                        </th>
                        <th>
                            <div class="flex">
                                <form action="{{ route('send_request_emkls') }}" method="post">
                                    @csrf
                                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 px-1.5 py-0.5 text-white text-xs text-center cursor-pointer rounded-sm">
                                        Send
                                    </button>
                                </form>
                                <div class="bg-red-500 hover:bg-red-600 ml-1 px-1.5 py-0.5 text-white text-xs text-center cursor-pointer rounded-sm">
                                    <a href="{{ route('delete_emkl', $item->id) }}" class="px-1 hover:text-white mb-2 mt-1">Delete</a>
                                </div>
                            </div>
                        </th>
                    </tr>
                @endforeach
            </tbody>
            </table>
    </section>
@endsection
@include('halaman.truckallocation.detail')