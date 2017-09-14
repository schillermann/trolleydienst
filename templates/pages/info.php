<?php $parse_file_preview_url = include 'templates/helpers/parse_file_preview_url.php'; ?>
<h2>Info</h2>
<?php if($_SESSION['is_admin']): ?>
<a href="info-add.php" tabindex="1" class="button active">
    <i class="fa fa-cloud-upload"></i> Information hochladen
</a>
<?php endif; ?>
<section>
    <ul class="info-list">
    <?php foreach ($placeholder['file_list'] as $file) : ?>
    <li>
        <a target="_blank" href="uploads/<?php echo $file['file_name_hash']; ?>">
            <img src="<?php echo $parse_file_preview_url('uploads/' . $file['file_name_hash']); ?>">
            <h4><?php echo $file['file_label']; ?></h4>
            <?php if ($_SESSION['is_admin']) : ?>
                <a href="info-edit.php?id_info=<?php echo $file['id_info']; ?>" class="button" target="_blank">bearbeiten</a>
            <?php endif; ?>
        </a>
    </li>
    <?php endforeach; ?>
    </ul>
</section>