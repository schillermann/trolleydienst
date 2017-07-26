<h2>Neue Schichten</h2>
<a href="shift.php?id_shift_type=<?php echo $placeholder['id_shift_type']?>" tabindex="13" class="button">
    <i class="fa fa-chevron-left" aria-hidden="true"></i> zurück
</a>
<div class="container-center">
    <?php if (isset($placeholder['message'])) : ?>
        <div class="note-box">
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
                <label for="place">Ort <small>(Pflichtfeld)</small></label>
                <input id="place" type="text" name="place" tabindex="1" required>
            </div>
            <div>
                <label for="date">Datum <small>(Pflichtfeld)</small></label>
                <input id="date" type="date" name="date" tabindex="2" required>
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
                <label>Farbe</label>
                <label class="color-picker" style="background-color: #d5c8e4">
                    <input type="radio" name="color_hex" value="#d5c8e4" tabindex="7" checked>
                    Violett
                </label>
                <label class="color-picker" style="background-color: #ffc000">
                    <input type="radio" name="color_hex" value="#ffc000" tabindex="8">
                    Gelb
                </label>
                <label class="color-picker" style="background-color: #a2f5fd">
                    <input type="radio" name="color_hex" value="#a2f5fd" tabindex="9">
                    Blau
                </label>
                <label class="color-picker" style="background-color: #aff96b">
                    <input type="radio" name="color_hex" value="#aff96b" tabindex="10">
                    Grün
                </label>
                <label class="color-picker" style="background-color: #d99694">
                    <input type="radio" name="color_hex" value="#d99694" tabindex="11">
                    Rot
                </label>
            </div>
        </fieldset>
        <div class="from-button">
            <button type="submit" name="save" class="active" tabindex="12">
                <i class="fa fa-floppy-o" aria-hidden="true"></i> speichern
            </button>
        </div>
    </form>
</div>
<script>
    const timeFrom = document.getElementById("time_from");
    const timeTo = document.getElementById("time_to");
    const number = document.getElementById("number");
    const hoursPerShift = document.getElementById("hours_per_shift");

    function calculateShiftTimeTo() {
        const timeRangeInMinutes = number.value * (hoursPerShift.value * 60);
        const timeFromSplit = timeFrom.value.split(":");

        const dateFrom = new Date();
        dateFrom.setHours(timeFromSplit[0]);
        dateFrom.setMinutes(timeFromSplit[1]);

        const dateTo = new Date(dateFrom.getTime() + timeRangeInMinutes * 60000);
        timeTo.value = dateTo.getHours() + ":" + ("0" + dateTo.getMinutes()).substr(-2);
    }
</script>