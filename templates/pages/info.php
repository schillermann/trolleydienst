<?php $parse_file_preview_url = include 'templates/helpers/parse_file_preview_url.php'; ?>
<h2>Infos</h2>
<?php if($_SESSION['role'] == Enum\UserRole::ADMIN): ?>
<a href="info-add.php" tabindex="1" class="button active">
    <i class="fa fa-cloud-upload" aria-hidden="true"></i> Information hochladen
</a>
<?php endif; ?>
<section>
    <h2><?php echo CONGREGATION_NAME; ?><small> - Infos rund um die Website</small></h2>

    <?php foreach ($placeholder['file_list'][-1] as $file) : ?>
    <figure>
        <a target="_blank" href="uploads/<?php echo $file->get_file_hash(); ?>">
            <img src="<?php echo $parse_file_preview_url('uploads/' . $file->get_file_hash()); ?>" width="100%">
        </a>
        <figcaption>
            <p><?php echo $file->get_file_label(); ?></p>
            <?php if ($_SESSION['role'] == Enum\UserRole::ADMIN) : ?>
            <a href="info-edit.php?id_file=<?php echo $file->get_id_file(); ?>" class="button">bearbeiten</a>
            <?php endif; ?>
        </figcaption>
    </figure>
    <?php endforeach; ?>
</section>

<section>
    <h2>ÖZi<small> - Die News vom öffentlichen Zeugnisgeben</small></h2>
    <?php foreach ($placeholder['file_list'][0] as $file) : ?>
    <figure>
        <a target="_blank" href="uploads/<?php echo $file->get_file_hash(); ?>">
            <img src="<?php echo $parse_file_preview_url('uploads/' . $file->get_file_hash()); ?>" width="100%">
        </a>
        <figcaption>
            <p><?php echo $file->get_file_label(); ?></p>
            <?php if ($_SESSION['role'] == Enum\UserRole::ADMIN) : ?>
            <a href="info-edit.php?id_file=<?php echo $file->get_id_file(); ?>" class="button">bearbeiten</a>
            <?php endif; ?>
        </figcaption>
    </figure>
    <?php endforeach; ?>
</section>

<section>
    <h2>Trolley<small> - Alle Infos, Merkblätter und Gebiete</small></h2>
    <?php foreach ($placeholder['file_list'][1] as $file) : ?>
        <figure>
            <a target="_blank" href="uploads/<?php echo $file->get_file_hash(); ?>">
                <img src="<?php echo $parse_file_preview_url('uploads/' . $file->get_file_hash()); ?>" width="100%">
            </a>
            <figcaption>
                <p><?php echo $file->get_file_label(); ?></p>
                <?php if ($_SESSION['role'] == Enum\UserRole::ADMIN) : ?>
                <a href="info-edit.php?id_file=<?php echo $file->get_id_file(); ?>" class="button">bearbeiten</a>
                <?php endif; ?>
            </figcaption>
        </figure>
    <?php endforeach; ?>
</section>

<section>
    <h2>Infostand<small> - Alle Infos, Merkblätter und Gebiete</small></h2>
    <?php foreach ($placeholder['file_list'][2] as $file) : ?>
        <figure>
            <a target="_blank" href="uploads/<?php echo $file->get_file_hash(); ?>">
                <img src="<?php echo $parse_file_preview_url('uploads/' . $file->get_file_hash()); ?>" width="100%">
            </a>
            <figcaption>
                <p><?php echo $file->get_file_label(); ?></p>
                <?php if ($_SESSION['role'] == Enum\UserRole::ADMIN) : ?>
                <a href="#<?php echo $file->get_id_file(); ?>" class="button">bearbeiten</a>
                <?php endif; ?>
            </figcaption>
        </figure>
    <?php endforeach; ?>
</section>