<?php

namespace App\Enums;

enum UserRole: string
{
    case Admin = 'admin';
    // Employee role will be added as a feature after finishing the project.
    // case Employee = 'employee';
    case Customer = 'customer';
}
