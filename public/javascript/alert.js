function confirmationForDelete(ev) {
    ev.preventDefault();
    let urlToRedirect = ev.currentTarget.getAttribute('href');
    swal({
        title: "Are you sure?",
        text: "Once deleted, you will not be able to recover this trick!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                swal("Poof! Your trick has been deleted!", {
                    icon: "success",
                });
                window.location = urlToRedirect;
            } else {
                swal("Your trick is safe!");
            }
        });
}

