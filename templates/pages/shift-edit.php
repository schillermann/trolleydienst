<h2>Schichten bearbeiten</h2>
<a href="shift.php" tabindex="4" class="button"><i class="fa fa-chevron-left" aria-hidden="true"></i> zurück</a>
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
            <legend>Teilnehmer</legend>
            <div>
                <label for="place">Ort <small>(Pflichtfeld)</small></label>
                <input id="place" type="text" name="place" tabindex="1" required value="">
            </div>
        </fieldset>
        <div class="from-button">
            <button type="submit" name="save" class="active" tabindex="2">
                <i class="fa fa-floppy-o" aria-hidden="true"></i> speichern
            </button>
            <button type="submit" name="delete" class="warning" tabindex="3">
                <i class="fa fa-trash-o" aria-hidden="true"></i> löschen
            </button>
        </div>
    </form>
</div>