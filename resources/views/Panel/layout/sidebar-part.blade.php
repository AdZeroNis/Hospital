<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <!--begin::Sidebar Brand-->
    <div class="sidebar-brand">
      <!--begin::Brand Link-->
      <a href="../index.html" class="brand-link">
        <!--begin::Brand Image-->
        <img
          src="{{asset('Adminasset/assets/img/AdminLTELogo.png')}}"
          alt="AdminLTE Logo"
          class="brand-image opacity-75 shadow"
        />
        <!--end::Brand Image-->
        <!--begin::Brand Text-->
        <span class="brand-text fw-light">{{$user->name}}</span>
        <!--end::Brand Text-->
      </a>
      <!--end::Brand Link-->
    </div>
    <!--end::Sidebar Brand-->
    <!--begin::Sidebar Wrapper-->
    <div class="sidebar-wrapper">
      <nav class="mt-2">
        <!--begin::Sidebar Menu-->
        <ul
          class="nav sidebar-menu flex-column"
          data-lte-toggle="treeview"
          role="menu"
          data-accordion="false"
        >
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon bi bi-speedometer"></i>
              <p>
                Dashboard
                <i class="nav-arrow bi bi-chevron-right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('Panel.UserList')}}" class="nav-link">
                  <i class="nav-icon bi bi-circle"></i>
                  <p> کاربران</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('Panel.SpecialitiesList')}}" class="nav-link">
                  <i class="nav-icon bi bi-circle"></i>
                  <p> تخصص ها</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('Panel.RolesDoctorList')}}" class="nav-link">
                  <i class="nav-icon bi bi-circle"></i>
                  <p> نقش پزشکان</p>
                </a>
                <li class="nav-item">
                    <a href="{{route('Panel.DoctorList')}}" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>پزشکان</p>
                 </a>
                    <li class="nav-item">
                        <a href="{{route('Panel.InsuranceList')}}" class="nav-link">
                          <i class="nav-icon bi bi-circle"></i>
                          <p>بیمه</p>
                  </a>
                  <li class="nav-item">
                    <a href="{{route('Panel.OperationList')}}" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>عمل ها</p>
              </a>
              <li class="nav-item">
                <a href="{{route('Panel.SurgeryList')}}" class="nav-link">
                  <i class="nav-icon bi bi-circle"></i>
                  <p>عمل های جراحی</p>
          </a>
              </li>


            </ul>
          </li>

        </ul>
        <!--end::Sidebar Menu-->
      </nav>
    </div>
    <!--end::Sidebar Wrapper-->
  </aside>
