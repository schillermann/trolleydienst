<h2>Neuer Teilnehmer</h2>
<div class="container-center">
    <form method="post">
        <fieldset>
            <legend>Teilnehmer</legend>
            <div>
                <label for="firstname">Vorname</label>
                <input id="firstname" type="text" name="firstname" tabindex="1" required>
            </div>
            <div>
                <label for="surname">Nachname</label>
                <input id="surname" type="text" name="surname" tabindex="2" required>
            </div>
            <div>
                <label for="email">E-Mail</label>
                <input id="email" type="text" name="email" tabindex="3" required>
            </div>
            <div>
                <label for="username">Benutzername</label>
                <input id="username" type="text" name="username" tabindex="4" required>
            </div>
            <div>
                <label for="mobile">Handynr</label>
                <input id="mobile" type="text" name="mobile" tabindex="5">
            </div>
            <div>
                <label for="phone">Telefonnr</label>
                <input id="phone" type="text" name="phone" tabindex="6">
            </div>
            <div>
                <label for="congregation">Versammlung</label>
                <input id="congregation" type="text" name="congregation" tabindex="7">
            </div>
            <div>
                <label for="language">Sprache</label>
                <input id="language" type="text" name="language" tabindex="8">
            </div>
            <div>
                <label for="active">Aktiv</label>
                <input id="active" type="checkbox" name="active" tabindex="9">
            </div>
            <div>
                <label for="literature_table">Infostand</label>
                <select name="literature_table" tabindex="10">
                    <option value="<?php echo \Enum\Status::INACTIVE;?>">inaktiv</option>
                    <option value="<?php echo \Enum\Status::ACTIVE;?>">aktiv</option>
                    <option value="<?php echo \Enum\Status::TRAINING;?>">Schulung</option>
                </select>
            </div>
            <div>
                <label for="literature_cart">Trolley</label>
                <select name="literature_cart" tabindex="11">
                    <option value="<?php echo \Enum\Status::INACTIVE;?>">inaktiv</option>
                    <option value="<?php echo \Enum\Status::ACTIVE;?>">aktiv</option>
                    <option value="<?php echo \Enum\Status::TRAINING;?>">Schulung</option>
                </select>
            </div>
            <div>
                <label for="admin">Admin-Rechte</label>
                <input id="admin" type="checkbox" name="admin" tabindex="12">
            </div>
            <div>
                <label for="note_admin">Admin Bemerkung</label>
                <textarea id="note_admin" name="note_admin" tabindex="13"></textarea>
            </div>

        </fieldset>
        <div class="from-button">

            <button type="submit" name="save" class="active" tabindex="15">
                <i class="fa fa-floppy-o" aria-hidden="true"></i> speichern
            </button>
            <button tabindex="16">
                <a href="user.php"><i class="fa fa-ban" aria-hidden="true"></i> abbrechen</a>
            </button>
        </div>
    </form>
</div>