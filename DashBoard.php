<html>
  <head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        <?php
          include 'SQL/Conexao.php';
          $sql = 'SELECT * FROM citys';
          $result = mysqli_query($conexao,$sql);
          $dataPoints = [];
          while($row = mysqli_fetch_array($result)) {
              $cidade = $row['city'];
              $populacao = $row['population'];
              $dataPoints[] = "['$cidade', $populacao]";
          }
          $dataPointsString = implode(",\n", $dataPoints);
        ?>
        var data = google.visualization.arrayToDataTable([
          ['City', 'Population'],
          <?php echo $dataPointsString; ?>
        ]);
        
        var options = {
          title: 'Company Performance',
          curveType: 'function',
          legend: { position: 'bottom' }
        };

        var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

        chart.draw(data, options);
      }
    </script>
  </head>
  <body>
    <div id="curve_chart" style="width: 900px; height: 500px"></div>
  </body>
</html>

