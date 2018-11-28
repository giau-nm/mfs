<aside class="main-sidebar" id="sidebar-wrapper">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        <div class="user-panel text-center" id="user-info-panel" style="height: 45px;">
            <div class="info text-center">
                @if (Auth::guest())
                <p>InfyOm</p>
                @else
                    <p>{{ Auth::user()->name}}</p>
                @endif
            </div>
        </div>


        <ul class="sidebar-menu" data-widget="tree">
            @include('layouts.menu')
        </ul>
    </section>
</aside>