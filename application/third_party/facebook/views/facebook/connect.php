<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Tagmosphere</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="<?=base_url();?>application/third_party/Bootstrap/css/bootstrap.css" rel="stylesheet">
	<link href="<?=base_url();?>application/third_party/Bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
</head>
<body>
  <div class="container">
    <img src="<?=base_url(); ?>assets/images/facebookconnect.png" id="facebook" style="cursor:pointer;float:left;margin-left:550px;" />
  </div>

  <!-- Load libs -->
  <script src="http://code.jquery.com/jquery-latest.js"></script>
  <script>window.jQuery || document.write('<script src="<?=base_url('assets/javascript/jquery/jquery-1.9.0.min.js'); ?>">\x3C/script>')</script>
  <script src="<?=base_url(); ?>assets/bootstrap/js/bootstrap.min.js"></script>
  <script src="<?=base_url(); ?>assets/javascript/jquery/libs/jquery.html5form.js"></script>
  <script src="<?=base_url(); ?>assets/javascript/jquery/libs/jquery.oauthpopup.js"></script>
  <!-- /Load libs -->
  
  <!-- Scripts -->
  <script type="text/javascript">
    $(document).ready(function(){
      $('#facebook').click(function(e){
        $.oauthpopup({
          path: '<?= site_url('user/facebook/login'); ?>',
          width:600,
          height:300,
          callback: function(){
            window.location.reload();
          }
        });
        e.preventDefault();
      });
    });
  </script>
  <!-- /Scripts -->
</body>
</html>