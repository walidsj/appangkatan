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
                           <?php if (!empty($pendukungList)) : ?>
                              <?php
                              $terisiParameter = 0;
                              $jumlahParameter = count($pendukungList);

                              foreach ($pendukungList as $pendukungItem) {
                                 if (!empty($pendukungItem->idParameter)) {
                                    $terisiParameter++;
                                 }
                              }
                              ?>
                              <?= form_open(current_url()); ?>
                              <div class="card-body">
                                 <h4 class="small font-weight-bold">Progres Pengisian <span class="float-right"><?= round((float)($terisiParameter / $jumlahParameter) * 100) . '%'; ?></span></h4>
                                 <div class="progress mb-4">
                                    <div class="progress-bar" role="progressbar" style="width: <?= round((float)($terisiParameter / $jumlahParameter) * 100) . '%'; ?>" aria-valuenow="<?= round((float)($terisiParameter / $jumlahParameter) * 100); ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                 </div>
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
                           <?php else : ?>
                              <div class="form-group text-center mt-3 mb-4">
                                 <img class="img-fluid" src="<?= base_url(); ?>public/assets/img/icon/execute.png" width="144">
                              </div>
                              <div class="form-group text-center">
                                 <h5>Data Not Found</h5>
                              </div>
                           <?php endif; ?>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <?php $this->load->view('components/footerComponent'); ?>
         </div>
      </div>

      <?php $this->load->view('layouts/scriptLayout'); ?>
   </body>

</html>