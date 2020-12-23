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
                     <div class="col-lg-4 mb-4">
                        <div class="card shadow mb-4">
                           <!-- Card Body -->
                           <div class="card-body">
                              <div class="form-group text-center mt-3 mb-4">
                                 <img class="img-fluid" src="<?= base_url(); ?>public/assets/img/icon/knight.png" width="144">
                              </div>
                              <div class="form-group">
                                 <label class="font-weight-bold mb-0">Nama Samaran</label>
                                 <span class="d-block"><?= $userSession->samaranUser; ?></span>
                              </div>
                              <div class="form-group">
                                 <label class="font-weight-bold mb-0">No. Pokok Mahasiswa</label>
                                 <span class="d-block"><?= substr($userSession->npmUser, 0, -2) . '**'; ?></span>
                              </div>
                              <div class="form-group">
                                 <label class="font-weight-bold mb-0">Program Studi</label>
                                 <span class="d-block"><?= $userSession->namaProdi; ?></span>
                              </div>
                              <div class="form-group">
                                 <label class="font-weight-bold mb-0">Tanggal Daftar</label>
                                 <span class="d-block"><?= strftime('%d %B %G', strtotime($userSession->createdUser)); ?></span>
                              </div>
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