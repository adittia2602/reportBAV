
    <div class="container">
        <div class="row">
          <div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-8 offset-lg-2 col-xl-8 offset-xl-2">
            <div class="login-brand">
              <img src="<?= base_url('assets-report/')?>/img/logo.png" alt="logo" width="35%" class="">
            </div>

            <div class="card card-primary">
              <div class="card-header"><h4>Register an Account</h4></div>

              <div class="card-body">
                <?php if (validation_errors()) : ?>
                    <div class="alert alert-danger" role="alert ">
                        <?= validation_errors(); ?>
                    </div>
                <?php endif; ?> <?= form_error('accesspublic', ''); ?> <?= $this->session->flashdata('message'); ?>
                <form method="POST" action="<?php echo base_url('auth/registration'); ?>">
                  <div class="form-group">
                    <label for="username">Username</label>
                    <input id="username" type="text" class="form-control" name="username">
                    <div class="invalid-feedback">
                        <?php echo form_error('username', '<small class ="text-danger pl-3">', ' </small>'); ?>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="name">Nama Lengkap</label>
                    <input id="name" type="text" class="form-control" name="name">
                    <div class="invalid-feedback">
                        <?php echo form_error('name', '<small class ="text-danger pl-3">', ' </small>'); ?>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email" type="email" class="form-control" name="email">
                    <div class="invalid-feedback">
                        <?php echo form_error('email', '<small class ="text-danger pl-3">', ' </small>'); ?>
                    </div>
                  </div>

                  <div class="row">
                    <div class="form-group col-6">
                      <label for="password" class="d-block">Password</label>
                      <input id="password" type="password" class="form-control" name="password">
                    </div>
                    <div class="form-group col-6">
                      <label for="passconf" class="d-block">Password Confirmation</label>
                      <input id="passconf" type="password" class="form-control" name="passconf">
                    </div>
                    <div class="invalid-feedback">
                        <?php echo form_error('password', '<small class ="text-danger pl-3">', ' </small>'); ?>
                    </div>
                  </div>

                  <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-block">
                      Register
                    </button>
                  </div>
                </form>
                <div class="text-center">
                    <a class="small" href="<?php echo base_url('auth'); ?>">Already have an account? Login!</a>
                </div>
              </div>
            </div>
            <div class="simple-footer">
              TIM SIT &copy; PIP  2019
            </div>
          </div>
        </div>
      </div>
      

                        