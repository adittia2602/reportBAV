            <!-- Container fluid  -->
            <div class="container-fluid">
              
              <div class="overview card-group">
                  <div class="card border-right">
                      <div class="card-body">
                          <div class="d-flex d-lg-flex d-md-block align-items-center">
                              <div>
                                  <div class="d-inline-flex align-items-center">
                                      <h2 class="text-dark mb-1 font-weight-medium"><?= $overview->totaldebitur; ?></h2>
                                  </div>
                                  <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Debitur</h6>
                              </div>
                              <div class="ml-auto mt-md-3 mt-lg-0">
                                  <span class="opacity-7 text-muted"><i data-feather="users"></i></span>
                              </div>
                          </div>
                      </div>
                  </div>
                  <div class="card border-right">
                      <div class="card-body">
                          <div class="d-flex d-lg-flex d-md-block align-items-center">
                              <div>
                                  <h2 class="text-dark mb-1 w-100 text-truncate font-weight-medium"><sup
                                          class="set-doller">Rp</sup> <?= $overview->totalpenyaluran; ?></h2>
                                  <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Penyaluran
                                  </h6>
                              </div>
                              <div class="ml-auto mt-md-3 mt-lg-0">
                                  <span class="opacity-7 text-muted"><i data-feather="dollar-sign"></i></span>
                              </div>
                          </div>
                      </div>
                  </div>
                  <div class="card border-right">
                      <div class="card-body">
                          <div class="d-flex d-lg-flex d-md-block align-items-center">
                              <div>
                                  <div class="d-inline-flex align-items-center">
                                      <h2 class="text-dark mb-1 font-weight-medium"><?= $overview->totalpenyalur;?></h2>
                                  </div>
                                  <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Linkage</h6>
                              </div>
                              <div class="ml-auto mt-md-3 mt-lg-0">
                                  <span class="opacity-7 text-muted"><i data-feather="file-plus"></i></span>
                              </div>
                          </div>
                      </div>
                  </div>
                  <div class="card border-right">
                      <div class="card-body">
                          <div class="d-flex d-lg-flex d-md-block align-items-center">
                              <div>
                                  <h2 class="text-dark mb-1 w-100 text-truncate font-weight-medium"><sup
                                          class="set-doller">Rp </sup> <?= $overview->totalpembiayaan; ?></h2>
                                  <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Pembiayaan
                                  </h6>
                              </div>
                              <div class="ml-auto mt-md-3 mt-lg-0">
                                  <span class="opacity-7 text-muted"><i data-feather="dollar-sign"></i></span>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>

              <div class="petaPenyaluran row">
                  <div class="col-12">
                      <div class="card">
                          <div class="card-body">
                              <div class="d-flex align-items-center mb-4">
                                  <h4 class="card-title">Peta Penyaluran UMi - BAV</h4>
                              </div>
                              <div id="visitorMap3"></div>
                          </div>
                      </div>
                  </div>
              </div>    

              <div class="chartPenyaluran row">
                  <div class="col-lg-6 col-md-12">
                      <div class="card">
                          <div class="card-body">
                              <h4 class="card-title">Total Debitur UMi</h4>
                              <canvas id="debtorChart"></canvas>

                              <ul class="list-style-none mb-0">
                                <?php foreach ($master_debitur as $m) :?>
                                  <li>
                                      <i class="fas fa-circle text-primary font-10 mr-2"></i>
                                      <span class="text-muted"><?= $m->bulan; ?></span>
                                      <span class="text-dark float-right font-weight-medium"> <?= $m->debitur; ?></span>
                                  </li>
                                <?php endforeach; ?>
                              </ul>
                          </div>
                      </div>
                  </div>
                  <div class="col-lg-6 col-md-12">
                      <div class="card">
                          <div class="card-body">
                              <h4 class="card-title">Total Penyaluran UMi</h4>
                              <canvas id="disburseChart"></canvas>

                              <ul class="list-style-none mb-0">
                                <?php foreach ($master_penyaluran as $m) :?>
                                  <li>
                                      <i class="fas fa-circle text-primary font-10 mr-2"></i>
                                      <span class="text-muted"><?= $m->bulan; ?></span>
                                      <span class="text-dark float-right font-weight-medium"> <?= $m->penyaluran; ?></span>
                                  </li>
                                <?php endforeach; ?>
                              </ul>
                          </div>
                      </div>
                  </div>
              </div>

              <div class="reminder row">
                  <div class="col-12">
                      <div class="card">
                          <div class="card-body">
                              <div class="d-flex align-items-center mb-4">
                                  <h4 class="card-title">Reminder: Expired Pencairan</h4>
                                  <!-- <div class="ml-auto">
                                      <div class="dropdown sub-dropdown">
                                          <button class="btn btn-link text-muted dropdown-toggle" type="button"
                                              id="dd1" data-toggle="dropdown" aria-haspopup="true"
                                              aria-expanded="false">
                                              <i data-feather="more-vertical"></i>
                                          </button>
                                          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dd1">
                                              <a class="dropdown-item" href="#">Insert</a>
                                              <a class="dropdown-item" href="#">Update</a>
                                              <a class="dropdown-item" href="#">Delete</a>
                                          </div>
                                      </div>
                                  </div> -->
                              </div>
                              <div class="table-responsive">
                                  <table class="table no-wrap v-middle mb-0">
                                      <thead>
                                          <tr class="border-0">
                                              <th class="border-0 font-14 font-weight-medium text-muted ">PENYALUR   </th>
                                              <th class="border-0 font-14 font-weight-medium text-muted text-center px-2">TOTAL PEMBIAYAAN </th>
                                              <th class="border-0 font-14 font-weight-medium text-muted text-center">TOTAL PENYALURAN</th>
                                              <th class="border-0 font-14 font-weight-medium text-muted text-center">DUE DATE</th>
                                              <th class="border-0 font-14 font-weight-medium text-muted text-center">STATUS</th>
                                              <th class="border-0 font-14 font-weight-medium text-muted text-center"> Keterangan</th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                        <?php foreach ($reminder as $r) :
                                            $selisih = $r->duedate - $r->curdate ;
                                            if ($selisih < 0){
                                                $status = "text-danger";
                                            } else if ($selisih <= 30) {
                                                $status = "text-warning";
                                            } else {
                                                $status = "text-success";
                                            }
                                        ?>
                                          <tr>
                                              <td class="border-top-0 px-2 py-4">
                                                  <div class="d-flex no-block align-items-center">
                                                      <div class="">
                                                          <h5 class="text-dark mb-0 font-16 font-weight-medium"><?= $r->penyalur;?></h5>
                                                          <span class="text-muted font-14"><?= $r->kodepenyalur;?></span>
                                                      </div>
                                                  </div>
                                              </td>
                                              <td class="border-top-0 text-center text-muted px-2 py-4 font-14 center"><?= $r->totalpencairan;?></td>
                                              <td class="border-top-0 text-center text-muted px-2 py-4 font-14"><?= $r->totalpenyaluran;?></td>
                                              <td class="border-top-0 text-center text-muted px-2 py-4 font-14"><?= $r->tglexp;?></td>
                                              <td class="border-top-0 text-center px-2 py-4"><i
                                                      class="fa fa-circle <?= $status ?> font-12" data-toggle="tooltip"
                                                      data-placement="top" title="Penyaluran on progress"></i></td>
                                              <td class="border-top-0 text-center font-weight-medium text-muted px-2 py-4">
                                                    <?= $selisih ;?> hari
                                              </td>
                                          </tr>
                                        <?php endforeach; ?>
                                      </tbody>
                                  </table>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>

            </div>
            
            <!-- footer -->
            <footer class="footer text-center text-muted">
                All Rights Reserved by BAV.
            </footer>
        </div>
    </div>

    <!-- All Jquery -->
    <script src="<?php echo base_url('assets/'); ?>libs/jquery/dist/jquery.min.js"></script>
    <script src="<?php echo base_url('assets/'); ?>libs/popper.js/dist/umd/popper.min.js"></script>
    <script src="<?php echo base_url('assets/'); ?>libs/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- apps -->
    <script src="<?php echo base_url('assets/'); ?>js/app-style-switcher.js"></script>
    <script src="<?php echo base_url('assets/'); ?>js/feather.min.js"></script>
    <script src="<?php echo base_url('assets/'); ?>libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js"></script>
    <script src="<?php echo base_url('assets/'); ?>js/sidebarmenu.js"></script>
    <!--Custom JavaScript -->
    <script src="<?php echo base_url('assets/'); ?>js/custom.min.js"></script>
    <script src="<?php echo base_url('assets/'); ?>libs/chart.js/dist/Chart.min.js"></script>
    <script src="<?php echo base_url('assets/'); ?>extra-libs/jqvmap/jquery.vmap.min.js"></script>
    <script src="<?php echo base_url('assets/'); ?>extra-libs/jqvmap/jquery.vmap.indonesia.js"></script>

    <!-- Page Specific JS File -->
    <script type="text/javascript">
        var dataPenyaluran = JSON.parse('<?php echo $petapenyaluran; ?>');

        jQuery(document).ready(function() {
            jQuery('#visitorMap3').vectorMap({  
                map: 'indonesia_id',
                backgroundColor: '#ffffff',
                borderColor: '#f2f2f2',
                borderOpacity: .8,
                borderWidth: 1,
                hoverColor  : '#000',
                hoverOpacity: .8,
                color: '#ddd',
                selectedRegions: false,
                showTooltip: true,
                
                series: {
                    regions: [{values: dataPenyaluran,}]
                },
                onLabelShow: function(event, label, code){
                    var data =  label[0].innerHTML.toUpperCase()
                                + ' <b>  <br/> Total Debitur : '
                                + dataPenyaluran[code]['DEBITUR']
                                + ' </b> <br/> <b> Total Penyaluran : '
                                + dataPenyaluran[code]['PENYALURAN']
                                + '</b>'; 
                    label.html(data);
                },
                onRegionClick: function(element, code, region)
                {
                    var message = region.toUpperCase()
                                + ' | Total Debitur : '
                                + dataPenyaluran[code]['DEBITUR']
                                + ' | Total Penyaluran : '
                                + dataPenyaluran[code]['PENYALURAN']
                                + ' |'; 
            
                    alert(message);
                }
            });
        });
    </script>
    <script>
        var debtor = JSON.parse('<?php echo $overall_debitur; ?>');
        var umi_disburse = JSON.parse('<?php echo $overall_penyaluran; ?>');

        var opt1 = {
            legend: { display: false },
            scales: {
            yAxes: [{
                gridLines: { drawBorder: false, color: '#f2f2f2' },
                ticks: { beginAtZero: true }
            }],
            xAxes: [{
                ticks: { display: true },
                gridLines: { display: false }
            }]
            }
        };

        var ctx = document.getElementById("debtorChart").getContext('2d');
        var myChart = new Chart(ctx, {
        type: 'bar',
        data: debtor,
        options:opt1
        });

        var ctx = document.getElementById("disburseChart").getContext('2d');
        var myChart = new Chart(ctx, {
        type: 'bar',
        data: umi_disburse,
        options: opt1
        });
    </script>
    
</body>

</html>
