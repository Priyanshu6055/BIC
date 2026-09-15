/**
 * Reusable Feedback Modal for Form Submissions
 * Provides grammatically clear, accessible success & error dialogs across BIC forms.
 */

export function showFeedbackModal({
    type = 'success',
    title = '',
    message = '',
    reference = null,
    primaryText = 'Acknowledge & Close',
    primaryUrl = null,
    onPrimary = null,
    secondaryText = null,
    secondaryUrl = null,
    onSecondary = null,
}) {
    // Remove any existing feedback modal
    const existing = document.getElementById('bic-feedback-modal-backdrop');
    if (existing) {
        existing.remove();
    }

    const defaultTitle = type === 'success' ? 'Submission Received Successfully' : 'Unable to Complete Submission';
    const finalTitle = title || defaultTitle;

    const isSuccess = type === 'success';

    const iconSvg = isSuccess
        ? `<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
             <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
             <polyline points="22 4 12 14.01 9 11.01"></polyline>
           </svg>`
        : `<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
             <circle cx="12" cy="12" r="10"></circle>
             <line x1="12" y1="8" x2="12" y2="12"></line>
             <line x1="12" y1="16" x2="12.01" y2="16"></line>
           </svg>`;

    const referenceHtml = reference
        ? `<div class="feedback-modal-meta">
             <div>
               <span class="feedback-modal-meta-label">Submission Reference:</span>
               <div class="feedback-modal-reference-code" id="feedback-ref-code">${escapeHtml(reference)}</div>
             </div>
             <button type="button" class="feedback-modal-copy-btn" id="feedback-copy-btn" title="Copy reference code">
               <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                 <rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect>
                 <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
               </svg>
               <span id="feedback-copy-text">Copy</span>
             </button>
           </div>`
        : '';

    const secondaryBtnHtml = secondaryText
        ? (secondaryUrl
            ? `<a href="${escapeHtml(secondaryUrl)}" class="feedback-modal-btn feedback-modal-btn--secondary" id="feedback-secondary-btn">${escapeHtml(secondaryText)}</a>`
            : `<button type="button" class="feedback-modal-btn feedback-modal-btn--secondary" id="feedback-secondary-btn">${escapeHtml(secondaryText)}</button>`)
        : '';

    const primaryBtnHtml = primaryUrl
        ? `<a href="${escapeHtml(primaryUrl)}" class="feedback-modal-btn feedback-modal-btn--primary" id="feedback-primary-btn">${escapeHtml(primaryText)}</a>`
        : `<button type="button" class="feedback-modal-btn feedback-modal-btn--primary" id="feedback-primary-btn">${escapeHtml(primaryText)}</button>`;

    const backdrop = document.createElement('div');
    backdrop.id = 'bic-feedback-modal-backdrop';
    backdrop.className = `feedback-modal-backdrop feedback-modal--${type}`;
    backdrop.setAttribute('role', 'dialog');
    backdrop.setAttribute('aria-modal', 'true');
    backdrop.setAttribute('aria-labelledby', 'feedback-modal-title');

    backdrop.innerHTML = `
        <div class="feedback-modal">
            <button type="button" class="feedback-modal-close" id="feedback-modal-close" aria-label="Close dialog">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>
            <div class="feedback-modal-icon-wrap">
                ${iconSvg}
            </div>
            <h2 class="feedback-modal-title" id="feedback-modal-title">${escapeHtml(finalTitle)}</h2>
            <div class="feedback-modal-message">${message}</div>
            ${referenceHtml}
            <div class="feedback-modal-actions">
                ${secondaryBtnHtml}
                ${primaryBtnHtml}
            </div>
        </div>
    `;

    document.body.appendChild(backdrop);

    // Trap focus and open animation
    requestAnimationFrame(() => {
        backdrop.classList.add('is-open');
        const primaryBtn = backdrop.querySelector('#feedback-primary-btn');
        if (primaryBtn) primaryBtn.focus();
    });

    const close = () => {
        backdrop.classList.remove('is-open');
        setTimeout(() => {
            if (backdrop.parentNode) {
                backdrop.parentNode.removeChild(backdrop);
            }
        }, 280);
    };

    const closeBtn = backdrop.querySelector('#feedback-modal-close');
    if (closeBtn) closeBtn.addEventListener('click', close);

    const primaryBtn = backdrop.querySelector('#feedback-primary-btn');
    if (primaryBtn) {
        primaryBtn.addEventListener('click', (e) => {
            if (onPrimary) {
                onPrimary(e);
            }
            if (!primaryUrl) {
                close();
            }
        });
    }

    const secondaryBtn = backdrop.querySelector('#feedback-secondary-btn');
    if (secondaryBtn) {
        secondaryBtn.addEventListener('click', (e) => {
            if (onSecondary) {
                onSecondary(e);
            }
            if (!secondaryUrl) {
                close();
            }
        });
    }

    // Copy reference button functionality
    const copyBtn = backdrop.querySelector('#feedback-copy-btn');
    if (copyBtn && reference) {
        copyBtn.addEventListener('click', async () => {
            try {
                await navigator.clipboard.writeText(reference);
                const copyText = backdrop.querySelector('#feedback-copy-text');
                if (copyText) {
                    copyText.textContent = 'Copied!';
                    setTimeout(() => {
                        copyText.textContent = 'Copy';
                    }, 2000);
                }
            } catch (err) {
                console.error('Clipboard copy failed:', err);
            }
        });
    }

    // Close on Escape or click outside
    const keyHandler = (e) => {
        if (e.key === 'Escape') {
            close();
            window.removeEventListener('keydown', keyHandler);
        }
    };
    window.addEventListener('keydown', keyHandler);

    backdrop.addEventListener('click', (e) => {
        if (e.target === backdrop) {
            close();
        }
    });

    return { close };
}

function escapeHtml(str) {
    if (!str) return '';
    return String(str)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#039;');
}

// Auto-check for server-flashed messages on page load
document.addEventListener('DOMContentLoaded', () => {
    const flashEl = document.getElementById('bic-server-flash');
    if (!flashEl) return;

    const type = flashEl.dataset.type || 'success';
    const title = flashEl.dataset.title || '';
    const message = flashEl.dataset.message || '';
    const reference = flashEl.dataset.reference || null;

    if (message) {
        showFeedbackModal({
            type,
            title,
            message,
            reference,
            primaryText: 'Understood',
        });
    }
});
