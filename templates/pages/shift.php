<h2>Schichten</h2>
<?php if (isset($placeholder['message'])) : ?>
    <div id="note-box" class="fade-in">
        <?php if (isset($placeholder['message']['success'])) : ?>
            <p class="success">
                <?php echo $placeholder['message']['success']; ?>
            </p>
            <button type="button" onclick="closeNoteBox()">
                <i class="fa fa-times"></i> schliessen
            </button>
        <?php elseif(isset($placeholder['message']['error'])): ?>
            <p class="error">
                <?php echo $placeholder['message']['error']; ?>
            </p>
        <?php endif; ?>
        <!--
        <button type="button">
            <i class="fa fa-undo" aria-hidden="true"></i> rückgängig
        </button>
        -->
    </div>
<?php endif; ?>
<?php if(!empty($placeholder['shift_type']['info'])): ?>
<div class="info-box">
    <p>
		<?php echo $placeholder['shift_type']['info'];?>
    </p>
</div>
<?php endif;?>
<?php if($_SESSION['is_admin']): ?>
<a href="shift-add.php?id_shift_type=<?php echo $placeholder['id_shift_type']?>" tabindex="1" class="button active">
    <i class="fa fa-plus"></i> Neue Schichten
</a>
<?php endif; ?>

<div class="table-container">
<?php foreach ($placeholder['shift_day'] as $id_shift => $shift_list) : ?>
    <table id="id_shift_<?php echo $id_shift; ?>">
        <thead>
            <tr>
                <th colspan="2" style="background-color: <?php echo $shift_list['color_hex'];?>">
                    <?php echo $shift_list['day']; ?>,
                    <?php echo $shift_list['date']; ?> -
                    <?php echo $shift_list['route']; ?>
                </th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <td colspan="2" style="background-color: <?php echo $shift_list['color_hex'];?>">
                    <p>
                        <?php if($_SESSION['is_admin']): ?>
                            <a href="shift-edit.php?id_shift_type=<?php echo $placeholder['id_shift_type']?>&id_shift=<?php echo $id_shift;?>" class="button">
                                <i class="fa fa-pencil"></i> bearbeiten
                            </a>
                        <?php endif; ?>
                    </p>
                </td>
            </tr>
        </tfoot>
        <?php $position = 1; ?>
        <tbody>
            <?php foreach ($shift_list['shifts'] as $shift_time => $user_list) : ?>

            <tr>
                <td class="shift-time">
                    <?php echo $shift_time;?>
                </td>
                <td>
                    <form method="post" action="#id_shift_<?php echo $id_shift; ?>">
                        <input type="hidden" name="id_shift" value="<?php echo $id_shift; ?>">
                        <input type="hidden" name="position" value="<?php echo $position++; ?>">
                        <?php $has_user_promoted = false;?>
                        <?php foreach ($user_list as $id_user => $name) : ?>
                            <?php $has_user_promoted = $id_user === $_SESSION['id_user'];?>

                            <?php if($has_user_promoted): ?>
                                <button name="delete_user" class="enable">
                                    <i class="fa fa-thumbs-o-up"></i> <?php echo $name; ?>
                                </button>
                            <?php else: ?>
                                <a href="user-details.php?id_shift_type=<?php echo (int)$_GET['id_shift_type'];?>&id_user=<?php echo $id_user; ?>" class="button promoted">
                                    <i class="fa fa-info"></i> <?php echo $name; ?>
                                </a>
                            <?php endif; ?>

                        <?php endforeach; ?>

                        <?php if (count($user_list) < (int)$placeholder['shift_type']['user_per_shift_max']) : ?>
                        <button name="promote_user">
                            <i class="fa fa-plus"></i> bewerben als
                        </button>
                        <select name="id_user" class="button promote">
                            <?php foreach ($placeholder['user_promote_list'] as $id_user => $name): ?>
                                <?php if($has_user_promoted && (int)$id_user === $_SESSION['id_user']) continue; ?>
                                <option value="<?php echo $id_user; ?>"><?php echo $name; ?></option>
                            <?php endforeach;?>
                        </select>
                        <?php endif; ?>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php endforeach; ?>
</div>