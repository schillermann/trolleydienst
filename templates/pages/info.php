<?php $get_file_icon_uri = include 'templates/helpers/get_file_icon_uri.php'; ?>

<header>
    <h2>Info</h2>
</header>

<?php if($_SESSION['is_admin']): ?>
    <nav id="nav-sub">
        <a href="info-add.php" tabindex="1" class="button active">
            <i class="fa fa-cloud-upload"></i> Datei hochladen
        </a>
    </nav>
<?php endif; ?>
<div>
    <ul class="info-list">
    <?php foreach ($placeholder['file_list'] as $file) : ?>
    <li>
        <a target="_blank" href="info-file.php?id_info=<?php echo $file['id_info'];?>">
            <img src="<?php echo $get_file_icon_uri($file['mime_type']);?>">
            <h4><?php echo $file['label']; ?></h4>
            <?php if ($_SESSION['is_admin']) : ?>
                <a href="info-edit.php?id_info=<?php echo $file['id_info']; ?>" class="button" target="_blank">bearbeiten</a>
            <?php endif; ?>
        </a>
    </li>
    <?php endforeach; ?>
    </ul>
</div>