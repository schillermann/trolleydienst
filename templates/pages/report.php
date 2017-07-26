<h2>Bericht abgeben</h2>
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
            <legend>Bericht</legend>
            <div>
                <label for="name">Name</label>
                <select id="name" name="name" tabindex="1">
                    <?php foreach($placeholder['user_list'] as $user): ?>
                    <option value="<?php echo $user['id_user'];?>" <?php echo ((int)$user['id_user'] === $_SESSION['id_user'])? 'selected':''?>>
                        <?php echo $user['firstname'] . ' ' . $user['lastname'];?>
                    </option>
                    <?php endforeach;?>
                </select>
            </div>
            <div>
                <label for="date">Datum <small>(Pflichtfeld)</small></label>
                <input id="date" type="date" name="date" tabindex="3" required>
            </div>
            <div>
                <label for="time">Schichtzeit <small>(Pflichtfeld)</small></label>
                <input id="time" type="time" name="time" tabindex="4" required>
            </div>
            <div>
                <label for="books">Bücher <small>(Pflichtfeld)</small></label>
                <input id="books" type="number" name="books" tabindex="1">
            </div>
            <div>
                <label for="brochures">Broschüren <small>(Pflichtfeld)</small></label>
                <input id="brochures" type="number" name="brochures" tabindex="2">
            </div>
            <div>
                <label for="bibles">Bibeln <small>(Pflichtfeld)</small></label>
                <input id="bibles" type="number" name="bibles" tabindex="3">
            </div>
            <div>
                <label for="magazines">Zeitschriften <small>(Pflichtfeld)</small></label>
                <input id="magazines" type="number" name="magazines" tabindex="4">
            </div>
            <div>
                <label for="tracts">Traktate <small>(Pflichtfeld)</small></label>
                <input id="tracts" type="number" name="tracts" tabindex="5">
            </div>
            <div>
                <label for="addresses">Adressen <small>(Pflichtfeld)</small></label>
                <input id="addresses" type="number" name="addresses" tabindex="6">
            </div>
            <div>
                <label for="talks">Gespräche <small>(Pflichtfeld)</small></label>
                <input id="talks" type="number" name="talks" tabindex="7">
            </div>
        </fieldset>
        <div class="from-button">
            <button type="submit" name="save" class="active" tabindex="2">
                <i class="fa fa-floppy-o" aria-hidden="true"></i> speichern
            </button>
        </div>
    </form>
</div>