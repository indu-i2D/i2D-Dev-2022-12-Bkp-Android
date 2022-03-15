<!-- page title area end -->
 <!-- TinyMCE script -->
<script src='<?= base_url() ?>resources/tinymce/tinymce.min.js'></script>
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
                                <h4 class="header-title">Add Page</h4>
                                
                                
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
                                
                                <form action="" id="page" name="page" method="post">
                                    <input type="hidden" name="id" id="id" value="
                                    " /> 
                                   
                                    <div class="form-group">
                                        <label for="example-text-input" class="col-form-label">Title</label>
                                        <input class="form-control" type="text" name="title" id="title" value="" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="example-text-input" class="col-form-label">Description</label>
                                        <textarea class="editor form-control" name='content' id="content"></textarea>
                                    </div>
                                
                                    <div class="submit-btn-area">
                                        <input type="hidden" class="form-control" id="justAnInputBox2" name="justAnInputBox2" value="" />
                                        <button id="form_submit" type="submit">Submit <i class="ti-arrow-right"></i></button>
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
<script>
    tinymce.init({ 
      selector:'.editor',
      theme: 'modern',
      height: 200
    });
    </script>
