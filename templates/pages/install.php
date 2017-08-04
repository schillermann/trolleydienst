<h2>Installation</h2>
<div class="container-center">
    <?php if (isset($placeholder['message']['error'])) : ?>
        <div id="note-box">
            <p class="error">
                <?php echo $placeholder['message']['error']; ?>
            </p>
        </div>
    <?php endif;?>
    <form method="post">
        <fieldset>
            <legend>Admin</legend>
            <div>
                <label for="firstname">Vorname <small>(Pflichtfeld)</small></label>
                <input id="firstname" type="text" name="firstname" tabindex="1" required oninput="insertUsername()" value="<?php echo (isset($_POST['firstname']))? $_POST['firstname'] : '';?>">
            </div>
            <div>
                <label for="lastname">Nachname <small>(Pflichtfeld)</small></label>
                <input id="lastname" type="text" name="lastname" tabindex="2" required oninput="insertUsername()" value="<?php echo (isset($_POST['lastname']))? $_POST['lastname'] : '';?>">
            </div>
            <div>
                <label for="email">E-Mail <small>(Pflichtfeld)</small></label>
                <input id="email" type="text" name="email" tabindex="3" required oninput="insertEmail(this)" value="<?php echo (isset($_POST['email']))? $_POST['email'] : '';?>">
            </div>
            <div>
                <label for="username">Benutzername <small>(Pflichtfeld)</small></label>
                <input id="username" type="text" name="username" tabindex="4" required value="<?php echo (isset($_POST['username']))? $_POST['username'] : '';?>">
            </div>
            <div>
                <label for="password">Passwort</label>
                <input id="password" type="password" name="password" tabindex="5">
            </div>
            <div>
                <label for="password_repeat">Passwort (wiederholen)</label>
                <input id="password_repeat" type="password" name="password_repeat" tabindex="6">
            </div>
        </fieldset>
        <fieldset>
            <legend>Einstellungen</legend>
            <div>
                <label for="email_address_from">E-Mail Server Absender Adresse <small>(Pflichtfeld)</small></label>
                <input id="email_address_from" type="text" name="email_address_from" tabindex="7" required placeholder="absender@email.de" value="<?php echo (isset($_POST['email_address_from']))? $_POST['email_address_from'] : '';?>">
            </div>
            <div>
                <label for="email_address_reply">E-Mail Antwort Adresse <small>(Pflichtfeld)</small></label>
                <input id="email_address_reply" type="text" name="email_address_reply" tabindex="8" required placeholder="antwort@email.de" value="<?php echo (isset($_POST['email_address_reply']))? $_POST['email_address_reply'] : '';?>">
            </div>
            <div>
                <label for="application_name">Name der Anwendung <small>(Pflichtfeld)</small></label>
                <input id="application_name" type="text" name="application_name" tabindex="9" required value="<?php echo (isset($_POST['application_name']))? $_POST['application_name'] : 'Öffentliches Zeugnisgeben';?>">
            </div>
            <div>
                <label for="team_name">Team Name <small>(Pflichtfeld)</small></label>
                <input id="team_name" type="text" name="team_name" tabindex="10" required value="<?php echo (isset($_POST['application_name']))? $_POST['application_name'] : 'Trolley Team';?>">
            </div>
            <div>
                <label for="congregation_name">Name der Versammlung <small>(Pflichtfeld)</small></label>
                <input id="congregation_name" type="text" name="congregation_name" tabindex="11" required placeholder="Muster Versammlung" value="<?php echo (isset($_POST['congregation_name']))? $_POST['congregation_name'] : '';?>">
            </div>
        </fieldset>
        <div class="from-button">
            <button type="submit" name="install" class="active" tabindex="12">
                <i class="fa fa-download" aria-hidden="true"></i> installieren
            </button>
        </div>
    </form>
</div>
<script type="text/javascript" src="js/insert_username.js"></script>
<script>
    let emailAddressFrom = document.getElementById('email_address_from');
    let emailAddressReply = document.getElementById('email_address_reply');

    function insertEmail(email) {
        emailAddressFrom.value = email.value;
        emailAddressReply.value = email.value;
    }

</script>