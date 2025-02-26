<!doctype html>
<html lang="en" dir="rtl">
     <!--begin::Head-->
     @include('Panel.layout.head-part')
     <!--end::Head-->
     <!--begin::Body-->
     <body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
        @include('sweetalert::alert', ['cdn' => "https://cdn.jsdelivr.net/npm/sweetalert2@9"])
         <!--begin::App Wrapper-->
    <div class="app-wrapper">
        <!--begin::Header-->
        @include('Panel.layout.nav-part')
         <!--end::Header-->
         <!--begin::Sidebar-->
         @include('Panel.layout.sidebar-part')
         <!--end::Sidebar-->
         <!--begin::App Main-->

         @yield('content')
         <!--end::App Main-->
          <!--begin::Footer-->
        @include('Panel.layout.footer-part')
         <!--end::Footer-->
         <!--end::App Wrapper-->
         <!--begin::Script-->
         <!--begin::Third Party Plugin(OverlayScrollbars)-->
         @include('Panel.layout.js-part')
          <!--end::OverlayScrollbars Configure-->
    <!--end::Script-->
    </div>
     </body>
     <!--end::Body-->
</html>
