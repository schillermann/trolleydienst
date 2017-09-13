<h2>Berichte</h2>
<a href="report-submit.php" class="button">
    <i class="fa fa-sticky-note-o"></i> Bericht abgeben
</a>
<div class="container-center">
	<?php if (isset($placeholder['message'])) : ?>
        <div id="note-box" class="fade-in">
			<?php if (isset($placeholder['message']['success'])): ?>
                <p class="success">
					<?php echo $placeholder['message']['success'];?>
                </p>
			<?php elseif (isset($placeholder['message']['error'])): ?>
                <p class="error">
					<?php echo $placeholder['message']['error'];?>
                </p>
			<?php endif; ?>
            <button type="button" onclick="closeNoteBox()">
                <i class="fa fa-times"></i> schliessen
            </button>
        </div>
	<?php endif; ?>
    <form method="post">
        <label for="id_shift_type">Schichtart</label>
        <select id="id_shift_type" name="id_shift_type">
			<?php foreach($placeholder['shifttype_list'] as $shifttype): ?>
                <option value="<?php echo $shifttype['id_shift_type'];?>" <?php echo (isset($_POST['id_shift_type']) && $_POST['id_shift_type'] == $shifttype['id_shift_type'])? 'selected':'';?>>
					<?php echo $shifttype['name'];?>
                </option>
			<?php endforeach;?>
        </select>
        <label for="report_from">von:</label>
        <input id="report_from" name="report_from" type="date" value="<?php echo $placeholder['report_from'];?>">
        <label for="report_to">bis:</label>
        <input id="report_to" name="report_to" type="date" value="<?php echo $placeholder['report_to'];?>">
        <button name="filter" class="active" tabindex="14">
            <i class="fa fa-search"></i> filtern
        </button>
    </form>
	<div class="table-container">
        <?php foreach ($placeholder['report_list'] as $id_report => $report): ?>
            <table>
                <thead>
                    <tr>
                        <th colspan="2" style="background-color: #d5c8e4">
							<?php echo $report['day'];?>, <?php echo $report['datetime'];?> - <?php echo $report['name'];?> - <?php echo $report['route'];?>
                            <a href="report.php?id_report=<?php echo $id_report;?>" class="button warning">
                                <i class="fa fa-trash-o"></i> löschen
                            </a>
                        </th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <td colspan="2" style="background-color: #d5c8e4"></td>
                    </tr>
                </tfoot>
                <tbody>
                    <?php if($report['book'] > 0): ?>
                    <tr>
                        <td>
                            Bücher
                        </td>
                        <td>
                            <?php echo $report['book'];?>
                        </td>
                    </tr>
                    <?php endif;?>
                    <?php if($report['brochure'] > 0): ?>
                    <tr>
                        <td>
                            Broschüren
                        </td>
                        <td>
                            <?php echo $report['brochure'];?>
                        </td>
                    </tr>
                    <?php endif;?>
                    <?php if($report['bible'] > 0): ?>
                    <tr>
                        <td>
                            Bibel
                        </td>
                        <td>
                            <?php echo $report['bible'];?>
                        </td>
                    </tr>
                    <?php endif;?>
                    <?php if($report['magazine'] > 0): ?>
                    <tr>
                        <td>
                            Zeitschriften
                        </td>
                        <td>
                            <?php echo $report['magazine'];?>
                        </td>
                    </tr>
                    <?php endif;?>
                    <?php if($report['tract'] > 0): ?>
                    <tr>
                        <td>
                            Traktate
                        </td>
                        <td>
                            <?php echo $report['tract'];?>
                        </td>
                    </tr>
                    <?php endif;?>
                    <?php if($report['address'] > 0): ?>
                    <tr>
                        <td>
                            Adressen
                        </td>
                        <td>
                            <?php echo $report['address'];?>
                        </td>
                    </tr>
                    <?php endif;?>
                    <?php if($report['talk'] > 0): ?>
                    <tr>
                        <td>
                            Gespräche
                        </td>
                        <td>
                            <?php echo $report['talk'];?>
                        </td>
                    </tr>
                    <?php endif;?>
                    <?php if(!empty($report['note'])): ?>
                    <tr>
                        <td>
                            Bemerkung
                        </td>
                        <td>
                            <?php echo $report['note'];?>
                        </td>
                    </tr>
                    <?php endif;?>
                </tbody>
            </table>
        <?php endforeach;?>
	</div>
</div>