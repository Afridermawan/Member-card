@extends('backend.user.templates.default')

@section('content')
{{-- {{ dd($data) }} --}}
  <div class="container">
    <div class="row">
    <div class="col s12 m12">
    <div class="card horizontal">
      <div class="card-image" style="background: #EEEEEE">
        <a class="modal-trigger" href="#modal2">
            <img src="{{ $session->image }}" style="width: 250px;height: 350px" title="Perbaharui Foto Profile">
        </a>
      </div>
      <div class="card-stacked">
        <div class="card-content">
          <p>
            Name : {{ $session->name }}<br>
            Username : {{ $session->username }}<br>
            Email : {{ $session->email }}<br>
            No.Telepon : {{ $session->phone }}<br>
            Jenis Kelamin : {{ $session->gender }}<br>
            Address : {!! $session->address !!}<br>
            PIN : {{ $_SESSION['pin'] }}

          </p>
          <span style="float: right;">
            <!-- Modal Trigger -->
              <a class="waves-effect waves-light btn modal-trigger" href="#modal1">QR-Code</a>
            <!-- Modal Structure -->
            <div class="col s3 center-align">
                <div id="modal1" class="modal">
                  <div class="modal-content">
                  <img src="{{ $session->code }}" style="width: 250px;height: 250px">
                  </div>
                </div>
            </div>
            </div>
          </span>
        <div class="action">
        @if(isset( $_SESSION['pin'] ))
          <a class="modal-trigger" href="#modal3">
              <i class="material-icons">create</i> &nbsp Edit PIN</a>
        @else
          <a class="modal-trigger" href="#modal3">
              <i class="material-icons">create</i> &nbsp Add PIN</a>
        @endif
          <a  href="{{ $base_url }}/web/user/edit/{{ $session->id }}/profile">
              <i class="material-icons">settings</i>&nbsp Setting Profile</a>
          <a class="modal-trigger" href="#modal4">
              <i class="material-icons">attach_money</i>&nbsp Chek deposit</a>
        </div>
      </div>
    </div>
  </div>
  </div>
  </div>

  <!-- deposit -->
  <span style="float: right;">
    <!-- Modal Structure -->
    <div class="col s3 center-align">
        <div id="modal4" class="modal">
          <div class="modal-content">
              @if ($saldo->status == 400)
                  <p>{{ $saldo->error_message }}</p>
              @else
                  <p>{{ $saldo->saldo_deposit }}</p>
              @endif

          </div>
          <div class="modal-footer">
              <a class="btn btn-default pull-right"
                href="{{ $base_url }}/web/deposit/kredit">
                <i class="material-icons">attach_money</i>&nbsp Deposit</a>
          </div>
        </div>
    </div>
    </div>
  </span>

  <!-- perbaharui foto profile -->
  <span style="float: right;">
  <!-- Modal Structure -->
  <div class="col s3 center-align">
      <div id="modal2" class="modal">
        <div class="modal-content">
            <form action="{{ $base_url }}/web/user/change/image" method="post" enctype="multipart/form-data">
              <div class="file-field input-field">
                <div class="btn">
                  <span>File</span>
                  <input type="file" name="image" multiple>
                </div>
                <div class="file-path-wrapper">
                  <input name="img" class="file-path validate" type="text" placeholder="Upload one or more files">
                </div>
              </div>
              <div class="card-action center-align">
                <button class="btn waves-effect waves-light" type="submit" name="action">Edit
                </button>
              </div>
            </form>
        </div>
      </div>
  </div>
</span>

<!-- setting PIN -->
<span style="float: right;">
<!-- Modal Structure -->
<div class="col s3 center-align">
    <div id="modal3" class="modal">
      <div class="modal-content">
          <form action="{{ $base_url }}/web/pin/check/password" method="post">
              <div class="row">
                <div class="input-field col s12">
                  <input name="password" id="password" type="password" class="validate">
                  <label for="password"><i class="material-icons">lock_outline</i> Password</label>
                </div>
              </div>
          </form>
      </div>
    </div>
</div>
</span>
@section('custom_script')
  <script>
    $(document).ready(function(){
      $('#modal1').modal();
      });
  </script>
  <script>
    $(document).ready(function(){
      $('#modal2').modal();
      });
  </script>
  <script>
    $(document).ready(function(){
      $('#modal3').modal();
      });
  </script>
  <script>
    $(document).ready(function(){
      $('#modal4').modal();
      });
  </script>
@endsection

@endsection
