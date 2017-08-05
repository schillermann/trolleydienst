<h2>Schichttyp bearbeiten</h2>
<a href="shift-type.php" tabindex="5" class="button">
    <i class="fa fa-chevron-left" aria-hidden="true"></i> zurück
</a>
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
                <i class="fa fa-times" aria-hidden="true"></i> schliessen
            </button>
        </div>
    <?php endif; ?>
    <form method="post">
        <fieldset>
            <legend>Schichttyp</legend>
            <div>
                <label for="name">Name <small>(Pflichtfeld)</small></label>
                <input id="name" type="text" name="name" tabindex="1" required value="<?php echo $placeholder['name'];?>">
            </div>
            <div>
                <label for="user_per_shift_max">Teilnehmer pro Schicht maximal <small>(Pflichtfeld)</small></label>
                <input id="user_per_shift_max" type="number" name="user_per_shift_max" tabindex="2" required value="<?php echo $placeholder['user_per_shift_max'];?>">
            </div>
        </fieldset>
        <div class="from-button">
            <button type="submit" name="save" class="active" tabindex="3">
                <i class="fa fa-floppy-o" aria-hidden="true"></i> speichern
            </button>
            <button type="submit" name="delete" class="warning" tabindex="4">
                <i class="fa fa-trash-o" aria-hidden="true"></i> löschen
            </button>
        </div>
    </form>
</div>