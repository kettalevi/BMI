<?php
declare(strict_types=1);

require __DIR__ . '/../src/BmiCalculator.php';

use Bmi\BmiCalculator;

$failures = 0;
function check(string $name, bool $ok): void
{
    global $failures;
    echo ($ok ? 'PASS' : 'FAIL') . "  $name\n";
    $failures += $ok ? 0 : 1;
}

$r = BmiCalculator::calculate(70, 175);
check('metric 70kg/175cm = 22.9', $r['bmi'] === 22.9 && $r['category'] === 'normal');

$r = BmiCalculator::calculate(154.32, 68.9, 'imperial');
check('imperial ~70kg/175cm = 22.9', $r['bmi'] === 22.9);

check('underweight', BmiCalculator::calculate(50, 180)['category'] === 'underweight');
check('overweight', BmiCalculator::calculate(85, 175)['category'] === 'overweight');
check('obese class I', BmiCalculator::calculate(100, 175)['category'] === 'obese-1');
check('obese class III', BmiCalculator::calculate(160, 170)['category'] === 'obese-3');
check('boundary 18.5 is normal', BmiCalculator::categorize(18.5)['key'] === 'normal');
check('boundary 25.0 is overweight', BmiCalculator::categorize(25.0)['key'] === 'overweight');

foreach ([[0, 170], [70, -1], [5000, 170], [70, 10]] as [$w, $h]) {
    try {
        BmiCalculator::calculate((float) $w, (float) $h);
        check("rejects $w/$h", false);
    } catch (InvalidArgumentException) {
        check("rejects $w/$h", true);
    }
}

try {
    BmiCalculator::calculate(70, 170, 'stones');
    check('rejects bad units', false);
} catch (InvalidArgumentException) {
    check('rejects bad units', true);
}

exit($failures > 0 ? 1 : 0);
