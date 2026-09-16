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

function initMobileNav() {
  const toggle = document.querySelector('.site-header__mobile-toggle');
  const navWrapper = document.querySelector('.site-header__nav-wrapper');
  let backdrop = document.querySelector('.site-header__backdrop');
  if (!toggle || !navWrapper) return;

  if (!backdrop) {
    backdrop = document.createElement('div');
    backdrop.className = 'site-header__backdrop';
    backdrop.setAttribute('aria-hidden', 'true');
    const header = document.querySelector('.site-header');
    if (header) {
      header.appendChild(backdrop);
    } else {
      document.body.appendChild(backdrop);
    }
  }

  function openNav() {
    navWrapper.classList.add('is-active', 'is-open');
    toggle.classList.add('is-active');
    toggle.setAttribute('aria-expanded', 'true');
    toggle.setAttribute('aria-label', 'Fechar Menu');
    if (backdrop) backdrop.classList.add('is-active');
    document.body.classList.add('menu-is-open');
  }

  function closeNav() {
    navWrapper.classList.remove('is-active', 'is-open');
    toggle.classList.remove('is-active');
    toggle.setAttribute('aria-expanded', 'false');
    toggle.setAttribute('aria-label', 'Abrir Menu');
    if (backdrop) backdrop.classList.remove('is-active');
    document.body.classList.remove('menu-is-open');
  }

  toggle.addEventListener('click', (e) => {
    e.preventDefault();
    e.stopPropagation();
    const isOpen = navWrapper.classList.contains('is-open') || navWrapper.classList.contains('is-active');
    if (isOpen) {
      closeNav();
    } else {
      openNav();
    }
  });

  if (backdrop) {
    backdrop.addEventListener('click', closeNav);
  }

  // Close when clicking any nav link (excluding accordion triggers)
  const navLinks = navWrapper.querySelectorAll('a:not(.mega-menu-trigger)');
  navLinks.forEach((link) => {
    link.addEventListener('click', () => {
      closeNav();
    });
  });

  // Close on Escape key
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && (navWrapper.classList.contains('is-open') || navWrapper.classList.contains('is-active'))) {
      closeNav();
      toggle.focus();
    }
  });

  // Close on resize to desktop
  window.addEventListener('resize', () => {
    if (window.innerWidth > 1024) {
      closeNav();
    }
  }, { passive: true });
}

function initStickyHeader() {
  const header = document.querySelector('.site-header');
  if (!header) return;

  window.addEventListener('scroll', () => {
    if (window.scrollY > 40) {
      header.classList.add('is-scrolled');
    } else {
      header.classList.remove('is-scrolled');
    }
  }, { passive: true });
}

function initScrollToTop() {
  const btn = document.querySelector('.scroll-to-top');
  if (!btn) return;

  window.addEventListener('scroll', () => {
    if (window.scrollY > 400) {
      btn.classList.add('is-visible');
    } else {
      btn.classList.remove('is-visible');
    }
  }, { passive: true });

  btn.addEventListener('click', (e) => {
    e.preventDefault();
    window.scrollTo({ top: 0, behavior: 'smooth' });
  });
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
 * Infinite 3D Arc Testimonial Carousel with Auto-Play & Touch Drag
 */
function initSliders() {
  const stage = document.querySelector('.testimonials-stage');
  const arcWrapper = document.querySelector('.testimonials-arc-wrapper');
  const track = document.querySelector('[data-testimonials-track]');
  const prevBtn = document.querySelector('[data-testimonials-nav="prev"]');
  const nextBtn = document.querySelector('[data-testimonials-nav="next"]');

  if (!track || !arcWrapper) return;

  const originalCards = Array.from(track.querySelectorAll('.testimonial-card'));
  const originalCount = originalCards.length;
  if (originalCount === 0) return;

  // Clone cards to enable seamless infinite wrapping
  // Set 1 (clones before) -> Set 2 (originals) -> Set 3 (clones after)
  originalCards.forEach((card) => {
    const cloneBefore = card.cloneNode(true);
    cloneBefore.classList.add('is-clone');
    cloneBefore.setAttribute('aria-hidden', 'true');
    track.insertBefore(cloneBefore, originalCards[0]);

    const cloneAfter = card.cloneNode(true);
    cloneAfter.classList.add('is-clone');
    cloneAfter.setAttribute('aria-hidden', 'true');
    track.appendChild(cloneAfter);
  });

  const allCards = Array.from(track.querySelectorAll('.testimonial-card'));
  const middleOffset = Math.floor(originalCount / 2);
  let currentIndex = originalCount + middleOffset; // Start centered on middle card (Maria do Carmo)
  let isTransitioning = false;
  let autoplayTimer = null;

  function getCardCenter(index) {
    const card = allCards[index];
    if (!card) return 0;
    return card.offsetLeft + card.offsetWidth / 2;
  }

  function updatePosition(animate = true) {
    if (!allCards[currentIndex]) return;

    if (!animate) {
      track.style.transition = 'none';
    } else {
      track.style.transition = 'transform 0.55s cubic-bezier(0.25, 1, 0.5, 1)';
    }

    const containerWidth = arcWrapper.offsetWidth;
    const cardCenter = getCardCenter(currentIndex);
    const targetX = (containerWidth / 2) - cardCenter;

    track.style.transform = `translate3d(${targetX}px, 0, 0)`;

    allCards.forEach((card, idx) => {
      if (idx === currentIndex) {
        card.classList.add('is-active');
      } else {
        card.classList.remove('is-active');
      }
    });
  }

  function goToIndex(index) {
    if (isTransitioning) return;
    isTransitioning = true;
    currentIndex = index;
    updatePosition(true);
  }

  function nextSlide() {
    goToIndex(currentIndex + 1);
  }

  function prevSlide() {
    goToIndex(currentIndex - 1);
  }

  // Handle seamless infinite wrap on transition end
  track.addEventListener('transitionend', (e) => {
    if (e.target !== track || e.propertyName !== 'transform') return;
    isTransitioning = false;

    // If we passed beyond the original set to the clones on the right:
    if (currentIndex >= originalCount * 2) {
      currentIndex = currentIndex - originalCount;
      updatePosition(false);
      void track.offsetHeight; // Force reflow
      track.style.transition = 'transform 0.55s cubic-bezier(0.25, 1, 0.5, 1)';
    }
    // If we moved before the original set to the clones on the left:
    else if (currentIndex < originalCount) {
      currentIndex = currentIndex + originalCount;
      updatePosition(false);
      void track.offsetHeight; // Force reflow
      track.style.transition = 'transform 0.55s cubic-bezier(0.25, 1, 0.5, 1)';
    }
  });

  // Navigation buttons
  if (nextBtn) {
    nextBtn.addEventListener('click', (e) => {
      e.preventDefault();
      resetAutoplay();
      nextSlide();
    });
  }

  if (prevBtn) {
    prevBtn.addEventListener('click', (e) => {
      e.preventDefault();
      resetAutoplay();
      prevSlide();
    });
  }

  // Card click to center
  track.addEventListener('click', (e) => {
    const card = e.target.closest('.testimonial-card');
    if (!card) return;
    const clickedIndex = allCards.indexOf(card);
    if (clickedIndex !== -1 && clickedIndex !== currentIndex) {
      resetAutoplay();
      goToIndex(clickedIndex);
    }
  });

  // Autoplay
  function startAutoplay() {
    stopAutoplay();
    autoplayTimer = setInterval(() => {
      nextSlide();
    }, 3800);
  }

  function stopAutoplay() {
    if (autoplayTimer) {
      clearInterval(autoplayTimer);
      autoplayTimer = null;
    }
  }

  function resetAutoplay() {
    stopAutoplay();
    startAutoplay();
  }

  // Pause on hover
  if (stage) {
    stage.addEventListener('mouseenter', stopAutoplay);
    stage.addEventListener('mouseleave', startAutoplay);
  }
  const navContainer = document.querySelector('.testimonials-nav');
  if (navContainer) {
    navContainer.addEventListener('mouseenter', stopAutoplay);
    navContainer.addEventListener('mouseleave', startAutoplay);
  }

  // Touch Swipe Support
  let touchStartX = 0;
  let touchEndX = 0;

  arcWrapper.addEventListener('touchstart', (e) => {
    stopAutoplay();
    touchStartX = e.changedTouches[0].screenX;
  }, { passive: true });

  arcWrapper.addEventListener('touchend', (e) => {
    touchEndX = e.changedTouches[0].screenX;
    const diff = touchEndX - touchStartX;
    if (Math.abs(diff) > 40) {
      if (diff < 0) {
        nextSlide();
      } else {
        prevSlide();
      }
    }
    startAutoplay();
  }, { passive: true });

  // Handle window resize
  let resizeTimeout;
  window.addEventListener('resize', () => {
    clearTimeout(resizeTimeout);
    resizeTimeout = setTimeout(() => {
      updatePosition(false);
    }, 100);
  });

  // Initial layout positioning without animation
  requestAnimationFrame(() => {
    updatePosition(false);
    startAutoplay();
  });
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
