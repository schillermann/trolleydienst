<?php $parse_file_preview_url = include 'templates/helpers/parse_file_preview_url.php'; ?>
<h2>Infos</h2>
<?php if($_SESSION['is_admin']): ?>
<a href="info-add.php" tabindex="1" class="button active">
    <i class="fa fa-cloud-upload" aria-hidden="true"></i> Information hochladen
</a>
<?php endif; ?>
<section>
    <h3>Trolley<small> - Alle Infos, Merkblätter und Gebiete</small></h3>
    <ul class="info-list">
    <?php foreach ($placeholder['file_list'] as $file) : ?>
    <?php if((int)$file['type'] !== 1) continue; ?>
    <li>
        <a target="_blank" href="uploads/<?php echo $file['file_hash']; ?>">
            <img src="<?php echo $parse_file_preview_url('uploads/' . $file['file_hash']); ?>">
            <h4><?php echo $file['label']; ?></h4>
            <?php if ($_SESSION['is_admin']) : ?>
                <a href="info-edit.php?id_info=<?php echo $file['id_info']; ?>" class="button">bearbeiten</a>
            <?php endif; ?>
        </a>
    </li>
    <?php endforeach; ?>
    </ul>
</section>