<a class="scroll-to-top rounded" href="#page-top">
   <i class="fas fa-angle-up"></i>
</a>

<!-- Bootstrap core JavaScript-->
<script src="<?= base_url(); ?>public/assets/vendor/jquery/jquery.min.js"></script>
<script src="<?= base_url(); ?>public/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="<?= base_url(); ?>public/assets/vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Vendor plugin JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.22/r-2.2.6/datatables.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="<?= base_url(); ?>public/assets/js/sb-admin-2.min.js"></script>

<script type="text/javascript">
   $('select').each(function() {
      $(this).select2({
         theme: 'bootstrap4',
         width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
         allowClear: Boolean($(this).data('allow-clear')),
      });
   });
   var columnDefs = [{
      type: "any-number",
      targets: 1
   }];
   $('.datatable').DataTable({
      "paging": true,
      "lengthChange": false,
      "info": true,
      "autoWidth": false,
      "responsive": true,
      "columnDefs": columnDefs
   });
   $('.dataTables_filter input[type="search"]').css({
      width: '100px',
      display: 'inline-block'
   });
   $('form').submit(function() {
      Swal.fire({
         title: "Memuat",
         text: "Mengirim data formulir",
         showLoaderOnConfirm: true,
         showConfirmButton: false,
         showCloseButton: false,
         showCancelButton: false,
         allowOutsideClick: false,
         allowEscapeKey: false,
         onOpen: () => {
            swal.showLoading();
         },
      });
      return true;
   });
</script>

<?php if ($this->session->flashdata('alert')) : ?>
   <?php $alert = explode('|', $this->session->flashdata('alert')); ?>
   <script type="text/javascript">
      Swal.fire({
         icon: "<?= $alert[0]; ?>",
         title: "<?= $alert[1]; ?>",
         text: "<?= $alert[2]; ?>"
      });
   </script>
<?php endif; ?>