![Logo](https://github.com/cassianooliveira27/SAE---Sistema-de-Aux-lio-Empresarial/blob/main/2024_logo_55anos_cps_gov_24-25_regua_horizontal+horizontal_cor.png?raw=true)

Este projeto é um sistema auxiliar empresarial desenvolvido em PHP com MySQL, executado em ambiente local via XAMPP.
O sistema permite gerenciar informações empresariais de forma prática e intuitiva.

![Separador](https://github.com/cassianooliveira27/SAE---Sistema-de-Aux-lio-Empresarial/blob/main/10578808.png?raw=true)

Tecnologias Utilizadas

Tecnologias Utilizadas

PHP, JavaScript — lógica de negócios e back-end

MySQL — armazenamento de dados

HTML, CSS — interface do usuário e estilização

XAMPP — servidor local (Apache + MySQL)

![Separador](https://github.com/cassianooliveira27/SAE---Sistema-de-Aux-lio-Empresarial/blob/main/10578808.png?raw=true)

Requisitos
XAMPP instalado (https://www.apachefriends.org/pt_br/index.html)

Navegador atualizado (Chrome, Edge, Firefox, etc.)

![Separador](https://github.com/cassianooliveira27/SAE---Sistema-de-Aux-lio-Empresarial/blob/main/10578808.png?raw=true)

Instalação e Configuração

Configuração do Projeto

Extraia a pasta SAE (Beta) do arquivo .zip.

Mova a pasta para o diretório do servidor local do XAMPP:

C:\xampp\htdocs\

Inicie o XAMPP e ative os módulos Apache e MySQL.

Banco de Dados

Abra o navegador e acesse o phpMyAdmin:

http://localhost/phpmyadmin/

Crie um novo banco de dados chamado: "sae_db"

Clique em Importar e selecione o arquivo .sql que está dentro da pasta SAE (Beta).

Confirme a importação.

Configuração da Conexão

Verifique no arquivo config.php (ou equivalente) as credenciais de conexão:

\$host = "localhost";

\$user = "root";

\$pass = "&tec77@info!";

\$db   = "sae_db";

Usuário padrão do MySQL no XAMPP: root

Senha: (em branco)

Se necessário, ajuste conforme sua instalação.

![Separador](https://github.com/cassianooliveira27/SAE---Sistema-de-Aux-lio-Empresarial/blob/main/10578808.png?raw=true)

Como Executar

Abra o navegador.

Acesse:

http://localhost/SAE (Beta)/

Faça login com as credenciais definidas no banco.

![Separador](https://github.com/cassianooliveira27/SAE---Sistema-de-Aux-lio-Empresarial/blob/main/10578808.png?raw=true)

Solução de Problemas Comuns

Problema

Possível Causa

Solução

Erro de conexão com o banco

MySQL não está ativo ou credenciais erradas

Verifique se o MySQL está rodando no XAMPP e confirme as credenciais no conect_bd.php.

Erro de estilização (CSS/JS)

Arquivos não extraídos corretamente

Confirme se todos os arquivos foram extraídos para a pasta correta dentro de htdocs.

Página em branco

Erros PHP ocultos

Ative a exibição de erros no PHP (php.ini) ou verifique o log do Apache para detalhes.

![Separador](https://github.com/cassianooliveira27/SAE---Sistema-de-Aux-lio-Empresarial/blob/main/10578808.png?raw=true)

Licença
Este sistema é distribuído para fins de estudo e uso interno.
Não é permitido uso comercial sem autorização.
