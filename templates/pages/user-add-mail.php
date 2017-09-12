<h2>Neuer Teilnehmer</h2>
<div class="container-center">
    <div id="note-box" class="fade-in">
        <p class="success">
            Der Teilnehmer wurde angelegt.
        </p>
        <p class="success">
            Login Daten wurden an <b><?php echo $placeholder['email']; ?></b> gesendet.
        </p>
        <table>
            <tr>
                <td>Name</td>
                <td><?php echo $placeholder['username']; ?></td>
            </tr>
            <tr>
                <td>Passwort</td>
                <td><?php echo $placeholder['password']; ?></td>
            </tr>
        </table>
    </div>
    <div class="from-button">
        <a href="user.php" class="button">
            <i class="fa fa-chevron-left" aria-hidden="true"></i> zurück
        </a>
    </div>
</div>