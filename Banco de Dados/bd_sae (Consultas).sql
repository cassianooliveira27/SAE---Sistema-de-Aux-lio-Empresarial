USE sae_db;

---------------------------------------------------
-- CONSULTA DE CARGOS
---------------------------------------------------

-- 🔹 Lista todos os cargos, ordenados por nome
SELECT *
FROM cargos
ORDER BY nome_cargo;

-- 🔹 Pesquisa cargos pelo nome (exemplo: buscar "Analista")
SELECT *
FROM cargos
WHERE nome_cargo LIKE '%Analista%'
ORDER BY nome_cargo;


---------------------------------------------------
-- CONSULTA DE FUNCIONÁRIOS
---------------------------------------------------

-- 🔹 Lista todos os funcionários com seus cargos, ordenados por nome
SELECT f.id_funcionario, f.nome_funcionario, f.cpf_funcionario,
       f.salario, f.data_admissao, c.nome_cargo, c.carga_horaria_max
FROM funcionarios f
LEFT JOIN cargos c ON f.id_cargo = c.id_cargo
ORDER BY f.nome_funcionario;

-- 🔹 Pesquisa funcionários pelo nome
SELECT f.id_funcionario, f.nome_funcionario, f.cpf_funcionario,
       f.salario, f.data_admissao, c.nome_cargo, c.carga_horaria_max
FROM funcionarios f
LEFT JOIN cargos c ON f.id_cargo = c.id_cargo
WHERE f.nome_funcionario LIKE '%Carlos%'
ORDER BY f.nome_funcionario;

-- 🔹 Filtra funcionários por cargo específico (exemplo: id_cargo = 2)
SELECT f.id_funcionario, f.nome_funcionario, f.cpf_funcionario,
       f.salario, f.data_admissao, c.nome_cargo, c.carga_horaria_max
FROM funcionarios f
LEFT JOIN cargos c ON f.id_cargo = c.id_cargo
WHERE f.id_cargo = 2
ORDER BY f.nome_funcionario;

-- 🔹 Filtra funcionários por faixa salarial (mínimo e máximo)
SELECT f.id_funcionario, f.nome_funcionario, f.cpf_funcionario,
       f.salario, f.data_admissao, c.nome_cargo, c.carga_horaria_max
FROM funcionarios f
LEFT JOIN cargos c ON f.id_cargo = c.id_cargo
WHERE f.salario >= 2000 AND f.salario <= 8000
ORDER BY f.nome_funcionario;
