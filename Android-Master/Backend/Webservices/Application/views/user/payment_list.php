<div class="main-content-inner">
    <div class="row">
        <!-- data table start -->
        <div class="col-12 mt-5">
            <div class="card">
                <div class="card-body">
                    <?php if($this->session->flashdata('message')) { ?>
                            <div role="alert" class="alert alert-success">
                                    <strong><i class="fa fa-check fa-fw"></i> <?php echo $this->session->flashdata('message'); ?></strong>
                            </div>
                        <?php } ?>
                  <h4 style="float:left;" class="header-title">User List</h4>

                    <div class="data-tables">
                        <table id="dataTable" class="">
                            <thead class="bg-light text-capitalize">
                                <tr>
                                    <th>Transaction ID</th>
                                     <th>EIN</th>
                                    <th>Charity Name</th>
                                    <th>User Name</th>
                                    <th>User Email</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($payment as $user) { ?>
                                    <tr>
                                        <td><?php echo $user[DB_prefix."TRANSACTION_ID"]; ?></td>
                                         <td><?php echo $user[DB_prefix."EIN"]; ?></td>
                                        <td><?php echo $user['cname']; ?></td>
                                        <?php $query = $this->db->query("SELECT * from ".DB_prefix."users  WHERE ".DB_prefix."ID = ".$user[DB_prefix."USER_ID"]);
                                        $result = $query->row_array(); ?>

                                        <td><?php echo $result[DB_prefix."NAME"]; ?></td>
                                        <td><?php echo $result[DB_prefix."EMAIL"]; ?></td>
                                        <td><?php echo $user[DB_prefix."AMOUNT"]; ?></td>
                                        <td><?php echo $user[DB_prefix."STATUS"]; ?></td>

                                        <td><?php echo date("d-M-Y", strtotime($user[DB_prefix."CREATED_AT"])); ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- data table end -->
    </div>
</div>
 <script src="<?php echo base_url(); ?>skins/js/vendor/jquery-2.2.4.min.js"></script>

 <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
 <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.1/css/buttons.dataTables.min.css">
      <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
      <script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
      <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
      <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
      <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>

<script type="text/javascript">
    jQuery(document).ready(function($){
        jQuery(document).on('click', '.deleteusers', function(e){
            var id = $(this).data('id');
            var url = $(this).attr('href');
            if (confirm('Confirm Delete ?')) {
                window.location.href = url;
            } else {
                var url = $(this).attr('href', '');
                window.location.reload();
                e.stopPropagation();
            }
        });


        $('#dataTable').DataTable( {
           dom: 'Bfrtip',
           buttons: [
                'excel'
           ]
   } );
    });
</script>
