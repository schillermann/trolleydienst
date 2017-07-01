<h2>Profil</h2>
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
            <legend>Kontaktdaten</legend>
            <div>
                <label for="firstname">Vorname <small>(Pflichtfeld)</small></label>
                <input id="firstname" type="text" name="firstname" tabindex="1" required value="<?php echo $placeholder['profile']['firstname']; ?>">
            </div>
            <div>
                <label for="lastname">Nachname <small>(Pflichtfeld)</small></label>
                <input id="lastname" type="text" name="lastname" tabindex="2" required value="<?php echo $placeholder['profile']['lastname']; ?>">
            </div>
            <div>
                <label for="email">E-Mail <small>(Pflichtfeld)</small></label>
                <input id="email" type="email" name="email" tabindex="3" required value="<?php echo $placeholder['profile']['email']; ?>">
            </div>
            <div>
                <label for="username">Benutzername <small>(Pflichtfeld)</small></label>
                <input id="username" type="text" name="username" tabindex="4" required readonly value="<?php echo $placeholder['profile']['username']; ?>">
            </div>
            <div>
                <label for="phone">Telefon</label>
                <input id="phone" type="tel" name="phone" tabindex="5" value="<?php echo $placeholder['profile']['phone']; ?>">
            </div>
            <div>
                <label for="mobile">Handy</label>
                <input id="mobile" type="tel" name="mobile" tabindex="6" value="<?php echo $placeholder['profile']['mobile']; ?>">
            </div>
            <div>
                <label for="congregation">Versammlung</label>
                <input id="congregation" type="text" name="congregation" tabindex="7" value="<?php echo $placeholder['profile']['congregation']; ?>">
            </div>
            <div>
                <label for="language">Sprache</label>
                <input id="language" type="text" name="language" tabindex="8" value="<?php echo $placeholder['profile']['language']; ?>">
            </div>
            <div>
                <label for="note_user">Bemerkung</label>
                <textarea id="note_user" name="note_user" class="note" tabindex="10"><?php echo $placeholder['profile']['note_user']; ?></textarea>
            </div>

        </fieldset>
        <div class="from-button">
            <button type="submit" name="profile_save" class="active" tabindex="11">
                <i class="fa fa-floppy-o" aria-hidden="true"></i> Profil speichern
            </button>
        </div>
    </form>
    <form method="post">
        <fieldset>
            <legend>Passwort</legend>
            <div>
                <label for="password">Neues Passwort</label>
                <input id="password" type="password" name="password" tabindex="12">
            </div>
            <div>
                <label for="password_repeat">Neues Passwort (wiederholen)</label>
                <input id="password_repeat" type="password" name="password_repeat" tabindex="13">
            </div>

        </fieldset>
        <div class="from-button">
            <button type="submit" name="password_save" class="active" tabindex="14">
                <i class="fa fa-floppy-o" aria-hidden="true"></i> Passwort ändern
            </button>
        </div>
    </form>
</div>