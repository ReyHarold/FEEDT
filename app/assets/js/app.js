// FeedTrack — lightweight UI helpers.
(function () {
    'use strict';

    // Modal open/close via data attributes.
    document.addEventListener('click', function (ev) {
        var opener = ev.target.closest('[data-modal-open]');
        if (opener) {
            ev.preventDefault();
            var m = document.getElementById(opener.getAttribute('data-modal-open'));
            if (m) {
                // Optional: prefill fields from data-set-* attributes (JSON in data-fields).
                var fields = opener.getAttribute('data-fields');
                if (fields) {
                    try {
                        var obj = JSON.parse(fields);
                        Object.keys(obj).forEach(function (name) {
                            var input = m.querySelector('[name="' + name + '"]');
                            if (input) input.value = obj[name];
                        });
                    } catch (e) {}
                }
                m.classList.add('open');
            }
            return;
        }
        if (ev.target.closest('[data-modal-close]') ||
            (ev.target.classList.contains('modal-backdrop') && ev.target.classList.contains('open'))) {
            var open = document.querySelector('.modal-backdrop.open');
            if (open) open.classList.remove('open');
        }
    });

    document.addEventListener('keydown', function (ev) {
        if (ev.key === 'Escape') {
            var open = document.querySelector('.modal-backdrop.open');
            if (open) open.classList.remove('open');
        }
    });

    // Client-side table filtering: input[data-filter="tableId"].
    document.querySelectorAll('[data-filter]').forEach(function (input) {
        input.addEventListener('input', function () {
            var table = document.getElementById(input.getAttribute('data-filter'));
            if (!table) return;
            var q = input.value.trim().toLowerCase();
            table.querySelectorAll('tbody tr').forEach(function (tr) {
                if (tr.classList.contains('empty-row')) return;
                tr.style.display = tr.textContent.toLowerCase().indexOf(q) > -1 ? '' : 'none';
            });
        });
    });

    // Confirm before submitting destructive forms.
    document.querySelectorAll('form[data-confirm]').forEach(function (form) {
        form.addEventListener('submit', function (ev) {
            if (!window.confirm(form.getAttribute('data-confirm'))) ev.preventDefault();
        });
    });
})();
