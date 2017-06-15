<h2>Neuer Teilnehmer</h2>
<div class="container-center">
    <?php if (isset($placeholder['message']['error'])) : ?>
    <div class="note-box">
        <p class="error">
            <?php echo $placeholder['message']['error']; ?>
        </p>
    </div>
    <?php endif;?>
    <form method="post">
        <fieldset>
            <legend>Teilnehmer</legend>
            <div>
                <label for="firstname">Vorname <small>(Pflichtfeld)</small></label>
                <input id="firstname" type="text" name="firstname" tabindex="1" required value="<?php echo $placeholder['user']->get_firstname(); ?>">
            </div>
            <div>
                <label for="surname">Nachname <small>(Pflichtfeld)</small></label>
                <input id="surname" type="text" name="surname" tabindex="2" required value="<?php echo $placeholder['user']->get_surname(); ?>">
            </div>
            <div>
                <label for="email">E-Mail <small>(Pflichtfeld)</small></label>
                <input id="email" type="text" name="email" tabindex="3" required value="<?php echo $placeholder['user']->get_email(); ?>">
            </div>
            <div>
                <label for="username">Benutzername <small>(Pflichtfeld)</small></label>
                <input id="username" type="text" name="username" tabindex="4" required value="<?php echo $placeholder['user']->get_username(); ?>">
            </div>
            <div>
                <label for="mobile">Handynr</label>
                <input id="mobile" type="text" name="mobile" tabindex="5" value="<?php echo $placeholder['user']->get_mobile(); ?>">
            </div>
            <div>
                <label for="phone">Telefonnr</label>
                <input id="phone" type="text" name="phone" tabindex="6" value="<?php echo $placeholder['user']->get_phone(); ?>">
            </div>
            <div>
                <label for="congregation">Versammlung</label>
                <input id="congregation" type="text" name="congregation" tabindex="7" value="<?php echo $placeholder['user']->get_congregation(); ?>">
            </div>
            <div>
                <label for="language">Sprache</label>
                <input id="language" type="text" name="language" tabindex="8" value="<?php echo $placeholder['user']->get_language(); ?>">
            </div>
            <div>
                <label for="is_active">Aktiv</label>
                <input id="is_active" type="checkbox" name="is_active" tabindex="9" <?php if ($placeholder['user']->is_active()): ?> checked <?php endif; ?>>
            </div>
            <div>
                <?php $literature_table = $placeholder['user']->get_literature_table(); ?>
                <label for="literature_table">Infostand</label>
                <select id="literature_table" name="literature_table" tabindex="10">
                    <option value="<?php echo Enum\Status::INACTIVE;?>" <?php if ($literature_table == 'inactive'): ?> selected <?php endif;?>>inaktiv</option>
                    <option value="<?php echo Enum\Status::ACTIVE;?>" <?php if ($literature_table == 'active'): ?> selected <?php endif;?>>aktiv</option>
                    <option value="<?php echo Enum\Status::TRAINING;?>" <?php if ($literature_table == 'training'): ?> selected <?php endif;?>>Schulung</option>
                </select>
            </div>
            <div>
                <?php $literature_cart = $placeholder['user']->get_literature_cart(); ?>
                <label for="literature_cart">Trolley</label>
                <select id="literature_cart" name="literature_cart" tabindex="11">
                    <option value="<?php echo Enum\Status::INACTIVE;?>" <?php if ($literature_cart == 'inactive'): ?> selected <?php endif;?>>inaktiv</option>
                    <option value="<?php echo Enum\Status::ACTIVE;?>" <?php if ($literature_cart == 'active'): ?> selected <?php endif;?>>aktiv</option>
                    <option value="<?php echo Enum\Status::TRAINING;?>" <?php if ($literature_cart == 'training'): ?> 'selected <?php endif;?>>Schulung</option>
                </select>
            </div>
            <div>
                <label for="is_admin">Admin-Rechte</label>
                <input id="is_admin" type="checkbox" name="is_admin" tabindex="12" <?php if ($placeholder['user']->is_admin()): ?> checked <?php endif; ?>>
            </div>
            <div>
                <label for="note_admin">Admin Bemerkung</label>
                <textarea id="note_admin" name="note_admin" class="note" tabindex="13"><?php echo $placeholder['user']->get_note_admin();?></textarea>
            </div>

        </fieldset>
        <div class="from-button">
            <button type="submit" name="save" class="active" tabindex="15">
                <i class="fa fa-floppy-o" aria-hidden="true"></i> speichern
            </button>
            <a href="user.php" tabindex="16" class="button"><i class="fa fa-ban" aria-hidden="true"></i> abbrechen</a>
        </div>
    </form>
</div>