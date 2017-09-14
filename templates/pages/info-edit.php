<?php $file_name = $placeholder['info']['file_name_hash']; ?>
<h2>Info hochladen</h2>
<a href="info.php" tabindex="4" class="button">
    <i class="fa fa-chevron-left"></i> zurück
</a>
<div class="container-center">
    <?php if (isset($placeholder['message'])) : ?>
        <div id="note-box" class="fade-in">
            <?php if (isset($placeholder['message']['success'])) : ?>
                <p class="success">
                    <?php echo $placeholder['message']['success']; ?>
                </p>
            <?php elseif(isset($placeholder['message']['error'])): ?>
                <p class="error">
                    <?php echo $placeholder['message']['error']; ?>
                </p>
            <?php endif; ?>
            <button type="button" onclick="closeNoteBox()">
                <i class="fa fa-times"></i> schliessen
            </button>
        </div>
    <?php endif; ?>
    <div class="info-box">
        <p>Du kannst Bilder im png, jpg, gif Format und Dokumente im pdf Format hochladen.</p>
    </div>
    <form method="post">
        <fieldset>
            <legend>Info</legend>
            <div>
                <label for="file_label">Bezeichnung</label>
                <input id="file_label" name="file_label" tabindex="1" value="<?php echo $placeholder['info']['file_label']; ?>">
            </div>

        </fieldset>
        <div class="from-button">

            <button name="save" class="active" tabindex="2">
                <i class="fa fa-floppy-o"></i> speichern
            </button>
            <button name="delete" class="warning" tabindex="3">
                <i class="fa fa-trash-o"></i> löschen
            </button>

        </div>
    </form>
</div>