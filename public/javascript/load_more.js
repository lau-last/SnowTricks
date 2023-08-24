$(document).ready(function () {


    $("#load-more").on('click', function () {
        let offset = $('.trick-card-container').length;

        $.ajax({
            type: "POST",
            url: /load-more/,
            data: JSON.stringify({'offset': offset}),
            dataType: 'json',
            success: (response) => {
                $('#tricks-presentation').append(response)
            },
        });
    });


});