<?php
namespace Tables;

class Users {

    const TABLE_NAME = 'users';
    
    static function is_table(\PDO $connection) {
        return ($connection->exec("SELECT 1 FROM " . self::TABLE_NAME) === false)? false : true;
    }

    static function create_table(\PDO $connection): bool {

        $sql =
            'CREATE TABLE `' . self::TABLE_NAME . '` (
            `id_user` INTEGER PRIMARY KEY AUTOINCREMENT,
            `firstname` TEXT NOT NULL,
            `lastname` TEXT NOT NULL,
            `email` TEXT NOT NULL,
            `username` TEXT NOT NULL,
            `password` TEXT NOT NULL,
            `is_active` INTEGER DEFAULT 1,
            `is_admin` INTEGER DEFAULT 0,
            `is_literature_cart` INTEGER DEFAULT 1,
            `is_literature_table` INTEGER DEFAULT 1,
            `phone` TEXT DEFAULT NULL,
            `mobile` TEXT DEFAULT NULL,
            `congregation` TEXT DEFAULT NULL,
            `language` TEXT DEFAULT NULL,
            `note_user` TEXT NULL,
            `note_admin` TEXT NULL,
            `last_login` TEXT DEFAULT NULL)';

        return ($connection->exec($sql) === false)? false : true;
    }

    static function is_username(\PDO $connection, string $username): bool {
        $stmt = $connection->prepare(
            'SELECT username FROM users WHERE username = :username'
        );

        $stmt->execute(
            array(':username' => $username)
        );
        return (bool)$stmt->rowCount();
    }

    static function select_all(\PDO $connection): array {
        $stmt = $connection->query(
            'SELECT id_user, firstname, lastname, email,
            username, is_admin, is_active, is_literature_table, is_literature_cart 
            FROM users'
        );
        $result = $stmt->fetchAll();
        return ($result === false)? array() : $result;
    }

    static function select_all_email(\PDO $connection, string $recipient): array {
        $literature_table = 'AND literature_table = 1';
        $literature_cart = 'AND literature_cart = 1';

        if($recipient == \Enum\Recipient::LITERATURE_TABLE)
            $literature_cart = '';
        elseif ($recipient == \Enum\Recipient::LITERATURE_CART)
            $literature_table = '';

        $stmt = $connection->query(
            'SELECT firstname, lastname, email FROM users WHERE is_active = 1 ' .
            $literature_table .
            $literature_cart
        );

        $result = $stmt->fetchAll();
        return ($result === false)? array() : $result;
    }

    static function select_all_without_user(\PDO $connection, int $id_user): array {
        $stmt = $connection->prepare(
            'SELECT id_user, firstname, lastname, is_literature_table, is_literature_cart
            FROM ' . self::TABLE_NAME . '
            WHERE id_user <> :id_user
            AND is_active = 1');

        $stmt->execute(
            array(':id_user' => $id_user)
        );
        $result = $stmt->fetchAll();
        return ($result === false)? array() : $result;
    }

    static function select_user(\PDO $connection, int $id_user): array {

        $stmt = $connection->prepare(
            'SELECT firstname, lastname, email, username, is_active, is_admin, is_literature_table,
            is_literature_cart, phone, mobile, congregation, language, note_admin, note_user
            FROM ' . self::TABLE_NAME . '
            WHERE id_user = :id_user'
        );

        $stmt->execute(
            array(':id_user' => $id_user)
        );
        $result = $stmt->fetch();
        return ($result === false)? array() : $result;
    }

    static function select_id_user(\PDO $connection, string $username, string $email): int {
        $stmt = $connection->prepare(
            'SELECT id_user
        FROM users
        WHERE username = :username
        AND email = :email'
        );

        $stmt->execute(
            array(
                ':username' => $username,
                ':email' => $email
            )
        );
        $result = $user_id = $stmt->fetchColumn();

        return ($result === false)? 0 : $result;
    }

    static function select_profile(\PDO $connection, int $id_user): array {

        $stmt = $connection->prepare(
            'SELECT firstname, lastname, email, username, phone, mobile, congregation, language, note_user
            FROM ' . self::TABLE_NAME . '
            WHERE id_user = :id_user'
        );

        $stmt->execute(
            array(':id_user' => $id_user)
        );
        $result = $stmt->fetch();
        return ($result === false)? array() : $result;
    }

    static function select_firstname_and_lastname(\PDO $connection, int $id_user): array {
        $stmt = $connection->prepare(
            'SELECT firstname, lastname
            FROM ' . self::TABLE_NAME . '
            WHERE id_user = :id_user'
        );

        $stmt->execute(
            array(':id_user' => $id_user)
        );
        $result = $stmt->fetch();
        return ($result === false)? array() : $result;
    }

    static function select_logindata(\PDO $connection, string $username, string $password): array {
        $stmt = $connection->prepare(
            'SELECT id_user, firstname, lastname,
            email, is_literature_table, is_literature_cart, is_admin
            FROM ' . self::TABLE_NAME . '
            WHERE is_active = 1
            AND username = :username
            AND password = :password'
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

    static function update_login_time(\PDO $connection, int $id_user): bool {
        $stmt = $connection->prepare(
            'UPDATE ' . self::TABLE_NAME . '
            SET last_login = "' . date('Y-m-d H:i:s') . '"
            WHERE id_user = :id_user'
        );

        $stmt->execute(
            array(':id_user' => $id_user)
        );

        return $stmt->rowCount() == 1;
    }

    static function update_profile(\PDO $connection, \Models\Profile $profile): bool {
        $stmt = $connection->prepare(
            'UPDATE ' . self::TABLE_NAME . '
            SET firstname = :firstname, lastname = :lastname, email = :email, username = :username,
            phone = :phone, mobile = :mobile, congregation = :congregation, language = :language, 
            note_user = :note_user
            WHERE id_user = :id_user'
        );

        $stmt->execute(
            array(
                ':firstname' => $profile->get_firstname(),
                ':lastname' => $profile->get_lastname(),
                ':email' => $profile->get_email(),
                ':username' => $profile->get_username(),
                ':phone' => $profile->get_phone(),
                ':mobile' => $profile->get_mobile(),
                ':congregation' => $profile->get_congregation(),
                ':language' => $profile->get_language(),
                ':note_user' => $profile->get_note_user(),
                ':id_user' => $profile->get_id_user()
            )
        );
        return $stmt->rowCount() == 1;
    }

    static function update_user(\PDO $connection, \Models\User $user): bool {
        $stmt = $connection->prepare(
            'UPDATE users
        SET firstname = :firstname, lastname = :lastname, email = :email, username = :username,
        is_active = :is_active, is_admin = :is_admin, is_literature_table = :is_literature_table,
        is_literature_cart = :is_literature_cart, phone = :phone, mobile = :mobile,
        congregation = :congregation, language = :language, note_admin = :note_admin
        WHERE id_user = :id_user'
        );

        $stmt->execute(
            array(
                ':firstname' => $user->get_firstname(),
                ':lastname' => $user->get_lastname(),
                ':email' => $user->get_email(),
                ':username' => $user->get_username(),
                ':is_active' => (int)$user->is_active(),
                ':is_admin' => (int)$user->is_admin(),
                ':is_literature_table' => (int)$user->is_literature_table(),
                ':is_literature_cart' => (int)$user->is_literature_cart(),
                ':phone' => $user->get_phone(),
                ':mobile' => $user->get_mobile(),
                ':congregation' => $user->get_congregation(),
                ':language' => $user->get_language(),
                ':note_admin' => $user->get_note_admin(),
                ':id_user' => $user->get_id_user()
            )
        );

        return $stmt->rowCount() == 1;
    }

    static function update_password(\PDO $connection, int $id_user, string $password): bool {
        $stmt = $connection->prepare(
            'UPDATE ' . self::TABLE_NAME . '
            SET password = :password
            WHERE id_user = :id_user'
        );

        $stmt->execute(
            array(
                ':password' => md5($password),
                ':id_user' => $id_user
            )
        );
        return $stmt->rowCount() == 1;
    }

    static function insert(\PDO $connection, \Models\User $user): bool {

        $stmt = $connection->prepare(
            'INSERT INTO users
            (
                firstname, lastname, email, username, password, is_admin, is_active, is_literature_table,
                is_literature_cart, phone, mobile, congregation, language, note_admin
            )
            VALUES (
                :firstname, :lastname, :email, :username, :password, :is_admin, :is_active, :is_literature_table,
                :is_literature_cart, :phone, :mobile, :congregation, :language, :note_admin
            )'
        );

        $stmt->execute(
            array(
                ':firstname' => $user->get_firstname(),
                ':lastname' => $user->get_lastname(),
                ':email' => $user->get_email(),
                ':username' => $user->get_username(),
                ':password' => $user->get_password(),
                ':is_admin' => (int)$user->is_admin(),
                ':is_active' => (int)$user->is_active(),
                ':is_literature_table' => (int)$user->is_literature_table(),
                ':is_literature_cart' => (int)$user->is_literature_cart(),
                ':phone' => $user->get_phone(),
                ':mobile' => $user->get_mobile(),
                ':congregation' => $user->get_congregation(),
                ':language' => $user->get_language(),
                ':note_admin' => $user->get_note_admin()
            )
        );
        return $stmt->rowCount() == 1;
    }

    static function delete(\PDO $connection, int $id_user): bool {
        $stmt = $connection->prepare(
            'DELETE FROM users WHERE id_user = :id_user'
        );

        return $stmt->execute(
            array(':id_user' => $id_user)
        );
    }

    protected $table_name;
}