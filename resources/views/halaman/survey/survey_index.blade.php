<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ asset('/css/survey.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.15/tailwind.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.min.css">
    
    <title>Customer Rating</title>
</head>
<body>
    <section>
    </section>
        <div class="container"><b>
            <p style="color:rgb(161, 161, 161)">{{$informations[0]->no_ppj}}</p>
            <p style="color:rgb(161, 161, 161)">{{$informations[0]->nama_jasa}}</p>
            <p style="color:rgb(161, 161, 161)">{{$informations[0]->nama_customer}}</p></b>
            <p style="color:rgb(161, 161, 161)">{{$informations[0]->vessel_name}}</p></b>
            <div class="bars">
                <div id="bars">
                    <div class="bar_container mt-auto">
                        <div id="main_container">
                        <div id="pbar" class="progress-pie-chart" data-percent="0">
                        <div class="ppc-progress">
                        <div class="ppc-progress-fill"></div>
                        </div>
                        <div class="ppc-percents">
                        <div class="pcc-percents-wrapper">
                        <span>0</span>
                        </div>
                        </div>
                        </div>
                </div>
            </div>
                </div>
            </div>
            
            <form action="{{ route('Update.rating',$informations[0]->id ) }}" method="POST" enctype="multipart/form-data" style="width: 100%" onsubmit="return sendpost()">
                @csrf
                <input type="hidden" name="overall_rating" id="overall_rating" value="0">

                <div class="rate" style="margin: auto">
                    @foreach ($list_item as $key => $item)
                    <input type="hidden" name="id_detail[]" id="" value="{{ $item->id }}">
                    <table style="width: 100%">
                        <tr>
                            <td style="text-align: left; vertical-align: bottom; "><b>{{$item->item_name}}</b></td>
                            <td class="right mr-0" rowspan="2"><div class="stars">
                                <input type="radio" id="five{{ $key }}" name="rate[{{$key}}]" value="5" onclick="getdata()">
                                <label for="five{{ $key }}"></label>    
                                <input type="radio" id="four{{ $key }}" name="rate[{{$key}}]" value="4" onclick="getdata()">
                                <label for="four{{ $key }}"></label>
                                <input type="radio" id="three{{$key}}" name="rate[{{$key}}]" value="3" onclick="getdata()">
                                <label for="three{{ $key }}"></label>
                                <input type="radio" id="two{{$key}}" name="rate[{{$key}}]" value="2" onclick="getdata()">
                                <label for="two{{ $key }}"></label>
                                <input type="radio" id="one{{$key}}" name="rate[{{$key}}]" value="1" onclick="getdata()">
                                <label for="one{{ $key }}"></label>
                            </div>
                        </td>
                        </tr>
                        <tr>
                            <td style="text-align:left;vertical-align: top; font-size: 15px;"><i>({{$item->item_detail}})</i></td>
                        </tr>
                    </table>
                    @endforeach
                    
                    
                </div>
                <div class="textarea mt-5">
                    <textarea name="coment" cols="30" placeholder="Leave a comment for out excellence service"></textarea>
                </div>
                <label for="file" class="flex justify-center text-center">
                    <div class="block text-center">
                        <img class="mx-auto cursor-pointer" src="https://img.icons8.com/external-kiranshastry-gradient-kiranshastry/64/000000/external-upload-interface-kiranshastry-gradient-kiranshastry.png"/>
                    </div>
                </label>
                <input type="file" id="file" name="upload" value="good" style="display:none">
                <div class="btn">
                    <button type="submit" >Post</button>
                </div>
            </form>
        </div>
        <br>

        @php
            $ttl = count($list_item);
        @endphp
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" ></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@7.12.15/dist/sweetalert2.all.min.js"></script>
        <script>
            function getdata() {
                const cars = {{$ttl}};
                var text = 0;

                for (let i = 0; i < cars; i++) {
                    variable = $("input[type='radio'][name='rate["+i+"]']:checked").val();
                    var x = (variable === undefined) ? 0 : variable;
                    
                    text += parseInt(x);
                }
                
                var ttl = text/25*100;
                ttl = ttl.toFixed(0);
                var html = `<div class="bar_container mt-auto">
                <div id="main_container">
                <div id="pbar" class="progress-pie-chart" data-percent="`+ttl+`">
                <div class="ppc-progress">
                <div class="ppc-progress-fill"></div>
                </div>
                <div class="ppc-percents">
                <div class="pcc-percents-wrapper">
                <span>`+ttl+`</span>
                </div>
                </div>
                </div>
            `;
                $("#bars").remove();
                $("#overall_rating").val(ttl);
                $(".bars").append('<div id="bars"></div>');
                $("#bars").html(html);
                
                value =ttl;

                $('.progress-value').html(value + '%');
                var $ppc = $('.progress-pie-chart'),
                    deg = 360 * value / 100;
                if (value > 50) {
                    $ppc.addClass('gt-50');
                }

                $('.ppc-progress-fill').css('transform', 'rotate(' + deg + 'deg)');
                $('.ppc-percents span').html(value );
                
            }

            function sendpost() {
                const cars = {{$ttl}};
                var text = 0;

                for (let i = 0; i < cars; i++) {
                    variable = $("input[type='radio'][name='rate["+i+"]']:checked").val();
                    var x = (variable === undefined) ? 0 : variable;
                    if (x == 0 ) {
                       swal("Mohon untuk dilengkapi", "", "warning");
                        return false;
                    }
                }
            }

            
        </script>
</body>
</html>