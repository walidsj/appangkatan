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
                  <div class="row">
                     <div class="col-lg-8 mb-4">
                        <div class="card shadow mb-4">
                           <div class="card-header">
                              <h6 class="m-0 font-weight-bold text-primary">Data Parameter Lain-Lain</h6>
                           </div>
                           <div class="card-body">
                              <?= form_open(current_url()); ?>
                              <div class="table-responsive">
                                 <table class="table table-bordered table-striped" cellspacing="0">
                                    <thead>
                                       <tr>
                                          <th width="1%">No.</th>
                                          <th>Nama Parameter</th>
                                          <th>Nilai</th>
                                       </tr>
                                    </thead>
                                    <tbody>
                                       <?php $noPendukung = 1; ?>
                                       <?php foreach ($pendukungList as $pendukungItem) : ?>
                                          <tr>
                                             <td><?= $noPendukung; ?></td>
                                             <td><?= $pendukungItem->namaPendukung; ?></td>
                                             <td>
                                                <input name="<?= $pendukungItem->idPendukung; ?>" type="text" class="form-control" placeholder="<?= $pendukungItem->namaPendukung; ?>" value="<?= (!empty(set_value($pendukungItem->idPendukung))) ? set_value($pendukungItem->idPendukung) : (!empty($pendukungItem->nilaiParameter) ? $pendukungItem->nilaiParameter : ''); ?>">
                                                <?= form_error($pendukungItem->idPendukung); ?>
                                             </td>
                                          </tr>
                                          <?php $noPendukung++; ?>
                                       <?php endforeach; ?>
                                    </tbody>
                                 </table>
                              </div>
                           </div>
                           <div class="card-footer">
                              <div class="form-group mt-2">
                                 <div class="custom-control custom-checkbox small">
                                    <input name="check" type="checkbox" class="custom-control-input" id="check">
                                    <label class="custom-control-label" for="check">Saya sedang mengubah data dan yakin data yang saya isikan sudah benar.</label>
                                 </div>
                                 <?= form_error('check'); ?>
                              </div>
                              <div class="form-group mb-3">
                                 <button type="submit" name="semester" class="btn btn-primary">Submit Data</button>
                              </div>
                           </div>
                           <?= form_close(); ?>
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


      <?php $this->load->view('layouts/scriptLayout'); ?>
   </body>

</html>