function goToCreateView(e) {
    window.location.href = e.getAttribute('data-href');
}

function deleteEntity(e) {
    window.axios.delete(e.getAttribute('data-href')).then(response => {
        window.location.reload();
    }).catch(error => {
        if (error.response.data.message) {
            alert(error.response.data.message);
            return;
        }
        if (error.response.data) {
            alert(error.response.data);
        } else {
            alert('Error has occurred.Contact us!');
        }
        console.error('There was an error!', error);
    });
}
