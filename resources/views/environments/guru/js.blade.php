<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Halaman guru index loaded (DOMContentLoaded)');

        const buttons = document.querySelectorAll('.js-delete-guru');
        const form = document.getElementById('deleteGuruForm');
        const nameEl = document.getElementById('deleteGuruName');

        buttons.forEach(btn => {
            btn.addEventListener('click', function() {
                const action = this.getAttribute('data-action');
                const name = this.getAttribute('data-name') || '-';

                if (form) form.setAttribute('action', action);
                if (nameEl) nameEl.textContent = name;
            });
        });

    });
</script>
