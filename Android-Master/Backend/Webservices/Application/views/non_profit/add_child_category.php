<!-- page title area end -->
    <?php $status = array('Yes' => 'Yes','No' => 'No'); ?>
    <div class="main-content-inner">
        <div class="row">
            <div class="col-lg-6 col-ml-12">
                <div class="row">
                    <!-- Textual inputs start -->
                    <div class="col-12 mt-5">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">Add Child Category</h4>
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
                                
                                <form action="" name="change_password" method="post">
                                     <div class="form-group">
                                        <label for="example-text-input" class="col-form-label">Parent Category</label>
                                        <select name="category_id" id="category_id" class="form-control" required="">
                                            <option value="">Choose Category</option>
                                            <?php foreach ($maincategory as $non_profit) {
                                                $selected = ($category[DB_prefix."ACTIVE"] == $key) ? 'selected' : '';
                                                echo '<option value="'.$non_profit[DB_prefix."CATEGORY_ID"].'">'.$non_profit[DB_prefix."CATEGORY_CODE"].' - '.$non_profit[DB_prefix."CATEGORY_NAME"].'</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="example-text-input" class="col-form-label">Sub Category</label>
                                        <select name="sub_category_id" id="sub_category_id" class="form-control" required="">
                                           <option value="">Choose SubCategory</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="example-text-input" class="col-form-label">Category Name</label>
                                        <input class="form-control" type="text" name="name" id="name" value="" required>
                                    </div>
                                  
                                    <div class="form-group">
                                        <label for="example-text-input" class="col-form-label">Category Code</label>
                                        <input class="form-control" type="text" name="code" id="code" value="" maxlength="2" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="example-text-input" class="col-form-label">Category Description</label>
                                        <textarea class="form-control" name="description" id="description"></textarea>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="example-text-input" class="col-form-label">Active</label>
                                        <select name="status" id="status" class="form-control">
                                            <option value=""></option>
                                            <?php foreach ($status as $key => $value) {
                                                
                                                echo '<option value="'.$key.'">'.$value.'</option>';
                                            }
                                            ?>
                                        </select>

                                    </div>
                                    <div class="submit-btn-area">
                                         <input type="hidden" class="form-control" id="justAnInputBox2" name="justAnInputBox2" value="" />
                                        <button id="form_submit" type="submit">Submit <i class="ti-arrow-right"></i></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- Textual inputs end -->
                </div>
            </div>            
        </div>
    </div>
</div>
 <script src="<?php echo base_url(); ?>skins/js/vendor/jquery-2.2.4.min.js"></script>
   <script src="<?php echo base_url(); ?>skins/js/comboTreePlugin.js"></script>
    <script src="<?php echo base_url(); ?>skins/js/icontains.js"></script>
<script type="text/javascript">
  function Validate() {
        var password = document.getElementById("password").value;
        var confirmPassword = document.getElementById("confirm_password").value;
        if (password != confirmPassword) {
            alert("Whoops, password and confirm password don't match.");
            return false;
        }
        return true;
    }
    jQuery(document).ready(function($){
        $("#category_id").click(function(){
            $.ajax({
                 type: "POST",
                 url: "<?php echo base_url().'nonprofit/getSubCategoryList'; ?>", 
                 data: {category_id: $("#category_id").val()}, 
                 cache:true,
                 success: function(data){
                    var myObject = eval('(' + data + ')');
                    $('#sub_category_id').html('');
                    $('#sub_category_id').html('<option value="">Choose SubCategory</option>');
                    for (var index in myObject) {
                       $("#sub_category_id").append('<option value="'+myObject[index].ID+'">'+myObject[index].code+' - '+myObject[index].Name+'</option>');                   
                       }

                 }
            });
            return false;
            });
    });

</script>

