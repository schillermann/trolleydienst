<h2>Schichttyp Liste</h2>
<div class="from-button">
    <a href="shift-type-add.php" tabindex="1" class="button active">
        <i class="fa fa-plus"></i> Neuer Schichttyp
    </a>
</div>
<div class="container-center">
    <div class="table-container">
        <table>
            <tr>
                <th>Name</th>
                <th>Teilnehmer pro Schicht maximal</th>
                <th>Aktion</th>
            </tr>
            <?php foreach ($placeholder['shift_type_list'] as $shift_type) : ?>
            <tr>
                <td><?php echo $shift_type['name']; ?></td>
                <td><?php echo $shift_type['user_per_shift_max']; ?></td>
                <td><a class="button" href="shift-type-edit.php?id_shift_type=<?php echo (int)$shift_type['id_shift_type'];?>"><i class="fa fa-pencil fa-6" aria-hidden="true"></i> bearbeiten</a></td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>