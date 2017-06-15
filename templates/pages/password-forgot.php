<h2>Passwort vergessen</h2>
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
            <legend>Passwort anfordern</legend>
            <div>
                <label for="username">Benutzername <small>(Pflichtfeld)</small></label>
                <input id="username" type="text" name="username" tabindex="1" required">
            </div>
            <div>
                <label for="email">E-Mail <small>(Pflichtfeld)</small></label>
                <input id="email" type="email" name="email" tabindex="2" required>
            </div>

        </fieldset>
        <div class="from-button">
            <button type="submit" name="password_reset" class="active" tabindex="3">
                <i class="fa fa-undo" aria-hidden="true"></i> Neues Passwort anfordern
            </button>
            <a href="user.php" tabindex="4" class="button"><i class="fa fa-ban" aria-hidden="true"></i> abbrechen</a>
        </div>
    </form>
</div>