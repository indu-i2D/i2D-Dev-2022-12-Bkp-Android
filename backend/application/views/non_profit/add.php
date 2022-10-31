<!-- page title area end -->
    <?php $taxexempt = array('1' => 'Deductible', '2' => 'Non Deductible');
    $taxexemptstatus = array('1' => '1 (Deductible)', '2' => '2 (Non Deductible)','4' => '4 (Deductible)' );
      $allcategories = '';?>
    <div class="main-content-inner">
        <div class="row">
            <div class="col-lg-6 col-ml-12">
                <div class="row">
                    <!-- Textual inputs start -->
                    <div class="col-12 mt-5">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">Add Non Profit Data</h4>


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

                                <form action="" id="change_password" name="change_password" method="post" enctype="multipart/form-data">

                                    <div class="form-group">
                                        <label for="example-text-input" class="col-form-label">Employer Identification Number (EIN)</label>
                                        <input class="form-control" type="text" name="ein" id="ein" value="" maxlength="9" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="example-text-input" class="col-form-label">Primary Name of Organization</label>
                                        <input class="form-control" type="text" name="name" id="name" value="" required>
                                    </div>
                                   <!--  <div class="form-group">
                                        <label for="example-text-input" class="col-form-label">Description</label>
                                        <input class="form-control" type="text" name="description" id="description" value="" required>
                                    </div> -->
                                    <div class="form-group">
                                        <label for="example-text-input" class="col-form-label">In Care of Name</label>
                                        <input class="form-control" type="text" name="ico" id="ico" value="">
                                    </div>
                                    <div class="form-group">
                                        <label for="example-text-input" class="col-form-label">Street Address</label>
                                        <input class="form-control" type="text" name="street" id="street" value="" >
                                    </div>
                                    <div class="form-group">
                                        <label for="example-text-input" class="col-form-label">City</label>
                                        <input class="form-control" type="text" name="city" id="city" value="">
                                    </div>
                                    <div class="form-group">
                                        <label for="example-text-input" class="col-form-label">State</label>
                                        <input class="form-control" type="text" name="state" id="state" value="" >
                                    </div>
                                    <div class="form-group">
                                        <label for="example-text-input" class="col-form-label">Zip Code</label>
                                        <input class="form-control" type="text" name="zip_code" id="zip_code" value="">
                                    </div>
                                    <?php
                                    //echo "<pre>"; print_r($countries); echo "</pre>";
                                    ?>
                                    <div class="form-group" style="display: none;">
                                        <label class="col-form-label">Country</label>
                                        <select class="form-control" name="country" id="country">
                                            <option>Select</option>
                                            <?php foreach($countries as $country)
                                            {?>

                                                <option <?php if($country[DB_prefix."SORTNAME"]== 'US'){echo 'selected="selected"'; } ?> value='<?php echo $country[DB_prefix."SORTNAME"]; ?>'><?php echo $country[DB_prefix."NAME"]; ?></option>
                                            <?php }?>
                                        </select>
                                    </div>
                                    <div class="form-group" style="display: none;">
                                        <label class="col-form-label">Category</label>
                                        <input type="hidden" class="form-control" id="justAnInputBox1" name="justAnInputBox1" value="test"/>
                                    </div>
                                    <?php //print_r($sub_categories); ?>
                                  <!--   <div class="form-group">
                                        <label class="col-form-label">NTEE Code 1</label>
                                        <select class="form-control" name="subcategory" id="subcategory" multiple="">
                                            <option value="">Select</option>
                                            <?php /*foreach($sub_categories as $subcategory)
                                            {?>
                                                <option <?php if($subcategory[DB_prefix."NTEE_1_CODE"]==$non_profit[DB_prefix."SUB_CATEGORY_CODE"]){ echo 'selected="selected"'; } ?> value="<?php echo $subcategory[DB_prefix."NTEE_1_CODE"]; ?>"><?php echo $subcategory[DB_prefix."NTEE_1_NAME"]; ?></option>
                                            <?php }  */ ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-form-label">Child Category</label>
                                        <select class="form-control" name="child_category" id="child_category">
                                            <option value="">Select</option>
                                            <?php foreach($child_categories as $child_category)
                                            {?>
                                                <option <?php if($child_category[DB_prefix."NTEE_2_CODE"]==$non_profit[DB_prefix."CHILD_CATEGORY_CODE"]){ echo 'selected="selected"'; } ?> value="<?php echo $child_category[DB_prefix."NTEE_2_CODE"]; ?>"><?php echo $child_category[DB_prefix."NTEE_2_NAME"]; ?></option>
                                            <?php }?>
                                        </select>
                                    </div> -->

                                    <div class="form-group">
                                        <label for="example-text-input" class="col-form-label">Group Exemption Number</label>
                                        <input class="form-control" type="text" name="group" id="group" value="">
                                    </div>
                                    <div class="form-group">
                                        <label for="example-text-input" class="col-form-label">Subsection Code</label>
                                        <input class="form-control" type="text" name="sub_section" id="sub_section" value="">
                                    </div>
                                    <div class="form-group">
                                        <label for="example-text-input" class="col-form-label">Affiliation Code</label>
                                        <input class="form-control" type="text" name="affiliation" id="affiliation" value="">
                                    </div>
                                    <div class="form-group">
                                        <label for="example-text-input" class="col-form-label">Classification Code</label>
                                        <input class="form-control" type="text" name="classification" id="classification" value="">
                                    </div>
                                    <div class="form-group">
                                        <label for="example-text-input" class="col-form-label">Ruling Date </label>
                                        <input class="form-control" type="text" name="ruling" id="ruling" value="">
                                    </div>
                                    <div class="form-group">
                                        <label for="example-text-input" class="col-form-label">Deductibility Code</label>

                                        <select name="deductibility" id="deductibility" class="form-control">
                                            <option value="">Tax Deductible Code</option>
                                            <?php foreach ($taxexemptstatus as $key => $value) {
                                                echo '<option value="'.$key.'" '.$selected.'>'.$value.'</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="example-text-input" class="col-form-label">Foundation Code</label>
                                        <input class="form-control" type="text" name="foundation" id="foundation" value="">
                                    </div>

                                    <div class="form-group">
                                        <label for="example-text-input" class="col-form-label">Activity Code</label>
                                        <input class="form-control" type="text" name="activity" id="activity" value="">
                                    </div>
                                    <div class="form-group">
                                        <label for="example-text-input" class="col-form-label">Organization Code</label>
                                        <input class="form-control" type="text" name="organization" id="organization" value="">
                                    </div>
                                    <div class="form-group">
                                        <label for="example-text-input" class="col-form-label">Exempt Organization Status Code</label>
                                        <input class="form-control" type="text" name="status" id="status" value="">
                                    </div>
                                    <div class="form-group">
                                        <label for="example-text-input" class="col-form-label">Tax Period</label>
                                        <input class="form-control" type="text" name="tax_period" id="tax_period" value="">

                                    </div>
                                   <!--  <div class="form-group">
                                        <label for="example-text-input" class="col-form-label">Tax Exempt</label>
                                        <select name="tax_exempt" id="tax_exempt" class="form-control">
                                            <option value="">Tax Deductible Status</option>
                                            <?php foreach ($taxexempt as $key => $value) {
                                                $selected = ($non_profit[DB_prefix."TAX_DEDUCTIBLE"] == $key) ? 'selected' : '';
                                                echo '<option value="'.$key.'" '.$selected.'>'.$value.'</option>';
                                            }
                                            ?>
                                        </select>
                                        <input class="form-control" type="text" name="tax_period" id="tax_period" value="">

                                    </div>
 -->

                                    <div class="form-group">
                                        <label for="example-text-input" class="col-form-label">Asset Code</label>
                                        <input class="form-control" type="text" name="asset_cd" id="asset_cd" value="">
                                    </div>
                                    <div class="form-group">
                                        <label for="example-text-input" class="col-form-label">Income Code</label>
                                        <input class="form-control" type="text" name="income_cd" id="income_cd" value="">
                                    </div>
                                    <div class="form-group">
                                        <label for="example-text-input" class="col-form-label">Fiing Requirement Code</label>
                                        <input class="form-control" type="text" name="filing_req_cd" id="filing_req_cd" value="">
                                    </div>
                                    <div class="form-group">
                                        <label for="example-text-input" class="col-form-label">PF Fiing Requirement Code</label>
                                        <input class="form-control" type="text" name="pf_filing_req_cd" id="pf_filing_req_cd" value="">
                                    </div>
                                    <div class="form-group">
                                        <label for="example-text-input" class="col-form-label">Accounting Period</label>
                                        <input class="form-control" type="text" name="acct_pd" id="acct_pd" value="">
                                    </div>
                                    <div class="form-group">
                                        <label for="example-text-input" class="col-form-label">Asset Amount</label>
                                        <input class="form-control" type="text" name="asset_amount" id="asset_amount" value="">
                                    </div>
                                    <div class="form-group">
                                        <label for="example-text-input" class="col-form-label">Income Amount</label>
                                        <input class="form-control" type="text" name="income_amount" id="income_amount" value="" >
                                    </div>

                                    <div class="form-group">
                                        <label for="example-text-input" class="col-form-label">Revenue Amount</label>
                                        <input class="form-control" type="text" name="revenue_amount" id="revenue_amount" value="">
                                    </div>
                                    <div class="form-group">
                                        <label for="example-text-input" class="col-form-label">NTEE CD</label>
                                        <input class="form-control" type="text" name="ntee_cd" id="ntee_cd" value="" maxlength="4">
                                    </div>
                                    <div class="form-group">
                                        <label for="example-text-input" class="col-form-label">Sort Name</label>
                                        <input class="form-control" type="text" name="sort_name" id="sort_name" value="" >
                                    </div>
                                    <div class="form-group">
                                        <label for="example-text-input" class="col-form-label">Logo</label>
                                        <input class="form-control" type="file" name="logo_file" id="logo_file" value="">
                                    </div>
                                    <div class="submit-btn-area">
                                          <input type="hidden" class="form-control" id="justAnInputBox2" name="justAnInputBox2" />
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
        // var password = document.getElementById("password").value;
        // var confirmPassword = document.getElementById("confirm_password").value;
        // if (password != confirmPassword) {
        //     alert("Whoops, password and confirm password don't match.");
        //     return false;
        // }
        return true;
    }

     jQuery(document).ready(function($){

        var commonprefix = '<?php echo DB_prefix; ?>';
            var commondata = <?php echo $commoncategorylist; ?>;
            var comboTree3, comboTree2;
            comboTree3 = $('#justAnInputBox1').comboTree({
              source : commondata,
              isMultiple: true,
              cascadeSelect: true

            });
                $('input[name="ein"]').bind('keypress', function(e) {
            return ( e.which!=8 && e.which!=0 && (e.which<48 || e.which>57)) ? false : true ;
          });


             var selection = setInterval(function() {
                if($('.comboTreeDropDownContainer').is(':visible')) {
                 var selectedIds = comboTree3.getSelectedItemsId();
            $('#justAnInputBox2').val(selectedIds);
                }
              }, 500);

    jQuery('#change_password').validate({
        rules:{
            ein: {
                minlength: 9,
                maxlength: 9,
                required: true,
                remote:{
                    url: "<?php echo base_url('nonprofit/check_ein_exists'); ?>",
                    type: "post",
                    data: {
                        ein: function() {
                            return $("#ein").val();
                        }
                    }

                }
            },
          //  ntee_cd: "required",
            type: "required",

        },
        messages:{
            name: "Please enter your name",

            ein: {
                required: "Please provide a EIN Number",
                minlength: "Your ein number allowed 9 digits only",
                minlength: "Your ein number allowed 9 digits only",
                remote: "EIN Number Already Used"
            },

        }

    });


    });

</script>
