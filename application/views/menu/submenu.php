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
                                    <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#NewSubMenuModal">Tambah Submenu</a>
                            </div>
                            <table class="table table-hover" id="dataTable">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Title</th>
                                        <th scope="col">Menu</th>
                                        <th scope="col">View Folder Path</th>
                                        <th scope="col">Icon</th>
                                        <th scope="col">Active</th>
                                        <th scope="col">action</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    <?php foreach ($submenu as $sm) :
                                        if ( $sm['menu_id'] == 1 || $sm['menu_id'] == 2 || $sm['menu_id'] == 3 || $sm['menu_id'] == 4) {continue;}
                                    ?>
                                        <tr>
                                            <th scope="row"><?= $i; ?></th>
                                            <td><?= $sm['title']; ?></td>
                                            <td><?= $sm['menu']; ?></td>
                                            <td><?= $sm['url']; ?></td>
                                            <td><?= $sm['icon']; ?></td>
                                            <td><?= $sm['is_active']; ?></td>
                                            <td>
                                                <a href="" class="badge badge-success" data-toggle="modal" data-target="#editSubmenuModal<?=$sm['id'];?>">Edit</a>
                                                <a href="<?= base_url('/menu/deletesubmenu/'); ?><?= $sm['id']; ?>" class="badge badge-danger" onclick="return confirm('apakah anda yakin akan menghapus submenu: <?= $sm['title']; ?>?')">Delete</a>
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

        <!-- Modal  New-->
        <div class="modal fade" id="NewSubMenuModal" tabindex="-1" role="dialog" aria-labelledby="NewSubMenuModalTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="NewSubMenuModalTitle">Add New Submenu</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <form action="<?= base_url('menu/submenu'); ?>" method="post">
                        <div class="modal-body">
                            <div class="form-group">
                                <input type="text" class="form-control" id="title" name="title" placeholder="Submenu Title">
                            </div>

                            <div class="form-group">
                                <select name="menu_id" id="menu_id" class="form-control">
                                    <option value="">Select Menu</option>
                                    <?php foreach ($menu as $m) : ?>
                                        <option value="<?= $m['id']; ?>"> <?= $m['group']; ?> - <?= $m['menu']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" id="url" name="url" placeholder="Url View Folder">
                            </div>

                            <div class="form-group">
                                <input type="text" class="form-control" id="icon" name="icon" placeholder="Submenu Icon">
                            </div>

                            <div class="form-group">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="1" name="is_active" id="defaultCheck1" checked>
                                    <label class="form-check-label" for="is_active">
                                        Active ?
                                    </label>
                                </div>
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

        <!-- Modal Edit -->
        <?php foreach ($submenu as $sm) : ?>
            <div class="modal fade" id="editSubmenuModal<?=$sm['id'];?>" tabindex="-1" role="dialog" aria-labelledby="editSubmenuModalTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editSubmenuModalTitle">Edit Submenu</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <form action="<?= base_url('menu/updatesubmenu/'.$sm['id'])?>" method="POST">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label class="control-label" for="title">Title</label>
                                    <input type="text" class="form-control" id="title" name="title" value="<?=$sm['title'];?>">
                                </div>

                                <div class="form-group">
                                    <label class="control-label" for="menu_id">Parent Menu</label>
                                    <select name="menu_id" id="menu_id" class="form-control">
                                        <?php foreach ($menu as $m) : ?>
                                            <?php if ($m['id'] === $sm['menu_id']) : ?>
                                                <option value="<?=$m['id'];?>" selected> <?= $m['group']; ?> - <?=$m['menu'];?> </option>
                                            <?php else : ?>
                                                <option value="<?=$m['id'];?>"> <?= $m['group']; ?> - <?=$m['menu'];?> </option>
                                        <?php endif; endforeach;?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label class="control-label" for="url">Url View Folder</label>
                                    <input type="text" class="form-control" id="url" name="url" value="<?= $sm['url']; ?>">
                                </div>

                                <div class="form-group">
                                    <label class="control-label" for="icon">Icon </label>
                                    <input type="text" class="form-control" id="icon" name="icon" value="<?= $sm['icon']; ?>">
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

    