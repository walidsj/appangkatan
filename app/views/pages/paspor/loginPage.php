<!DOCTYPE html>
<html lang="en">

<head>
   <?php $this->load->view('layouts/headLayout'); ?>
</head>

<body class="bg-gradient-primary">

   <div class="container">

      <!-- Outer Row -->
      <div class="row justify-content-center">

         <div class="col-md-6 col-lg-4">

            <div class="card o-hidden border-0 shadow-lg my-5">
               <div class="card-body p-0">
                  <!-- Nested Row within Card Body -->
                  <div class="row">
                     <div class="col-12">
                        <div class="p-5">
                           <div class="text-center">
                              <img src="<?= base_url(); ?>public/assets/img/icon/shield.png" width="72">
                              <h1 class="h4 text-gray-900 mb-4 mt-2">Login</h1>
                           </div>
                           <?= form_open(current_url()); ?>
                           <div class="form-group">
                              <input name="npm" type="text" class="form-control" placeholder="No. Pokok Mahasiswa">
                              <?= form_error('npm'); ?>
                           </div>
                           <div class="form-group">
                              <input name="password" type="password" class="form-control" placeholder="Password">
                              <?= form_error('password'); ?>
                           </div>
                           <button type="submit" class="btn btn-primary btn-block">
                              Login
                           </button>
                           <?= form_close(); ?>
                           <hr>
                           <div class="text-center">
                              <a class="small" href="<?= site_url(); ?>paspor/registrasi">Registrasi Akun</a>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>

         </div>

      </div>

   </div>

   <?php $this->load->view('layouts/scriptLayout'); ?>
</body>

</html>