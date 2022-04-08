<!-- Sidebar Menu -->
<nav class="mt-2">
<ul class="nav nav-pills nav-sidebar flex-initial" data-widget="treeview" role="menu" data-accordion="false">
<!-- Add icons to the links using the .nav-icon class
with font-awesome or any other icon font library -->   
<!--Admin sidebar menu -->
@auth
      @if(Auth::user()->name != "")
      <li class="nav-item">
            <a href="{{ url('manage_files') }}" class="nav-link">
                  <p>Manage Files</p>
            </a>
      </li>
      <!-- end Admin sidebar menu -->
      @endif
@endauth
</ul>
</nav>