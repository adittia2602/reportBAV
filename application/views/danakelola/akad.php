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
                            <h4><?= $subtitle?></h4>
                            <div class="table-responsive mt-5">
                                <table class="table table-bordered" id="dataTable">
                                    <thead>
                                        <tr class="text-center">
                                            <th>PENYALUR</th>
                                            <th>TGL AKAD</th>
                                            <th>NILAI AKAD</th>
                                            <th>BATCH</th>
                                            <th>TGL PENCAIRAN</th>
                                            <th>NILAI PENCAIRAN</th>
                                            <th>NILAI ANGSURAN</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($akad as $a) : ?>
                                            <tr>
                                                <td><?= $a['PENYALUR']; ?></td>
                                                <td><?= $a['TGLAKAD']; ?></td>
                                                <td class="text-right"><?=  number_format($a['NILAIAKAD'],0, '', '.'); ?></td>
                                                <td class="text-center"><?= $a['BATCH']; ?></td>
                                                <td><?= $a['TGLPENCAIRAN']; ?></td>
                                                <td class="text-right"><?= number_format($a['NILAIPENCAIRAN'],0, '', '.'); ?></td>
                                                <td class="text-right"><?= number_format($a['ANGSURAN'],0, '', '.'); ?></td>
                                            </tr>
                                        <?php endforeach;?>
                                    </tbody>
                            </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
      </div>