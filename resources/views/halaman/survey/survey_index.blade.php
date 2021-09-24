<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ asset('/css/survey.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.15/tailwind.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
    <title>Support System</title>
</head>
<body>
    <section>
        <h1 style="padding: 5px; background-color:white">Halaman Survey</h1>
    </section>
        <div class="container">
            <p>{{$informations[0]->no_ppj}}</p>
            <p>{{$informations[0]->nama_jasa}}</p>
            <p>{{$informations[0]->nama_customer}}</p>
            <form action="{{ route('Update.rating',$informations[0]->id ) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="text-center justify-center flex">
                    <div class="stars">
                        <input type="radio" id="five" name="rate" value="5">
                        <label for="five"></label>
                        <input type="radio" id="four" name="rate" value="4">
                        <label for="four"></label>
                        <input type="radio" id="three" name="rate" value="3">
                        <label for="three"></label>
                        <input type="radio" id="two" name="rate" value="2">
                        <label for="two"></label>
                        <input type="radio" id="one" name="rate" value="1">
                        <label for="one"></label>
                    </div>
                </div>
                <div class="rate mt-6">
                    @foreach ($list_item as $key => $item)
                    <input type="hidden" name="id_detail[]" id="" value="{{ $item->id }}">
                    <div class="mt-2 grid grid-cols-5 gap-1">
                        <p class="mr-8 col-span-2">{{$item->item_name}}</p>
                        <input type="radio" id="good1{{$key}}" checked="checked" name="pa[{{ $key }}]" value="good">
                        <label for="good1{{$key}}" style="background-color: rgb(20, 163, 20);">Good</label>
                        <input type="radio" id="good2{{$key}}" name="pa[{{ $key }}]" value="No Good">
                        <label for="good2{{$key}}" style="background-color: rgb(255, 0, 0);">No Good</label>
                        <input type="radio" id="good3{{$key}}" name="pa[{{ $key }}]" value="No Comment">
                        <label for="good3{{$key}}" style="background-color: black;">No Comment</label>
                    </div>
                    @endforeach
                    
                    
                </div>
                <div class="textarea mt-10">
                    <textarea name="coment" cols="30" placeholder="Leave a comment for out excellence service"></textarea>
                </div>
                <label for="file" class="flex justify-center text-center">
                    <div class="block text-center">
                        <img class="mx-auto cursor-pointer" src="https://img.icons8.com/external-kiranshastry-gradient-kiranshastry/64/000000/external-upload-interface-kiranshastry-gradient-kiranshastry.png"/>
                        <p>Upload Image</p>
                    </div>
                </label>
                <input type="file" id="file" name="upload" value="good" style="display:none">
                <div class="btn">
                    <button type="submit">Post</button>
                </div>
            </form>
        </div>
</body>
</html>