<?php

namespace App\Constraints;

enum HttpMethod: string
{
    case POST = 'POST';
    case GET = 'GET';
}
