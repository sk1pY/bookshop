import "./bootstrap.js"

if (window.location.pathname.startsWith('/admin')) {
    Promise.all([
        import ("./components/permissions_update.js"),
        import ("./components/role_update.js"),
        import ("./components/table.js"),
    ]).then(r => console.log('loaded'));
} else {
    import ("./components/bookmark.js")
    import ("./components/search.js")
    import("./components/increase_decrease_book_basket.js")
}





