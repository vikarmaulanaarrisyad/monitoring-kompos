 <aside class="main-sidebar sidebar-dark-primary elevation-4">
     <!-- Brand Logo -->
     <a href="{{ route('dashboard') }}" class="brand-link">
         <img src="{{ Storage::url($setting->logo ?? '') }}" alt="Logo" class="brand-image img-circle elevation-3"
             style="opacity: .8">
         <span class="brand-text font-weight-light">{{ $setting->nama_aplikasi ?? config('app.name') }}</span>
     </a>

     <!-- Sidebar -->
     <div class="sidebar">
         <div class="user-panel mt-3 pb-3 mb-3 d-flex">
             <div class="image">
                 <img src="{{ Storage::url(auth()->user()->avatar) }}" class="img-circle elevation-2" alt="User Image">
             </div>
             <div class="info">
                 <a href="{{ route('profile.show') }}" class="d-block">{{ auth()->user()->name }}</a>
             </div>
         </div>

         <!-- Sidebar Menu -->
         <nav class="mt-2">
             <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                 data-accordion="false">
                 <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                 <li class="nav-item">
                     <a href="{{ route('dashboard') }}" class="nav-link">
                         <i class="nav-icon fas fa-tachometer-alt"></i>
                         <p>
                             Dashboard
                         </p>
                     </a>
                 </li>
                 {{--  <li class="nav-item">
                     <a href="{{ route('devices.index') }}" class="nav-link">
                         <i class="nav-icon fas fa-cogs"></i>
                         <p>
                             Data User
                         </p>
                     </a>
                 </li>  --}}
                 {{--  <li class="nav-item">
                     <a href="{{ route('devices.index') }}" class="nav-link">
                         <i class="nav-icon fas fa-cogs"></i>
                         <p>
                             Data Alat
                         </p>
                     </a>
                 </li>  --}}
                 <li class="nav-item">
                     <a href="{{ route('sensordata.index') }}" class="nav-link">
                         <i class="nav-icon fas fa-history"></i>
                         <p>
                             Histori Monitoring
                         </p>
                     </a>
                 </li>
                 <li class="nav-item">
                     <a href="{{ route('setting.index') }}" class="nav-link">
                         <i class="nav-icon fas fa-cog"></i>
                         <p>
                             Pengaturan Aplikasi
                         </p>
                     </a>
                 </li>
                 <li class="nav-item">
                     <a href="javascript:void(0)" class="nav-link"
                         onclick="document.querySelector('#form-logout').submit()">
                         <i class="nav-icon fas fa-sign-out-alt"></i>
                         <p>
                             Logout
                         </p>
                     </a>
                     <form action="{{ route('logout') }}" method="post" id="form-logout">
                         @csrf
                     </form>
                 </li>
             </ul>
         </nav>
         <!-- /.sidebar-menu -->
     </div>
     <!-- /.sidebar -->
 </aside>
