CREATE DATABASE db_kuisioner_unilever;
USE db_kuisioner_unilever;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('user', 'admin') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE biodata (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    nama VARCHAR(100),
    usia INT,
    jenis_kelamin ENUM('Laki-laki', 'Perempuan'),
    pekerjaan VARCHAR(100),
    FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE pertanyaan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    isi_pertanyaan TEXT NOT NULL,
    jenis ENUM('kuantitatif', 'kualitatif') NOT NULL
);

CREATE TABLE jawaban (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    pertanyaan_id INT,
    jawaban TEXT,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (pertanyaan_id) REFERENCES pertanyaan(id)
);

CREATE TABLE analisis_nps (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    skor_nps INT,
    kategori ENUM('Promoter', 'Passive', 'Detractor'),
    FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE rekomendasi_produk (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    produk_disarankan VARCHAR(100),
    alasan TEXT,
    FOREIGN KEY (user_id) REFERENCES users(id)
);
