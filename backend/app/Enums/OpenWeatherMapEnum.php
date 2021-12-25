<?php

namespace App\Enums;

/**
 * Class OpenWeatherMapEnum
 */
class OpenWeatherMapEnum
{
    public const UNIT_STANDARD = 'standard';
    public const UNIT_METRIC = 'metric';
    public const UNIT_IMPERIAL = 'imperial';

    public const CELSIUS = 'C';
    public const KELVIN = 'K';
    public const FAHRENHEIT = 'F';

    public const LANG_RU = 'ru';

    public const UNITS = [
        self::CELSIUS => self::UNIT_METRIC,
        self::FAHRENHEIT => self::UNIT_IMPERIAL,
        self::KELVIN => self::UNIT_STANDARD,
    ];
}
