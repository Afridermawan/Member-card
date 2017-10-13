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
              <h2>Tambah Berita Donasi </h2>
              <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
              </ul>
              <div class="clearfix"></div>
            </div>
            <div class="x_content">
              <br />
              <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" action=" {{ route('donation-news.add') }} " method="post">
                 {!! csrf_field() !!}
                <div class="form-group has-feedback {{ $errors->has('title') ? ' has-error' : '' }}">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-title">Title <span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" name="title" id="first-title" required="required" class="form-control col-md-7 col-xs-12" value="{{ old('title')?: '' }}" placeholder="Title">
                  </div>
                    @if ($errors->has('title'))
                        <span class="help-block">{{ $errors->first('title') }}</span>
                    @endif
                </div>

                <div class="form-group has-feedback {{ $errors->has('image') ? ' has-error' : '' }}">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-image">Image <span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="file" name="image" id="first-image" class="form-control col-md-7 col-xs-12" value="{{ old('image')?: '' }}" placeholder="Nama">
                  </div>
                    @if ($errors->has('image'))
                        <span class="help-block">{{ $errors->first('image') }}</span>
                    @endif
                </div>

                <div class="form-group has-feedback {{ $errors->has('content') ? ' has-error' : '' }}">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Berita <span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <textarea name="content" rows="8" cols="40"></textarea>
                  </div>
                    @if ($errors->has('content'))
                        <span class="help-block">{{ $errors->first('content') }}</span>
                    @endif
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
