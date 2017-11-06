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
