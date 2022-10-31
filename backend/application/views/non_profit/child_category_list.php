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
                    <h4 style="float:left;" class="header-title">Child Category List</h4>
                    <a style="float:right; margin-bottom:20px;" class="btn btn-primary" href="<?php echo base_url().'nonprofit/category_import'; ?>">Bulk Upload Category</a>
                      <a style="float:right; margin-bottom:20px; margin-right: 10px;" class="btn btn-primary" href="<?php echo base_url().'nonprofit/add_child_category/'.$category_id.'/'.$subcategory_id; ?>">Add Child Category</a>
                    <div class="data-tables">

                        <table id="dataTable" class="">
                            <thead class="bg-light text-capitalize">
                                <tr>

                                    <th>Category Name</th>
                                    <th>Category Description</th>
                                    <th>Category Code</th>
                                    <th>Active</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i=0; foreach($maincategory as $non_profit) { ?>
                                    <tr>

                                        <td><?php echo $non_profit[DB_prefix.'NTEE_2_NAME']; ?></td>
                                        <td><?php echo $non_profit[DB_prefix.'NTEE_2_DESCRIPTION']; ?></td>
                                        <td><?php echo $non_profit[DB_prefix.'NTEE_2_CODE']; ?></td>
                                        <td><?php echo $non_profit[DB_prefix.'ACTIVE']; ?></td>
                                        <td>
                                        <a href="<?php echo base_url().'nonprofit/edit_child_category/'.$category_id.'/'.$subcategory_id.'/'.$non_profit[DB_prefix.'NTEE_2_ID']; ?>" title="Edit">Edit</a>&nbsp;||&nbsp;<a href="<?php echo base_url().'nonprofit/delete_child_category/'.$category_id.'/'.$subcategory_id.'/'.$non_profit[DB_prefix.'NTEE_2_ID']; ?>" class="deletesubcategory" title="DELETE">Delete</a></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
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
        jQuery(document).on('click', '.deletesubcategory', function(e){
            var url = $(this).attr('href');
            if (confirm('Confirm Delete Child Category ?')) {
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
        });
    });
</script>
