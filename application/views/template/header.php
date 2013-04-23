<!doctype html>
<!-- [if (gt IE 9)|!(IE)]><!--><html dir="ltr" lang="nl-be" class="no-js" prefix="og: http://ogp.me/ns#"><!--<![endif]-->
<head>
	<!-- CHARACTER ENCODING -->
	<meta charset="UTF-8">
	<!-- LATEST VERSION OF RENDERING ENGINE -->
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<!-- MOST IMPORTANT SEO FRIENDLY TAG -->
	<title>tagmosphere | User</title>
	<!-- OTHER IMPORTANT SEO TAGS -->
	<meta name="description" content="Een nieuwe en unieke manier om jouw leven en dat van vele andere in te kleuren. Wij noemen het tagmosphere. Registreer je nu en bouw mee aan een wereld waar alles draait om tags, sfeer en gevoel!">
	<meta name="keywords" content="tagmosphere, tags, sfeer, atmoshere, locatie, foto's, wall, check-in">
	<meta name="author" content="2MMP | 2CMO">
	<meta name="copyright" content="Copyright &copy; 2012 | Arteveldehogeschool | Gent en ik?. All rights reserved">
	<!-- OPEN GRAPH -->
	<meta property="og:title" content="tagmosphere">
	<meta property="og:type" content="website">
	<meta property="og:url" content="tagmosphere.be">
	<meta property="og:image" content="">
	<meta property="og:description" content="Een nieuwe en unieke manier om jouw leven en dat van vele andere in te kleuren. Wij noemen het tagmosphere. Registreer je nu en bouw mee aan een wereld waar alles draait om tags, sfeer en gevoel!">
	<meta property="og:site_name" content="tagmosphere">
	<meta property="fb:admins" content="">
	<!-- MOBILE VIEWPORT -->
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- LINK MY OWN STYLESHEET -->
	<link rel="stylesheet" href="<?= base_url(); ?>assets/css/<?= $page; ?>.css">
	<!--FAVICON -->
  <link rel="shortcut icon" href="<?= base_url(); ?>assets/images/template/favicon.ico">
	<!-- MODERNIZR: NEW HTML5 ELEMENTS + FEATURE DETECTION -->
	<script src="<?= base_url(); ?>assets/javascript/libs/modernizr.custom.min.js"></script>
</head>
<body>
  <div id="page-wrapper">
		<div id="header-wrapper">
			<header id="header" class="row clearfix">
				<hgroup>
					<h1><a href=""><span>tagmosphere</span></a></h1>
				</hgroup>
				<nav id="courtesy" class="columns cols-12">
					<ul>
						<li class="nav-small"><a href="<?= site_url('home'); ?>">Home</a></li>
						<li class="nav-small"><a href="<?= site_url('credits'); ?>">Credits</a></li>
            <?php if(empty($access)){ ?>
              <li><a href="<?= site_url('user/authentication'); ?>">Aanmelden</a></li>
              <li>|</li>
              <li class="last"><a href="<?= site_url('user/authentication'); ?>">Registreren<a></li>
            <?php }else{ ?>
              <li>Welkom, <?= $firstName; ?> <?= $lastName; ?></li>
            <?php } ?>
					</ul>
				</nav>
			</header>
      <?php
        if(!empty($access)){
      ?>
        <section id="navigation" class="row clearfix">
          <nav id="menu" class="columns cols-12">
            <ul>
              <li><a href="<?= site_url('wall'); ?>">Wall</a></li>
              <li><a href="<?= site_url('photo'); ?>">Check-in</a></li>
              <li class="last"><a href="<?= site_url('user/logout'); ?>">Log uit</a></li>
            </ul>
          </nav>
        </section>
      <?php
        }
      ?>
		</div>