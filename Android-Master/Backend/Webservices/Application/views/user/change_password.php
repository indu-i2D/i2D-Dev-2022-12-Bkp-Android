<!-- page title area end -->
    <div class="main-content-inner">
        <div class="row">
            <div class="col-lg-6 col-ml-12">
                <div class="row">
                    <!-- Textual inputs start -->
                    <div class="col-12 mt-5">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">Change Password</h4>
                                
                                
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
                                    <input type="hidden" name="user_id" id="user_id" value="<?php echo $this->session->userdata('user_id'); ?>" />
                                    <div class="form-group">
                                        <label for="example-text-input" class="col-form-label">Old Password</label>
                                        <input class="form-control" type="password" name="old_password" id="old_password" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="example-search-input" class="col-form-label">New Password</label>
                                        <input class="form-control" type="password" name="password" id="password" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="example-email-input" class="col-form-label">Confirm Password</label>
                                        <input class="form-control" type="password" name="confirm_password" id="confirm_password" data-match="#password" data-match-error="Whoops, password and confirm password don't match" required>
                                    </div>
                                    <div class="submit-btn-area">
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
<!-- main content area end -->
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
</script>