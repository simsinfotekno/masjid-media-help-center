/*
 * Progressive enhancement for the language dropdown (layouts/public.blade.php).
 * <details>/<summary> already gives it a working, keyboard-operable toggle
 * with no JS at all — this only adds what native <details> lacks: closing on
 * an outside click or Escape. If this file fails to load, the dropdown still
 * opens and closes via its native behavior.
 */
document.addEventListener('click', function (event) {
    document.querySelectorAll('details.lang-menu[open]').forEach(function (menu) {
        if (!menu.contains(event.target)) {
            menu.open = false;
        }
    });
});

document.addEventListener('keydown', function (event) {
    if (event.key !== 'Escape') return;

    document.querySelectorAll('details.lang-menu[open]').forEach(function (menu) {
        menu.open = false;
        menu.querySelector('summary').focus();
    });
});
