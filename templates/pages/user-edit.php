<?php
    $literature_table_inactive = '';
    $literature_table_active = '';
    $literature_table_training = '';

    if($placeholder['user']->get_literature_table() == \Enum\Status::ACTIVE)
        $literature_table_active = 'selected';
    elseif ($placeholder['user']->get_literature_table() == \Enum\Status::TRAINING)
        $literature_table_training = 'selected';
    else
        $literature_table_inactive = 'selected';

    $literature_cart_inactive = '';
    $literature_cart_active = '';
    $literature_cart_training = '';

    if($placeholder['user']->get_literature_cart() == \Enum\Status::ACTIVE)
        $literature_cart_active = 'selected';
    elseif ($placeholder['user']->get_literature_cart() == \Enum\Status::TRAINING)
        $literature_cart_training = 'selected';
    else
        $literature_cart_inactive = 'selected';
?>
<h2>Teilnehmer bearbeiten</h2>
<div class="container-center">
    <?php if (isset($placeholder['update_user'])) : ?>
    <div class="note-box">
        <?php if ($placeholder['update_user']): ?>
            <p class="success">
                Die Teilnehmer Daten wurde geändert.
            </p>
        <?php else: ?>
            <p class="error">
                Die Teilnehmer Daten konnten nicht geändert werden!
            </p>
        <?php endif; ?>
    </div>
    <?php endif; ?>
    <form method="post">
        <fieldset>
            <legend>Teilnehmer</legend>
            <div>
                <label for="firstname">Vorname</label>
                <input id="firstname" type="text" name="firstname" tabindex="1" required value="<?php echo $placeholder['user']->get_firstname();?>">
            </div>
            <div>
                <label for="surname">Nachname</label>
                <input id="surname" type="text" name="surname" tabindex="2" required value="<?php echo $placeholder['user']->get_surname();?>">
            </div>
            <div>
                <label for="email">E-Mail</label>
                <input id="email" type="text" name="email" tabindex="3" required value="<?php echo $placeholder['user']->get_email();?>">
            </div>
            <div>
                <label for="username">Benutzername</label>
                <input id="username" type="text" name="username" tabindex="4" required value="<?php echo $placeholder['user']->get_username();?>">
            </div>
            <div>
                <label for="mobile">Handynr</label>
                <input id="mobile" type="text" name="mobile" tabindex="5" value="<?php echo $placeholder['user']->get_mobile();?>">
            </div>
            <div>
                <label for="phone">Telefonnr</label>
                <input id="phone" type="text" name="phone" tabindex="6" value="<?php echo $placeholder['user']->get_phone();?>">
            </div>
            <div>
                <label for="congregation">Versammlung</label>
                <input id="congregation" type="text" name="congregation" tabindex="7" value="<?php echo $placeholder['user']->get_congregation();?>">
            </div>
            <div>
                <label for="language">Sprache</label>
                <input id="language" type="text" name="language" tabindex="8" value="<?php echo $placeholder['user']->get_language();?>">
            </div>
            <div>
                <label for="active">Aktiv</label>
                <input id="active" type="checkbox" name="active" tabindex="9" <?php echo ($placeholder['user']->is_active()) ? 'checked' : '';?>>
            </div>
            <div>
                <label for="literature_table">Infostand</label>
                <select name="literature_table" tabindex="10">
                    <option value="<?php echo \Enum\Status::INACTIVE;?>" <?php echo $literature_table_inactive;?>>inaktiv</option>
                    <option value="<?php echo \Enum\Status::ACTIVE;?>" <?php echo $literature_table_active;?>>aktiv</option>
                    <option value="<?php echo \Enum\Status::TRAINING;?>" <?php echo $literature_table_training;?>>Schulung</option>
                </select>
            </div>
            <div>
                <label for="literature_cart">Trolley</label>
                <select name="literature_cart" tabindex="11">
                    <option value="<?php echo \Enum\Status::INACTIVE;?>" <?php echo $literature_cart_inactive;?>>inaktiv</option>
                    <option value="<?php echo \Enum\Status::ACTIVE;?>" <?php echo $literature_cart_active;?>>aktiv</option>
                    <option value="<?php echo \Enum\Status::TRAINING;?>" <?php echo $literature_cart_training;?>>Schulung</option>
                </select>
            </div>
            <div>
                <label for="admin">Admin-Rechte</label>
                <input id="admin" type="checkbox" name="admin" tabindex="12" <?php echo ($placeholder['user']->is_admin()) ? 'checked' : '';?>>
            </div>
            <div>
                <label for="note_admin">Admin Bemerkung</label>
                <textarea id="note_admin" name="note_admin" tabindex="13"><?php echo $placeholder['user']->get_note_admin();?></textarea>
            </div>

            <div>
                <label for="note_user">Teilnehmer Bemerkung</label>
                <textarea id="note_user" name="note_user" tabindex="14" disabled><?php echo $placeholder['user']->get_note_user();?></textarea>
            </div>

        </fieldset>
        <div class="from-button">

            <button type="submit" name="save" class="active" tabindex="15">
                <i class="fa fa-floppy-o" aria-hidden="true"></i> speichern
            </button>
            <button onClick="location.href='user.php'" type="button" tabindex="16">
                <i class="fa fa-ban" aria-hidden="true"></i> abbrechen
            </button>
            <button type="submit" name="delete" class="warning" tabindex="17">
                <i class="fa fa-trash-o" aria-hidden="true"></i> löschen
            </button>

        </div>
    </form>
</div>