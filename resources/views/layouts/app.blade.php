<!doctype html>
<html lang ="en" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="favicon.png" type="image/png">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
            crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
{{--    <script src="{{ asset('js/bookmark.js')}}?v={{ filemtime(public_path('js/search.js')) }}"></script>--}}
    <script src="{{ asset('js/search.js') }}?v={{ filemtime(public_path('js/search.js')) }}"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
          integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" rel="stylesheet">


    <title>#BookShop</title>
</head>
<style  >
    body {
        font-family: 'Inter', sans-serif;
        font-weight: 400;
        font-size: 14px;
        width: 100%;margin: 0;padding: 0;
        overflow-x: hidden;

    }

    .dropdownnav:hover {
        background-color: #f4f4f5;
        text: black;
    }

    a {
        color: black;
        text-decoration: none;
    }


    .dropdown-item:hover {
        background-color: transparent !important;
        color: grey;
    }

    .dropdown-item:focus, .dropdown-item:active {
        background-color: transparent !important;
        color: inherit;
    }


    .dropdown-center:hover .dropdown-menu {
        display: block;
        margin-top: 0;
    }

    .sticky-element {
        position: sticky;
        top: 100px;
    }

    body {
        max-width: 1200px;
        margin: 0 auto;
    }

    html {
        margin: 0;
        padding: 0;
    }
    .bg-red-bookmark {
        color: #ff0000;
    }
    .atext:hover{
        color:red;
    }

</style>
<body style="width: 1200px;">

<div class="sticky-top">
    @include('header.nav')
</div>
<div class="container">

    @yield('content')
</div>
    @include('footer.footer')
</body>
<script>
    document.getElementById('btnSwitch').addEventListener('click',()=>{
        if (document.documentElement.getAttribute('data-bs-theme') == 'dark') {
            document.documentElement.setAttribute('data-bs-theme','light')
        }
        else {
            document.documentElement.setAttribute('data-bs-theme','dark')
        }
    })
</script>
<script>
    $(document).ready(function () {

        $('.bookmark-button').on('click', function () {
            var taskId = $(this).data('bookmark-id');
            var bookmarkButton = $(this).find('.fa-heart');

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: 'home/bookmarks' ,
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


</script>
</html>
