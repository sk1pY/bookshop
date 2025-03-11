    $(document).ready(function () {

    $('.bookmark-button').on('click', function () {
        let taskId = $(this).data('bookmark-id');
        let bookmarkButton = $(this).find('.bookmark_button');
        let url = this.dataset.url;

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: url ,
            method: 'POST',
            data: {
                bookmark_id: taskId
            },
            success: function (response) {
                if (response.success) {
                    if (response.bookmark) {
                        bookmarkButton.addClass('bi-heart-fill', 'text-danger');
                        bookmarkButton.removeClass('bi-heart');
                    } else {
                        bookmarkButton.addClass('bi-heart');
                        bookmarkButton.removeClass('bi-heart-fill', 'text-danger');
                    }
                } else {
                    $('#message').text(response.message).css('color', 'red');
                }
            },

        });
    })
});

