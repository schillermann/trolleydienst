<?php $get_weekday = include 'templates/helpers/get_weekday.php'; ?>
<?php $convert_datetime = include 'templates/helpers/convert_datetime.php'; ?>

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

<?php foreach ($placeholder['shiftday_list'] as $shiftday) : ?>
<table class="<?php echo ($shiftday['type'])? 'literature_cart' : 'literature_table';?> <?php if ((int)$shiftday['shift_extra']):?>extra-shift<?php endif;?>">
    <thead>
        <tr>
            <th colspan="2">
                <h3>
                    <?php echo $get_weekday($shiftday['time_from']); ?>,
                    <?php echo $convert_datetime($shiftday['time_from'], 'd.m.Y'); ?> -
                    <?php if ((int)$shiftday['shift_extra']):?> Sonderschicht <?php endif;?>
                    <?php echo ($shiftday['type']) ? 'Trolley' : 'Infostand'; ?>:
                    <?php echo $shiftday['place']; ?>

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
        <?php $id_shift_day = (int)$shiftday['id_shift_day']; ?>
        <?php foreach ($placeholder['shift_list'][$id_shift_day] as $shift) : ?>

        <?php
            $id_shift = (int)$shift['id_shift'];
            $user_list = $placeholder['user_list'][$id_shift_day][$id_shift];
        ?>

        <tr>
            <td class="shift_time" id="id_shift_day_<?php echo $id_shift_day; ?>">
                <?php echo $convert_datetime($shift['time_from']); ?> -
                <?php echo $convert_datetime($shift['time_to']); ?>
            </td>
            <td>
                <form method="post">
                    <input type="hidden" name="id_shift_day" value="<?php echo $id_shift_day; ?>">
                    <input type="hidden" name="id_shift" value="<?php echo $id_shift; ?>">

                    <?php foreach ($user_list as $user) : ?>

                        <?php $user_name =  $user['firstname'] . ' ' . $user['surname']; ?>

                        <?php if((int)$user['id_user'] === $_SESSION['id_user'] && (int)$user['status'] === 0): ?>
                            <button type="submit" name="delete_user" class="enable">
                                <i class="fa fa-thumbs-o-down" aria-hidden="true"></i> <?php echo $user_name; ?>
                            </button>
                        <?php else: ?>
                            <a href="user-details.php?id_user=<?php echo $user['id_user']; ?>" class="button">
                                <i class="fa fa-info" aria-hidden="true"></i> <?php echo $user_name; ?>
                            </a>
                        <?php endif; ?>

                    <?php endforeach; ?>

                    <?php if (count($user_list) < PARTICIPANTS_PER_SHIFT) : ?>

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