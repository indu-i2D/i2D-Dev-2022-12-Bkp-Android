
        <!-- page title area end -->
        <div class="main-content-inner">
            <div class="container">
                <div class="row">
                    <!-- seo fact area start -->
                    <div class="col-lg-8">
                        <div class="row">
                            <div class="col-md-6 mt-5 mb-3">
                                <div class="card">
                                    <a href="<?php echo base_url().'user/view'; ?>">
                                        <div class="seo-fact sbg1">
                                                <div class="p-4 d-flex justify-content-between align-items-center">
                                                    <div class="seofct-icon"><i class="ti-user"></i> Users</div>
                                                    <h2><?php echo $user_count; ?></h2>
                                                </div>
                                                <!--<canvas id="seolinechart1" height="50"></canvas>-->
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-6 mt-md-5 mb-3">
                                <div class="card">
                                        <a href="<?php echo base_url().'user/admin_users'; ?>">
                                            <div class="seo-fact sbg2">
                                                <div class="p-4 d-flex justify-content-between align-items-center">
                                                    <div class="seofct-icon"><i class="ti-user"></i> Admin Users</div>
                                                    <h2><?php echo $admin_user_count; ?></h2>
                                                </div>
                                                <!--<canvas id="seolinechart2" height="50"></canvas>-->
                                            </div>
                                        </a>
                                </div>
                            </div>
                            
                            <div class="col-md-6 mt-md-5 mb-3">
                                <div class="card">
                                        <a href="<?php echo base_url().'nonprofit/view'; ?>">
                                            <div class="seo-fact sbg2">
                                                <div class="p-4 d-flex justify-content-between align-items-center">
                                                    <div class="seofct-icon"><i class="ti-user"></i> Non Profit List</div>
                                                    <h2><?php echo $non_profit_count; ?></h2>
                                                </div>
                                            </div>
                                        </a>
                                </div>
                            </div>
                            <div class="col-md-6 mt-md-5 mb-3">
                                <div class="card">
                                        <a href="<?php echo base_url().'nonprofit/category_list'; ?>">
                                            <div class="seo-fact sbg2">
                                                <div class="p-4 d-flex justify-content-between align-items-center">
                                                    <div class="seofct-icon"><i class="ti-user"></i> Category</div>
                                                     <h2><?php echo $category_count; ?></h2>
                                                </div>
                                            </div>
                                        </a>
                                </div>
                            </div>
                            <div class="col-md-6 mt-md-5 mb-3">
                                <div class="card">
                                        <a href="<?php echo base_url().'user/payment_list'; ?>">
                                            <div class="seo-fact sbg2">
                                                <div class="p-4 d-flex justify-content-between align-items-center">
                                                    <div class="seofct-icon"><i class="ti-user"></i> Payment</div>
                                                    <h2><?php echo $payment_count; ?></h2>
                                                </div>
                                            </div>
                                        </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- main content area end -->
        
