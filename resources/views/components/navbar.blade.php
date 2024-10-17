  <nav class="topnav navbar navbar-light">
            <button type="button" class="p-0 mt-2 mr-3 navbar-toggler text-muted collapseSidebar">
                <i class="fe fe-menu navbar-toggler-icon"></i>
            </button>
            <ul class="nav">
                 <li class="nav-item">
                </li>
                <li class="nav-item dropdown">
                    <a class="pr-0 nav-link dropdown-toggle text-muted" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="mt-2 avatar avatar-sm">
                            <img src="{{ asset('assets/assets/avatars/face-1.jpg') }}" alt="..." class="avatar-img rounded-circle">
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="#">Profile</a>
                        <a class="dropdown-item" href="#">Settings</a>
                         <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="dropdown-item" type="submit">Logout</button> <!-- Logout menggunakan form POST -->
                </form>
                    </div>
                </li>
            </ul>
        </nav>
        <aside class="bg-white shadow sidebar-left border-right" id="leftSidebar" data-simplebar>
            <a href="#" class="mt-3 ml-2 btn collapseSidebar toggle-btn d-lg-none text-muted" data-toggle="toggle">
                <i class="fe fe-x"><span class="sr-only"></span></i>
            </a>
            <nav class="vertnav navbar navbar-light">
                <!-- nav bar -->
                <div class="mb-4 w-100 d-flex">
                    <a class="mx-auto mt-2 text-center navbar-brand flex-fill" href="./index.html">
                        <svg version="1.1" id="logo" class="navbar-brand-img brand-sm" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 120 120" xml:space="preserve">
                            <g>
                                <polygon class="st0" points="78,105 15,105 24,87 87,87 	" />
                                <polygon class="st0" points="96,69 33,69 42,51 105,51 	" />
                                <polygon class="st0" points="78,33 15,33 24,15 87,15 	" />
                            </g>
                        </svg>
                    </a>
                </div>
                <ul class="mb-2 navbar-nav flex-fill w-100">
                    <li class="nav-item dropdown">
                        <a href="#dashboard" data-toggle="collapse" aria-expanded="false">
                            <i class="fe fe-home fe-16"></i>
                            <span class="ml-3 item-text">Dashboard</span>
                        </a>
                    </li>
                </ul>
                <p class="mt-4 mb-1 text-muted nav-heading">
                    <span>Components</span>
                </p>
                <ul class="mb-2 navbar-nav flex-fill w-100">
                    <li class="nav-item w-100">
                        <a class="nav-link" href="/doctors">
                            <i class="fe fe-users fe-16"></i>
                            <span class="ml-3 item-text">Doctors</span>
                        </a>
                    </li>
                    <li class="nav-item w-100">
                        <a class="nav-link" href="/patients">
                            <i class="fe fe-user fe-16"></i>
                            <span class="ml-3 item-text">Patients</span>
                        </a>
                    </li>
                    <li class="nav-item w-100">
                        <a class="nav-link" href="/nurses">
                            <i class="fe fe-users fe-16"></i>
                            <span class="ml-3 item-text">Nurses</span>
                        </a>
                    </li>

                </ul>
                <p class="mt-4 mb-1 text-muted nav-heading">
                    <span>Apps</span>
                </p>
                <ul class="mb-2 navbar-nav flex-fill w-100">
                    <li class="nav-item w-100">
                        <a class="nav-link" href="calendar.html">
                            <i class="fe fe-calendar fe-16"></i>
                            <span class="ml-3 item-text">Calendar</span>
                        </a>
                    </li>
                     <li class="nav-item w-100">
                        <a class="nav-link" href="/appointments">
                            <i class="fe fe-clock fe-16"></i>
                            <span class="ml-3 item-text">Appoinment</span>
                        </a>
                    </li>
                     <li class="nav-item w-100">
                        <a class="nav-link" href="/treatments">
                            <i class="fe fe-monitor fe-16"></i>
                            <span class="ml-3 item-text">Treatment</span>
                        </a>
                    </li>
                     <li class="nav-item w-100">
                        <a class="nav-link" href="/appointment_treatments">
                            <i class="fe fe-clipboard fe-16"></i>
                            <span class="ml-3 item-text">Apploitment Treatment</span>
                        </a>
                    </li>
                    <li class="nav-item w-100">
                        <a class="nav-link" href="/payments">
                            <i class="fe fe-dollar-sign fe-16"></i>
                            <span class="ml-3 item-text">Payment</span>
                        </a>
                    </li>
                </ul>
                <p class="mt-4 mb-1 text-muted nav-heading">
                    <span>Documentation</span>
                </p>
                <ul class="mb-2 navbar-nav flex-fill w-100">
                    <li class="nav-item w-100">
                        <a class="nav-link" href="/monthly">
                            <i class="fe fe-fe-folder fe-16"></i>
                            <span class="ml-3 item-text">Laporan Bulanan</span>
                        </a>
                        <a class="nav-link" href="/daily">
                            <i class="fe fe-file fe-16"></i>
                            <span class="ml-3 item-text">Laporan harian</span>
                        </a>
                        <a class="nav-link" href="users">
                            <i class="fe fe-help-circle fe-16"></i>
                            <span class="ml-3 item-text">User Status</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>
