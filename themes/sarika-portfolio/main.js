document.addEventListener('DOMContentLoaded', function () {

    // ===========================
    // MOBILE NAV TOGGLE
    // ===========================
    const navToggle = document.getElementById('nav-toggle');
    const siteNav = document.getElementById('site-nav');

    if (navToggle && siteNav) {
        navToggle.addEventListener('click', function () {
            siteNav.classList.toggle('open');
        });
    }

    // Close nav when a link is clicked
    const navLinks = document.querySelectorAll('.site-nav a');
    navLinks.forEach(function (link) {
        link.addEventListener('click', function () {
            siteNav.classList.remove('open');
        });
    });

    // ===========================
    // STICKY HEADER SHADOW
    // ===========================
    const header = document.getElementById('site-header');

    window.addEventListener('scroll', function () {
        if (window.scrollY > 50) {
            header.style.boxShadow = '0 4px 30px rgba(0, 0, 0, 0.4)';
        } else {
            header.style.boxShadow = 'none';
        }
    });

    // ===========================
    // ACTIVE NAV LINK ON SCROLL
    // ===========================
    const sections = document.querySelectorAll('section[id]');

    window.addEventListener('scroll', function () {
        let scrollY = window.scrollY + 100;

        sections.forEach(function (section) {
            const sectionTop = section.offsetTop;
            const sectionHeight = section.offsetHeight;
            const sectionId = section.getAttribute('id');
            const navLink = document.querySelector('.site-nav a[href="#' + sectionId + '"]');

            if (navLink) {
                if (scrollY >= sectionTop && scrollY < sectionTop + sectionHeight) {
                    document.querySelectorAll('.site-nav a').forEach(a => a.classList.remove('active'));
                    navLink.classList.add('active');
                }
            }
        });
    });

    // ===========================
    // SCROLL FADE-IN ANIMATION
    // ===========================
    const fadeElements = document.querySelectorAll(
        '.skill-category, .project-card, .stat, .contact-item'
    );

    const observer = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1 });

    fadeElements.forEach(function (el) {
        el.style.opacity = '0';
        el.style.transform = 'translateY(20px)';
        el.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
        observer.observe(el);
    });

});
