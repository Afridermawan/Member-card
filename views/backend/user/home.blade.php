@extends('backend.user.templates.default')

@section('content')

    <style>
    table {
        padding: 10px 40px; 
        background: #EEEEEE;
        width: 300px;
        border-radius: 25px;
        box-shadow: 2px 2px 4px #000000;
    }
    </style>   
    
<div class="container">
    <div class="row">
        <table style="margin: 0 auto;">
            <tr style="border-bottom: 1px solid black;">
                <th style="text-align: center;">
                    <span style="font-family: Trebuchet, sans-serif;font-size: 20px;color: black">Member-Card</span>
                </th>
                <th style="text-align: center;">
                    <span style="font-family: Trebuchet, sans-serif;font-size: 20px;color: black">Data Pribadi</span>
                </th>
                <th style="text-align: center;">
                    <span style="font-family: Trebuchet, sans-serif;font-size: 20px;color: black">QR-Code</span>
                </th>
            </tr>
            <tr>
                <td>
                    <img src="{{ $session->image }}" style="width: 200px;height: 200px">
                </td>
                <td>
                    <span style="font-family: Arial, Trebuchet , Trebuchet, sans-serif;font-size: 15px;">
                        <b>
                        
                            {{ $session->username }}<br><br>
                            {{ $session->phone }}<br><br>
                            {{ $session->email }}<br> 
                        </b>
                    </span>
                </td>
                <td>
                    <img src="{{ $session->code }}" 
                    style="width: 200px;height: 200px"> 
                </td>
            </tr>
        </table>
        <div class="icons">
            <a href="{{ $base_url }}/web/article"><i title="Artikel" class="large material-icons hoverable">toc</i></a>
            <a href="{{ $base_url }}/web/produk/list"><i title="Belanja" class="large material-icons hoverable">shopping_cart</i></a>
            <a href="{{ $base_url }}/web/event/list"><i title="Event" class="large material-icons hoverable">event</i></a>
            <a href="{{ $base_url }}/web/donation-news/list""><i title="Berita Donasi" class="large material-icons hoverable">people_outline</i></a>
        </div>
        <style> 
        .icons i{
            background: #fff;
            padding: 12px;
            margin:26px;
            margin-top:80px;
            color:#ee6e73
        }
        </style>
    </div>
</div>
    {{-- </div> --}}
@endsection
