     const searchInput = document.getElementById('search');
    const resultsBox = document.getElementById('search-cards');

     const categorySlug = document.getElementById('category-slug')?.value || '';

    if (searchInput) {
        searchInput.addEventListener('keyup', function () {
            const value = this.value.trim();

            axios.get('/search', {
                params: { search: value, category_slug: categorySlug }
            }).then(res => {
                resultsBox.innerHTML = res.data.html;
            });
        });
    }

