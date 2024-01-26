# API Tasks UNMEP

A [API Tasks UNMEP](https://api-tasks-unmep.vercel.app) foi hospedada na plataforma ``Vercel`` para possibilitar a listagem, criação, atualização e exclusão de tarefas, as tarefas em questão contém os seguintes campos: título, descrição, status (pendente, executando e concluída) e data (data de criação da tarefa que será preenchido automaticamente).

## Execução do projeto em outra máquina (opcional)

Para executar este projeto em outra máquina como uma API local é necessário ter instalado o PHP, XAMPP ou WampServer, o MySQL e o gerenciador de dependências composer, contudo as dependências necessárias já estão inclusas neste repositório.

Caso ocorra algum problema relacionado às dependências basta executar dentro do diretório do projeto por meio do terminal o comando ``composer update``.

Outra coisa a ser feita é a criação do banco de dados e a configuração dos campos referentes a conexão com o MySQL, para isso basta abrir o arquivo [config.php](https://github.com/rafabrito/api_tasks_unmep/blob/main/api/config.php), e redefinir os campos ``DB_HOST``, ``DB_DBNAME``, ``DB_USER``, ``DB_PASSWORD`` e ``DB_CHARSET`` de acordo com as configuração local:

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

Para preencher o banco de dados recém com dados fictícios é necessário executar o script ``.sql`` que está em [database/api_task_unmep_database.sql](https://github.com/rafabrito/api_tasks_unmep/blob/main/database/api_task_unmep_database.sql).

O projeto está estruturado da seguinte forma:

```sh
api_tasks_unmep
├── api
│   ├── core
│   │   ├── class
│   │   │   └── Database.php
│   │   ├── controller
│   │   │   └── Main.php
│   │   ├── models
│   │   │   └── Task.php
│   │   └── routes.php
│   ├── composer.json
│   ├── composer.lock
│   ├── vendor
│   ├── config.php
│   └──index.php
└── database
    └──api_task_unmep_database.sql
```

| Arquivo | Descrição |
|---|---|
|``Database.php``| responsável pela conexão com o banco de dados e pelas operações CRUD.|
|``Main.php``| controla o fluxo de dados de entrada e saída.|
|``Task.php``| manipula os dados vinculados a tabela ``task``.|
|``routes.php``| resposável por vincular as URIs que identifica um recurso ao controller para acessar .algo, como por exemplo, a lista com todas as tarefas.|
|``config.php``| definição das configurações básicas da aplicação e do banco de dados.|
|``index.php``| arquivo pricipal que permite o carregamento de outros arquivos importantes para que a aplicação funcione como esperado.|

## Execução da API e URL de acesso

Para testar o projeto por meio da API hospedada na ``Vercel`` basta usar plataformas como [Postman](https://www.postman.com/downloads/) ou [Insomnia](https://insomnia.rest/download).

URL da API: https://api-tasks-unmep.vercel.app

Para o preenchimento dos campos seja durante a criação ou atualização de uma tarefa indica-se o uso do ``form-data`` no Postman ou de um ``Multipart Form`` no Insomnia para simulação de um formulário de preenchimento.

## Respostas da API (response)

| Termo | Descrição |
|---|---|
|`[sucess]`| Requisição realizada com sucesso.|
|`[error]`| Erros de validação ou relacionados aos campos informados não existirem ou estarem vazias ou devido a não existência no sistema.|

## Grupo de Recursos da API

### Listar Tarefas [/ ``ou`` /?a=list_task]

Exibir a lista com todas as tarefas.

### Listar (List) [GET]

+ Request (application/json)

    + Headers

            Não é obrigatório o seu preenchimento


+ Response [sucess] (application/json)

        {
            "tasks": [
                {
                    "id": 1,
                    "title": "Tarefa 1",
                    "description": "Lorem ipsum ut elit magna hendrerit amet habitasse pulvinar, 
                    convallis eu ipsum massa vestibulum magna cubilia, maecenas inceptos id per fames 
                    lectus mattis.",
                    "status": "pendente",
                    "date_at": "23-01-2024"
                },
                {
                    "id": 2,
                    "title": "Tarefa 2",
                    "description": "Lorem ipsum ut elit magna hendrerit amet habitasse pulvinar, 
                    convallis eu ipsum massa vestibulum magna cubilia, maecenas inceptos id per fames 
                    lectus mattis.",
                    "status": "concluída",
                    "date_at": "23-01-2024"
                },
                {
                    "id": 3,
                    "title": "Tarefa 3",
                    "description": "Lorem ipsum ut elit magna hendrerit amet habitasse pulvinar, 
                    convallis eu ipsum massa vestibulum magna cubilia, maecenas inceptos id per fames 
                    lectus mattis.",
                    "status": "concluída",
                    "date_at": "20-01-2024"
                },
                {
                    "id": 4,
                    "title": "Tarefa 4",
                    "description": "Lorem ipsum ut elit magna hendrerit amet habitasse pulvinar, 
                    convallis eu ipsum massa vestibulum magna cubilia, maecenas inceptos id per fames 
                    lectus mattis.",
                    "status": "executando",
                    "date_at": "20-01-2024"
                }
            ]
        }

### Criar Tarefa [/?a=create_task]

Adicionar uma nova tarefa a lista de tarefas.

#### Criar (Create) [POST]

+ Request (application/json)

    + Headers

            Não é obrigatório o seu preenchimento


+ Attributes (object)

    + title: nome do título (string, required)
    + description: descrição da tarefa (text, required)
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


+ Response [sucess] (application/json)

    + Body

            {
                "sucess": {
                    "message": "Tarefa criada com sucesso!"
                } 
            }

+ Response [error] (application/json)

    + Body

            {
                "error": {
                    "message": "Status não existe",
                    "possible status": ["pendente","executando", "concluída"]
                }
            }


            {
                "error": { 
                    "message": "O campo 'status' não foi definido"
                }
            }


            {
                "error": { 
                    "message": "O campo 'description' não foi definido"
                }
            }


            {
                "error": { 
                    "message": "O campo 'title' não foi definido"
                }
            }


            {
                "error": { 
                    "message": "Não foram preenchido todos os campos"
                }
            }

### Editar Tarefa [/?a=edit_task&id={id_task}]

Editar tarefa específica da lista de tarefas, salientando que um ou mais campos podem ser alterados na edição.

### Editar (Update) [POST]

+ Parameters
    + id (required, number, `1`) ... Índice da tarefa

+ Attributes (object)

    + title: nome do título (string, optional)
    + description: descrição da tarefa (text, optional)
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


+ Response [sucess] (application/json)

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

+ Response [error] (application/json)

    + Body

            {
                "error": {
                    "message": "Status não existe",
                    "possible status": ["pendente","executando", "concluída"]
                }
            }


            {
                "error": { 
                    "message": "Tarefa não existe"
                }
            }


            {
                "error": { 
                    "message": "Não foi especificado o 'id' da tarefa"
                }
            }


### Excluir Tarefa [/?a=delete_task&id={id_task}]

Excluir tarefa específica da lista de tarefas.

### Deletar (Delete) [DELETE]

+ Parameters
    + id (required, number, `1`) ... Índice da tarefa


+ Request (application/json)

    + Headers

            Não é obrigatório o seu preenchimento


+ Response [sucess] (application/json)

    + Body

            {
                "removed": 5,
                "message": "Tarefa deletada com sucesso!"
            }

+ Response [error] (application/json)

    + Body

            {
                "error": { 
                    "message": "Tarefa não existe"
                }
            }

### Exibir Tarefa [/?a=display_task&id={id_task}]

Exibir uma tarefa específica da lista de tarefas.

### Detalhar (Read) [GET]

+ Parameters
    + codigo (required, number, `1`) ... Índice da tarefa

+ Request (application/json)

    + Headers

            Não é obrigatório o seu preenchimento

+ Response [sucess] (application/json)

    + Body

            {
                "task": [
                    {
                        "id": 1,
                        "title": "Aqui está",
                        "description": "aqui oh",
                        "status": "",
                        "date_at": "23-01-2024"
                    }
                ]
            }

+ Response [error] (application/json)

    + Body

            {
                "error": { 
                    "message": "Tarefa não existe"
                }
            }


            {
                "error": { 
                    "message": "Não foi especificado o 'id' da tarefa"
                }
            }

            

## Uso de Banco de dados externo

Para que fosse possível usar o MySQL como SGBD da API (hospedada no ``Vercel``), foi necessário criar uma conta na plataforma [Clever Clound](https://www.clever-cloud.com) e implantar de forma gratuita o MySQL.
