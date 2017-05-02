<?php $parse_file_preview_url = include 'templates/helpers/parse_file_preview_url.php'; ?>
<h1>Infos</h1>
<a href="info-add.php" class="button" role="button">
    Information hochladen
</a>
<section>
    <h2><?php echo CONGREGATION_NAME; ?><small> - Infos rund um die Website</small></h2>

    <?php foreach ($placeholder['file_list'][-1] as $file) : ?>
    <figure>
        <a href="uploads/<?php echo $file->get_file_name(); ?>">
            <img src="<?php echo $parse_file_preview_url('uploads/' . $file->get_file_name()); ?>" width="100%">
        </a>
        <figcaption>
            <p><?php echo $file->get_file_label(); ?></p>
            <a href="#<?php echo $file->get_id_file(); ?>" class="button">bearbeiten</a>
        </figcaption>
    </figure>
    <?php endforeach; ?>
</section>

<section>
    <h2>ÖZi<small> - Die News vom öffentlichen Zeugnisgeben</small></h2>
    <?php foreach ($placeholder['file_list'][0] as $file) : ?>
    <figure>
        <a href="uploads/<?php echo $file->get_file_name(); ?>">
            <img src="<?php echo $parse_file_preview_url('uploads/' . $file->get_file_name()); ?>" width="100%">
        </a>
        <figcaption>
            <p><?php echo $file->get_file_label(); ?></p>
            <a href="#<?php echo $file->get_id_file(); ?>" class="button">bearbeiten</a>
        </figcaption>
    </figure>
    <?php endforeach; ?>
</section>

<section>
    <h2>Trolley<small> - Alle Infos, Merkblätter und Gebiete</small></h2>
    <?php foreach ($placeholder['file_list'][1] as $file) : ?>
        <figure>
            <a href="uploads/<?php echo $file->get_file_name(); ?>">
                <img src="<?php echo $parse_file_preview_url('uploads/' . $file->get_file_name()); ?>" width="100%">
            </a>
            <figcaption>
                <p><?php echo $file->get_file_label(); ?></p>
                <a href="#<?php echo $file->get_id_file(); ?>" class="button">bearbeiten</a>
            </figcaption>
        </figure>
    <?php endforeach; ?>
</section>

<section>
    <h2>Infostand<small> - Alle Infos, Merkblätter und Gebiete</small></h2>
    <?php foreach ($placeholder['file_list'][2] as $file) : ?>
        <figure>
            <a href="uploads/<?php echo $file->get_file_name(); ?>">
                <img src="<?php echo $parse_file_preview_url('uploads/' . $file->get_file_name()); ?>" width="100%">
            </a>
            <figcaption>
                <p><?php echo $file->get_file_label(); ?></p>
                <a href="#<?php echo $file->get_id_file(); ?>" class="button">bearbeiten</a>
            </figcaption>
        </figure>
    <?php endforeach; ?>
</section>