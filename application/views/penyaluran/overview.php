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
                            <h4>Summary per Wilayah</h4>
                            <div class="">
                                <form class = "form-horizontal col-md-6  offset-md-6" action="<?= base_url('penyaluran/wilayah'); ?>" method="post" enctype="multipart/form-data">
                                    <div class="form-group row">
                                        <label for="cod" class="col-sm-12 col-md-2 offset-md-3 col-form-label">Cut Off Date : </label>
                                        <div class="col-md-5 col-sm-12">
                                            <input type="date" class="form-control" id="cod" name="cod" value="<?= $cod; ?>">
                                        </div>
                                        <div class="col-md-2 col-sm-12">
                                            <button type="submit" class="btn btn-primary btn-md">Submit</button>
                                        </div>
                                    </div>
                                    
                                </form>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable">   
                                    <thead>                                 
                                        <tr class="text-center">
                                            <th>
                                            #
                                            </th>
                                            <th>PROPINSI</th>
                                            <th>KABKOTA</th>
                                            <th>PENYALUR</th>
                                            <th>TOTAL DEBITUR</th>
                                            <th>TOTAL PENYALURAN</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i=1; foreach ($umi as $a) : ?>                              
                                        <tr>
                                            <td class="text-center">
                                            <?= $i ?>
                                            </td>
                                            <td><?= $a['PROPINSI']; ?></td>
                                            <td><?= $a['KABKOTA']; ?></td>
                                            <td><?= $a['LINKAGE']; ?></td>
                                            <td class="text-right"><?=  number_format($a['JUMDEBITUR'],0, '', '.'); ?></td>
                                            <td class="text-right"><?= number_format($a['TOTAPENYALURAN'],0, '', '.'); ?></td>
                                        </tr>
                                        <?php $i++; endforeach;?>
                                    </tbody>
                            </table>
                            </div> 
                        </div>
                    </div>
                </div>
            </div>
        </section>
      </div>