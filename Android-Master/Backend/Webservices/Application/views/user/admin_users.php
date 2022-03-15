<div class="main-content-inner">
    <div class="row">
        <!-- data table start -->
        <div class="col-12 mt-5">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Admin Users</h4>
                    <div class="data-tables">
                        <table id="dataTable" class="">
                            <thead class="bg-light text-capitalize">
                                <tr>
                                    <th>Name</th>
                                    <th>Username</th>
                                    <th>Active</th>
                                    <th>Last Login</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($users as $user) { ?>
                                    <tr>
                                        <td><?php echo $user['name']; ?></td>
                                        <td><?php echo $user['username']; ?></td>
                                        <td><?php echo $user['active']; ?></td>
                                        <td><?php echo date("d-M-Y h:i a", strtotime($user['last_login'])); ?></td>
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
        $('#dataTable').DataTable( {
           dom: 'Bfrtip',
           buttons: [
                'excel'
           ]
        });
    });
</script>
