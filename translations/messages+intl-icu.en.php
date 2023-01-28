<?php

declare(strict_types=1);

return [
    'header' => [
        'employments' => 'Employments'
    ],
    'employment' => [
        'present' => 'Present',
        'duration' => <<<TRANSLATION
        {years, plural, =0 {} one {1 year} other {# years}}
        {months, plural, =0 {} one {1 month} other {# months}}
        TRANSLATION
    ]
];
