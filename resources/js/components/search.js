     const searchInput = document.getElementById('search');
    const resultsBox = document.getElementById('search-cards');

     const categorySlug = document.getElementById('category-slug')?.value ||
         document.getElementById('special-category-slug')?.value ||   '';

     const authorId = document.getElementById('author-id')?.value || '';

    if (searchInput) {
        searchInput.addEventListener('keyup', function () {
            const value = this.value.trim();

            axios.get('/search', {
                params: { search: value, category_slug: categorySlug, author_id:authorId }
            }).then(res => {
                resultsBox.innerHTML = res.data.html;
            });
        });
    }

