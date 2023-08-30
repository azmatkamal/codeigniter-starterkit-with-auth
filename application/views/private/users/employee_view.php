<div class="row">
    <div class="col-md-12">
        <div class="kt-portlet" style="border: 3px dashed black">
            <div class="kt-portlet__head" style="justify-content: center;">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title">
                        Employees
                    </h3>
                </div>
            </div>
            <div class="kt-portlet__body table-responsive" style="display: flex;justify-content: center;">
                <table class="table table-bordered table-hover table-condensed">
                    <thead>
                        <tr style="background: #ddd;">
                            <th>ID</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Email Verified</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(count($employees)): ?>
                            <?php foreach($employees as $employee): ?>
                                <tr>
                                    <td><?php echo $employee->id; ?></td>
                                    <td><?php echo $employee->first_name; ?></td>
                                    <td><?php echo $employee->last_name; ?></td>
                                    <td><?php echo $employee->username; ?></td>
                                    <td><?php echo $employee->email; ?></td>
                                    <td><?php echo $employee->email_verified ? '<span class="kt-badge  kt-badge--success kt-badge--inline kt-badge--pill">Yes</span>' : '<span class="kt-badge  kt-badge--danger kt-badge--inline kt-badge--pill">No</span>'; ?></td>
                                    <td><?php echo $employee->is_active ? '<span class="kt-badge  kt-badge--success kt-badge--inline kt-badge--pill">Yes</span>' : '<span class="kt-badge  kt-badge--danger kt-badge--inline kt-badge--pill">No</span>'; ?></td>
                                    <td>
                                        <a href="<?php echo base_url(); ?>users/update/<?php echo $employee->id; ?>"><span class="kt-badge  kt-badge--info kt-badge--inline kt-badge--pill">Update</span></a>
                                        <?php if($employee->is_active): ?>
                                            <a href="<?php echo base_url(); ?>users/disable_employee/<?php echo $employee->id; ?>"><span class="kt-badge  kt-badge--danger kt-badge--inline kt-badge--pill">Disable</span></a>
                                        <?php else: ?>
                                            <a href="<?php echo base_url(); ?>users/enable_employee/<?php echo $employee->id; ?>"><span class="kt-badge  kt-badge--success kt-badge--inline kt-badge--pill">Enable</span></a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>