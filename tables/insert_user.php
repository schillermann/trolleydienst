<?php
return function (\PDO $database, Models\User $user): bool {

    $stmt_user_login = $database->prepare(
        'INSERT INTO teilnehmer
        (status, vorname, nachname, email, username, infostand, trolley, admin, Telefonnr, Handy, versammlung, sprache, Bemerkung)
        VALUES (:active, :firstname, :surname, :email, :username, :literature_table, :literature_cart, :admin, :phone, :mobile, :congregation, :language, :note_admin)'
    );
//TODO: User ID muss vorher ermittelt werden
    $user_id = 1;

    $stmt_user_login->execute(
        array(
            ':active' => (int)!$user->is_active(),
            ':firstname' => $user->get_firstname(),
            ':surname' => $user->get_surname(),
            ':email' => $user->get_email(),
            ':username' => $user->get_username(),
            ':literature_table' => \Enum\Status::convert_to_id_status($user->get_literature_table()),
            ':literature_cart' => \Enum\Status::convert_to_id_status($user->get_literature_cart()),
            ':admin' => (int)$user->is_admin(),
            ':phone' => $user->get_phone(),
            ':mobile' => $user->get_mobile(),
            ':congregation' => $user->get_congregation(),
            ':language' => $user->get_language(),
            ':note_admin' => $user->get_note_admin(),
            ':id_user' => $user_id
        )
    );
    return $stmt_user_login->rowCount() == 1;
};