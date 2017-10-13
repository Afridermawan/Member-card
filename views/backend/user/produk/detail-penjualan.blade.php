@extends('backend.user.templates.default')

@section('content')

  <div class="container">
    <div class="row">
    <div class="col s12 m12">
    <div class="card horizontal">
      <div class="card-image">
        <img src="{{ $produk->image }}" style="width: 200px;height: 200px">
      </div>
      <div class="card-stacked">
        <div class="card-content">
          <p>
            Name :<span style="float: right;">{{ $produk->name }}</span> <br>
            Harga :<span style="float: right;"> {{ $produk->harga }}</span><br>
            kuantitas :<span style="float: right;"> {{ $produk->kuantitas }}</span>
          </p>
          <hr>
          <p>
            Total :<span style="float: right;"> {{ $produk->total_harga }}</span>
          </p>
        <div class="card-action">
          <a href="{{ $base_url }}/web/produk/bayar"><i class="material-icons">payment</i> &nbsp Lanjutkan Pembayaran</a>
        </div>
      </div>
    </div>
  </div>
  </div>
  </div>  
@endsection
