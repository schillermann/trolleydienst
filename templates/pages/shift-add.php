<h2>Neue Schichten</h2>
<a href="shift.php?id_shift_type=<?php echo $placeholder['id_shift_type']?>" tabindex="13" class="button">
    <i class="fa fa-chevron-left" aria-hidden="true"></i> zurück
</a>
<div class="container-center">
    <?php if (isset($placeholder['message'])) : ?>
        <div id="note-box">
            <?php if (isset($placeholder['message']['success'])) : ?>
                <p class="success">
                    Folgende Schichten wurden angelegt:
                <ul>
                    <?php foreach ($placeholder['message']['success'] as $shiftday): ?>
                        <li><?php echo $shiftday; ?></li>
                    <?php endforeach;?>
                </ul>
                </p>
            <?php elseif(isset($placeholder['message']['error'])): ?>
                <p class="success">
                    Folgende Schichten konnten nicht angelegt werden:
                <ul>
                    <?php foreach ($placeholder['message']['error'] as $shiftday): ?>
                        <li><?php echo $shiftday; ?></li>
                    <?php endforeach;?>
                </ul>
                </p>
            <?php endif; ?>
        </div>
    <?php endif; ?>
    <form method="post">
        <fieldset>
            <legend>Schichten</legend>
            <div>
                <label for="route">Route <small>(Pflichtfeld)</small></label>
                <input id="route" type="text" name="route" tabindex="1" required maxlength="10" placeholder="Wie heißt die Route?">
            </div>
            <div>
                <label for="date_from">Datum <small>(Pflichtfeld)</small></label>
                <input id="date_from" type="date" name="date_from" tabindex="2" required>
            </div>
            <div>
                <label for="time_from">Von <small>(Pflichtfeld)</small></label>
                <input id="time_from" type="time" name="time_from" tabindex="3" required onchange="calculateShiftTimeTo()">
            </div>
            <div>
                <label for="number">Schichtanzahl <small>(Pflichtfeld)</small></label>
                <input id="number" type="number" name="number" tabindex="4" required value="2" onchange="calculateShiftTimeTo()">
            </div>
            <div>
                <label for="hours_per_shift">Schichtlänge in Stunden <small>(Pflichtfeld)</small></label>
                <input id="hours_per_shift" type="number" name="hours_per_shift" tabindex="5" required value="2" onchange="calculateShiftTimeTo()">
            </div>
            <div>
                <label for="time_to">Bis</label>
                <input id="time_to" type="time" name="time_to" disabled>
            </div>

            <div>
                <label for="shiftday_series_until">Terminserie bis zum</label>
                <input id="shiftday_series_until" type="date" name="shiftday_series_until" tabindex="6">
            </div>
            <div>
                <label for="color_hex">Farbe</label>
                <input id="color_hex" type="color" name="color_hex" value="#d5c8e4" maxlength="7" required>
            </div>
        </fieldset>
        <div class="from-button">
            <button type="submit" name="save" class="active" tabindex="12">
                <i class="fa fa-floppy-o" aria-hidden="true"></i> speichern
            </button>
        </div>
    </form>
</div>
<script type="text/javascript" src="js/calculate_shift_datetime_to.js"></script>