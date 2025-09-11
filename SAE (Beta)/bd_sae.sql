CREATE DATABASE sae_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE sae_db;

CREATE TABLE cargos (
    id_cargo INT AUTO_INCREMENT PRIMARY KEY,
    nome_cargo VARCHAR(100) NOT NULL UNIQUE, 
    descricao TEXT,
    salario_base DECIMAL(10,2) NOT NULL,
    carga_horaria_max INT NOT NULL
);

CREATE TABLE funcionarios (
    id_funcionario INT AUTO_INCREMENT PRIMARY KEY,
    nome_funcionario VARCHAR(100) NOT NULL,
    cpf_funcionario VARCHAR(14) NOT NULL UNIQUE,
    salario DECIMAL(10,2) NOT NULL,
    data_admissao DATE,
    id_cargo INT NOT NULL,
    FOREIGN KEY (id_cargo) REFERENCES cargos(id_cargo)
);

INSERT INTO cargos (nome_cargo, descricao, salario_base, carga_horaria_max)
VALUES 
('Gerente de Projetos', 'Gerencia equipes e cronogramas', 7500.00, 40),
('Analista de Sistemas', 'Desenvolvimento e manutenção de sistemas', 4200.00, 44),
('Assistente Administrativo', 'Auxilia em rotinas administrativas', 2500.00, 40);

INSERT INTO funcionarios (nome_funcionario, cpf_funcionario, salario, data_admissao, id_cargo)
VALUES
('Carlos Silva', '123.456.789-00', 5000.00, '2024-01-15', 1),
('Maria Oliveira', '987.654.321-00', 6200.00, '2023-05-10', 2),
('João Santos', '111.222.333-44', 2600.00, '2025-03-20', 3);
