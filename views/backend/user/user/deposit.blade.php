@extends('backend.user.templates.default')
@section('custom_script')
<script>

  $(document).ready(function() {
    $('select').material_select();
  });
</script>
@endsection
@section('content')
{{ dd($payment_method->data[0]->id) }}
<div class="container">
  <div class="row">
    <form class="col s12" action="{{ $base_url }}/web/deposit/kredit" method="post">
      <div class="row">
        <div class="input-field col s12">
          <input value="{{$session->username}}" name="username" id="name" type="text" class="validate">
          <label for="username">username</label>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s12">
          <input value="{{$session->email}}" name="email" id="email" type="email" class="validate">
          <label for="email">Email</label>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s12">
          <input value="{{$session->phone}}" name="phone" id="phone" type="text" class="validate">
          <label for="phone">No.telepon</label>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s12">
          <select name="payment_method">
              @foreach ($payment_method->data as $payment)
                  <option value="{{$payment->id}}">{{ $payment->name }}</option>
              @endforeach
          </select>
          <label>Jenis pembayaran</label>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s12">
          <input name="total" id="total" type="number" class="validate">
          <label for="total">Jumlah</label>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s12">
          <textarea class="materialize-textarea" name="description" data-length="120"></textarea>
          <label for="address">Deskripsi</label>
        </div>
      </div>
      <div class="card-action center-align">
        <button class="btn waves-effect waves-light" type="submit" name="action">Deposit
        </button>
      </div>
    </form>
  </div>
</div>
@endsection
