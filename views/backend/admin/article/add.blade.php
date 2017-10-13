@extends('templates.default')
@section('custom-css')
    <script src="{{$base_url}}/assets/css/select2/min.css"></script>
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
              <h2>Tambah Artikel</h2>
              <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
              </ul>
              <div class="clearfix"></div>
            </div>
            <div class="x_content">
              <br />
              <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" action=" {{ $base_url }}/admin/article/add " method="post" enctype="multipart/form-data">

                <div class="form-group has-feedback">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-title">Title <span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" name="title" id="first-title" required="required" class="form-control col-md-7 col-xs-12" value="" placeholder="Title">
                  </div>
                        <span class="help-block"></span>
                </div>

                <div class="form-group has-feedback ">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-image">Image <span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="file" name="thumbnail" id="first-image" class="form-control col-md-7 col-xs-12" value="" placeholder="Thumbnail">
                  </div>
                        <span class="help-block"></span>
                </div>

                <div class="form-group has-feedback">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Content <span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <textarea name="content" rows="8" cols="40"></textarea>
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

  @section('custom-script')
      <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
      <script>tinymce.init({ selector:'textarea' });</script>
      <script src="{{$base_url}}/assets/js/select/select2.full.js"></script>
      <script src="{{$base_url}}/assets/js/tags/jquery.tagsinput.min.js"></script>
  @endsection

@endsection