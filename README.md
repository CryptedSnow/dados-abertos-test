<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Instruções

Antes de executar os containers, você pode escolher a versão do ```PHP``` de sua preferência (```8.0```,```8.1```,```8.2```,```8.3```,```8.4```). No arquivo ```docker-compose.yml``` em ```context```  escolha a versão:
```
// Examplo: Mudar version para 8.0
context: ./docker/version 
```

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

5 - No arquivo ```.env```, configure o seguinte trecho para se conectar a aplicação ao container do MySQL que se encontra no Docker:
```
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=dados-abertos-test
DB_USERNAME=user
DB_PASSWORD=password
```

6 - Execute as ```migration``` para criar o banco de dados e suas tabelas: 
```
docker-compose exec app php artisan migrate
```

7 - Para usar o ```phpMyAdmin``` do Docker, você pode acessar:
```
http://localhost:8081
```

9 - O dashboard estará disponível:

![](https://raw.githubusercontent.com/CryptedSnow/dados-abertos-test/refs/heads/main/public/img/01.png)

10 - Verifique o banco de dados criado ```dados-abertos-test```.

![](https://raw.githubusercontent.com/CryptedSnow/dados-abertos-test/refs/heads/main/public/img/02.png)

11 - Verifique a tabela ```deputados```:

![](https://raw.githubusercontent.com/CryptedSnow/dados-abertos-test/refs/heads/main/public/img/03.png)

12 - A tabela ```deputados```está vazia.

![](https://raw.githubusercontent.com/CryptedSnow/dados-abertos-test/refs/heads/main/public/img/04.png)

13 - Verifique a tabela ```despesas```.

![](https://raw.githubusercontent.com/CryptedSnow/dados-abertos-test/refs/heads/main/public/img/05.png)

14 - A tabela ```despesas```está vazia.

![](https://raw.githubusercontent.com/CryptedSnow/dados-abertos-test/refs/heads/main/public/img/06.png)

## Execução dos Jobs

01 - Execute o comando para executar as Jobs da aplicação:

```
docker compose exec app php artisan queue:work
```

02 - Agora o processo de Jobs está em andamento, sendo possível realizar a inserção de dados no MySQL de registros da API online chamada [Dados Abertos](https://dadosabertos.camara.leg.br/swagger/api.html).

![](https://raw.githubusercontent.com/CryptedSnow/dados-abertos-test/refs/heads/main/public/img/07.png)

03 - Insira o endereço abaixo no navegador ou alguma API Plataform para iniciar o processo de inserção de dados:

```
http://localhost:8000/api/iniciar-importacao
```

04 - Com isso você pode ver a seguinte mensagem:

![](https://raw.githubusercontent.com/CryptedSnow/dados-abertos-test/refs/heads/main/public/img/08.png)

05 - Agora você pode ver que está sendo executada a Jobs pelo terminal.

![](https://raw.githubusercontent.com/CryptedSnow/dados-abertos-test/refs/heads/main/public/img/09.png)

06 - No arquivo ```laravel.log``` você vai notar a inserção dos deputados na tabela ```deputados``` e as despesas feitas na tabela ```despesas```.

![](https://raw.githubusercontent.com/CryptedSnow/dados-abertos-test/refs/heads/main/public/img/10.png)

07 - O processo pode demorar, aguarde até finalizar.

![](https://raw.githubusercontent.com/CryptedSnow/dados-abertos-test/refs/heads/main/public/img/11.png)

08 - Perceba que a tabela ```deputados``` agora tem registros.

![](https://raw.githubusercontent.com/CryptedSnow/dados-abertos-test/refs/heads/main/public/img/12.png)

09 - E a tabela ```despesas``` também há registros.

![](https://raw.githubusercontent.com/CryptedSnow/dados-abertos-test/refs/heads/main/public/img/13.png)

## Execução de REST API

Se você tem seguido as instruções acima, você precisa de alguma API Plataform para executar os endpoints, você pode usar o [POSTMAN](https://www.postman.com/) por exemplo. É necessário instalar o Postman em sua máquina local para testes locais.

![](https://raw.githubusercontent.com/CryptedSnow/dados-abertos-test/refs/heads/main/public/img/14.png)

Agora você precisa seguir com a atenção para executar os endpoints:

> Listar deputados

**GET: localhost:8000/api/listar-deputados**

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

> Listar despesas de determinado deputado

**GET: localhost:8000/api/buscar-despesas-deputado?nome=**
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
