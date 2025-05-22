document.querySelectorAll('.permission-update').forEach(checkbox => {
    checkbox.addEventListener('change', function () {
        let permissionId = this.dataset.permissionId;
        let url = this.dataset.url;
        axios.put(url, {permissionId:permissionId })
            .then(response => {
                console.log('permission updated successfully.', response.data);
            })
            .catch(error => {
                console.error('Error updating role.', error);
            });
    });
});

