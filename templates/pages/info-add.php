<div id="content-apps">
    <h2>Info hochladen</h2>

    <?php if (isset($placeholder['message'])) : ?>
        <div class="note-box">
            <p class="<?php echo $placeholder['message_class']; ?>">
                <?php echo $placeholder['message']; ?>
            </p>
        </div>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data">
        <fieldset>
            <legend>Info</legend>
            <p>Du kannst Bilder im png, jpg, gif Format und Dokumente im pdf Format hochladen.</p>
            <div>
                <label for="file_label">Bezeichnung</label>
                <input id="file_label" type="text" name="file_label" tabindex="1">
            </div>

            <div>
                <label for="file_type">Typ</label>
                <select name="file_type" tabindex="2">
                    <option value="-1">Anleitung</option>
                    <option value="0" selected="">Özi</option>
                    <option value="1">Trolley</option>
                    <option value="2">Infostand</option>
                </select>
            </div>

            <div>
                <label for="file">Datei</label>
                <input id="file" type="file" name="file" tabindex="3">
            </div>

        </fieldset>
        <div class="from_button">
            <input id="button_submit" type="submit" value="Datei hochladen" tabindex="4">
        </div>
    </form>
</div>