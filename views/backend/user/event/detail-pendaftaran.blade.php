@extends('backend.user.templates.default')

@section('content')

  <div class="container">
    <div class="row">
    <div class="col s12 m12">
    <div class="card horizontal">
      <div class="card-image">
        <img src="{{ $event->image }}" style="width: 200px;height: 200px">
      </div>
      <div class="card-stacked">
        <div class="card-content">
          <p>
            Name :<span style="float: right;">{{ $event->name }}</span> <br>
            Biaya Pendaftaran :<span style="float: right;"> {{ $event->biaya_pendaftaran }}</span><br>
            kuantitas :<span style="float: right;"> {{ $event->kuantitas }}</span>
          </p>
          <hr>
          <p>
            Total :<span style="float: right;"> {{ $event->total_harga }}</span>
          </p>
        <div class="card-action">
          <a href="{{ $base_url }}/web/event/bayar"><i class="material-icons">payment</i> &nbsp Lanjutkan Pembayaran</a>
        </div>
      </div>
    </div>
  </div>
  </div>
  </div>  
@endsection
