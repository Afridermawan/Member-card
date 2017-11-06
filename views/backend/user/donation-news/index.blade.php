@extends('backend.user.templates.default')

@section('content')
    
<div class="container">
  <div class="row">
    <nav style="border-radius: 25px;margin-top: 20px">
      <div class="nav-wrapper">
        <div class="col s12">
            <span style="font-family:  Tibetan Machine Uni, sans-serif;font-size: 25px;">Member-Card  &nbsp</span>
            <span style="font-family:  Trebuchet, sans-serif;font-size: 20px;"> {{ $title }}</span>
            @if ($title == Home)

            @else
            <span class="pull-right">
                <a href="{{ $base_url }}/web/request/send"><i class="material-icons">mode_edit</i></a>
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
          <div class="card-image">
            <img src="{{ $datas->image }}">
            <span class="card-title"></span>
          </div>
          <div class="card-content" style="">
            <p>{!! substr($datas->content,0, 300) !!}
              <a href="{{ $base_url }}/web/donation-news/{{ $datas->id }}">Readmore...</a>
            </p>
          </div>
          <div class="card-action">
            <a href="{{ $base_url }}/web/donation-news/{{ $datas->id }}">{{ $datas->title }}</a>
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
@endsection
