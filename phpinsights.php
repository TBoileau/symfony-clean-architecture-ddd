<?php

declare(strict_types=1);

use NunoMaduro\PhpInsights\Domain\Insights\Composer\ComposerMustBeValid;
use NunoMaduro\PhpInsights\Domain\Insights\CyclomaticComplexityIsHigh;
use NunoMaduro\PhpInsights\Domain\Insights\ForbiddenNormalClasses;
use NunoMaduro\PhpInsights\Domain\Sniffs\ForbiddenSetterSniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\Files\LineLengthSniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\Formatting\SpaceAfterNotSniff;
use SlevomatCodingStandard\Sniffs\Classes\ForbiddenPublicPropertySniff;
use SlevomatCodingStandard\Sniffs\Classes\SuperfluousAbstractClassNamingSniff;
use SlevomatCodingStandard\Sniffs\Classes\SuperfluousExceptionNamingSniff;
use SlevomatCodingStandard\Sniffs\Classes\SuperfluousInterfaceNamingSniff;
use SlevomatCodingStandard\Sniffs\Commenting\InlineDocCommentDeclarationSniff;
use SlevomatCodingStandard\Sniffs\ControlStructures\DisallowYodaComparisonSniff;
use SlevomatCodingStandard\Sniffs\Functions\FunctionLengthSniff;
use SlevomatCodingStandard\Sniffs\Functions\UnusedParameterSniff;
use SlevomatCodingStandard\Sniffs\TypeHints\DisallowMixedTypeHintSniff;
use SlevomatCodingStandard\Sniffs\TypeHints\ParameterTypeHintSniff;

return [
    /*
    |--------------------------------------------------------------------------
    | Default Preset
    |--------------------------------------------------------------------------
    |
    | This option controls the default preset that will be used by PHP Insights
    | to make your code reliable, simple, and clean. However, you can always
    | adjust the `Metrics` and `Insights` below in this configuration file.
    |
    | Supported: "default", "laravel", "symfony", "magento2", "drupal"
    |
     */

    'preset' => 'symfony',

    /*
    |--------------------------------------------------------------------------
    | IDE
    |--------------------------------------------------------------------------
    |
    | This options allow to add hyperlinks in your terminal to quickly open
    | files in your favorite IDE while browsing your PhpInsights report.
    |
    | Supported: "textmate", "macvim", "emacs", "sublime", "phpstorm",
    | "atom", "vscode".
    |
    | If you have another IDE that is not in this list but which provide an
    | url-handler, you could fill this config with a pattern like this:
    |
    | myide://open?url=file://%f&line=%l
    |
     */

    'ide' => 'phpstorm',

    /*
    |--------------------------------------------------------------------------
    | Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may adjust all the various `Insights` that will be used by PHP
    | Insights. You can either add, remove or configure `Insights`. Keep in
    | mind, that all added `Insights` must belong to a specific `Metric`.
    |
     */

    'exclude' => [
        'build',
        'phpinsights.php',
        'src/Kernel.php',
        'src/Shared/Infrastructure/Symfony/Resources',
        'src/Security/Infrastructure/Symfony/Resources',
    ],

    'add' => [
    ],

    'remove' => [
        DisallowYodaComparisonSniff::class,
        ComposerMustBeValid::class,
        SuperfluousAbstractClassNamingSniff::class,
        SuperfluousInterfaceNamingSniff::class,
        SuperfluousExceptionNamingSniff::class,
        SpaceAfterNotSniff::class,
        ForbiddenPublicPropertySniff::class,
        DisallowMixedTypeHintSniff::class,
        InlineDocCommentDeclarationSniff::class,
    ],

    'config' => [
        UnusedParameterSniff::class => [
            'exclude' => [
                'src/Security/Infrastructure/Symfony/Security/Authenticator/Authenticator',
                'src/Security/Infrastructure/Doctrine/Type',
                'src/Shared/Infrastructure/Doctrine/Type',
                'src/Security/UserInterface/Form',
                'src/Shared/Infrastructure/Symfony/Maker',
                'src/Security/Infrastructure/Symfony/Security/Voter/UserVoter',
            ],
        ],
        ParameterTypeHintSniff::class => [
            'exclude' => [
                'src/Security/Infrastructure/Doctrine/Type',
                'src/Shared/Infrastructure/Doctrine/Type',
            ],
        ],
        LineLengthSniff::class => [
            'lineLimit' => 120,
            'absoluteLineLimit' => 120,
            'ignoreComments' => true,
        ],
        ForbiddenSetterSniff::class => [
            'exclude' => [
                'src/Security/Infrastructure/InMemory/Entity',
            ],
        ],
        CyclomaticComplexityIsHigh::class => [
            'maxComplexity' => 5,
            'exclude' => [
                'src/Shared/Infrastructure/Symfony/Kernel',
                'src/Shared/Infrastructure/Doctrine/DataFixtures',
                'src/Shared/Domain/ValueObject/Date/Time',
            ],
        ],
        ForbiddenNormalClasses::class => [
            'exclude' => [
                'src/Security/Domain/ValueObject',
                'src/Security/Domain/Entity',
                'src/Shared/Domain/ValueObject',
            ],
        ],
        FunctionLengthSniff::class => [
            'exclude' => [
                'src/Shared/Infrastructure/Symfony/Maker',
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Requirements
    |--------------------------------------------------------------------------
    |
    | Here you may define a level you want to reach per `Insights` category.
    | When a score is lower than the minimum level defined, then an error
    | code will be returned. This is optional and individually defined.
    |
     */

    'requirements' => [
        'min-quality' => 100,
        'min-complexity' => 85,
        'min-architecture' => 100,
        'min-style' => 100,
        'disable-security-check' => false,
    ],

    /*
    |--------------------------------------------------------------------------
    | Threads
    |--------------------------------------------------------------------------
    |
    | Here you may adjust how many threads (core) PHPInsights can use to perform
    | the analyse. This is optional, don't provide it and the tool will guess
    | the max core number available. This accept null value or integer > 0.
    |
     */

    'threads' => null,
];
