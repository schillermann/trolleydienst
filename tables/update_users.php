<?php
return function (\PDO $database, Models\User $user): bool {

    $stmt_user_login = $database->prepare(
        'UPDATE teilnehmer
        SET status = :active, vorname = :firstname, nachname = :surname, email = :email, username = :username,
        infostand = :literature_table, trolley = :literature_cart, admin = :admin,
        Telefonnr = :phone, Handy = :mobile, versammlung = :congregation, sprache = :language, 
        MaxSchichten = :shift_max, TeilnehmerBemerkung = :note_user, Bemerkung = :note_admin
        WHERE teilnehmernr = :id_user'
    );

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
            ':shift_max' => $user->get_shift_max(),
            ':note_user' => $user->get_note_user(),
            ':note_admin' => $user->get_note_admin(),
            ':id_user' => $user->get_id_user()
        )
    );
    return $stmt_user_login->rowCount() == 1;
};