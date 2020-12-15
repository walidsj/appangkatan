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
                           <div class="card-body text-center">
                              <div class="form-group mt-3 mb-4">
                                 <img class="img-fluid" src="<?= base_url(); ?>public/assets/img/icon/castle.png" width="144">
                              </div>
                              <div class="form-group">
                                 <h3 class="font-weight-bold">Coming Soon</h3>
                                 <h4>20 Desember 2020</h4>
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