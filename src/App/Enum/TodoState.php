<?php

namespace App\Enum;

enum TodoState: string
{
    case DRAFT = 'draft';
    case CREATED = 'created';
    case COMPLETED = 'completed';
}