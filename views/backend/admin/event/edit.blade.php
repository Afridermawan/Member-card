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
              <h2>Edit Event <small> {{ $data->name }} </small></h2>
              <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
              </ul>
              <div class="clearfix"></div>
            </div>
            <div class="x_content">
              <br />
              <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" action=" {{$base_url}}/admin/event/{{$data->id}}/edit " method="post" enctype="multipart/form-data">
                <div class="form-group has-feedback">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Nama <span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" name="name" id="first-name" required="required" class="form-control col-md-7 col-xs-12" value="{{ $data->name }}" placeholder="Name">
                  </div>
                        <span class="help-block"></span>
                </div>

                <div class="form-group has-feedback">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-image">Image <span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="file" name="image" id="first-image" class="form-control col-md-7 col-xs-12" value="{{ $data->name }}" placeholder="Nama">
                  </div>
                        <span class="help-block"></span>
                </div>

                <div class="form-group has-feedback">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Deskripsi <span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <textarea name="description" rows="8" cols="40">{{ $data->description }}</textarea>
                  </div>
                        <span class="help-block"></span>
                </div>

                <div class="form-group has-feedback">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-harga">Biaya Pendaftaran <span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" name="biaya_pendaftaran" id="first-harga" required="required" class="form-control col-md-7 col-xs-12" value="{{ $data->biaya_pendaftaran }}" placeholder="Biaya Pendaftaran">
                  </div>
                        <span class="help-block"></span>
                </div>

                <div class="form-group has-feedback">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-start_date">Acara Mulai <span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="date" name="start_date" id="first-start_date" required="required" class="form-control col-md-7 col-xs-12" value="{{ $data->start_date }}" placeholder="Acara mulai">
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
