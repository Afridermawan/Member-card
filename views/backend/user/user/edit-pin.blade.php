@extends('backend.user.templates.default')

@section('content')

<div class="container">
  @include('backend.user.templates.partials.alerts')
  <div class="row">
    <form class="col s12 center" action="{{ $base_url }}/web/pin/edit" method="post">
        <div class="input-field col s12">
          <input value="{{ $data->pin }}" name="pin" id="pin" type="text" class="validate">
          <label for="pin">PIN</label>
        </div>
      <div class="card-action center-align">
        <button class="btn waves-effect waves-light" type="submit" name="action">Edit
        </button>
      </div>
    </form>
  </div>
</div>
@endsection
