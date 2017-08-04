<h2>Passwort vergessen</h2>
<a href="index.php" tabindex="4" class="button"><i class="fa fa-chevron-left" aria-hidden="true"></i> zurück</a>
<div class="container-center">

    <?php if (isset($placeholder['message'])) : ?>
        <div id="note-box">
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
        </div>
    </form>
</div>