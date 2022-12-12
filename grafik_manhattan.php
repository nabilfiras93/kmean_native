<?php 
  if (empty($_SESSION['username'])) {
    header("location:index.php");
  }
  

  $data_unggul      = array();
  $data_berkembang  = array();
  $data_lemah       = array();


  $query = "SELECT * FROM nilai_siswa_manhattan WHERE CLUSTER='CLUSTER-1'";
  $resultat = $bdd->query($query) or die(print_r($bdd->errorInfo()));
  while ($row = $resultat->fetch()) { 
    $data_unggul[] = [(floatval($row['NILAI'])+floatval($row['PRESTASI_NONAKADEMIK'])+floatval($row['PERILAKU'])+floatval($row['ABSENSI']))];
  }

  $query = "SELECT * FROM nilai_siswa_manhattan WHERE CLUSTER='CLUSTER-2'";
  $resultat = $bdd->query($query) or die(print_r($bdd->errorInfo()));
  while ($row = $resultat->fetch()) { 
    $data_berkembang[] = [(floatval($row['NILAI'])+floatval($row['PRESTASI_NONAKADEMIK'])+floatval($row['PERILAKU'])+floatval($row['ABSENSI']))];
  }

  $query = "SELECT * FROM nilai_siswa_manhattan WHERE CLUSTER='CLUSTER-3'";
  $resultat = $bdd->query($query) or die(print_r($bdd->errorInfo()));
  while ($row = $resultat->fetch()) { 
    $data_lemah[] = [(floatval($row['NILAI'])+floatval($row['PRESTASI_NONAKADEMIK'])+floatval($row['PERILAKU'])+floatval($row['ABSENSI']))];
  }
?>

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script src="https://code.highcharts.com/modules/series-label.js"></script>

<style type="text/css">
  .highcharts-figure, .highcharts-data-table table {
    min-width: 90%; 
    max-width: 100%;
    margin: 5em auto;
  }

  .highcharts-data-table table {
    font-family: Verdana, sans-serif;
    border-collapse: collapse;
    border: 1px solid #EBEBEB;
    margin: 10px auto;
    text-align: center;
    width: 100%;
    max-width: 500px;
  }
  .highcharts-data-table caption {
      padding: 1em 0;
      font-size: 1.2em;
      color: #555;
  }
  .highcharts-data-table th {
    font-weight: 600;
      padding: 0.5em;
  }
  .highcharts-data-table td, .highcharts-data-table th, .highcharts-data-table caption {
      padding: 0.5em;
  }
  .highcharts-data-table thead tr, .highcharts-data-table tr:nth-child(even) {
      background: #f8f8f8;
  }
  .highcharts-data-table tr:hover {
      background: #f1f7ff;
  }
</style>


<figure class="highcharts-figure">
    <div id="container2"></div>
    <p class="highcharts-description"></p>
</figure>

<figure class="highcharts-figure">
    <div id="container"></div>
    <p class="highcharts-description"></p>
</figure>

<script type="text/javascript">
  $(document).ready(function() {
    Highcharts.chart('container', {
        chart: {
            type: 'scatter',
            zoomType: 'xy'
        },
        title: {
            text: 'GRAFIK HASIL PERHITUNGAN K-MEANS CLUSTERING (MANHATTAN)'
        },
        subtitle: {
            text: 'PENGELOMPOKAN SISWA'
        },
        xAxis: {
            title: {
                enabled: true,
                text: 'Value'
            },
            startOnTick: true,
            endOnTick: true,
            showLastLabel: true
        },
        yAxis: {
            title: {
                text: 'K-Means'
            }
        },
        legend: {
            layout: 'vertical',
            align: 'left',
            verticalAlign: 'top',
            x: 100,
            y: 70,
            floating: true,
            backgroundColor: Highcharts.defaultOptions.chart.backgroundColor,
            borderWidth: 1
        },
        plotOptions: {
            scatter: {
                marker: {
                    radius: 5,
                    states: {
                        hover: {
                            enabled: true,
                            lineColor: 'rgb(100,100,100)'
                        }
                    }
                },
                states: {
                    hover: {
                        marker: {
                            enabled: false
                        }
                    }
                },
                tooltip: {
                    headerFormat: '<b>{series.name}</b><br>',
                    pointFormat: ''
                }
            }
        },
        series: [{
            name: 'Unggul',
            color: 'rgba(223, 83, 83, .5)',
            data: <?php echo json_encode($data_unggul); ?>

        }, {
            name: 'Berkembang',
            color: 'rgba(119, 152, 191, .5)',
            data: <?php echo json_encode($data_berkembang); ?>
        }, {
            name: 'Lemah',
            color: 'rgba(143, 191, 119, 0.5)',
            data: <?php echo json_encode($data_lemah); ?>
        }]
    });


    Highcharts.chart('container2', {
      title: {
          text: 'GRAFIK TOTAL HASIL PERHITUNGAN K-MEANS CLUSTERING (MANHATTAN)'
      },
      xAxis: {
          categories: ['K-Means']
      },
      labels: {
          items: [{
              html: 'Total',
              style: {
                  left: '50px',
                  top: '18px',
                  color: ( // theme
                      Highcharts.defaultOptions.title.style &&
                      Highcharts.defaultOptions.title.style.color
                  ) || 'black'
              }
          }]
      },
      series: [{
          type: 'column',
          name: 'Unggul',
          data: [<?php echo count($data_unggul); ?>]
      }, {
          type: 'column',
          name: 'Berkembang',
          data: [<?php echo count($data_berkembang); ?>]
      }, {
          type: 'column',
          name: 'Lemah',
          data: [<?php echo count($data_lemah); ?>]
      }, {
          type: 'pie',
          name: 'Total consumption',
          data: [{
              name: 'Unggul',
              y: <?php echo count($data_unggul); ?>,
              color: Highcharts.getOptions().colors[0] // Jane's color
          }, {
              name: 'Berkembang',
              y: <?php echo count($data_berkembang); ?>,
              color: Highcharts.getOptions().colors[1] // John's color
          }, {
              name: 'Lemah',
              y: <?php echo count($data_lemah); ?>,
              color: Highcharts.getOptions().colors[2] // Joe's color
          }],
          center: [100, 80],
          size: 100,
          showInLegend: false,
          dataLabels: {
              enabled: false
          }
      }]
  });

  });
</script>