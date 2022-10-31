<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.1/css/buttons.dataTables.min.css">
<div class="main-content-inner">
    <div class="row">
        <?php //echo json_encode($non_profit_list); exit; ?>
        <div class="col-12 mt-5">
            <div class="card">

                <div class="card-body">
                    <?php if($this->session->flashdata('message')) { ?>
                    		<div role="alert" class="alert alert-success">
                    				<strong><i class="fa fa-check fa-fw"></i> <?php echo $this->session->flashdata('message'); ?></strong>
                    		</div>
                    	<?php } ?>
                       <?php if($this->session->flashdata('error')) { ?>
                                    <div role="alert" class="alert alert-danger">
                                        <strong><i class="fa fa-close fa-fw"></i> <?php echo $this->session->flashdata('error'); ?></strong>
                                    </div>
                                <?php } ?>
                    <h4 style="float:left;" class="header-title">Non Profit List</h4>
                    <a style="float:right; margin-bottom:20px;" class="btn btn-primary" href="<?php echo base_url().'nonprofit/import'; ?>">Bulk Upload Non Profit Data</a>
                    <a style="float:right; margin-bottom:20px; margin-right: 10px;" class="btn btn-primary" href="<?php echo base_url().'nonprofit/add'; ?>">Add Non Profit Data</a>
                    <div class="data-tables">

                        <table id="example" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th>EIN</th>
                                    <th>Name</th>
                                    <th>Address</th>
                                    <th>Sort Name</th>
                                    <th>NTEE Code</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>EIN</th>
                                    <th>Name</th>
                                    <th>Address</th>
                                    <th>Sort Name</th>
                                    <th>NTEE Code</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
             
                                <?php /* $i=0; foreach($non_profit_list as $non_profit) { ?>
                                    <tr>

                                        <td><?php echo $non_profit['ein']; ?></td>
                                        <td><?php echo $non_profit['name']; ?></td>
                                         <td><?php echo $non_profit['address']; ?></td>
                                        <td><?php echo $non_profit['sort_name']; ?></td>
                                        <td><?php echo $non_profit['code']; ?></td>
                                        <td><a href="<?php echo base_url().'nonprofit/edit/'.$non_profit['charity_id']; ?>" title="Edit">Edit</a>&nbsp;||&nbsp;<a href="<?php echo base_url().'nonprofit/delete/'.$non_profit['id']; ?>" title="Delete" class="deleteusers">Delete</a>&nbsp;||&nbsp;<a href="<?php echo base_url().'nonprofit/view_details/'.$non_profit['charity_id']; ?>" title="View">View</a></td>
                                    </tr>
                                <?php } */ ?>
                          
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- data table end -->
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
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
            if (confirm('Confirm Delete Nonprofit Data ?')) {
                window.location.href = url;
            } else {
                e.preventDefault();
                var url1 = $(this).attr('href', '');
                e.stopPropagation();
            }
        });

        var editurl = '<?php echo base_url().'nonprofit/edit/'; ?>';


        $('#example').DataTable({
          //  dom: 'Bfrtip',
          //  buttons: [
          //       'excel'
          //  ],
          // // "deferRender": true,
           "iDisplayLength": 50,
          "aLengthMenu": [[5, 10, 25, 50, 100, 250, 500,-1], [5, 10, 25, 50,100, 250,500, "All"]],
           "pagingType": "full_numbers",
           "responsive": true,
           'processing': true,
           'serverSide': true,
           'serverMethod': 'post',
           'ajax': {
              'url':'<?php echo base_url().'nonprofit/getdata'; ?>'
            },
            'columns': [
                { data: 'ein' },
                { data: 'name' },
                { data: 'address' },
                { data: 'sort_name' },
                { data: 'code' },
                { data: 'url'},
            ]
        });
    });
</script>
