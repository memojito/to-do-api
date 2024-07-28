<?php

namespace App\Enum;

enum TodoState: string
{
    case DRAFT = 'DRAFT';
    case CREATED = 'CREATED';
    case COMPLETED = 'COMPLETED';
}