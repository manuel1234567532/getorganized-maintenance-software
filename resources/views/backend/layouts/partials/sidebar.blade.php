<div class="sticky">
    <div class="app-sidebar__overlay" data-bs-toggle="sidebar"></div>
    <div class="app-sidebar">
        <div class="side-header">
            <a class="header-brand1" href="{{ route('dashboard') }}">
                <img src="{{ asset('storage/websiteSettings/sidebar_open_white.png') }}"
                    class="header-brand-img desktop-logo" alt="logo">
                <img src="{{ asset('storage/websiteSettings/sidebar_closed_white.png') }}"
                    class="header-brand-img toggle-logo" alt="logo">
                <img src="{{ asset('storage/websiteSettings/sidebar_closed_dark.png') }}"
                    class="header-brand-img light-logo" alt="logo">
                <img src="{{ asset('storage/websiteSettings/sidebar_open_dark.png') }}" class="header-brand-img light-logo1"
                    alt="logo">
            </a>
            <!-- LOGO -->
        </div>
        <div class="main-sidemenu">
            <div class="slide-left disabled" id="slide-left">
                <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24"
                    viewBox="0 0 24 24">
                    <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z" />
                </svg>
            </div>
            <ul class="side-menu">
                <li class="sub-category">
                    <h3>Main</h3>
                </li>
                <li class="slide">
                    <a class="side-menu__item has-link" data-bs-toggle="slide" href="{{ route('dashboard') }}">
                        <i class="side-menu__icon fe fe-home"></i>
                        <span class="side-menu__label">{{ __('messages.dashboard') }}</span>
                    </a>
                </li>
     @php
    $userRole = \App\Models\RoleAndAccess::where('role_name', Auth::user()->user_type)->first();
@endphp
@php
    $showSpareparts = $userRole->can_view_spareparts === 'yes';
    $showWorkOrders = $userRole->can_view_workorders === 'yes';
    $showIHCategory = $showSpareparts || $showWorkOrders;
    $showTasks = $userRole->can_view_tasks === 'yes';
    $showManageCategory = $showTasks;
@endphp
                @if($showManageCategory)
        <li class="sub-category">
            <h3>Manage</h3>
        </li>
        @if($showTasks)
            @php
                $taskCount = \App\Models\Task::whereIn('status', ['offen', 'in Bearbeitung'])->count();
            @endphp
            <li class="slide">
                <a class="side-menu__item has-link" data-bs-toggle="slide" href="{{ route('tasks.index') }}">
                    <i class="side-menu__icon fe fe-clipboard"></i>
                    <span class="side-menu__label">Tickets</span>
                    @if ($taskCount > 0)
                        <span class="badge bg-green side-badge">{{ $taskCount }}</span>
                    @endif
                </a>
            </li>
        @endif
    </ul>
@endif
            </ul>
@if($showIHCategory)
    <ul class="side-menu">
        <li class="sub-category">
            <h3>IH</h3>
        </li>
        @if($showSpareparts)
            <li class="slide">
                <a class="side-menu__item has-link" data-bs-toggle="slide" href="{{ route('spareparts.index') }}">
                    <i class="side-menu__icon fe fe-square"></i>
                    <span class="side-menu__label">Ersatzteile</span>
                </a>
            </li>
        @endif
        @if($showWorkOrders)
            <li class="slide">
                <a class="side-menu__item" data-bs-toggle="slide" href="{{ route('work-order.index') }}">
                    <i class="side-menu__icon fe fe-server"></i>
                    <span class="side-menu__label">Arbeitsaufträge</span>
                </a>
            </li>
        @endif
    </ul>
@endif

@if ($userRole && $userRole->can_view_filemanager === 'yes')
    <ul class="side-menu">
        <li class="sub-category">
            <h3>Dateien</h3>
        </li>
        <li class="slide">
            <a class="side-menu__item has-link" data-bs-toggle="slide" href="{{ route('filemanager.index') }}">
                <i class="side-menu__icon fe fe-folder"></i>
                <span class="side-menu__label">Dateimanager</span>
            </a>
        </li>
    </ul>
@endif

@if ($userRole && ($userRole->can_view_users === 'yes' || $userRole->can_view_roles === 'yes' || $userRole->can_view_categories === 'yes' || $userRole->can_view_machines === 'yes' || $userRole->can_view_locations === 'yes' || $userRole->can_view_files === 'yes' || $userRole->can_view_departement === 'yes'))
<ul class="side-menu">
        <li class="sub-category">
            <h3>Admin</h3>
        </li>
        <li class="slide">
            <a class="side-menu__item has-link" data-bs-toggle="slide" href="{{ route('settings.index') }}">
                <i class="side-menu__icon fe fe-slack"></i>
                <span class="side-menu__label">Admin Einstellungen</span>
            </a>
        </li>
    </ul>
@endif
</div>
</div>