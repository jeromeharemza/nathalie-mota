document.addEventListener('DOMContentLoaded', function() {
  const modal = document.getElementById('lightbox-modal');
  if (!modal) return;
  
  const overlay = modal.querySelector('.lightbox-overlay');
  const closeBtn = modal.querySelector('.lightbox-close');
  const lightboxImg = modal.querySelector('.lightbox-image');
  const lightboxReference = modal.querySelector('.lightbox-reference');
  const lightboxCategory = modal.querySelector('.lightbox-category');
  const prevBtn = modal.querySelector('.lightbox-prev');
  const nextBtn = modal.querySelector('.lightbox-next');
  
  let currentPhotos = [];
  let currentIndex = 0;

  function openLightbox(photoUrl, reference, category, postId) {
    lightboxImg.src = photoUrl;
    lightboxReference.textContent = reference || '';
    lightboxCategory.textContent = category ? category.toUpperCase() : '';
    modal.style.display = 'block';
    document.body.style.overflow = 'hidden';
    
    currentPhotos = Array.from(document.querySelectorAll('.lightbox-trigger'));
    currentIndex = currentPhotos.findIndex(photo => photo.dataset.postId === postId);
    
    updateNavButtons();
  }

  function closeLightbox() {
    modal.style.display = 'none';
    document.body.style.overflow = 'auto';
  }

  function showNext() {
    if (currentIndex < currentPhotos.length - 1) {
      currentIndex++;
      loadPhoto(currentIndex);
    }
  }

  function showPrev() {
    if (currentIndex > 0) {
      currentIndex--;
      loadPhoto(currentIndex);
    }
  }

  function loadPhoto(index) {
    const photo = currentPhotos[index];
    lightboxImg.src = photo.href;
    lightboxReference.textContent = photo.dataset.reference || '';
    lightboxCategory.textContent = photo.dataset.category ? photo.dataset.category.toUpperCase() : '';
    updateNavButtons();
  }

  function updateNavButtons() {
    if (prevBtn) {
      prevBtn.style.opacity = currentIndex === 0 ? '0.3' : '1';
      prevBtn.style.cursor = currentIndex === 0 ? 'not-allowed' : 'pointer';
    }
    if (nextBtn) {
      nextBtn.style.opacity = currentIndex === currentPhotos.length - 1 ? '0.3' : '1';
      nextBtn.style.cursor = currentIndex === currentPhotos.length - 1 ? 'not-allowed' : 'pointer';
    }
  }

  document.addEventListener('click', function(e) {
    const trigger = e.target.closest('.lightbox-trigger');
    if (trigger) {
      e.preventDefault();
      openLightbox(
        trigger.href,
        trigger.dataset.reference,
        trigger.dataset.category,
        trigger.dataset.postId
      );
    }
  });

  if (closeBtn) closeBtn.addEventListener('click', closeLightbox);
  if (overlay) overlay.addEventListener('click', closeLightbox);
  if (prevBtn) prevBtn.addEventListener('click', function() {
    if (currentIndex > 0) showPrev();
  });
  if (nextBtn) nextBtn.addEventListener('click', function() {
    if (currentIndex < currentPhotos.length - 1) showNext();
  });

  document.addEventListener('keydown', function(e) {
    if (modal.style.display === 'block') {
      if (e.key === 'Escape') closeLightbox();
      if (e.key === 'ArrowLeft' && currentIndex > 0) showPrev();
      if (e.key === 'ArrowRight' && currentIndex < currentPhotos.length - 1) showNext();
    }
  });
});
