document.addEventListener('click', function (e) {
    if (e.target.closest('.increase-button') || e.target.closest('.decrease-button') || e.target.closest('.in-basket-button')) {
        const button = e.target.closest('.increase-button, .decrease-button, .in-basket-button');
        const url = button.dataset.url;
        const bookId = button.dataset.bookId;
        const general = button.closest('.increase_decrease_buttons');
        const inputQuantityBook = general.querySelector('.basket_item_count');

        if (window.location.pathname === '/basket') {
            const in_basket_button = general.querySelector('.in-basket-button');
            const buttonsIncDec = general.querySelector('.button-inc-dec');
        }

        axios.post(url, {book_id: bookId})
            .then(response => {
                if (response.data.success) {
                    const basketPrice = document.querySelector('.basket_price');
                    const quantity = response.data.quantity;
                    const basketCount = document.getElementById('basket-count');
                    const bookPrice = document.getElementById(`full-price-book-${bookId}`);
                    const bookInBasketQuantity = response.data.bookInBasketQuantity;
                    basketCount.textContent = bookInBasketQuantity;

                    const toastLiveExample = document.getElementById('ToastMaxBook')
                    const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toastLiveExample)

                    if (window.location.pathname !== '/basket') {
                        const in_basket_button = general.querySelector('.in-basket-button');
                        const buttonsIncDec = general.querySelector('.button-inc-dec');

                        if (quantity == 0) {
                            in_basket_button.classList.remove('d-none');
                            buttonsIncDec.classList.add('d-none');

                        } else {
                            in_basket_button.classList.add('d-none');
                            buttonsIncDec.classList.remove('d-none');
                            if(response.data.bookMax){
                                toastBootstrap.show()
                            }
                        }
                    }else{
                        if(quantity === 0){
                            const tr = button.closest('tr');
                            tr.remove();
                        }
                        if(response.data.bookMax){
                            toastBootstrap.show()
                        }
                    }
                    inputQuantityBook.textContent = quantity;

                    if (basketPrice) {
                        basketPrice.textContent = response.data.basketPrice;
                        bookPrice.textContent  =  response.data.bookFullPrice;
                    }
                    console.log(response.data.message);
                } else {

                    const message = document.getElementById('message');
                    if (message) {
                        message.textContent = response.data.message;
                        message.style.color = 'red';
                    }
                }
            })
            .catch(error => console.error('Ошибка:', error));
    }
});
