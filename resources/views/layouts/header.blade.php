<header class="main-header">
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </a>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li class="dropdown user user-menu">
                    <a href="{{ route('user.logout') }}" class="dropdown-toggle" >
                        <span class="glyphicon glyphicon-log-out"></span>
                        <span class="hidden-xs">Sign out</span>
                    </a>
                </li>
            </ul>
        </div>
    </nav>
</header>