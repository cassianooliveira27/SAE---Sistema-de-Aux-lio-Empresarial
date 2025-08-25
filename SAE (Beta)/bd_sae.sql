CREATE DATABASE sae_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE sae_db;

CREATE TABLE cargos (
    id_cargo INT AUTO_INCREMENT PRIMARY KEY,
    nome_cargo VARCHAR(100) NOT NULL,
    descricao TEXT,
    salario_base DECIMAL(10,2) DEFAULT 0.00
) ENGINE=InnoDB;

CREATE TABLE funcionarios (
    id_funcionario INT AUTO_INCREMENT PRIMARY KEY,
    nome_funcionario VARCHAR(200) NOT NULL,
    cpf_funcionario VARCHAR(20) NOT NULL UNIQUE,
    id_cargo INT DEFAULT NULL,
    carga_horaria INT NOT NULL,
    salario DECIMAL(10,2) NOT NULL,
    data_admissao DATE DEFAULT NULL,
    FOREIGN KEY (id_cargo) REFERENCES cargos(id_cargo) ON DELETE SET NULL
) ENGINE=InnoDB;

INSERT INTO cargos (nome_cargo, descricao, salario_base) VALUES
('Analista', 'Analista Jr/Sr', 2500.00),
('Gerente', 'Gerente de Produto', 6000.00),
('Estagiario', 'Estágio', 800.00);

INSERT INTO funcionarios (nome_funcionario, cpf_funcionario, id_cargo, carga_horaria, salario, data_admissao) VALUES
('João Silva','11122233344',1,40,2700.00,'2023-02-10'),
('Maria Costa','55566677788',2,40,7000.00,'2021-06-20');