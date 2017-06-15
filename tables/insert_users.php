<?php
return function (\PDO $database, Models\User $user): bool {

    $stmt_user_next_id = $database->query('SELECT coalesce(Max(teilnehmernr), 0) + 1 AS teilnehmernr FROM teilnehmer');
    $user_id = (int)$stmt_user_next_id->fetchColumn();

    $stmt_user_login = $database->prepare(
        'INSERT INTO teilnehmer
        (teilnehmernr, status, vorname, nachname, email, username, pwd, infostand, trolley, admin, Telefonnr, Handy, versammlung, sprache, Bemerkung)
        VALUES (:id_user, :active, :firstname, :surname, :email, :username, :password, :literature_table, :literature_cart, :admin, :phone, :mobile, :congregation, :language, :note_admin)'
    );

    $stmt_user_login->execute(
        array(
            ':id_user' => $user_id,
            ':active' => (int)!$user->is_active(),
            ':firstname' => $user->get_firstname(),
            ':surname' => $user->get_surname(),
            ':email' => $user->get_email(),
            ':username' => $user->get_username(),
            ':password' => md5($user->get_password()),
            ':literature_table' => \Enum\Status::convert_to_id_status($user->get_literature_table()),
            ':literature_cart' => \Enum\Status::convert_to_id_status($user->get_literature_cart()),
            ':admin' => (int)$user->is_admin(),
            ':phone' => $user->get_phone(),
            ':mobile' => $user->get_mobile(),
            ':congregation' => $user->get_congregation(),
            ':language' => $user->get_language(),
            ':note_admin' => $user->get_note_admin()
        )
    );
    return $stmt_user_login->rowCount() == 1;
};