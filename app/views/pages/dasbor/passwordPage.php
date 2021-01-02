<!DOCTYPE html>
<html lang="en">

<head>
   <?php $this->load->view('layouts/headLayout'); ?>
</head>

<body>

   <body id="page-top" class="sidebar-toggled">
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
                              <h6 class="m-0 font-weight-bold text-primary">Ganti Password</h6>
                           </div>
                           <!-- Card Body -->
                           <div class="card-body">
                              <?= form_open(current_url()); ?>
                              <div class="form-group">
                                 <label>Masukkan Password Lama</label>
                                 <input name="password" type="password" class="form-control" placeholder="Password Lama" value="<?= set_value('password'); ?>">
                                 <?= form_error('password'); ?>
                              </div>
                              <div class="form-group">
                                 <label>Masukkan Password Baru</label>
                                 <input name="newPassword" type="password" class="form-control" placeholder="Password Baru" value="<?= set_value('newPassword'); ?>">
                                 <?= form_error('newPassword'); ?>
                              </div>
                              <div class="form-group">
                                 <button type="submit" class="btn btn-primary">Ganti Password</button>
                              </div>
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