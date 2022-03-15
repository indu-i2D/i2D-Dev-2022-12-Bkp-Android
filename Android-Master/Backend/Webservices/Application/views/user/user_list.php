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
                     <a style="float:right; margin-bottom:20px;" class="btn btn-primary" href="<?php echo base_url().'user/import'; ?>">Import User Data</a>
                      <a style="float:right; margin-bottom:20px; margin-right: 10px;" class="btn btn-primary" href="<?php echo base_url().'user/add'; ?>">Add User Data</a>
                    <div class="data-tables">
                        <table id="dataTable" class="">
                            <thead class="bg-light text-capitalize">
                                <tr>
                                    <th>Name</th>
                                    <th>User Type</th>
                                    <th>Business Name</th>
                                    <th>Email</th>
                                    <th>Phone Number</th>
                                    <th>Gender</th>
                                    <th>Country</th>
                                    <th>Login Type</th>
                                    <th>Terms</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($users as $user) { ?>
                                    <tr>
                                        <td><?php echo $user['name']; ?></td>
                                        <td><?php echo ucfirst(strtolower($user['user_type'])); ?></td>
                                        <?php if($user['user_type'] == 'business') { ?>
                                          <td><?php echo ucfirst(strtolower($user['business_name'])); ?></td>
                                        <?php } else { ?>
                                              <td></td>
                                        <?php } ?>
                                        <td><?php echo $user['email']; ?></td>
                                        <td><?php echo $user['phone_number']; ?></td>
                                        <td><?php echo $user['gender']; ?></td>
                                        <td><?php echo $user['country']; ?></td>
                                        <td><?php echo ucfirst(strtolower($user['login_type'])); ?></td>
                                        <td><?php echo $user['terms']; ?></td>
                                        <td><a href="<?php echo base_url().'user/edit/'.$user['user_id']; ?>" title="Edit">Edit</a>&nbsp;||&nbsp;<a href="<?php echo base_url().'user/delete/'.$user['user_id']; ?>" class="deleteusers" data-id="<?php echo $user['user_id']; ?>" title="View">Delete</a></td>
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
        //
        // $('#dataTable').DataTable({
        //     buttons: [
        //         'copy', 'csv', 'excel', 'pdf', 'print'
        //     ]
        // } );
    });
</script>
