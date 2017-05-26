<table id="user-list">
    <tr>
        <th>Vorname</th>
        <th>Nachname</th>
        <th>E-Mail</th>
        <th>Benutzername</th>
        <th>Aktiv</th>
        <th>Infostand</th>
        <th>Trolley</th>
        <th>Admin</th>
        <th></th>
    </tr>
    <?php foreach ($placeholder['user_list'] as $user) : ?>
    <tr>
        <td><?php echo $user->get_firstname();?></td>
        <td><?php echo $user->get_surname();?></td>
        <td><?php echo $user->get_email();?></td>
        <td><?php echo $user->get_username();?></td>
        <td><i class="fa <?php echo ($user->is_active()) ? 'fa-check' : 'fa-times';?>" aria-hidden="true"></i></td>
        <td><i class="fa <?php echo ($user->get_literature_table() != \Enum\Status::INACTIVE) ? 'fa-check' : 'fa-times';?>" aria-hidden="true"></i></td>
        <td><i class="fa <?php echo ($user->get_literature_cart() != \Enum\Status::INACTIVE) ? 'fa-check' : 'fa-times';?>" aria-hidden="true"></i></td>
        <td><i class="fa <?php echo ($user->is_admin()) ? 'fa-check' : 'fa-times';?>" aria-hidden="true"></i></td>
        <td><a href="user-edit.php?id_user=<?php echo $user->get_id_user();?>"><i class="fa fa-pencil fa-6" aria-hidden="true"></i></a></td>
    </tr>
    <?php endforeach; ?>
</table>