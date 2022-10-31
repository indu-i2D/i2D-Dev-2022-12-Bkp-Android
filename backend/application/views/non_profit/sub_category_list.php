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
                    <h4 style="float:left;" class="header-title">Sub Category List</h4>
                    <a style="float:right; margin-bottom:20px;" class="btn btn-primary" href="<?php echo base_url().'nonprofit/category_import'; ?>">Bulk Upload Category</a>
                    <a style="float:right; margin-bottom:20px; margin-right: 10px;" class="btn btn-primary" href="<?php echo base_url().'nonprofit/add_sub_category/'.$category_id; ?>">Add Sub Category</a>
                    <div class="data-tables">
                        	
                        <table id="dataTable" class="">
                            <thead class="bg-light text-capitalize">
                                <tr>
                                    
                                    <th>Category Name</th>
                                    <th>Category Description</th>
                                    <th>Category Code</th>
                                    <th>Subcategory List</th>
                                    <th>Active</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i=0; foreach($maincategory as $non_profit) { ?>
                                    <tr>
                                        
                                        <td><?php echo $non_profit[DB_prefix.'NTEE_1_NAME']; ?></td>
                                        <td><?php echo $non_profit[DB_prefix.'NTEE_1_DESCRIPTION']; ?></td>
                                        <td><?php echo $non_profit[DB_prefix.'NTEE_1_CODE']; ?></td>
                                         <td><a href="<?php echo base_url().'nonprofit/child_category_list/'.$category_id.'/'.$non_profit[DB_prefix.'NTEE_1_ID']; ?>">View Child Category</a></td>
                            
                                        <td><?php echo $non_profit[DB_prefix.'ACTIVE']; ?></td>
                                        <td>     
                                        <a href="<?php echo base_url().'nonprofit/edit_sub_category/'.$category_id.'/'.$non_profit[DB_prefix.'NTEE_1_ID']; ?>" title="Edit">Edit</a>&nbsp;||&nbsp;<a href="<?php echo base_url().'nonprofit/delete_subcategory/'.$category_id.'/'.$non_profit[DB_prefix.'NTEE_1_ID']; ?>" class="deletesubcategory" title="DELETE">Delete</a></td>
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
<script type="text/javascript">
    jQuery(document).ready(function($){
        jQuery(document).on('click', '.deletesubcategory', function(e){
            var url = $(this).attr('href');
            if (confirm('Confirm Delete Sub Category ?')) {
                window.location.href = url;
            } else {
                var url = $(this).attr('href', '');
                window.location.reload();
                e.stopPropagation();
            }
        });
    });
</script>
