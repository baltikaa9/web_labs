<?php
require_once 'db.php';

class UserTable
{
    public static function create(
        string $email,
        string $hashed_password,
        string $full_name,
        string $date_of_birth,
        string $address,
        string $sex,
        string $interests,
        string $vk,
        string $blood_type,
        string $rh_factor,
    ): void {
        $query = DB::prepare(
    'INSERT INTO users (email, password, full_name, date_of_birth, address, sex, interests, vk, blood_type, rh_factor) ' .
            'VALUES (:email, :password, :full_name, :date_of_birth, :address, :sex, :interests, :vk, :blood_type, :rh_factor)'
        );
        $query->bindValue(':email', $email);
        $query->bindValue(':password', $hashed_password);
        $query->bindValue(':full_name', $full_name);
        $query->bindValue(':date_of_birth', $date_of_birth);
        $query->bindValue(':address', $address);
        $query->bindValue(':sex', $sex);
        $query->bindValue(':interests', $interests);
        $query->bindValue(':vk', $vk);
        $query->bindValue(':blood_type', $blood_type);
        $query->bindValue(':rh_factor', $rh_factor);

        try {
            $query->execute();
        }
        catch (PDOException) {
            throw new PDOException('При добавлении пользователя произошла ошибка');
        }
    }

    public static function get_by_email(string $email): ?array {
        $query = DB::prepare(
            'SELECT * FROM users WHERE email = :email'
        );
        $query->bindValue(':email', $email);
        $query->execute();
        $user = $query->fetch();
        if ($user) {
            return $user;
        }
        return null;
    }

    public static function get_by_id(int $id): ?array {
        $query = DB::prepare(
            'SELECT * FROM users WHERE id = :id'
        );
        $query->bindValue(':id', $id);
        $query->execute();
        $user = $query->fetch();
        if ($user) {
            return $user;
        }
        return null;
    }
}