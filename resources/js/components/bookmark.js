    document.querySelectorAll('.bookmark-button').forEach(function (button) {
        button.addEventListener('click', function () {
            let bookmarkId = this.dataset.bookmarkId;
            let bookmarkButton = this.querySelector('.bookmark_button');
            let url = this.dataset.url;
            axios.post(url, {bookmark_id: bookmarkId})
                .then(response => {
                    if (response.data.success) {
                        if (response.data.bookmark) {
                            bookmarkButton.classList.add('bi-heart-fill', 'text-danger');
                            bookmarkButton.classList.remove('bi-heart');
                        } else {
                            bookmarkButton.classList.add('bi-heart');
                            bookmarkButton.classList.remove('bi-heart-fill', 'text-danger');
                        }
                    } else {
                        document.getElementById('message').textContent = response.data.message;
                        document.getElementById('message').style.color = 'red';
                    }
                })
                .catch(error => console.error('Ошибка:', error));
        });
    });




