<?php
namespace Tables;

class Users {

    static function select_all_without_user(\PDO $connection, int $id_user): array {
        $stmt = $connection->prepare(
            'SELECT teilnehmernr AS id_user, vorname AS firstname, nachname AS surname, infostand AS literature_table, trolley AS literature_cart
            FROM teilnehmer
            WHERE teilnehmernr <> :id_user
            AND status = 0');

        $stmt->execute(
            array(':id_user' => $id_user)
        );
        $result = $stmt->fetchAll();
        return ($result === false)? array() : $result;
    }

    static function select_user_by_id_user(\PDO $connection, int $id_user): array {

        $stmt = $connection->prepare(
            'SELECT status AS active, vorname AS firstname, nachname AS surname, email, username,
        infostand AS literature_table, trolley AS literature_cart, admin AS is_admin, Telefonnr AS phone,
        Handy AS mobile, versammlung AS congregation, sprache AS language, MaxSchichten AS shift_max, Bemerkung AS note_admin, TeilnehmerBemerkung AS note_user
        FROM teilnehmer
        WHERE teilnehmernr = :id_user'
        );

        $stmt->execute(
            array(':id_user' => $id_user)
        );
        $result = $stmt->fetch();
        return ($result === false)? array() : $result;
    }

    static function select_profile_by_id_user(\PDO $connection, int $id_user): array {

        $stmt = $connection->prepare(
            'SELECT vorname AS firstname, nachname AS surname, email, username,
            Telefonnr AS phone,
            Handy AS mobile, versammlung AS congregation, sprache AS language, MaxSchichten AS shift_max, TeilnehmerBemerkung AS note_user
            FROM teilnehmer
            WHERE teilnehmernr = :id_user'
        );

        $stmt->execute(
            array(':id_user' => $id_user)
        );
        $result = $stmt->fetch();
        return ($result === false)? array() : $result;
    }

    static function select_firstname_and_surname_by_id_user(\PDO $connection, int $id_user): array {
        $stmt = $connection->prepare(
            'SELECT vorname AS firstname, nachname AS surname
            FROM teilnehmer
            WHERE teilnehmernr = :id_user'
        );

        $stmt->execute(
            array(':id_user' => $id_user)
        );
        $result = $stmt->fetch();
        return ($result === false)? array() : $result;
    }

    static function select_logindata_by_username_and_password(\PDO $connection, string $username, string $password): array {
        $stmt = $connection->prepare(
            'SELECT teilnehmernr AS id_user, vorname AS firstname, nachname AS surname,
            email, infostand AS literature_table, trolley AS literature_cart, admin AS is_admin
            FROM teilnehmer
            WHERE username = :username
            AND pwd = :password'
        );

        $stmt->execute(
            array(
                ':username' => $username,
                ':password' => md5($password)
            )
        );
        $result = $stmt->fetch();
        return ($result === false)? array() : $result;
    }

    static function update_login_time_by_id_user(\PDO $connection, int $id_user): bool {
        $stmt = $connection->prepare(
            'UPDATE
              teilnehmer
            SET
              LastLoginTime = NOW()
            WHERE
              teilnehmernr = :id_user'
        );

        $stmt->execute(
            array(':id_user' => $id_user)
        );

        return $stmt->rowCount() == 1;
    }

    static function update_profile_by_id_user(\PDO $connection, \Models\Profile $profile): bool {
        $stmt = $connection->prepare(
            'UPDATE teilnehmer
            SET vorname = :firstname, nachname = :surname, email = :email, username = :username,
            Telefonnr = :phone, Handy = :mobile, versammlung = :congregation, sprache = :language, 
            MaxSchichten = :shift_max, TeilnehmerBemerkung = :note_user
            WHERE teilnehmernr = :id_user'
        );

        $stmt->execute(
            array(
                ':firstname' => $profile->get_firstname(),
                ':surname' => $profile->get_surname(),
                ':email' => $profile->get_email(),
                ':username' => $profile->get_username(),
                ':phone' => $profile->get_phone(),
                ':mobile' => $profile->get_mobile(),
                ':congregation' => $profile->get_congregation(),
                ':language' => $profile->get_language(),
                ':shift_max' => $profile->get_shift_max(),
                ':note_user' => $profile->get_note_user(),
                ':id_user' => $profile->get_id_user()
            )
        );
        return $stmt->rowCount() == 1;
    }

    static function update_password_by_id_user(\PDO $connection, int $id_user, string $password): bool {
        $stmt = $connection->prepare(
            'UPDATE teilnehmer
        SET pwd= :password
        WHERE teilnehmernr = :id_user'
        );

        $stmt->execute(
            array(
                ':password' => md5($password),
                ':id_user' => $id_user
            )
        );
        return $stmt->rowCount() == 1;
    }
}