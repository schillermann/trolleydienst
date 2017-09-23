<h2>Verlauf</h2>
<h3>Schichtverlauf</h3>
<fieldset>
    <legend>Fehlermeldungen</legend>
    <div class="table-container">
        <table>
            <tr>
                <th>Ausgeführt am</th>
                <th>Ausgeführt von</th>
                <th>Mitteilung</th>
            </tr>
            <?php foreach ($placeholder['shift_error_list'] as $shift_history) : ?>
                <tr>
                    <td><?php echo $shift_history['created'];?></td>
                    <td><?php echo $shift_history['name'];?></td>
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
                <th>Ausgeführt am</th>
                <th>Ausgeführt von</th>
                <th>Mitteilung</th>
            </tr>
            <?php foreach ($placeholder['shift_success_list'] as $shift_history) : ?>
                <tr>
                    <td><?php echo $shift_history['created'];?></td>
                    <td><?php echo $shift_history['name'];?></td>
                    <td><?php echo $shift_history['message'];?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</fieldset>
<h3>Login Verlauf</h3>
<fieldset>
    <legend>Fehlermeldungen</legend>
    <div class="table-container">
        <table>
            <tr>
                <th>Ausgeführt am</th>
                <th>Name</th>
                <th>Mitteilung</th>
            </tr>
            <?php foreach ($placeholder['login_error_list'] as $shift_history) : ?>
                <tr>
                    <td><?php echo $shift_history['created'];?></td>
                    <td><?php echo $shift_history['name'];?></td>
                    <td><?php echo $shift_history['message'];?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</fieldset>