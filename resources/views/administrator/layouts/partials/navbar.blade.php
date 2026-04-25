<!-- [ Header ] -->
<header class="pc-header">
    <div class="header-wrapper">
        <div class="me-auto pc-mob-drp">
            <ul class="list-unstyled">
                <li class="pc-h-item header-mobile-collapse">
                    <a href="#" class="pc-head-link head-link-secondary ms-0" id="sidebar-hide">
                        <i class="ti ti-menu-2"></i>
                    </a>
                </li>
                <li class="pc-h-item pc-sidebar-popup">
                    <a href="#" class="pc-head-link head-link-secondary ms-0" id="mobile-collapse">
                        <i class="ti ti-menu-2"></i>
                    </a>
                </li>
            </ul>
        </div>
        <div class="ms-auto">
            <ul class="list-unstyled">
                <!-- User Profile -->
                <li class="dropdown pc-h-item header-user-profile">
                    <a class="pc-head-link head-link-primary dropdown-toggle arrow-none me-0"
                        data-bs-toggle="dropdown" href="#" role="button">
                        <img src="{{ asset('admin-template/assets/images/user/avatar-2.jpg') }}" alt="Admin" class="user-avtar" />
                        <span><i class="ti ti-chevron-down"></i></span>
                    </a>
                    <div class="dropdown-menu dropdown-user-profile dropdown-menu-end pc-h-dropdown">
                        <div class="dropdown-header">
                            <h4>Halo, <span class="small text-muted">{{ auth()->user()->name ?? 'Admin Desa' }}</span></h4>
                            <p class="text-muted">Administrator</p>
                            <hr />
                            <a href="#" class="dropdown-item">
                                <i class="ti ti-user"></i> <span>Profil Saya</span>
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item">
                                    <i class="ti ti-logout"></i> <span>Logout</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</header>
