@extends('backend.user.templates.default')

@section('content')

<div class="container">
  <div class="row">
    <div class="card">
      <div class="card-image waves-effect waves-block waves-light">
        <img class="activator" src="{{ $data->thumbnail }}" style="max-height: 400px;min-height: 400px">
      </div>
      <div class="card-content">
        <span class="card-title activator grey-text text-darken-4">{{ $data->title }}</span>
          <p>{!! $data->content !!}
          </p>
      </div>
    </div>
  </div>
</div>

@foreach($comment->data as $comments)
  <div class="container">
    <div class="card"  style="border-radius: 25px">
      <div class="chip" style="margin: 15px">
        <img src="{{ $comments->image }}" alt="Contact Person">
        {{ $comments->username }}
        <p style="padding-left: 20px"><i class="material-icons prefix">subdirectory_arrow_right</i> {!! $comments->comment !!}</p>
      </div>
    </div>
  </div>
@endforeach

<div class="container">
    <div class="row">
      <div class="input-field col s12">
      <form action="{{ $base_url }}/web/article/{{ $data->id }}/comment" method="post">
        <textarea name="comment" id="textarea1" class="materialize-textarea" placeholder="Tulis Komentar Anda .."></textarea>
        <button class="btn btn-default"><i class="fa fa-reply"></i> Submit</button>
        <label for="textarea1">Comment :</label>
      </form>
      </div>
    </div>
</div>

@endsection
