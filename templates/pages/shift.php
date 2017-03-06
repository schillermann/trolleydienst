<?php $get_weekday = include 'templates/helpers/get_weekday.php'; ?>
<div id="content-apps">
    <h3 class="Title_Middle">Schichten</h3>
    <div class="div_Legende">
        <table>
            <colgroup>
                <COL width="60">
                <COL width="20">
                <COL width="60">
                <COL width="20">
                <COL width="60">
                <COL width="20">
                <COL width="60">
            </colgroup>
            <tr>
                <td class="Legende">Legende:</td>
                <td class="Teilnehmer_Status0_Legende">??</td>
                <td class="Legende">beworben</td>
                <td class="Teilnehmer_Status2_Legende"></td>
                <td class="Legende">bestätigt</td>
                <td class="Teilnehmer_Schichtleiter_Legende">SL</td>
                <td class="Legende">Schichtleiter</td>
            </tr>
        </table>
    </div>

    <?php foreach ($placeholder['schedule_list'] as $schedule) : ?>
    <table>
        <thead>
            <tr>
                <th colspan="2" style="background-color: #B3A2C7;">
                    <?php echo $get_weekday($schedule->get_datetime_from()); ?>,
                    <?php echo $schedule->get_datetime_from()->format('d.m.Y'); ?>
                    <?php echo ($schedule->get_type() == 0) ? 'Infostand' : 'Trolley'; ?>:
                    <?php echo $schedule->get_place(); ?>
                </th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <td colspan="2" style="background-color: brown;">Fuß</td>
            </tr>
        </tfoot>
        <tbody>
            <?php foreach ($schedule->get_iterator_shift() as $shift) : ?>
            <tr>
                <td id="id_schedule_<?php echo $schedule->get_schedule_id(); ?>_id_shift_<?php echo $shift->get_id_shift(); ?>" style="background-color: #5F497A;">
                    <?php echo $shift->get_datetime_from()->format('H:i'); ?> -
                    <?php echo $shift->get_datetime_to()->format('H:i'); ?>
                </td>
                <td style="background-color: #0070C0">
                    <?php foreach ($shift->get_iterator_user() as $shift_user) : ?>

                        <?php $user_name =  $shift_user->get_firstname() . ' ' . $shift_user->get_surname(); ?>

                        <?php if($shift_user->get_id_user() === $_SESSION['id_user'] && $shift_user->get_status() === 0): ?>
                            <a href="shift-user-remove.php?id_schedule=<?php echo $shift->get_id_schedule(); ?>&id_shift=<?php echo $shift->get_id_shift(); ?>" role="button">
                                <?php echo $user_name; ?>
                                <img src="images/Nein.png">
                            </a>
                        <?php else: ?>
                            <a href="tel:<?php echo $shift_user->get_mobile(); ?>" role="button">
                                <?php echo $user_name; ?>
                            </a>
                        <?php endif; ?>

                    <?php endforeach; ?>
                    <?php if ($shift->count() < 2) : ?>
                    <a href="shift-user-advertise.php?id_schedule=<?php echo $shift->get_id_schedule(); ?>&id_shift=<?php echo $shift->get_id_shift(); ?>" class="button" role="button">
                        bewerben
                    </a>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php endforeach; ?>

</div>