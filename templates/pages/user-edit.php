<h2>Teilnehmer bearbeiten</h2>
<div class="container-center">
    <?php if (isset($placeholder['message'])) : ?>
        <div class="note-box">
            <?php if (isset($placeholder['message']['success'])): ?>
                <p class="success">
                    <?php echo $placeholder['message']['success'];?>
                </p>
            <?php elseif (isset($placeholder['message']['error'])): ?>
                <p class="error">
                    <?php echo $placeholder['message']['error'];?>
                </p>
            <?php endif; ?>
        </div>
    <?php endif; ?>
    <form method="post">
        <fieldset>
            <legend>Teilnehmer</legend>
            <div>
                <label for="is_active">Aktiv</label>
                <input id="is_active" type="checkbox" name="is_active" tabindex="1" <?php if ($placeholder['user']['is_active']):?>checked<?php endif;?>>
            </div>
            <div>
                <label for="is_admin">Admin-Rechte</label>
                <input id="is_admin" type="checkbox" name="is_admin" tabindex="4" <?php if ($placeholder['user']['is_admin']):?>checked<?php endif;?>>
            </div>
            <div>
                <label for="firstname">Vorname <small>(Pflichtfeld)</small></label>
                <input id="firstname" type="text" name="firstname" tabindex="5" required value="<?php echo $placeholder['user']['firstname'];?>">
            </div>
            <div>
                <label for="lastname">Nachname <small>(Pflichtfeld)</small></label>
                <input id="lastname" type="text" name="lastname" tabindex="6" required value="<?php echo $placeholder['user']['lastname'];?>">
            </div>
            <div>
                <label for="email">E-Mail <small>(Pflichtfeld)</small></label>
                <input id="email" type="text" name="email" tabindex="7" required value="<?php echo $placeholder['user']['email'];?>">
            </div>
            <div>
                <label for="username">Benutzername <small>(Pflichtfeld)</small></label>
                <input id="username" type="text" name="username" tabindex="8" required value="<?php echo $placeholder['user']['username'];?>">
            </div>
            <div>
                <label for="mobile">Handynr</label>
                <input id="mobile" type="text" name="mobile" tabindex="9" value="<?php echo $placeholder['user']['mobile'];?>">
            </div>
            <div>
                <label for="phone">Telefonnr</label>
                <input id="phone" type="text" name="phone" tabindex="10" value="<?php echo $placeholder['user']['phone'];?>">
            </div>
            <div>
                <label for="congregation">Versammlung</label>
                <input id="congregation" type="text" name="congregation" tabindex="11" value="<?php echo $placeholder['user']['congregation'];?>">
            </div>
            <div>
                <label for="language">Sprache</label>
                <input id="language" type="text" name="language" tabindex="12" value="<?php echo $placeholder['user']['language'];?>">
            </div>
            <div>
                <label for="note">Admin Bemerkung</label>
                <textarea id="note" name="note" class="note" tabindex="13"><?php echo $placeholder['user']['note_admin'];?></textarea>
            </div>
            <div>
                <label for="note_user">Teilnehmer Bemerkung</label>
                <textarea id="note_user" name="note_user" class="note" tabindex="14" disabled><?php echo $placeholder['user']['note_user'];?></textarea>
            </div>
        </fieldset>
        <div class="from-button">
            <button type="submit" name="save" class="active" tabindex="15">
                <i class="fa fa-floppy-o" aria-hidden="true"></i> speichern
            </button>
            <a href="user.php" class="button" tabindex="16">
                <i class="fa fa-ban" aria-hidden="true"></i> abbrechen
            </a>
            <button type="submit" name="delete" class="warning" tabindex="17">
                <i class="fa fa-trash-o" aria-hidden="true"></i> löschen
            </button>
        </div>
    </form>
    <form method="post">
        <fieldset>
            <legend>Passwort</legend>
            <div>
                <label for="password">Neues Passwort</label>
                <input id="password" type="password" name="password" tabindex="18">
            </div>
            <div>
                <label for="password_repeat">Neues Passwort (wiederholen)</label>
                <input id="password_repeat" type="password" name="password_repeat" tabindex="19">
            </div>

        </fieldset>
        <div class="from-button">
            <button type="submit" name="password_save" class="active" tabindex="20">
                <i class="fa fa-floppy-o" aria-hidden="true"></i> Passwort ändern
            </button>
        </div>
    </form>
</div>