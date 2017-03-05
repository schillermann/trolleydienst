<div id="content-apps">
    <?php if (isset($placeholder['error_message'])) : ?>
        <div id="divLoginNote" class="note-box login-alert-box">
            <p class="error">
                Anmeldung ist fehlgeschlagen.
            </p>
        </div>
    <?php endif; ?>
    <form method="post">
        <fieldset class="login">
            <legend>Anmelden</legend>
            <p>Wenn du ein Konto hast, bitte <em>Benutzernamen</em> und <em>Kennwort</em> eingeben.</p>
            <div>
                <label for="username">Benutzername</label>
                <input id="username" type="text" name="username" tabindex="1" autocomplete="off">
            </div>
            <div>
                <label for="password">Kennwort</label>
                <input id="password" type="password" name="password" tabindex="2" autocomplete="off">
            </div>
            <div id="divForgotLink" class="login">
                <a href="/password-forgot.php" class="xsmall">Benutzernamen oder Kennwort vergessen?</a>
            </div>
            <div>
                <label>
                    <input type="checkbox" tabindex="3" name="remember">&nbsp;Meinen Benutzernamen speichern
                </label>
            </div>
        </fieldset>
        <div class="from_button">
            <input id="button_submit" type="submit" value="Anmelden" tabindex="4">
        </div>
    </form>
</div>