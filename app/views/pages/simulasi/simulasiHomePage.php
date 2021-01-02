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
               <?php $this->load->view('components/breadcrumbComponent'); ?>
               <div class="row">
                  <div class="col-12 mb-4">
                     <div class="card shadow mb-4">
                        <div class="card-header px-2 pb-0 pt-2">
                           <ul class="nav nav-tabs" role="tablist">
                              <?php foreach ($semesterList as $semesterItem) : ?>
                                 <li class="nav-item">
                                    <a href="<?= current_url(); ?>?semester=<?= $semesterItem->idSemester; ?>" class="nav-link <?= ($this->input->get('semester', true) == $semesterItem->idSemester || (!empty($selectedSemester) && $selectedSemester == $semesterItem->idSemester)) ? 'active' : ''; ?>" role="tab"><?= $semesterItem->namaSemester; ?></a>
                                 </li>
                              <?php endforeach; ?>
                           </ul>
                        </div>
                        <div class="card-body">
                           <div class="tab-content">
                              <div class="tab-pane text-left fade show active" role="tabpanel">
                                 <?php if (!empty($matkulList)) : ?>

                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-primary mb-4" data-toggle="modal" data-target="#exampleModal">
                                       Lihat/Ganti Proporsi
                                    </button>

                                    <!-- Modal -->
                                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                       <div class="modal-dialog modal-lg" role="document">
                                          <div class="modal-content">
                                             <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Proporsi Nilai (%)</h5>
                                                <br>
                                                Perubahan proporsi hanya bersifat sementara, jika direfresh proporsi akan berubah menjadi default.
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                   <span aria-hidden="true">&times;</span>
                                                </button>
                                             </div>
                                             <div class="modal-body">
                                                <div class="table-responsive">
                                                   <table class="table table-bordered table-striped" cellspacing="0">
                                                      <thead>
                                                         <tr>
                                                            <th width="60%">Mata Kuliah</th>
                                                            <th>UTS</th>
                                                            <th>UAS</th>
                                                            <th>Akt</th>
                                                         </tr>
                                                      </thead>
                                                      <tbody>
                                                         <?php foreach ($matkulList as $matkulItem) : ?>
                                                            <tr>
                                                               <td><?= $matkulItem->namaMatkul; ?></td>
                                                               <td>
                                                                  <input id="propUts<?= $matkulItem->idMatkul; ?>" type="text" class="form-control" placeholder="UTS" value="<?= $matkulItem->utsMatkul ?>">
                                                               </td>
                                                               <td>
                                                                  <input id="propUas<?= $matkulItem->idMatkul; ?>" type="text" class="form-control" placeholder="UAS" value="<?= $matkulItem->uasMatkul ?>">
                                                               </td>
                                                               <td>
                                                                  <input id="propAkt<?= $matkulItem->idMatkul; ?>" type="text" class="form-control" placeholder="Akt" value="<?= 100 - ($matkulItem->utsMatkul + $matkulItem->uasMatkul) ?>" disabled>
                                                               </td>
                                                            </tr>
                                                         <?php endforeach; ?>
                                                      </tbody>
                                                   </table>
                                                </div>
                                             </div>
                                             <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Siap</button>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <table class="table table-striped">
                                       <?php
                                       $sksTotal = 0;

                                       foreach ($matkulList as $matkulItem) {
                                          $sksTotal = $sksTotal + $matkulItem->sksMatkul;
                                       }
                                       ?>
                                       <tr>
                                          <th>Jumlah SKS</th>
                                          <td><?= $sksTotal; ?></td>
                                       </tr>
                                       <tr>
                                          <th>Perhitungan IP</th>
                                          <th><span class="text-lg" id="nilaiIp"></span></th>
                                       </tr>
                                    </table>

                                    <?= form_open(current_url() . '?semester=' . $this->input->get('semester', true)); ?>
                                    <div class="table-responsive">
                                       <table class="table table-bordered table-striped" cellspacing="0">
                                          <thead>
                                             <tr>
                                                <th width="1%">#</th>
                                                <th>Mata Kuliah</th>
                                                <th>SKS</th>
                                                <th>N.UTS</th>
                                                <th>N.UAS</th>
                                                <th>N.Akt</th>
                                                <th>Total Nilai</th>
                                                <th>Predikat</th>
                                                <th>Angka</th>
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
                                                      <input id="uts<?= $matkulItem->idMatkul; ?>" name="uts<?= $matkulItem->idMatkul; ?>" type="text" class="form-control" placeholder="Nilai UTS" value="<?= (!empty(set_value('uts' . $matkulItem->idMatkul))) ? set_value('uts' . $matkulItem->idMatkul) : (!empty($matkulItem->utsNilai) ? $matkulItem->utsNilai : ''); ?>">
                                                      <?= form_error($matkulItem->idMatkul); ?>
                                                   </td>
                                                   <td>
                                                      <input id="uas<?= $matkulItem->idMatkul; ?>" name="uas<?= $matkulItem->idMatkul; ?>" type="text" class="form-control" placeholder="Nilai UAS" value="<?= (!empty(set_value('uas' . $matkulItem->idMatkul))) ? set_value('uas' . $matkulItem->idMatkul) : (!empty($matkulItem->uasNilai) ? $matkulItem->uasNilai : ''); ?>">
                                                      <?= form_error($matkulItem->idMatkul); ?>
                                                   </td>
                                                   <td>
                                                      <input id="akt<?= $matkulItem->idMatkul; ?>" name="akt<?= $matkulItem->idMatkul; ?>" type="text" class="form-control" placeholder="Nilai Akt" value="<?= (!empty(set_value('akt' . $matkulItem->idMatkul))) ? set_value('akt' . $matkulItem->idMatkul) : (!empty($matkulItem->aktNilai) ? $matkulItem->aktNilai : ''); ?>">
                                                      <?= form_error($matkulItem->idMatkul); ?>
                                                   </td>
                                                   <th><span id="total<?= $matkulItem->idMatkul; ?>">0.00</span></th>
                                                   <th><span id="predikat<?= $matkulItem->idMatkul; ?>">N/A</span></th>
                                                   <td><span id="angka<?= $matkulItem->idMatkul; ?>">0.00</span></td>
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
                                 <label class="custom-control-label" for="check">Saya ingin menyimpan data nilai ujian biar besok tidak ngisi-ngisi lagi.</label>
                              </div>
                              <?= form_error('check'); ?>
                           </div>
                           <div class="form-group mb-3">
                              <button type="submit" name="semester" value="<?= $semesterItem->idSemester; ?>" class="btn btn-primary">Simpan Nilai</button>
                           </div>
                        </div>
                        <?= form_close(); ?>
                     <?php else : ?>
                        <div class="form-group text-center mt-3 mb-4">
                           <img class="img-fluid" src="<?= base_url(); ?>public/assets/img/icon/execute.png" width="144">
                        </div>
                        <div class="form-group text-center">
                           <h4 class="mb-0">404 Semester</h4>
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

   <script type="text/javascript">
      refreshForm();

      $('input').keyup(function() {
         refreshForm();
      });

      function getPredikat(x) {
         var nilai = x;
         var keluaran;

         <?php foreach ($predikatList as $predikat) : ?>
            <?php if ($predikat->maxPredikat >= 100) : ?>
               if (nilai >= <?= $predikat->minPredikat; ?> && nilai <= <?= $predikat->maxPredikat; ?>) {
                  keluaran = {
                     huruf: "<?= $predikat->namaPredikat; ?>",
                     angka: <?= $predikat->angkaPredikat; ?>
                  };
               }
            <?php else : ?>
               if (nilai >= <?= $predikat->minPredikat; ?> && nilai < <?= $predikat->maxPredikat; ?>) {
                  keluaran = {
                     huruf: "<?= $predikat->namaPredikat; ?>",
                     angka: <?= $predikat->angkaPredikat; ?>
                  };
               }
            <?php endif; ?>
         <?php endforeach; ?>

         return keluaran;
      }

      function refreshForm() {
         var totalAngka = 0;
         var totalSks = 0;
         var nilaiIp;

         <?php foreach ($matkulList as $matkul) : ?>
            var uts<?= $matkul->idMatkul; ?> = parseFloat($('#uts<?= $matkul->idMatkul; ?>').val()) || 0;
            var uas<?= $matkul->idMatkul; ?> = parseFloat($('#uas<?= $matkul->idMatkul; ?>').val()) || 0;
            var akt<?= $matkul->idMatkul; ?> = parseFloat($('#akt<?= $matkul->idMatkul; ?>').val()) || 0;

            var propUts<?= $matkul->idMatkul; ?> = parseFloat($('#propUts<?= $matkul->idMatkul; ?>').val());
            var propUas<?= $matkul->idMatkul; ?> = parseFloat($('#propUas<?= $matkul->idMatkul; ?>').val());
            var propAkt<?= $matkul->idMatkul; ?> = 100 - (propUts<?= $matkul->idMatkul; ?> + propUas<?= $matkul->idMatkul; ?>);

            $('#propAkt<?= $matkul->idMatkul; ?>').val(propAkt<?= $matkul->idMatkul; ?>);

            var nilaiProp<?= $matkul->idMatkul; ?> = uts<?= $matkul->idMatkul; ?> * propUts<?= $matkul->idMatkul; ?> / 100 + uas<?= $matkul->idMatkul; ?> * propUas<?= $matkul->idMatkul; ?> / 100 + akt<?= $matkul->idMatkul; ?> * propAkt<?= $matkul->idMatkul; ?> / 100;

            var predikat<?= $matkul->idMatkul; ?> = getPredikat(nilaiProp<?= $matkul->idMatkul; ?>);

            $('#total<?= $matkul->idMatkul; ?>').text(nilaiProp<?= $matkul->idMatkul; ?>.toFixed(2));

            $('#predikat<?= $matkul->idMatkul; ?>').text(predikat<?= $matkul->idMatkul; ?>.huruf);
            $('#angka<?= $matkul->idMatkul; ?>').text(predikat<?= $matkul->idMatkul; ?>.angka.toFixed(2));

            totalAngka = totalAngka + (parseFloat(predikat<?= $matkul->idMatkul; ?>.angka) * <?= $matkul->sksMatkul; ?>);

            totalSks = totalSks + parseFloat(<?= $matkul->sksMatkul; ?>);
         <?php endforeach; ?>

         nilaiIp = totalAngka / totalSks;

         $('#nilaiIp').text(nilaiIp.toFixed(2));
      };
   </script>

   <body />

</html>