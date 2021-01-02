<!DOCTYPE html>
<html lang="en">

<head>
   <?php $this->load->view('layouts/headLayout'); ?>
</head>

<body id="page-top" class="sidebar-toggled">
   <div id="wrapper">
      <?php $this->load->view('components/sidebarComponent'); ?>
      <div id="content-wrapper" class="d-flex flex-column">
         <div id="content">
            <?php $this->load->view('components/navbarComponent'); ?>

            <div class="container-fluid">
               <div class="row justify-content-center">
                  <div class="col-lg-4">
                     <div class="card o-hidden border-0 shadow-lg mb-4">
                        <div class="card-body p-0">
                           <!-- Nested Row within Card Body -->
                           <div class="row">
                              <div class="col-12">
                                 <div class="p-5">
                                    <div class="text-center">
                                       <h1 class="h4 text-gray-900 mt-2">Masukkan Password</h1>
                                       <p class="text-center small">Pastikan kamu siap 100% sebelum membuka halaman ini.</p>
                                    </div>
                                    <?= form_open(current_url()); ?>
                                    <div class="form-group">
                                       <input name="password" type="password" class="form-control" placeholder="Password Kamu">
                                       <?= form_error('password'); ?>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-block">
                                       Buka Peringkat
                                    </button>
                                    <?= form_close(); ?>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <?php $this->load->view('components/footerComponent'); ?>
      </div>
   </div>

   <?php $this->load->view('layouts/scriptLayout'); ?>

   <body />

</html>