		<div id="content-wrapper" class="photo">
			<section id="content-banner" class="row clearfix">
				<form action="<?= site_url('wall/search'); ?>" method="post" class="columns cols-6">
          <input id="location-search" name="location-search" type="text" class="search clearfix" placeholder="search locations...">
          <input type="button" class="send" value="&nbsp;">
        </form>
				<section id="walkthrough" class="columns cols-6">
					<ul>
						<li class="first">quick walkthrough</li>
						<li class="take"><a href="index.html"></a></li>
						<li class="atmosphere"><a href=""></a></li>
						<li class="location"><a href=""></a></li>
						<li class="tag"><a href=""></a></li>
						<li class="wall last"><a href=""></a></li>
					</ul>
				</section>
			</section>
      
      <!-- STEP 1 (Photo) -->
			<section id="view-step1" class="row clearfix view">
				<section class="checkin columns cols-10">
					<section id="wheel">
						<h3>1. Maak een foto</h3>
                                                <button class="button" id="btnTakePicture" onclick="takePicture();">Klik!</button>
                                                <br/>
                                                <div id="webcam"></div>
                                                <div id="showAfterStep1">
                                                    <button class="button" id="btnResetPicture" onclick="initCamera();">Opnieuw!</button>
                                                    <button class="button" onclick="goToStep(2);">Volgende stap</button>
                                                  <div id='imageContainer'><img id="image" /></div>
                                                  <input type='hidden' id="base64_photo" />
                                                </div>
					</section>
				</section>
				<section class="help columns cols-2 last-col">
                                        <section class="taken-image">
                                                <div class="image-preview"></div>
                                        </section>
					<section id="textballoon">
						<p>Om een foto te maken moet je Flash Player toestemming geven om jouw webcam te gebruiken.</p>
					</section>
					<section class="steps">
						<ul>
							<li><a href="" class="step1"></a></li>
							<li class="bullet">•</li>
							<li><a href="" class="step2"></a></li>
							<li class="bullet">•</li>
							<li><a href="" class="step3"></a></li>
							<li class="bullet">•</li>
							<li><a href="" class="step4"></a></li>
							<li class="bullet">•</li>
							<li><a href="" class="step5"></a></li>
						</ul>
					</section>
				</section>
			</section>
      <!-- /STEP 1 (Photo) -->
      
      <!-- STEP 2 (Atmosphere) -->
      <section id="view-step2" class="row clearfix view">
				<section class="checkin columns cols-10">
                                        <h3>2. Kies een sfeer</h3>
                                        <button class="button" id="btnSphere" onclick="goToStep(3);">Volgende stap</button>
					<section id="atmosphere-wheel"></section>
				</section>
				<section class="help columns cols-2 last-col">
                                        <section class="sphere">
						<figure>
							<img src="" alt="" />
							<p></p>
						</figure>
					</section>
                                        <section class="taken-image">
                                                <div class="image-preview"></div>
                                        </section>
					
					<section class="steps">
						<ul>
							<li><a href="" class="step1"></a></li>
							<li class="bullet">•</li>
							<li><a href="" class="step2"></a></li>
							<li class="bullet">•</li>
							<li><a href="" class="step3"></a></li>
							<li class="bullet">•</li>
							<li><a href="" class="step4"></a></li>
							<li class="bullet">•</li>
							<li><a href="" class="step5"></a></li>
						</ul>
					</section>
				</section>
			</section>
      <!-- /STEP 2 (Atmosphere) -->
      
      <!-- STEP 3 (Location) -->
      <section id="view-step3" class="row clearfix view">
				<section class="checkin columns cols-10">
					<h3>3. Locaties</h3>
					<section id="googlemaps">
                                <div id="map_canvas"></div>
					</section>
					<section id="plaatsen">
						<h4>Dichtbij:</h4>
						<table id="locations_nearby">
						</table>
					</section>
				</section>
				<section class="help columns cols-2 last-col">
                                        <section class="location-preview">
						<p><strong>Locatie: </strong><br />&nbsp;</p>
					</section>
					<section class="sphere">
						<figure>
							<img src="<?= base_url(); ?>assets/images/template/happy.png" alt="Smiley" />
							<p>happy</p>
						</figure>
					</section>
                                        <section class="taken-image">
                                                <div class="image-preview"></div>
                                        </section>
					<section class="steps">
						<ul>
							<li><a href="" class="step1"></a></li>
							<li class="bullet">•</li>
							<li><a href="" class="step2"></a></li>
							<li class="bullet">•</li>
							<li><a href="" class="step3"></a></li>
							<li class="bullet">•</li>
							<li><a href="" class="step4"></a></li>
							<li class="bullet">•</li>
							<li><a href="" class="step5"></a></li>
						</ul>
					</section>
				</section>
			</section>
      <!-- /STEP 3 (Location) -->
      
      <!-- STEP 4 (Tags) -->
      <section id="view-step4" class="row clearfix view">
				<section class="checkin columns cols-10">
					<section id="tags">
						<h4>voeg tag(s) toe</h4>
                                                <form id="addTagForm">
                                                  <input id="newTagField" type="text" class="tagszoeken" value="" maxlength='15'>
                                                  <input type="submit" id="addTag" class="button" name="voegtoe" value="Tag toevoegen">
                                                </form>
						<ul id="tags-list">
						</ul>
                                                <button class="button" id="location_next_step" onclick="goToStep(5);">Volgende stap</button>
					</section>
                                        
				</section>
				<section class="help columns cols-2 last-col">
					<section class="tags-small" class="clearfix">
						<ul>
						</ul>
					</section>
                                        <section class="location-preview">
						<p><strong>Locatie: </strong><br />&nbsp;</p>
					</section>
                                        <section class="sphere">
						<figure>
							<img src="<?= base_url(); ?>assets/images/template/happy.png" alt="Smiley" />
							<p>happy</p>
						</figure>
					</section>
                                        <section class="taken-image">
                                                <div class="image-preview"></div>
                                        </section>
					<section class="steps">
						<ul>
							<li><a href="" class="step1"></a></li>
							<li class="bullet">•</li>
							<li><a href="" class="step2"></a></li>
							<li class="bullet">•</li>
							<li><a href="" class="step3"></a></li>
							<li class="bullet">•</li>
							<li><a href="" class="step4"></a></li>
							<li class="bullet">•</li>
							<li><a href="" class="step5"></a></li>
						</ul>
					</section>
				</section>
			</section>
      <!-- /STEP 4 (Tags) -->
      
      <!-- STEP 5 (Publish) -->
                        <section id="view-step5" class="row clearfix view">
				<section class="checkin columns cols-12">
                                <h4>Publish!</h4>
                                        
                                        <section class="taken-image">
                                                <div class="image-preview"></div>
                                        </section>
                                        <p class="bullet">•</p>
                                        <section class="sphere">
						<figure>
							<img src="<?= base_url(); ?>assets/images/template/happy.png" alt="Smiley" />
							<p>happy</p>
						</figure>
					</section>
                                        <p class="bullet">•</p>
                                        <section class="location-preview">
						<p><strong>Locatie: </strong><br />&nbsp;</p>
					</section>
                                        <p class="bullet">•</p>
					<section class="tags-small" class="clearfix">
						<ul>
						</ul>
					</section>
                                        <p class="bullet">•</p>
                                        <input type="submit" id="publish-btn" class="button" name="publish" value="Publish" onclick="publish()">
                                </section>
			</section>
      <!-- /STEP 5 (Publish) -->
		</div>