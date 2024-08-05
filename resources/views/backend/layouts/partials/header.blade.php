<div class="app-header header sticky">
    <div class="container-fluid main-container">
        <div class="d-flex">
            <a aria-label="Hide Sidebar" class="app-sidebar__toggle" data-bs-toggle="sidebar" href="javascript:void(0)"></a>
            <!-- sidebar-toggle-->
            <a class="logo-horizontal " href="{{ route('dashboard') }}">
                <img src="{{ asset('backend/images/brand/logo-getorganized-white.png') }}" class="header-brand-img desktop-logo"
                    alt="logo">
                <img src="{{ asset('backend/images/brand/logo-sidebar.png') }}" class="header-brand-img light-logo1"
                    alt="logo">
            </a>
            <!-- LOGO -->
            <div class="d-flex order-lg-2 ms-auto header-right-icons">
                <!-- SEARCH -->
                <button class="navbar-toggler navresponsive-toggler d-lg-none ms-auto" type="button"
                    data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent-4"
                    aria-controls="navbarSupportedContent-4" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon fe fe-more-vertical"></span>
                </button>
                <div class="navbar navbar-collapse responsive-navbar p-0">
                    <div class="collapse navbar-collapse" id="navbarSupportedContent-4">
                        <div class="d-flex order-lg-2">
                             <div class="d-flex country">
                                <a class="nav-link icon theme-layout nav-link-bg layout-setting">
                                    <span class="dark-layout"><i class="fe fe-moon"></i></span>
                                    <span class="light-layout"><i class="fe fe-sun"></i></span>
                                </a>
                            </div>
                            <!-- Theme-Layout -->
                            <div class="dropdown d-flex">
                                <a class="nav-link icon full-screen-link nav-link-bg">
                                    <i class="fe fe-minimize fullscreen-button"></i>
                                </a>
                            </div>
<!-- BENACHRICHTIGUNGEN -->
<div class="dropdown d-flex notifications">
    <a class="nav-link icon" data-bs-toggle="dropdown">
        <i class="fe fe-bell"></i><span class="pulse"></span>
    </a>
    <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
        <div class="drop-heading border-bottom">
            <div class="d-flex">
                <h6 class="mt-1 mb-0 fs-16 fw-semibold text-dark">Benachrichtigungen</h6>
            </div>
        </div>
        <div class="notifications-menu">
            @php
            $loggedInUsername = Auth::user()->username; // Username des eingeloggten Benutzers

            $notifications = \DB::table('notifications')
                ->where('created_for', $loggedInUsername)
                ->where('status', 'not read') // Nur Benachrichtigungen mit Status 'not read'
                ->where('created_at', '>=', \Carbon\Carbon::now()->subDays(7)) // Anzeige von Benachrichtigungen der letzten 7 Tage
                ->latest('created_at') // Nach Erstellungsdatum absteigend sortieren
                ->take(3) // Begrenze die Anzahl der Einträge auf 4
                ->get();
            @endphp

            @foreach($notifications as $notification)
                <div id="notification-{{ $notification->id }}" class="dropdown-item d-flex justify-content-between align-items-center position-relative">
                    <div class="me-3 notifyimg {{ $notification->type == 'workordercreated' ? 'bg-primary' : ($notification->type == 'workorderdeleted' ? 'bg-danger' : '') }} brround box-shadow-primary small-icon-container">
                        @if ($notification->type == 'workordercreated')
                            <i class="fe fe-mail"></i>
                        @elseif ($notification->type == 'workorderdeleted')
                            <i class="fe fe-trash-2"></i>
                        @endif
                    </div>
                    <div class="me-auto">
                        <h5 class="notification-label mb-1">
                            {{ $notification->message }} <!-- Nachricht -->
                        </h5>
                        <span class="notification-subtext">
                            {{ \Carbon\Carbon::parse($notification->created_at)->diffForHumans() }} <!-- Erstellungsdatum -->
                        </span>
                    </div>
                    <button type="button" class="custom-close position-absolute top-0 end-0 mt-2 me-2" aria-label="Schließen" onclick="markNotificationAsRead({{ $notification->id }})">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            @endforeach
        </div>
        <div class="dropdown-divider m-0"></div>
        <a href="https://getorganized.at/dashboard" class="dropdown-item text-center p-3 text-muted">Alle Benachrichtigungen anzeigen</a>
    </div>
</div>
<!-- END NOTIFICATIONS -->
                            <!-- FULL-SCREEN -->
                            <div class="dropdown d-flex profile-1">
                                <a href="javascript:void(0)" data-bs-toggle="dropdown"
                                    class="nav-link leading-none d-flex">
                                    <img src="{{ getImage(auth()->user()->avatar, true) }}" alt="profile-user"
                                        class="avatar  profile-user brround cover-image">
                                </a>
                         
                               <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
<div class="drop-heading">
   <div class="text-center">
       <h5 class="text-dark mb-0 fs-14 fw-semibold">{{ getFullName(auth()->user()) }}</h5>
       <small class="user-type" id="userType">
           {{ auth()->user()->user_type }}
       </small>
   </div>
</div>

@php
   $userType = auth()->user()->user_type; // Benutzer-Typ aus der Datenbank abrufen
   $roleAccess = \App\Models\RoleAndAccess::where('role_name', $userType)->first(); // Rolle aus roles_and_access-Tabelle abrufen

   $userRoleColor = $roleAccess ? $roleAccess->role_color : '#FFFFFF'; // Hex-Farbcode aus der Rolle abrufen oder Standardfarbe verwenden
@endphp



    <div class="dropdown-divider m-0"></div>
                 
                                        <a class="dropdown-item" href="{{ route('profile.edit', auth()->user()->id) }}">
                                            <i class="dropdown-icon fe fe-user"></i> Profil
                                        </a>
                                    
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                            onclick="event.preventDefault(); this.closest('form').submit();">
                                            <i class="dropdown-icon fe fe-alert-circle"></i> Abmelden
                                        </a>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>