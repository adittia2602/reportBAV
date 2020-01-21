<div class="main-wrapper">
        <!-- Preloader - style you can find in spinners.css -->
        <div class="preloader">
            <div class="lds-ripple">
                <div class="lds-pos"></div>
                <div class="lds-pos"></div>
            </div>
        </div>

        <!-- Login box.scss -->
        <div class="auth-wrapper d-flex no-block justify-content-center align-items-center position-relative"
            style="background:url(<?php echo base_url('assets/'); ?>images/big/auth-bg.jpg) no-repeat center center;">
            <div class="auth-box row" width= "80%">
                <!-- <div class="col-lg-5 col-md-5 modal-bg-img rounded-circle" style="background-image: url(<?php echo base_url('assets/'); ?>images/img3.jpg);">
                </div> -->
                <div class="bg-white">
                    <div class="p-3">
                        <div class="text-center">
                            <img src="<?php echo base_url('assets/'); ?>images/bav.png" alt="wrapkit" width="25%">
                        </div>
                        <h2 class="mt-3 text-center">Reporting UMi BAV</h2>
                        <?php echo $this->session->flashdata('message'); ?>
                        <form class="mt-4" method="POST" action="<?php echo base_url('auth'); ?>">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="text-dark" for="name">Username</label>
                                        <input class="form-control" id="name" name="name" type="text" placeholder="Username">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="text-dark" for="password">Password</label>
                                        <input class="form-control" id="password" name="password" type="password" placeholder="Password">
                                    </div>
                                </div>
                                <div class="col-lg-12 text-center">
                                    <button type="submit" class="btn btn-block btn-dark">Sign In</button>
                                </div>
                                <div class="col-lg-12 text-center mt-5"></div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>