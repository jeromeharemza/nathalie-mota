console.log('[nm] filters.js chargé');

document.addEventListener("DOMContentLoaded", function () {
    
    const gallery = document.querySelector("#gallery");

    // Gestion des selects personnalisés
    const customSelects = document.querySelectorAll('.custom-select');

    customSelects.forEach(select => {

        const trigger = select.querySelector('.custom-select-trigger');
        const options = select.querySelectorAll('.custom-option');
        const optionsContainer = select.querySelector('.custom-options');
        const hiddenInput = select.closest('.custom-select-wrapper').querySelector('input[type="hidden"]');
        const selectName = select.getAttribute('data-name');

        const defaultTexts = {
            'category': 'Catégories',
            'format': 'Formats',
            'order': 'Trier par'
        };

        const defaultText = defaultTexts[selectName] || 'Sélectionner';


        // Ouverture/fermeture du menu
        trigger.addEventListener('click', function (e) {
            e.stopPropagation();
            customSelects.forEach(s => {
                if (s !== select) s.classList.remove('open');
            });
            select.classList.toggle('open');
        });


        // Réinitialisation si on clique sur le conteneur blanc
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


        // Sélection d'une option
        options.forEach(option => {
            option.addEventListener('click', function (e) {
                e.stopPropagation();

                const value = this.getAttribute('data-value');
                const text = this.textContent;

                // Si on clique sur la première ligne => reset
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

                select.classList.remove('open');

                filterPhotos();
            });
        });

    });

    // Fermer les dropdowns en cliquant ailleurs sur la page
    document.addEventListener('click', function () {
        customSelects.forEach(select => select.classList.remove('open'));
    });


    /**
     * Filtrage = recharger la page avec paramètres GET
     */
    function filterPhotos() {

        const category = document.querySelector('#nm-category').value;
        const format = document.querySelector('#nm-format').value;
        const order = document.querySelector('#nm-order').value;

        const params = new URLSearchParams();

        if (category) params.append('category', category);
        if (format) params.append('format', format);
        if (order) params.append('order', order);

        // Recharge la page avec les filtres
        window.location.search = params.toString();
    }

});
