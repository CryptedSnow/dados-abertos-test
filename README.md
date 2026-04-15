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
    {
      "id": 2,
      "camara_id": 220714,
      "nome": "Adail Filho",
      "partido": "MDB",
      "uf": "AM"
    },
    {
      "id": 3,
      "camara_id": 221328,
      "nome": "Adilson Barroso",
      "partido": "PL",
      "uf": "SP"
    },
    {
      "id": 4,
      "camara_id": 204560,
      "nome": "Adolfo Viana",
      "partido": "PSDB",
      "uf": "BA"
    },
    {
      "id": 5,
      "camara_id": 204528,
      "nome": "Adriana Ventura",
      "partido": "NOVO",
      "uf": "SP"
    },
    {
      "id": 6,
      "camara_id": 121948,
      "nome": "Adriano do Baldy",
      "partido": "PP",
      "uf": "GO"
    },
    {
      "id": 7,
      "camara_id": 74646,
      "nome": "Aécio Neves",
      "partido": "PSDB",
      "uf": "MG"
    },
    {
      "id": 8,
      "camara_id": 160508,
      "nome": "Afonso Florence",
      "partido": "PT",
      "uf": "BA"
    },
    {
      "id": 9,
      "camara_id": 136811,
      "nome": "Afonso Hamm",
      "partido": "PP",
      "uf": "RS"
    },
    {
      "id": 10,
      "camara_id": 178835,
      "nome": "Afonso Motta",
      "partido": "PDT",
      "uf": "RS"
    }
  ],
  "links": {
    "first": "http://localhost:8000/api/listar-deputados?page=1",
    "last": "http://localhost:8000/api/listar-deputados?page=52",
    "prev": null,
    "next": "http://localhost:8000/api/listar-deputados?page=2"
  },
  "meta": {
    "current_page": 1,
    "from": 1,
    "last_page": 52,
    "links": [
      {
        "url": null,
        "label": "&laquo; Previous",
        "active": false
      },
      {
        "url": "http://localhost:8000/api/listar-deputados?page=1",
        "label": "1",
        "active": true
      },
      {
        "url": "http://localhost:8000/api/listar-deputados?page=2",
        "label": "2",
        "active": false
      },
      {
        "url": "http://localhost:8000/api/listar-deputados?page=3",
        "label": "3",
        "active": false
      },
      {
        "url": "http://localhost:8000/api/listar-deputados?page=4",
        "label": "4",
        "active": false
      },
      {
        "url": "http://localhost:8000/api/listar-deputados?page=5",
        "label": "5",
        "active": false
      },
      {
        "url": "http://localhost:8000/api/listar-deputados?page=6",
        "label": "6",
        "active": false
      },
      {
        "url": "http://localhost:8000/api/listar-deputados?page=7",
        "label": "7",
        "active": false
      },
      {
        "url": "http://localhost:8000/api/listar-deputados?page=8",
        "label": "8",
        "active": false
      },
      {
        "url": "http://localhost:8000/api/listar-deputados?page=9",
        "label": "9",
        "active": false
      },
      {
        "url": "http://localhost:8000/api/listar-deputados?page=10",
        "label": "10",
        "active": false
      },
      {
        "url": null,
        "label": "...",
        "active": false
      },
      {
        "url": "http://localhost:8000/api/listar-deputados?page=51",
        "label": "51",
        "active": false
      },
      {
        "url": "http://localhost:8000/api/listar-deputados?page=52",
        "label": "52",
        "active": false
      },
      {
        "url": "http://localhost:8000/api/listar-deputados?page=2",
        "label": "Next &raquo;",
        "active": false
      }
    ],
    "path": "http://localhost:8000/api/listar-deputados",
    "per_page": 10,
    "to": 10,
    "total": 513
  }
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
      "id": 74373,
      "deputado_id": "Tiririca",
      "tipo_despesa": "PASSAGEM AÉREA - SIGEPA",
      "valor": "2165.21",
      "fornecedor": "Gol Linhas Aéreas",
      "url_documento": null,
      "data_documento": null
    },
    {
      "id": 74376,
      "deputado_id": "Tiririca",
      "tipo_despesa": "PASSAGEM AÉREA - SIGEPA",
      "valor": "2066.28",
      "fornecedor": "LATAM Airlines Brasil",
      "url_documento": null,
      "data_documento": null
    },
    {
      "id": 74362,
      "deputado_id": "Tiririca",
      "tipo_despesa": "COMBUSTÍVEIS E LUBRIFICANTES.",
      "valor": "231.60",
      "fornecedor": "BELIZE COMPANY AUTO POSTO LTDA",
      "url_documento": "http://www.camara.leg.br/cota-parlamentar/nota-fiscal-eletronica?ideDocumentoFiscal=8001992",
      "data_documento": null
    },
    {
      "id": 74370,
      "deputado_id": "Tiririca",
      "tipo_despesa": "LOCAÇÃO OU FRETAMENTO DE VEÍCULOS AUTOMOTORES",
      "valor": "6500.00",
      "fornecedor": "SUPREMA MOBILIDADE LTDA",
      "url_documento": "https://www.camara.leg.br/cota-parlamentar/documentos/publ/2395/2025/8007583.pdf",
      "data_documento": null
    },
    {
      "id": 74360,
      "deputado_id": "Tiririca",
      "tipo_despesa": "COMBUSTÍVEIS E LUBRIFICANTES.",
      "valor": "387.38",
      "fornecedor": "AUTO SERVICOS ROCAR LT",
      "url_documento": "https://www.camara.leg.br/cota-parlamentar/documentos/publ/2395/2025/8019933.pdf",
      "data_documento": null
    },
    {
      "id": 74364,
      "deputado_id": "Tiririca",
      "tipo_despesa": "DIVULGAÇÃO DA ATIVIDADE PARLAMENTAR.",
      "valor": "19000.00",
      "fornecedor": "Strike Media",
      "url_documento": "https://www.camara.leg.br/cota-parlamentar/documentos/publ/2395/2025/8009764.pdf",
      "data_documento": null
    },
    {
      "id": 74367,
      "deputado_id": "Tiririca",
      "tipo_despesa": "TELEFONIA",
      "valor": "636.44",
      "fornecedor": "Claro NXT Telecomunicações S.A",
      "url_documento": null,
      "data_documento": null
    },
    {
      "id": 74377,
      "deputado_id": "Tiririca",
      "tipo_despesa": "PASSAGEM AÉREA - SIGEPA",
      "valor": "1241.26",
      "fornecedor": "LATAM Airlines Brasil",
      "url_documento": null,
      "data_documento": null
    },
    {
      "id": 74378,
      "deputado_id": "Tiririca",
      "tipo_despesa": "PASSAGEM AÉREA - SIGEPA",
      "valor": "3035.75",
      "fornecedor": "LATAM Airlines Brasil",
      "url_documento": null,
      "data_documento": null
    },
    {
      "id": 74379,
      "deputado_id": "Tiririca",
      "tipo_despesa": "PASSAGEM AÉREA - SIGEPA",
      "valor": "2164.58",
      "fornecedor": "LATAM Airlines Brasil",
      "url_documento": null,
      "data_documento": null
    }
  ],
  "links": {
    "first": "http://localhost:8000/api/buscar-despesas-deputado?page=1",
    "last": "http://localhost:8000/api/buscar-despesas-deputado?page=6",
    "prev": null,
    "next": "http://localhost:8000/api/buscar-despesas-deputado?page=2"
  },
  "meta": {
    "current_page": 1,
    "from": 1,
    "last_page": 6,
    "links": [
      {
        "url": null,
        "label": "&laquo; Previous",
        "active": false
      },
      {
        "url": "http://localhost:8000/api/buscar-despesas-deputado?page=1",
        "label": "1",
        "active": true
      },
      {
        "url": "http://localhost:8000/api/buscar-despesas-deputado?page=2",
        "label": "2",
        "active": false
      },
      {
        "url": "http://localhost:8000/api/buscar-despesas-deputado?page=3",
        "label": "3",
        "active": false
      },
      {
        "url": "http://localhost:8000/api/buscar-despesas-deputado?page=4",
        "label": "4",
        "active": false
      },
      {
        "url": "http://localhost:8000/api/buscar-despesas-deputado?page=5",
        "label": "5",
        "active": false
      },
      {
        "url": "http://localhost:8000/api/buscar-despesas-deputado?page=6",
        "label": "6",
        "active": false
      },
      {
        "url": "http://localhost:8000/api/buscar-despesas-deputado?page=2",
        "label": "Next &raquo;",
        "active": false
      }
    ],
    "path": "http://localhost:8000/api/buscar-despesas-deputado",
    "per_page": 10,
    "to": 10,
    "total": 56
  }
}
```
