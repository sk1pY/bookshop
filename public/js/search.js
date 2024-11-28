$(document).ready(function () {
    $('#search').on('keyup', function () {
        var value = $(this).val();
        $.ajax({
            type: 'get',
            url: '/search',
            data: {'search': value},
            success: function (data) {
                $('.search-result').html(data).show();
            }
        });
    });
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(document).click(function (event) {
        let target = $(event.target);
        if (!target.closest('#search').length && !target.closest('.search-result').length) {
            $('.search-result').hide();
        }
    });

});
