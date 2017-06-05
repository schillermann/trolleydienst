<h2>Neuer Teilnehmer</h2>
<div class="container-center">
    <div class="note-box">
        <p class="success">
            Der Teilnehmer wurde angelegt.
        </p>
    </div>
</div>
<div class="container-center">
    <div class="note-box">
        <p class="success">
            Login Daten wurden an <b><?php echo $placeholder['user']->get_email(); ?></b> gesendet.
        </p>
        <table>
            <tr>
                <td>Benutzername</td>
                <td><?php echo $placeholder['user']->get_username(); ?></td>
            </tr>
            <tr>
                <td>Passwort</td>
                <td><?php echo $placeholder['user']->get_password(); ?></td>
            </tr>
        </table>
    </div>
    <div class="from-button">
        <a href="user.php" class="button">
            <i class="fa fa-chevron-left" aria-hidden="true"></i> zurück
        </a>
    </div>
</div>