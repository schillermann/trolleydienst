<h2>Installation</h2>
<div class="container-center">
    <?php if (isset($placeholder['message']['error'])) : ?>
        <div id="note-box" class="fade-in">
            <p class="error">
                <?php echo $placeholder['message']['error']; ?>
            </p>
            <button type="button" onclick="closeNoteBox()">
                <i class="fa fa-times"></i> schliessen
            </button>
        </div>
    <?php endif;?>
    <form method="post">
        <fieldset>
            <legend>Admin</legend>
            <div>
                <label for="name">Name <small>(Pflichtfeld)</small></label>
                <input id="name" name="name" tabindex="1" required oninput="insertUsername()" value="<?php echo (isset($_POST['name']))? $_POST['name'] : '';?>">
            </div>
            <div>
                <label for="email">E-Mail <small>(Pflichtfeld)</small></label>
                <input id="email" name="email" tabindex="2" required oninput="insertEmail(this)" value="<?php echo (isset($_POST['email']))? $_POST['email'] : '';?>">
            </div>
            <div>
                <label for="password">Passwort</label>
                <input id="password" type="password" name="password" tabindex="3">
            </div>
            <div>
                <label for="password_repeat">Passwort (wiederholen)</label>
                <input id="password_repeat" type="password" name="password_repeat" tabindex="4">
            </div>
        </fieldset>
        <fieldset>
            <legend>Einstellungen</legend>
            <div>
                <label for="email_address_from">E-Mail Server Absender Adresse <small>(Pflichtfeld)</small></label>
                <input id="email_address_from" name="email_address_from" tabindex="5" required placeholder="absender@email.de" value="<?php echo (isset($_POST['email_address_from']))? $_POST['email_address_from'] : '';?>">
            </div>
            <div>
                <label for="email_address_reply">E-Mail Antwort Adresse <small>(Pflichtfeld)</small></label>
                <input id="email_address_reply" name="email_address_reply" tabindex="6" required placeholder="antwort@email.de" value="<?php echo (isset($_POST['email_address_reply']))? $_POST['email_address_reply'] : '';?>">
            </div>
            <div>
                <label for="application_name">Name der Anwendung <small>(Pflichtfeld)</small></label>
                <input id="application_name" name="application_name" tabindex="7" required value="<?php echo (isset($_POST['application_name']))? $_POST['application_name'] : 'Öffentliches Zeugnisgeben';?>">
            </div>
            <div>
                <label for="team_name">Team Name <small>(Pflichtfeld)</small></label>
                <input id="team_name" name="team_name" tabindex="8" required value="<?php echo (isset($_POST['application_name']))? $_POST['application_name'] : 'Trolley Team';?>">
            </div>
            <div>
                <label for="congregation_name">Name der Versammlung <small>(Pflichtfeld)</small></label>
                <input id="congregation_name" name="congregation_name" tabindex="9" required placeholder="Muster Versammlung" value="<?php echo (isset($_POST['congregation_name']))? $_POST['congregation_name'] : '';?>">
            </div>
        </fieldset>
        <div class="from-button">
            <button name="install" class="active" tabindex="10">
                <i class="fa fa-download"></i> installieren
            </button>
        </div>
    </form>
</div>
<script>
    let emailAddressFrom = document.getElementById('email_address_from');
    let emailAddressReply = document.getElementById('email_address_reply');

    function insertEmail(email) {
        emailAddressFrom.value = email.value;
        emailAddressReply.value = email.value;
    }

</script>