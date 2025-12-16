<?php

class M_User
{
    private $db;

    public function __construct()
    {
        global $db;

        if (!isset($db)) {
            die('M_User: Database belum di-load');
        }

        $this->db = $db;
    }

    public function getAll()
    {
        $stmt = $this->db->query(
            "SELECT id, nama, username, departemen, role FROM users"
        );
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $stmt = $this->db->prepare(
            "SELECT id, nama, username, departemen, role FROM users WHERE id = ?"
        );
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getUserByUsername($username)
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM users WHERE username = ? LIMIT 1"
        );
        $stmt->execute([$username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function insert($data)
    {
        $password = password_hash($data['password'], PASSWORD_DEFAULT);

        $stmt = $this->db->prepare(
            "INSERT INTO users (nama, username, password, departemen, role)
             VALUES (?, ?, ?, ?, ?)"
        );

        return $stmt->execute([
            $data['nama'],
            $data['username'],
            $password,
            $data['departemen'],
            $data['role']
        ]);
    }

    public function update($data)
    {
        if (!empty($data['password'])) {
            $password = password_hash($data['password'], PASSWORD_DEFAULT);

            $stmt = $this->db->prepare(
                "UPDATE users
                 SET nama=?, username=?, password=?, departemen=?, role=?
                 WHERE id=?"
            );

            return $stmt->execute([
                $data['nama'],
                $data['username'],
                $password,
                $data['departemen'],
                $data['role'],
                $data['id']
            ]);
        } else {
            $stmt = $this->db->prepare(
                "UPDATE users
                 SET nama=?, username=?, departemen=?, role=?
                 WHERE id=?"
            );

            return $stmt->execute([
                $data['nama'],
                $data['username'],
                $data['departemen'],
                $data['role'],
                $data['id']
            ]);
        }
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare(
            "DELETE FROM users WHERE id = ?"
        );
        return $stmt->execute([$id]);
    }
}
