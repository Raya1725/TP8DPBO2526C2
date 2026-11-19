<?php

require_once __DIR__ . '/Database.php';

class Lecturers extends Database
{
    /**
     * Mengambil semua dosen.
     *
     * @return array Daftar baris dosen, array kosong jika tabel kosong.
     * @throws RuntimeException Jika query gagal.
     *
     * Kompleksitas: waktu O(n), memori O(n) karena semua baris ditampung.
     */
    public function getLecturers()
    {
        // Query gagal harus dilaporkan, bukan dibiarkan lolos ke getResult().
        if (!$this->execute("SELECT * FROM lecturers")) {
            throw new RuntimeException("Gagal mengambil data dosen.");
        }

        $lecturers = [];
        while ($row = $this->getResult()) {
            $lecturers[] = $row;
        }
        return $lecturers;
    }

    /**
     * Mengambil satu dosen berdasarkan NIDN.
     *
     * @param string $nidn NIDN dosen yang dicari.
     * @return array|null Baris dosen, atau null jika tidak ditemukan.
     * @throws RuntimeException Jika query gagal.
     *
     * Kompleksitas: waktu O(log n) lewat primary key, memori O(1).
     */
    public function getByNidn($nidn)
    {
        if (!$this->executePrepared("SELECT * FROM lecturers WHERE nidn = ?", "s", [$nidn])) {
            throw new RuntimeException("Gagal mengambil data dosen.");
        }

        return $this->getResult();
    }

    /**
     * Menambah dosen baru.
     *
     * @param string $nidn      NIDN (primary key, harus unik).
     * @param string $name      Nama dosen.
     * @param string $phone     Nomor telepon.
     * @param string $join_date Tanggal bergabung (Y-m-d).
     * @return bool true jika query berhasil dijalankan.
     *
     * Kompleksitas: waktu O(log n), memori O(1).
     */
    public function create($nidn, $name, $phone, $join_date)
    {
        return $this->executePrepared(
            "INSERT INTO lecturers(nidn, name, phone, join_date) VALUES (?, ?, ?, ?)",
            "ssss",
            [$nidn, $name, $phone, $join_date]
        );
    }

    /**
     * Mengubah data dosen berdasarkan NIDN.
     *
     * @param string $nidn      Kunci baris yang diubah (tidak ikut diubah).
     * @param string $name      Nama baru.
     * @param string $phone     Nomor telepon baru.
     * @param string $join_date Tanggal bergabung baru (Y-m-d).
     * @return bool true jika query berhasil dijalankan, walau NIDN tidak ada.
     *
     * Kompleksitas: waktu O(log n), memori O(1).
     */
    public function update($nidn, $name, $phone, $join_date)
    {
        // NIDN diletakkan terakhir karena urutan "?" harus sama dengan urutan parameter.
        return $this->executePrepared(
            "UPDATE lecturers SET name = ?, phone = ?, join_date = ? WHERE nidn = ?",
            "ssss",
            [$name, $phone, $join_date, $nidn]
        );
    }

    /**
     * Menghapus dosen berdasarkan NIDN.
     *
     * @param string $nidn NIDN dosen yang dihapus.
     * @return bool true jika query berhasil dijalankan, walau NIDN tidak ada.
     *
     * Kompleksitas: waktu O(log n), memori O(1).
     */
    public function delete($nidn)
    {
        return $this->executePrepared(
            "DELETE FROM lecturers WHERE nidn = ?",
            "s",
            [$nidn]
        );
    }
}