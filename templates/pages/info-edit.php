<?php $file_name = $placeholder['info']['file_name']; ?>
<h2>Info hochladen</h2>
    <div class="container-center">
    <?php if (isset($placeholder['update_info_success'])) : ?>
        <div class="note-box">
            <?php if ($placeholder['update_info_success']): ?>
                <p class="success">
                    Die Datei <?php echo $file_name; ?> wurde geändert.
                </p>
            <?php else: ?>
            <p class="error">
                Die Datei <?php echo $file_name; ?> konnte nicht geändert werden!
            </p>
            <?php endif; ?>
        </div>
    <?php elseif (isset($placeholder['delete_info_success'])): ?>
        <div class="note-box">
            <?php if (!$placeholder['delete_info_success']): ?>
                <p class="error">
                    Die Datei <?php echo $file_name; ?> konnte nicht gelöscht werden!
                </p>
            <?php endif; ?>
        </div>
    <?php endif; ?>
    <form method="post">
        <fieldset>
            <legend>Info</legend>
            <p>Du kannst Bilder im png, jpg, gif Format und Dokumente im pdf Format hochladen.</p>
            <div>
                <label for="info_label">Bezeichnung</label>
                <input id="info_label" type="text" name="info_label" tabindex="1" value="<?php echo $placeholder['info']['label']; ?>">
            </div>
            <div>
                <label for="info_type">Typ</label>
                <?php $type = $placeholder['info']['type']; ?>
                <select name="info_type" tabindex="2">
                    <option value="-1" <?php echo ($type ==  -1) ? 'selected' : ''; ?>>Anleitung</option>
                    <option value="0" <?php echo ($type ==  0) ? 'selected' : ''; ?>>Özi</option>
                    <option value="1" <?php echo ($type ==  1) ? 'selected' : ''; ?>>Trolley</option>
                    <option value="2" <?php echo ($type ==  2) ? 'selected' : ''; ?>>Infostand</option>
                </select>
            </div>

        </fieldset>
        <div class="from-button">

            <button type="submit" name="save" class="active" tabindex="3">
                <i class="fa fa-floppy-o" aria-hidden="true"></i> speichern
            </button>
            <a href="info.php" class="button" tabindex="4">
                <i class="fa fa-ban" aria-hidden="true"></i> abbrechen
            </a>
            <button type="submit" name="delete" class="warning" tabindex="5">
                <i class="fa fa-trash-o" aria-hidden="true"></i> löschen
            </button>

        </div>
    </form>
</div>