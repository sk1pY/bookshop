document.addEventListener('click', function (e) {
    if (e.target.closest('.increase-button') || e.target.closest('.decrease-button')) {
        const button = e.target.closest('.increase-button') || e.target.closest('.decrease-button');
        const url = button.dataset.url;
        const bookId = button.dataset.bookId;
        const general = button.closest('.increase_decrease_buttons');

        const buttonIncrease = general.querySelector('.button_increase');
        const buttonDecrease = general.querySelector('.button_decrease');
        const inputQuntityBook = general.querySelector('.basket_item_count');

        axios.post(url, {book_id: bookId})
            .then(response => {
                if (response.data.success) {
                    const basketPrice = document.querySelector('.basket_price');
                    buttonIncrease.classList.remove('bg-danger', 'rounded-pill' ,'btn',
                        'd-flex', 'justify-content-center', 'align-items-center', 'text-white');

                    buttonIncrease.textContent = '+';


                    buttonDecrease.style.display = '';
                    buttonDecrease.textContent = '-';
                    inputQuntityBook.textContent = response.data.quantity;
                    if(basketPrice){
                        basketPrice.textContent = response.data.basketPrice;
                    }
                    if(!response.data.quantity){
                        buttonDecrease.style.display = 'none';

                        buttonIncrease.textContent = 'в корзину';
                        buttonIncrease.classList.add('bg-danger', 'rounded-pill', 'btn', 'd-flex', 'justify-content-center', 'align-items-center');

                    }
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
