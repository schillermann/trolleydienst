<?php
return function (\PDO $database, Models\User $user): bool {

    $stmt_user_login = $database->prepare(
        'UPDATE teilnehmer
        SET vorname = :firstname, nachname = :surname, email = :email,
        Telefonnr = :phone, Handy = :mobile, MaxSchichten = :shift_max, TeilnehmerBemerkung = :note
        WHERE teilnehmernr = :id_user'
    );

    $stmt_user_login->execute(
        array(
            ':firstname' => $user->get_firstname(),
            ':surname' => $user->get_surname(),
            ':email' => $user->get_email(),
            ':phone' => $user->get_phone(),
            ':mobile' => $user->get_mobile(),
            ':shift_max' => $user->get_shift_max(),
            ':note' => $user->get_note(),
            ':id_user' => $user->get_id_user(),
        )
    );
    return $stmt_user_login->rowCount() == 1;
};