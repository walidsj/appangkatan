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
                              <h6 class="m-0 font-weight-bold text-primary">Tambah Parameter Baru</h6>
                           </div>
                           <!-- Card Body -->
                           <div class="card-body">
                              <?= form_open(current_url() . '?action=tambah'); ?>
                              <div class="form-group">
                                 <label>Nama Parameter</label>
                                 <input name="nama" type="text" class="form-control" placeholder="Nama Parameter" value="<?= set_value('nama'); ?>">
                                 <?= form_error('nama'); ?>
                              </div>
                              <div class="form-group">
                                 <label>Jenis Parameter</label>
                                 <select name="validasi" class="form-control">
                                    <option selected>Pilih Jenis</option>
                                    <option value="">bebas</option>
                                    <option value="numeric">numeric</option>
                                    <option value="alpha">alpha</option>
                                    <option value="alphanumeric">alphanumeric</option>
                                 </select>
                                 <?= form_error('validasi'); ?>
                              </div>
                              <button type="submit" class="btn btn-primary">Tambah Parameter</button>
                              <a href="<?= site_url(); ?>admin" class="btn btn-secondary">Kembali</a>
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