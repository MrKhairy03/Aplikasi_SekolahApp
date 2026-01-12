<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Halaman orangtua index loaded (DOMContentLoaded)');

        const buttons = document.querySelectorAll('.js-delete-orangtua');
        const form = document.getElementById('deleteOrangtuaForm');
        const nameEl = document.getElementById('deleteOrangtuaName');

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
