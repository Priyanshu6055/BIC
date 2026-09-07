const forms = document.querySelectorAll('[data-inquiry-form]');

for (const form of forms) {
    const steps = [...form.querySelectorAll('[data-step]')];
    const progress = [...form.querySelectorAll('.form-progress li')];
    const stepButtons = [...form.querySelectorAll('[data-step-button]')];
    const back = form.querySelector('[data-back]');
    const next = form.querySelector('[data-next]');
    const submit = form.querySelector('[data-submit]');
    const summary = form.querySelector('.form-error-summary');
    const state = form.querySelector('.submission-state');
    let current = 0;
    let furthest = 0;

    const show = (index) => {
        current = Math.max(0, Math.min(index, steps.length - 1));
        steps.forEach((step, i) => { step.hidden = i !== current; });
        progress.forEach((item, i) => {
            item.dataset.current = i === current ? 'true' : 'false';
            item.dataset.complete = i < current ? 'true' : 'false';
            const button = stepButtons[i];
            button.disabled = i > furthest;
            if (i === current) button.setAttribute('aria-current', 'step');
            else button.removeAttribute('aria-current');
        });
        back.hidden = current === 0;
        next.hidden = current === steps.length - 1;
        submit.hidden = current !== steps.length - 1;
        summary.hidden = true;
        window.scrollTo({top: 0, behavior: 'smooth'});
    };

    const clearError = (control) => {
        const wrapper = control.closest('[data-field]');
        if (!wrapper) return;
        wrapper.removeAttribute('data-invalid');
        control.removeAttribute('aria-invalid');
        const error = wrapper.querySelector('.field__error');
        if (error) { error.hidden = true; error.textContent = ''; }
    };

    const setError = (name, message) => {
        const control = form.elements.namedItem(name);
        if (!control) return;
        const wrapper = control.closest('[data-field]');
        if (!wrapper) return;
        wrapper.dataset.invalid = 'true';
        control.setAttribute('aria-invalid', 'true');
        const error = wrapper.querySelector('.field__error');
        if (error) { error.textContent = message; error.hidden = false; }
    };

    const validateStep = () => {
        let valid = true;
        for (const control of steps[current].querySelectorAll('input,select,textarea')) {
            clearError(control);
            if (!control.checkValidity()) {
                setError(control.name, control.validationMessage);
                valid = false;
            }
            if (control.type === 'file' && control.files[0]) {
                const file = control.files[0];
                if (file.type !== 'application/pdf' || file.size > 10 * 1024 * 1024) {
                    setError(control.name, 'Choose a PDF file no larger than 10 MB.');
                    valid = false;
                }
            }
        }
        summary.hidden = valid;
        if (!valid) summary.focus();
        return valid;
    };

    stepButtons.forEach((button, index) => button.addEventListener('click', () => { if (index <= furthest) show(index); }));
    back.addEventListener('click', () => show(current - 1));
    next.addEventListener('click', () => { if (validateStep()) { furthest = Math.max(furthest, current + 1); show(current + 1); } });
    form.addEventListener('input', (event) => clearError(event.target));
    form.addEventListener('submit', async (event) => {
        event.preventDefault();
        if (!validateStep()) return;
        submit.disabled = true;
        submit.textContent = 'Checking inquiry…';
        state.hidden = true;
        try {
            const response = await fetch(form.action, {method: 'POST', body: new FormData(form), headers: {'Accept': 'application/json'}});
            const data = await response.json();
            if (response.status === 422) {
                const errors = data.errors || {};
                const first = Object.keys(errors)[0];
                const stepIndex = first ? steps.findIndex((step) => step.querySelector(`[name="${CSS.escape(first)}"]`)) : current;
                if (stepIndex >= 0) { furthest = Math.max(furthest, stepIndex); show(stepIndex); }
                Object.entries(errors).forEach(([name, messages]) => setError(name, messages[0]));
                summary.hidden = false; summary.focus();
            } else if (response.ok) {
                form.innerHTML = `<div class="inquiry-result"><div class="state-panel state-panel--success"><h2>Inquiry received</h2><p>${data.message}</p><p><strong>Reference:</strong> <span class="reference-code">${data.reference}</span></p></div></div>`;
            } else throw new Error('Submission failed');
        } catch {
            state.className = 'submission-state state-panel state-panel--error';
            state.innerHTML = '<h2>Submission not accepted</h2><p>The inquiry service could not be reached. Your entered information remains in this form.</p>';
            state.hidden = false;
        } finally {
            if (submit.isConnected) { submit.disabled = false; submit.textContent = 'Submit inquiry'; }
        }
    });
    show(0);
}
