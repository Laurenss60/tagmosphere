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
      <section id="content" class="row clearfix">
        <section id="wall-wrapper" class="columns cols-12">
          <h3>Wall</h3>
          <section id="wall-top" class="row clearfix">
            <section id="wall-choise" class="columns cols-6">
              <ul>
                <li><a href="<?= site_url('wall'); ?>">Publiek</a></li>
                <li><a href="<?= site_url('wall/wall/personal'); ?>">Persoonlijk</a></li>
              </ul>
            </section>
            <section id="fullscreen" class="columns cols-6 last-col">
              <a href="">Open fullscreen <img src="<?= base_url(); ?>assets/images/template/fullscreen.png" alt="Open fullscreen" /></a>
            </section>
          </section>
          <section id="wall" class="row clearfix">
            <?php 
              if(empty($photos)){
                echo '<p>Er werden geen foto\'s gevonden</p>';
              }else{
                foreach($photos as $photo){ 
            ?>
                <section id="wall-img" class="columns cols-2">
                  <div class="figure" style="background-image: url(data:image/png;base64,<?= $photo->getPhoto(); ?>)"></div>
                  <div class="hover-overlay">
                    <section id="top">
                      <h4><?php $location = $photo->getLocation(); echo $location->getName(); ?></h4>
                      <p><strong>Gebruiker:</strong> <?php $user = $photo->getUser(); echo $user->getUsername(); ?></p>
                      <p><strong>Datum:</strong> <?= $photo->getCreated()->format('H:i d-m-Y' ); ?></p>
                    </section>
                    <figure>
                      <img src="<?= base_url(); ?>assets/images/template/atmospheres/<?= $photo->getAtmosphere(); ?>.png" alt="Smiley" />
                      <p>
                        <?php
                          switch($photo->getAtmosphere()){
                            case ACTIEF:
                              echo 'Actief';
                              break;
                            case BLIJ:
                              echo 'Blij';
                              break;
                            case BOOS:
                              echo 'Boos';
                              break;
                            case DROMERIG:
                              echo 'Dromerig';
                              break;
                            case FEESTSTEMMING:
                              echo 'Feeststemming';
                              break;
                            case GEIRRITEERD:
                              echo 'Geirriteerd';
                              break;
                            case GEK:
                              echo 'Gek';
                              break;
                            case OPGEWONDEN:
                              echo 'Opgewonden';
                              break;
                            case ROMANTISCH:
                              echo 'Romantisch';
                              break;
                            case RUSTIG:
                              echo 'Rustig';
                              break;
                            case VERDRIETIG:
                              echo 'Verdrietig';
                              break;
                            case VERVEELD:
                              echo 'Verveeld';
                              break;
                          }
                        ?>
                      </p>
                    </figure>
                  </div>
                </section>
             <?php 
                }
              } 
             ?>
          </section>
        </section>
      </section>
    </div>