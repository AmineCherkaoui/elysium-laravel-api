<?php
namespace App\Enums;

enum ProductCategory: string
{
    case INTERIEUR = 'INTERIEUR';
    case EXTERIEUR = 'EXTERIEUR';
    case MOBILE    = 'MOBILE';
    case VITRINE   = 'VITRINE';
    case FLEXIBLE  = 'FLEXIBLE';
}
