<!-- page title area end -->
    <?php $status = array('No' => 'No', 'Yes' => 'Yes'); ?>
    <style type="text/css">
        .invalid {
            color: red;
        }
    </style>
    <div class="main-content-inner">
        <div class="row">
            <div class="col-lg-6 col-ml-12">
                <div class="row">
                    <!-- Textual inputs start -->
                    <div class="col-12 mt-5">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">Add Category</h4>
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

                                <form action="" name="addcategory" id="addcategory" method="post">

                                    <div class="form-group">
                                        <label for="example-text-input" class="col-form-label">NTEE Definition</label>
                                        <input class="form-control" type="text" name="name" id="name" value="" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="example-text-input" class="col-form-label">NTEE Category</label>
                                        <input class="form-control" type="text" name="code" id="code" value="" maxlength="1" style="text-transform: uppercase;" required>
                                    </div>
                                      <div class="form-group">
                                        <label for="example-text-input" class="col-form-label">NTEE Sub-Type1</label>
                                        <input class="form-control" type="text" name="subcode" id="subcode" style="text-transform: uppercase;" value="" maxlength="1">
                                    </div>

                                     <div class="form-group">
                                        <label for="example-text-input" class="col-form-label">NTEE Sub-Type2</label>
                                        <input class="form-control" type="text" name="childcode" id="childcode" value="" style="text-transform: uppercase;" maxlength="2">
                                    </div>
                                    <div class="form-group">
                                        <label for="example-text-input" class="col-form-label">NTEE Description</label>
                                        <textarea class="form-control" name="description" id="description"></textarea>
                                    </div>

                                    <div class="form-group">
                                        <label for="example-text-input" class="col-form-label">Active</label>
                                        <select name="status" id="status" class="form-control">
                                            <?php foreach ($status as $key => $value) {
                                                $selected = ($category[DB_prefix."ACTIVE"] == $key) ? 'selected' : '';
                                                echo '<option value="'.$key.'" '.$selected.'>'.$value.'</option>';
                                            }
                                            ?>
                                        </select>

                                    </div>
                                    <div class="submit-btn-area">
                                         <input type="hidden" class="form-control" id="justAnInputBox2" name="justAnInputBox2" value="" />
                                        <button id="form_submit" type="submit" onclick="return Validate()">Submit <i class="ti-arrow-right"></i></button>
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
<script src="<?php echo base_url(); ?>skins/js/jquery.validate.min.js"></script>
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
     $('input[name="code"]').bind('keypress', function(e) {
            //console.log(e.which);
            return ( e.which!=8 && e.which!=0 && (e.which<97 || e.which>122)) ? false : true ;
          });
       $('input[name="subcode"], input[name="childcode"]').bind('keypress', function(e) {
            //console.log(e.which);
            return ( e.which!=8 && e.which!=0 && (e.which<97 || e.which>122) && (e.which<48 || e.which>57)) ? false : true ;
          });

     jQuery('#addcategory').validate({
        rules:{
          name:{
            required: true,
            minlength: 10,
          },

        },
        messages:{
            name:{
                required: "Please enter the NTEE Definition",
                minlength: "Should be minimum 10 characters long",
            }
        }

     });
  });

</script>
