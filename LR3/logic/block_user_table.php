<?php
require_once 'db.php';

class BlockUser {
    public static function create_block(string $ip, DateTime $expire): void {
        $query = DB::prepare('INSERT INTO block_users VALUES (:ip, 1, :expire)');
        $query->bindValue(':ip', $ip);
        $query->bindValue(':expire', $expire);

        try {
            $query->execute();
        }
        catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public static function get_block(string $ip): ?array {
        $query = DB::prepare('SELECT * FROM block_users WHERE user_ip = :ip');
        $query->bindValue(':ip', $ip);

        $query->execute();
        $block = $query->fetch();
        if ($block) {
            return $block;
        }
        return null;
    }

    public static function update_block(string $ip, int $count): void {
        $query = DB::prepare('UPDATE block_users SET count = :count WHERE user_ip = :ip');
        $query->bindValue(':ip', $ip);
        $query->bindValue(':count', $count);

        try {
            $query->execute();
        }
        catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public static function delete_block(string $ip): void {
        $query = DB::prepare('DELETE FROM block_users WHERE user_ip = :ip');
        $query->bindValue(':ip', $ip);

        try {
            $query->execute();
        }
        catch (PDOException $e) {
            die($e->getMessage());
        }
    }
}