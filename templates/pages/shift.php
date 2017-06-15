<?php $get_weekday = include 'templates/helpers/get_weekday.php'; ?>

<h2>Schichten</h2>
<?php if (isset($placeholder['message'])) : ?>
    <div class="note-box">
        <?php if (isset($placeholder['message']['success'])) : ?>
            <p class="success">
                <?php echo $placeholder['message']['success']; ?>
            </p>
        <?php elseif(isset($placeholder['message']['error'])): ?>
            <p class="error">
                <?php echo $placeholder['message']['error']; ?>
            </p>
        <?php endif; ?>
    </div>
<?php endif; ?>

<?php if($_SESSION['role'] == Enum\UserRole::ADMIN): ?>
<a href="shift-add.php" tabindex="1" class="button active">
    <i class="fa fa-plus" aria-hidden="true"></i> Neue Schichten
</a>
<?php endif; ?>

<?php foreach ($placeholder['appointment_list'] as $appointment_list) : ?>
<table>
    <thead>
        <tr>
            <th colspan="2">
                <h3>
                    <?php echo $get_weekday($appointment_list->get_appointment()->get_time_from()); ?>,
                    <?php echo $appointment_list->get_appointment()->get_time_from()->format('d.m.Y'); ?> -
                    <?php echo ($appointment_list->get_appointment()->get_type() == 0) ? 'Trolley' : 'Infostand'; ?>:
                    <?php echo $appointment_list->get_appointment()->get_place(); ?>

                    <?php if($_SESSION['role'] == Enum\UserRole::ADMIN): ?>
                        <a href="#" class="button">
                            <i class="fa fa-pencil" aria-hidden="true"></i> bearbeiten
                        </a>
                    <?php endif; ?>
                </h3>
            </th>
        </tr>
    </thead>
    <tfoot>
        <tr>
            <td colspan="2"></td>
        </tr>
    </tfoot>
    <tbody>
        <?php foreach ($appointment_list->get_iterator_shift_user_list() as $shift_user_list) : ?>
        <tr>
            <td class="shift_time" id="id_appointment_<?php echo $appointment_list->get_appointment()->get_id(); ?>_id_shift_<?php echo $shift_user_list->get_shift()->get_id_shift(); ?>">
                <?php echo $shift_user_list->get_shift()->get_time_from()->format('H:i'); ?> -
                <?php echo $shift_user_list->get_shift()->get_time_to()->format('H:i'); ?>
            </td>
            <td>
                <form method="post">
                    <input type="hidden" name="id_shift_day" value="<?php echo $shift_user_list->get_shift()->get_id_appointment(); ?>">
                    <input type="hidden" name="id_shift" value="<?php echo $shift_user_list->get_shift()->get_id_shift(); ?>">
                    <?php foreach ($shift_user_list->get_iterator_user() as $shift_user) : ?>

                        <?php $user_name =  $shift_user->get_firstname() . ' ' . $shift_user->get_surname(); ?>

                        <?php if($shift_user->get_id_user() === $_SESSION['id_user'] && $shift_user->get_status() === 0): ?>
                            <button type="submit" name="delete_user" class="enable">
                                <i class="fa fa-thumbs-o-down" aria-hidden="true"></i> <?php echo $user_name; ?>
                            </button>
                        <?php else: ?>
                            <a href="user-details.php?id_user=<?php echo $shift_user->get_id_user(); ?>" class="button">
                                <i class="fa fa-phone" aria-hidden="true"></i> <?php echo $user_name; ?>
                            </a>
                        <?php endif; ?>

                    <?php endforeach; ?>

                    <?php if ($shift_user_list->count() < 2) : ?>

                    <button type="submit" name="promote_user">
                        <i class="fa fa-thumbs-o-up" aria-hidden="true"></i> bewerben
                    </button>

                    <?php endif; ?>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php endforeach; ?>