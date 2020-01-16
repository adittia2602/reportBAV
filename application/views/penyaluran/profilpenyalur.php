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
                <div class="col-12 col-sm-12 col-md-10 offset-md-1">
                    <div class="card profile-widget">
                    <div class="profile-widget-header">
                        <img alt="image" src="<?= base_url('assets-report');?>/img/avatar/avatar-1.png" class="rounded-circle profile-widget-picture">
                        <div class="profile-widget-items">
                        <div class="profile-widget-item">
                            <div class="profile-widget-item-label">Debitur</div>
                            <div class="profile-widget-item-value"><?= number_format($profil['TOTALDEBITUR'],0, '', '.');?></div>
                        </div>
                        <div class="profile-widget-item">
                            <div class="profile-widget-item-label">Penyaluran</div>
                            <div class="profile-widget-item-value">Rp. <?= number_format($profil['TOTALPENYALURAN'],0, '', '.');?></div>
                        </div>
                        <div class="profile-widget-item">
                            <div class="profile-widget-item-label">Pencairan</div>
                            <div class="profile-widget-item-value">Rp. <?= number_format($profil['PENCAIRAN'],0, '', '.');?></div>
                        </div>
                        </div>
                    </div>
                    <div class="profile-widget-description pb-0">
                        <div class="profile-widget-name mb-5"><b><?= $profil['PENYALUR'];?></b><div class="text-muted d-inline font-weight-normal"> | <small>ID Penyalur : <?= $profil['KODEBARU'];?> / <?= $profil['KODELAMA'];?> </small></div></div>

                        <div class="summary">
                            <div class="summary-item border-bottom">
                                <h6 class="mt-3">OUTSTANDING LOAN <span class="text-muted">(OSL)</span></h6>
                                <ul class="list-unstyled list-unstyled-border">
                                    <li class="media">
                                        <div class="media-body">
                                        <div class="media-right">Rp. <?= number_format($profil['OS_PEMBIAYAAN'],0, '', '.');?></div>
                                        <div class="media-title"><a href="#">OSL Pencairan</a></div>
                                        <div class="text-small text-muted"> Outstanding dana PIP di Penyalur <div class="bullet"></div> COD: <a href="#"><?= date("d F Y");?></a> </div>
                                        </div>
                                    </li>
                                    <li class="media">
                                        <div class="media-body">
                                        <div class="media-right">Rp. <?= number_format($profil['OS_PENYALURAN'],0, '', '.');?></div>
                                        <div class="media-title"><a href="#">OSL Penyaluran</a></div>
                                        <div class="text-small text-muted"> Outstanding Penyaluran ke Debitur <div class="bullet"></div> COD: <a href="#"><?= date("d F Y");?></a>  </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <!-- <div class="summary-item">
                                <h6 class="mt-3">PEMBAYARAN PIUTANG <span class="text-muted"> (ke PIP)</span></h6>
                                <ul class="list-unstyled list-unstyled-border">
                                <li class="media">
                                    <div class="media-body">
                                    <div class="media-right">Rp. <?= number_format($profil['BAYAR_PIUTANG_POKOK'],0, '', '.');?></div>
                                    <div class="media-title"><a href="#">Total Pembayaran Pokok</a></div>
                                    <div class="text-small text-muted">COD: <a href="#"><?= date("F Y");?></a> <div class="bullet"></div> <?= date("D");?></div>
                                    </div>
                                </li>
                                <li class="media">
                                    <div class="media-body">
                                    <div class="media-right">Rp. <?= number_format($profil['BAYAR_PIUTANG_BUNGA'],0, '', '.');?></div>
                                    <div class="media-title"><a href="#">Total Pembayaran Bunga</a></div>
                                    <div class="text-small text-muted">COD: <a href="#"><?= date("F Y");?></a> <div class="bullet"></div> <?= date("D");?></div>
                                    </div>
                                </li>
                                </ul>
                            </div> -->
                        </div>
                    </div>
                    <div class="card-footer text-center mt-3">
                        <a class="btn btn-primary" href="<?= base_url('penyaluran/penyalur')?>" ><i class="fa fa-arrow-left"></i> Back to Penyalur</a>
                    </div>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-6">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h4>Akad & Pencairan Pembiayaan</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered multipleTable" >
                                    <thead>
                                        <tr class="text-center">
                                            <th>
                                            #
                                            </th>
                                            <th>TGL AKAD</th>
                                            <th>NILAI AKAD</th>
                                            <th>BATCH</th>
                                            <th>TGL PENCAIRAN</th>
                                            <th>NILAI PENCAIRAN</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($profil['AKAD_PEMBIAYAAN'] as $a) : ?>
                                        <tr>
                                            <td><?= $a['FASILITAS KE-']; ?></td>
                                            <td><?= $a['TGLAKAD']; ?></td>
                                            <td class="text-right"><?= number_format($a['NILAIAKAD'],0, '', '.'); ?></td>
                                            <td><?= $a['BATCH']; ?></td>
                                            <td><?= $a['TGLPENCAIRAN']; ?></td>
                                            <td class="text-right"><?= number_format($a['NILAIPENCAIRAN'],0, '', '.'); ?></td>
                                        </tr>
                                        <?php endforeach;?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-6">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h4>History Upload SIKP</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered multipleTable">
                                    <thead>
                                        <tr class="text-center">
                                            <th>
                                            #
                                            </th>
                                            <th>TGL UPLOAD</th>
                                            <th>TGL AKAD</th>
                                            <th>TOTAL DEBITUR</th>
                                            <th>TOTAL PENYALURAN</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; foreach ($profil['HISTORY_UPLOAD'] as $a) : ?>
                                        <tr>
                                            <td><?= $i;?></td>
                                            <td><?= $a['TGLUPLOAD']; ?></td>
                                            <td><?= $a['TGLAKAD']; ?></td>
                                            <td class="text-right"><?= number_format($a['TOTALDEBITUR'],0, '', '.'); ?></td>
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
