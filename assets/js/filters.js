console.log('[nm] filters.js chargé');

document.addEventListener("DOMContentLoaded", function () {

    const gallery = document.querySelector("#gallery");

    // ===============================
    // Gestion des SELECTS PERSONNALISÉS
    // ===============================
    const customSelects = document.querySelectorAll('.custom-select');

    customSelects.forEach(select => {
        
        const trigger = select.querySelector('.custom-select-trigger');
        const options = select.querySelectorAll('.custom-option');
        const optionsContainer = select.querySelector('.custom-options');
        const hiddenInput = select.closest('.custom-select-wrapper').querySelector('input[type="hidden"]');
        const selectName = select.getAttribute('data-name');

        // Labels 
        const defaultTexts = {
            'categorie': 'Catégorie',
            'format': 'Formats',
            'order': 'Trier par'
        };
        const defaultText = defaultTexts[selectName] || 'Sélectionner';

        // OUVERTURE / FERMETURE DU MENU
        trigger.addEventListener('click', function (e) {
            e.stopPropagation();
            customSelects.forEach(s => {
                if (s !== select) s.classList.remove('open');
            });
            select.classList.toggle('open');
        });

        // RESET si clic sur le blanc du menu
        optionsContainer.addEventListener('click', function (e) {
            if (e.target === optionsContainer) {
                e.stopPropagation();
                hiddenInput.value = '';
                trigger.querySelector('span').textContent = defaultText;
                options.forEach(opt => opt.classList.remove('selected'));
                select.classList.remove('open');
                filterPhotos();
            }
        });

        // SELECTION D'UNE OPTION
        options.forEach(option => {
            option.addEventListener('click', function (e) {
                e.stopPropagation();

                const value = this.getAttribute('data-value');
                const text = this.textContent;

                // Si reset 
                if (!value) {
                    hiddenInput.value = '';
                    trigger.querySelector('span').textContent = defaultText;
                    options.forEach(opt => opt.classList.remove('selected'));
                    select.classList.remove('open');
                    filterPhotos();
                    return;
                }

                hiddenInput.value = value;
                trigger.querySelector('span').textContent = text;
                options.forEach(opt => opt.classList.remove('selected'));
                this.classList.add('selected');

                // select
                setTimeout(() => {
                    this.classList.remove('selected');
                }, 120);

                select.classList.remove('open');
                filterPhotos();
            });
        }); 

    });
    
    document.addEventListener('click', function () {
        customSelects.forEach(select => select.classList.remove('open'));
    });

}); 

//  Fonction globale AJAX
function filterPhotos() {
    const category = document.querySelector('#nm-categorie').value;
    const format = document.querySelector('#nm-format').value;
    const order = document.querySelector('#nm-order').value;
    const gallery = document.querySelector('#gallery');

    jQuery.ajax({
        url: nmAjax.ajaxurl,
        type: 'POST',
        data: {
            action: 'nm_filter_photos',
            nonce: nmAjax.nonce,
            page: 1,
            category: category,
            format: format,
            order: order
        },
        success: function(response) {
            if (!response.success) {
                return;
            }
            gallery.innerHTML = response.data.html;
            const btn = jQuery('.nm-home-loadmore');
            btn.data('page', 1);
            btn.data('category', category);
            btn.data('format', format);
            btn.data('order', order);
            btn.show();
        },
        error: function() {
            console.error('Erreur AJAX');
        }
    });
}
