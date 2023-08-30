<div class="row">
    <div class="col-md-6">
        <!--begin::Portlet-->
        <div class="kt-portlet">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title">
                        New User
                    </h3>
                </div>
            </div>

            <!--begin::Form-->
            <form class="kt-form" action="<?php echo base_url(); ?>users/new" method="post">
                <div class="kt-portlet__body">
                    <div class="form-group">
                        <label>First Name</label>
                        <input type="text" class="form-control" name="first_name" value="<?php echo set_value('first_name'); ?>" placeholder="First Name">
                        <span class="form-text text-danger"><?php echo form_error('first_name'); ?></span>
                    </div>
                    <div class="form-group">
                        <label>Last Name</label>
                        <input type="text" class="form-control" name="last_name" value="<?php echo set_value('last_name'); ?>" placeholder="Last Name">
                        <span class="form-text text-danger"><?php echo form_error('last_name'); ?></span>
                    </div>
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" class="form-control" name="username" value="<?php echo set_value('username'); ?>" placeholder="Username" onkeyup="$(this).val($(this).val().replace(/[^a-zA-Z0-9]/g, ''))">
                        <span class="form-text text-danger"><?php echo form_error('username'); ?></span>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="text" class="form-control" name="email" value="<?php echo set_value('email'); ?>" placeholder="Email">
                        <span class="form-text text-danger"><?php echo form_error('email'); ?></span>
                    </div>
                    <div class="form-group">
                        <label>User Type</label>
                        <select name="user_type" id="user_type" class="form-control">
                            <option value="">Select User Type</option>
                            <?php if(is_employee()): ?>
                                <option value="3" <?php echo set_value('user_type')=='3' ? 'selected' : ''; ?>>Client</option>
                            <?php endif; ?>
                            <?php if(is_admin()): ?>
                                <option value="2" <?php echo set_value('user_type')=='2' ? 'selected' : ''; ?>>Employee</option>
                                <option value="1" <?php echo set_value('user_type')=='1' ? 'selected' : ''; ?>>Administrator</option>
                            <?php endif; ?>
                        </select>
                        <span class="form-text text-danger"><?php echo form_error('user_type'); ?></span>
                    </div>
                </div>
                <div class="kt-portlet__foot">
                    <div class="kt-form__actions">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>