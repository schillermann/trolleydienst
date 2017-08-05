<h2>Neuer Teilnehmer</h2>
<a href="user.php" tabindex="12" class="button"><i class="fa fa-chevron-left" aria-hidden="true"></i> zurück</a>
<div class="container-center">
    <?php if (isset($placeholder['message']['error'])) : ?>
    <div id="note-box" class="fade-in">
        <p class="error">
            <?php echo $placeholder['message']['error']; ?>
        </p>
        <button type="button" onclick="closeNoteBox()">
            <i class="fa fa-times" aria-hidden="true"></i> schliessen
        </button>
    </div>
    <?php endif;?>
    <form method="post">
        <fieldset>
            <legend>Teilnehmer</legend>
            <div>
                <label for="firstname">Vorname <small>(Pflichtfeld)</small></label>
                <input id="firstname" type="text" name="firstname" tabindex="1" required value="<?php echo (isset($_POST['firstname']))? $_POST['firstname'] : '';?>">
            </div>
            <div>
                <label for="lastname">Nachname <small>(Pflichtfeld)</small></label>
                <input id="lastname" type="text" name="lastname" tabindex="2" required value="<?php echo (isset($_POST['lastname']))? $_POST['lastname'] : '';?>">
            </div>
            <div>
                <label for="email">E-Mail <small>(Pflichtfeld)</small></label>
                <input id="email" type="text" name="email" tabindex="3" required value="<?php echo (isset($_POST['email']))? $_POST['email'] : '';?>">
            </div>
            <div>
                <label for="username">Benutzername <small>(Pflichtfeld)</small></label>
                <input id="username" type="text" name="username" tabindex="4" required value="<?php echo (isset($_POST['username']))? $_POST['username'] : '';?>">
            </div>
            <div>
                <label for="mobile">Handynr</label>
                <input id="mobile" type="text" name="mobile" tabindex="5" value="<?php echo (isset($_POST['mobile']))? $_POST['mobile'] : '';?>">
            </div>
            <div>
                <label for="phone">Telefonnr</label>
                <input id="phone" type="text" name="phone" tabindex="6" value="<?php echo (isset($_POST['phone']))? $_POST['phone'] : '';?>">
            </div>
            <div>
                <label for="congregation">Versammlung</label>
                <input id="congregation" type="text" name="congregation" tabindex="7" value="<?php echo (isset($_POST['congregation']))? $_POST['congregation'] : '';?>">
            </div>
            <div>
                <label for="language">Sprache</label>
                <input id="language" type="text" name="language" tabindex="8" value="<?php echo (isset($_POST['language']))? $_POST['language'] : '';?>">
            </div>
            <div>
                <label for="note">Admin Bemerkung</label>
                <textarea id="note" name="note" class="note" tabindex="9"><?php echo (isset($_POST['note']))? $_POST['note'] : '';?></textarea>
            </div>
            <div>
                <label for="is_admin">Admin-Rechte</label>
                <input id="is_admin" type="checkbox" name="is_admin" tabindex="10" <?php if (isset($_POST['is_admin'])):?>checked<?php endif;?>>
            </div>
        </fieldset>
        <div class="from-button">
            <button type="submit" name="save" class="active" tabindex="11">
                <i class="fa fa-floppy-o" aria-hidden="true"></i> speichern
            </button>
        </div>
    </form>
</div>
<script type="text/javascript" src="js/insert_username.js"></script>