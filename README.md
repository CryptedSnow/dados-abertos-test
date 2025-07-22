<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Instruções

1 - Ative os containers do Docker:
```
docker-compose up -d
```

2 - Execute o ```composer install``` para criar a pasta ```vendor```:
```
docker-compose exec app composer install
```

3 - Crie o arquivo ```.env```:
```
docker-compose exec app cp .env.example .env  
```

4 - Crie a chave criptografada (Vai preencher o ```APP_KEY=``` do arquivo ```.env``` de forma automática):
```
docker-compose exec app php artisan key:generate
```

5 - No arquivo ```.env```, configure o seguinte trecho para se conectar a aplicação ao container do PostgreSQL que se encontra no Docker:
```
DB_CONNECTION=pgsql
DB_HOST=pgsql
DB_PORT=5432
DB_DATABASE=dados-abertos-test
DB_USERNAME=postgres
DB_PASSWORD=secret
```

6 - Execute as migration para criar o banco de dados e suas tabelas: 
```
docker-compose exec app php artisan migrate
```

7 - Para usar o ```pgAdmin``` do Docker, você pode acessar:
```
http://localhost:5050
```

Você vai ver

(Foto)

Use as seguintes credenciais para fazer login e clique no botão ```Login```:

(Foto)


8 - Após realizar o login, o dashboard estará disponível:

(Foto)

9 - Crie um servidor: ```Servers -> Register -> Server```.

(Foto)

10 - Na aba ```General``` no campo ```Name```, você pode escolher qualquer nome para seu servidor (exceto ```localhost```), no meu exemplo vou usar ```test-postgres```.

(Foto)

11 - Na aba ```Connection```, você precisa inserir os seguintes valores:
- Host name/address: ```pgsql```
- Port: ```5432```
- Maintenance database: ```postgres```
- Username: ```postgres```
- Password: ```secret```

Finalmente, clique no botão ```Save```.

(Foto)

12 - O servidor ```test-postgres``` foi criado.

(Foto)

13 - Verifique o banco de dados criado: ```test-postgres -> Databases -> dados-abertos-test```.

(Foto)

14 - Verifique a tabela ```deputados```: ```dados-abertos-test -> Schemas -> public -> Tables -> deputados```.

(Foto)

15 - A tabela ```deputados``` vai estar vazia: ```deputados -> View/Edit Data -> All Rows```.

(Foto)

16 - Verifique a tabela ```despesas```: ```dados-abertos-test -> Schemas -> public -> Tables -> despesas```.

(Foto)

17 - A tabela ```despesas``` vai estar vazia: ```despesas -> View/Edit Data -> All Rows```.

(Foto)
