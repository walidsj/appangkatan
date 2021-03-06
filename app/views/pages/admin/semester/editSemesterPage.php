<!DOCTYPE html>
<html lang="en">

<head>
   <?php $this->load->view('layouts/headLayout'); ?>
</head>

<body>

   <body id="page-top" class="sidebar-toggled">
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
                              <h6 class="m-0 font-weight-bold text-primary">Edit Semester</h6>
                           </div>
                           <!-- Card Body -->
                           <div class="card-body">
                              <?= form_open(current_url() . '?action=edit&id=' . $semesterItem->idSemester); ?>
                              <div class="form-group">
                                 <label>Nama Semester</label>
                                 <input name="nama" type="text" class="form-control" placeholder="Nama Semester" value="<?= $semesterItem->namaSemester; ?>">
                                 <?= form_error('nama'); ?>
                              </div>
                              <div class="form-group">
                                 <label>Status</label>
                                 <select name="status" class="form-control">
                                    <option selected>Status Semester</option>
                                    <option value="1" <?= ($semesterItem->statusSemester == 1) ? 'selected' : null; ?>>Selesai</option>
                                    <option value="2" <?= ($semesterItem->statusSemester == 2) ? 'selected' : null; ?>>Ongoing</option>
                                    <option value="0" <?= ($semesterItem->statusSemester == 0) ? 'selected' : null; ?>>Nonaktif</option>
                                 </select>
                                 <?= form_error('status'); ?>
                              </div>
                              <button type="submit" class="btn btn-primary">Edit Semester</button>
                              <a href="<?= site_url(); ?>admin" class="btn btn-secondary">Kembali</a>
                              <?= form_close(); ?>
                           </div>
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