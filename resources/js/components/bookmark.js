document.querySelectorAll('.bookmark-button').forEach(function (button) {
    button.addEventListener('click', function () {
        let bookId = this.dataset.bookId;
        let bookmarkButton = this.querySelector('.bookmark_button');
        let url = this.dataset.url;
        axios.post(url, {book_id: bookId})
            .then(response => {
                if (response.data.success) {
                    const cardPost = document.getElementById(`book-${bookId}`);
                    const toastBookmarkAddEl = document.getElementById('ToastBookmarkAdd')
                    const ToastBookmarkAdd = bootstrap.Toast.getOrCreateInstance(toastBookmarkAddEl)

                    const toastBookmarkRemoveEl = document.getElementById('ToastBookmarkRemove')
                    const ToastBookmarkRemove = bootstrap.Toast.getOrCreateInstance(toastBookmarkRemoveEl)
                    if (response.data.bookmark) {
                        bookmarkButton.classList.add('bi-heart-fill');
                        bookmarkButton.classList.remove('bi-heart');
                        ToastBookmarkAdd.show()

                    } else {
                        bookmarkButton.classList.add('bi-heart');
                        bookmarkButton.classList.remove('bi-heart-fill');
                        ToastBookmarkRemove.show()


                    }
                } else {
                    document.getElementById('message').textContent = response.data.message;
                    document.getElementById('message').style.color = 'red';
                }
            })
            .catch(error => console.error('Ошибка:', error));
    });
});




