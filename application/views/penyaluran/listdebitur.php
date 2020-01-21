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
                            <h4><?= $subtitle; ?></h4>
                            <form class = "form-horizontal col-md-6  offset-md-3" action="<?= $_SERVER['REQUEST_URI']; ?>" method="post" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label class="control-label" for="penyalur">Penyalur : </label>
                                    <select name="penyalur" id="penyalur" class="form-control select2">
                                        <option value="">...</option>
                                        <?php foreach ($penyalur as $p) :?>
                                            <option value="<?=$p['did']; ?>"> <?= $p['nama']; ?> </option>
                                        <?php endforeach;?>
                                    </select>
                                </div>
                                <div class="row justify-content-end">
                                    <button type="submit" class="btn btn-primary btn-lg">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
      </div>