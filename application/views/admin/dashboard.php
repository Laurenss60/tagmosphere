<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Tagmosphere</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="apple-mobile-web-app-capable" content="yes" />
  <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
	<link href="<?=base_url();?>assets/third_party/bootstrap/css/bootstrap.css" rel="stylesheet">
	<link href="<?=base_url();?>assets/third_party/bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
  <link href="<?=base_url();?>assets/css/newAdmin.css" rel="stylesheet">
</head>
<body>
  
  <div id="fixed-bg-top"></div>
  
  <div id="top-nav" class="navbar navbar-inverse navbar-fixed-top">
    <div class="navbar-inner">
      <div class="container">
        <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="brand" href="<?= site_url('admin/dashboard'); ?>">Tagmosphere <small style="font-variant: small-caps; font-weight: bold;">admin</small></a>
        <div class="nav-collapse collapse">
          <ul class="nav">
            <li class="active"><a href="<?= site_url('admin/dashboard'); ?>">Dashboard</a></li>
            <li><a href="<?= site_url('admin/users'); ?>">Gebruikers</a></li>
            <li><a href="<?= site_url('admin/locations'); ?>">Locaties</a></li>
            <li><a href="<?= site_url('admin/categories'); ?>">Categorie&euml;n</a></li>
            <li><a href="<?= site_url('admin/datasets'); ?>">Datasets</a></li>
          </ul>
          <ul class="nav pull-right mobile-left">
            <li><a href="<?= site_url('wall'); ?>">Gebruikers niveau</a></li>
            <li><a href="<?= site_url('user/logout'); ?>">Uitloggen</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>
  </div>
  
  <div id="page-nav" class="navbar">
    <h4 class="visible-phone">Dashboard</h4>
    <div class="navbar-inner">
      <a class="brand hidden-phone hidden-tablet" href="<?= site_url('admin/dashboard'); ?>">Dashboard</a>
      <ul class="nav">
        <li class="active">
          <a href="<?= site_url('admin/dashboard'); ?>">
            <i class="icon-home"></i><span class="hidden-phone">&nbsp;Dashboard</span>
          </a>
        </li>
        <li>
          <a href="<?= site_url('admin/users'); ?>">
            <i class="icon-user"></i><span class="hidden-phone">&nbsp;Gebruikers</span>
          </a>
        </li>
        <li>
          <a href="<?= site_url('admin/locations'); ?>">
            <i class="icon-map-marker"></i><span class="hidden-phone">&nbsp;Locaties</span>
          </a>
        </li>
        <li>
          <a href="<?= site_url('admin/categories'); ?>">
            <i class="icon-th-large"></i><span class="hidden-phone">&nbsp;Categorie&euml;n</span>
          </a>
        </li>
        <li>
          <a href="<?= site_url('admin/datasets'); ?>">
            <i class="icon-magnet"></i><span class="hidden-phone">&nbsp;Datasets</span>
          </a>
        </li>
      </ul>
    </div>
  </div>

  <div class="container">

    <div class="row-fluid">
      <div class="span8">
        <h4>Statistieken</h4>
        <div id="stats-charts" class="row-fluid hidden-phone">
          <div id="chart_categories" class="charts span6"></div>
          <div id="chart_locations" class="charts span6"></div>
        </div>
        <div id="stats-table" class="row-fluid">
          <table class='table table-bordered table-striped'>
            <tr><th class='span6'>Aantal gebruikers</th><td class='span6'><span class="badge badge-info"><?= $users_count['num']; ?></span></td></tr>
            <tr><th>Aantal foto's</th><td><span class="badge badge-info"><?= $photos_count['num']; ?></span></td></tr>
            <tr><th>Aantal locaties</th><td><span class="badge badge-info"><?= $locations_count['num']; ?></span></td></tr>
            <tr><th>Aantal categorie&euml;n</th><td><span class="badge badge-info"><?= $categories_count['num']; ?></span></td></tr>
            <tr><th>Aantal datasets</th><td><span class="badge badge-info"><?= $datasets_count['num']; ?></span></td></tr>
          </table>
        </div>
      </div>
      <div class="span4">
        <h4>Webserver</h4>
        <label>Schijfruimte <small class="pull-right"><?= $diskSpaceUsed ?>MB / <?= $diskSpaceTotal ?>MB | <?= $diskSpacePercentage ?>%</small></label>
        <div class="progress">
          <div class="bar" style="width: <?= $diskSpacePercentage ?>%"></div>
        </div>
        <label>Dataverkeer <small class="pull-right"><?= $bandwidthUsed ?>MB / <?= $bandwidthTotal ?>MB | <?= $bandwithPercentage ?>%</small></label>
        <div class="progress">
          <div class="bar" style="width: <?= $bandwithPercentage ?>%"></div>
        </div>
      </div>
    </div>
    
    <div id="stats-charts" class="row-fluid visible-phone">
      <h4>Grafieken</h4>
      <div id="chart_categories_mobile" class="charts span6"></div>
      <div id="chart_locations_mobile" class="charts span6"></div>
    </div>

  </div> <!-- /container -->
  
  <div id="fixed-bg-bottom"></div>

  <!-- Load libs -->
  <script src="http://code.jquery.com/jquery-latest.js"></script>
  <script>window.jQuery || document.write('<script src="<?=base_url('assets/javascript/jquery/jquery-1.9.0.min.js'); ?>">\x3C/script>');</script>
  <script src="<?=base_url(); ?>assets/third_party/bootstrap/js/bootstrap.min.js"></script>
  <script src="<?=base_url(); ?>assets/javascript/jquery/libs/jquery.html5form.js"></script>
  <script type="text/javascript" src="https://www.google.com/jsapi"></script>
  <script src="<?=base_url(); ?>assets/javascript/admin.js"></script>
  <!-- /Load libs -->
  
  <!-- Scripts -->
  <script type="text/javascript">
    google.load("visualization", "1", {packages:["corechart"]});
    function drawChartCategories(){
      var data = google.visualization.arrayToDataTable([
        ['Categorie', 'Aantal locaties'],
        <?php
          foreach($category_chart as $category){
            echo "['" . $category['name'] . "', " . $category['num'] . "],";
          }
        ?>
      ]);

      var options = {
        title: "Locaties per categorie (Top 5)",
        legend: {position: 'none'}
      };

      var chart = new google.visualization.PieChart(document.getElementById('chart_categories'));
      var chart_mobile = new google.visualization.PieChart(document.getElementById('chart_categories_mobile'));
      chart.draw(data, options);
      chart_mobile.draw(data, options);
    }
    function drawChartLocations(){
      var data = google.visualization.arrayToDataTable([
        ['Locaties', 'Aantal foto\'s'],
        <?php
          foreach($category_chart as $category){
            echo "['" . $category['name'] . "', " . $category['num'] . "],";
          }
        ?>
      ]);

      var options = {
        title: "Populairste Locaties (Top 5)",
        legend: {position: 'none'}
      };

      var chart = new google.visualization.PieChart(document.getElementById('chart_locations'));
      var chart_mobile = new google.visualization.PieChart(document.getElementById('chart_locations_mobile'));
      chart.draw(data, options);
      chart_mobile.draw(data, options);
    }
    
    $(window).resize(function() {
      drawChartCategories();
      drawChartLocations();
    });
    $(window).load(function() {
      drawChartCategories();
      drawChartLocations();
    });
    
  </script>
  <!-- /Scripts -->
</body>
</html>