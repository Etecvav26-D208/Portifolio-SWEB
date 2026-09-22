USE suapack;

CREATE TABLE IF NOT EXISTS usuarios (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(120) NOT NULL,
    email VARCHAR(180) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    tipo ENUM('cliente', 'admin') NOT NULL DEFAULT 'cliente',
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO usuarios (nome, email, senha, tipo)
SELECT 'Administrador SUA PACK', 'admin@suapack.com', '$2y$12$hQPYVwHrxr2X9zUz61dg0.9NA.2yZsr7IfpBRHf0KYjmpXb67hzNy', 'admin'
WHERE NOT EXISTS (SELECT 1 FROM usuarios WHERE email = 'admin@suapack.com');

SET @col_exists := (SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'pedidos' AND COLUMN_NAME = 'id_usuario');
SET @sql := IF(@col_exists = 0, 'ALTER TABLE pedidos ADD COLUMN id_usuario INT NULL AFTER id_pedido', 'SELECT 1');
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

UPDATE pedidos SET id_usuario = (SELECT id_usuario FROM usuarios WHERE email = 'admin@suapack.com' LIMIT 1) WHERE id_usuario IS NULL;

SET @fk_exists := (SELECT COUNT(*) FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'pedidos' AND CONSTRAINT_NAME = 'fk_pedidos_usuario');
SET @sql_fk := IF(@fk_exists = 0, 'ALTER TABLE pedidos ADD CONSTRAINT fk_pedidos_usuario FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario) ON UPDATE CASCADE ON DELETE RESTRICT', 'SELECT 1');
PREPARE stmt2 FROM @sql_fk; EXECUTE stmt2; DEALLOCATE PREPARE stmt2;
