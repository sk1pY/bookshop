    document.querySelectorAll('.bookmark-button').forEach(function (button) {
        button.addEventListener('click', function () {
            let bookId = this.dataset.bookId;
            let bookmarkButton = this.querySelector('.bookmark_button');
            let url = this.dataset.url;
            axios.post(url, {book_id: bookId})
                .then(response => {
                    if (response.data.success) {
                        const cardPost = document.getElementById(`book-${bookId}`);

                        if (response.data.bookmark) {
                            bookmarkButton.classList.add('bi-heart-fill');
                            bookmarkButton.classList.remove('bi-heart');
                        } else {
                            bookmarkButton.classList.add('bi-heart');
                            bookmarkButton.classList.remove('bi-heart-fill');
                            if (window.location.pathname === '/home/bookmarks') {
                                cardPost.remove();
                            }

                        }
                    } else {
                        document.getElementById('message').textContent = response.data.message;
                        document.getElementById('message').style.color = 'red';
                    }
                })
                .catch(error => console.error('Ошибка:', error));
        });
    });




