-- Schema generated from the Laravel migrations for SIG-ACAD.
-- Import into a new MySQL/MariaDB database, then run: php artisan db:seed

CREATE DATABASE trabalho_pweb2
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE trabalho_pweb2;

CREATE TABLE users (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    email_verified_at TIMESTAMP NULL DEFAULT NULL,
    password VARCHAR(255) NOT NULL,
    remember_token VARCHAR(100) NULL,
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL
) ENGINE=InnoDB;

CREATE TABLE password_reset_tokens (
    email VARCHAR(255) NOT NULL PRIMARY KEY,
    token VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NULL DEFAULT NULL
) ENGINE=InnoDB;

CREATE TABLE sessions (
    id VARCHAR(255) NOT NULL PRIMARY KEY,
    user_id BIGINT UNSIGNED NULL,
    ip_address VARCHAR(45) NULL,
    user_agent TEXT NULL,
    payload LONGTEXT NOT NULL,
    last_activity INT NOT NULL,
    INDEX sessions_user_id_index (user_id),
    INDEX sessions_last_activity_index (last_activity)
) ENGINE=InnoDB;

CREATE TABLE cache (
    `key` VARCHAR(255) NOT NULL PRIMARY KEY,
    value MEDIUMTEXT NOT NULL,
    expiration BIGINT NOT NULL,
    INDEX cache_expiration_index (expiration)
) ENGINE=InnoDB;

CREATE TABLE cache_locks (
    `key` VARCHAR(255) NOT NULL PRIMARY KEY,
    owner VARCHAR(255) NOT NULL,
    expiration BIGINT NOT NULL,
    INDEX cache_locks_expiration_index (expiration)
) ENGINE=InnoDB;

CREATE TABLE jobs (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    queue VARCHAR(255) NOT NULL,
    payload LONGTEXT NOT NULL,
    attempts SMALLINT UNSIGNED NOT NULL,
    reserved_at INT UNSIGNED NULL,
    available_at INT UNSIGNED NOT NULL,
    created_at INT UNSIGNED NOT NULL,
    INDEX jobs_queue_index (queue)
) ENGINE=InnoDB;

CREATE TABLE job_batches (
    id VARCHAR(255) NOT NULL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    total_jobs INT NOT NULL,
    pending_jobs INT NOT NULL,
    failed_jobs INT NOT NULL,
    failed_job_ids LONGTEXT NOT NULL,
    options MEDIUMTEXT NULL,
    cancelled_at INT NULL,
    created_at INT NOT NULL,
    finished_at INT NULL
) ENGINE=InnoDB;

CREATE TABLE failed_jobs (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    uuid VARCHAR(255) NOT NULL UNIQUE,
    connection VARCHAR(255) NOT NULL,
    queue VARCHAR(255) NOT NULL,
    payload LONGTEXT NOT NULL,
    exception LONGTEXT NOT NULL,
    failed_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    INDEX failed_jobs_connection_queue_failed_at_index (connection, queue, failed_at)
) ENGINE=InnoDB;

CREATE TABLE planos (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    valor DECIMAL(10, 2) NOT NULL,
    descricao TEXT NULL,
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL
) ENGINE=InnoDB;

CREATE TABLE modalidades (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    descricao TEXT NULL,
    imagem VARCHAR(255) NULL,
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL
) ENGINE=InnoDB;

CREATE TABLE alunos (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(150) NOT NULL,
    cpf VARCHAR(16) NOT NULL,
    telefone VARCHAR(20) NULL,
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL,
    imagem VARCHAR(150) NULL,
    plano_id BIGINT UNSIGNED NULL,
    email VARCHAR(255) NULL UNIQUE,
    endereco VARCHAR(255) NULL,
    data_nascimento DATE NULL,
    ativo TINYINT(1) NOT NULL DEFAULT 1,
    modalidade_id BIGINT UNSIGNED NULL,
    CONSTRAINT alunos_plano_id_foreign
        FOREIGN KEY (plano_id) REFERENCES planos (id) ON DELETE SET NULL,
    CONSTRAINT alunos_modalidade_id_foreign
        FOREIGN KEY (modalidade_id) REFERENCES modalidades (id) ON DELETE SET NULL
) ENGINE=InnoDB;

CREATE TABLE equipamentos (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(120) NOT NULL,
    numero_serie VARCHAR(100) NOT NULL UNIQUE,
    estado VARCHAR(40) NOT NULL,
    imagem VARCHAR(255) NULL,
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL
) ENGINE=InnoDB;

CREATE TABLE avaliacoes_fisicas (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    aluno_id BIGINT UNSIGNED NOT NULL UNIQUE,
    peso DECIMAL(5, 2) NOT NULL,
    altura DECIMAL(3, 2) NOT NULL,
    imc DECIMAL(6, 2) NOT NULL,
    observacoes TEXT NULL,
    data_avaliacao DATE NOT NULL,
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL,
    CONSTRAINT avaliacoes_fisicas_aluno_id_foreign
        FOREIGN KEY (aluno_id) REFERENCES alunos (id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE migrations (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    migration VARCHAR(255) NOT NULL,
    batch INT NOT NULL
) ENGINE=InnoDB;

INSERT INTO migrations (migration, batch) VALUES
    ('0001_01_01_000000_create_users_table', 1),
    ('0001_01_01_000001_create_cache_table', 1),
    ('0001_01_01_000002_create_jobs_table', 1),
    ('2026_08_07_181211_create_alunos_table', 1),
    ('2026_08_28_165105_create_categoria_alunos_table', 1),
    ('2026_08_28_170306_alter_alunos_add_campo', 1),
    ('2026_09_18_174204_create_cursos_table', 1),
    ('2026_09_18_174310_create_turmas_table', 1),
    ('2026_09_18_174320_create_matriculas_table', 1),
    ('2026_10_16_000000_create_planos_table', 1),
    ('2026_10_16_000001_add_plano_id_to_alunos_table', 1),
    ('2026_10_16_000002_create_modalidades_table', 1),
    ('2026_10_16_000003_create_avaliacoes_fisicas_table', 1),
    ('2026_10_16_000004_create_equipamentos_table', 1),
    ('2026_10_16_000005_add_academy_fields_to_alunos_table', 2),
    ('2026_10_16_000006_remove_categoria_from_alunos_table', 3),
    ('2026_10_16_000007_remove_courses_and_enrollments', 4);
