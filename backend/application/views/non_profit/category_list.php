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
                          <?php if($this->session->flashdata('error')) { ?>
                                    <div role="alert" class="alert alert-danger">
                                        <strong><i class="fa fa-close fa-fw"></i> <?php echo $this->session->flashdata('error'); ?></strong>
                                    </div>
                                <?php } ?>
                    <h4 style="float:left;" class="header-title">Category List</h4>
                    <a style="float:right; margin-bottom:20px;" class="btn btn-primary" href="<?php echo base_url().'nonprofit/category_import'; ?>">Bulk Upload Category</a>
                   <!--   <a style="float:right; margin-bottom:20px; margin-right: 10px;" class="btn btn-primary" href="<?php echo base_url().'nonprofit/add_child_category/'; ?>">Add Child Category</a>
                      <a style="float:right; margin-bottom:20px; margin-right: 10px;" class="btn btn-primary" href="<?php echo base_url().'nonprofit/add_sub_category'; ?>">Add Sub Category</a> -->
                       <a style="float:right; margin-bottom:20px; margin-right: 10px;" class="btn btn-primary" href="<?php echo base_url().'nonprofit/add_category'; ?>">Add Category</a>
                    <div class="data-tables">

                        <table id="dataTable" class="">
                            <thead class="bg-light text-capitalize">
                                <tr>

                                    <th>NTEE Category</th>
                                    <th>NTEE Sub-Type1</th>
                                    <th>NTEE Sub-Type2</th>
                                    <th>NTEE Definition</th>
                                    <th>NTEE Description</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i=0; foreach($maincategorys as $non_profit) { ?>
                                    <tr>

                                        <td><?php echo $non_profit[DB_prefix.'CATEGORY_CODE']; ?></td>
                                        <td><?php echo $non_profit[DB_prefix.'SUB_CATEGORY_CODE']; ?></td>
                                        <td><?php echo $non_profit[DB_prefix.'CHILD_CATEGORY_CODE']; ?></td>

                                        <td><?php echo $non_profit[DB_prefix.'CATEGORY_NAME']; ?></td>
                                        <td><?php echo $non_profit[DB_prefix.'CATEGORY_DESCIPTION']; ?></td>
                                        <td>
                                        <a href="<?php echo base_url().'nonprofit/edit_category/'.$non_profit[DB_prefix.'CATEGORY_ID']; ?>" title="Edit">Edit</a>&nbsp;||&nbsp;<a href="<?php echo base_url().'nonprofit/delete_category/'.$non_profit[DB_prefix.'CATEGORY_ID']; ?>" class="deletesubcategory" title="DELETE">Delete</a></td>

                                       <!--  <td><?php echo $non_profit[DB_prefix.'NTEE_2_CODE']; ?></td>
                                         <td><a href="<?php echo base_url().'nonprofit/sub_category_list/'.$non_profit[DB_prefix.'CATEGORY_ID']; ?>">View Subcategory</a></td>

                                        <td><?php echo $non_profit[DB_prefix.'ACTIVE']; ?></td>
                                        <td>
                                        <a href="<?php echo base_url().'nonprofit/edit_category/'.$non_profit[DB_prefix.'CATEGORY_ID']; ?>" title="Edit">Edit</a>&nbsp;||&nbsp;<a href="<?php echo base_url().'nonprofit/delete_category/'.$non_profit[DB_prefix.'CATEGORY_ID']; ?>" class="deletesubcategory" title="DELETE">Delete</a></td> -->
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
        jQuery(document).on('click', '.deletesubcategory', function(e){
            var url = $(this).attr('href');
            if (confirm('Confirm Delete Category ?')) {
                window.location.href = url;
            } else {
                 var url1 = $(this).attr('href', '');
                // $(this).attr('href',  url);
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
