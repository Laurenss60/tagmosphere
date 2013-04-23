  <div id="content-wrapper" class="authentication">
    <section id="content-banner" class="row clearfix">
      <section id="walkthrough" class="columns cols-12">
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
      <section id="login" class="columns cols-6 first-col">
        <h3>Aanmelden</h3>
        <p>Log in met facebook of vul hieronder uw gegevens in.</p>
        <p><strong>Let op:</strong> Als dit de eerste keer is dat je inlogt met facebook moet je toestemming geven en dan worden 
            uw gegevens automatisch ingevuld in het registratie gedeelte hiernaast. </p>
        <?=facebookLoginButton();?>
        <?php if($action == 'login'){ echo validation_errors(); } ?>
        <form action="<?= site_url('user/authentication'); ?>" method="post" >
          <fieldset>
            <label for="login_username">Gebruiker:</label>
            <input id="username" type="text" name="username" placeholder="e.g. John.Doe" required maxlength="16"><br />
            <label for="login_password">Paswoord:</label>
            <input id="login_password" type="password" name="password" placeholder="e.g. 123456" required maxlength="32">
          </fieldset>
            <input type="hidden" name="action" value="login" />
            <input type="submit" class="button" name="login" value="Aanmelden">
        </form>
        <h3>Na het aanmelden</h3>
        <p>Wordt deel van de tagmosphere en bouw mee aan een wereld met meer gevoel, klik op <strong>Check-in</strong> om aan het avontuur te beginnen! </p>
      </section>
      <section id="registration" class="columns cols-6 last-col">
        <section id="registration-content">
        <h3>Registratie</h3>
        <?php if($action == 'register'){ echo $serverAlert; echo validation_errors(); } ?>
        <form action="<?= site_url('user/authentication'); ?>" method="post">
          <fieldset>
            <label for="register_firstName">Voornaam:</label>
            <input id="register_firstName" type="text" name="first_name" placeholder="e.g. John" value="<?= $firstName; ?>" required maxlength="64">
            <label for="register_lastName">Familienaam:</label>
            <input id="register_lastName" type="text" name="last_name" placeholder="e.g. Doe" value="<?= $lastName; ?>" required maxlength='64'>
            <label for="register_email">Email:</label>
            <input id="register_email" type="email" name="email" placeholder="e.g. john.doe@email.com" value="<?= $email; ?>" required maxlength="128">
          </fieldset>
          <fieldset>
            <label for="register_username">Gebruiker:</label>
            <input id="register_username" type="text" name="username" placeholder="e.g. John.Doe" value="<?= $username; ?>" required maxlength="16">
            <label for="register_password">Wachtwoord:</label>
            <input id="register_password" type="password" name="password" placeholder="e.g. 123456" required>
            <label for="register_repeat_password" class="herhaal">Herhaal wachtwoord:</label>
            <input id="register_repeat_password" type="password" name="repeat_password" placeholder="e.g. 123456" required>
            <!-- Facebook id (hidden) -->
            <input type="hidden" name="fb_id" value="<?= $fb_id; ?>" />
          </fieldset>
            <input type="hidden" name="action" value="register" />
            <input type="submit" class="button" name="register" value="Registreer"> of <div id="fblogin"><?=facebookLoginButton();?></div>
        </form>
        </section>
      </section>
    </section>
  </div>