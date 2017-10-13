<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    @include('backend.user.templates.partials.header')
     @yield('custom_css')

 </head>

  <body style="background: #fafafa"> 

        @include('backend.user.templates.partials.navbar')

    <div class="container">
        <div class="row justify-content-center" style="margin-top: 50px; margin-bottom: 50px;height: auto;">
            <div class="col-lg-8">
    			@include('backend.user.templates.partials.alerts')
                <div class="container-fluid">
                <div class="container">
                  <div class="row">
                    <nav style="border-radius: 25px;margin-top: 20px">
                      <div class="nav-wrapper">
                        <div class="col s12">
                          <span style="font-family:  Tibetan Machine Uni, sans-serif;font-size: 25px;">Member-Card  &nbsp</span>
                          <span style="font-family:  Trebuchet, sans-serif;font-size: 20px;"> {{ $title }}</span>
                        </div>
                      </div>
                    </nav>
                    <br>
                  </div>
                </div>
    				@yield('content')

                </div>
            </div>
        </div>
    </div>

    @include('backend.user.templates.partials.script')
     @yield('custom_script')

  </body>
    @include('backend.user.templates.partials.footer')
  
</html>