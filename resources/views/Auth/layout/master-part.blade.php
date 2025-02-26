<!doctype html>
<html lang="en">
    <!--begin::Head-->
    @include('Auth.layout.head-part')
    <!--end::Head-->
    <!--begin::Body-->
    <body class="login-page bg-body-secondary">
        <div class="login-box">


            @yield('content')

          </div>
     <!--begin::Third Party Plugin(OverlayScrollbars)-->
     @include('Auth.layout.js-part')
    <!--end::OverlayScrollbars Configure-->
    <!--end::Script-->
    </body>
    <!--end::Body-->
</html>
