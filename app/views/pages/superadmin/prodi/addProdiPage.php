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
                  <div class="row">
                     <!-- Content Column -->
                     <div class="col-lg-6 mb-4">
                        <div class="card shadow mb-4">
                           <!-- Card Header - Dropdown -->
                           <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                              <h6 class="m-0 font-weight-bold text-primary">Tambah Prodi Baru</h6>
                           </div>
                           <!-- Card Body -->
                           <div class="card-body">
                              <?= form_open(current_url() . '?action=tambah'); ?>
                              <div class="form-group">
                                 <label>Nama Prodi</label>
                                 <input name="nama" type="text" class="form-control" placeholder="Nama Prodi" value="<?= set_value('nama'); ?>">
                                 <?= form_error('nama'); ?>
                              </div>
                              <div class="form-group">
                                 <label>NPM Prodi</label>
                                 <small class="d-block">Misal: Penilai 230218****, maka masukkan 230218</small>
                                 <input name="npm" type="text" class="form-control" placeholder="NPM Prodi" value="<?= set_value('npm'); ?>">
                                 <?= form_error('npm'); ?>
                              </div>
                              <button type="submit" class="btn btn-primary">Tambah Prodi</button>
                              <a href="<?= site_url(); ?>superadmin" class="btn btn-secondary">Kembali</a>
                              <?= form_close(); ?>
                           </div>
                        </div>
                     </div>
                  </div>

               </div>
            </div>
            <?php $this->load->view('components/footerComponent'); ?>
            <!-- End of Footer -->

         </div>
         <!-- End of Content Wrapper -->

      </div>
      <!-- End of Page Wrapper -->


      <?php $this->load->view('layouts/scriptLayout'); ?>
   </body>

</html>