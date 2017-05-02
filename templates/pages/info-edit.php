<h2>Info hochladen</h2>
    <div class="container-center">
    <?php if (isset($placeholder['file_uploaded'])) : ?>
        <div class="note-box">
            <?php if ($placeholder['file_uploaded']): ?>
                <p class="success">
                    Die Datei wurde hochgeladen.
                </p>
            <?php else: ?>
            <p class="error">
                Die Datei konnte nicht hochgeladen werden!
            </p>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <form method="post">
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

        </fieldset>
        <div class="from_button">

            <button type="submit">
                <i class="fa fa-trash-o" aria-hidden="true"></i> löschen
            </button>

            <button type="submit" style="float: right">
                <i class="fa fa-ban" aria-hidden="true"></i> abbrechen
            </button>
            <button type="submit" style="float: right">
                <i class="fa fa-floppy-o" aria-hidden="true"></i> speichern
            </button>


        </div>
    </form>
</div>