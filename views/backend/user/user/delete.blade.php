@extends('templates.default')

@section('content')
    <div class="page-title">
        <div class="title_left">
          <h3>Hapus Pilihan Qurban</h3>
        </div>
        <div class="title_right">
          <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
            <div class="input-group">
              <input type="text" class="form-control" placeholder="Search for...">
              <span class="input-group-btn">
                        <button class="btn btn-default" type="button">Go!</button>
                    </span>
            </div>
          </div>
        </div>
      </div>
      <div class="clearfix"></div>
      <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
            <div class="x_title">
              <h2>Form Design <small>different form elements</small></h2>
              <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                </li>
              </ul>
              <div class="clearfix"></div>
            </div>
            <div class="x_content">
              <br />
              <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" action=" {{ route('qurban.delete', $qurban->id) }} " method="post">
                 {!! csrf_field() !!}
                  <h2>Are you sure to delete " {{ $qurban->name }} " ?</h2>
                <div class="ln_solid"></div>
                <div class="form-group">
                  <div class="col-md-12 col-sm-12 col-xs-12">
                    <button type="submit" class="btn btn-danger pull-right">Hapus</button>
                  </div>
                </div>

              </form>
            </div>
          </div>
        </div>
      </div>
@endsection
