# API Task UNMEP

A [API Task UNMEP](https://api-tasks-unmep.vercel.app) permitirá a listagem, criação, atualização e exclusão de tarefas, tais tarefas apresentam os campos como titulo, descrição, status (pendente, executando e concluída) e data (data de criação da tarefa que será preenchido automaticamente).

## Execução do projeto em outra máquina

Para executar este projeto em outra máquina é necessário ter instala o PHP, XAMPP ou WampServer que vem inclusos com o MySql e o gerenciador de dependências composer, contudo as dependências necessárias já estão inclusas neste repositório.

Outra coisa a ser feita é a configuração do banco de dados através do arquivo ``config.php``, os campos DB_HOST, DB_DBNAME, DB_USER, DB_PASSWORD serão redefinidos de acordo com as configurações do MySql:

+ De:
        
        define('DB_HOST',      $_ENV['DB_HOST']);
        define('DB_DBNAME',    $_ENV['DB_DBNAME']);
        define('DB_USER',      $_ENV['DB_USER']);
        define('DB_PASSWORD',  $_ENV['DB_PASSWORD']);
        define('DB_CHARSET',   $_ENV['DB_CHARSET']);

+ Para:

        define('DB_HOST',      'localhost');
        define('DB_DBNAME',    'nome_banco_de_dados');
        define('DB_USER',      'nome_usuario_banco_dados');
        define('DB_PASSWORD',  'senha_banco_dados');
        define('DB_CHARSET',   'utf-8');

## Teste da API e URL de acesso

Para testar o projeto por meio da API basta usar plataformas como Postman ou Insomnia.

URL da API: https://api-tasks-unmep.vercel.app

Para o preenchimento dos campos seja durante a criação ou atualização de uma tarefa indica-se o uso do ``form-data`` no Postman ou de um ``Multipart`` no Insomnia para simular um formulário de preenchimento.


## Grupo de Recursos da API

### Listar Tarefas [/ ou /?a=list_task]

Exibir a lista com as tarefas.

### Listar (List) [GET]

+ Request (application/json)

    + Headers

            Não é obrigatório o seu preenchimento


+ Response (application/json)

        {
            "tasks": [
                {
                    "id": 1,
                    "title": "Aqui está",
                    "description": "aqui oh",
                    "status": "",
                    "date_at": "23-01-2024"
                },
                {
                    "id": 2,
                    "title": "Tarefa 2",
                    "description": "alterei a descrição",
                    "status": "concluída",
                    "date_at": "23-01-2024"
                },
                {
                    "id": 3,
                    "title": "Tarefa 3",
                    "description": "Lorem ipsum ut elit magna hendrerit amet habitasse pulvinar, convallis eu ipsum massa vestibulum magna cubilia, maecenas inceptos id per fames lectus mattis. justo sed et turpis curabitur leo enim potenti, ultricies tempor habitasse rutrum netus himenaeos torquent, commodo justo sed eros potenti per. nam habitant nunc sociosqu vitae integer gravida aenean lectus, tempor ultrices in ligula enim taciti at fermentum, bibendum eleifend augue habitant metus congue etiam.",
                    "status": "concluída",
                    "date_at": "20-01-2024"
                },
                {
                    "id": 4,
                    "title": "Tarefa 4",
                    "description": "Lorem ipsum ut elit magna hendrerit amet habitasse pulvinar, convallis eu ipsum massa vestibulum magna cubilia, maecenas inceptos id per fames lectus mattis. justo sed et turpis curabitur leo enim potenti, ultricies tempor habitasse rutrum netus himenaeos torquent, commodo justo sed eros potenti per. nam habitant nunc sociosqu vitae integer gravida aenean lectus, tempor ultrices in ligula enim taciti at fermentum, bibendum eleifend augue habitant metus congue etiam.",
                    "status": "executando",
                    "date_at": "20-01-2024"
                }
            ]
        }

### Criar Tarefa [/?a=create_task&id={id_task}]

Adicionar uma nova tarefa a lista de tarefas.

#### Criar (Create) [POST]

+ Parameters
    + id (required, number, `1`)


+ Request (application/json)

    + Headers

            Não é obrigatório o seu preenchimento


+ Attributes (object)

    + title: nome do título (string, required)
    + description (text, required)
    + status (array, required) - Tipo
        + pendente
        + executando
        + concluída


+ Request (application/json)

    + Body

            {
              "title": "Título da tarefa",
              "description": "Descrição da tarefa que será feita",
              "status": "pendente"
            }


+ Response (application/json)

    + Body

            {
                "sucess": {
                    "message": "Tarefa criada com sucesso!"
                } 
            }

### Editar Tarefa [/?a=edit_task&id={id_task}]

Editar uma tarefa específica da lista de tarefas, um ou mais campos podem ser alterados na edição.

### Editar (Update) [POST]

+ Parameters
    + id (required, number, `1`)

+ Attributes (object)

    + title: nome do título (string, optional)
    + description (text, optional)
    + status (array, optional) - Tipo
        + pendente
        + executando
        + concluída

+ Request (application/json)

    + Headers

            Não é obrigatório o seu preenchimento


+ Request (application/json)

    + Body

            {
              "title": "Título alterado",
              "description": "Descrição alterado",
              "status": "pendente",
            }


+ Response (application/json)

    + Body

            {
                "task": [
                    {
                        "id": 9,
                        "title": "Titulo alterado",
                        "description": "Descrição alterada",
                        "status": "pendente",
                        "date_at": "23-01-2024"
                    }
                ],
                "message": "Tarefa editada com sucesso!"
            }

### Excluir Tarefa [/?a=delete_task&id={id_task}]

Excluir uma tarefa da lista de tarefas.

### Deletar (Delete) [DELETE]

+ Parameters
    + id (required, number, `1`)


+ Request (application/json)

    + Headers

            Não é obrigatório o seu preenchimento


+ Response (application/json)

    + Body

            {
                "removed": 5,
                "message": "Tarefa deletada com sucesso!"
            }