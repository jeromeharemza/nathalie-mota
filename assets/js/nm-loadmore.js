jQuery(document).ready(function($) {
    let page = 2;

    $('.nm-home-loadmore').on('click', function(e) {
        e.preventDefault();

        $.ajax({
            url: nmLoadmore.ajaxurl,
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'nm_loadmore_photos',
                nonce: nmLoadmore.nonce,
                paged: page
            },
            success: function(response) {
                if(response.success) {
                    $('#gallery').append(response.data.html);
                    page++;
                } else {
                    alert('Erreur lors du chargement des photos.');
                }
            },
            error: function() {
                alert('Erreur AJAX');
            }
        });
    });
});
