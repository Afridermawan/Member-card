<div class="top_nav">
  </span>
{{ print_r($notif->data) }}
  <div class="nav_menu">
    <nav class="" role="navigation">
      <div class="nav toggle">
        <a id="menu_toggle"><i class="fa fa-bars"></i></a>
      </div>

      <ul class="nav navbar-nav navbar-right">
        <li class="">
          <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
          @php
            $session = $_SESSION['login'];
          @endphp
          {{$session->username}}

            <span class=" fa fa-angle-down"></span>
          </a>
          <ul class="dropdown-menu dropdown-usermenu animated fadeInDown pull-right">
            <li><a href="{{$base_url}}/admin/logout"><i class="fa fa-sign-out pull-right"></i> Log Out</a>
            </li>
          </ul>
        </li>

        <li role="presentation" class="dropdown">
          <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
            <i class="fa fa-envelope-o"></i>
            <span class="badge bg-green">
                @php
                    // {{ $count->data }}
                @endphp
            </span>
          </a>
          <ul id="menu1" class="dropdown-menu list-unstyled msg_list animated fadeInDown" role="menu">
            @foreach ($notif->data as $key => $request)
                <li>
                    <a href="{{ $link }}list">
                        <span class="image">
                            <img src="{{ $request->image }}" alt="Profile Image" />
                        </span>
                        <span>
                            {{-- <span></span> --}}
                            {{-- <span class="time">3 mins ago</span> --}}
                        </span>
                        <span class="message">
                            {{ $request->username }} meminta Permission untuk upgrade feature ..
                        </a>
                    </li>
            @endforeach
            <li>
              <div class="text-center">
                <a href="{{ $link }}list">
                  <strong>See All Alerts</strong>
                  <i class="fa fa-angle-right"></i>
                </a>
              </div>
            </li>
          </ul>
        </li>

      </ul>
    </nav>
  </div>

</div>
