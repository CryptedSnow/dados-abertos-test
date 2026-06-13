<?php

namespace App\Http\Controllers\Api;

use OpenApi\Attributes as OA;

#[OA\Info(
    title: 'Dados Abertos API',
    version: '1.0.0',
    description: 'API REST para importação e consulta de deputados e despesas'
)]
#[OA\Server(
    url: 'http://localhost:8000/api',
    description: 'Servidor local (Docker)'
)]
class SwaggerInfo {}
