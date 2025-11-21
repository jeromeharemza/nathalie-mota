(function(){
  const btn = document.getElementById('menu-toggle');
  const nav = document.getElementById('site-navigation');
  if(!btn || !nav) return;

  btn.addEventListener('click', () => {
    const open = btn.getAttribute('aria-expanded') === 'true';
    btn.setAttribute('aria-expanded', String(!open));
    nav.classList.toggle('is-open');
    btn.classList.toggle('is-open');
    document.body.classList.toggle('menu-open', !open);
  });

  window.addEventListener('resize', () => {
    if (window.innerWidth > 1200) {
      btn.setAttribute('aria-expanded','false');
      nav.classList.remove('is-open');
      btn.classList.remove('is-open');
      document.body.classList.remove('menu-open');
    }
  });
})();
