<h2>Teilnehmer Kontaktdaten</h2>
<div class="container-center">
    <fieldset>
        <legend><?php echo $placeholder['user']['firstname']; ?> <?php echo $placeholder['user']['lastname']; ?></legend>
        <dl>
            <dt>E-Mail</dt>
            <dd><a href="mailto:<?php echo $placeholder['user']['email'];?>?subject=Trolleydienst"><?php echo $placeholder['user']['email']; ?></a></dd>
            <dt>Handynr</dt>
            <?php if(empty($placeholder['user']['mobile'])): ?>
            <dd>fehlt</dd>
            <?php else: ?>
            <dd><a href="tel:<?php echo $placeholder['user']['mobile']; ?>"><?php echo $placeholder['user']['mobile']; ?></a></dd>
            <?php endif;?>
            <dt>Telefonnr</dt>
            <?php if(empty($placeholder['user']['phone'])): ?>
            <dd>fehlt</dd>
            <?php else: ?>
                <dd><a href="tel:<?php echo $placeholder['user']['phone']; ?>"><?php echo $placeholder['user']['phone']; ?></a></dd>
            <?php endif;?>
            <dt>Versammlung</dt>
            <dd><?php echo $placeholder['user']['congregation']; ?></dd>
            <dt>Sprache</dt>
            <dd><?php echo $placeholder['user']['language']; ?></dd>
        </dl>
    </fieldset>
    <div class="from-button">
        <a href="shift.php" class="button">
            <i class="fa fa-chevron-left" aria-hidden="true"></i> zurück
        </a>
    </div>
</div>