<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Halaman kelas index loaded (DOMContentLoaded)');

        const deleteButtons = document.querySelectorAll('.js-delete-kelas');
        const deleteForm = document.getElementById('deleteKelasForm');
        const nameEl = document.getElementById('deleteKelasName');

        deleteButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                const action = this.getAttribute('data-action');
                const name = this.getAttribute('data-name') || '-';

                if (deleteForm) deleteForm.setAttribute('action', action);
                if (nameEl) nameEl.textContent = name;
            });
        });

    });
</script>
