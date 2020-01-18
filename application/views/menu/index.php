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
                                    <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#NewMenuModal">Add New Menu</a>
                                </div>

                                <a href="<?= base_url('menu/excel') ?>" class="btn btn-primary mb-3">Download</a>

                                <table class="table" id="dataTable">
                                    <thead>
                                        <tr>
                                            <th scope="col">No</th>
                                            <th scope="col">Group Menu</th>
                                            <th scope="col">Menu</th>
                                            <th scope="col">Urutan</th>
                                            <th scope="col" class="text-center">Action</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1 ?>
                                        <?php foreach ($menu as $m) : ?>
                                            <tr>
                                                <th scope="row"><?= $i; ?></th>
                                                <td><?= $m['group']; ?></td>
                                                <td><?= $m['menu']; ?></td>
                                                <td><?= $m['urutan']; ?></td>
                                                <td class="text-center">
                                                    <a href="" class=" badge badge-primary" data-toggle="modal" data-target="#editMenuModal<?= $m['id']; ?>">Edit</a>
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
            <div class="modal fade" id="NewMenuModal" tabindex="-1" role="dialog" aria-labelledby="NewMenuModalTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="NewMenuModalTitle">Add New Menu</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <form action="<?= base_url('menu'); ?>" method="post">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label class="control-label" for="group">Group Menu</label>
                                    <input type="text" class="form-control" id="group" name="group">
                                </div>

                                <div class="form-group">
                                    <label class="control-label" for="menu">Menu</label>
                                    <input type="text" class="form-control" id="menu" name="menu">
                                </div>

                                <div class="form-group">
                                    <label class="control-label" for="urutan">Urutan</label>
                                    <input type="number" class="form-control" id="urutan" name="urutan">
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

            <?php foreach ($menu as $m) : ?>
                <div class="modal fade" role="dialog" id="editMenuModal<?= $m['id']; ?>">
                    <div class="modal-dialog " role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editMenuModalTitle">Edit Menu: <?= $m['menu']; ?></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <form action="<?= base_url('menu/updatemenu/' . $m['id']) ?>" method="post">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label class="control-label" for="group">Group Menu</label>
                                        <input type="text" class="form-control" id="group" name="group" value="<?= $m['group']; ?>">
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label" for="menu">Menu</label>
                                        <input type="text" class="form-control" id="menu" name="menu" value="<?= $m['menu']; ?>">
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label" for="urutan">Urutan</label>
                                        <input type="number" class="form-control" id="urutan" name="urutan" value="<?= $m['urutan']; ?>">
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
            <?php endforeach; ?>
        </div>