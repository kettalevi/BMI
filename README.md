# BMI

Free Body Mass Index (BMI) web application, built with **PHP**, **JavaScript** and **Tailwind CSS**.

- Metric (kg/cm) and imperial (lb/in) units
- WHO adult categories (underweight → obese class III)
- Healthy weight range for the entered height
- Server-side validation in PHP; no database, no dependencies

## Run locally

Requires PHP 8.1+.

```bash
php -S localhost:8000
```

Then open <http://localhost:8000>. Any PHP host (Apache, nginx + PHP-FPM, shared hosting) works by uploading the files.

## Structure

| Path | Purpose |
| --- | --- |
| `index.php` | Page markup (Tailwind via CDN) |
| `assets/app.js` | Form handling and result rendering |
| `api/calculate.php` | JSON endpoint: `POST {weight, height, units}` |
| `src/BmiCalculator.php` | BMI calculation and classification |
| `tests/run.php` | Tests: `php tests/run.php` |

## API

```bash
curl -X POST localhost:8000/api/calculate.php \
  -d '{"weight":70,"height":175,"units":"metric"}'
# {"bmi":22.9,"category":"normal","label":"Normal weight","healthyWeightKg":{"min":56.7,"max":76.3}}
```

## Disclaimer

BMI is a screening tool, not a diagnosis. It does not account for muscle mass, age or body composition.

## License

[MIT](LICENSE)
