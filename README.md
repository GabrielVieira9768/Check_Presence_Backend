# 🖥️ Check Presence API (Back-end)

API desenvolvida com **Laravel 10+**, responsável pelo gerenciamento de usuários, matérias, aulas e registros de presença para o sistema **Check Presence**. Essa API se comunica com o app mobile via **endpoints REST** autenticados com **Laravel Sanctum**.

---

## ⚙️ Funcionalidades

- Autenticação via matrícula e senha
- Geração e leitura de QR Codes para registrar presença
- Associação entre alunos e matérias
- Controle de aulas (data, hora, local)
- Registro de presença com status e horário
- Exibição de presenças e faltas por matéria
- Acesso diferenciado para alunos e professores

---

## 🧱 Tecnologias Utilizadas

- PHP 8.2+
- Laravel 10+
- Laravel Sanctum (autenticação de API)
- MySQL
- Eloquent ORM
- Composer
- Vite + Blade (frontend web opcional)
- Laravel Breeze (starter kit)

---

## 🚀 Como executar o projeto

Para executar o projeto você deve seguir os seguintes passos:

- Copie o arquivo `.env.example`, renomeie sua cópia para `.env`, altere o  `APP_URL` para seu ip e o `DB_DATABASE` para `check_presence`
- Crie um banco 'MySql' com o nome de `check_presence`
- execute o comando: ```composer install```
- execute o comando: ```php artisan key:generate``` 
- execute o comando: ```npm install```
- execute o comando: ```npm run build```
