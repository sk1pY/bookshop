document.querySelectorAll('input[name="permissions[]"]').forEach(checkbox => {
    checkbox.addEventListener('change', function () {
        const permissions = document.querySelectorAll('input[name="permissions[]"]:checked');
        const permissionValues = Array.from(permissions).map(checkbox => checkbox.value);

        let url = this.dataset.url;
        axios.put(url, {permissions: permissionValues})
            .then(response => {
                console.log('Ответ от сервера:', response.data);
            })
            .catch(error => {
                console.error('Ошибка:', error);
            });

    });
});
