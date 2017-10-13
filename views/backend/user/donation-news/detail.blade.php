@extends('backend.user.templates.default')

@section('content')

<div class="container">
  <div class="row">
  <div class="card">
    <div class="card-image waves-effect waves-block waves-light">
      <img class="activator" src="{{ $data->image }}">
    </div>
    <div class="card-content">
      <span class="card-title activator grey-text text-darken-4">{{ $data->title }}</span>
      <p>{!! $data->content !!}</p>
    </div>
  </div>
  </div>
</div>
@endsection
