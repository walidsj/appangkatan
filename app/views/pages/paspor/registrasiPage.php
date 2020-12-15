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
                              <img src="<?= base_url(); ?>public/assets/img/icon/knight.png" width="72">
                              <h1 class="h4 text-gray-900 mb-4 mt-2">Registrasi</h1>
                           </div>
                           <?= form_open(current_url()); ?>
                           <div class="form-group">
                              <input name="nama" type="text" class="form-control" placeholder="Nama Asli" value="<?= set_value('nama'); ?>">
                              <?= form_error('nama'); ?>
                           </div>
                           <div class="form-group">
                              <input name="samaran" type="text" class="form-control" placeholder="Nama Samaran" value="<?= set_value('samaran'); ?>">
                              <?= form_error('samaran'); ?>
                           </div>
                           <div class="form-group">
                              <input name="npm" type="text" class="form-control" placeholder="No. Pokok Mahasiswa" value="<?= set_value('npm'); ?>">
                              <?= form_error('npm'); ?>
                           </div>
                           <div class="form-group">
                              <input name="password" type="password" class="form-control" placeholder="Password" value="<?= set_value('password'); ?>">
                              <?= form_error('password'); ?>
                           </div>
                           <div class="form-group">
                              <select name="prodi" class="form-control">
                                 <option selected>Program Studi</option>
                                 <?php foreach ($prodiList as $prodiItem) : ?>
                                    <option value="<?= $prodiItem->idProdi; ?>" <?= (set_value('prodi') == $prodiItem->idProdi) ? 'selected' : null; ?>><?= $prodiItem->namaProdi; ?></option> <?php endforeach; ?>
                              </select>
                              <?= form_error('prodi'); ?>
                           </div>
                           <div class=" form-group">
                              <div class="custom-control custom-checkbox small">
                                 <input name="check" type="checkbox" class="custom-control-input" id="check">
                                 <label class="custom-control-label" for="check">Saya menyetujui ketentuan dan persyaratan <?= getenv('app.Name'); ?>.</label>
                              </div>
                              <?= form_error('check'); ?>
                           </div>
                           <button type="submit" class="btn btn-primary btn-block">
                              Daftar Akun
                           </button>
                           <?= form_close(); ?>
                           <hr>
                           <div class="text-center">
                              <a class="small" href="<?= site_url(); ?>paspor">Sudah punya akun? Login</a>
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