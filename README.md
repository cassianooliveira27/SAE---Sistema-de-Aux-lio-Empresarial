Este projeto é um sistema auxiliar empresarial desenvolvido em PHP com MySQL, executado em ambiente local via XAMPP.
O sistema permite gerenciar informações empresariais de forma prática e intuitiva.

Tecnologias Utilizadas

PHP (lógica de negócios e back-end)

MySQL (armazenamento de dados)

HTML, CSS (interface do usuário e estilização)

XAMPP (servidor local com Apache + MySQL)

Instalação e Configuração
1. Pré-requisitos

Instalar XAMPP

Ter um navegador atualizado (Chrome, Edge, Firefox, etc.)

2. Configuração do Projeto

Extraia a pasta SistemaAuxiliarEmpresarialV1 do arquivo .zip.

Mova a pasta para o diretório do servidor local do XAMPP:

C:\xampp\htdocs\


Inicie o XAMPP e ative os módulos Apache e MySQL.

Banco de Dados

Abra o navegador e acesse o phpMyAdmin:

http://localhost/phpmyadmin/


Crie um novo banco de dados chamado:

sistema_empresarial


Clique em Importar e selecione o arquivo .sql que está dentro da pasta SistemaAuxiliarEmpresarialV1.

Confirme a importação.

Configuração da Conexão

Verifique no arquivo config.php (ou equivalente) as credenciais de conexão:

$host = "localhost";
$user = "root";
$pass = "&tec77@info!";
$db   = "sistema_empresarial";


Usuário padrão do MySQL no XAMPP: root

Senha: (em branco)

Se necessário, ajuste conforme sua instalação.

Como Executar

Abra o navegador.

Acesse:

http://localhost/SistemaAuxiliarEmpresarialV1/


Faça login com as credenciais definidas no banco.

Solução de Problemas

Erro de conexão com o banco → verifique se o MySQL está ativo e se as credenciais no config.php estão corretas.

Erro de estilização (CSS/JS) → confirme que todos os arquivos foram extraídos corretamente dentro da pasta htdocs.

Página em branco → ative a exibição de erros no PHP ou verifique o log do Apache.

Licença

Este sistema é distribuído para fins de estudo e uso interno.
