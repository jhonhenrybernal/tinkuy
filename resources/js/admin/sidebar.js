document.getElementById('sidebarToggle').addEventListener('click', function () {
    document.getElementById('sidebar').classList.toggle('collapsed');
    document.getElementById('content').classList.toggle('collapsed');
});

document.querySelectorAll('.language-select').forEach(item => {
    item.addEventListener('click', function (e) {
        e.preventDefault();
        const selectedLang = this.getAttribute('data-lang');

        const modal = new bootstrap.Modal(document.getElementById('languageChangeModal'));
        modal.show();

        document.getElementById('confirmChange').onclick = function () {
            modal.hide();

            axios.post('/admin/change-language', {
                _token: document.querySelector('meta[name="csrf-token"]').content,
                lang: selectedLang
            })
            .then(response => {
                console.log(response.data);
                window.location.reload();
            })
            .catch(error => {
                console.error(error);
            });
        };
    });
});


