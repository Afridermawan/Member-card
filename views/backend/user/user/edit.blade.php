@extends('backend.user.templates.default')
@section('custom_script')
<script>
  
  $(document).ready(function() {
    $('select').material_select();
  });
</script>
@endsection
@section('content')

<div class="container">
  <div class="row">
    <form class="col s12" action="{{ $base_url }}/web/user/edit/{{ $session->id }}/profile" method="post">
      <div class="row">
        <div class="input-field col s12">
          <input value="{{ $session->username }}" name="username" id="username" type="text" class="validate">
          <label for="username">Username</label>
        </div>
        <div class="input-field col s12">
          <input value="{{ $session->name }}" name="name" id="name" type="text" class="validate">
          <label for="name">name</label>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s12">
          <input value="{{ $session->email }}" name="email" id="email" type="email" class="validate">
          <label for="email">Email</label>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s12">
          <input value="{{ $session->phone }}" name="phone" id="phone" type="text" class="validate">
          <label for="phone">No.telepon</label>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s12">
          <textarea class="materialize-textarea" name="address" data-length="120">{{ $session->address }}</textarea>
          <label for="address">Alamat</label> 
        </div>
      </div>
      <div class="row">  
        <div class="input-field col s12">
          <select name="gender">
            <option value="Laki-laki" @if ( $session->gender == Laki-laki ) selected="selected" @endif>Laki-laki</option>
            <option value="Perempuan" @if ( $session->gender == Perempuan ) selected="selected" @endif>Perempuan</option>
          </select>
          <label>Jenis Kelamin</label>
        </div>
      </div>
      <div class="card-action center-align">
        <button class="btn waves-effect waves-light" type="submit" name="action">Edit
        </button>
      </div>
    </form>
  </div>
</div>
@endsection
