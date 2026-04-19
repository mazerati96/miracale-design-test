// ── Sticky nav on scroll ──
const nav = document.getElementById('nav');
window.addEventListener('scroll', () => {
    nav.classList.toggle('scrolled', window.scrollY > 40);
});

// ── Scroll-reveal ──
const reveals = document.querySelectorAll('.reveal');
const observer = new IntersectionObserver((entries) => {
    entries.forEach(e => {
        if (e.isIntersecting) {
            e.target.classList.add('visible');
            observer.unobserve(e.target);
        }
    });
}, { threshold: 0.1 });
reveals.forEach(el => observer.observe(el));

// ── Mobile hamburger menu ──
const hamburger = document.getElementById('navHamburger');
const drawer = document.getElementById('navDrawer');
const drawerClose = document.getElementById('navDrawerClose');
const overlay = document.getElementById('navOverlay');

function openDrawer() {
    drawer.classList.add('open');
    overlay.classList.add('open');
    document.body.style.overflow = 'hidden';
}
function closeDrawer() {
    drawer.classList.remove('open');
    overlay.classList.remove('open');
    document.body.style.overflow = '';
}

if (hamburger) hamburger.addEventListener('click', openDrawer);
if (drawerClose) drawerClose.addEventListener('click', closeDrawer);
if (overlay) overlay.addEventListener('click', closeDrawer);

// ── Scroll hint — click to scroll past the hero ──
const scrollHint = document.querySelector('.scroll-hint');
if (scrollHint) {
    scrollHint.style.cursor = 'pointer';
    scrollHint.addEventListener('click', function () {
        const hero = document.querySelector('.hero');
        if (hero) {
            const nextSection = hero.nextElementSibling;
            if (nextSection) {
                nextSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        }
    });
}