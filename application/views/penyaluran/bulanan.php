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
                            <h4>Summary Penyaluran setiap Bulan</h4>

                            <div class="table-responsive mt-5">
                                <table class="table table-bordered" id="dataTable">
                                    <thead>
                                        <tr class="text-center">
                                            <th>
                                            #
                                            </th>
                                            <th>TAHUN</th>
                                            <th>BULAN</th>
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
                                            <td><?= $a['TAHUN']; ?></td>
                                            <td><?= $a['BULAN']; ?></td>
                                            <td><?= $a['PENYALUR']; ?></td>
                                            <td class="text-right"><?=  number_format($a['TOTALDEBITUR'],0, '', '.'); ?></td>
                                            <td class="text-right"><?= number_format($a['TOTALPENYALURAN'],0, '', '.'); ?></td>
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