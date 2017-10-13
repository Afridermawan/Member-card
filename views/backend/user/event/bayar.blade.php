@extends('backend.user.templates.default')

@section('content')

    <div class="container">
    <div class="row">
    <div class="col s12 m12">
    <div class="card horizontal">
      <div class="card-image">
        <img src="{{ $base_url }}/assets/img/bri.png" style="width: 200px;height: 200px">
      </div>
      <div class="card-stacked">
        <div class="card-content">
          <p>
            Bank :<span style="float: right;">BRI Syariah</span><br>
            No.Rekening :<span style="float: right;">99987613232423423</span> <br>
            Atas Nama :<span style="float: right;">Afri dermawan ginting</span><br>
          </p>
          <hr>
      </div>
    </div>
  </div>
  </div>
  </div>
  </div> 

    <div class="container">
    <div class="row">
    <div class="col s12 m12">
    <div class="card horizontal">
      <div class="card-image">
        <img src="{{ $base_url }}/assets/img/brisyariah.png" style="width: 200px;height: 200px">
      </div>
      <div class="card-stacked">
        <div class="card-content">
          <p>
            Bank :<span style="float: right;">BRI</span><br>
            No.Rekening :<span style="float: right;">99987613232423423</span> <br>
            Atas Nama :<span style="float: right;">Afri dermawan ginting</span><br>
          </p>
          <hr>
      </div>
    </div>
  </div>
  </div>
  </div>  
<div class="container">
  <div class="row">
    <div class="card-content right">
      <a href="{{ $base_url }}/web/event/list"><i class="material-icons">reply</i> &nbsp Selesaikan Pembayaran</a>
    </div>
  </div>
</div>  
@endsection
