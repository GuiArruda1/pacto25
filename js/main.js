/**
 * Main JavaScript File
 * Theme: Pacto 25
 * Strict Agency Standard: 100% Vanilla JS, lightweight, accessible, zero jQuery
 */

function initApp() {
  initMobileNav();
  initMegaMenu();
  initStickyHeader();
  initScrollToTop();
  initSliders();
  initHeroSlider();
  initNewsletterValidation();
}

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', initApp);
} else {
  initApp();
}

/**
 * Hero Multi-Slide Carousel with Native Transitions, Touch Swipe, and Keyboard Nav
 */
function initHeroSlider() {
  const heroSlider = document.querySelector('[data-hero-slider]');
  if (!heroSlider) return;

  function goToSlide(targetIndex) {
    const slides = document.querySelectorAll('.hero-slide');
    if (slides.length <= 1) return;

    let normalized = targetIndex;
    if (normalized >= slides.length) {
      normalized = 0;
    } else if (normalized < 0) {
      normalized = slides.length - 1;
    }

    slides.forEach((slide, idx) => {
      if (idx === normalized) {
        slide.classList.add('is-active');
        slide.setAttribute('aria-hidden', 'false');
      } else {
        slide.classList.remove('is-active');
        slide.setAttribute('aria-hidden', 'true');
      }
    });
  }

  // Click delegation on document to guarantee arrow clicks are captured
  document.addEventListener('click', (e) => {
    const btn = e.target.closest('[data-hero-action]');
    if (!btn) return;

    e.preventDefault();
    e.stopPropagation();

    const slides = document.querySelectorAll('.hero-slide');
    if (slides.length <= 1) return;

    let activeIdx = Array.from(slides).findIndex((s) => s.classList.contains('is-active'));
    if (activeIdx === -1) activeIdx = 0;

    const action = btn.getAttribute('data-hero-action');
    if (action === 'prev') {
      goToSlide(activeIdx - 1);
    } else if (action === 'next') {
      goToSlide(activeIdx + 1);
    }
  });

  // Touch Swipe Support
  let touchStartX = 0;
  let touchEndX = 0;
  let touchStartY = 0;
  let touchEndY = 0;

  heroSlider.addEventListener('touchstart', (e) => {
    touchStartX = e.changedTouches[0].screenX;
    touchStartY = e.changedTouches[0].screenY;
  }, { passive: true });

  heroSlider.addEventListener('touchend', (e) => {
    touchEndX = e.changedTouches[0].screenX;
    touchEndY = e.changedTouches[0].screenY;

    const diffX = touchEndX - touchStartX;
    const diffY = touchEndY - touchStartY;

    if (Math.abs(diffX) > Math.abs(diffY) && Math.abs(diffX) > 40) {
      const slides = document.querySelectorAll('.hero-slide');
      let activeIdx = Array.from(slides).findIndex((s) => s.classList.contains('is-active'));
      if (activeIdx === -1) activeIdx = 0;

      if (diffX < 0) {
        goToSlide(activeIdx + 1);
      } else {
        goToSlide(activeIdx - 1);
      }
    }
  }, { passive: true });

  // Keyboard navigation when user has focus within slider
  heroSlider.addEventListener('keydown', (e) => {
    if (e.key === 'ArrowLeft' || e.key === 'ArrowRight') {
      const slides = document.querySelectorAll('.hero-slide');
      let activeIdx = Array.from(slides).findIndex((s) => s.classList.contains('is-active'));
      if (activeIdx === -1) activeIdx = 0;

      if (e.key === 'ArrowLeft') {
        goToSlide(activeIdx - 1);
      } else {
        goToSlide(activeIdx + 1);
      }
    }
  });
}

/**
 * 8000x8000 Arc Testimonial Carousel
 */
function initSliders() {
  const stage = document.querySelector('.testimonials-stage');
  const arcWrapper = document.querySelector('.testimonials-arc-wrapper');
  const track = document.querySelector('[data-testimonials-track]');
  const prevBtn = document.querySelector('[data-testimonials-nav="prev"]');
  const nextBtn = document.querySelector('[data-testimonials-nav="next"]');

  if (!track || !stage) return;

  const cards = Array.from(track.querySelectorAll('.testimonial-card'));
  if (cards.length === 0) return;

  let activeIndex = Math.min(2, Math.floor(cards.length / 2));

  function updateSlider() {
    const isDesktop = window.innerWidth >= 1200;

    cards.forEach((card, i) => {
      if (i === activeIndex) {
        card.classList.add('is-active');
      } else {
        card.classList.remove('is-active');
      }
      // Reset any legacy transform overrides
      card.style.transform = '';
    });

    if (arcWrapper && cards[activeIndex]) {
      const containerWidth = arcWrapper.offsetWidth;
      const trackWidth = track.scrollWidth;

      if (isDesktop && trackWidth <= containerWidth + 20) {
        track.style.transform = 'none';
      } else {
        const wrapperCenter = containerWidth / 2;
        const cardCenter = cards[activeIndex].offsetLeft + cards[activeIndex].offsetWidth / 2;
        const targetX = wrapperCenter - cardCenter;
        track.style.transform = `translateX(${targetX}px)`;
      }
    }
  }

  function setActive(newIndex) {
    if (newIndex < 0) {
      activeIndex = cards.length - 1;
    } else if (newIndex >= cards.length) {
      activeIndex = 0;
    } else {
      activeIndex = newIndex;
    }
    updateSlider();
  }

  if (prevBtn) {
    prevBtn.addEventListener('click', (e) => {
      e.preventDefault();
      setActive(activeIndex - 1);
    });
  }

  if (nextBtn) {
    nextBtn.addEventListener('click', (e) => {
      e.preventDefault();
      setActive(activeIndex + 1);
    });
  }

  // Clicking any card makes it active
  cards.forEach((card, idx) => {
    card.addEventListener('click', () => {
      if (activeIndex !== idx) {
        setActive(idx);
      }
    });
  });

  // Touch swipe support
  let touchStartX = 0;
  let touchEndX = 0;
  if (arcWrapper) {
    arcWrapper.addEventListener('touchstart', (e) => {
      touchStartX = e.changedTouches[0].screenX;
    }, { passive: true });

    arcWrapper.addEventListener('touchend', (e) => {
      touchEndX = e.changedTouches[0].screenX;
      const diff = touchEndX - touchStartX;
      if (Math.abs(diff) > 40) {
        if (diff < 0) {
          setActive(activeIndex + 1);
        } else {
          setActive(activeIndex - 1);
        }
      }
    }, { passive: true });
  }

  window.addEventListener('resize', () => {
    updateSlider();
  });

  // Initialize
  updateSlider();
}

/**
 * Newsletter Form Submission
 */
function initNewsletterValidation() {
  const form = document.querySelector('.newsletter-form');
  if (!form) return;

  form.addEventListener('submit', () => {
    // Form can be submitted freely without blocking validation
  });
}

/**
 * Mega Menu Accessibility & Mobile Accordion Toggle
 */
function initMegaMenu() {
  const megaItems = document.querySelectorAll('.site-header__nav-item--mega');

  megaItems.forEach((item) => {
    const trigger = item.querySelector('.mega-menu-trigger');
    const megaMenu = item.querySelector('.site-header__mega-menu');

    if (!trigger || !megaMenu) return;

    let closeTimer = null;

    function openMenu() {
      if (window.innerWidth > 1024) {
        if (closeTimer) {
          clearTimeout(closeTimer);
          closeTimer = null;
        }
        item.classList.add('is-active');
        trigger.setAttribute('aria-expanded', 'true');
      }
    }

    function closeMenuWithDelay() {
      if (window.innerWidth > 1024) {
        closeTimer = setTimeout(() => {
          item.classList.remove('is-active');
          trigger.setAttribute('aria-expanded', 'false');
        }, 250);
      }
    }

    item.addEventListener('mouseenter', openMenu);
    item.addEventListener('mouseleave', closeMenuWithDelay);

    // Mobile click behavior: expand/collapse accordion
    trigger.addEventListener('click', (e) => {
      if (window.innerWidth <= 1024) {
        e.preventDefault();
        const isOpen = item.classList.toggle('is-mobile-open');
        trigger.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
      }
    });

    // Keyboard accessibility: ESC key to close
    item.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') {
        if (closeTimer) clearTimeout(closeTimer);
        item.classList.remove('is-mobile-open');
        item.classList.remove('is-active');
        trigger.setAttribute('aria-expanded', 'false');
        trigger.focus();
      }
    });
  });
}
