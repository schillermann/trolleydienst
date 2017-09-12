<h2>Teilnehmer bearbeiten</h2>
<a href="user.php" tabindex="16" class="button"><i class="fa fa-chevron-left"></i> zurück</a>
<div class="container-center">
    <?php if (isset($placeholder['message'])) : ?>
        <div id="note-box" class="fade-in">
            <?php if (isset($placeholder['message']['success'])): ?>
                <p class="success">
                    <?php echo $placeholder['message']['success'];?>
                </p>
            <?php elseif (isset($placeholder['message']['error'])): ?>
                <p class="error">
                    <?php echo $placeholder['message']['error'];?>
                </p>
            <?php endif; ?>
            <button type="button" onclick="closeNoteBox()">
                <i class="fa fa-times"></i> schliessen
            </button>
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
                <input id="is_admin" type="checkbox" name="is_admin" tabindex="2" <?php if ($placeholder['user']['is_admin']):?>checked<?php endif;?>>
            </div>
            <div>
                <label for="name">Name <small>(Pflichtfeld)</small></label>
                <input id="name" name="name" tabindex="3" required value="<?php echo $placeholder['user']['name'];?>">
            </div>
            <div>
                <label for="email">E-Mail <small>(Pflichtfeld)</small></label>
                <input id="email" type="text" name="email" tabindex="4" required value="<?php echo $placeholder['user']['email'];?>">
            </div>
            <div>
                <label for="mobile">Handynr</label>
                <input id="mobile" type="text" name="mobile" tabindex="5" value="<?php echo $placeholder['user']['mobile'];?>">
            </div>
            <div>
                <label for="phone">Telefonnr</label>
                <input id="phone" type="text" name="phone" tabindex="6" value="<?php echo $placeholder['user']['phone'];?>">
            </div>
            <div>
                <label for="congregation_name">Versammlung</label>
                <input id="congregation_name" type="text" name="congregation_name" tabindex="7" value="<?php echo $placeholder['user']['congregation_name'];?>">
            </div>
            <div>
                <label for="language">Sprache</label>
                <input id="language" type="text" name="language" tabindex="8" value="<?php echo $placeholder['user']['language'];?>">
            </div>
            <div>
                <label for="note">Admin Bemerkung</label>
                <textarea id="note" name="note" class="note" tabindex="9"><?php echo $placeholder['user']['note_admin'];?></textarea>
            </div>
            <div>
                <label for="note_user">Teilnehmer Bemerkung</label>
                <textarea id="note_user" name="note_user" class="note" tabindex="10" disabled><?php echo $placeholder['user']['note_user'];?></textarea>
            </div>
        </fieldset>
        <div class="from-button">
            <button name="save" class="active" tabindex="11">
                <i class="fa fa-floppy-o"></i> speichern
            </button>
            <button name="delete" class="warning" tabindex="12">
                <i class="fa fa-trash-o"></i> löschen
            </button>
        </div>
    </form>
    <form method="post">
        <fieldset>
            <legend>Passwort</legend>
            <div>
                <label for="password">Neues Passwort</label>
                <input id="password" type="password" name="password" tabindex="13">
            </div>
            <div>
                <label for="password_repeat">Neues Passwort (wiederholen)</label>
                <input id="password_repeat" type="password" name="password_repeat" tabindex="14">
            </div>

        </fieldset>
        <div class="from-button">
            <button name="password_save" class="active" tabindex="15">
                <i class="fa fa-floppy-o"></i> Passwort ändern
            </button>
        </div>
    </form>
</div>