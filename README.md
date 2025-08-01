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

6 - Execute as ```migration``` para criar o banco de dados e suas tabelas: 
```
docker-compose exec app php artisan migrate
```

7 - Para usar o ```pgAdmin``` do Docker, você pode acessar:
```
http://localhost:5050
```

8 - Use as seguintes credenciais para fazer login e depois clique no botão ```Login```:

```
email: admin@admin.com
password: admin
```

![](https://raw.githubusercontent.com/CryptedSnow/dados-abertos-test/refs/heads/main/public/img/01.png)

9 - Após realizar o login, o dashboard estará disponível:

![](https://raw.githubusercontent.com/CryptedSnow/dados-abertos-test/refs/heads/main/public/img/02.png)

10 - Crie um servidor: ```Servers -> Register -> Server```.

![](https://raw.githubusercontent.com/CryptedSnow/dados-abertos-test/refs/heads/main/public/img/03.png)

11 - Na aba ```General``` no campo ```Name```, você pode escolher qualquer nome para seu servidor (exceto ```localhost```), no meu exemplo vou usar ```test-postgres```.

![](https://raw.githubusercontent.com/CryptedSnow/dados-abertos-test/refs/heads/main/public/img/04.png)

12 - Na aba ```Connection```, você precisa inserir os seguintes valores:
- Host name/address: ```pgsql```
- Port: ```5432```
- Maintenance database: ```postgres```
- Username: ```postgres```
- Password: ```secret```

Finalmente, clique no botão ```Save```.

![](https://raw.githubusercontent.com/CryptedSnow/dados-abertos-test/refs/heads/main/public/img/05.png)

13 - O servidor ```test-postgres``` foi criado.

![](https://raw.githubusercontent.com/CryptedSnow/dados-abertos-test/refs/heads/main/public/img/06.png)

14 - Verifique o banco de dados criado: ```test-postgres -> Databases -> dados-abertos-test```.

![](https://raw.githubusercontent.com/CryptedSnow/dados-abertos-test/refs/heads/main/public/img/07.png)

15 - Verifique a tabela ```deputados```: ```dados-abertos-test -> Schemas -> public -> Tables -> deputados```.

![](https://raw.githubusercontent.com/CryptedSnow/dados-abertos-test/refs/heads/main/public/img/08.png)

16 - Verifique a quantidade de registros da tabela ```deputados```: ```deputados -> View/Edit Data -> All Rows```.

![](https://raw.githubusercontent.com/CryptedSnow/dados-abertos-test/refs/heads/main/public/img/09.png)

17 - A tabela ```deputados```está vazia.

![](https://raw.githubusercontent.com/CryptedSnow/dados-abertos-test/refs/heads/main/public/img/10.png)

18 - Verifique a quantidade de registros da tabela ```despesas```: ```despesas -> View/Edit Data -> All Rows```.

![](https://raw.githubusercontent.com/CryptedSnow/dados-abertos-test/refs/heads/main/public/img/11.png)

19 - A tabela ```despesas```está vazia.

![](https://raw.githubusercontent.com/CryptedSnow/dados-abertos-test/refs/heads/main/public/img/12.png)

## Execução dos Jobs

01 - Execute o comando para executar as Job da aplicação:

```
docker compose exec app php artisan queue:work
```

02 - Agora o processo de Jobs está em andamento, sendo possível realizar a inserção de dados no PostgreSQL de registros da API online chamada [Dados Abertos](https://dadosabertos.camara.leg.br/swagger/api.html).

![](https://raw.githubusercontent.com/CryptedSnow/dados-abertos-test/refs/heads/main/public/img/13.png)

03 - Insira o endereço abaixo no navegador ou alguma API Plataform para iniciar o processo de inserção de dados:

```
http://localhost:8000/iniciar-importacao
```

04 - Com isso você pode ver a seguinte mensagem:

![](https://raw.githubusercontent.com/CryptedSnow/dados-abertos-test/refs/heads/main/public/img/14.png)

05 - Agora você pode ver que está sendo executada a Jobs pelo terminal.

![](https://raw.githubusercontent.com/CryptedSnow/dados-abertos-test/refs/heads/main/public/img/15.png)

06 - No arquivo ```laravel.log``` você vai notar a inserção dos deputados na tabela ```deputados``` e as despesas feitas na tabela ```despesas```.

![](https://raw.githubusercontent.com/CryptedSnow/dados-abertos-test/refs/heads/main/public/img/16.png)

07 - O processo pode demorar, aguarde até finalizar.

![](https://raw.githubusercontent.com/CryptedSnow/dados-abertos-test/refs/heads/main/public/img/17.png)

08 - Perceba que a tabela ```deputados``` agora tem registros.

![](https://raw.githubusercontent.com/CryptedSnow/dados-abertos-test/refs/heads/main/public/img/18.png)

09 - E a tabela ```despesas``` também há registros.

![](https://raw.githubusercontent.com/CryptedSnow/dados-abertos-test/refs/heads/main/public/img/19.png)

## Execução de REST API

Se você tem seguido as instruções acima, você precisa de alguma API Plataform para executar os endpoints, você pode usar o [POSTMAN](https://www.postman.com/) por exemplo. É necessário instalar o Postman em sua máquina local para testes locais.

![](https://raw.githubusercontent.com/CryptedSnow/dados-abertos-test/refs/heads/main/public/img/20.png)

Você precisa seguir com a atenção para executar os endpoints:

. Listar todos os deputados

**GET: localhost:8000/listar-deputados**

```
// Response - Status: 200 OK
{
    "data": [
        {
            "id": 1,
            "camara_id": 204379,
            "nome": "Acácio Favacho",
            "partido": "MDB",
            "uf": "AP"
        },
        ...
        {
            "id": 511,
            "camara_id": 220552,
            "nome": "Zucco",
            "partido": "PL",
            "uf": "RS"
        }
    ]
}
```
. Buscar determinado deputado

**GET: localhost:8000/buscar-deputado?nome=**
- Você precisa alterar **nome=** para **nome=Tiririca**.

```
// Response - Status: 200 OK
{
    "data": [
        {
            "id": 484,
            "camara_id": 160976,
            "nome": "Tiririca",
            "partido": "PL",
            "uf": "SP"
        }
    ]
}
```

. Listar todos as despesas

**GET: localhost:8000/listar-despesas**

```
// Response - Status: 200 OK
{
    "data": [
        {
            "id": 1,
            "deputado_id": "Acácio Favacho",
            "tipo_despesa": "MANUTENÇÃO DE ESCRITÓRIO DE APOIO À ATIVIDADE PARLAMENTAR",
            "valor": "750.00",
            "fornecedor": "AMORETTO CAFES EXPRESSO LTDA",
            "url_documento": "https://www.camara.leg.br/cota-parlamentar/documentos/publ/3308/2025/7864352.pdf",
            "data_documento": null
        },
        ...
        {
            "id": 97949,
            "deputado_id": "Zucco",
            "tipo_despesa": "PASSAGEM AÉREA - SIGEPA",
            "valor": "3126.02",
            "fornecedor": "TAM",
            "url_documento": null,
            "data_documento": null
        }
    ]
}
```

. Listar despesas por determinado deputado

**GET: localhost:8000/buscar-despesas-deputado?nome=**
- Você precisa alterar **nome=** para **nome=Tiririca**.

```
// Response - Status: 200 OK
{
    "data": [
        {
            "id": 92967,
            "deputado_id": "Tiririca",
            "tipo_despesa": "PASSAGEM AÉREA - SIGEPA",
            "valor": "1353.53",
            "fornecedor": "TAM",
            "url_documento": null,
            "data_documento": null
        },
        ...
        {
            "id": 92957,
            "deputado_id": "Tiririca",
            "tipo_despesa": "HOSPEDAGEM ,EXCETO DO PARLAMENTAR NO DISTRITO FEDERAL.",
            "valor": "1505.18",
            "fornecedor": "HOTELARIA ACCOR BRASIL S/A",
            "url_documento": "https://www.camara.leg.br/cota-parlamentar/documentos/publ/2395/2025/7948484.pdf",
            "data_documento": null
        }
    ]
}
```
