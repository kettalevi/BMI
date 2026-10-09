(() => {
  const form = document.getElementById('bmi-form');
  const errorEl = document.getElementById('error');
  const resultEl = document.getElementById('result');

  const styles = {
    underweight: 'bg-sky-100 text-sky-800',
    normal: 'bg-emerald-100 text-emerald-800',
    overweight: 'bg-amber-100 text-amber-800',
    'obese-1': 'bg-orange-100 text-orange-800',
    'obese-2': 'bg-red-100 text-red-800',
    'obese-3': 'bg-red-200 text-red-900',
  };

  const KG_TO_LB = 2.20462262185;

  const units = () => form.elements.units.value;

  function showError(message) {
    errorEl.textContent = message;
    errorEl.classList.toggle('hidden', !message);
  }

  form.addEventListener('change', (e) => {
    if (e.target.name !== 'units') return;
    const imperial = units() === 'imperial';
    document.getElementById('weight-unit').textContent = imperial ? '(lb)' : '(kg)';
    document.getElementById('height-unit').textContent = imperial ? '(in)' : '(cm)';
  });

  form.addEventListener('submit', async (e) => {
    e.preventDefault();
    showError('');
    resultEl.classList.add('hidden');

    const weight = parseFloat(form.elements.weight.value);
    const height = parseFloat(form.elements.height.value);
    if (!(weight > 0) || !(height > 0)) {
      showError('Please enter a positive weight and height.');
      return;
    }

    try {
      const res = await fetch('api/calculate.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ weight, height, units: units() }),
      });
      const data = await res.json();
      if (!res.ok) throw new Error(data.error || 'Something went wrong.');
      render(data);
    } catch (err) {
      showError(err.message || 'Could not reach the server.');
    }
  });

  function render(data) {
    const imperial = units() === 'imperial';
    document.getElementById('bmi-value').textContent = data.bmi.toFixed(1);

    const label = document.getElementById('bmi-label');
    label.textContent = data.label;
    label.className = 'mt-1 inline-block rounded-full px-3 py-1 text-sm font-semibold ' + (styles[data.category] || '');

    const { min, max } = data.healthyWeightKg;
    const fmt = (kg) => (imperial ? `${(kg * KG_TO_LB).toFixed(1)} lb` : `${kg.toFixed(1)} kg`);
    document.getElementById('healthy-range').textContent = `Healthy weight for your height: ${fmt(min)} – ${fmt(max)}`;

    const pct = Math.min(100, Math.max(0, ((data.bmi - 15) / (40 - 15)) * 100));
    document.getElementById('marker').style.left = pct + '%';

    resultEl.classList.remove('hidden');
  }
})();
