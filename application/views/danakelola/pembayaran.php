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
                                            <th>FASILITAS KE-</th>
                                            <th>NILAI PENCAIRAN</th>
                                            <th>TGL BAYAR</th>
                                            <th>ANGSURAN POKOK</th>
                                            <th>ANGSURAN BUNGA</th>
                                            <th>TOTAL ANGSURAN</th>
                                            <th>OUTSTANDING</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($akad as $a) : ?>
                                            <tr>
                                                <td><?= $a['PENYALUR']; ?></td>
                                                <td class="text-center"><?= $a['PENYALURAN_KE']; ?></td>
                                                <td class="text-right"><?= number_format($a['NILAI_PENCAIRAN'],0, '', '.'); ?></td>
                                                <td><?= $a['TGL_BAYAR']; ?></td>
                                                <td class="text-right"><?= number_format($a['NILAI_POKOK'],0, '', '.'); ?></td>
                                                <td class="text-right"><?= number_format($a['NILAI_BUNGA'],0, '', '.'); ?></td>
                                                <td class="text-right"><?= number_format($a['TOTAL_BAYAR'],0, '', '.'); ?></td>
                                                <td class="text-right"><?= number_format($a['OUTSTANDING'],0, '', '.'); ?></td>
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