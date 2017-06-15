<h2>Teilnehmer Kontaktdaten</h2>
<div class="container-center">
    <fieldset>
        <legend><?php echo $placeholder['user']->get_firstname(); ?> <?php echo $placeholder['user']->get_surname(); ?></legend>
        <dl>
            <dt>E-Mail</dt>
            <dd><a href="mailto:<?php echo $placeholder['user']->get_email();?>?subject=Trolleydienst"><?php echo $placeholder['user']->get_email(); ?></a></dd>
            <dt>Handynr</dt>
            <?php if(empty($placeholder['user']->get_mobile())): ?>
            <dd>fehlt</dd>
            <?php else: ?>
            <dd><a href="tel:<?php echo $placeholder['user']->get_mobile(); ?>"><?php echo $placeholder['user']->get_mobile(); ?></a></dd>
            <?php endif;?>
            <dt>Telefonnr</dt>
            <?php if(empty($placeholder['user']->get_phone())): ?>
            <dd>fehlt</dd>
            <?php else: ?>
                <dd><a href="tel:<?php echo $placeholder['user']->get_phone(); ?>"><?php echo $placeholder['user']->get_phone(); ?></a></dd>
            <?php endif;?>
            <dt>Versammlung</dt>
            <dd><?php echo $placeholder['user']->get_congregation(); ?></dd>
            <dt>Sprache</dt>
            <dd><?php echo $placeholder['user']->get_language(); ?></dd>
        </dl>
    </fieldset>
    <div class="from-button">
        <a href="shift.php" class="button">
            <i class="fa fa-chevron-left" aria-hidden="true"></i> zurück
        </a>
    </div>
</div>