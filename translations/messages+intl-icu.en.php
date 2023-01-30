<?php

declare(strict_types=1);

return [
    'heading' => [
        'employments' => 'Employments'
    ],
    'employment' => [
        'present' => 'Present',
        'duration' => <<<TRANSLATION
        {years, plural, =0 {} one {1 yr} other {# yrs}}
        {months, plural, =0 {} one {1 mo} other {# mos}}
        TRANSLATION
    ]
];
