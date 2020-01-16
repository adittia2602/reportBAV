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
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <div class="d-flex justify-content-end">
                                    <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#NewRoleModal">Tambah Role</a>
                                </div>

                                <table class="table table-bordered" id="dataTable">   
                                    <thead>
                                        <tr>
                                            <th scope="col">ID Role</th>
                                            <th scope="col">Nama Role</th>
                                            <th scope="col" class="text-center">Action</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1 ?>
                                        <?php foreach ($role as $r) : ?>
                                            <tr>
                                                <td><?= $r['id']; ?></td>
                                                <td><?= $r['role']; ?></td>
                                                <td class="text-center">
                                                    <a href="<?= base_url('users/roleaccess/') . $r['id']; ?>" class=" badge badge-warning">Access</a>
                                                    <?php if ( ($r['id'] != 1) && ($r['id'] != 2) ) { ?> 
                                                        <a href="<?= base_url('/users/deleteRole/'); ?><?= $r['id']; ?>" class="badge badge-danger" onclick="return confirm('Aakah anda yakin menghapus <?= $r['role']; ?>?')">Delete</a>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            <?php $i++; ?>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div> 
                        </div>
                    </div>
                </div>

                
            </div>

            <!-- Modal -->
            <div class="modal fade" id="NewRoleModal" tabindex="-1" role="dialog" aria-labelledby="NewRoleModalTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="NewRoleModalTitle">Input Data Role Baru</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <form action="<?= base_url('users/role'); ?>" method="POST">
                            <div class="modal-body">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="role" name="role" placeholder="Role Name">
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Add</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
      </div>
