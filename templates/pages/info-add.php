<h2>Info hochladen</h2>
<a href="info.php" tabindex="5" class="button"><i class="fa fa-chevron-left" aria-hidden="true"></i> zurück</a>
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

    <form method="post" enctype="multipart/form-data">
        <fieldset>
            <legend>Info</legend>
            <p>Du kannst Bilder im png, jpg, gif Format und Dokumente im pdf Format hochladen.</p>
            <div>
                <label for="info_label">Bezeichnung</label>
                <input id="info_label" type="text" name="info_label" tabindex="1">
            </div>

            <div>
                <label for="info_type">Typ</label>
                <select id="info_type" name="info_type" tabindex="2">
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
        <div class="from-button">
            <button type="submit" name="upload" class="active" tabindex="4">
                <i class="fa fa-cloud-upload" aria-hidden="true"></i> Datei hochladen
            </button>

        </div>
    </form>
</div>