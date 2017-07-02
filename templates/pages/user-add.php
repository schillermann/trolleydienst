<h2>Neuer Teilnehmer</h2>
<div class="container-center">
    <?php if (isset($placeholder['message']['error'])) : ?>
    <div class="note-box">
        <p class="error">
            <?php echo $placeholder['message']['error']; ?>
        </p>
    </div>
    <?php endif;?>
    <form method="post">
        <fieldset>
            <legend>Teilnehmer</legend>
            <div>
                <label for="is_active">Aktiv</label>
                <input id="is_active" type="checkbox" name="is_active" tabindex="1" <?php if (isset($_POST['is_active'])):?>checked<?php endif;?>>
            </div>
            <div>
                <label for="is_literature_table">Infostand</label>
                <input id="is_literature_table" type="checkbox" name="is_literature_table" tabindex="2" <?php if (isset($_POST['is_literature_table'])):?>checked<?php endif;?>>
            </div>
            <div>
                <label for="is_literature_cart">Trolley</label>
                <input id="is_literature_cart" type="checkbox" name="is_literature_cart" tabindex="3" <?php if (isset($_POST['is_literature_cart'])):?>checked<?php endif;?>>
            </div>
            <div>
                <label for="is_admin">Admin-Rechte</label>
                <input id="is_admin" type="checkbox" name="is_admin" tabindex="4" <?php if (isset($_POST['is_admin'])):?>checked<?php endif;?>>
            </div>
            <div>
                <label for="firstname">Vorname <small>(Pflichtfeld)</small></label>
                <input id="firstname" type="text" name="firstname" tabindex="5" required value="<?php echo (isset($_POST['firstname']))? $_POST['firstname'] : '';?>">
            </div>
            <div>
                <label for="lastname">Nachname <small>(Pflichtfeld)</small></label>
                <input id="lastname" type="text" name="lastname" tabindex="6" required value="<?php echo (isset($_POST['lastname']))? $_POST['lastname'] : '';?>">
            </div>
            <div>
                <label for="email">E-Mail <small>(Pflichtfeld)</small></label>
                <input id="email" type="text" name="email" tabindex="7" required value="<?php echo (isset($_POST['email']))? $_POST['email'] : '';?>">
            </div>
            <div>
                <label for="username">Benutzername <small>(Pflichtfeld)</small></label>
                <input id="username" type="text" name="username" tabindex="8" required value="<?php echo (isset($_POST['username']))? $_POST['username'] : '';?>">
            </div>
            <div>
                <label for="mobile">Handynr</label>
                <input id="mobile" type="text" name="mobile" tabindex="9" value="<?php echo (isset($_POST['mobile']))? $_POST['mobile'] : '';?>">
            </div>
            <div>
                <label for="phone">Telefonnr</label>
                <input id="phone" type="text" name="phone" tabindex="10" value="<?php echo (isset($_POST['phone']))? $_POST['phone'] : '';?>">
            </div>
            <div>
                <label for="congregation">Versammlung</label>
                <input id="congregation" type="text" name="congregation" tabindex="11" value="<?php echo (isset($_POST['congregation']))? $_POST['congregation'] : '';?>">
            </div>
            <div>
                <label for="language">Sprache</label>
                <input id="language" type="text" name="language" tabindex="12" value="<?php echo (isset($_POST['language']))? $_POST['language'] : '';?>">
            </div>
            <div>
                <label for="note">Admin Bemerkung</label>
                <textarea id="note" name="note" class="note" tabindex="13"><?php echo (isset($_POST['note']))? $_POST['note'] : '';?></textarea>
            </div>

        </fieldset>
        <div class="from-button">
            <button type="submit" name="save" class="active" tabindex="14">
                <i class="fa fa-floppy-o" aria-hidden="true"></i> speichern
            </button>
            <a href="user.php" tabindex="15" class="button">
                <i class="fa fa-ban" aria-hidden="true"></i> abbrechen
            </a>
        </div>
    </form>
</div>
<script type="text/javascript" src="js/insert_username.js"></script>