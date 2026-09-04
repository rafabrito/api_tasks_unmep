# API Tasks UNMEP

A **API Tasks UNMEP** é uma API REST desenvolvida em **PHP puro** com o objetivo de gerenciar uma lista de tarefas, permitindo as operações básicas de **CRUD** (Create, Read, Update, Delete). Cada tarefa possui os seguintes campos:

| Campo | Tipo | Descrição |
|---|---|---|
| `id` | int | Identificador único gerado automaticamente |
| `title` | varchar(255) | Título da tarefa |
| `description` | text | Descrição detalhada da tarefa |
| `status` | enum | Estado da tarefa: `pendente`, `executando` ou `concluída` |
| `date_at` | datetime | Data/hora de criação ou última atualização, preenchida automaticamente |

A API foi hospedada na plataforma **Vercel** e utilizou um banco de dados **MySQL** externo provisionado no **Clever Cloud**.

---

## Ferramentas e Configurações Necessárias

Para executar o projeto localmente, você precisa ter instalado:

| Ferramenta | Finalidade |
|---|---|
| **PHP 8.x** | Interpretador da linguagem |
| **XAMPP** ou **WampServer** | Servidor web local com Apache e MySQL |
| **MySQL** | Sistema gerenciador de banco de dados |
| **Composer** | Gerenciador de dependências PHP |

> As dependências já estão incluídas no repositório dentro da pasta `api/vendor/`. Caso ocorra algum problema relacionado a elas, execute o comando abaixo dentro do diretório `api/` pelo terminal:

```bash
composer update
```

---

## Executando o Projeto Localmente

### 1. Criar o banco de dados

Importe o arquivo SQL localizado em [`database/api_task_unmep_database.sql`](database/api_task_unmep_database.sql) no seu MySQL local (via phpMyAdmin ou terminal). Esse script irá:

- Criar a tabela `task` com todos os seus campos e índices
- Popular a tabela com **4 tarefas fictícias** para testes imediatos

### 2. Configurar a conexão com o banco de dados

Abra o arquivo [`api/config.php`](api/config.php) e substitua as constantes de ambiente pelas suas credenciais locais:

- **De** (configuração para produção via variáveis de ambiente):

```php
define('DB_HOST',      $_ENV['DB_HOST']);
define('DB_DBNAME',    $_ENV['DB_DBNAME']);
define('DB_USER',      $_ENV['DB_USER']);
define('DB_PASSWORD',  $_ENV['DB_PASSWORD']);
define('DB_CHARSET',   $_ENV['DB_CHARSET']);
```

- **Para** (configuração local):

```php
define('DB_HOST',      'localhost');
define('DB_DBNAME',    'nome_do_banco_de_dados');
define('DB_USER',      'usuario_mysql');
define('DB_PASSWORD',  'senha_mysql');
define('DB_CHARSET',   'utf8');
```

### 3. Iniciar o servidor

Com o XAMPP ou WampServer em execução, coloque o projeto dentro da pasta `htdocs/` (XAMPP) ou `www/` (WampServer) e acesse via navegador:

```
http://localhost/api_tasks_unmep/api/
```

---

## Arquivo SQL — `database/api_task_unmep_database.sql`

O arquivo [`database/api_task_unmep_database.sql`](database/api_task_unmep_database.sql) é um dump gerado pelo **phpMyAdmin** e contém:

1. **Criação da tabela `task`** com a seguinte estrutura:

```sql
CREATE TABLE `task` (
  `id`          int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title`       varchar(255)     DEFAULT NULL,
  `description` text             DEFAULT NULL,
  `status`      enum('pendente','executando','concluída') DEFAULT NULL,
  `date_at`     datetime         DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

2. **Inserção de dados fictícios** — 4 tarefas de exemplo com variados status (`pendente`, `executando`, `concluída`) para que a API já possa ser testada imediatamente após a importação.

3. **Definição de AUTO_INCREMENT** — o campo `id` é chave primária com incremento automático.

> ⚠️ O banco de dados esperado por padrão se chama `nome_banco_dados`. Certifique-se de criá-lo antes de importar o script, ou ajuste o nome conforme preferir e reflita essa mudança no [`config.php`](api/config.php).

---

## Estrutura do Projeto

```
api_tasks_unmep
├── api
│   ├── core
│   │   ├── class
│   │   │   └── Database.php        # Classe de conexão e operações com o banco de dados (PDO)
│   │   ├── controllers
│   │   │   └── Main.php            # Controller principal: valida entradas e retorna respostas JSON
│   │   ├── models
│   │   │   └── Task.php            # Model: executa as queries SQL relacionadas à tabela task
│   │   └── routes.php              # Mapeamento das rotas (query string ?a=) para métodos do controller
│   ├── vendor                      # Dependências gerenciadas pelo Composer (PSR-4 autoload)
│   ├── composer.json
│   ├── composer.lock
│   ├── config.php                  # Configurações globais da aplicação e credenciais do banco
│   └── index.php                   # Ponto de entrada da aplicação
└── database
    └── api_task_unmep_database.sql # Script SQL com estrutura e dados iniciais da tabela task
```

---

## Principais Arquivos PHP

### [`api/index.php`](api/index.php)
Ponto de entrada da aplicação. Responsável por:
- Iniciar a sessão PHP (`session_start()`)
- Carregar as configurações globais via `config.php`
- Registrar o autoloader do Composer (`vendor/autoload.php`)
- Carregar o sistema de roteamento (`core/routes.php`)

### [`api/config.php`](api/config.php)
Define as constantes globais da aplicação, incluindo nome, versão e as credenciais de conexão com o MySQL. Em produção (Vercel), os valores são lidos de **variáveis de ambiente**. Localmente, as constantes são definidas diretamente com os dados da máquina.

### [`api/core/routes.php`](api/core/routes.php)
Mapeia o parâmetro `?a=` da query string para um método específico do controller. O roteamento funciona da seguinte forma:

```php
$routes = [
    'list_task'    => 'main@index',
    'create_task'  => 'main@create',
    'edit_task'    => 'main@edit',
    'delete_task'  => 'main@destroy',
    'display_task' => 'main@show',
];
```

Se nenhuma ação for informada (ou a ação não existir), a rota padrão é `list_task`, que exibe todas as tarefas.

### [`api/core/class/Database.php`](api/core/class/Database.php)
Classe de abstração de banco de dados utilizando **PDO**. Implementa os métodos:
- `select()` — valida e executa instruções `SELECT`, retornando resultados como objetos
- `insert()` — valida e executa instruções `INSERT`
- `update()` — valida e executa instruções `UPDATE` com bind de parâmetros nomeados
- `delete()` — valida e executa instruções `DELETE`

Todos os métodos abrem e fecham a conexão por demanda, e usam **prepared statements** para prevenir SQL Injection.

### [`api/core/controllers/Main.php`](api/core/controllers/Main.php)
Controller principal que recebe as requisições HTTP, valida os dados de entrada e retorna as respostas em **JSON**. Seus métodos correspondem a cada rota:

| Método | Rota | Ação |
|---|---|---|
| `index()` | `list_task` | Lista todas as tarefas |
| `create()` | `create_task` | Cria uma nova tarefa após validar todos os campos obrigatórios |
| `edit()` | `edit_task` | Atualiza campos específicos de uma tarefa existente |
| `destroy()` | `delete_task` | Remove uma tarefa pelo `id` |
| `show()` | `display_task` | Exibe uma tarefa específica pelo `id` |

### [`api/core/models/Task.php`](api/core/models/Task.php)
Model responsável pelas queries SQL da tabela `task`. Encapsula as operações:
- `list_task()` — `SELECT * FROM task`
- `create_task()` — `INSERT INTO task ...` com os dados do `$_POST`
- `edit_task($id)` — `UPDATE task SET ... WHERE id = :id`, montando dinamicamente apenas os campos enviados
- `delete_task($id)` — `DELETE FROM task WHERE id = :id`
- `find_task($id)` — `SELECT * FROM task WHERE id IN ($id)`

---

## Testando a API Localmente

Para testar os endpoints da API recomenda-se o uso de ferramentas como:

- **[Postman](https://www.postman.com/downloads/)** — utilize `form-data` no corpo da requisição para simular o envio de formulários
- **[Insomnia](https://insomnia.rest/download)** — utilize `Multipart Form` para o mesmo fim

Essas ferramentas permitem configurar o método HTTP (GET, POST, DELETE), os parâmetros de URL e o corpo da requisição de forma visual e prática.

---

## Respostas da API (Response)

Todas as respostas da API são retornadas no formato **JSON**. As chaves de nível superior indicam o resultado da operação:

| Chave | Significado |
|---|---|
| `tasks` | Lista de tarefas retornada com sucesso |
| `task` | Objeto de tarefa única retornado com sucesso |
| `success` | Operação realizada com sucesso (ex: criação) |
| `message` | Mensagem descritiva do resultado da operação |
| `removed` | ID da tarefa que foi removida |
| `error` | Erro de validação ou de existência do recurso |

---

## Endpoints da API

### `GET /` ou `GET /?a=list_task` — Listar todas as tarefas

Retorna a lista completa de tarefas cadastradas.

**Headers:** Não obrigatórios

**Parâmetros de URL:** Nenhum

**Resposta de sucesso `200`:**
```json
{
    "tasks": [
        {
            "id": 1,
            "title": "Tarefa 1",
            "description": "Lorem ipsum ut elit magna hendrerit amet habitasse pulvinar...",
            "status": "pendente",
            "date_at": "23-01-2024"
        },
        {
            "id": 2,
            "title": "Tarefa 2",
            "description": "Lorem ipsum ut elit magna hendrerit amet habitasse pulvinar...",
            "status": "concluída",
            "date_at": "23-01-2024"
        }
    ]
}
```

---

### `POST /?a=create_task` — Criar uma nova tarefa

Adiciona uma nova tarefa à lista.

**Headers:** Não obrigatórios

**Body** (`form-data` / `multipart-form`):

| Campo | Tipo | Obrigatório | Descrição |
|---|---|---|---|
| `title` | string | ✅ Sim | Título da tarefa |
| `description` | text | ✅ Sim | Descrição da tarefa |
| `status` | string | ✅ Sim | `pendente`, `executando` ou `concluída` |

**Exemplo de body:**
```json
{
    "title": "Título da tarefa",
    "description": "Descrição da tarefa que será feita",
    "status": "pendente"
}
```

**Resposta de sucesso `200`:**
```json
{
    "success": {
        "message": "Tarefa criada com sucesso!"
    }
}
```

**Respostas de erro `200`:**
```json
{ "error": { "message": "Status não existe", "possible status": ["pendente","executando","concluída"] } }
{ "error": { "message": "O campo 'status' não foi definido" } }
{ "error": { "message": "O campo 'description' não foi definido" } }
{ "error": { "message": "O campo 'title' não foi definido" } }
{ "error": { "message": "Não foram preenchido todos os campos" } }
```

---

### `POST /?a=edit_task&id={id}` — Editar uma tarefa

Atualiza um ou mais campos de uma tarefa existente. Apenas os campos enviados serão alterados.

**Headers:** Não obrigatórios

**Parâmetros de URL:**

| Parâmetro | Tipo | Obrigatório | Descrição |
|---|---|---|---|
| `id` | number | ✅ Sim | ID da tarefa a ser editada |

**Body** (`form-data` / `multipart-form`) — todos opcionais, mas ao menos um deve ser informado:

| Campo | Tipo | Obrigatório | Descrição |
|---|---|---|---|
| `title` | string | ❌ Opcional | Novo título da tarefa |
| `description` | text | ❌ Opcional | Nova descrição da tarefa |
| `status` | string | ❌ Opcional | `pendente`, `executando` ou `concluída` |

**Exemplo de body:**
```json
{
    "title": "Título alterado",
    "description": "Descrição alterada",
    "status": "pendente"
}
```

**Resposta de sucesso `200`:**
```json
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
```

**Respostas de erro `200`:**
```json
{ "error": { "message": "Status não existe", "possible status": ["pendente","executando","concluída"] } }
{ "error": { "message": "Tarefa não existe" } }
{ "error": { "message": "Não foi especificado o 'id' da tarefa" } }
```

---

### `DELETE /?a=delete_task&id={id}` — Excluir uma tarefa

Remove permanentemente uma tarefa da lista.

**Headers:** Não obrigatórios

**Parâmetros de URL:**

| Parâmetro | Tipo | Obrigatório | Descrição |
|---|---|---|---|
| `id` | number | ✅ Sim | ID da tarefa a ser excluída |

**Body:** Não necessário

**Resposta de sucesso `200`:**
```json
{
    "removed": 5,
    "message": "Tarefa deletada com sucesso!"
}
```

**Respostas de erro `200`:**
```json
{ "error": { "message": "Tarefa não existe" } }
```

---

### `GET /?a=display_task&id={id}` — Exibir uma tarefa específica

Retorna os dados de uma única tarefa pelo seu ID.

**Headers:** Não obrigatórios

**Parâmetros de URL:**

| Parâmetro | Tipo | Obrigatório | Descrição |
|---|---|---|---|
| `id` | number | ✅ Sim | ID da tarefa a ser exibida |

**Body:** Não necessário

**Resposta de sucesso `200`:**
```json
{
    "task": [
        {
            "id": 1,
            "title": "Tarefa 1",
            "description": "Lorem ipsum ut elit magna...",
            "status": "pendente",
            "date_at": "23-01-2024"
        }
    ]
}
```

**Respostas de erro `200`:**
```json
{ "error": { "message": "Tarefa não existe" } }
{ "error": { "message": "Não foi especificado o 'id' da tarefa" } }
```

---

## Hospedagem: Vercel + Clever Cloud

### Vercel (API PHP)

A API é hospedada gratuitamente na **[Vercel](https://vercel.com)**, uma plataforma de deploy focada em frontend e funções serverless que também suporta PHP via runtime.

O deploy é feito conectando o repositório GitHub à Vercel. A cada novo `push` na branch `main`, a Vercel realiza o deploy automático. As **variáveis de ambiente** (`DB_HOST`, `DB_DBNAME`, `DB_USER`, `DB_PASSWORD`, `DB_CHARSET`) são configuradas diretamente no painel da Vercel em **Settings → Environment Variables**, sendo injetadas na aplicação PHP via `$_ENV['...']` (lidas em [`api/config.php`](api/config.php)).

> O arquivo `vercel.json` (não versionado, presente no `.gitignore`) é usado para configurar o roteamento da aplicação PHP na plataforma, direcionando todas as requisições para o `api/index.php`.

### Clever Cloud (Banco de dados MySQL)

Como a Vercel não oferece banco de dados relacional nativo, foi utilizado o **[Clever Cloud](https://www.clever-cloud.com)** para provisionar uma instância **MySQL gratuita** na nuvem.

O processo consiste em:
1. Criar uma conta no Clever Cloud
2. Criar um add-on do tipo **MySQL** (plano gratuito disponível)
3. Obter as credenciais de conexão fornecidas pelo painel (host, nome do banco, usuário, senha e charset)
4. Inserir essas credenciais como variáveis de ambiente na Vercel

Com isso, a API hospedada na Vercel se conecta ao banco MySQL do Clever Cloud a cada requisição, utilizando **PDO com conexão persistente** (definida em [`Database.php`](api/core/class/Database.php)).
