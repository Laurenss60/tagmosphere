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
            <li><a href="<?= site_url('admin/dashboard'); ?>">Dashboard</a></li>
            <li><a href="<?= site_url('admin/users'); ?>">Gebruikers</a></li>
            <li class="active"><a href="<?= site_url('admin/locations'); ?>">Locaties</a></li>
            <li><a href="<?= site_url('admin/categories'); ?>">Categoriëen</a></li>
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
  
  <div id="page-nav">
    <h4 class="visible-phone">Locatie toevoegen</h4>
    <div class="navbar">
      <div class="navbar-inner">
        <a class="brand hidden-phone" href="<?= site_url('admin/locations'); ?>">Locaties</a>
        <ul class="nav">
          <li>
            <a href="<?= site_url('admin/locations'); ?>">
              <i class="icon-list"></i><span class="hidden-phone">&nbsp;Lijst</span>
            </a>
          </li>
          <li class="active">
            <a href="<?= site_url('admin/locations/create'); ?>">
              <i class="icon-plus-sign"></i><span class="hidden-phone">&nbsp;Locatie toevoegen</span>
            </a>
          </li>
        </ul>
        <form class="hidden-phone navbar-search pull-right">
          <input type="text" class="search-query" placeholder="Search">
        </form>
        <ul class="nav visible-phone pull-right">
          <li>
            <a href="#searchForm" role="button" data-toggle="modal">
              <i class="icon-search"></i>
            </a>
          </li>
        </ul>
      </div>
    </div>
  </div>

  <!-- container -->
  <div class="container">
    
    <div><?= $serverAlert; ?></div>
    
    <div class="row-fluid">
      
      <!-- Table -->
      <div class="span4">
        <form action="<?= site_url('admin/locations/create'); ?>" method="post">
          <fieldset>
            <legend>Nieuwe locatie</legend>
            <?php echo form_error('locationName', '<span class="help-inline error-text">', '</span>'); ?>
            <input id='locationName' type="text" name="locationName" placeholder="Locatie naam" required maxlength="32" />
            <?php echo form_error('category', '<span class="help-inline error-text">', '</span>'); ?>
            <select id='category' name="category">
              <option disabled="disabled">Categorie</option>
              <?php
                foreach($categories as $category){
                  echo '<option value="' . $category->getId() . '">' . $category->getName() . '</option>';
                }
              ?>
            </select>
          </fieldset>
          <hr/>
          <fieldset>
            <label>
              <span class="pull-left">Duid aan op de kaart:&nbsp;</span>
              <a class="visible-phone pull-left" href="#mobileMap" role="button" data-toggle="modal" onClick="showMobileMap();">
                <i class="icon-map-marker"></i>
              </a>
            </label>
            <p class="clearfix">&nbsp;</p>
            <?php echo form_error('lat', '<span class="help-inline error-text">', '</span>'); ?>
            <input id='lat_dis' type="text" name="lat" placeholder="Latitude" required maxlength="10" disabled="disabled" />
            <input type="hidden" name="lat" id="lat" />
            <?php echo form_error('lng', '<span class="help-inline error-text">', '</span>'); ?>
            <input id='lng_dis' type="text" name="lng" placeholder="Longitude" required maxlength="10" disabled="disabled" />
            <input type="hidden" name="lng" id="lng" />
          </fieldset>
          <hr/>
          <fieldset>
            <button type="submit" class="btn">Submit</button>
          </fieldset>
        </form>
      </div>
      <!-- /Table -->
      
      <!-- Maps -->
      <div id="maps-container" class="span8 well well-small hidden-phone" style="height: 400px;">
        <div id="map_canvas" style="height: 100%"></div>
      </div>
      <!-- /Maps -->
      
    </div>
    
  </div> 
  <!-- /container -->
  
  <div id="fixed-bg-bottom"></div>

  <!-- (Modal) Mobile search -->
  <div id="searchForm" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="searchFormLabel" aria-hidden="true">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      <h4 id="searchFormLabel">Zoeken</h4>
    </div>
    <div class="modal-body">
      <form id="searchForm_Form" action="<?= site_url('admin/locations/search'); ?>" method="post">
        <label for="searchMobile">Zoekterm:</label>
        <input id="searchMobile" name="search" type="text" required maxlength="32" />
      </form>
    </div>
    <div class="modal-footer">
      <button class="btn" data-dismiss="modal" aria-hidden="true">Annuleren</button>
      <button class="btn btn-primary" onClick="$('#searchForm_Form').submit();">Zoeken</button>
    </div>
  </div>
  <!-- /(Modal) Mobile search -->
  
  <!-- (Modal) Mobile map -->
  <div id="mobileMap" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="mobileMapLabel" aria-hidden="true">
    <div class="modal-body">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icon-remove-sign"></i></button>
      <div id="maps-container-mobile" class="span8 well well-small">
        <div id="map_canvas-mobile" style="height: 100%"></div>
      </div>
    </div>
  </div>
  <!-- /(Modal) Mobile map -->
  
  <!-- Load libs -->
  <script src="http://code.jquery.com/jquery-latest.js"></script>
  <script>window.jQuery || document.write('<script src="<?=base_url('assets/javascript/jquery/jquery-1.9.0.min.js'); ?>">\x3C/script>');</script>
  <script src="<?=base_url(); ?>assets/third_party/bootstrap/js/bootstrap.min.js"></script>
  <script src="<?=base_url(); ?>assets/javascript/jquery/libs/jquery.html5form.js"></script>
  <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
  <script src="<?=base_url(); ?>assets/javascript/admin.js"></script>
  <!-- /Load libs -->
  
  <!-- Scripts -->
  <script type="text/javascript">
    var map_desktop;
    var map_mobile;
    var markersArray = [];
    var myOptions = {
        zoom: 15,
        center: new google.maps.LatLng(51.04758721, 3.73072105),
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    map_desktop = new google.maps.Map(document.getElementById("map_canvas"),  myOptions);
    google.maps.event.addListener(map_desktop, "click", function (e){ 
      plotPoint(map_desktop, e.latLng.lat().toFixed(7), e.latLng.lng().toFixed(7));
      $("#lat").val(e.latLng.lat().toFixed(7));
      $("#lng").val(e.latLng.lng().toFixed(7));
      $("#lat_dis").val(e.latLng.lat().toFixed(7));
      $("#lng_dis").val(e.latLng.lng().toFixed(7));
    }); 
    google.maps.Map.prototype.clearOverlays = function(){
      for (var i = 0; i < markersArray.length; i++ ){
        markersArray[i].setMap(null);
      }
    };

    function plotPoint(map, srcLat,srcLng,title,popUpContent,markerIcon){
      map.clearOverlays();
      var myLatlng = new google.maps.LatLng(srcLat, srcLng);            
      var marker = new google.maps.Marker({
            position: myLatlng, 
            map: map, 
            title:title,
            icon: markerIcon
      });
      markersArray.push(marker);
      var infowindow = new google.maps.InfoWindow({
          content: popUpContent
      });
      google.maps.event.addListener(map, marker, 'click', function() {
        infowindow.open(map,marker);
      });                                          
      panToPoint(map, srcLat, srcLng);
    }
    function panToPoint(map, srcLat, srcLng){
      map.panTo(new google.maps.LatLng(srcLat, srcLng));
    }
    function showMobileMap(){
      $("#mobileMap").show();
      map_mobile = new google.maps.Map(document.getElementById("map_canvas-mobile"), myOptions);
      google.maps.event.addListener(map_mobile, "click", function (e){ 
      plotPoint(map_mobile, e.latLng.lat().toFixed(7), e.latLng.lng().toFixed(7));
      $("#lat").val(e.latLng.lat().toFixed(7));
      $("#lng").val(e.latLng.lng().toFixed(7));
      $("#lat_dis").val(e.latLng.lat().toFixed(7));
      $("#lng_dis").val(e.latLng.lng().toFixed(7));
    }); 
    }
    
  </script>
  <!-- /Scripts -->
</body>
</html>