<?php
require_once 'db.php';

class BlockUser {
    public static function create(string $ip, string $expire): array {
        $query = DB::prepare('INSERT INTO block_users VALUES (:ip, 1, :expire)');
        $query->bindValue(':ip', $ip);
        $query->bindValue(':expire', $expire);

        try {
            $query->execute();
            return [
                'ip' => $ip,
                'count' => 1,
                'expire' => $expire,
            ];
        }
        catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public static function get(string $ip): ?array {
        $query = DB::prepare('SELECT * FROM block_users WHERE user_ip = :ip');
        $query->bindValue(':ip', $ip);

        $query->execute();
        $block = $query->fetch();
        if ($block) {
            return $block;
        }
        return null;
    }

    public static function update_count(string $ip, int $count): array {
        $query = DB::prepare('UPDATE block_users SET count = :count WHERE user_ip = :ip');
        $query->bindValue(':ip', $ip);
        $query->bindValue(':count', $count);

        try {
            $query->execute();
            return self::get($ip);
        }
        catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public static function delete(string $ip): void {
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