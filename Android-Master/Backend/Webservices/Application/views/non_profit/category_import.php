<div class="main-content-inner">
    <div class="row">
    	    <div id="preloader" style="display: none;">
       <div class="loader"></div>
       </div>
        <!-- data table start -->
        <div class="col-12 mt-5">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Category</h4>
                    <div class="data-tables">
                        <form class="form-horizontal" action="<?php echo base_url(); ?>nonprofit/category_import" method="post" enctype='multipart/form-data' id="user_import">								
								<fieldset>
									<legend>Import Category</legend>
									
									<div class="form-group">
										<label class="col-md-2 control-label">Import<span class="error">*</span></label>
										<div class="col-md-6"> 
											<input type="file" name="file" id="file">
										</div>
										<span id="fileerr"></span>
									</div>
									
									
								</fieldset>								
								<div class="form-actions">
									<div class="row">
										<div class="col-md-12">
											<button type="submit" class="btn btn-primary">
												<i class="fa fa-save"></i>
												Submit
											</button>
										</div>
									</div>
								</div>
	
							</form>
	
                    </div>
                </div>
            </div>
        </div>
        <!-- data table end -->
    </div>
</div>