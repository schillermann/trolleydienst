<h2>Info hochladen</h2>
<a href="info.php" tabindex="4" class="button"><i class="fa fa-chevron-left"></i> zurück</a>
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

    <form method="post" enctype="multipart/form-data">
        <fieldset>
            <legend>Info</legend>
            <p>Du kannst Bilder im png, jpg, gif Format und Dokumente im pdf Format hochladen.</p>
            <div>
                <label for="file_label">Bezeichnung</label>
                <input id="file_label" name="file_label" tabindex="1" value="<?php echo (isset($_POST['file_label']))? $_POST['file_label'] : '';?>">
            </div>
            <div>
                <label for="file">Datei</label>
                <input id="file" type="file" name="file" tabindex="2">
            </div>
        </fieldset>
        <div class="from-button">
            <button name="upload" class="active" tabindex="3">
                <i class="fa fa-cloud-upload"></i> Datei hochladen
            </button>

        </div>
    </form>
</div>