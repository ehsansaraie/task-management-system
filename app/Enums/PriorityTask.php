<?php

namespace App\Enums;

enum PriorityTask:string
{
    case High = 'high';
    case Average = 'average';
    case Down = 'down';
}