      <div class="section-body">
          <h2 class="section-title"> Pencarian Data Debitur UMi </h2>
          <p class="section-lead"> </p>
            <?php if (validation_errors()) : ?>
                <div class="alert alert-danger" role="alert ">
                    <?= validation_errors(); ?>
                </div>
            <?php endif; ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                        <h4><?= $subtitle; ?></h4>
                        </div>
                        <div class="card-body">
                            <?= form_error('pencairan', ''); ?> <?= $this->session->flashdata('message'); ?>

                            <form class = "form-horizontal col-md-6  offset-md-3" action="<?= base_url('dashboardSIKP/pencarian'); ?>" method="post" enctype="multipart/form-data">
                                <div class="form-group row">
                                    <label for="nik" class="col-sm-12 col-md-2 col-form-label">NIK : </label>
                                    <div class="col-md-8 col-sm-12">
                                        <input type="number" class="form-control" id="nik" name="nik">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 offset-md-4">
                                        <button type="submit" class="btn btn-primary btn-lg">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-12 col-sm-12 <?= $show; ?>">
                    <div class="card">
                        <?php if ($found) : ?>
                            <div class="empty-state" >
                                <h2 class="section-title"> NIK DITEMUKAN!</h2>
                                <!-- PRINT DATA DEBITUR -->
                                <div class="row mb-5">
                                    <div class="col-3 offset-3 text-left"> NIK </div>  <div class="col-6 text-left">: <b><?= $debtor['NIK']?></b> </div>
                                    <div class="col-3 offset-3 text-left"> NAMA </div>  <div class="col-6 text-left">: <b><?= $debtor['NAMA']?></b> </div>
                                    <div class="col-3 offset-3 text-left <?= $showStatus;?>"> TGL UPLOAD </div>  <div class="col-6 text-left <?= $showStatus;?>">: <b><?= $debtor['TGLUPLOAD']?></b> </div>
                                    <div class="col-3 offset-3 text-left <?= $showStatus;?>"> STATUS </div>  <div class="col-6 text-left <?= $showStatus;?>">: <b><?= $debtor['STATUS']?></b> </div>
                                    <div class="col-3 offset-3 text-left <?= $showStatus;?>"> KETERANGAN </div>  <div class="col-6 text-left <?= $showStatus;?>">: <b><?= $debtor['KETERANGAN']?></b> </div>
                                </div>
                    
                                <!-- PRINT LOOP DATA PEMBIAYAAN  -->
                                <div class="table-responsive <?= $showTable;?>">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr class="text-center">
                                                <th>
                                                #
                                                </th>
                                                <th>PENYALUR</th>
                                                <th>NOAKAD</th>
                                                <th>SEKTOR</th>
                                                <th>TGL AKAD</th>
                                                <th>TGL JATUHTEMPO</th>
                                                <th>NILAI AKAD</th>
                                                <th>OUTSTANDING</th>
                                                <th>KOLEKTABILITAS</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i=1; foreach ($debtor['KONTRAK'] as $a) : ?>
                                            <tr>
                                                <td class="text-center">
                                                <?= $i ?>
                                                </td>
                                                <td><?= $a['PENYALUR']; ?></td>
                                                <td><?= $a['NOAKAD']; ?></td>
                                                <td><?= $a['SEKTOR']; ?></td>
                                                <td><?= $a['TGLAKAD']; ?></td>
                                                <td><?= $a['TGLJATUHTEMPO']; ?></td>
                                                <td class="text-right">Rp. <?= number_format($a['NILAIAKAD'],0, '', '.'); ?></td>
                                                <td class="text-right">Rp. <?= number_format($a['OUTSTANDING'],0, '', '.'); ?></td>
                                                <td><?= $a['KOLEKTABILITAS']; ?></td>
                                            </tr>
                                            <?php $i++; endforeach;?>
                                        </tbody>
                                    </table>
                                </div>


                            </div>
                        <?php else : ?>
                            <div class="empty-state" data-height="300">
                                <h2 class="section-title"> NIK TIDAK DITEMUKAN! </h2>
                                
                                <p class="lead"> <?= $keterangan; ?> </p>
                            </div>
                        <?php endif;?>

                    </div>
                </div>
            </div>
        </section>
      </div>