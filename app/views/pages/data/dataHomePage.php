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
                           <div class="card-header px-2 pb-0 pt-2">
                              <ul class="nav nav-tabs" role="tablist">
                                 <?php foreach ($semesterList as $semesterItem) : ?>
                                    <li class="nav-item">
                                       <a href="<?= site_url(); ?>data?semester=<?= $semesterItem->idSemester; ?>" class="nav-link <?= ($this->input->get('semester', true) == $semesterItem->idSemester || (!empty($selectedSemester) && $selectedSemester == $semesterItem->idSemester)) ? 'active' : ''; ?>" role="tab"><?= $semesterItem->namaSemester; ?></a>
                                    </li>
                                 <?php endforeach; ?>
                              </ul>
                           </div>
                           <div class="card-body">
                              <div class="tab-content">
                                 <div class="tab-pane text-left fade show active" role="tabpanel">
                                    <?php if (!empty($matkulList)) : ?>
                                       <table class="table table-striped">
                                          <?php
                                          $sksTotal = 0;
                                          $ipAgregat = 0;

                                          $jumlahMatkul = count($matkulList);
                                          $terisiMatkul = 0;

                                          foreach ($matkulList as $matkulItem) {
                                             $sksTotal = $sksTotal + $matkulItem->sksMatkul;
                                             $ipAgregat = $ipAgregat + $matkulItem->sksMatkul * $matkulItem->angkaPredikat;
                                             if (!empty($matkulItem->predikatIp)) {
                                                $terisiMatkul++;
                                             }
                                          }
                                          ?>
                                          <tr>
                                             <th>Jumlah SKS</th>
                                             <td><?= $sksTotal; ?></td>
                                          </tr>
                                          <tr>
                                             <th>IP Semester</th>
                                             <td><?= number_format($ipAgregat / $sksTotal, 2); ?></td>
                                          </tr>
                                       </table>
                                       <h4 class="small font-weight-bold">Progres Pengisian <span class="float-right"><?= round((float)($terisiMatkul / $jumlahMatkul) * 100) . '%'; ?></span></h4>
                                       <div class="progress mb-4">
                                          <div class="progress-bar" role="progressbar" style="width: <?= round((float)($terisiMatkul / $jumlahMatkul) * 100) . '%'; ?>" aria-valuenow="<?= round((float)($terisiMatkul / $jumlahMatkul) * 100); ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                       </div>
                                       <?= form_open(current_url() . '?semester=' . $this->input->get('semester', true)); ?>
                                       <div class="table-responsive">
                                          <table class="table table-bordered table-striped" cellspacing="0">
                                             <thead>
                                                <tr>
                                                   <th width="1%">No</th>
                                                   <th>Mata Kuliah</th>
                                                   <th>SKS</th>
                                                   <th width="1%">Predikat</th>
                                                </tr>
                                             </thead>
                                             <tbody>
                                                <?php $noMatkul = 1; ?>
                                                <?php foreach ($matkulList as $matkulItem) : ?>
                                                   <tr>
                                                      <td><?= $noMatkul; ?></td>
                                                      <td><?= $matkulItem->namaMatkul; ?></td>
                                                      <td><?= $matkulItem->sksMatkul; ?></td>
                                                      <td>
                                                         <div class="form-group">
                                                            <select name="<?= $matkulItem->idMatkul; ?>" class="form-control">
                                                               <option selected value="" disabled>Pilih</option>
                                                               <?php foreach ($predikatList as $predikatItem) : ?>
                                                                  <option value="<?= $predikatItem->idPredikat; ?>" <?= ($matkulItem->predikatIp == $predikatItem->idPredikat) ? 'selected' : ((set_value($matkulItem->idMatkul) == $predikatItem->idPredikat) ? 'selected' : ''); ?>><?= $predikatItem->namaPredikat; ?></option> <?php endforeach; ?>
                                                            </select>
                                                            <?= form_error($matkulItem->idMatkul); ?>
                                                         </div>
                                                      </td>
                                                   </tr>
                                                   <?php $noMatkul++; ?>
                                                <?php endforeach; ?>
                                             </tbody>
                                          </table>
                                       </div>
                                 </div>
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
                                 <button type="submit" name="semester" value="<?= $semesterItem->idSemester; ?>" class="btn btn-primary">Submit Data</button>
                              </div>
                           </div>
                           <?= form_close(); ?>
                        <?php else : ?>
                           <div class="form-group text-center mt-3 mb-4">
                              <img class="img-fluid" src="<?= base_url(); ?>public/assets/img/icon/execute.png" width="144">
                           </div>
                           <div class="form-group text-center">
                              <h4 class="mb-0">Pilih Semester</h4>
                              <h5>Data Not Found</h5>
                           </div>
                        <?php endif; ?>
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