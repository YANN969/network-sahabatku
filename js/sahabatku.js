// Data

var faqs = [
  { q: "Apa saja paket internet yang tersedia?", a: "Sahabatku menyediakan 3 paket internet: Basic (30 Mbps, Rp 150k/bulan), Family (50 Mbps, Rp 300k/bulan), dan Bisnis (100 Mbps, Rp 700k/bulan). Semua paket bersifat unlimited tanpa batas kuota." },
  { q: "Bagaimana cara mendaftar layanan Sahabatku?", a: "Anda dapat mendaftar melalui website kami dengan mengklik tombol 'Daftar' di navbar, atau menghubungi customer service kami melalui  di nomor 0895-3339-53073." },
  { q: "Berapa lama proses instalasi?", a: "Proses instalasi biasanya memakan waktu 1–3 hari kerja setelah pendaftaran dan pembayaran dilakukan. Tim teknisi kami akan menghubungi Anda untuk menjadwalkan instalasi." },
  { q: "Apakah instalasi dikenakan biaya?", a: "Tidak, biaya instalasi sudah termasuk dalam paket yang Anda pilih. Kami memberikan instalasi GRATIS untuk semua paket." },
  { q: "Bagaimana jika terjadi gangguan internet?", a: "Anda dapat menghubungi customer service kami 24/7 melalui telepon atau WhatsApp. Tim teknisi kami akan segera menangani gangguan tersebut dengan cepat." }
];

// Slider

/**
 * Returns the next slide index using modulo arithmetic.
 * @param {number} current
 * @param {number} total
 * @returns {number}
 */
function getNextSlideIndex(current, total) {
  return (current + 1) % total;
}

var currentSlide = 0;
var sliderInterval = null;

/**
 * Navigate to a specific slide index and update dots.
 * @param {number} index
 */
function goToSlide(index) {
  var track = document.getElementById('slider-track');
  var dots = document.querySelectorAll('.dot');
  var slideEls = document.querySelectorAll('.slide');

  if (!track || slideEls.length === 0) return;

  var total = slideEls.length;
  index = ((index % total) + total) % total;

  track.style.transform = 'translateX(-' + (index * 100) + '%)';

  for (var i = 0; i < slideEls.length; i++) {
    if (i === index) {
      slideEls[i].classList.add('active');
    } else {
      slideEls[i].classList.remove('active');
    }
  }

  for (var j = 0; j < dots.length; j++) {
    if (j === index) {
      dots[j].classList.add('active');
      dots[j].setAttribute('aria-selected', 'true');
    } else {
      dots[j].classList.remove('active');
      dots[j].setAttribute('aria-selected', 'false');
    }
  }

  currentSlide = index;
}

function startSliderAutoplay() {
  var slideEls = document.querySelectorAll('.slide');
  if (slideEls.length <= 1) return;

  sliderInterval = setInterval(function () {
    goToSlide(getNextSlideIndex(currentSlide, slideEls.length));
  }, 5000);
}

function initSlider() {
  var dots = document.querySelectorAll('.dot');
  var slideEls = document.querySelectorAll('.slide');
  var dotsContainer = document.getElementById('slider-dots');

  if (slideEls.length === 0) return;

  if (slideEls.length <= 1 && dotsContainer) {
    dotsContainer.style.display = 'none';
  }

  for (var i = 0; i < dots.length; i++) {
    (function (dot) {
      dot.addEventListener('click', function () {
        var idx = parseInt(dot.getAttribute('data-index'), 10);
        goToSlide(idx);
        clearInterval(sliderInterval);
        startSliderAutoplay();
      });
    })(dots[i]);
  }

  // Animate first slide in after 300ms (
  setTimeout(function () {
    goToSlide(0);
  }, 300);

  startSliderAutoplay();
}


// FAQ Accordion

/**
 * Toggle FAQ item — close all others, toggle the clicked one.
 * @param {number} index
 */
function toggleFAQ(index) {
  var items = document.querySelectorAll('.faq-item');
  for (var i = 0; i < items.length; i++) {
    if (i === index) {
      items[i].classList.toggle('open');
    } else {
      items[i].classList.remove('open');
    }
  }
}

function initFAQ() {
  var list = document.getElementById('faq-list');
  if (!list) return;

  for (var i = 0; i < faqs.length; i++) {
    (function (faq, idx) {
      var item = document.createElement('div');
      item.className = 'faq-item';
      item.innerHTML =
        '<button class="faq-question" aria-expanded="false">' +
          faq.q +
          '<span class="faq-icon" aria-hidden="true">+</span>' +
        '</button>' +
        '<div class="faq-answer"><p>' + faq.a + '</p></div>';

      item.querySelector('.faq-question').addEventListener('click', function () {
        toggleFAQ(idx);
        var isOpen = item.classList.contains('open');
        item.querySelector('.faq-question').setAttribute('aria-expanded', isOpen ? 'true' : 'false');
      });

      list.appendChild(item);
    })(faqs[i], i);
  }
}

// Fade-in on scroll

function initFadeIn() {
  var fadeEls = document.querySelectorAll('.fade-in');
  if (!('IntersectionObserver' in window)) {
    for (var i = 0; i < fadeEls.length; i++) {
      fadeEls[i].classList.add('visible');
    }
    return;
  }

  var observer = new IntersectionObserver(function (entries) {
    for (var i = 0; i < entries.length; i++) {
      if (entries[i].isIntersecting) {
        entries[i].target.classList.add('visible');
        observer.unobserve(entries[i].target);
      }
    }
  }, { threshold: 0.15 });

  for (var j = 0; j < fadeEls.length; j++) {
    observer.observe(fadeEls[j]);
  }
}

// Hamburger Menu

function initHamburger() {
  var hamburger = document.getElementById('hamburger');
  var navMenu = document.getElementById('nav-menu');
  if (!hamburger || !navMenu) return;

  hamburger.addEventListener('click', function () {
    var isActive = navMenu.classList.toggle('active');
    hamburger.setAttribute('aria-expanded', isActive ? 'true' : 'false');
  });

  // Close menu when a nav link is clicked
  var navLinks = navMenu.querySelectorAll('a');
  for (var i = 0; i < navLinks.length; i++) {
    navLinks[i].addEventListener('click', function () {
      navMenu.classList.remove('active');
      hamburger.setAttribute('aria-expanded', 'false');
    });
  }
}

// Smooth Scroll

function initSmoothScroll() {
  var anchors = document.querySelectorAll('a[href^="#"]');
  for (var i = 0; i < anchors.length; i++) {
    anchors[i].addEventListener('click', function (e) {
      var href = this.getAttribute('href');
      if (href === '#') return;
      var target = document.querySelector(href);
      if (target) {
        e.preventDefault();
        target.scrollIntoView({ behavior: 'smooth' });
      }
    });
  }
}


// Modal Legal

function openModal(id) {
  var overlay = document.getElementById(id);
  if (!overlay) return;
  overlay.classList.add('active');
  document.body.style.overflow = 'hidden';

  // Render FAQ accordion di dalam modal jika belum
  if (id === 'modal-faq') {
    var list = document.getElementById('faq-modal-list');
    if (list && list.children.length === 0) {
      for (var i = 0; i < faqs.length; i++) {
        (function (faq, idx) {
          var item = document.createElement('div');
          item.className = 'faq-item';
          item.innerHTML =
            '<button class="faq-question" aria-expanded="false">' +
              faq.q +
              '<span class="faq-icon" aria-hidden="true">+</span>' +
            '</button>' +
            '<div class="faq-answer"><p>' + faq.a + '</p></div>';

          item.querySelector('.faq-question').addEventListener('click', function () {
            var allItems = list.querySelectorAll('.faq-item');
            allItems.forEach(function (el, i) {
              if (i === idx) {
                el.classList.toggle('open');
              } else {
                el.classList.remove('open');
              }
            });
          });

          list.appendChild(item);
        })(faqs[i], i);
      }
    }
  }
}

function closeModal(id) {
  var overlay = document.getElementById(id);
  if (!overlay) return;
  overlay.classList.remove('active');
  document.body.style.overflow = '';
}

function closeLegalModal(event, id) {
  // Tutup hanya jika klik di overlay (bukan di dalam modal)
  if (event.target === document.getElementById(id)) {
    closeModal(id);
  }
}

// DOM Ready
  document.addEventListener('DOMContentLoaded', function () {
    initSlider();
    initFAQ();
    initFadeIn();
    initHamburger();
    initSmoothScroll();
  });



