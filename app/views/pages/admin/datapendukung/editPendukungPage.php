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
                              <h6 class="m-0 font-weight-bold text-primary">Edit Parameter</h6>
                           </div>
                           <!-- Card Body -->
                           <div class="card-body">
                              <?= form_open(current_url() . '?action=edit&id=' . $pendukungItem->idPendukung); ?>
                              <div class="form-group">
                                 <label>Nama Parameter</label>
                                 <input name="nama" type="text" class="form-control" placeholder="Nama Parameter" value="<?= $pendukungItem->namaPendukung; ?>">
                                 <?= form_error('nama'); ?>
                              </div>
                              <div class="form-group">
                                 <label>Proporsi Penilaian %</label>
                                 <input name="proporsi" type="text" class="form-control" placeholder="Proporsi Penilaian" value="<?= $pendukungItem->proporsiPendukung; ?>">
                                 <?= form_error('proporsi'); ?>
                              </div>
                              <div class="form-group">
                                 <label>Pembagi (Nilai Maksimal, jika tidak ada isi 1)</label>
                                 <input name="pembagi" type="text" class="form-control" placeholder="Proporsi Penilaian" value="<?= $pendukungItem->pembagiPendukung; ?>">
                                 <?= form_error('pembagi'); ?>
                              </div>
                              <div class="form-group">
                                 <label>Jenis Parameter</label>
                                 <select name="validasi" class="form-control">
                                    <option selected>Pilih Jenis</option>
                                    <option value="" <?= ($pendukungItem->validasiPendukung == '') ? 'selected' : null; ?>>bebas</option>
                                    <option value="numeric" <?= ($pendukungItem->validasiPendukung == 'numeric') ? 'selected' : null; ?>>numeric</option>
                                    <option value="alpha" <?= ($pendukungItem->validasiPendukung == 'alpha') ? 'selected' : null; ?>>alpha</option>
                                    <option value="alphanumeric" <?= ($pendukungItem->validasiPendukung == 'alphanumeric') ? 'selected' : null; ?>>alphanumeric</option>
                                 </select>
                                 <?= form_error('validasi'); ?>
                              </div>
                              <div class="form-group">
                                 <label>Status</label>
                                 <select name="status" class="form-control">
                                    <option selected>Status Pendukung</option>
                                    <option value="1" <?= ($pendukungItem->statusPendukung == 1) ? 'selected' : null; ?>>Aktif</option>
                                    <option value="0" <?= ($pendukungItem->statusPendukung == 0) ? 'selected' : null; ?>>Nonaktif</option>
                                 </select>
                                 <?= form_error('status'); ?>
                              </div>
                              <button type="submit" class="btn btn-primary">Edit Pendukung</button>
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