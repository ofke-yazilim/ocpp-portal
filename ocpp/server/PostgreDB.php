<?php
namespace OCPP\Server;

use PDO;
/**
 * $db = new PostgresDB('localhost', '5432', 'mydb', 'myuser', 'mypassword');
 *
 * // INSERT
 * $newId = $db->insert('charging_sessions', [
 * 'user_id' => 1,
 * 'rfid_card_id' => 2,
 * 'station_id' => 3,
 * 'start_time' => '2025-10-27 13:00:00',
 * 'status' => 'active'
 * ]);
 *
 * // UPDATE
 $affected = $db->update('charging_sessions', [
 'end_time' => '2025-10-27 14:00:00',
 'status' => 'completed'
  ], 'id = :id', ['id' => $newId]);
 *
 * $activeSessions = $db->select('charging_sessions', 'user_id = :uid AND status = :status', [
 * 'uid' => 1,
 * 'status' => 'active'
 * ]);
 *
 * foreach ($activeSessions as $session) {
 * echo "Session ID: {$session['id']}, Başlangıç: {$session['start_time']}\n";
 * }
 */
class PostgresDB
{
    private PDO $conn;

    public function __construct(
        private string $host,
        private string $port,
        private string $dbname,
        private string $user,
        private string $password
    ) {
        $dsn = "pgsql:host={$this->host};port={$this->port};dbname={$this->dbname}";
        $this->conn = new PDO($dsn, $this->user, $this->password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
    }

    public function insert(string $table, array $data): int
    {
        $columns = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_map(fn($k) => ":$k", array_keys($data)));

        $sql = "INSERT INTO {$table} ({$columns}) VALUES ({$placeholders})";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($data);

        return (int) $this->conn->lastInsertId();
    }

    public function updatestandart(string $table, array $data, string $whereClause, array $whereParams): int
    {
        $setClause = implode(', ', array_map(fn($k) => "$k = :$k", array_keys($data)));
        $sql = "UPDATE {$table} SET {$setClause} WHERE {$whereClause}";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([...$data, ...$whereParams]);

        return $stmt->rowCount();
    }

    public function update(string $table, array $data, string $whereClause, array $whereParams, array $increments = []): int
    {
        $setParts = [];

        // Normal alanlar
        foreach ($data as $key => $value) {
            $setParts[] = "$key = :$key";
        }

        // Artırılacak alanlar
        foreach ($increments as $key => $amount) {
            $setParts[] = "$key = $key + :inc_$key";
            $data["inc_$key"] = $amount;
        }

        $setClause = implode(', ', $setParts);
        $sql = "UPDATE {$table} SET {$setClause} WHERE {$whereClause}";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([...$data, ...$whereParams]);

        return $stmt->rowCount();
    }

    public function select(string $table, string $whereClause = '', array $params = []): array
    {
        $sql = "SELECT * FROM {$table}";
        if ($whereClause) {
            $sql .= " WHERE {$whereClause}";
        }

        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function selectFirst(string $table, string $whereClause = '', array $params = []): ?array
    {
        $sql = "SELECT * FROM {$table}";
        if ($whereClause) {
            $sql .= " WHERE {$whereClause}";
        }
        $sql .= " LIMIT 1";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);

        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $result ?: null;
    }

}
