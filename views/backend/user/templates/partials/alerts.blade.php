<!-- Alert Material -->
@if (isset($messages['success']))
    <div class="card-panel green lighten-4 green-text text-alert-4"><b>Success! </b>      
      <strong>
        @foreach($messages['success'] as $m)
          {{$m}}
        @endforeach
      </strong>
    <span class="pull-right"><i class="material-icons prefix">close</i></span>
    </div>      
@endif

@if (isset($messages['error']))
    <div class="card-panel red lighten-4 red-text text-alert-4"><b>Error! </b>       
    <strong>
        @foreach($messages['error'] as $m)
          {{$m}}
        @endforeach
      </strong>
    <span class="pull-right"><i class="material-icons prefix">close</i></span>
    </div>      
@endif

@if (isset($messages['warning']))
    <div class="card-panel yellow lighten-4 yellow-text text-alert-4"><b>Warning! </b>
        <strong>
        @foreach($messages['warning'] as $m)
          {{$m}}
        @endforeach
      </strong>
    <span class="pull-right"><i class="material-icons prefix">close</i></span>
    </div>      
@endif

@if (isset($messages['info']))
    <div class="card-panel blue lighten-4 blue-text text-alert-4"><b>Info! </b>
        <strong>
        @foreach($messages['info'] as $m)
          {{$m}}
        @endforeach
      </strong>
    <span class="pull-right"><i class="material-icons prefix">close</i></span>
    </div>
@endif

<script>
    window.setTimeout(function() {
    $(".alert-dismissible").fadeTo(700, 0).slideUp(700, function(){
        $(this).remove();
    });
}, 3700);
window.setTimeout(function() {
    $(".text-alert-4").fadeTo(700, 0).slideUp(700, function(){
        $(this).remove();
    });
}, 3700);
</script>