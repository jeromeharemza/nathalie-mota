<?php

/**
 * Template part — Modale de contact
 * Nathalie Mota (Thème enfant)
 */

?><script>console.log('[nm] modal template loaded');</script>

<!-- Modale de contact -->
<div class="nm-modal" id="modal-contact" role="dialog" aria-modal="true"
     aria-labelledby="modal-contact-title" aria-hidden="true" tabindex="-1">

  <div class="nm-modal__backdrop" data-modal-close></div>

  <!-- Contenu principal de la modale -->
  <div class="nm-modal__dialog" role="document">

 
    <button type="button" class="nm-modal__close" aria-label="Fermer la fenêtre" data-modal-close>
      &times;
    </button>

    
    <h2 id="modal-contact-title" class="nm-modal__title">Contact</h2>

  
    <div class="nm-modal__body">
      <?php


    
      echo do_shortcode('[contact-form-7 id="1234" title="Formulaire de contact 1"]');
      ?>
    </div>

  </div>


  </div>