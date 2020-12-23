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
                     <!-- Content Column -->
                     <div class="col-md-3">
                        <div class="card shadow mb-4">
                           <!-- Card Body -->
                           <div class="card-body">
                              <div class="form-group text-center mt-3">
                                 <img class="img-fluid" src="<?= base_url(); ?>public/assets/img/icon/knight.png" width="64">
                              </div>

                              <div class="form-group text-center">
                                 <strong><span class="d-block"><?= $userSession->samaranUser; ?></span></strong>
                                 <span class="d-block"><?= substr($userSession->npmUser, 0, -2) . '**'; ?></span>
                                 <span class="d-block"><?= $userSession->namaProdi; ?></span>
                              </div>
                              <?php
                              function peringkatSaya($userList, $searchId)
                              {

                                 $userListLen = count($userList);
                                 for ($i = 0; $i < $userListLen; $i++) {
                                    if ($userList[$i]['idUser'] == $searchId) return $i + 1;
                                 }

                                 return 0;
                              }
                              ?>
                              <?php if (peringkatSaya($userList, $userSession->idUser) > 0) : ?>
                                 <table class="table table-striped">
                                    <tr>
                                       <th>Peringkat</th>
                                       <td><?= peringkatSaya($userList, $userSession->idUser); ?> <small>dari <?= count($userList); ?></small></td>
                                    </tr>
                                 </table>
                              <?php else : ?>
                                 <table class="table table-striped">
                                    <tr>
                                       <td class="small">Tidak dapat menampilkan peringkat jika data belum diisi</td>
                                    </tr>
                                 </table>
                              <?php endif; ?>
                           </div>
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="card shadow mb-4">
                           <div class="card-header px-2 pb-0 pt-2">
                              <ul class="nav nav-tabs" role="tablist">
                                 <li class="nav-item">
                                    <a href="<?= site_url(); ?>peringkat/parameter" class="nav-link" role="tab">Rank Parameter</a>
                                 </li>
                                 <!-- <li class="nav-item">
                                    <a href="<?= site_url(); ?>peringkat?by=parameter" class="nav-link" role="tab">Nilai IP + Parameter</a>
                                 </li> -->
                                 <li class="nav-item">
                                    <a href="<?= site_url(); ?>peringkat" class="nav-link active" role="tab">Rank IPK</a>
                                 </li>
                              </ul>
                           </div>
                           <div class="card-body">
                              <div class="table-responsive">
                                 <table class="datatable table table-bordered table-striped" cellspacing="0">
                                    <thead>
                                       <tr>
                                          <th width="1%">#</th>
                                          <th>NPM</th>
                                          <th>SKS</th>
                                          <th>IPK</th>
                                       </tr>
                                    </thead>
                                    <tbody>
                                       <?php $noUser = 1; ?>
                                       <?php foreach ($userList as $userItem) : ?>
                                          <tr class="<?= ($userItem['idUser'] == $userSession->idUser) ? 'text-primary' : ''; ?>">
                                             <th><?= $noUser; ?></th>
                                             <td><?= substr($userItem['npmUser'], 0, -2) . '**'; ?> <?= ($userItem['idUser'] == $userSession->idUser) ? '<small>(me)</small>' : ''; ?></td>
                                             <td><?= ($userItem['totalSks'] / $userItem['totalSks'] > 0) ? $userItem['totalSks'] : '0'; ?></td>
                                             <th>
                                                <?= ($userItem['totalAgregatIp'] / $userItem['totalSks'] > 0) ? number_format((float)$userItem['totalAgregatIp'] / $userItem['totalSks'], 2) : '0.00'; ?>
                                             </th>
                                          </tr>
                                          <?php $noUser++; ?>
                                       <?php endforeach; ?>
                                    </tbody>
                                 </table>
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