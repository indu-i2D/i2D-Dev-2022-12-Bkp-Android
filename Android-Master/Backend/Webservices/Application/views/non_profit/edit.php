<!-- page title area end -->
    <?php $taxexempt = array('1' => 'Deductible', '2' => 'Non Deductible');
    $allcatid = $non_profit[DB_prefix."CATEGORY_CODE"].','.$non_profit[DB_prefix."SUB_CATEGORY_CODE"].','.$non_profit[DB_prefix."CHILD_CATEGORY_CODE"];
    $splittedNumbers1 = explode(",", $allcatid);
    $allcategories = "'" . implode("', '", $splittedNumbers1) ."'";
   $taxexemptstatus = array('1' => '1 (Deductible)', '2' => '2 (Non Deductible)','4' => '4 (Deductible)' );?>
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
                                <h4 class="header-title">Edit Non Profit Data</h4>


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

                                <form action="" id="change_password" name="change_password" enctype="multipart/form-data" method="post">
                                    <input type="hidden" name="id" id="id" value="<?php echo $non_profit[DB_prefix."ID"]; ?>" />
                                    <div class="form-group">
                                        <label for="example-text-input" class="col-form-label">Employer Identification Number</label>
                                        <input class="form-control" type="text" name="ein" id="ein" maxlength="9" value="<?php echo $non_profit[DB_prefix."EIN"]; ?>" readonly="">
                                    </div>
                                    <div class="form-group">
                                        <label for="example-text-input" class="col-form-label">Primary Name of Organization</label>
                                        <input class="form-control" type="text" name="name" id="name" value="<?php echo $non_profit[DB_prefix."NAME"]; ?>">
                                    </div>
                                 <!--    <div class="form-group">
                                        <label for="example-text-input" class="col-form-label">Description</label>
                                        <input class="form-control" type="text" name="description" id="description" value="<?php echo $non_profit[DB_prefix."DESCRIPTION"]; ?>" required>
                                    </div> -->
                                    <div class="form-group">
                                        <label for="example-text-input" class="col-form-label">In Care of Name</label>
                                        <input class="form-control" type="text" name="ico" id="ico" value="<?php echo $non_profit[DB_prefix."ICO"]; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="example-text-input" class="col-form-label">Street Address</label>
                                        <input class="form-control" type="text" name="street" id="street" value="<?php echo $non_profit[DB_prefix."STREET"]; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="example-text-input" class="col-form-label">City</label>
                                        <input class="form-control" type="text" name="city" id="city" value="<?php echo $non_profit[DB_prefix."CITY"]; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="example-text-input" class="col-form-label">State</label>
                                        <input class="form-control" type="text" name="state" id="state" value="<?php echo $non_profit[DB_prefix."STATE"]; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="example-text-input" class="col-form-label">Zip Code</label>
                                        <input class="form-control" type="text" name="zip_code" id="zip_code" value="<?php echo $non_profit[DB_prefix."ZIP"]; ?>">
                                    </div>
                                  <!--   <div class="form-group">
                                        <label class="col-form-label">Country</label>
                                        <select class="form-control">
                                            <option>Select</option>
                                            <?php foreach($countries as $country)
                                            {?>

                                                <option <?php if($country[DB_prefix."SORTNAME"]==$non_profit[DB_prefix."COUNTRY_CODE"]){echo 'selected="selected"'; } ?> value='<?php echo $country[DB_prefix."SORTNAME"]; ?>'><?php echo $country[DB_prefix."NAME"]; ?></option>
                                            <?php }?>
                                        </select>
                                    </div> -->
                              <!--       <div class="form-group">
                                        <label class="col-form-label">Category</label>
                                        <input type="text" class="form-control" id="justAnInputBox3" name="justAnInputBox3" placeholder="Select"/>
                                    </div> -->
                                    <?php //print_r($sub_categories); ?>

                                    <div class="form-group">
                                        <label for="example-text-input" class="col-form-label">Group Exemption Number</label>
                                        <input class="form-control" type="text" name="group" id="group" value="<?php echo $non_profit[DB_prefix."GROUP"]; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="example-text-input" class="col-form-label">Subsection Code</label>
                                        <input class="form-control" type="text" name="sub_section" id="sub_section" value="<?php echo $non_profit[DB_prefix."SUBSECTION"]; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="example-text-input" class="col-form-label">Affiliation Code</label>
                                        <input class="form-control" type="text" name="affiliation" id="affiliation" value="<?php echo $non_profit[DB_prefix."AFFILIATION"]; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="example-text-input" class="col-form-label">Classification Code(s)</label>
                                        <input class="form-control" type="text" name="classification" id="classification" value="<?php echo $non_profit[DB_prefix."CLASSIFICATION"]; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="example-text-input" class="col-form-label">Ruling Date</label>
                                        <input class="form-control" type="text" name="ruling" id="ruling" value="<?php echo $non_profit[DB_prefix."RULING"]; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="example-text-input" class="col-form-label">Deductibility Code</label>
                                         <select name="deductibility" id="deductibility" class="form-control">
                                            <option value="">Tax Deductible Code</option>
                                            <?php foreach ($taxexemptstatus as $key => $value) {
                                                 $selected = ($non_profit[DB_prefix."DEDUCTIBILITY"] == $key) ? 'selected' : '';
                                                echo '<option value="'.$key.'" '.$selected.'>'.$value.'</option>';
                                            }
                                            ?>
                                        </select>

                                    </div>
                                    <div class="form-group">
                                        <label for="example-text-input" class="col-form-label">Foundation Code</label>
                                        <input class="form-control" type="text" name="foundation" id="foundation" value="<?php echo $non_profit[DB_prefix."FOUNDATION"]; ?>">
                                    </div>

                                    <div class="form-group">
                                        <label for="example-text-input" class="col-form-label">Activity Codes</label>
                                        <input class="form-control" type="text" name="activity" id="activity" value="<?php echo $non_profit[DB_prefix."ACTIVITY"]; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="example-text-input" class="col-form-label">Organization Code</label>
                                        <input class="form-control" type="text" name="organization" id="organization" value="<?php echo $non_profit[DB_prefix."ORGANIZATION"]; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="example-text-input" class="col-form-label">Exempt Organization Status Code</label>
                                        <input class="form-control" type="text" name="status" id="status" value="<?php echo $non_profit[DB_prefix."STATUS"]; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="example-text-input" class="col-form-label">Tax Period</label>
                                        <input class="form-control" type="text" name="tax_period" id="tax_period" value="<?php echo $non_profit[DB_prefix."TAX_PERIOD"]; ?>">

                                    </div>
                                   <!--  <div class="form-group">
                                        <label for="example-text-input" class="col-form-label">Tax Deductible</label>
                                        <select name="tax_exempt" id="tax_exempt" class="form-control">
                                            <option value="">Tax Deductible Status</option>
                                            <?php foreach ($taxexempt as $key => $value) {
                                                $selected = ($non_profit[DB_prefix."TAX_DEDUCTIBLE"] == $key) ? 'selected' : '';
                                                echo '<option value="'.$key.'" '.$selected.'>'.$value.'</option>';
                                            }
                                            ?>
                                        </select>
                                        <input class="form-control" type="text" name="tax_period" id="tax_period" value="<?php echo $non_profit[DB_prefix."TAX_PERIOD"]; ?>">

                                    </div> -->


                                    <div class="form-group">
                                        <label for="example-text-input" class="col-form-label">Asset Code</label>
                                        <input class="form-control" type="text" name="asset_cd" id="asset_cd" value="<?php echo $non_profit[DB_prefix."ASSET_CD"]; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="example-text-input" class="col-form-label">Income Code</label>
                                        <input class="form-control" type="text" name="income_cd" id="income_cd" value="<?php echo $non_profit[DB_prefix."INCOME_CD"]; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="example-text-input" class="col-form-label">Fiing Requirement Code</label>
                                        <input class="form-control" type="text" name="filing_req_cd" id="filing_req_cd" value="<?php echo $non_profit[DB_prefix."FILING_REQ_CD"]; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="example-text-input" class="col-form-label">PF Fiing Requirement Code</label>
                                        <input class="form-control" type="text" name="pf_filing_req_cd" id="pf_filing_req_cd" value="<?php echo $non_profit[DB_prefix."PF_FILING_REQ_CD"]; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="example-text-input" class="col-form-label">Accounting Period</label>
                                        <input class="form-control" type="text" name="acct_pd" id="acct_pd" value="<?php echo $non_profit[DB_prefix."ACCT_PD"]; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="example-text-input" class="col-form-label">Asset Amount</label>
                                        <input class="form-control" type="text" name="asset_amount" id="asset_amount" value="<?php echo $non_profit[DB_prefix."ASSET_AMT"]; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="example-text-input" class="col-form-label">Income Amount</label>
                                        <input class="form-control" type="text" name="income_amount" id="income_amount" value="<?php echo $non_profit[DB_prefix."INCOME_AMT"]; ?>" >
                                    </div>

                                    <div class="form-group">
                                        <label for="example-text-input" class="col-form-label">Revenue Amount</label>
                                        <input class="form-control" type="text" name="revenue_amount" id="revenue_amount" value="<?php echo $non_profit[DB_prefix."REVENUE_AMT"]; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="example-text-input" class="col-form-label">NTEE CD</label>
                                        <input class="form-control" type="text" name="ntee_cd" id="ntee_cd" maxlength="4" value="<?php echo $non_profit[DB_prefix."NTEE_CD"]; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="example-text-input" class="col-form-label">Sort Name</label>
                                        <input class="form-control" type="text" name="sort_name" id="sort_name" value="<?php echo $non_profit[DB_prefix."SORT_NAME"]; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="example-text-input" class="col-form-label">Logo</label>
                                        <input class="form-control" type="file" name="logo_file" id="logo_file" value="">
                                    </div>
                                    <div class="submit-btn-area">
                                         <input type="hidden" class="form-control" id="justAnInputBox2" name="justAnInputBox2" value="<?php echo $allcatid; ?>" />
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
<script src="<?php echo base_url(); ?>skins/js/jquery.validate.min.js"></script>
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

        var commonprefix = '<?php echo DB_prefix; ?>';
            var commondata = <?php echo $commoncategorylist; ?>;
            var comboTree3, comboTree2;
            comboTree3 = $('#justAnInputBox3').comboTree({
              source : commondata,
              isMultiple: true,
              cascadeSelect: true,
              selected : [<?php echo $allcategories; ?>]
            });


             var selection = setInterval(function() {
                if($('.comboTreeDropDownContainer').is(':visible')) {
                 var selectedIds = comboTree3.getSelectedItemsId();
            $('#justAnInputBox2').val(selectedIds);
                }
              }, 500);
        $('input[name="ein"]').bind('keypress', function(e) {
            return ( e.which!=8 && e.which!=0 && (e.which<48 || e.which>57)) ? false : true ;
        });

        jQuery('#change_password').validate({
        rules:{
            // ein: {
            //     required: true,
            //     minlength: 9,
            //     maxlength: 9
            // },
            ntee_cd: "required"
        },
        messages:{
            ein:{
                required: "Please provide a EIN Number",
                minlength: "Your EIN Number Minimum 9 Number only",
                maxlength: "Your EIN Number Maximum 9 Number only"
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
