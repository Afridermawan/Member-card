@if (isset($messages['success']))
    <div class="alert alert-success alert-dismissible fade in" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
      </button>
      <strong>
      	@foreach($messages['success'] as $m)
      		{{$m}}
      	@endforeach
      </strong>
    </div>
@endif
@if (isset($messages['info']))
    <div class="alert alert-info alert-dismissible fade in" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
      </button>
      <strong>
      	@foreach($messages['info'] as $m)
      		{{$m}}
      	@endforeach
      </strong>
    </div>
@endif
@if (isset($messages['error']))
    <div class="alert alert-danger alert-dismissible fade in" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
      </button>
      <strong>
      	@foreach($messages['error'] as $m)
      		{{$m}}
      	@endforeach
      </strong>
    </div>
@endif