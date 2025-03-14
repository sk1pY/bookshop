document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('search');
    const searchResult = document.querySelector('.search-result');

    if (searchInput) {
        searchInput.addEventListener('keyup', function () {
            const value = this.value;

            if (value.trim() === '') {
                searchResult.style.display = 'none';
                return;
            }

            axios.get('/search', { params: { search: value } })
                .then(response => {
                    searchResult.innerHTML = response.data;
                    searchResult.style.display = 'block';
                })
                .catch(error => {
                    console.error('Ошибка при поиске:', error);
                });
        });
    }

    document.addEventListener('click', function (event) {
        const target = event.target;

        if (!searchInput.contains(target) && !searchResult.contains(target)) {
            searchResult.style.display = 'none';
        }
    });
});
