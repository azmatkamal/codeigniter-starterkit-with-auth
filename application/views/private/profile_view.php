<div class="row">
    <div class="col-md-6">
        <!--begin::Portlet-->
        <div class="kt-portlet">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title">
                        Update Profile
                    </h3>
                </div>
            </div>

            <!--begin::Form-->
            <form class="kt-form" action="" method="post">
                <div class="kt-portlet__body">
                    <div class="form-group">
                        <label>First Name</label>
                        <input type="text" class="form-control" name="first_name" value="<?php echo $this->session->userdata('first_name'); ?>" placeholder="First Name">
                        <span class="form-text text-danger"><?php echo form_error('first_name'); ?></span>
                    </div>
                    <div class="form-group">
                        <label>Last Name</label>
                        <input type="text" class="form-control" name="last_name" value="<?php echo $this->session->userdata('last_name'); ?>" placeholder="Last Name">
                        <span class="form-text text-danger"><?php echo form_error('last_name'); ?></span>
                    </div>
                    <span class="form-text text-muted">Only fill if you want to change the password.</span>
                    <div class="form-group">
                        <label for="">Password</label>
                        <input type="password" class="form-control" id="" name="password" placeholder="Password">
                        <span class="form-text text-danger"><?php echo form_error('password'); ?></span>
                    </div>
                    <div class="form-group">
                        <label for="">Confirm Password</label>
                        <input type="password" class="form-control" id="" name="cpassword" placeholder="Confirm Password">
                        <span class="form-text text-danger"><?php echo form_error('cpassword'); ?></span>
                    </div>
                </div>
                <div class="kt-portlet__foot">
                    <div class="kt-form__actions">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </form>

            <!--end::Form-->
        </div>

        <!--end::Portlet-->
    </div>
</div>