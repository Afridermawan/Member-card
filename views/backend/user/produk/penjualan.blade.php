@extends('backend.user.templates.default')

@section('content')

  <div class="container">
    <div class="row">
    <div class="col s12 m12">
    <div class="card horizontal">
      <div class="card-image">
        <img src="{{ $data->image }}" style="width: 200px;height: 200px">
      </div>
      <div class="card-stacked">
        <div class="card-content">
          <p>
            Name : {{ $data->name }}<br>
            Harga : {{ $data->harga }}<br>
          </p>
          <p>
          <form action="{{ $base_url }}/web/produk/{{ $data->id }}/buy" method="post">
            <div class="row">
               <div class="input-field col s12">
                  <i class="material-icons prefix">add</i>
                  <input name="kuantitas" id="firstname" type="text" class="validate">
                  <label for="kuantitas" class="active">Kuantitas</label>
               </div>
            </div>
          </form>
          </p>
      </div>
    </div>
  </div>
  </div>
  </div>  
@endsection
