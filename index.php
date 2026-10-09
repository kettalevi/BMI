<?php declare(strict_types=1); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>BMI Calculator</title>
  <meta name="description" content="Free Body Mass Index (BMI) calculator.">
  <script src="https://cdn.tailwindcss.com/3.4.16"></script>
</head>
<body class="min-h-screen bg-slate-100 text-slate-800 antialiased">
  <main class="mx-auto flex min-h-screen max-w-md flex-col justify-center px-4 py-10">
    <div class="rounded-2xl bg-white p-6 shadow-lg">
      <h1 class="text-2xl font-bold">BMI Calculator</h1>
      <p class="mt-1 text-sm text-slate-500">Check your Body Mass Index in seconds.</p>

      <form id="bmi-form" class="mt-6 space-y-4" novalidate>
        <div class="grid grid-cols-2 gap-1 rounded-lg bg-slate-100 p-1" role="radiogroup" aria-label="Units">
          <label class="cursor-pointer">
            <input type="radio" name="units" value="metric" class="peer sr-only" checked>
            <span class="block rounded-md py-2 text-center text-sm font-medium peer-checked:bg-white peer-checked:shadow peer-focus-visible:ring-2 peer-focus-visible:ring-indigo-500">Metric</span>
          </label>
          <label class="cursor-pointer">
            <input type="radio" name="units" value="imperial" class="peer sr-only">
            <span class="block rounded-md py-2 text-center text-sm font-medium peer-checked:bg-white peer-checked:shadow peer-focus-visible:ring-2 peer-focus-visible:ring-indigo-500">Imperial</span>
          </label>
        </div>

        <div>
          <label for="weight" class="block text-sm font-medium">Weight <span id="weight-unit" class="text-slate-500">(kg)</span></label>
          <input id="weight" name="weight" type="number" inputmode="decimal" step="any" min="0" required
                 class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200">
        </div>

        <div>
          <label for="height" class="block text-sm font-medium">Height <span id="height-unit" class="text-slate-500">(cm)</span></label>
          <input id="height" name="height" type="number" inputmode="decimal" step="any" min="0" required
                 class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200">
        </div>

        <p id="error" class="hidden rounded-lg bg-red-50 px-3 py-2 text-sm text-red-700" role="alert"></p>

        <button type="submit" class="w-full rounded-lg bg-indigo-600 py-2.5 font-semibold text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-300">
          Calculate BMI
        </button>
      </form>

      <section id="result" class="mt-6 hidden text-center" aria-live="polite">
        <p class="text-sm text-slate-500">Your BMI</p>
        <p id="bmi-value" class="text-5xl font-extrabold"></p>
        <p id="bmi-label" class="mt-1 inline-block rounded-full px-3 py-1 text-sm font-semibold"></p>
        <p id="healthy-range" class="mt-3 text-sm text-slate-600"></p>

        <div class="relative mt-5 h-3 overflow-hidden rounded-full bg-gradient-to-r from-sky-400 via-emerald-400 via-45% to-red-500" aria-hidden="true">
          <div id="marker" class="absolute top-0 h-3 w-1 -translate-x-1/2 bg-slate-900"></div>
        </div>
        <div class="mt-1 flex justify-between text-xs text-slate-400" aria-hidden="true"><span>15</span><span>25</span><span>40</span></div>
      </section>

      <p class="mt-6 text-xs text-slate-400">
        BMI is a screening tool, not a diagnosis. It does not account for muscle mass, age or body composition.
        Talk to a healthcare professional for medical advice.
      </p>
    </div>
    <p class="mt-4 text-center text-xs text-slate-400">
      Open source (MIT) · <a class="underline" href="https://github.com/kettalevi/BMI">GitHub</a>
    </p>
  </main>
  <script src="assets/app.js"></script>
</body>
</html>
