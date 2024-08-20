@php
    $canViewUsers = auth()->user()->can('teacher-list') || auth()->user()->can('student-list') || auth()->user()->can('admin-list');
@endphp

<aside class="sidebar">
    <button type="button" class="sidebar-close-btn">
        <iconify-icon icon="radix-icons:cross-2"></iconify-icon>
    </button>
    <div>
        <a href="{{ route('admin.dashboard') }}" class="sidebar-logo">
                    <img src="{{ asset(appLogoUrl()) }}" alt="site logo" class="light-logo">
            {{-- <img src="{{ asset('assets/images/logo-light.png') }}" alt="site logo" class="dark-logo"> --}}
            <img src="{{ asset(appLogoUrl()) }}" alt="site logo" class="logo-icon">
        </a>
    </div>
    <div class="sidebar-menu-area">
        <ul class="sidebar-menu" id="sidebar-menu">
            {{-- <li class="dropdown">
                <a href="javascript:void(0)">
                    <iconify-icon icon="solar:home-smile-angle-outline" class="menu-icon"></iconify-icon>
                    <span>Dashboard</span>
                </a>
                <ul class="sidebar-submenu">
                    <li>
                        <a href="index.html"><i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i>
                            AI</a>
                    </li>
                    <li>
                        <a href="index-2.html"><i class="ri-circle-fill circle-icon text-warning-main w-auto"></i>
                            CRM</a>
                    </li>
                    <li>
                        <a href="index-3.html"><i class="ri-circle-fill circle-icon text-info-main w-auto"></i>
                            eCommerce</a>
                    </li>
                    <li>
                        <a href="index-4.html"><i class="ri-circle-fill circle-icon text-danger-main w-auto"></i>
                            Cryptocurrency</a>
                    </li>
                    <li>
                        <a href="index-5.html"><i class="ri-circle-fill circle-icon text-success-main w-auto"></i>
                            Investment</a>
                    </li>
                </ul>
            </li> --}}
            {{-- <li class="sidebar-menu-group-title">Application</li> --}}
            {{-- <li>
                <a href="email.html">
                    <iconify-icon icon="mage:email" class="menu-icon"></iconify-icon>
                    <span>Email</span>
                </a>
            </li>
            <li>
                <a href="chat-message.html">
                    <iconify-icon icon="bi:chat-dots" class="menu-icon"></iconify-icon>
                    <span>Chat</span>
                </a>
            </li>
            <li>
                <a href="calendar-main.html">
                    <iconify-icon icon="solar:calendar-outline" class="menu-icon"></iconify-icon>
                    <span>Calendar</span>
                </a>
            </li>
            <li>
                <a href="kanban.html">
                    <iconify-icon icon="material-symbols:map-outline" class="menu-icon"></iconify-icon>
                    <span>Kanban</span>
                </a>
            </li> --}}
            {{-- <li class="dropdown">
                <a href="javascript:void(0)">
                    <iconify-icon icon="hugeicons:invoice-03" class="menu-icon"></iconify-icon>
                    <span>Invoice</span>
                </a>
                <ul class="sidebar-submenu">
                    <li>
                        <a href="invoice-list.html"><i
                                class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> List</a>
                    </li>
                    <li>
                        <a href="invoice-preview.html"><i
                                class="ri-circle-fill circle-icon text-warning-main w-auto"></i> Preview</a>
                    </li>
                    <li>
                        <a href="invoice-add.html"><i class="ri-circle-fill circle-icon text-info-main w-auto"></i>
                            Add new</a>
                    </li>
                    <li>
                        <a href="invoice-edit.html"><i
                                class="ri-circle-fill circle-icon text-danger-main w-auto"></i> Edit</a>
                    </li>
                </ul>
            </li> --}}

            {{-- <li class="sidebar-menu-group-title">Application</li> --}}

            {{-- <li class="dropdown">
                <a href="javascript:void(0)">
                    <iconify-icon icon="solar:document-text-outline" class="menu-icon"></iconify-icon>
                    <span>Components</span>
                </a>
                <ul class="sidebar-submenu">
                    <li>
                        <a href="typography.html"><i
                                class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> Typography</a>
                    </li>
                    <li>
                        <a href="colors.html"><i class="ri-circle-fill circle-icon text-warning-main w-auto"></i>
                            Colors</a>
                    </li>
                    <li>
                        <a href="button.html"><i class="ri-circle-fill circle-icon text-success-main w-auto"></i>
                            Button</a>
                    </li>
                    <li>
                        <a href="dropdown.html"><i class="ri-circle-fill circle-icon text-lilac-600 w-auto"></i>
                            Dropdown</a>
                    </li>
                    <li>
                        <a href="alert.html"><i class="ri-circle-fill circle-icon text-warning-main w-auto"></i>
                            Alerts</a>
                    </li>
                    <li>
                        <a href="card.html"><i class="ri-circle-fill circle-icon text-danger-main w-auto"></i>
                            Card</a>
                    </li>
                    <li>
                        <a href="carousel.html"><i class="ri-circle-fill circle-icon text-info-main w-auto"></i>
                            Carousel</a>
                    </li>
                    <li>
                        <a href="avatar.html"><i class="ri-circle-fill circle-icon text-success-main w-auto"></i>
                            Avatars</a>
                    </li>
                    <li>
                        <a href="progress.html"><i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i>
                            Progress bar</a>
                    </li>
                    <li>
                        <a href="tabs.html"><i class="ri-circle-fill circle-icon text-warning-main w-auto"></i>
                            Tab & Accordion</a>
                    </li>
                    <li>
                        <a href="pagination.html"><i
                                class="ri-circle-fill circle-icon text-danger-main w-auto"></i> Pagination</a>
                    </li>
                    <li>
                        <a href="badges.html"><i class="ri-circle-fill circle-icon text-info-main w-auto"></i>
                            Badges</a>
                    </li>
                    <li>
                        <a href="tooltip.html"><i class="ri-circle-fill circle-icon text-lilac-600 w-auto"></i>
                            Tooltip & Popover</a>
                    </li>
                    <li>
                        <a href="videos.html"><i class="ri-circle-fill circle-icon text-cyan w-auto"></i>
                            Videos</a>
                    </li>
                    <li>
                        <a href="star-rating.html"><i class="ri-circle-fill circle-icon text-indigo w-auto"></i>
                            Star Ratings</a>
                    </li>
                    <li>
                        <a href="tags.html"><i class="ri-circle-fill circle-icon text-purple w-auto"></i> Tags</a>
                    </li>
                    <li>
                        <a href="list.html"><i class="ri-circle-fill circle-icon text-red w-auto"></i> List</a>
                    </li>
                    <li>
                        <a href="calendar.html"><i class="ri-circle-fill circle-icon text-yellow w-auto"></i>
                            Calendar</a>
                    </li>
                    <li>
                        <a href="radio.html"><i class="ri-circle-fill circle-icon text-orange w-auto"></i>
                            Radio</a>
                    </li>
                    <li>
                        <a href="switch.html"><i class="ri-circle-fill circle-icon text-pink w-auto"></i>
                            Switch</a>
                    </li>
                    <li>
                        <a href="image-upload.html"><i
                                class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> Upload</a>
                    </li>
                </ul>
            </li> --}}
            {{-- <li class="dropdown">
                <a href="javascript:void(0)">
                    <iconify-icon icon="heroicons:document" class="menu-icon"></iconify-icon>
                    <span>Forms</span>
                </a>
                <ul class="sidebar-submenu">
                    <li>
                        <a href="form.html"><i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i>
                            Input Forms</a>
                    </li>
                    <li>
                        <a href="form-layout.html"><i
                                class="ri-circle-fill circle-icon text-warning-main w-auto"></i> Input Layout</a>
                    </li>
                    <li>
                        <a href="form-validation.html"><i
                                class="ri-circle-fill circle-icon text-success-main w-auto"></i> Form
                            Validation</a>
                    </li>
                    <li>
                        <a href="wizard.html"><i class="ri-circle-fill circle-icon text-danger-main w-auto"></i>
                            Form Wizard</a>
                    </li>
                </ul>
            </li> --}}
            {{-- <li class="dropdown">
                <a href="javascript:void(0)">
                    <iconify-icon icon="mingcute:storage-line" class="menu-icon"></iconify-icon>
                    <span>Table</span>
                </a>
                <ul class="sidebar-submenu">
                    <li>
                        <a href="table-basic.html"><i
                                class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> Basic Table</a>
                    </li>
                    <li>
                        <a href="table-data.html"><i
                                class="ri-circle-fill circle-icon text-warning-main w-auto"></i> Data Table</a>
                    </li>
                </ul>
            </li> --}}
            {{-- <li class="dropdown">
                <a href="javascript:void(0)">
                    <iconify-icon icon="solar:pie-chart-outline" class="menu-icon"></iconify-icon>
                    <span>Chart</span>
                </a>
                <ul class="sidebar-submenu">
                    <li>
                        <a href="line-chart.html"><i
                                class="ri-circle-fill circle-icon text-danger-main w-auto"></i> Line Chart</a>
                    </li>
                    <li>
                        <a href="column-chart.html"><i
                                class="ri-circle-fill circle-icon text-warning-main w-auto"></i> Column Chart</a>
                    </li>
                    <li>
                        <a href="pie-chart.html"><i
                                class="ri-circle-fill circle-icon text-success-main w-auto"></i> Pie Chart</a>
                    </li>
                </ul>
            </li> --}}
            {{-- <li>
                <a href="widgets.html">
                    <iconify-icon icon="fe:vector" class="menu-icon"></iconify-icon>
                    <span>Widgets</span>
                </a>
            </li> --}}
            
            {{-- <li class="sidebar-menu-group-title">Application</li> --}}

            {{-- <li class="dropdown">
                <a href="javascript:void(0)">
                    <iconify-icon icon="simple-line-icons:vector" class="menu-icon"></iconify-icon>
                    <span>Authentication</span>
                </a>
                <ul class="sidebar-submenu">
                    <li>
                        <a href="sign-in.html"><i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i>
                            Sign In</a>
                    </li>
                    <li>
                        <a href="sign-up.html"><i class="ri-circle-fill circle-icon text-warning-main w-auto"></i>
                            Sign Up</a>
                    </li>
                    <li>
                        <a href="forgot-password.html"><i
                                class="ri-circle-fill circle-icon text-info-main w-auto"></i> Forgot Password</a>
                    </li>
                </ul>
            </li> --}}
            {{-- <li>
                <a href="gallery.html">
                    <iconify-icon icon="solar:gallery-wide-linear" class="menu-icon"></iconify-icon>
                    <span>Gallery</span>
                </a>
            </li>
            <li>
                <a href="pricing.html">
                    <iconify-icon icon="hugeicons:money-send-square" class="menu-icon"></iconify-icon>
                    <span>Pricing</span>
                </a>
            </li>
            <li>
                <a href="faq.html">
                    <iconify-icon icon="mage:message-question-mark-round" class="menu-icon"></iconify-icon>
                    <span>FAQs.</span>
                </a>
            </li>
            <li>
                <a href="error.html">
                    <iconify-icon icon="streamline:straight-face" class="menu-icon"></iconify-icon>
                    <span>404</span>
                </a>
            </li> --}}
            <li>
                <a href="{{ route('admin.dashboard') }}">
                    <iconify-icon icon="solar:home-smile-angle-outline" class="menu-icon"></iconify-icon>
                    <span>Dashboard</span>
                </a>
            </li>
            @if($canViewUsers)
            <li class="dropdown">
                <a href="javascript:void(0)" class="{{ request()->routeIs('admin.teacher.index', 'admin.teacher.create', 'admin.teacher.edit', 'admin.student.index', 'admin.student.create', 'admin.student.edit', 'admin.admin.index', 'admin.admin.create', 'admin.admin.edit') ? 'active-page' : '' }}">
                    <iconify-icon icon="flowbite:users-group-outline" class="menu-icon"></iconify-icon>
                    <span>Users</span>
                </a>
                <ul class="sidebar-submenu" style="{{ request()->routeIs('admin.teacher.index', 'admin.teacher.create', 'admin.teacher.edit', 'admin.student.index', 'admin.student.create', 'admin.student.edit', 'admin.admin.index', 'admin.admin.create', 'admin.admin.edit') ? 'display:block;' : '' }}">
                    @can('teacher-list')
                        <li>
                            <a href="{{ route('admin.teacher.index') }}" class="{{ request()->routeIs('admin.teacher.index', 'admin.teacher.create', 'admin.teacher.edit') ? 'active-page' : '' }}">
                                <iconify-icon icon="flowbite:users-group-outline" class="menu-icon"></iconify-icon>
                                <span>Teachers</span>
                            </a>
                        </li>
                    @endcan
                    @can('student-list')
                        <li>
                            <a href="{{ route('admin.student.index') }}" class="{{ request()->routeIs('admin.student.index', 'admin.student.create', 'admin.student.edit') ? 'active-page' : '' }}">
                                <iconify-icon icon="flowbite:users-group-outline" class="menu-icon"></iconify-icon>
                                <span>Students</span>
                            </a>
                        </li>
                    @endcan
                    @can('admin-list')
                        <li>
                            <a href="{{ route('admin.admin.index') }}" class="{{ request()->routeIs('admin.admin.index', 'admin.admin.create', 'admin.admin.edit') ? 'active-page' : '' }}">
                                <iconify-icon icon="flowbite:users-group-outline" class="menu-icon"></iconify-icon>
                                <span>Admins</span>
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
            @endif
            @can('subscription-list')
                <li>
                    <a href="{{ route('admin.subscription.index') }}" class="{{ request()->routeIs('admin.subscription.index', 'admin.subscription.create', 'admin.subscription.edit') ? 'active-page' : '' }}">
                        <iconify-icon icon="streamline:subscription-cashflow" class="menu-icon"></iconify-icon>
                        <span>Subcriptions</span>
                    </a>
                </li>
            @endcan
            @can('location-list')
                <li>
                    <a href="{{ route('admin.location.index') }}" class="{{ request()->routeIs('admin.location.index', 'admin.location.create', 'admin.location.edit') ? 'active-page' : '' }}">
                        <iconify-icon icon="mingcute:location-line" class="menu-icon"></iconify-icon>
                        <span>Locations</span>
                    </a>
                </li>
            @endcan
            @can('instrument-list')
                <li>
                    <a href="{{ route('admin.instrument.index') }}" class="{{ request()->routeIs('admin.instrument.index', 'admin.instrument.create', 'admin.instrument.edit') ? 'active-page' : '' }}">
                        <iconify-icon icon="heroicons:musical-note-20-solid" class="menu-icon"></iconify-icon>
                        <span>Instruments</span>
                    </a>
                </li>
            @endcan
            @can('skill-list')
                <li>
                    <a href="{{ route('admin.skill.index') }}" class="{{ request()->routeIs('admin.skill.index', 'admin.skill.create', 'admin.skill.edit') ? 'active-page' : '' }}">
                        <iconify-icon icon="carbon:skill-level-advanced" class="menu-icon"></iconify-icon>
                        <span>Skills</span>
                    </a>
                </li>
            @endcan
            @can('role-list')
                <li>
                    <a href="{{ route('admin.roles.index') }}" class="{{ request()->routeIs('admin.roles.index', 'admin.roles.create', 'admin.roles.edit') ? 'active-page' : '' }}">
                        <iconify-icon icon="oui:app-users-roles" class="menu-icon"></iconify-icon>
                        <span>Roles</span>
                    </a>
                </li>
            @endcan
            {{-- <li>
                <a href="{{ route('admin.termsAndCondition.index') }}">
                    <iconify-icon icon="iconoir:privacy-policy" class="menu-icon"></iconify-icon>
                    <span>Terms & Conditions</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.privacyAndPolicy.index') }}">
                    <iconify-icon icon="iconoir:privacy-policy" class="menu-icon"></iconify-icon>
                    <span>Privacy & Policy</span>
                </a>
            </li> --}}
            @can('cms_setting-list')
                <li>
                    <a href="{{ route('admin.CmsSetting.index') }}">
                        <iconify-icon icon="icon-park-outline:setting-two" class="menu-icon"></iconify-icon>
                        <span>Settings</span>
                    </a>
                </li>
            @endcan
            {{-- <li class="dropdown">
                <a href="javascript:void(0)">
                    <iconify-icon icon="icon-park-outline:setting-two" class="menu-icon"></iconify-icon>
                    <span>Settings</span>
                </a>
                <ul class="sidebar-submenu">
                    <li>
                        <a href="company.html"><i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i>
                            Company</a>
                    </li>
                    <li>
                        <a href="notification.html"><i
                                class="ri-circle-fill circle-icon text-warning-main w-auto"></i> Notification</a>
                    </li>
                    <li>
                        <a href="notification-alert.html"><i
                                class="ri-circle-fill circle-icon text-info-main w-auto"></i> Notification
                            Alert</a>
                    </li>
                    <li>
                        <a href="theme.html"><i class="ri-circle-fill circle-icon text-danger-main w-auto"></i>
                            Theme</a>
                    </li>
                    <li>
                        <a href="currencies.html"><i
                                class="ri-circle-fill circle-icon text-danger-main w-auto"></i> Currencies</a>
                    </li>
                    <li>
                        <a href="language.html"><i class="ri-circle-fill circle-icon text-danger-main w-auto"></i>
                            Languages</a>
                    </li>
                    <li>
                        <a href="payment-gateway.html"><i
                                class="ri-circle-fill circle-icon text-danger-main w-auto"></i> Payment Gateway</a>
                    </li>
                </ul>
            </li> --}}
        </ul>
    </div>
    <div class="sidebar-version">
        <span>{{ siteVersion() }}</span>
    </div>
    
</aside>