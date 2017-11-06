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
    <nav style="border-radius: 25px;margin-top: 20px">
      <div class="nav-wrapper">
        <div class="col s12">
            <span style="font-family:  Tibetan Machine Uni, sans-serif;font-size: 25px;">Member-Card  &nbsp</span>
            <span style="font-family:  Trebuchet, sans-serif;font-size: 20px;"> {{ $title }}</span>
        </div>
      </div>
    </nav>
    <br>
  </div>
</div>

<div class="container">
    <form class="input-field col s12" action="{{ $base_url }}/web/produk/user/add" method="post"
        enctype="multipart/form-data">
        <div class="file-field input-field">
          <div class="btn">
           <span>File</span>
           <input type="file" name="image" multiple>
          </div>
          <div class="file-path-wrapper">
           <input class="file-path validate" type="text" placeholder="Upload one or more files">
          </div>
        </div>
        <div class="row">
            <div class="input-field col s12">
              <input name="name" id="name" type="text" class="validate">
              <label for="name">Nama</label>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12">
              <input name="harga" id="harga" type="number" class="validate">
              <label for="harga">Harga</label>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12">
              <textarea class="materialize-textarea" name="description"></textarea>
              <label for="description">Deskripsi</label>
            </div>
        </div>

        <div class="card-action center-align">
            <button class="btn waves-effect waves-light" type="submit" name="action">Simpan
            </button>
        </div>
    </form>
</div>
@endsection
