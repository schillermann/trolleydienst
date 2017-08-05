<h2>Verlauf</h2>
<h3>Schichtverlauf</h3>
<fieldset>
    <legend>Fehlermeldungen</legend>
    <div class="table-container">
        <table>
            <tr>
                <th>Zeit</th>
                <th>Ausgeführt von</th>
                <th>Mitteilung</th>
            </tr>
            <?php foreach ($placeholder['shift_history_error_list'] as $shift_history) : ?>
                <tr>
                    <td><?php echo $shift_history['datetime'];?></td>
                    <td><?php echo $shift_history['user'];?></td>
                    <td><?php echo $shift_history['message'];?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</fieldset>
<fieldset>
    <legend>Statusmeldungen</legend>
    <div class="table-container">
        <table>
            <tr>
                <th>Zeit</th>
                <th>Ausgeführt von</th>
                <th>Mitteilung</th>
            </tr>
            <?php foreach ($placeholder['shift_history_success_list'] as $shift_history) : ?>
                <tr>
                    <td><?php echo $shift_history['datetime'];?></td>
                    <td><?php echo $shift_history['user'];?></td>
                    <td><?php echo $shift_history['message'];?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</fieldset>