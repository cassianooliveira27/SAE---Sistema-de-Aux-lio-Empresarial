![Logo](https://github.com/cassianooliveira27/SAE---Sistema-de-Aux-lio-Empresarial/blob/main/2024_logo_55anos_cps_gov_24-25_regua_horizontal+horizontal_cor.png?raw=true)

Sistema Auxiliar Empresarial (SAE) - Beta
Sistema desenvolvido em PHP com MySQL para gerenciamento prático e intuitivo de informações empresariais, executado em ambiente local via XAMPP.

Tecnologias Utilizadas
PHP, JavaScript — lógica de negócios e back-end
MySQL — armazenamento de dados
HTML, CSS — interface do usuário e estilização
XAMPP — servidor local (Apache + MySQL)
Requisitos
XAMPP instalado (https://www.apachefriends.org/pt_br/index.html)
Navegador atualizado (Chrome, Edge, Firefox, etc.)
Instalação e Configuração

1. Preparação do Projeto
Extraia a pasta SAE (Beta) do arquivo .zip.
Copie ou mova a pasta para o diretório do servidor local do XAMPP:
C:\xampp\htdocs\
Inicie o painel de controle do XAMPP e ative os módulos Apache e MySQL.

2. Configuração do Banco de Dados
Acesse o phpMyAdmin pelo navegador:
http://localhost/phpmyadmin/
Crie um novo banco de dados chamado: "sae_db"
Clique na aba Importar e selecione o arquivo .sql dentro da pasta SAE (Beta).
Confirme a importação para criar as tabelas e dados necessários.

3. Configuração da Conexão com o Banco
Abra o arquivo conect.php (ou equivalente) e ajuste as credenciais conforme sua instalação:
$host = "localhost";
$user = "root";
$pass = ""; // Senha padrão do XAMPP é vazia
$db   = "sae_db";

Como Executar
Abra o navegador.
Acesse a URL:

http://localhost/SAE (Beta)/
Faça login com as credenciais cadastradas no banco de dados.
Solução de Problemas Comuns
Problema

Possível Causa

Solução

Erro de conexão com o banco

MySQL não está ativo ou credenciais erradas

Verifique se o MySQL está rodando no XAMPP e confirme as credenciais no config.php.

Erro de estilização (CSS/JS)

Arquivos não extraídos corretamente

Confirme se todos os arquivos foram extraídos para a pasta correta dentro de htdocs.

Página em branco

Erros PHP ocultos

Ative a exibição de erros no PHP (php.ini) ou verifique o log do Apache para detalhes.

Licença
Este sistema é distribuído para fins de estudo e uso interno.
Não é permitido uso comercial sem autorização.
