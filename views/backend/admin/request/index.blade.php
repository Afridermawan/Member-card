@extends('templates.default')

@section('content')
    <div class="">

      <div class="page-title">
        <div class="title_left">
          <h3>
                Daftar Produk
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

            <div class="x_content">

                <table class="table">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Image</th>
                      <th>Nama</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>

                    @foreach($data->data as $key => $datas)
                        <tr>
                            <td> {{ $key+1 }}</td>
                            <td><img src="{{ $datas->image }}" alt="" width="50px" height="50px"></td>
                            <td> {{ $datas->username }} </td>
                            <td>
                                <a href="{{ $link.$datas->id.'/approve' }}" class="btn btn-default btn-sm">Terima</a>
                                <a href="{{ $link.$datas->id.'/delete' }}" class="btn btn-danger btn-sm">Tolak</a>
                            </td>
                        </tr>
                    @endforeach
                  </tbody>
                </table>

            @if (isset($data->meta->pagination))
                <?php
                $page = $data->meta->pagination;
                ?>
                <p class="pull-left"><br><b>Total Data : {{$page->total}}</b></p>
                <ul class="pagination pull-right">
                    @if (isset($page->links->previous))
                    <li><a href="{{$link}}list?page=1">First</a></li>
                    <li><a href="{{$link}}list?page={{$page->current_page-1}}"><<</a></li>
                    @else
                    <li class="disabled"><a class="disabled">First</a></li>
                    <li class="disabled"><a class="disabled"><<</a></li>
                    @endif

                <?php $x = $page->total_pages+1; ?>

                @for ($i =1; $i<$x; $i++ )
                    @if ($page->current_page==$i)
                    <li class="active"><a href="">{{$i}}</a></li>
                    @else
                    <li><a href="{{$link}}list?page={{$i}}">{{$i}}</a></li>
                    @endif
                @endfor

                    @if (isset($page->links->next))
                    <li><a href="{{$link}}list?page={{$page->current_pages+1}}">>></a></li>
                    <li><a href="{{$link}}list?page={{$page->total_pages}}">Last</a></li>
                    @else
                    <li class="disabled"><a>>></a></li>
                    <li class="disabled"><a class="disabled">Last</a></li>
                    @endif
                </ul>
            @endif
              </div>
            </div>
          </div>

        </div>
      </div>
@endsection
