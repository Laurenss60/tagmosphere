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
  
  <div  id="top-nav" class="navbar navbar-inverse navbar-fixed-top">
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
            <li><a href="<?= site_url('admin/locations'); ?>">Locaties</a></li>
            <li class="active"><a href="<?= site_url('admin/categories'); ?>">Categori&euml;en</a></li>
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
    <h4 class="visible-phone">Categori&euml;en</h4>
    <div class="navbar-inner">
      <a class="brand hidden-phone" href="<?= site_url('admin/categories'); ?>">Categori&euml;en</a>
      <ul class="nav">
        <li class="active">
          <a href="<?= site_url('admin/categories'); ?>">
            <i class="icon-list"></i><span class="hidden-phone">&nbsp;Lijst</span>
          </a>
        </li>
        <li>
          <a href="#createForm" role="button" data-toggle="modal">
            <i class="icon-plus-sign"></i><span class="hidden-phone">&nbsp;Categorie toevoegen</span>
          </a>
        </li>
      </ul>
      <form action="<?= site_url('admin/categories/search'); ?>" method="post" class="hidden-phone navbar-search pull-right">
        <input name="search" type="text" class="search-query" placeholder="Search">
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

  <!-- container -->
  <div class="container">
    
    <div><?= $serverAlert ?></div>
    
    <table class="table table-bordered table-striped">
      <tr><th>Categorie naam</th><th>Verwijderen</th></tr>
      <?php foreach($categories as $category){ ?>
        <tr>
          <td><?= $category->getName(); ?></td>
          <td>
            <a class="confirm-delete" href="#" data-url="<?= site_url('admin/categories/delete/' . $category->getId()); ?>"><i class="icon-remove-circle"></i></a>
          </td>
        </tr>
      <?php } ?>
    </table>
    
  </div> 
  <!-- /container -->
  
  <div id="fixed-bg-bottom"></div>
  
  <!-- (Modal) Create new catergory -->
  <div id="createForm" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="createFormLabel" aria-hidden="true">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      <h4 id="createFormLabel">Categorie toevoegen</h4>
    </div>
    <div class="modal-body">
      <form id="createForm_Form" action="<?= site_url('admin/categories/create'); ?>" method="post">
        <label for="categoryName">Categorie naam:</label>
        <input id="categoryName" name="categoryName" type="text" required maxlength="32" />
      </form>
    </div>
    <div class="modal-footer">
      <button class="btn" data-dismiss="modal" aria-hidden="true">Annuleren</button>
      <button class="btn btn-primary" onClick="$('#createForm_Form').submit();">Aanmaken</button>
    </div>
  </div>
  <!-- /(Modal) Create new category -->
  
  <!-- (Modal) Mobile search -->
  <div id="searchForm" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="searchFormLabel" aria-hidden="true">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      <h4 id="searchFormLabel">Zoeken</h4>
    </div>
    <div class="modal-body">
      <form id="searchForm_Form" action="<?= site_url('admin/categories/search'); ?>" method="post">
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
      <h3>Categorie verwijderen</h3>
    </div>
    <div class="modal-body">
      <p>Ben je zeker dat je deze categorie wilt verwijderen?</p>
      <p>Let op: Alle foto's, locaties en datasets verbonden aan deze categorie worden ook verwijderd!</p>
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
  <script src="<?=base_url(); ?>assets/javascript/admin.js"></script>
  <!-- /Load libs -->
  
  <!-- Scripts -->
  <script type="text/javascript">
    /* Confirm delete */
    $(document).ready(function(){ 
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