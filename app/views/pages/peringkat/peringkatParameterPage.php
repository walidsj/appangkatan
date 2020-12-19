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
                                 <span class="d-block"><?= substr($userSession->npmUser, 0, -2) . 'XX'; ?></span>
                                 <span class="d-block"><?= $userSession->namaProdi; ?></span>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="card shadow mb-4">
                           <div class="card-header px-2 pb-0 pt-2">
                              <ul class="nav nav-tabs" role="tablist">
                                 <li class="nav-item">
                                    <a href="<?= site_url(); ?>peringkat?by=parameter" class="nav-link active" role="tab">Nilai Parameter</a>
                                 </li>
                                 <!-- <li class="nav-item">
                                    <a href="<?= site_url(); ?>peringkat?by=parameter" class="nav-link" role="tab">Nilai IP + Parameter</a>
                                 </li> -->
                                 <li class="nav-item">
                                    <a href="<?= site_url(); ?>peringkat" class="nav-link" role="tab">Nilai IP</a>
                                 </li>
                              </ul>
                           </div>
                           <div class="card-body">
                              <div class="form-group mb-4">
                                 <label class="font-weight-bold">Kategori Parameter</label>
                                 <form class="form-inline">
                                    <input name="by" value="parameter" hidden>
                                    <div class="form-group">
                                       <select name="parameter" class="form-control">
                                          <option value="0" selected>Pilih Parameter</option>
                                          <?php foreach ($pendukungList as $pendukungItem) : ?>
                                             <option value="<?= $pendukungItem->idPendukung; ?>" <?= ($this->input->get('parameter', true) == $pendukungItem->idPendukung) ? 'selected' : null; ?>><?= $pendukungItem->namaPendukung; ?></option> <?php endforeach; ?>
                                       </select>
                                       <button type="submit" class="mx-2 my-2 btn btn-primary">Pilih</button>
                                    </div>
                                 </form>
                              </div>
                              <?php if ($userList) : ?>
                                 <div class="table-responsive">
                                    <table class="datatable table table-bordered table-striped" cellspacing="0">
                                       <thead>
                                          <tr>
                                             <th>Rank</th>
                                             <th>Nama</th>
                                             <th>Nilai</th>
                                          </tr>
                                       </thead>
                                       <tbody>
                                          <?php $noUser = 1; ?>
                                          <?php foreach ($userList as $userItem) : ?>
                                             <tr class="<?= ($userItem['idUser'] == $userSession->idUser) ? 'text-primary' : ''; ?>">
                                                <th><?= str_pad($noUser, 4, '0', STR_PAD_LEFT);; ?></th>
                                                <td><?= $userItem['samaranUser']; ?></td>
                                                <td><?= $userItem['nilaiParameter']; ?></td>
                                             </tr>
                                             <?php $noUser++; ?>
                                          <?php endforeach; ?>
                                       </tbody>
                                    </table>
                                 </div>
                              <?php else : ?>
                                 <div class="form-group text-center mt-3 mb-4">
                                    <img class="img-fluid" src="<?= base_url(); ?>public/assets/img/icon/execute.png" width="144">
                                 </div>
                                 <div class="form-group text-center">
                                    <h4 class="mb-0">Pilih Parameter</h4>
                                    <h5>Data Not Found</h5>
                                 </div>
                              <?php endif; ?>
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