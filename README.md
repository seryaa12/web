# Desenvolvimento Web — HTML5, CSS, JavaScript e PHP

Repositório com seis projetos desenvolvidos durante a disciplina **Desenv. Web em HTML5, CSS, JavaScript e PHP**.

As atividades têm como objetivo aplicar os conceitos estudados ao longo da disciplina, explorando a criação de páginas web, estilização de interfaces, programação com JavaScript e desenvolvimento de aplicações com PHP e MySQL.

Cada projeto foi desenvolvido separadamente, com seus próprios arquivos e funcionalidades.

---

## Projetos

### 01. Cartão de Visitas

**Diretório:** `01-cartao-visitas`

Projeto de criação de um cartão de visitas digital, desenvolvido para apresentar informações pessoais e profissionais em uma página web.

A aplicação utiliza uma interface própria, com organização visual dos elementos e apresentação das informações de maneira objetiva.

**Tecnologias:**
- HTML5
- CSS3
- JavaScript

**Arquivos principais:**
- `index.html`
- `style.css`
- `script.js`

**Como executar:**

1. Abra a pasta `01-cartao-visitas`.
2. Localize o arquivo `index.html`.
3. Abra o arquivo diretamente no navegador.

---

### 02. Currículo

**Diretório:** `02-curriculo`

Projeto de desenvolvimento de um currículo em formato de página web, reunindo informações pessoais, acadêmicas e profissionais.

A proposta é apresentar os dados de maneira organizada, utilizando recursos de HTML e CSS para estruturar e estilizar o conteúdo.

**Tecnologias:**
- HTML5
- CSS3
- JavaScript

**Arquivos principais:**
- `index.html`
- `style.css`
- `script.js`

**Como executar:**

1. Abra a pasta `02-curriculo`.
2. Localize o arquivo `index.html`.
3. Abra o arquivo no navegador.

---

### 03. Formulário

**Diretório:** `03-formulario`

Projeto desenvolvido para trabalhar a criação e utilização de formulários em aplicações web.

A atividade explora a entrada de informações pelo usuário, a organização dos campos e a utilização de JavaScript para adicionar interatividade e tratar os dados informados.

**Tecnologias:**
- HTML5
- CSS3
- JavaScript

**Arquivos principais:**
- `index.html`
- `style.css`
- `script.js`

**Como executar:**

1. Abra a pasta `03-formulario`.
2. Localize o arquivo `index.html`.
3. Abra no navegador.
4. Utilize o formulário para testar suas funcionalidades.

---

### 04. Calculadora 1.0

**Diretório:** `04-calculadora1.0`

Primeira versão do projeto de calculadora, desenvolvida para realizar operações matemáticas por meio de uma interface interativa.

A aplicação utiliza JavaScript para processar os valores informados e apresentar os resultados das operações.

**Funcionalidades:**
- Adição.
- Subtração.
- Multiplicação.
- Divisão.

**Tecnologias:**
- HTML5
- CSS3
- JavaScript

**Arquivos principais:**
- `index.html`
- `style.css`
- `script.js`

**Como executar:**

1. Abra a pasta `04-calculadora1.0`.
2. Localize o arquivo `index.html`.
3. Abra no navegador.
4. Utilize a calculadora para realizar operações.

---

### 05. Calculadora 2.0

**Diretório:** `05-calculadora2.0`

Segunda versão do projeto de calculadora, com foco na resolução de equações do segundo grau utilizando a fórmula de Bhaskara.

O usuário informa os coeficientes da equação e a aplicação realiza os cálculos necessários para apresentar os resultados.

**Funcionalidades:**
- Entrada dos coeficientes A, B e C.
- Cálculo do discriminante (Delta).
- Aplicação da fórmula de Bhaskara.
- Cálculo das raízes da equação.
- Identificação de situações sem raízes reais.

**Tecnologias:**
- HTML5
- CSS3
- JavaScript

**Arquivos principais:**
- `index.html`
- `style.css`
- `script.js`

**Como executar:**

1. Abra a pasta `05-calculadora2.0`.
2. Localize o arquivo `index.html`.
3. Abra no navegador.
4. Informe os coeficientes da equação e execute o cálculo.

---

### 06. ACCESS — Sistema de Cadastro e Login

**Diretório:** `06-login`

Sistema de autenticação desenvolvido utilizando PHP e MySQL.

O ACCESS permite cadastrar usuários, realizar autenticação e acessar uma área restrita com informações individuais da conta.

Este projeto trabalha conceitos de desenvolvimento no lado do servidor, comunicação com banco de dados e gerenciamento de sessões.

**Funcionalidades:**
- Cadastro de usuários.
- Validação de nome, e-mail e senha.
- Verificação de e-mails já cadastrados.
- Armazenamento de senhas com `password_hash()`.
- Verificação de credenciais com `password_verify()`.
- Gerenciamento de sessões.
- Proteção de formulários com token CSRF.
- Painel individual do usuário.
- Encerramento de sessão (logout).

**Tecnologias:**
- HTML5
- CSS3
- PHP
- MySQL
- PDO

**Estrutura principal:**

```text
06-login/
├── config/
│   ├── conexao.php
│   └── seguranca.php
│
├── css/
│   └── style.css
│
├── database/
│   └── login.sql
│
├── cadastro.php
├── dashboard.php
├── index.php
└── logout.php
```

**Como executar:**

O projeto utiliza PHP e MySQL. Para executá-lo localmente, é possível utilizar o XAMPP.

**1. Iniciar o ambiente**

- Abra o XAMPP Control Panel.
- Inicie o Apache.
- Inicie o MySQL.

**2. Configurar o diretório**

Copie a pasta `06-login` para dentro do diretório `htdocs` do XAMPP.

Exemplo:

```text
C:\xampp\htdocs\06-login\
```

**3. Criar o banco de dados**

- Acesse `http://localhost/phpmyadmin`.
- Entre na opção de importação.
- Selecione o arquivo `database/login.sql`.
- Execute a importação.

O arquivo SQL cria o banco de dados `login` e a tabela `usuarios`.

**4. Conferir a conexão**

Abra o arquivo `config/conexao.php` e confira as configurações:

```php
$host = 'localhost';
$banco = 'login';
$usuario = 'root';
$senha = '';
```

Essas configurações correspondem ao ambiente padrão do XAMPP. Caso utilize outras credenciais, ajuste os valores.

**5. Acessar o sistema**

Com Apache e MySQL iniciados, abra:

```text
http://localhost/06-login/
```

**6. Testar o funcionamento**

- Acesse a opção de cadastro.
- Crie uma conta.
- Retorne à tela inicial.
- Entre com o e-mail e a senha cadastrados.
- Confira as informações exibidas no painel.
- Utilize a opção de logout para encerrar a sessão.

---

## Tecnologias utilizadas

| Tecnologia | Aplicação |
|---|---|
| HTML5 | Estruturação das páginas |
| CSS3 | Estilização das interfaces |
| JavaScript | Interatividade e lógica de programação |
| PHP | Processamento no servidor |
| MySQL | Armazenamento de dados |
| PDO | Comunicação com o banco de dados |

## Organização do repositório

```text
web/
│
├── .vscode/
│
├── 01-cartao-visitas/
│   ├── index.html
│   ├── script.js
│   └── style.css
│
├── 02-curriculo/
│   ├── index.html
│   ├── script.js
│   └── style.css
│
├── 03-formulario/
│   ├── index.html
│   ├── script.js
│   └── style.css
│
├── 04-calculadora1.0/
│   ├── index.html
│   ├── script.js
│   └── style.css
│
├── 05-calculadora2.0/
│   ├── index.html
│   ├── script.js
│   └── style.css
│
├── 06-login/
│   ├── config/
│   ├── css/
│   ├── database/
│   ├── cadastro.php
│   ├── dashboard.php
│   ├── index.php
│   └── logout.php
│
└── README.md
```

## Considerações finais

O desenvolvimento dos seis projetos permitiu trabalhar diferentes etapas da construção de aplicações web, desde a estruturação de páginas simples até a implementação de funcionalidades que envolvem lógica de programação, processamento no servidor e persistência de dados.

As atividades representam a aplicação prática dos conteúdos estudados na disciplina e contribuem para o desenvolvimento das habilidades técnicas necessárias na área de desenvolvimento web.

## Agradecimentos

Agradeço ao Professor Garabed pela orientação, pelos ensinamentos e pela oportunidade de colocar em prática os conhecimentos apresentados durante a disciplina.

**Obrigado por visitar meu repositório!**

---

**Disciplina:** Desenv. Web em HTML5, CSS, JavaScript e PHP  
**Repositório:** Projetos acadêmicos de desenvolvimento web
