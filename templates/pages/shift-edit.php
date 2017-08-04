<h2>Schichten bearbeiten</h2>
<a href="shift.php" tabindex="8" class="button"><i class="fa fa-chevron-left" aria-hidden="true"></i> zurück</a>
<div class="container-center">
    <?php if (isset($placeholder['message'])) : ?>
        <div id="note-box">
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
            <legend>Schichten</legend>
            <div>
                <label for="route">Route <small>(Pflichtfeld)</small></label>
                <input id="route" type="text" name="route" tabindex="1" required value="<?php echo $placeholder['route'];?>">
            </div>
            <div>
                <label for="date_from">Datum <small>(Pflichtfeld)</small></label>
                <input id="date_from" type="date" name="date_from" tabindex="2" required value="<?php echo $placeholder['date_from'];?>">
            </div>
            <div>
                <label for="time_from">Von <small>(Pflichtfeld)</small></label>
                <input id="time_from" type="time" name="time_from" tabindex="3" required onchange="calculateShiftTimeTo()" value="<?php echo $placeholder['time_from'];?>">
            </div>
            <div>
                <label for="number">Schichtanzahl <small>(Pflichtfeld)</small></label>
                <input id="number" type="number" name="number" required value="<?php echo $placeholder['number'];?>" disabled>
            </div>
            <div>
                <label for="hours_per_shift">Schichtlänge in Stunden <small>(Pflichtfeld)</small></label>
                <input id="hours_per_shift" type="number" name="hours_per_shift" tabindex="4" required value="<?php echo $placeholder['hours_per_shift'];?>" onchange="calculateShiftTimeTo()" value="<?php echo $placeholder['hours_per_shift'];?>">
            </div>
            <div>
                <label for="time_to">Bis</label>
                <input id="time_to" type="time" name="time_to" disabled>
            </div>
            <div>
                <label for="color_hex">Farbe</label>
                <input id="color_hex" type="color" name="color_hex" maxlength="5" required value="<?php echo $placeholder['color_hex'];?>">
            </div>
        </fieldset>
        <div class="from-button">
            <button type="submit" name="save" class="active" tabindex="6">
                <i class="fa fa-floppy-o" aria-hidden="true"></i> speichern
            </button>
            <button type="submit" name="delete" class="warning" tabindex="7">
                <i class="fa fa-trash-o" aria-hidden="true"></i> löschen
            </button>
        </div>
    </form>
</div>
<script type="text/javascript" src="js/calculate_shift_datetime_to.js"></script>
<script>
    calculateShiftTimeTo();
</script>