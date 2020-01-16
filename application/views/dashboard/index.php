          <div class="section-body">
            <div class="penyaluranOverall row">
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-primary">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Total Debitur</h4>
                            </div>
                            <div class="card-body">
                                <?= $overview['DEBITUR'] ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-danger">
                            <i class="fas fa-random"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Total Penyaluran</h4>
                            </div>
                            <div class="card-body" data-toggle="tooltip" title="Rp. <?= $overview['PENYALURAN_DEBITUR']; ?>">
                                <?= $pd = substr($overview['PENYALURAN_DEBITUR'],0,3)." T"; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-warning">
                            <i class="fas fa-undo"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Pengembalian Penyalur</h4>
                            </div>
                            <div class="card-body" data-toggle="tooltip" title="Rp. <?= $overview['PEMBAYARAN_POKOK_PENYALUR']; ?>">
                                <?= $pp = substr($overview['PEMBAYARAN_POKOK_PENYALUR'],0,3)." M"; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-success">
                            <i class="fas fa-handshake"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Total Pencairan</h4>
                            </div>
                            <div class="card-body" data-toggle="tooltip" title="Rp. <?= $overview['PENCAIRAN_PIP']; ?>">
                                <?= $pp = substr($overview['PENCAIRAN_PIP'],0,3)." T"; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="petaPenyaluran row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Peta Penyebaran Penyaluran UMi </h4>
                  </div>
                  <div class="card-body">
                    <div id="visitorMap3"></div>
                  </div>
                </div>
              </div>
            </div>

            <div class="chartPenyaluran row">
              <div class="col-12 col-md-3 col-lg-3">
                <div class="card">
                  <div class="card-header">
                    <h4>Penyaluran UMi by Gender</h4>
                  </div>
                  <div class="card-body">
                    <canvas id="jeniskelamin"></canvas>
                  </div>
                </div>
              </div>

              <div class="col-12 col-md-4 col-lg-4">
                <div class="card">
                  <div class="card-header">
                    <h4>Penyaluran UMi by Usia</h4>
                  </div>
                  <div class="card-body">
                    <canvas id="usia"></canvas>
                  </div>
                </div>
              </div>

              <div class="col-12 col-md-5 col-lg-5">
                <div class="card">
                  <div class="card-header">
                    <h4>Penyaluran UMi by Nominal Pembiayaan</h4>
                  </div>
                  <div class="card-body">
                    <canvas id="nominal"></canvas>
                  </div>
                </div>
              </div>
            </div>

            <div class="penyaluranPerPenyalur row">
              <div class="col-12 col-md-12 col-sm-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Summary Penyaluran (by Penyalur)</h4>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-striped" id="dataTable">
                        <thead>
                          <tr class="text-center">
                            <th>
                              #
                            </th>
                            <th>PENYALUR</th>
                            <th>TOTAL DEBITUR</th>
                            <th>TOTAL PENYALURAN</th>
                          </tr>
                        </thead>
                        <tbody>
                        <?php $i=1; foreach ($umiallpartner as $a) : ?>
                          <tr>
                            <td>
                              <?= $i ?>
                            </td>
                            <td><?= $a['PENYALUR']; ?></td>
                            <td class="text-right"><?= number_format($a['JMLDEBITUR'],0, '', '.'); ?></td>
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
        </section>
      </div>

      <footer class="main-footer">
        <div class="footer-left">
          Copyright &copy; 2019 <div class="bullet"></div> TIM SIT - PIP
        </div>
        <div class="footer-right">
          2.3.0
        </div>
      </footer>
    </div>
  </div>

  <!-- General JS Scripts -->
  <script src="<?php echo base_url('assets-report/'); ?>js/jquery.min.js"></script>
  <script src="<?php echo base_url('assets-report/'); ?>js/popper.js"></script>
  <script src="<?php echo base_url('assets-report/'); ?>vendor/bootstrap/js/bootstrap.min.js"></script>
  <script src="<?php echo base_url('assets-report/'); ?>js/nicescroll/jquery.nicescroll.min.js"></script>
  <script src="<?php echo base_url('assets-report/'); ?>js/moment.min.js"></script>
  <script src="<?php echo base_url('assets-report/'); ?>js/stisla.js"></script>

  <!-- JS Libraies -->
  <script src="<?php echo base_url('assets-report/'); ?>vendor/datatables/datatables.min.js"></script>
  <script src="<?php echo base_url('assets-report/'); ?>vendor/datatables/JSZip-2.5.0/jszip.min.js"></script>
  <script src="<?php echo base_url('assets-report/'); ?>vendor/datatables/Buttons-1.5.6/js/dataTables.buttons.min.js"></script>
  <script src="<?php echo base_url('assets-report/'); ?>vendor/datatables/Buttons-1.5.6/js/buttons.html5.min.js"></script>
  <script src="<?php echo base_url('assets-report/'); ?>vendor/datatables/Buttons-1.5.6/js/buttons.print.min.js"></script>
  <script src="<?php echo base_url('assets-report/'); ?>vendor/datatables/Buttons-1.5.6/js/buttons.flash.min.js"></script>
  <script src="<?php echo base_url('assets-report/'); ?>vendor/datatables/datatables.min.js"></script>
  <script src="<?php echo base_url('assets-report/'); ?>js/page/modules-datatables.js"></script>

  <script src="<?php echo base_url('assets-report/'); ?>vendor/jqvmap/jquery.vmap.min.js"></script>
  <script src="<?php echo base_url('assets-report/'); ?>vendor/jqvmap/jquery.vmap.indonesia.js"></script>

  <script src="<?php echo base_url('assets-report/'); ?>vendor/chart.min.js"></script>

  <!-- Template JS File -->
  <script src="<?php echo base_url('assets-report/'); ?>js/scripts.js"></script>
  <script src="<?php echo base_url('assets-report/'); ?>js/custom.js"></script>

  <!-- Page Specific JS File -->
  <script>
    var umiGender = JSON.parse('<?php echo $umi_gender; ?>');
    var umiAge      = JSON.parse('<?php echo $umi_age; ?>');
    var umiNominal  = JSON.parse('<?php echo $umi_nominal; ?>');
    var opt = { responsive: true, legend: {position: 'bottom' }, 
                tooltips: {
                    callbacks: {
                      label: function(tooltipItem, data) {
                        var value = data.datasets[0].data[tooltipItem.index];
                        value = value.toString();
                        value = value.split(/(?=(?:...)*$)/);
                        value = value.join('.');
                        return value + " Debitur";
                      }
                    } // end callbacks:
                  }, //end tooltips
    };

    var ctx = document.getElementById("jeniskelamin").getContext('2d');
    var myChart = new Chart(ctx, {
      type: 'pie',
      data: {
        datasets: umiGender.datasets,
        labels: umiGender.labels,
      },
      options: opt,
    });

    var ctx = document.getElementById("usia").getContext('2d');
    var myChart = new Chart(ctx, {
      type: 'pie',
      data: {
        datasets: umiAge.datasets,
        labels: umiAge.labels,
      },
      options: opt,
    });

    var ctx = document.getElementById("nominal").getContext('2d');
    var myChart = new Chart(ctx, {
      type: 'pie',
      data: {
        datasets: umiNominal.datasets,
        labels: umiNominal.labels,
      },
      options: opt,
    });

    
  </script>

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
                            + ''; 
        
                alert(message);
            }
        });
    });
  </script>
</body>
</html>

