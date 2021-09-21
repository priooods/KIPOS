<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/css/fontawesome.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/css/all.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.15/tailwind.min.css">
    <title>
        @yield('title')
    </title>
</head>
<body>
    <section class="navigate sticky top-0 w-full z-30">
        <div class="bg-indigo-900 text-white p-2 ">
            <div class="container mx-auto">
                <div class="text-xs flex justify-start">
                    <h4>Krakatau Bandar Samudera</h4>
                    <div class="ml-auto flex my-auto">
                        @if (Session::get('users'))
                            <p>{{Session::get('users')->realname}}</p>
                        @endif
                        <a href="/index/call_logout" class="text-blue-100 ml-2 my-auto hover:text-red-500 uppercase">logout</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-gray-100 py-1">
            <div class="flex container mx-auto text-xs font-semibold justify-start">
                {{-- <a href="/" class="hover:text-gray-700">Home</a> --}}
                <a href="/allocation" class="hover:text-black text-gray-500">Truck Allocation</a>
                <a href='/approval/gto/{{Session::getId()}}' class="hover:text-black text-gray-500 ml-3">Approval GTO</a>
                @if (session('customer'))
                    <a href="/emkls/{{Session::getId()}}/{{base64_encode(session('customer')->id)}}/{{base64_encode(session('mkl_id'))}}" class="hover:text-black text-gray-500 ml-3">Approval EMKL</a>
                @endif
                <a href='/survey' class="hover:text-black text-gray-500 ml-3">Survey</a>
            </div>
        </div>
    </section>
    @yield('content')
</body>
<script src="https://rawgit.com/moment/moment/2.2.1/min/moment.min.js"></script>
{{-- SELECT * FROM t_truck_allocations a WHERE a.m_trucks_id = 5 ORDER BY a.id DESC LIMIT 10 --}}
<script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.2/dist/alpine.min.js" defer></script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.min.js" integrity="sha384-skAcpIdS7UcVUC05LJ9Dxay8AXcDYfBJqt1CJ85S/CFujBsIzCIv+l9liuYLaMQ/" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
    @yield('script')
</html>