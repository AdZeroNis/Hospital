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
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">

                <li class="nav-item">
                    <a href="{{route('Panel.SpecialitiesList')}}" class="nav-link">
                        <i class="nav-icon bi bi-award"></i> <!-- آیکن مرتبط با تخصص‌ها -->
                        <p> تخصص ها</p>
                    </a>
                </li>
                
                <li class="nav-item">
                    <a href="{{route('Panel.RolesDoctorList')}}" class="nav-link">
                        <i class="nav-icon bi bi-person-badge"></i> <!-- آیکن مرتبط با نقش پزشکان -->
                        <p> نقش پزشکان</p>
                    </a>
                </li>
                
                <li class="nav-item">
                    <a href="{{route('Panel.DoctorList')}}" class="nav-link">
                        <i class="nav-icon bi bi-person-lines-fill"></i> <!-- آیکن مرتبط با پزشکان -->
                        <p>پزشکان</p>
                    </a>
                </li>
                
                <li class="nav-item">
                    <a href="{{route('Panel.InsuranceList')}}" class="nav-link">
                        <i class="nav-icon bi bi-shield-check"></i> <!-- آیکن مرتبط با بیمه -->
                        <p>بیمه</p>
                    </a>
                </li>
                
                <li class="nav-item">
                    <a href="{{route('Panel.OperationList')}}" class="nav-link">
                        <i class="nav-icon bi bi-scissors"></i> <!-- آیکن مرتبط با عمل‌ها -->
                        <p>عمل ها</p>
                    </a>
                </li>
                
                <li class="nav-item">
                    <a href="{{route('Panel.SurgeryList')}}" class="nav-link">
                        <i class="nav-icon bi bi-hospital"></i> <!-- آیکن مرتبط با عمل‌های جراحی -->
                        <p>عمل های جراحی</p>
                    </a>
                </li>
                
                <li class="nav-item">
                    <a href="{{route('Panel.InvoicePay')}}" class="nav-link">
                        <i class="nav-icon bi bi-cash-coin"></i> <!-- آیکن مرتبط با پرداخت صورتحساب -->
                        <p>پرداخت صورتحساب</p>
                    </a>
                </li>
                
                <li class="nav-item">
                    <a href="{{route('Panel.InvoiceList')}}" class="nav-link">
                        <i class="nav-icon bi bi-file-earmark-text"></i> <!-- آیکن مرتبط با صورتحساب‌ها -->
                        <p>صورتحساب ها</p>
                    </a>
                </li>

            </ul>
        </nav>
    </div>
    <!--end::Sidebar Wrapper-->
</aside>
