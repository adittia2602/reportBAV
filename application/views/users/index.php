      <!-- Container fluid  -->
      <div class="container-fluid">
            <!-- Notification -->
            <?php if (validation_errors()) : ?>
                <div class="alert alert-danger" role="alert ">
                    <?= validation_errors(); ?>
                </div>
            <?php endif; ?>
            <?= form_error('accesspublic', ''); ?> <?= $this->session->flashdata('message'); ?>

            <!-- Data -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                           
                            <div class="d-flex justify-content-end mb-5">
                                    <a href="<?= base_url("auth/registration");?>" class="btn btn-primary" target="_blank">Tambah User</a>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable">
                                    <thead>
                                        <tr class="text-center">
                                            <th>ID</th>
                                            <th>NAMA PENGGUNA</th>
                                            <th>USERNAME</th>
                                            <th>EMAIL</th>
                                            <th>ROLE</th>
                                            <th>IS ACTIVE</th>
                                            <th>ACTION</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i=1; foreach ($users as $a) : ?>
                                            <tr>
                                                <td class="text-center"><?= $a['id']; ?></td>
                                                <td><?= $a['fullname']; ?></td>
                                                <td><?= $a['name']; ?></td>
                                                <td><?= $a['email']; ?></td>
                                                <td><?= $a['role']; ?></td>
                                                <td class="text-center"><?= $a['is_active']; ?></td>
                                                <td class="text-center">
                                                    <?php if( $a['id'] != 1 ) : ?>
                                                        <a href="" class=" badge badge-primary" data-toggle="modal" data-target="#editUsersModal<?=$a['id'];?>">Edit</a>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php $i++; endforeach;?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                            
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal -->
            <?php foreach ($users as $sm) : ?>
                <div class="modal fade" role="dialog" id="editUsersModal<?=$sm['id'];?>">
                    <div class="modal-dialog " role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editUsersModalTitle">Edit Users</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <form action="<?= base_url('users/updateuser/'.$sm['id'])?>" method="post">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label class="control-label" for="name">Username</label>
                                        <input type="text" class="form-control" id="name" name="name" readonly value="<?=$sm['name'];?>">
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label" for="name">Nama Lengkap</label>
                                        <input type="text" class="form-control" id="fullname" name="fullname" value="<?=$sm['fullname'];?>">
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label" for="email">Email</label>
                                        <input type="text" class="form-control" id="email" name="email" value="<?=$sm['email'];?>">
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label" for="role">Role</label>
                                        <select name="role" id="role" class="form-control">
                                            <?php foreach ($role as $r) : ?>
                                                <?php if ($r['id'] === $sm['role_id']) : ?>
                                                    <option value="<?=$r['id'];?>" selected> <?=$r['role'];?> </option>
                                                <?php else : ?>
                                                    <option value="<?=$r['id'];?>"> <?=$r['role'];?> </option>
                                            <?php endif; endforeach;?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label" for="password">Password</label>
                                        <input type="password" class="form-control" id="password" name="password">
                                    </div>

                                    <div class="form-group">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="1" name="is_active" id="is_active" <?php if( $sm['is_active'] == 1 ) { echo "checked"; } ?> >
                                            <label class="form-check-label" for="is_active">
                                                Active
                                            </label>
                                        </div>
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach;?>
        </div>

    
