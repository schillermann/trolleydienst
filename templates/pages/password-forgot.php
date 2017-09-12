<h2>Passwort vergessen</h2>
<a href="index.php" tabindex="4" class="button"><i class="fa fa-chevron-left"></i> zurück</a>
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
            <legend>Passwort anfordern</legend>
            <div>
                <label for="name">Name <small>(Pflichtfeld)</small></label>
                <input id="name" name="name" tabindex="1" required">
            </div>
            <div>
                <label for="email">E-Mail <small>(Pflichtfeld)</small></label>
                <input id="email" type="email" name="email" tabindex="2" required>
            </div>

        </fieldset>
        <div class="from-button">
            <button name="password_reset" class="active" tabindex="3">
                <i class="fa fa-undo"></i> Neues Passwort anfordern
            </button>
        </div>
    </form>
</div>