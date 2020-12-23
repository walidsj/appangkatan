 <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
       <i class="fa fa-bars"></i>
    </button>

    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">
       <li class="nav-item dropdown no-arrow mx-1">
          <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
             <i class="fas fa-bell fa-fw"></i>
          </a>
          <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
             <h6 class="dropdown-header">
                Notifikasi
             </h6>
             <a class="dropdown-item d-flex align-items-center">
                <div class="mr-3">
                   <div class="icon-circle bg-primary">
                      <i class="fas fa-file-alt text-white"></i>
                   </div>
                </div>
                <div>
                   <span class="font-weight-bold">Halo, Selamat Datang!</span>
                </div>
             </a>
             <a class="dropdown-item text-center small text-gray-500">Show All Alerts</a>
          </div>
       </li>


       <div class="topbar-divider d-none d-sm-block"></div>

       <!-- Nav Item - User Information -->
       <li class="nav-item dropdown no-arrow">
          <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
             <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?= $userSession->samaranUser; ?></span>
             <img class="img-profile rounded-circle" src="<?= base_url(); ?>public/assets/img/icon/knight.png">
          </a>
          <!-- Dropdown - User Information -->
          <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
             <a class="dropdown-item" href="<?= site_url(); ?>dasbor/profil">
                <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                Profil Saya
             </a>
             <a class="dropdown-item" href="<?= site_url(); ?>dasbor/ganti-password">
                <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                Ganti Password
             </a>
             <div class="dropdown-divider"></div>
             <a class="dropdown-item" href="<?= site_url(); ?>paspor/logout">
                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                Logout
             </a>
          </div>
       </li>

    </ul>

 </nav>