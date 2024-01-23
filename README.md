# API Task UNMEP

A [API Task UNMEP](https://api-tasks-unmep.vercel.app) permitirá a listagem, criação, atualização e exclusão de tarefas, tais tarefas apresentam os campos como titulo, descrição, status (pendente, executando e concluída) e data (data de criação da tarefa que será preenchido automaticamente).

## Teste da API e URL de acesso

A API pode ser testada por meio das plataformas Postman ou Insomnia.

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