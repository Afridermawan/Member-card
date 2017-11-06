@extends('backend.user.templates.default')

@section('content')

<div class="container">
  <div class="row">
    <nav style="border-radius: 25px;margin-top: 20px">
      <div class="nav-wrapper">
        <div class="col s12">
            <span style="font-family:  Tibetan Machine Uni, sans-serif;font-size: 25px;">Member-Card  &nbsp</span>
            <span style="font-family:  Trebuchet, sans-serif;font-size: 20px;"> {{ $title }}</span>
            @if (!$session->hak_akses)
                <span class="pull-right">
                    <a href="{{ $base_url }}/web/request/send"><i class="material-icons">mode_edit</i></a>
                </span>
            @else
                <span class="pull-right">
                    <a href="{{ $base_url }}/web/article/create/user"><i class="material-icons">mode_edit</i></a>
                </span>
            @endif
        </div>
      </div>
    </nav>
    <br>
  </div>
</div>

<div class="container">
  <div class="row">
    @foreach($data->data as $datas)
    <div class="col s12 m6 hoverable">
      <div class="card">
        <div class="card-image waves-effect waves-block waves-light">
          <img class="activator" src="{{ $datas->thumbnail }}" style="width: 350px;min-height: 300px;max-height: 300px">
        </div>
        <div class="card-content">
          <a href="{{ $base_url }}/web/article/{{ $datas->id }}/detail">
            <span class="card-title activator grey-text text-darken-4">{{ $datas->title }}</span>
          </a>
            <p>{!! substr($datas->content,0, 300) !!}
                <a href="{{ $base_url }}/web/article/{{ $datas->id }}/detail">Readmore...</a>
            </p>
        </div>
      </div>
    </div>
    @endforeach
  </div>
</div>
  @if (isset($data->meta->pagination))
      <?php
      $page = $data->meta->pagination;
      ?>
      <ul class="pagination center">
          @if (isset($page->links->previous))
          <li><a href="{{$link}}?page=1">First</a></li>
          <li><a href="{{$link}}?page={{$page->current_page-1}}"><<</a></li>
          @else
          <li class="disabled"><a class="disabled">First</a></li>
          <li class="disabled"><a class="disabled"><<</a></li>
          @endif

      <?php $x = $page->total_pages+1; ?>

      @for ($i =1; $i<$x; $i++ )
          @if ($page->current_page==$i)
          <li class="active"><a href="">{{$i}}</a></li>
          @else
          <li><a href="{{$link}}?page={{$i}}">{{$i}}</a></li>
          @endif
      @endfor

          @if (isset($page->links->next))
          <li><a href="{{$link}}?page={{$page->current_pages+1}}">>></a></li>
          <li><a href="{{$link}}?page={{$page->total_pages}}">Last</a></li>
          @else
          <li class="disabled"><a>>></a></li>
          <li class="disabled"><a class="disabled">Last</a></li>
          @endif
      </ul>
  @endif
@endsection
