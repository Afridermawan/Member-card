@extends('templates.default')

@section('content')
    <div class="">

      <div class="page-title">
        <div class="title_left">
          <h3>
                Komentar
                <small>
                    Member Card Apps
                </small>
            </h3>
        </div>
      </div>
      <div class="clearfix"></div>

      <div class="row">

        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
            <div class="x_title">
                <div class="clearfix"></div>
            </div>

            <div class="x_content">

                <table class="table">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Judul</th>
                      <th>Nama</th>
                      <th>Komentar</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    @php
                    $key = 1;
                    @endphp
                    @foreach($data->data as $datas)
                        <tr>
                            <td> {{ $key++ }}</td>
                            <td> {{ $datas->title }} </td>
                            <td> {{ $datas->username }} </td>
                            <td> {{ $datas->comment }} </td>
                            @if ($datas->user_id > 1)
                            <td>
                                <a href="{{ $link.$datas->id.'/comment/admin' }}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Balas</a>
                            </td>
                            @endif
                        </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>

        </div>
      </div>
@endsection
