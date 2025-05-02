const searchInput = document.getElementById('search');
const resultsBox = document.getElementById('search-cards');

searchInput.addEventListener('keyup', function () {
    const value = this.value.trim();

    axios.get('/search', {
        params: { search: value }
    }).then(res => {
        resultsBox.innerHTML = res.data.html;
    });
});
