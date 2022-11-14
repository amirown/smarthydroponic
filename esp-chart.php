
<?php

$servername = "localhost";

// REPLACE with your Database name
$dbname = "esp_data";
// REPLACE with Database user
$username = "root";
// REPLACE with Database user password
$password = "";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "SELECT id, water_speed, water_quantity, light_intensity, reading_time FROM reading order by reading_time desc limit 40";

$result = $conn->query($sql);

while ($data = $result->fetch_assoc()){
    $reading[] = $data;
}

$reading_time = array_column($reading, 'reading_time');

// ******* Uncomment to convert readings time array to your timezone ********
/*$i = 0;
foreach ($readings_time as $reading){
    // Uncomment to set timezone to - 1 hour (you can change 1 to any number)
    $readings_time[$i] = date("Y-m-d H:i:s", strtotime("$reading - 1 hours"));
    // Uncomment to set timezone to + 4 hours (you can change 4 to any number)
    //$readings_time[$i] = date("Y-m-d H:i:s", strtotime("$reading + 4 hours"));
    $i += 1;
}*/

$WS = json_encode(array_reverse(array_column($reading, 'water_speed')), JSON_NUMERIC_CHECK);
$WQ = json_encode(array_reverse(array_column($reading, 'water_quantity')), JSON_NUMERIC_CHECK);
$LI = json_encode(array_reverse(array_column($reading, 'light_intensity')), JSON_NUMERIC_CHECK);
$reading_time = json_encode(array_reverse($reading_time), JSON_NUMERIC_CHECK);

/*echo $value1;
echo $value2;
echo $value3;
echo $reading_time;*/

$result->free();
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
      <!-- basic -->
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <!-- mobile metas -->
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="viewport" content="initial-scale=1, maximum-scale=1">
      <!-- site metas -->
      <title>SMART HYDROPONIC SYSTEM</title>
      <meta name="keywords" content="">
      <meta name="description" content="">
      <meta name="author" content="">
      <!-- bootstrap css -->
      <link rel="stylesheet" href="css/bootstrap.min.css">
      <!-- style css -->
      <link rel="stylesheet" href="css/style.css">
      <!-- Responsive-->
      <link rel="stylesheet" href="css/responsive.css">
      <!-- fevicon -->
      <link rel="icon" href="images/fevicon.png" type="image/gif" />
      <!-- Scrollbar Custom CSS -->
      <link rel="stylesheet" href="css/jquery.mCustomScrollbar.min.css">
      <!-- Tweaks for older IEs-->
      <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">
      <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
   </head>
<header>
         <!-- header inner -->
         <div class="header">
            <div class="container-fluid">
               <div class="row">
                  <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col logo_section">
                     <div class="full">
                        <div class="center-desk">
                           <div class="logo">
                              <a href="index.html"><img src="images/kktm.jpg" alt="#" /></a>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-xl-9 col-lg-9 col-md-9 col-sm-9">
                     <nav class="navigation navbar navbar-expand-md navbar-dark ">
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample04" aria-controls="navbarsExample04" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarsExample04">
                           <ul class="navbar-nav mr-auto">
                              <li>
                                 <a class="nav-link" href="index.html"> Home  </a>
                              </li>
                              
                              <li  class="nav-item active">
                                 <a class="nav-link" href="esp-chart.php">Realtime Dashboard</a>
                              </li>
                              


                              
                           
                           
                           </ul>
                        </div>
                     </nav>
                  </div>
               </div>
            </div>
         </div>
         
      </header>
      
<meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="https://code.highcharts.com/highcharts.js"></script>
  <style>
    body {
      min-width: 310px;
    	max-width: 1280px;
    	height: 500px;
      margin: 0 auto;
      background: #1f1f1f;
       
    }
    h2 {
      font-family: system-ui;
      font-size: 2.5rem;
      text-align: center;
      color: #ddd;
    }
  </style>
  <body>
    <h2>Smart Hydroponic System</h2>
    <div id="chart-water_speed" class="container"></div>
    <div id="chart-water_quantity" class="container"></div>
    <div id="chart-light_intensity" class="container"></div>
<script>

var WS = <?php echo $WS; ?>;
var WQ = <?php echo $WQ; ?>;
var LI = <?php echo $LI; ?>;

var reading_time = <?php echo $reading_time; ?>;

var chartT = new Highcharts.Chart({
  chart:{ renderTo : 'chart-water_speed' },
  title: { text: 'Water Speed' },
  series: [{
    showInLegend: false,
    data: WS
  }],
  plotOptions: {
    line: { animation: false,
      dataLabels: { enabled: true }
    },
    series: { color: '#059e8a' }
  },
  xAxis: { 
    type: 'datetime',
    categories: reading_time
  },
  yAxis: {
    title: { text: 'Water Speed (L/min)' }
    //title: { text: 'Temperature (Fahrenheit)' }
  },
  credits: { enabled: false }
});

var chartH = new Highcharts.Chart({
  chart:{ renderTo:'chart-water_quantity' },
  title: { text: 'Water Quantity' },
  series: [{
    showInLegend: false,
    data: WQ
  }],
  plotOptions: {
    line: { animation: false,
      dataLabels: { enabled: true }
    }
  },
  xAxis: {
    type: 'datetime',
    //dateTimeLabelFormats: { second: '%H:%M:%S' },
    categories: reading_time
  },
  yAxis: {
    title: { text: 'Milliliter (mL)' }
  },
  credits: { enabled: false }
});


var chartP = new Highcharts.Chart({
  chart:{ renderTo:'chart-light_intensity' },
  title: { text: 'Light Intensity' },
  series: [{
    showInLegend: false,
    data: LI
  }],
  plotOptions: {
    line: { animation: false,
      dataLabels: { enabled: true }
    },
    series: { color: '#18009c' }
  },
  xAxis: {
    type: 'datetime',
    categories: reading_time
  },
  yAxis: {
    title: { text: 'Bright/Dark' }
  },
  credits: { enabled: false }
});






</script>
<div class="choose ">
         <div class="container">
            <div class="row">
               <div class="col-md-8">
                  <div class="titlepage">
                     <h2>Other Dashboard is also available </h2>
                     <p >There are other dashboards that display different different graphs from different sensors such as Water level sensor, DHT11 sensor, PH sensor and MQ2 sensor.  </p>
                     
                  </div>
               </div>
            </div>
         </div>
         <div class="container-fluid">
            <div class="row d_flex">
               <div class="col-xl-7 col-lg-7 col-md-12 col-sm-12">
                  <div class="padding_with">
                     <div class="row">
                        <div class="col-md-6 padding_bottom">
                           <div class="choose_box">
                              <i><img src="images/icon1.png" alt="#"/></i>
                              <div class="choose_text">
                                 <h3><a href="https://danishfyp.000webhostapp.com" style="color:white;">Water Level and DHT11 Sensor Dashboard</a></h3>
                              </div>
                           </div>
                        </div>
                        <div class="col-md-6 padding_bottom">


                           <div class="choose_box">
                              <i><img src="images/icon2.png" alt="#"/></i>
                              <div class="choose_text">
                                 <h3><a href="http://asyraaffyp.000webhostapp.com" style="color:white;">PH and MQ2 Sensor Dashboard</a></h3>
                              </div>
                           </div>
                        </div>
</body>
</html>