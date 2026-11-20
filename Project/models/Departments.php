<?php

require_once __DIR__ . '/Database.php';

class Departments extends Database
{
    public function getDepartment()
    {
        if (!$this->execute("SELECT * FROM departments")) {
            throw new RuntimeException("Gagal mengambil data prodi");
        }

        $departments = [];
        while ($row = $this->getResult()) {
            $departments[] = $row;
        }
        return $departments;
    }

    public function getById($id)
    {
        if (!$this->executePrepared("SELECT * FROM departments WHERE id = ?", "s", [$id])) {
            throw new RuntimeException("Gagal menemukan prodi dengan id tersebut");
        }

        return $this->getResult();
    }

    public function create($id, $name, $head_department_nidn)
    {
        return $this->executePrepared(
            "INSERT INTO departments(id, name, head_department_nidn) VALUES (?, ?, ?)",
            "sss",
            [$id, $name, $head_department_nidn]
        );
    }

    public function update($id, $name, $head_department_nidn)
    {
        return $this->executePrepared(
            "UPDATE departments SET name = ?, head_department_nidn = ? WHERE id = ?",
            "sss",
            [$name, $head_department_nidn, $id]
        );
    }

    public function delete($id)
    {
        return $this->executePrepared(
            "DELETE FROM departments WHERE id = ?",
            "s",
            [$id]
        );
    }
}