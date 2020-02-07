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
                                            <th>BATCH</th>
                                            <th>TGL PENCAIRAN</th>
                                            <th>NILAI PENCAIRAN</th>
                                            <th>TGL JATUH TAMPO</th>
                                            <th>ANGSURAN POKOK</th>
                                            <th>ANGSURAN BUNGA</th>
                                            <th>TOTAL ANGSURAN</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($tagihan as $a) : ?>
                                            <tr>
                                                <td><?= $a['penyalur']; ?></td>
                                                <td><?= $a['tglakad']; ?></td>
                                                <td ><?= number_format($a['batch'],0, '', '.'); ?></td>
                                                <td><?= $a['tglpencairan']; ?></td>
                                                <td><?= $a['nilaipencairan']; ?></td>
                                                <td><?= $a['tgljthtempo']; ?></td>
                                                <td class="text-right"><?= number_format($a['angsuranpokok'],0, '', '.'); ?></td>
                                                <td class="text-right"><?= number_format($a['angsuranbunga'],0, '', '.'); ?></td>
                                                <td class="text-right"><?= number_format($a['totalangsuran'],0, '', '.'); ?></td>
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