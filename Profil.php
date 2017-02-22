<?php
$ChangePWDError = 0;
$IsPWDChanged=0;
if (isset($_POST['SaveProfil'])) {

    $stmt_update_user_data = $database_pdo->prepare(
        'UPDATE teilnehmer
	    SET vorname = :firstname,
	    nachname = :surname,
	    email = :email,
	    Telefonnr = :phone,
	    Handy = :mobil,
	    MaxSchichten = :shift_max,
        TeilnehmerBemerkung = :note_user
        WHERE teilnehmernr = :id_user'
    );

    $stmt_update_user_data->execute(
        array(
            ':firstname' => filter_var($_POST['vorname'], FILTER_SANITIZE_STRING),
            ':surname' => filter_var($_POST['nachname'], FILTER_SANITIZE_STRING),
            ':email' => (string)filter_var($_POST['email'], FILTER_VALIDATE_EMAIL),
            ':phone'  => filter_var($_POST['Telefonnr'], FILTER_SANITIZE_NUMBER_INT),
            ':mobil' => filter_var($_POST['Handy'], FILTER_SANITIZE_NUMBER_INT),
            ':shift_max' => (int)$_POST['MaxSchichten'],
            ':note_user' => filter_var($_POST['TeilnehmerBemerkung'], FILTER_SANITIZE_STRING),
            ':id_user' => (int)$_SESSION['ID']
        )
    );

	if ($stmt_update_user_data->rowCount() != 1)
        exit('Profil konnte nicht gespeichert werden!');
}

if (isset($_POST['ChangePWD'])) {
	$ChangePWDError = 0;
	if ($_POST['Passwort'] != '') {
        if ($_POST['Passwort'] != $_POST['Passwort2'])
            $ChangePWDError = 2;
    } else {
		$ChangePWDError = 1;
    }
	
	if ($ChangePWDError == 0)
	{
        $stmt_update_user_password = $database_pdo->prepare(
            'Update teilnehmer SET pwd= :password WHERE teilnehmernr = :id_user'
        );

        $stmt_update_user_password->execute(
            array(
                ':password' => md5($_POST['Passwort']),
                ':id_user' => $_SESSION['ID']
            )
        );

		if ($stmt_update_user_password->rowCount() != 1)
            exit("Profil konnte nicht gespeichert werden");

		$IsPWDChanged = 1;
	}
}

$stmt_select_user = $database_pdo->prepare(
    'SELECT vorname, nachname, email, Telefonnr, Handy, versammlung, 
    sprache, coalesce(MaxSchichten, "2") AS MaxSchichten, coalesce(TeilnehmerBemerkung, "") AS TeilnehmerBemerkung
    FROM teilnehmer
    WHERE teilnehmernr  = :id_user'
);
$stmt_select_user->execute(
    array(':id_user' => (int)$_SESSION['ID'])
);

$user_data = $stmt_select_user->fetch();

$mHTML .= '<h3>Profil</h3>';
if ($IsPWDChanged == 1)
	$mHTML .= '<p style="color: green;">Passwort wurde erfolgreich geändert.</p>';

$mHTML .=
    '<fieldset style="width:470px">
    <legend>Kontaktdaten</legend>
        <form action="index.php?Type=Profil" method="post">
            <table border=0 cellspacing=0>
                <colgroup>
                    <COL WIDTH=150>
                    <COL WIDTH=150>
                </colgroup>
                <tr>
                    <td>Vorname:</td>
                    <td><input type="Text" name="vorname" size=30 value="' . $user_data['vorname'] . '"></td>
                </tr>
                <tr>
                    <td>Nachname:</td>
                    <td><input type="Text" name="nachname" size=30 value="' . $user_data['nachname'] . '"></td>
                </tr>
                <tr>
                    <td>E-Mail:</td>
                    <td><input type="Text" name="email" size=30 value="' . $user_data['email']. '"></td>
                </tr>
                <tr>
                    <td>Telefonnr:</td>
                    <td><input type="Text" name="Telefonnr" size=30 value="' . $user_data['Telefonnr'] . '"></td>
                </tr>
                <tr>
                    <td>Handy:</td>
                    <td><input type="Text" name="Handy" size=30 value="' . $user_data['Handy'] . '"></td>
                </tr>
                <tr>
                    <td>Max Stunden/Tag:</td>
                    <td><input type="Text" name="MaxSchichten" size=5 value="' . $user_data['MaxSchichten'] . '"></td>
                </tr>
                <tr>
                    <td>Bemerkung:</td>
                    <td><textarea name="TeilnehmerBemerkung" cols="40" rows="5">' . $user_data['TeilnehmerBemerkung'] . '</textarea></td>
                </tr>
            </table>
            <input type="Submit" name="SaveProfil" value="Speichern">
        </form>
    </fieldset></br>
    <fieldset style="width:470px">
        <legend>Passwort</legend>
        <form action="index.php?Type=Profil" method="post">
            <table border=0 cellspacing=0>
                <colgroup>
                    <COL WIDTH=150>
                    <COL WIDTH=150>
                </colgroup>';
if ($ChangePWDError != 0) {
	$mHTML .= '<tr><td></td><td><font color=red>';

	if ($ChangePWDError == 1)
		$mHTML .= 'Bitte gib ein Passwort ein!';
	if ($ChangePWDError == 2)
		$mHTML .= 'Beide Passwörte stimmten nicht überein!';

	$mHTML .= '</font></td></tr>';
}
$mHTML .=
    '<tr>
    <td>neues Passwort:</td>
    <td><input type="Password" name="Passwort" size=30></td>
    </tr>
    <tr>
    <tr>
    <td>neues Passwort (wiederholen):</td>
    <td><input type="Password" name="Passwort2" size=30></td>
    </tr>
    <tr>
    </table>
    <input type="Submit" name="ChangePWD" value="Passwort ändern">
    </form></fieldset></br>';
?>