jQuery(document).ready(function($) {
    $('.nm-home-loadmore').on('click', function(e) {
        e.preventDefault();
        
        var button = $(this);
        var currentPage = parseInt(button.data('page'));
        var maxPages = parseInt(button.data('max'));
        var category = button.data('category') || '';
        var format = button.data('format') || '';
        var order = button.data('order') || '';
        
        button.text('Chargement...').prop('disabled', true);

        $.ajax({
            url: nm_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 'nm_load_more',
                page: currentPage + 1,
                category: category,
                format: format,
                order: order
            },
            success: function(response) {
                if (response && response.trim() !== '') {
                    $('#gallery').append(response);
                    button.data('page', currentPage + 1);
                    button.text('Charger plus').prop('disabled', false);
                    
                    if ((currentPage + 1) >= maxPages) {
                        button.parent().hide();
                    }
                } else {
                    button.text('Plus de photos').prop('disabled', true);
                }
            },
            error: function() {
                button.text('Erreur').prop('disabled', false);
            }
        });
    });
});
