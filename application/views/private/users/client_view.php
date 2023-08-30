<div class="row">
    <div class="col-md-12">
        <div class="kt-portlet" style="border: 3px dashed black">
            <div class="kt-portlet__head" style="justify-content: center;">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title">
                        Clients
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
                        <?php if(count($clients)): ?>
                            <?php foreach($clients as $client): ?>
                                <tr>
                                    <td><?php echo $client->id; ?></td>
                                    <td><?php echo $client->first_name; ?></td>
                                    <td><?php echo $client->last_name; ?></td>
                                    <td><?php echo $client->username; ?></td>
                                    <td><?php echo $client->email; ?></td>
                                    <td><?php echo $client->email_verified ? '<span class="kt-badge  kt-badge--success kt-badge--inline kt-badge--pill">Yes</span>' : '<span class="kt-badge  kt-badge--danger kt-badge--inline kt-badge--pill">No</span>'; ?></td>
                                    <td><?php echo $client->is_active ? '<span class="kt-badge  kt-badge--success kt-badge--inline kt-badge--pill">Yes</span>' : '<span class="kt-badge  kt-badge--danger kt-badge--inline kt-badge--pill">No</span>'; ?></td>
                                    <td>
                                        <a href="<?php echo base_url(); ?>users/update/<?php echo $client->id; ?>"><span class="kt-badge  kt-badge--info kt-badge--inline kt-badge--pill">Update</span></a>
                                        <?php if($client->is_active): ?>
                                            <a href="<?php echo base_url(); ?>users/disable_client/<?php echo $client->id; ?>"><span class="kt-badge  kt-badge--danger kt-badge--inline kt-badge--pill">Disable</span></a>
                                        <?php else: ?>
                                            <a href="<?php echo base_url(); ?>users/enable_client/<?php echo $client->id; ?>"><span class="kt-badge  kt-badge--success kt-badge--inline kt-badge--pill">Enable</span></a>
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