<h2>Verlauf</h2>
<a href="history-shift.php" class="button active">
    <i class="fa fa-calendar-o"></i> Schichtverlauf
</a>
<a href="history-login.php" class="button">
    <i class="fa fa-sign-in"></i> Login
</a>
<a href="history-system.php" class="button">
    <i class="fa fa-cog"></i> System
</a>
<h3>Schichtverlauf</h3>
<h4>Fehlermeldungen</h4>
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
<h4>Statusmeldungen</h4>
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