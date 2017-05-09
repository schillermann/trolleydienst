<h2>Profil</h2>
<div class="container-center">

    <?php if (isset($placeholder['profile_save'])) : ?>
        <div class="note-box">
            <?php if ($placeholder['profile_save']): ?>
                <p class="success">
                    Dein Profil wurde gespeichert.
                </p>
            <?php else: ?>
                <p class="error">
                    Dein Profil konnte nicht gespeichert werden!
                </p>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <form method="post">
        <fieldset>
            <legend>Kontaktdaten</legend>
            <div>
                <label for="firstname">Vorname</label>
                <input id="firstname" type="text" name="firstname" tabindex="1" value="<?php echo $placeholder['user']->get_firstname(); ?>">
            </div>
            <div>
                <label for="surname">Nachname</label>
                <input id="surname" type="text" name="surname" tabindex="2" value="<?php echo $placeholder['user']->get_surname(); ?>">
            </div>
            <div>
                <label for="email">E-Mail</label>
                <input id="email" type="email" name="email" tabindex="3" value="<?php echo $placeholder['user']->get_email(); ?>">
            </div>
            <div>
                <label for="phone">Telefon</label>
                <input id="phone" type="tel" name="phone" tabindex="4" value="<?php echo $placeholder['user']->get_phone(); ?>">
            </div>
            <div>
                <label for="mobile">Handy</label>
                <input id="mobile" type="tel" name="mobile" tabindex="5" value="<?php echo $placeholder['user']->get_mobile(); ?>">
            </div>
            <div>
                <label for="shift_max">Max Stunden/Tag</label>
                <input id="shift_max" type="number" name="shift_max" tabindex="6" value="<?php echo $placeholder['user']->get_shift_max(); ?>">
            </div>
            <div>
                <label for="note">Bemerkung</label>
                <textarea id="note" name="note" tabindex="7"><?php echo $placeholder['user']->get_note(); ?></textarea>
            </div>

        </fieldset>
        <div class="from_button">
            <button type="submit" name="profile_save" class="active" tabindex="8">
                <i class="fa fa-floppy-o" aria-hidden="true"></i> speichern
            </button>
        </div>
    </form>
    <fieldset>
        <legend>Passwort</legend>
        <div>
            <label for="password">Neues Passwort</label>
            <input id="password" type="password" name="password" tabindex="1">
        </div>
        <div>
            <label for="password_repeat">Neues Passwort (wiederholen)</label>
            <input id="password_repeat" type="password" name="password_repeat" tabindex="2">
        </div>

    </fieldset>
    <div class="from_button">
        <button type="submit" name="password_save" class="active" tabindex="3">
            <i class="fa fa-floppy-o" aria-hidden="true"></i> Passwort ändern
        </button>
    </div>
</div>