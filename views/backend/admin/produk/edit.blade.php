@extends('templates.default')
@section('header-script')
    <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
    <script>tinymce.init({ selector:'textarea' });</script>
@endsection
@section('content')
    <div class="">

      <div class="page-title">
        <div class="title_left">
          <h3>Halaman</h3>
        </div>
      </div>
      <div class="clearfix"></div>
      <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
            <div class="x_title">
              <h2>Edit Produk <small> {{ $data->name }} </small></h2>
              <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
              </ul>
              <div class="clearfix"></div>
            </div>
            <div class="x_content">
              <br />
             <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" action=" {{$base_url}}/admin/produk/{{$data->id}}/edit " method="post" enctype="multipart/form-data">
                <div class="form-group has-feedback">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Nama <span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" name="name" id="first-name" required="required" class="form-control col-md-7 col-xs-12" value="{{$data->name}}" placeholder="Name">
                  </div>
                        <span class="help-block"></span>
                </div>

                <div class="form-group has-feedback">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-image">Image <span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="file" name="image" id="first-image" class="form-control col-md-7 col-xs-12" value="{{$data->image}}" placeholder="Nama">
                  </div>
                        <span class="help-block"></span>
                </div>

                <div class="form-group has-feedback">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Deskripsi <span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <textarea name="description" rows="8" cols="40">{{$data->description}}</textarea>
                  </div>
                        <span class="help-block"></span>
                </div>

                <div class="form-group has-feedback">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-harga">Harga <span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" name="harga" id="first-harga" required="required" class="form-control col-md-7 col-xs-12" value="{{$data->harga}}" placeholder="Harga">
                  </div>
                        <span class="help-block"></span>
                </div>

                <div class="form-group has-feedback">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-stok">Stok <span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="number" name="stok" id="first-stok" required="required" class="form-control col-md-7 col-xs-12" value="{{$data->stok}}" placeholder="Stok">
                  </div>
                        <span class="help-block"></span>
                </div>

                <div class="ln_solid"></div>
                <div class="form-group">
                  <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <button type="submit" class="btn btn-success">Submit</button>
                  </div>
                </div>

              </form>
            </div>
          </div>
        </div>
      </div>
@endsection
