<?php
declare(strict_types=1);

namespace Bmi;

use InvalidArgumentException;

/**
 * Calculates Body Mass Index and classifies it using WHO adult categories.
 */
final class BmiCalculator
{
    private const LB_PER_KG = 2.20462262185;
    private const CM_PER_INCH = 2.54;

    /** @var array<int, array{max: float, key: string, label: string}> */
    private const CATEGORIES = [
        ['max' => 18.5, 'key' => 'underweight', 'label' => 'Underweight'],
        ['max' => 25.0, 'key' => 'normal', 'label' => 'Normal weight'],
        ['max' => 30.0, 'key' => 'overweight', 'label' => 'Overweight'],
        ['max' => 35.0, 'key' => 'obese-1', 'label' => 'Obese (Class I)'],
        ['max' => 40.0, 'key' => 'obese-2', 'label' => 'Obese (Class II)'],
        ['max' => INF, 'key' => 'obese-3', 'label' => 'Obese (Class III)'],
    ];

    /**
     * @param float  $weight Kilograms (metric) or pounds (imperial)
     * @param float  $height Centimetres (metric) or inches (imperial)
     * @param string $units  "metric" or "imperial"
     * @return array{bmi: float, category: string, label: string, healthyWeightKg: array{min: float, max: float}}
     */
    public static function calculate(float $weight, float $height, string $units = 'metric'): array
    {
        if (!in_array($units, ['metric', 'imperial'], true)) {
            throw new InvalidArgumentException('Units must be "metric" or "imperial".');
        }
        if (!is_finite($weight) || !is_finite($height) || $weight <= 0 || $height <= 0) {
            throw new InvalidArgumentException('Weight and height must be positive numbers.');
        }

        $kg = $units === 'imperial' ? $weight / self::LB_PER_KG : $weight;
        $m = ($units === 'imperial' ? $height * self::CM_PER_INCH : $height) / 100;

        if ($kg < 2 || $kg > 700 || $m < 0.5 || $m > 2.8) {
            throw new InvalidArgumentException('Weight or height is outside a realistic range.');
        }

        $bmi = $kg / ($m * $m);
        $category = self::categorize($bmi);

        return [
            'bmi' => round($bmi, 1),
            'category' => $category['key'],
            'label' => $category['label'],
            'healthyWeightKg' => [
                'min' => round(18.5 * $m * $m, 1),
                'max' => round(24.9 * $m * $m, 1),
            ],
        ];
    }

    /** @return array{max: float, key: string, label: string} */
    public static function categorize(float $bmi): array
    {
        foreach (self::CATEGORIES as $category) {
            if (round($bmi, 1) < $category['max']) {
                return $category;
            }
        }
        return self::CATEGORIES[array_key_last(self::CATEGORIES)];
    }
}
