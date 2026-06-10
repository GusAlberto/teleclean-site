const header = document.querySelector('[data-header]');
const navToggle = document.querySelector('[data-nav-toggle]');
const mobileMenu = document.getElementById('mobile-menu');
const backToTop = document.querySelector('[data-back-to-top]');
const reveals = document.querySelectorAll('.reveal');
const serviceCarousel = document.querySelector('[data-service-carousel]');
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

const heroVideo = document.querySelector('.hero__video');

const setHeaderState = () => {
  if (!header) return;
  const scrollY = window.scrollY;
  
  header.classList.toggle('is-scrolled', scrollY > 50);

  // Efeito Parallax Suave
  if (heroVideo && scrollY < window.innerHeight) {
    heroVideo.style.transform = `translate3d(-50%, calc(-50% + ${scrollY * 0.4}px), 0) rotate(90deg)`;
  }
};

let scrollTimeout;
const handleScroll = () => {
  setHeaderState();
  if (!header) return;

  // Esconde a navbar se o usuário estiver rolando (e não estiver no topo)
  if (window.scrollY > 20) {
    header.classList.add('is-moving');

    // Limpa o timer anterior e define um novo de 250ms
    clearTimeout(scrollTimeout);
    scrollTimeout = setTimeout(() => {
      header.classList.remove('is-moving');
    }, 1000); // Tempo para considerar que o usuário "parou" de rolar
  } else {
    header.classList.remove('is-moving');
  }
};

handleScroll();
window.addEventListener('scroll', handleScroll, { passive: true });

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
  // Configuração para disparar o efeito quando o elemento estiver um pouco mais visível
  const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -100px 0px' // O elemento precisa estar 100px dentro da área visível
  };

  const observer = new IntersectionObserver((entries, observer) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        entry.target.classList.add('is-visible');
        // Uma vez visível, paramos de observar este elemento específico
        observer.unobserve(entry.target);
      }
    });
  }, observerOptions);

  // Inicia a observação imediatamente (o script já está com 'defer')
  reveals.forEach((item) => observer.observe(item));
} else {
  reveals.forEach((item) => item.classList.add('is-visible'));
}

if (serviceCarousel) {
  const stage = serviceCarousel.querySelector('[data-service-stage]');
  const ring = serviceCarousel.querySelector('[data-service-ring]');
  const cards = Array.from(serviceCarousel.querySelectorAll('[data-service-card]'));
  const prev = serviceCarousel.querySelector('[data-carousel-prev]');
  const next = serviceCarousel.querySelector('[data-carousel-next]');

  if (stage && ring && cards.length) {
    const state = { rotation: 0, target: 0 };
    let radius = 0;
    let activeTween = null;
    let dragStartX = 0;
    let dragStartRotation = 0;
    let dragging = false;

    const setActiveCard = () => {
      const normalized = ((state.rotation % 360) + 360) % 360;
      const activeIndex = Math.round(normalized / (360 / cards.length)) % cards.length;
      cards.forEach((card, index) => card.classList.toggle('is-active', index === activeIndex));
    };

    const render = () => {
      if (typeof gsap !== 'undefined') {
        gsap.set(ring, { rotationY: state.rotation, transformPerspective: 1600, transformOrigin: '50% 50%' });
      } else {
        ring.style.transform = `rotateY(${state.rotation}deg)`;
      }
      setActiveCard();
    };

    const positionCards = () => {
      const cardWidth = cards[0].getBoundingClientRect().width || 320;
      radius = Math.max((cardWidth / 2) / Math.tan(Math.PI / cards.length), serviceCarousel.classList.contains('service-carousel--mini') ? 108 : 260);
      const gap = 40; // Define o espaçamento entre os cards (em pixels)
      radius = Math.max(((cardWidth + gap) / 2) / Math.tan(Math.PI / cards.length), serviceCarousel.classList.contains('service-carousel--mini') ? 140 : 300);
      cards.forEach((card, index) => {
        const angle = index * (360 / cards.length);
        card.style.transform = `translate(-50%, -50%) rotateY(${angle}deg) translateZ(${radius}px)`;
      });
      render();
    };

    const animateTo = (rotation) => {
      state.target = rotation;
      if (typeof gsap !== 'undefined') {
        activeTween?.kill?.();
        activeTween = gsap.to(state, {
          rotation,
          duration: 0.75,
          ease: 'power3.out',
          onUpdate: render,
        });
      } else {
        state.rotation = rotation;
        render();
      }
    };

    prev?.addEventListener('click', () => animateTo(state.rotation + (360 / cards.length)));
    next?.addEventListener('click', () => animateTo(state.rotation - (360 / cards.length)));

    const onPointerMove = (event) => {
      if (!dragging) return;
      const delta = event.clientX - dragStartX;
      state.rotation = dragStartRotation + (delta * 0.28);
      render();
    };

    const endDrag = () => {
      if (!dragging) return;
      dragging = false;
      window.removeEventListener('pointermove', onPointerMove);
      window.removeEventListener('pointerup', endDrag);
      animateTo(Math.round(state.rotation / (360 / cards.length)) * (360 / cards.length));
    };

    stage.addEventListener('pointerdown', (event) => {
      // Limita a área de arraste para o meio (ignora os 20% das bordas laterais)
      const rect = stage.getBoundingClientRect();
      const relativeX = event.clientX - rect.left;
      const threshold = rect.width * 0.2;
      if (relativeX < threshold || relativeX > rect.width - threshold) return;

      dragging = true;
      dragStartX = event.clientX;
      dragStartRotation = state.rotation;
      activeTween?.kill?.();
      window.addEventListener('pointermove', onPointerMove);
      window.addEventListener('pointerup', endDrag);
    });

    stage.addEventListener('keydown', (event) => {
      if (event.key === 'ArrowRight') {
        event.preventDefault();
        animateTo(state.rotation - (360 / cards.length));
      }
      if (event.key === 'ArrowLeft') {
        event.preventDefault();
        animateTo(state.rotation + (360 / cards.length));
      }
    });

    window.addEventListener('resize', positionCards, { passive: true });
    positionCards();
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

// Smooth-scroll navigation handling
(function(){
  function findTarget(hash){
    if(!hash) return null;
    const id = hash.replace('#','');
    return document.getElementById(id) || document.querySelector(`[name="${id}"]`);
  }

  function smoothScrollToHash(hash){
    const target = findTarget(hash);
    if(target){
      target.scrollIntoView({ behavior: 'smooth', block: 'start' });
      // set focus for accessibility
      try{ target.focus({preventScroll:true}); }catch(e){}
    }
  }

  // If the page loaded with a hash, avoid the instant jump and perform a smooth scroll
  if(window.location.hash){
    // ensure page starts at top then smooth scroll after paint
    window.scrollTo(0,0);
    window.addEventListener('load', ()=>{
      // small delay to allow styles/layout
      setTimeout(()=> smoothScrollToHash(window.location.hash), 60);
    });
  }

  // Intercept in-page anchor clicks to perform smooth scroll without reloading when already on root
  document.querySelectorAll('a[href^="#"], a[href^="/#"]').forEach((link)=>{
    link.addEventListener('click', (e)=>{
      const href = link.getAttribute('href');
      const hashIndex = href.indexOf('#');
      if(hashIndex === -1) return;
      const hash = href.slice(hashIndex);
      // If current path is root or index, do an in-page smooth scroll
      const path = window.location.pathname.replace(/index\.php$/,'/') || '/';
      if(path === '/' || path === '/index.php' || path === ''){
        e.preventDefault();
        history.pushState(null, '', hash);
        smoothScrollToHash(hash);
      }
      // otherwise allow normal navigation — on load handler will smooth-scroll
    });
  });
})();