<?php

namespace App;

enum ProfilStatus: string
{
    case Inactive = 'inactive';
    case Pending = 'pending';
    case Active = 'active';
}
