<style>
    h4{
        text-transform: uppercase;
        font-size: 13px;
        margin-bottom: 8px;
    },
    td{
        padding: 7px;
        text-align: left; 
        font-weight: 700;
    }
</style>
<section>
    <p style="font-style: normal">Yang Terhormat</p>
    @isset($nama_tujuan)
        <p style="text-transform: uppercase; font-weight: 700; margin-top: -8px;">{{$nama_tujuan}}</p>
        {{-- "pop up. mkl harap hubungi pemasaran" --}}
    @endisset
    @isset($nopol)
    {{-- bigbluebutton --}}
        <p style="font-style: normal; text-size: 12px;">Bersama dengan email ini, Saya <span style="font-weight: 700">{{$dari}}</span> mengirimkan permintaan 
            untuk menggunakan Truck dengan Nopol {{$nopol}}, adapun informasi detail pemakaian truck saat ini yaitu :</p>
    @endisset
    @isset($table)
        <table style="border-collapse: collapse; position: relative; font-size: 11px;">
            <thead>
                <tr>
                    <th style="padding: 7px; text-align: center; font-size: 11px; background-color: #023a6e; color: #fff;">Nopol</th>
                    <th style="padding: 7px; text-align: center; font-size: 11px; background-color: #023a6e; color: #fff;">Driver</th>
                    <th style="padding: 7px; text-align: center; font-size: 11px; background-color: #023a6e; color: #fff;">Valid From</th>
                    <th style="padding: 7px; text-align: center; font-size: 11px; background-color: #023a6e; color: #fff;">Valid Until</th>
                    <th style="padding: 7px; text-align: center; font-size: 11px; background-color: #023a6e; color: #fff;">Consignee</th>
                    <th style="padding: 7px; text-align: center; font-size: 11px; background-color: #023a6e; color: #fff;">Route</th>
                </tr>
            </thead>
            <tbody>
                <td style="font-size: 11px; text-align:center;">{{$table['Polisi']}}</td>
                <td style="font-size: 11px; text-align:center;">{{$table['Driver']}}</td>
                <td style="font-size: 11px; text-align:center;">{{$table['Active_date']}}</td>
                <td style="font-size: 11px; text-align:center;">{{$table['End_date']}}</td>
                <td style="font-size: 11px; text-align:center;">{{$table['consigne']}}</td>
                <td style="font-size: 11px; text-align:center;">{{$table['routes']}}</td>
            </tbody>
        </table>
        <div style="margin-top: 12px; font-size: 13px; display: block;">
            @isset($link)
                <span>Click tautan dibawah ini untuk pergi ke halaman approval</span>
                <a href="{{url($link)}}">{{url($link)}}</a>
            @endisset
            @isset($link_mkl)
                <span>Click tautan dibawah ini untuk pergi ke halaman approval</span>
                <a href="{{url( $link_mkl)}}">{{url( $link_mkl )}}</a>
            @endisset
        </div>
    @endisset

    @isset($table_emkl)
    {{-- bigbluebutton --}}
        <p style="font-style: normal; text-size: 12px;">Bersama dengan email ini, permintaan anda
            untuk PPJ {{$table_emkl['Project_No']}}, {{$pesan}} adapun informasi detail anda yaitu :</p>
    @endisset
    @isset($table_emkl)
        <table style="border-collapse: collapse; position: relative; font-size: 11px;">
            <thead>
                <tr>
                    <th style="padding: 7px; text-align: center; font-size: 11px; background-color: #023a6e; color: #fff;">Project No</th>
                    <th style="padding: 7px; text-align: center; font-size: 11px; background-color: #023a6e; color: #fff;">Vessel</th>
                    <th style="padding: 7px; text-align: center; font-size: 11px; background-color: #023a6e; color: #fff;">Consignee</th>
                    <th style="padding: 7px; text-align: center; font-size: 11px; background-color: #023a6e; color: #fff;">Truck Qty</th>
                    <th style="padding: 7px; text-align: center; font-size: 11px; background-color: #023a6e; color: #fff;">Commodity</th>
                    <th style="padding: 7px; text-align: center; font-size: 11px; background-color: #023a6e; color: #fff;">Truck Type</th>
                    <th style="padding: 7px; text-align: center; font-size: 11px; background-color: #023a6e; color: #fff;">Transportir</th>
                </tr>
            </thead>
            <tbody>
                <td style="font-size: 11px; text-align:center;">{{$table_emkl['Project_No']}}</td>
                <td style="font-size: 11px; text-align:center;">{{$table_emkl['Vessel']}}</td>
                <td style="font-size: 11px; text-align:center;">{{$table_emkl['Consignee']}}</td>
                <td style="font-size: 11px; text-align:center;">{{$table_emkl['Truck_Qty']}}</td>
                <td style="font-size: 11px; text-align:center;">{{$table_emkl['Commodity']}}</td>
                <td style="font-size: 11px; text-align:center;">{{$table_emkl['Truck_Type']}}</td>
                <td style="font-size: 11px; text-align:center;">{{$table_emkl['Transportir']}}</td>
            </tbody>
        </table>
    @endisset
    @isset($gto_approved)
        <p>{{$gto_approved}}</p>
    @endisset
</section>