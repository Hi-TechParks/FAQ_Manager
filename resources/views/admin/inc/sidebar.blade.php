<!--- Sidemenu -->
<div id="sidebar-menu">

    <ul class="metismenu" id="side-menu">

        <li class="menu-title">Navigation</li>

        <li>
            <a href="{{ URL::route('dashboard.index') }}">
                <span class="icon"><i class="fas fa-desktop"></i></span>
                <span> Dashboard </span>
            </a>
        </li>

        <li>
            <a href="javascript: void(0);">
                <span class="icon"><i class="fas fa-question-circle"></i></span>
                <span> FAQs List</span>
                <span class="menu-arrow"></span>
            </a>
            <ul class="nav-second-level" aria-expanded="false">
                <li>
                    @can('faq-all')
                    <a href="{{ URL::route('faq.pending') }}">Pending List</a>
                    <a href="{{ URL::route('faq.approve') }}">Approve List</a>
                    <a href="{{ URL::route('faq.reject') }}">Reject List</a>
                    @endcan
                    @can('faq-default-all')
                    <a href="{{ URL::route('faq-default.index') }}">Default FAQ Setup</a>
                    @endcan
                </li>
            </ul>
        </li>

        @can('category-all')
        <li>
            <a href="{{ URL::route('faq-category.index') }}">
                <span class="icon"><i class="fas fa-bars"></i></span>
                <span> FAQ Category </span>
            </a>
        </li>
        @endcan

        @can('location-all')
        <li>
            <a href="{{ URL::route('location.index') }}">
                <span class="icon"><i class="fas fa-map-marker-alt"></i></span>
                <span> Locations </span>
            </a>
        </li>
        @endcan

        @can('user-list')
        <li>
            <a href="{{ URL::route('user.index') }}">
                <span class="icon"><i class="fas fa-users"></i></span>
                <span> Manage Users </span>
            </a>
        </li>
        @endcan

        @can('role-list')
        <li>
            <a href="{{ URL::route('role.index') }}">
                <span class="icon"><i class="fas fa-user-tag"></i></span>
                <span> Manage Roles </span>
            </a>
        </li>
        @endcan

        @can('setting-all')
        <li>
            <a href="{{ URL::route('setting.index') }}">
                <span class="icon"><i class="fas fa-cog"></i></span>
                <span> Settings </span>
            </a>
        </li>
        @endcan
    </ul>

</div>
<!-- End Sidebar -->