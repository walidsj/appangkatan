<!DOCTYPE html>
<html lang="en">

<head>
   <?php $this->load->view('layouts/headLayout'); ?>
</head>

<body>

   <body id="page-top">
      <div id="wrapper">
         <?php $this->load->view('components/sidebarComponent'); ?>
         <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
               <?php $this->load->view('components/navbarComponent'); ?>

               <div class="container-fluid">
                  <?php $this->load->view('components/breadcrumbComponent'); ?>
                  <!-- Content Row -->
                  <div class="row">
                     <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-warning shadow h-100 py-2">
                           <div class="card-body">
                              <div class="row no-gutters align-items-center">
                                 <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                       Jumlah Program Studi</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?= count($prodiList); ?> prodi</div>
                                 </div>
                                 <div class="col-auto">
                                    <i class="fas fa-comments fa-2x text-gray-300"></i>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <!-- Earnings (Monthly) Card Example -->
                     <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-primary shadow h-100 py-2">
                           <div class="card-body">
                              <div class="row no-gutters align-items-center">
                                 <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                       Jumlah Semester</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $semesterCount; ?> semester</div>
                                 </div>
                                 <div class="col-auto">
                                    <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>

                     <!-- Earnings (Monthly) Card Example -->
                     <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-success shadow h-100 py-2">
                           <div class="card-body">
                              <div class="row no-gutters align-items-center">
                                 <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                       Jumlah Mahasiswa</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $userCount; ?> user</div>
                                 </div>
                                 <div class="col-auto">
                                    <i class="fas fa-users fa-2x text-gray-300"></i>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>

                     <!-- Earnings (Monthly) Card Example -->
                     <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-info shadow h-100 py-2">
                           <div class="card-body">
                              <div class="row no-gutters align-items-center">
                                 <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                       Jumlah Mata Kuliah</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $matkulCount; ?> matkul</div>
                                 </div>
                                 <div class="col-auto">
                                    <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>

                  <div class="row">
                     <div class="col-lg-6 mb-4">
                        <div class="card shadow mb-4">
                           <!-- Card Header - Dropdown -->
                           <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                              <h6 class="m-0 font-weight-bold text-primary">Daftar Program Studi</h6>
                           </div>
                           <!-- Card Body -->
                           <div class="card-body">
                              <a href="<?= site_url(); ?>superadmin/prodi?action=tambah" class="btn btn-primary mb-3">Tambah Prodi</a>
                              <div class="table-responsive">
                                 <table class="datatable table table-bordered table-striped" cellspacing="0">
                                    <thead>
                                       <tr>
                                          <th>Nama Prodi</th>
                                          <th>Aksi</th>
                                       </tr>
                                    </thead>
                                    <tbody>
                                       <?php foreach ($prodiList as $prodiItem) : ?>
                                          <tr>
                                             <td><?= ($prodiItem->statusProdi == 1) ? '<i class="fas fa-power-off text-success mr-2"></i>' : '<i class="fas fa-power-off text-secondary mr-2"></i>'; ?> <?= $prodiItem->namaProdi; ?></td>
                                             <td>
                                                <a href="<?= site_url(); ?>superadmin/prodi?action=edit&id=<?= $prodiItem->idProdi; ?>" class="btn btn-warning btn-circle btn-sm">
                                                   <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="<?= site_url(); ?>superadmin/prodi?action=delete&id=<?= $prodiItem->idProdi; ?>" class="btn btn-danger btn-circle btn-sm">
                                                   <i class="fas fa-trash"></i>
                                                </a>
                                             </td>
                                          </tr>
                                       <?php endforeach; ?>
                                    </tbody>
                                 </table>
                              </div>
                           </div>
                        </div>
                     </div>
                     <!-- Content Column -->
                     <div class="col-lg-6 mb-4">
                        <div class="row">
                           <div class="col-12">
                              <div class="card shadow mb-4">
                                 <!-- Card Header - Dropdown -->
                                 <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Admin Prodi</h6>
                                 </div>
                                 <!-- Card Body -->
                                 <div class="card-body">
                                    <a href="<?= site_url(); ?>superadmin/admin/tambah" class="btn btn-primary mb-3">Tambah Admin</a>
                                    <div class="table-responsive">
                                       <table class="datatable table table-bordered table-striped" cellspacing="0">
                                          <thead>
                                             <tr>
                                                <th>Nama Admin</th>
                                                <th>NPM</th>
                                                <th>Prodi</th>
                                                <th>Aksi</th>
                                             </tr>
                                          </thead>
                                          <tbody>
                                             <?php foreach ($adminList as $adminItem) : ?>
                                                <tr>
                                                   <td><?= $adminItem->namaUser; ?></td>
                                                   <td><?= $adminItem->npmUser; ?></td>
                                                   <td><?= $adminItem->namaProdi; ?></td>
                                                   <td>
                                                      <?php if ($adminItem->idUser != $userSession->idUser) : ?>
                                                         <a href="<?= site_url(); ?>superadmin/admin/delete/<?= $adminItem->idUser; ?>" class="btn btn-danger btn-circle btn-sm">
                                                            <i class="fas fa-power-off"></i>
                                                         </a>
                                                      <?php endif; ?>
                                                   </td>
                                                </tr>
                                             <?php endforeach; ?>
                                          </tbody>
                                       </table>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>

               </div>
               <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <?php $this->load->view('components/footerComponent'); ?>
            <!-- End of Footer -->

         </div>
         <!-- End of Content Wrapper -->

      </div>
      <!-- End of Page Wrapper -->


      <?php $this->load->view('layouts/scriptLayout'); ?>
   </body>

</html>