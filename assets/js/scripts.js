/* ---------------------------
 Modale de contact
---------------------------- */

console.log('[nm] scripts.js chargé');

(function () {
  const openers = document.querySelectorAll('[data-modal-open]');
  const body = document.body;
  let lastFocused = null;

  function trapFocus(container, e) {
    const focusables = container.querySelectorAll(
      'a[href], button:not([disabled]), textarea, input, select, [tabindex]:not([tabindex="-1"])'
    );
    if (!focusables.length) return;
    const first = focusables[0];
    const last = focusables[focusables.length - 1];

    if (e.key === 'Tab') {
      if (e.shiftKey && document.activeElement === first) {
        last.focus();
        e.preventDefault();
      } else if (!e.shiftKey && document.activeElement === last) {
        first.focus();
        e.preventDefault();
      }
    }
  }

  function openModal(id) {
    const modal = document.getElementById(id);
    if (!modal) return;

    lastFocused = document.activeElement;

    modal.removeAttribute('aria-hidden');
    modal.classList.add('is-open');
    body.classList.add('modal-open');

    const firstFocusable = modal.querySelector(
      'button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])'
    );
    (firstFocusable || modal).focus();

    modal.addEventListener('keydown', onKeydown);
    modal.addEventListener('keydown', (e) => trapFocus(modal, e));
  }

  function closeModal(modal) {
    if (!modal) return;
    modal.setAttribute('aria-hidden', 'true');
    modal.classList.remove('is-open');
    body.classList.remove('modal-open');
    modal.removeEventListener('keydown', onKeydown);
    if (lastFocused) lastFocused.focus();
  }

  function onKeydown(e) {
    if (e.key === 'Escape') {
      closeModal(document.querySelector('.nm-modal.is-open'));
    }
  }
  
  
// OUVERTURE + FERMETURE (un seul listener)
document.addEventListener('click', (e) => {
  // ---- OUVERTURE ----
  const opener = e.target.closest('li.js-modal-contact > a, a.js-modal-contact, [data-modal-open]');
  if (opener) {
    // Empêche la navigation si c'est un lien
    if (opener.matches('a')) e.preventDefault();

    const id = opener.getAttribute('data-modal-open') || 'modal-contact';
    openModal(id);
    return; // éviter de tomber sur la suite (fermeture) au même clic
  }

  // ---- FERMETURE (croix, backdrop, clic hors dialog) ----
  const closer = e.target.closest('[data-modal-close], .nm-modal__backdrop');
  if (closer) {
    const modal = closer.closest('.nm-modal');
    closeModal(modal);
    return;
  }

  // Clic à l'intérieur de la modale mais en dehors du dialog
  const opened = document.querySelector('.nm-modal.is-open');
  if (opened) {
    const dialog = opened.querySelector('.nm-modal__dialog');
    if (dialog && opened.contains(e.target) && !dialog.contains(e.target)) {
      closeModal(opened);
    }
  }
});

// Échap global (au cas où)
document.addEventListener('keydown', (e) => {
  if (e.key === 'Escape') {
    const opened = document.querySelector('.nm-modal.is-open');
    if (opened) closeModal(opened);
  }
});
})(); 
