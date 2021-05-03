# Make Transactions

<h3 align="center">
   Aplicação utilizada para realizar transações.<br><br> Os usuários ao se cadastrarem recebem R$ 100.00 de Bônus. Usuários podem enviar dinheiro(efetuar transferência) para lojistas e entre usuários. Lojistas apenas recebem transferências.
   <br><br>
</h3>

### Tecnologias
-   [PHP 7.3](https://www.php.net/)
-   [MySQL](https://www.mysql.com/)
-   [Laravel 8](https://laravel.com/)
-   [Laravel Passport](https://laravel.com/docs/8.x/passport)
-   [Laradock](https://laradock.io/)
-   [Docker](https://www.docker.com/)


## Instalação

Clone da Aplicação
  `git clone https://github.com/cleberbonifacio/make-transactions.git`

Criar .env na raiz do projeto utilizando o .env.example como referência

Fazer a instalação do Laradock
  `cd laradock`
  `git clone https://github.com/laradock/laradock.git`
  
Criar .env na raiz de Laradock utilizando o .env.example como referência

Criar Containers
  `cd laradock`
  `docker-compose up -d nginx mysql phpmyadmin`

Rodar migrations do Banco de dados
  `php artisan migrate`

### Telas
  
  <img src="https://github.com/cleberbonifacio/make-transactions/blob/main/prints/registerUser.PNG">
  <img src="https://github.com/cleberbonifacio/make-transactions/blob/main/prints/loginUser.PNG">
  <img src="https://github.com/cleberbonifacio/make-transactions/blob/main/prints/detailUser.PNG">
  <img src="https://github.com/cleberbonifacio/make-transactions/blob/main/prints/authorized.PNG">
  <img src="https://github.com/cleberbonifacio/make-transactions/blob/main/prints/Unauthorized.PNG">
  
  


