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
                              <h6 class="m-0 font-weight-bold text-primary">Yakin Hapus Semester ini?</h6>
                           </div>
                           <!-- Card Body -->
                           <div class="card-body">
                              <?= form_open(current_url() . '?action=delete&id=' . $semesterItem->idSemester); ?>
                              <div class="form-group">
                                 <p class="text-danger">Dengan menghapus semester ini maka kamu akan menghapus data <strong>Mata Kuliah</strong> dan <strong>Nilai IP Mahasiswa</strong> yang telah diinput yang terhubung.</p>
                              </div>
                              <div class="form-group">
                                 <label>Nama Semester</label>
                                 <input class="form-control" value="<?= $semesterItem->namaSemester ?>" disabled>
                              </div>
                              <div class="form-group">
                                 <label>Qty Mata Kuliah</label>
                                 <input class="form-control" value="<?= $this->db->get_where('matkul', ['semesterMatkul' => $semesterItem->idSemester])->num_rows(); ?>" disabled>
                              </div>
                              <div class="form-group">
                                 <label>Qty IP Mahasiswa</label>
                                 <input class="form-control" value="<?= $this->db->join('matkul', 'matkul.IdMatkul = ip.matkulIp', 'left')->join('semester', 'semester.idSemester = matkul.semesterMatkul', 'left')->get_where('ip', ['idSemester' => $semesterItem->idSemester])->num_rows(); ?>" disabled>
                              </div>
                              <div class=" form-group">
                                 <div class="custom-control custom-checkbox small">
                                    <input name="check" type="checkbox" class="custom-control-input" id="check">
                                    <label class="custom-control-label" for="check">Saya yakin ingin menghapus semester ini.</label>
                                 </div>
                                 <?= form_error('check'); ?>
                              </div>
                              <button type="submit" class="btn btn-primary">Hapus</button>
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