<h2>E-Mail Einstellungen</h2>
<a href="email.php" tabindex="13" class="button"><i class="fa fa-chevron-left" aria-hidden="true"></i> zurück</a>
<div class="container-center">
    <?php if (isset($placeholder['message'])) : ?>
        <div id="note-box" class="fade-in">
            <?php if (isset($placeholder['message']['success'])): ?>
                <?php foreach ($placeholder['message']['success'] as $success): ?>
                <p class="success">
                    <?php echo $success;?>
                </p>
                <?php endforeach;?>
            <?php elseif (isset($placeholder['message']['error'])): ?>
                <?php foreach ($placeholder['message']['error'] as $error): ?>
                <p class="error">
                    <?php echo $error;?>
                </p>
                <?php endforeach;?>
            <?php endif; ?>
            <button type="button" onclick="closeNoteBox()">
                <i class="fa fa-times" aria-hidden="true"></i> schliessen
            </button>
        </div>
    <?php endif; ?>
    <h3>E-Mail Platzhalter</h3>
    <form method="post">
        <fieldset>
            <legend>E-Mail Platzhalter</legend>
            <div>
                <label for="email_address_from">E-Mail Absenderadresse <small>(Pflichtfeld)</small></label>
                <input id="email_address_from" type="email" name="email_address_from" tabindex="1" required value="<?php echo $placeholder['email_address_from'];?>">
            </div>
            <div>
                <label for="email_address_reply">E-Mail Adresse für Rückmeldungen <small>(Pflichtfeld)</small></label>
                <input id="email_address_reply" type="email" name="email_address_reply" tabindex="2" required value="<?php echo $placeholder['email_address_reply'];?>">
            </div>
            <div>
                <label for="congregation_name">Name der Versammlung <small>(Pflichtfeld)</small></label>
                <input id="congregation_name" type="text" name="congregation_name" tabindex="3" required value="<?php echo $placeholder['congregation_name'];?>">
            </div>
            <div>
                <label for="application_name">Name des Programms <small>(Pflichtfeld)</small></label>
                <input id="application_name" type="text" name="application_name" tabindex="4" required value="<?php echo $placeholder['application_name'];?>">
            </div>
            <div>
                <label for="team_name">Name des Team <small>(Pflichtfeld)</small></label>
                <input id="team_name" type="text" name="team_name" tabindex="5" required value="<?php echo $placeholder['team_name'];?>">
            </div>
        </fieldset>
        <div class="from-button">
            <button type="submit" name="save_email_placeholder" class="active" tabindex="6">
                <i class="fa fa-floppy-o" aria-hidden="true"></i> speichern
            </button>
        </div>
    </form>
    <h3>E-Mail Vorlagen</h3>
    <form method="post">
        <fieldset>
            <legend>Infos</legend>
            <div>
                <label for="template_email_info_subject">Betreff <small>(Pflichtfeld)</small></label>
                <input id="template_email_info_subject" type="text" name="template_email_info_subject" class="email-subject" tabindex="7" required value="<?php echo $placeholder['template_email_info']['subject']; ?>">
            </div>
            <div>
                <label for="template_email_info_message">Nachricht <small>(Pflichtfeld)</small></label>
                <textarea id="template_email_info_message" name="template_email_info_message" tabindex="8" rows="10" required><?php echo $placeholder['template_email_info']['message'];?></textarea>
            </div>
        </fieldset>
        <fieldset>
            <legend>Passwort vergessen</legend>
            <div>
                <label for="template_email_password_forgot_subject">Betreff <small>(Pflichtfeld)</small></label>
                <input id="template_email_password_forgot_subject" type="text" name="template_email_password_forgot_subject" class="email-subject" tabindex="9" required value="<?php echo $placeholder['template_email_password_forgot']['subject']; ?>">
            </div>
            <div>
                <label for="template_email_password_forgot_message">Nachricht <small>(Pflichtfeld)</small></label>
                <textarea id="template_email_password_forgot_message" name="template_email_password_forgot_message" tabindex="10" rows="10" required><?php echo $placeholder['template_email_password_forgot']['message'];?></textarea>
            </div>
        </fieldset>
        <fieldset>
            <legend>Signatur</legend>
            <div>
                <textarea name="template_email_signature" tabindex="11" rows="10" required><?php echo $placeholder['template_email_signature']['message'];?></textarea>
            </div>
        </fieldset>
        <div class="from-button">
            <button type="submit" name="save_templates_email" class="active" tabindex="12">
                <i class="fa fa-floppy-o" aria-hidden="true"></i> speichern
            </button>
        </div>
    </form>
</div>