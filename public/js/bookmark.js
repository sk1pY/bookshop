    $(document).ready(function () {

    $('.bookmark-button').on('click', function () {
        var taskId = $(this).data('bookmark-id');
        var bookmarkButton = $(this).find('.fa-heart');

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '/bookmark' ,
            method: 'POST',
            data: {
                bookmark_id: taskId
            },
            success: function (response) {
                if (response.success) {
                    if (response.bookmark) {
                        bookmarkButton.addClass('fa-solid bg-red-bookmark');
                    } else {
                        bookmarkButton.removeClass('fa-solid ');
                    }
                } else {
                    $('#message').text(response.message).css('color', 'red');
                }
            },
            error: function (xhr, status, error) {
                console.error('Произошла ошибка при добавлении/удалении закладки');
            }
        });
    })
});

