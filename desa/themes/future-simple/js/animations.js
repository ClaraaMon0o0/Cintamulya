/**
 * Futuristic Simplism — Anime.js Animation Module
 * Target Theme: future-simple
 */

document.addEventListener('DOMContentLoaded', () => {
  // 1. Staggered Entrance Animation for Grid Cards & Section Elements
  if (typeof anime !== 'undefined') {
    // Reveal animated items on scroll using IntersectionObserver
    const observerOptions = {
      root: null,
      threshold: 0.15
    };

    const scrollObserver = new IntersectionObserver((entries, observer) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          const target = entry.target;
          
          if (target.classList.contains('anime-stagger-container')) {
            anime({
              targets: target.querySelectorAll('.anime-stagger-item'),
              opacity: [0, 1],
              translateY: [30, 0],
              delay: anime.stagger(100),
              duration: 600,
              easing: 'easeOutQuad'
            });
          } else if (target.classList.contains('anime-fade-up')) {
            anime({
              targets: target,
              opacity: [0, 1],
              translateY: [20, 0],
              duration: 500,
              easing: 'easeOutCubic'
            });
          }

          observer.unobserve(target);
        }
      });
    }, observerOptions);

    document.querySelectorAll('.anime-stagger-container, .anime-fade-up').forEach(el => {
      scrollObserver.observe(el);
    });

    // 2. Interactive Physics Hover Effects for Quick Pills & Primary Buttons
    document.querySelectorAll('.quick-pill, .btn-detail, .btn-login').forEach(btn => {
      btn.addEventListener('mouseenter', () => {
        anime({
          targets: btn,
          scale: 1.05,
          duration: 200,
          easing: 'easeOutQuad'
        });
      });
      btn.addEventListener('mouseleave', () => {
        anime({
          targets: btn,
          scale: 1.0,
          duration: 200,
          easing: 'easeOutQuad'
        });
      });
    });
  }
});

/**
 * Animate APBDes Progress Bar Fill & Numeric Counter
 * @param {HTMLElement} barElement 
 * @param {number} percentage 
 */
function animateAPBDesBar(barElement, percentage) {
  if (typeof anime !== 'undefined') {
    anime({
      targets: barElement,
      width: [0, percentage + '%'],
      duration: 800,
      easing: 'easeInOutQuad'
    });
  } else {
    barElement.style.width = percentage + '%';
  }
}
