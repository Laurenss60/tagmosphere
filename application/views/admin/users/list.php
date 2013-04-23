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
  <link href="<?=base_url();?>assets/third_party/stacktable/stacktable.css" rel="stylesheet">
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
            <li class="active"><a href="<?= site_url('admin/users'); ?>">Gebruikers</a></li>
            <li><a href="<?= site_url('admin/locations'); ?>">Locaties</a></li>
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
  
  <div id="page-nav" class="navbar">
    <h4 class="visible-phone">Gebruikers</h4>
    <div class="navbar-inner">
      <a class="brand hidden-phone" href="<?= site_url('admin/users'); ?>">Gebruikers</a>
      <ul class="nav">
        <li class="active">
          <a href="<?= site_url('admin/users'); ?>">
            <i class="icon-list"></i><span class="hidden-phone">&nbsp;Lijst</span>
          </a>
        </li>
      </ul>
      <form action="<?= site_url('admin/users/search'); ?>" method="post" class="hidden-phone navbar-search pull-right">
        <input type="text" name="search" class="search-query" placeholder="Zoeken">
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

  <div class="container">
    
    <?= $serverAlert ?>
    
    <div class="row-fluid">
      <div class="span12">
        <table id="users" class="table table-bordered table-striped hidden-phone hidden-tablet">
          <thead>
            <tr><th>Gebruikersnaam</th><th>Emailadres</th><th>Voornaam</th><th>Familienaam</th><th>FB-connect</th><th>Beheerder</th><th>Verwijderen</th></tr>
          </thead>
          <tbody>
            <?php foreach($users as $user){ ?>
              <tr>
                <td><?= $user->getUsername(); ?></td>
                <td><?= $user->getEmailaddress(); ?></td>
                <td><?= $user->getFirstname(); ?></td>
                <td><?= $user->getLastname(); ?></td>
                <td><?php if($user->getFacebookid()) echo 'Ja'; else echo 'nee'; ?></td>
                <td>
                  <?php if($user->getAccess() >= 2){ ?>
                    <a href="<?= site_url('admin/users/setUser/' . $user->getId()); ?>"><i class="icon-star"></i></a>
                  <?php }else{ ?>
                    <a href="<?= site_url('admin/users/setAdmin/' . $user->getId()); ?>"><i class="icon-star-empty"></i></a>
                  <?php } ?>
                </td>
                <td>
                  <a class="confirm-delete" href="#" data-url="<?= site_url('admin/users/delete/' . $user->getId()); ?>"><i class="icon-remove-circle"></i></a>
                </td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
    
  </div> <!-- /container -->
  
  <div id="fixed-bg-bottom"></div>
  
  <!-- (Modal) Mobile search -->
  <div id="searchForm" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="searchFormLabel" aria-hidden="true">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      <h4 id="searchFormLabel">Zoeken</h4>
    </div>
    <div class="modal-body">
      <form id="searchForm_Form" action="<?= site_url('admin/users/search'); ?>" method="post">
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
  
  <!-- (Modal) Delete confirmation -->
  <div id="modal-from-dom" class="modal hide fade">
    <div class="modal-header">
      <a href="javascript:$('#modal-from-dom').modal('hide')" class="close">&times;</a>
      <h3>Gebruiker verwijderen</h3>
    </div>
    <div class="modal-body">
      <p>Ben je zeker dat je deze gebruiker wilt verwijderen?</p>
      <p>Let op: Alle foto's verbonden aan deze gebruiker worden mee verwijderd!</p>
    </div>
    <div class="modal-footer">
      <a href="javascript:$('#modal-from-dom').modal('hide')" class="btn secondary">Annuleren<a>
      <a href="#" class="btn btn-danger">Verwijderen</a>
    </div>
  </div>
  <!-- /(Modal) Delete confirmation -->

  <!-- Load libs -->
  <script src="http://code.jquery.com/jquery-latest.js"></script>
  <script>window.jQuery || document.write('<script src="<?=base_url('assets/javascript/jquery/jquery-1.9.0.min.js'); ?>">\x3C/script>');</script>
  <script src="<?=base_url(); ?>assets/third_party/bootstrap/js/bootstrap.min.js"></script>
  <script src="<?=base_url(); ?>assets/javascript/jquery/libs/jquery.html5form.js"></script>
  <script src="<?=base_url(); ?>assets/third_party/stacktable/stacktable.js"></script>
  <script src="<?=base_url(); ?>assets/javascript/admin.js"></script>
  <!-- /Load libs -->
  
  <!-- Scripts -->
  <script type="text/javascript">
    /* Confirm delete */
    $(document).ready(function(){ 
      $("#users").stacktable({myClass: "stacktable-6 stacktable-hide-desktop"});
      $('#modal-from-dom').bind('show', function() {
        console.log($(this).data('url'));
        var url = $(this).data('url'),
          removeBtn = $(this).find('.btn-danger'),
          href = removeBtn.attr('href');

        removeBtn.attr('href', url);
      });
      $('.confirm-delete').click(function(e) {
        e.preventDefault();

        var url = $(this).data('url');
        $('#modal-from-dom').data('url', url).modal('show');
      });
    });
    /* /Confirm delete */
  </script>
  <!-- /Scripts -->
</body>
</html>