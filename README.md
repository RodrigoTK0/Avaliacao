Pré-requisitos:
1.PHP >= 8.2
2.Composer
3.Um servidor de banco de dados

Instalação:
1.Clone o repositório ou baixe os arquivos:
(git clone <url-do-seu-repositorio> 
cd nome-do-projeto)
2.Instale as dependências:
(composer install)
3.Configure o ambiente:
(cp .env.example .env
php artisan key:generate)
4.Banco de Dados, abra o arquivo .env e configure seu banco:
(DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=nome_do_seu_banco
DB_USERNAME=seu_usuario
DB_PASSWORD=sua_senha)
5.Rode as migrations
(php artisan migrate)

Execução:
1.Inicie o servidor local
(php artisan serve)
2.Acesse no seu navegador: http://127.0.0.1:8000/startups

⚖️ LGPD e o Armazenamento de E-mails
A Lei Geral de Proteção de Dados (Lei nº 13.709/2018) aplica-se ao seu formulário, pois o "e-mail de contato" é considerado um dado pessoal (informação relacionada a uma pessoa natural identificada ou identificável).

Como a LGPD se aplica aqui:
Princípio da Finalidade: O e-mail coletado deve ser utilizado estritamente para o propósito informado ao usuário (ex: estabelecer contato comercial com a startup). Usar esse e-mail para outros fins (como vender a base para terceiros) sem aviso prévio viola a lei.

Base Legal: Para estar em conformidade, o ideal é coletar o Consentimento do titular. No formulário, isso é feito através de uma cláusula clara ou um "checkbox" onde o usuário aceita fornecer os dados para aquela finalidade.

Minimização: O sistema coleta apenas o necessário (E-mail, Nome e Setor). Coletar dados excessivos (como CPF ou endereço pessoal sem necessidade) iria contra a LGPD.
