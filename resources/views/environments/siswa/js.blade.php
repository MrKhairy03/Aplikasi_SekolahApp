<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Halaman siswa index loaded (DOMContentLoaded)');

        const buttons = document.querySelectorAll('.js-delete-siswa');
        const form = document.getElementById('deleteSiswaForm');
        const nameEl = document.getElementById('deleteSiswaName');

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
