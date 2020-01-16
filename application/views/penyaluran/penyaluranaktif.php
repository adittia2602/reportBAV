        <div class="section-body">
          <h2 class="section-title"> Data Penyaluran UMi  </h2>
          <p class="section-lead"> </p>
            <?php if (validation_errors()) : ?>
                <div class="alert alert-danger" role="alert ">
                    <?= validation_errors(); ?>
                </div>
            <?php endif; ?> 
            <?= form_error('penyaluran/penyaluranaktif', ''); ?> <?= $this->session->flashdata('message'); ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                        <h4>Summary per Wilayah per <?= $cod; ?></h4>
                        </div>
                        <div class="card-body">

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
                                            <td class="text-right"><?=  number_format($a['TOTALDEBITUR'],0, '', '.'); ?></td>
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