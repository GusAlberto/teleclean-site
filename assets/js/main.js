const header = document.querySelector('[data-header]');
const navToggle = document.querySelector('[data-nav-toggle]');
const mobileMenu = document.getElementById('mobile-menu');
const backToTop = document.querySelector('[data-back-to-top]');
const reveals = document.querySelectorAll('.reveal');
const carousel = document.querySelector('[data-carousel]');
const accordion = document.querySelector('[data-accordion]');

const MEDIA_FALLBACK = 'assets/img/placeholder.svg';

document.querySelectorAll('img').forEach((img) => {
  img.addEventListener('error', () => {
    if (!img.dataset.fallbackApplied) {
      img.dataset.fallbackApplied = 'true';
      img.src = MEDIA_FALLBACK;
    }
  });
});

document.querySelectorAll('video').forEach((video) => {
  video.addEventListener('error', () => {
    video.style.display = 'none';
  });

  video.querySelectorAll('source').forEach((source) => {
    source.addEventListener('error', () => {
      video.style.display = 'none';
    });
  });
});

const setHeaderState = () => {
  if (!header) return;
  header.classList.toggle('is-scrolled', window.scrollY > 12);
};
setHeaderState();
window.addEventListener('scroll', setHeaderState, { passive: true });

if (navToggle && mobileMenu) {
  navToggle.addEventListener('click', () => {
    const expanded = navToggle.getAttribute('aria-expanded') === 'true';
    navToggle.setAttribute('aria-expanded', String(!expanded));
    mobileMenu.hidden = expanded;
  });

  mobileMenu.querySelectorAll('a').forEach((link) => {
    link.addEventListener('click', () => {
      mobileMenu.hidden = true;
      navToggle.setAttribute('aria-expanded', 'false');
    });
  });
}

if (backToTop) {
  backToTop.addEventListener('click', () => {
    window.scrollTo({ top: 0, behavior: 'smooth' });
  });
}

if ('IntersectionObserver' in window && !window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
  const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        entry.target.classList.add('is-visible');
        observer.unobserve(entry.target);
      }
    });
  }, { threshold: 0.18, rootMargin: '0px 0px -40px 0px' });

  reveals.forEach((item) => observer.observe(item));
} else {
  reveals.forEach((item) => item.classList.add('is-visible'));
}

if (carousel) {
  const viewport = carousel.querySelector('.carousel__viewport');
  const prev = carousel.querySelector('[data-carousel-prev]');
  const next = carousel.querySelector('[data-carousel-next]');
  if (!viewport) {
    // Carousel incompleto: ignora comportamento para evitar erro em runtime.
  } else {
    const amount = () => Math.min(viewport.clientWidth * 0.9, 380);

    prev?.addEventListener('click', () => viewport.scrollBy({ left: -amount(), behavior: 'smooth' }));
    next?.addEventListener('click', () => viewport.scrollBy({ left: amount(), behavior: 'smooth' }));

    viewport.addEventListener('keydown', (event) => {
      if (event.key === 'ArrowRight') {
        event.preventDefault();
        viewport.scrollBy({ left: amount(), behavior: 'smooth' });
      }
      if (event.key === 'ArrowLeft') {
        event.preventDefault();
        viewport.scrollBy({ left: -amount(), behavior: 'smooth' });
      }
    });
  }
}

if (accordion) {
  accordion.querySelectorAll('button[aria-controls]').forEach((button) => {
    button.addEventListener('click', () => {
      const panel = document.getElementById(button.getAttribute('aria-controls'));
      const isOpen = button.getAttribute('aria-expanded') === 'true';
      accordion.querySelectorAll('button[aria-controls]').forEach((other) => {
        const otherPanel = document.getElementById(other.getAttribute('aria-controls'));
        other.setAttribute('aria-expanded', 'false');
        otherPanel.hidden = true;
      });
      button.setAttribute('aria-expanded', String(!isOpen));
      panel.hidden = isOpen;
    });
  });
}