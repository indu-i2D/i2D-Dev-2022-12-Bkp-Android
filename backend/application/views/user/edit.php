<!-- page title area end -->
    <?php 
    $gender = array('M' => 'Male', 'F' => 'Female', 'O' => 'Other'); 
    $status = array('A' => 'Activate', 'D' => 'Deactivate');
    $type = array('individual' => 'Individual', 'business' => 'Business'); 
    $userdatas = array('No' => 'No', 'Yes' => 'Yes');
   // echo "<pre>"; print_r($users); echo "</pre>";
    //exit;?>
      <style type="text/css">
        .invalid{
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
                                <h4 class="header-title">Edit User Data</h4>
                                
                                
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
                                
                                <form action="" id="change_password" name="change_password" method="post">
                                    <input type="hidden" name="id" id="id" value="<?php echo $users[DB_prefix."ID"]; ?>" />
                                    <div class="form-group">
                                        <label for="example-text-input" class="col-form-label">Registering as</label>
                                         <select class="form-control" name="status" id="status" disabled="">
                                            <option value="">Select</option>
                                            <?php foreach($type as $k => $v)
                                            {?>
                                                
                                                <option <?php if($k==$users[DB_prefix."REGISTERING_AS"]){echo 'selected="selected"'; } ?> value='<?php echo $k; ?>'><?php echo $v; ?></option>
                                            <?php }?>
                                        </select>
                                    </div>
                                    <?php $style = ($users[DB_prefix."REGISTERING_AS"] == 'business') ? 'display: block;' : 'display : none;'; ?>
                                    <div class="form-group businessclass" style="<?php echo $style; ?>">
                                        <label for="example-text-input" class="col-form-label">Business Name</label>
                                        <input class="form-control" type="text" name="business_name" id="business_name" value="<?php echo $users[DB_prefix."BUSINESS_NAME"]; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="example-text-input" class="col-form-label">Name</label>
                                        <input class="form-control" type="text" name="name" id="name" value="<?php echo $users[DB_prefix."NAME"]; ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="example-text-input" class="col-form-label">Email</label>
                                        <input class="form-control" type="text" name="email" id="email" value="<?php echo $users[DB_prefix."EMAIL"]; ?>" readonly="" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="example-text-input" class="col-form-label">Phone Number</label>
                                        <input class="form-control" type="text" name="phone" id="phone" value="<?php echo $users[DB_prefix."PHONE_NUMBER"]; ?>" maxlength="15">
                                    </div>
                                     <?php $newstyle = ($users[DB_prefix."REGISTERING_AS"] == 'business') ? 'display: none;' : 'display : block;'; ?>
                                    <div class="form-group" style="<?php echo $newstyle; ?>">
                                        <label for="example-text-input" class="col-form-label">Gender</label>
                                        <select name="gender" id="gender" class="form-control">
                                            <option value="">Gender</option>
                                            <?php foreach ($gender as $key => $value) {
                                                $selected = ($users[DB_prefix."GENDER"] == $key) ? 'selected' : '';
                                                echo '<option value="'.$key.'" '.$selected.'>'.$value.'</option>';
                                            }
                                            ?>
                                        </select>

                                    </div>
                                    <div class="form-group">
                                        <label for="example-text-input" class="col-form-label">Country</label>
                                         <select class="form-control" name="country" id="country">
                                            <option>Select</option>
                                            <?php foreach($countries as $country)
                                            {?>
                                                
                                                <option <?php if($country[DB_prefix."SORTNAME"]==$users[DB_prefix."COUNTRY"]){echo 'selected="selected"'; } ?> value='<?php echo $country[DB_prefix."SORTNAME"]; ?>'><?php echo $country[DB_prefix."NAME"]; ?></option>
                                            <?php }?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="example-text-input" class="col-form-label">Terms</label>
                                         <select class="form-control" name="termsconditions" id="termsconditions" <?php if($users[DB_prefix."TERMS"] == 'Yes'){ echo 'disabled=""'; } ?>>
                                            <option value="">Select</option>
                                            <?php foreach($userdatas as $k => $v) { 
                                            $selectedu = ($k == $users[DB_prefix."TERMS"]) ? 'selected="selected"' : 'selected="selected"'; ?>
                                            <option <?php echo $selectedu; ?> value='<?php echo $v; ?>'><?php echo $v; ?></option>
                                            <?php } ?>
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
                </div>
            </div>            
        </div>
    </div>
</div>
 <script src="<?php echo base_url(); ?>skins/js/vendor/jquery-2.2.4.min.js"></script>
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
           $('input[name="phone"]').bind('keypress', function(e) { 
            return ( e.which!=8 && e.which!=0 && (e.which<48 || e.which>57)) ? false : true ;
          });
    jQuery('#status').change(function(){
        var value = $(this).val();
        if(value == 'business')
        {
            $('.businessclass').show();
        }
        else
        {
            $('.businessclass').hide();
        }
    });
     jQuery('#change_password').validate({
        rules:{
            name: "required",
            gender: "required",
            status : "required",
            password: {
                    required: true,
                     regex: /^.*(?=.{8,})(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*?[\'^£$%&*()}\[\]{@#~`!:;.\/"?><>,|=+_\\\¬-]+)(?!.*[\s]).*$/
            },
            country : "required",
            status: "required",
        },
        messages:{
            name: "Please enter your name",
            email:{
                    required: "Please enter your email id",
                    email: "Please enter a valid email",
                    remote: "Email Already Used"
                },
            phone: "Please enter your phone number",
            country: "Please select your country",
            password: {
                    required: "Please provide a Password",
                    minlength: "Your password must be at least 8 characters long",
                    pwcheck:"Password must be at least 8 characters long and have a combination of Letters, Number and Symbols"
            },
            einno: {
                    minlength: "Your ein number allowed 9 characters only"
            },
            cpassword: {
                required: "Please provide a Password",
                minlength: "Your password must be at least 6 characters long",
                equalTo: "Please enter the same password as above"
            },

        }

    });
});
</script>

