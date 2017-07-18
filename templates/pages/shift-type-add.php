<h2>Neuer Schichttyp</h2>
<a href="shift-type.php" tabindex="4" class="button"><i class="fa fa-chevron-left" aria-hidden="true"></i> zurück</a>
<div class="container-center">
    <?php if (isset($placeholder['message'])) : ?>
        <div class="note-box">
            <?php if (isset($placeholder['message']['success'])) : ?>
                <p class="success">
                    <?php echo $placeholder['message']['success']; ?>
                </p>
            <?php elseif(isset($placeholder['message']['error'])): ?>
                <p class="error">
                    <?php echo $placeholder['message']['error']; ?>
                </p>
            <?php endif; ?>
        </div>
    <?php endif; ?>
    <form method="post">
        <fieldset>
            <legend>Schichtart</legend>
            <div>
                <label for="name">Name <small>(Pflichtfeld)</small></label>
                <input id="name" type="text" name="name" tabindex="1" required value="<?php echo (isset($_POST['name']))? $_POST['name'] : '';?>">
                <label for="user_per_shift_max">Max. Teilnehmer <small>(Pflichtfeld)</small></label>
                <input id="user_per_shift_max" type="number" name="user_per_shift_max" tabindex="2" required value="<?php echo (isset($_POST['user_per_shift_max']))? $_POST['user_per_shift_max'] : 2;?>">
            </div>
        </fieldset>
        <div class="from-button">
            <button type="submit" name="save" class="active" tabindex="3">
                <i class="fa fa-floppy-o" aria-hidden="true"></i> speichern
            </button>
        </div>
    </form>
</div>