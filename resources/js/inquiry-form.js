import { showFeedbackModal } from './modal-feedback';

const forms = document.querySelectorAll('[data-inquiry-form]');

for (const form of forms) {
    const steps = [...form.querySelectorAll('[data-step]')];
    const progress = [...form.querySelectorAll('.form-progress li')];
    const stepButtons = [...form.querySelectorAll('[data-step-button]')];
    const back = form.querySelector('[data-back]');
    const homeBack = form.querySelector('[data-home-back]');
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
        if (homeBack) homeBack.hidden = current !== 0;
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
        if (!validateStep()) {
            return;
        }
        submit.disabled = true;
        submit.textContent = 'Processing inquiry…';
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
                summary.hidden = false;
                summary.focus();
            } else if (response.ok) {
                form.innerHTML = `
                    <div class="inquiry-result">
                        <div class="state-panel state-panel--success" style="text-align: center; padding: 48px 32px;">
                            <div style="width: 56px; height: 56px; border-radius: 50%; background: rgba(34, 197, 94, 0.12); color: #16a34a; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 20px;">
                                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                                </svg>
                            </div>
                            <h2 style="font-size: 26px; font-family: Georgia, serif; color: #1e293b; margin: 0 0 24px;">Your response has been submitted successfully.</h2>
                            <p><a class="button button--primary" href="/">Back to Home</a></p>
                        </div>
                    </div>
                `;
            } else {
                throw new Error('Submission failed');
            }
        } catch {
            state.className = 'submission-state state-panel state-panel--error';
            state.innerHTML = '<h2>Submission could not be completed</h2><p>We encountered a connection issue. Your entered details remain in the form. Please try submitting again, or email us directly at <a href="mailto:connect@bridgrindia.com" style="color: #5b1522; font-weight: 600; text-decoration: underline;">connect@bridgrindia.com</a>.</p>';
            state.hidden = false;
        } finally {
            if (submit.isConnected) { submit.disabled = false; submit.textContent = 'Submit inquiry'; }
        }
    });
    show(0);
}
