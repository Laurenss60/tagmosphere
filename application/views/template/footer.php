  <div id="footer-wrapper" class="row clearfix">
    <footer id="footer" class="columns cols-12">
      <p>Tagmosphere is een project in opdracht van Artevelde Hogeschool &copy; 2012-2013</p>
    </footer>
  </div>
</div>
<!-- BOTTOM SCRIPTS -->
	<!-- 1. GRAB GOOGLE'S JQUERY CDN -->
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
	<!-- 2. FALLBACK TO LOCAL JQUERY IF CDN NOT ACTIVE -->
	<script>window.jQuery || document.write('<script src="_scripts/libs/jquery-1.8.3.min.js"><\/script>')</script>
  <!-- 3. OTHER LIBS -->
	<!-- 4. MY OWN SCRIPTS -->
  <?php if($page == 'authentication'){ echo facebookLoginScript(); } ?>
  <?php if($page == 'photo'){ ?>
    <script src="<?=base_url(); ?>assets/javascript/photo.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/swfobject/2.2/swfobject.js"></script>
    <script src="<?=base_url(); ?>assets/third_party/scriptcam/scriptcam.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
  <?php } ?>
    
  <?php if($access > 0){ ?>
    <script src="<?=base_url(); ?>assets/javascript/jquery/libs/jquery.autocomplete.min.js"></script>
    <script src="<?=base_url(); ?>assets/javascript/locationSearch.js"></script>
  <?php } ?>
	<!--<script src="_scripts/index.js"></script>-->
</body>
</html>