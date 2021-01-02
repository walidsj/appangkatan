<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion toggled" id="accordionSidebar">

   <!-- Sidebar - Brand -->
   <a class="sidebar-brand d-flex align-items-center justify-content-center">
      <div class="sidebar-brand-icon">
         <img class="img-profile rounded-circle" src="<?= base_url(); ?>public/assets/img/icon/horse.png" width="42">
      </div>
      <div class="sidebar-brand-text mx-3"><?= getenv('app.Name'); ?></div>
   </a>


   <!-- Nav Item - Dashboard -->
   <div class="my-3">
      <li class="nav-item <?= ($this->uri->segment(1) == 'dasbor') ? 'active' : ''; ?>">
         <a class="nav-link" href="<?= site_url(); ?>dasbor">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dasbor Saya</span></a>
      </li>
      <li class="nav-item <?= ($this->uri->segment(1) == 'data') ? 'active' : ''; ?>">
         <a class="nav-link" href="<?= site_url(); ?>data">
            <i class="fas fa-fw fa-edit"></i>
            <span>Data Nilai IP</span></a>
      </li>
      <li class="nav-item <?= ($this->uri->segment(1) == 'data-pendukung') ? 'active' : ''; ?>">
         <a class="nav-link" href="<?= site_url(); ?>data-pendukung">
            <i class="fas fa-fw fa-folder"></i>
            <span>Data Pendukung</span></a>
      </li>
      <li class="nav-item <?= ($this->uri->segment(1) == 'peringkat') ? 'active' : ''; ?>">
         <a class="nav-link" href="<?= site_url(); ?>peringkat">
            <i class="fas fa-fw fa-trophy"></i>
            <span>Peringkat</span></a>
      </li>
      <li class="nav-item <?= ($this->uri->segment(1) == 'simulasi') ? 'active' : ''; ?>">
         <a class="nav-link" href="<?= site_url(); ?>simulasi">
            <i class="fas fa-fw fa-globe"></i>
            <span>Simulasi</span></a>
      </li>
      <?php if ($userSession->roleUser >= 1) : ?>
         <li class="nav-item <?= ($this->uri->segment(1) == 'admin') ? 'active' : ''; ?>">
            <a class="nav-link" href="<?= site_url(); ?>admin">
               <i class="fas fa-fw fa-university"></i>
               <span>Admin</span></a>
         </li>
      <?php endif; ?>
      <?php if ($userSession->roleUser >= 2) : ?>
         <li class="nav-item <?= ($this->uri->segment(1) == 'superadmin') ? 'active' : ''; ?>">
            <a class="nav-link" href="<?= site_url(); ?>superadmin">
               <i class="fas fa-fw fa-user-astronaut"></i>
               <span>Super Admin</span></a>
         </li>
      <?php endif; ?>
   </div>


   <!-- Sidebar Toggler (Sidebar) -->
   <div class="text-center d-none d-md-inline">
      <button class="rounded-circle border-0" id="sidebarToggle"></button>
   </div>

</ul>