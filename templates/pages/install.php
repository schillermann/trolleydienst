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

        </fieldset>
        <div class="from-button">
            <button type="submit" name="save" class="active" tabindex="14">
                <i class="fa fa-floppy-o" aria-hidden="true"></i> speichern
            </button>
        </div>
    </form>
</div>