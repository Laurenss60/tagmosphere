<div id="content-wrapper">
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
					<section class="wheel">
						<h3>1. Maak een foto</h3>
            <button class="btn" id="btnTakePicture" onclick="takePicture();">Klik!</button>
            <br/>
            <div id="webcam"></div>
            <div id="showAfterStep1">
              <button class="btn" id="btnResetPicture" onclick="initCamera();">Opnieuw!</button>
              <button class="button" onclick="goToStep(2);">Volgende stap</button>
              <div id='imageContainer'><img id="image" /></div>
              <input type='hidden' id="base64_photo" />
            </div>
					</section>
				</section>
				<section class="help columns cols-2 last-col">
					<section id="textballoon">
						<p>Om een foto te maken moet je Flash Player toestemming geven om jouw webcam te gebruiken.</p>
					</section>
          <section class="image-preview"></section>
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
</div>
