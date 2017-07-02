<h2>Neue Schichten</h2>
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
                <p class="error">
                    <?php echo $placeholder['message']['error']; ?>
                </p>
            <?php endif; ?>
        </div>
    <?php endif; ?>
    <form method="post">
        <fieldset>
            <legend>Schichten</legend>
            <div>
                <label for="shift_type">Schichtart</label>
                <select id="shift_type" name="shift_type" tabindex="1">
                    <option value="0">Infostand</option>
                    <option value="1">Trolley</option>
                </select>
            </div>
            <div>
                <label for="place">Ort <small>(Pflichtfeld)</small></label>
                <input id="place" type="text" name="place" tabindex="2" required>
            </div>
            <div>
                <label for="date">Datum <small>(Pflichtfeld)</small></label>
                <input id="date" type="date" name="date" tabindex="3" required>
            </div>
            <div>
                <label for="time_from">Von <small>(Pflichtfeld)</small></label>
                <input id="time_from" type="time" name="time_from" tabindex="4" required>
            </div>
            <div>
                <label for="time_to">Bis <small>(Pflichtfeld)</small></label>
                <input id="time_to" type="time" name="time_to" tabindex="5" required>
            </div>
            <div>
                <label for="shift_hour_number">Stundenanzahl <small>(Pflichtfeld)</small></label>
                <input id="shift_hour_number" type="number" name="shift_hour_number" tabindex="7" required value="2">
            </div>
            <div>
                <label for="shiftday_series_until">Terminserie bis zum</label>
                <input id="shiftday_series_until" type="date" name="shiftday_series_until" tabindex="8">
            </div>
            <div>
                <label>Farbe</label>
                <label class="color-picker" style="background-color: #d5c8e4">
                    <input type="radio" name="color_hex" value="#d5c8e4" checked>
                    Violett
                </label>
                <label class="color-picker" style="background-color: #ffc000">
                    <input type="radio" name="color_hex" value="#ffc000">
                    Gelb
                </label>
                <label class="color-picker" style="background-color: #a2f5fd">
                    <input type="radio" name="color_hex" value="#a2f5fd">
                    Blau
                </label>
                <label class="color-picker" style="background-color: #aff96b">
                    <input type="radio" name="color_hex" value="#aff96b">
                    Grün
                </label>
                <label class="color-picker" style="background-color: #d99694">
                    <input type="radio" name="color_hex" value="#d99694">
                    Rot
                </label>
            </div>
        </fieldset>
        <div class="from-button">
            <button type="submit" name="save" class="active" tabindex="15">
                <i class="fa fa-floppy-o" aria-hidden="true"></i> speichern
            </button>
            <a href="shift.php" tabindex="16" class="button"><i class="fa fa-ban" aria-hidden="true"></i> abbrechen</a>
        </div>
    </form>
</div>