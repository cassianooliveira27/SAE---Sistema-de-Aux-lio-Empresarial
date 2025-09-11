USE sae_db;

SELECT * FROM cargos;

SELECT * FROM cargos
WHERE nome_cargo LIKE '%Analista%';

SELECT * FROM cargos
WHERE id_cargo = 1;

SELECT f.id_funcionario, f.nome_funcionario, f.cpf_funcionario,
       f.salario, f.data_admissao, c.nome_cargo
FROM funcionarios f
JOIN cargos c ON f.id_cargo = c.id_cargo;

SELECT f.id_funcionario, f.nome_funcionario, f.cpf_funcionario,
       f.salario, f.data_admissao, c.nome_cargo
FROM funcionarios f
JOIN cargos c ON f.id_cargo = c.id_cargo
WHERE f.nome_funcionario LIKE '%Carlos%';

SELECT f.id_funcionario, f.nome_funcionario, f.cpf_funcionario,
       f.salario, f.data_admissao, c.nome_cargo
FROM funcionarios f
JOIN cargos c ON f.id_cargo = c.id_cargo
WHERE f.cpf_funcionario = '123.456.789-00';

SELECT f.id_funcionario, f.nome_funcionario, f.cpf_funcionario,
       f.salario, f.data_admissao, c.nome_cargo
FROM funcionarios f
JOIN cargos c ON f.id_cargo = c.id_cargo
WHERE c.nome_cargo LIKE '%Assistente%';

SELECT * FROM funcionarios
WHERE id_funcionario = 2;
