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
                     <div class="col mb-4">
                        <div class="card shadow">
                           <div class="card-body d-flex flex-column justify-content-center py-5 py-xl-4">
                              <div class="row align-items-center">
                                 <div class="col-xl-2 text-center"><img class="img-fluid" src="<?= base_url(); ?>public/assets/img/icon/castle.png" width="144"></div>
                                 <div class="col-xl-10">
                                    <div class="text-center text-xl-left text-xxl-center px-4 mb-4 mb-xl-0">
                                       <h1 class="text-primary mt-3">Halo, <?= $userSession->samaranUser; ?>!</h1>
                                       <p class="text-gray-700 mb-0">Portal ini tidak menyimpan data pribadi kamu dan data yang kamu masukkan sangat dirahasiakan. Data yang terlihat di publik hanya nama samaran kamu, yaitu <strong><?= $userSession->samaranUser; ?> (<?= $userSession->namaProdi; ?>)</strong></p>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <!-- Content Row -->
                  <div class="row">
                     <?php
                     $arraySemester = 0;
                     $arrayIP = 0;
                     $arrayMatkul = 0;

                     foreach ($semesterList as $semesterItem) {
                        $sksTotal = 0;
                        $ipAgregat = 0;

                        $jumlahMatkul = 0;
                        $terisiMatkul = 0;

                        foreach ($matkulList as $matkulItem) {
                           if ($matkulItem->semesterMatkul == $semesterItem->idSemester) {
                              $sksTotal = $sksTotal + $matkulItem->sksMatkul;
                              $ipAgregat = $ipAgregat + $matkulItem->sksMatkul * $matkulItem->angkaPredikat;
                              if (!empty($matkulItem->predikatIp)) {
                                 $terisiMatkul++;
                              }
                              $jumlahMatkul++;
                              $arrayMatkul++;
                           }
                        }

                        if ($jumlahMatkul > 0) {
                           $arrayIP = $arrayIP + $ipAgregat / $sksTotal;
                        }
                        $arraySemester++;
                     }

                     $IPK = $arrayIP / $arraySemester;
                     ?>
                     <!-- Content Column -->
                     <div class="col-lg-6">
                        <div class="row">
                           <div class="col-6">
                              <div class="card bg-success text-white shadow  mb-4">
                                 <div class="card-body">
                                    IP Kumulatif
                                    <div class="font-weight-bold"><?= number_format((float)$IPK, 2); ?></div>
                                 </div>
                              </div>
                           </div>
                           <div class="col-6">
                              <div class="card bg-info text-white shadow  mb-4">
                                 <div class="card-body">
                                    Mata Kuliah
                                    <div class="font-weight-bold"><?= $arrayMatkul; ?></div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="row">
                           <div class="col">
                              <div class="card shadow mb-4">
                                 <!-- Card Header - Dropdown -->
                                 <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Grafik IP</h6>
                                 </div>
                                 <!-- Card Body -->
                                 <div class="card-body">
                                    <div class="chart-area">
                                       <canvas id="IPChart"></canvas>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>

                     <div class="col-lg-6 mb-4">
                        <div class="card shadow mb-4">
                           <div class="card-header py-3">
                              <h6 class="m-0 font-weight-bold text-primary">Kelengkapan Data IP</h6>
                           </div>
                           <div class="card-body">
                              <?php
                              $arraySemester = '';
                              $arrayIP = '';
                              ?>
                              <?php foreach ($semesterList as $semesterItem) : ?>
                                 <?php
                                 $sksTotal = 0;
                                 $ipAgregat = 0;

                                 $jumlahMatkul = 0;
                                 $terisiMatkul = 0;

                                 foreach ($matkulList as $matkulItem) {
                                    if ($matkulItem->semesterMatkul == $semesterItem->idSemester) {
                                       $sksTotal = $sksTotal + $matkulItem->sksMatkul;
                                       $ipAgregat = $ipAgregat + $matkulItem->sksMatkul * $matkulItem->angkaPredikat;
                                       if (!empty($matkulItem->predikatIp)) {
                                          $terisiMatkul++;
                                       }
                                       $jumlahMatkul++;
                                    }
                                 }
                                 ?>
                                 <?php if ($jumlahMatkul > 0) : ?>
                                    <h4 class="small font-weight-bold"><?= $semesterItem->namaSemester; ?> <span class="float-right"><?= ((float)($terisiMatkul / $jumlahMatkul) < 1) ? round((float)($terisiMatkul / $jumlahMatkul) * 100) . '%' : 'Complete'; ?></span></h4>
                                    <div class="progress mb-4">
                                       <div class="progress-bar" role="progressbar" style="width: <?= round((float)($terisiMatkul / $jumlahMatkul) * 100) . '%'; ?>" aria-valuenow="<?= round((float)($terisiMatkul / $jumlahMatkul) * 100); ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                 <?php else : ?>
                                    <h4 class="small font-weight-bold"><?= $semesterItem->namaSemester; ?> <span class="float-right">0%</span></h4>
                                    <div class="progress mb-4">
                                       <div class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                 <?php endif; ?>
                                 <?php
                                 $arraySemester = $arraySemester . '"' . $semesterItem->namaSemester . '",';

                                 if ($jumlahMatkul > 0) {
                                    $arrayIP = $arrayIP . '"' . number_format($ipAgregat / $sksTotal, 2) . '",';
                                 }
                                 ?>
                              <?php endforeach; ?>
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
      <!-- Page level plugins -->
      <script src="<?= base_url(); ?>public/assets/vendor/chart.js/Chart.min.js"></script>
      <script type="text/javascript">
         Chart.defaults.global.defaultFontFamily = 'Product Sans', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
         Chart.defaults.global.defaultFontColor = '#858796';
         var ctx = document.getElementById("IPChart");
         var myLineChart = new Chart(ctx, {
            type: 'line',
            data: {
               labels: [<?= $arraySemester; ?>],
               datasets: [{
                  label: "Indeks Prestasi",
                  lineTension: 0.3,
                  backgroundColor: "rgba(78, 115, 223, 0.05)",
                  borderColor: "rgba(78, 115, 223, 1)",
                  pointRadius: 3,
                  pointBackgroundColor: "rgba(78, 115, 223, 1)",
                  pointBorderColor: "rgba(78, 115, 223, 1)",
                  pointHoverRadius: 3,
                  pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
                  pointHoverBorderColor: "rgba(78, 115, 223, 1)",
                  pointHitRadius: 10,
                  pointBorderWidth: 2,
                  data: [<?= $arrayIP; ?>],
               }],
            },
            options: {
               maintainAspectRatio: false,
               layout: {
                  padding: {
                     left: 10,
                     right: 25,
                     top: 25,
                     bottom: 0
                  }
               },
               scales: {
                  xAxes: [{
                     time: {
                        unit: 'date'
                     },
                     gridLines: {
                        display: false,
                        drawBorder: false
                     },
                     ticks: {
                        maxTicksLimit: 7
                     }
                  }],
                  yAxes: [{
                     gridLines: {
                        color: "rgb(234, 236, 244)",
                        zeroLineColor: "rgb(234, 236, 244)",
                        drawBorder: false,
                        borderDash: [2],
                        zeroLineBorderDash: [2]
                     }
                  }],
               },
               legend: {
                  display: false
               },
               tooltips: {
                  backgroundColor: "rgb(255,255,255)",
                  bodyFontColor: "#858796",
                  titleMarginBottom: 10,
                  titleFontColor: '#6e707e',
                  titleFontSize: 14,
                  borderColor: '#dddfeb',
                  borderWidth: 1,
                  xPadding: 15,
                  yPadding: 15,
                  displayColors: false,
                  intersect: false,
                  mode: 'index',
                  caretPadding: 10,
               }
            }
         });
      </script>
   </body>

</html>