<?php

/*
 * This file was created by Jakub Szczerba
 * Contact: https://www.linkedin.com/in/jakub-szczerba-3492751b4/
*/

declare(strict_types=1);

namespace App\Dictionary;

class CollectionDictionary
{
    /* For levenshtein */
    public const KEY = 'przegląd';
    public const THRESHOLD = 3;

    /* Statuses */
    public const STATUS_SCHEDULED= 'zaplanowany';
    public const STATUS_NEW = 'nowy';
    public const STATUS_DATE = 'termin';

    /* Priorities keys*/
    public const VERY_IMPORTANT = 'bardzo pilne';
    public const IMPORTANT = 'pilna';

    /* Priorities */
    public const CRITICAL = 'krytyczny';
    public const HIGH = 'wysoki';
    public const NORMAL = 'normalny';
}