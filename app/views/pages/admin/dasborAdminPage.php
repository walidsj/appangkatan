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
                                       Program Studi</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $userSession->namaProdi; ?></div>
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
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?= count($semesterList); ?> semester</div>
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
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?= count($userList); ?> user</div>
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
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?= count($matkulList); ?> matkul</div>
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
                              <h6 class="m-0 font-weight-bold text-primary">Daftar Mata Kuliah</h6>
                           </div>
                           <!-- Card Body -->
                           <div class="card-body">
                              <a href="<?= site_url(); ?>admin/matkul?action=tambah" class="btn btn-primary mb-3">Tambah Matkul</a>
                              <div class="table-responsive">
                                 <table class="datatable table table-bordered table-striped" cellspacing="0">
                                    <thead>
                                       <tr>
                                          <th>#</th>
                                          <th>Mata Kuliah</th>
                                          <th>Semester</th>
                                          <th>SKS</th>
                                          <th>Status</th>
                                          <th>Aksi</th>
                                       </tr>
                                    </thead>
                                    <tbody>
                                       <?php
                                       $num = 1;
                                       foreach ($matkulList as $matkulItem) : ?>
                                          <tr>
                                             <td><?= $num; ?></td>
                                             <td><?= $matkulItem->namaMatkul; ?></td>
                                             <td><?= $matkulItem->namaSemester; ?>
                                                <br>
                                                <?= ($matkulItem->statusSemester == 1) ? '<small class="badge badge-success">Selesai</small>' : (($matkulItem->statusSemester == 2) ? '<small class="badge badge-primary">Ongoing</small>' : '<small class="badge badge-secondary">Nonaktif</small>'); ?>
                                             </td>
                                             <td><?= $matkulItem->sksMatkul; ?></td>
                                             <td><?= ($matkulItem->statusMatkul == 1) ? '<span class="badge badge-success">Aktif</span>' : '<span class="badge badge-secondary">Nonaktif</span>'; ?></td>
                                             <td>
                                                <a href="<?= site_url(); ?>admin/matkul?action=edit&id=<?= $matkulItem->idMatkul; ?>" class="btn btn-warning btn-circle btn-sm">
                                                   <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="<?= site_url(); ?>admin/matkul?action=delete&id=<?= $matkulItem->idMatkul; ?>" class="btn btn-danger btn-circle btn-sm">
                                                   <i class="fas fa-trash"></i>
                                                </a>
                                             </td>
                                          </tr>
                                       <?php
                                          $num++;
                                       endforeach; ?>
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
                                    <h6 class="m-0 font-weight-bold text-primary">Daftar Semester</h6>
                                 </div>
                                 <!-- Card Body -->
                                 <div class="card-body">
                                    <a href="<?= site_url(); ?>admin/semester?action=tambah" class="btn btn-primary mb-3">Tambah Semester</a>
                                    <div class="table-responsive">
                                       <table class="datatable table table-bordered table-striped" cellspacing="0">
                                          <thead>
                                             <tr>
                                                <th>#</th>
                                                <th>Nama Semester</th>
                                                <th>Status</th>
                                                <th>Aksi</th>
                                             </tr>
                                          </thead>
                                          <tbody>
                                             <?php
                                             $num = 1;
                                             foreach ($semesterList as $semesterItem) : ?>
                                                <tr>
                                                   <td><?= $num; ?></td>
                                                   <td><?= $semesterItem->namaSemester; ?></td>
                                                   <td><?= ($semesterItem->statusSemester == 1) ? '<small class="badge badge-success">Selesai</small>' : (($semesterItem->statusSemester == 2) ? '<small class="badge badge-primary">Ongoing</small>' : '<small class="badge badge-secondary">Nonaktif</small>'); ?></td>
                                                   <td>
                                                      <a href="<?= site_url(); ?>admin/semester?action=edit&id=<?= $semesterItem->idSemester; ?>" class="btn btn-warning btn-circle btn-sm">
                                                         <i class="fas fa-edit"></i>
                                                      </a>
                                                      <a href="<?= site_url(); ?>admin/semester?action=delete&id=<?= $semesterItem->idSemester; ?>" class="btn btn-danger btn-circle btn-sm">
                                                         <i class="fas fa-trash"></i>
                                                      </a>
                                                   </td>
                                                </tr>
                                             <?php
                                                $num++;
                                             endforeach; ?>
                                          </tbody>
                                       </table>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="col-12">
                              <div class="card shadow mb-4">
                                 <!-- Card Header - Dropdown -->
                                 <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Parameter Data Pendukung</h6>
                                 </div>
                                 <!-- Card Body -->
                                 <div class="card-body">
                                    <a href="<?= site_url(); ?>admin/pendukung?action=tambah" class="btn btn-primary mb-3">Tambah Parameter Pendukung</a>
                                    <div class="table-responsive">
                                       <table class="datatable table table-bordered table-striped" cellspacing="0">
                                          <thead>
                                             <tr>
                                                <th>#</th>
                                                <th>Judul Parameter Pendukung</th>
                                                <th>Jenis Data</th>
                                                <th>Proporsi Penilaian</th>
                                                <th>Pembagi</th>
                                                <th>Status</th>
                                                <th>Aksi</th>
                                             </tr>
                                          </thead>
                                          <tbody>
                                             <?php
                                             $num = 1;
                                             foreach ($pendukungList as $pendukungItem) : ?>
                                                <tr>
                                                   <td><?= $num; ?></td>
                                                   <td><?= $pendukungItem->namaPendukung; ?></td>
                                                   <td><?= ($pendukungItem->validasiPendukung == '') ? 'bebas' : $pendukungItem->validasiPendukung; ?></td>
                                                   <td><?= $pendukungItem->proporsiPendukung; ?>%</td>
                                                   <td><?= $pendukungItem->pembagiPendukung; ?></td>
                                                   <td><?= ($pendukungItem->statusPendukung == 1) ? '<small class="badge badge-success">Aktif</small>' : '<small class="badge badge-secondary">Nonaktif</small>'; ?> </td>
                                                   <td>
                                                      <a href="<?= site_url(); ?>admin/pendukung?action=edit&id=<?= $pendukungItem->idPendukung; ?>" class="btn btn-warning btn-circle btn-sm">
                                                         <i class="fas fa-edit"></i>
                                                      </a>
                                                      <a href="<?= site_url(); ?>admin/pendukung?action=delete&id=<?= $pendukungItem->idPendukung; ?>" class="btn btn-danger btn-circle btn-sm">
                                                         <i class="fas fa-trash"></i>
                                                      </a>
                                                   </td>
                                                </tr>
                                             <?php
                                                $num++;
                                             endforeach; ?>
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