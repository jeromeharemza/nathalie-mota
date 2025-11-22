jQuery(document).ready(function($) {
    let page = 2;

    $('.nm-home-loadmore').on('click', function(e) {
        e.preventDefault();

        // On récupère les filtres actifs
        let category = $('#nm-categorie').val();
        let format   = $('#nm-format').val();
        let order    = $('#nm-order').val();

        $.ajax({
            url: nmLoadmore.ajaxurl,
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'nm_loadmore_photos',
                nonce: nmLoadmore.nonce,
                paged: page,
                category: category,
                format: format,
                order: order
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