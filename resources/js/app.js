import { gsap } from 'gsap';

const initApp = function () {
    /* =====================================================================
       Education Tabs with Blinds Transition
       ===================================================================== */
    const educContent = [
        {
            icon: 'precision_manufacturing',
            badge: 'Technology Track',
            subtitle: 'Automating Quality Control',
            title: 'AI in Diagnostics',
            desc: 'Discover how computer vision and machine learning models are automating cosmetic grading and hardware testing for thousands of devices an hour, reducing human error and boosting efficiency.',
            benefits: ['99.4% Grading Accuracy', 'Reduced Cycle Times', 'Standardized Cosmetic Standards'],
        },
        {
            icon: 'trending_up',
            badge: 'Business Track',
            subtitle: 'Securing Profit Margins',
            title: 'Growth Strategies',
            desc: 'Learn about financial hedging, volume procurement, and logistics optimization workflows to protect and improve profit margins in the highly volatile global secondary mobile market.',
            benefits: ['Procurement Workflows', 'Hedging Volatility', 'Supply Chain Security'],
        },
        {
            icon: 'public',
            badge: 'Compliance Track',
            subtitle: 'Navigating Trade Tariffs',
            title: 'Global Policy & Compliance',
            desc: 'Get access to expert policy reviews on emerging cross-border e-waste shipping regulations, customs compliance procedures, international logistics requirements, and sustainability standards.',
            benefits: ['Customs Clearance Guides', 'E-waste Compliance', 'Cross-Border Logistics'],
        },
        {
            icon: 'diversity_3',
            badge: 'Leadership Track',
            subtitle: 'Empowering Industry Leaders',
            title: 'Women in Mobile',
            desc: 'Join monthly workshops, roundtables, and leadership development sessions designed specifically to empower and showcase women leading major secondary market operations.',
            benefits: ['Career Mentorship', 'Executive Roundtables', 'Talent Development'],
        },
    ];

    let activeEducTab = 0;
    let isEducTransitioning = false;
    const tabs = document.querySelectorAll('.educ-tab');

    if (tabs && tabs.length > 0) {
        const blindsContainer = document.getElementById('educ-blinds');
        const blinds = document.querySelectorAll('.educ-blind');
        const iconEl = document.getElementById('educ-icon');
        const badgeEl = document.getElementById('educ-badge');
        const subtitleEl = document.getElementById('educ-subtitle');
        const titleEl = document.getElementById('educ-card-title');
        const descEl = document.getElementById('educ-desc');
        const benefitsEl = document.getElementById('educ-benefits');

        function updateEducContent(index) {
            const data = educContent[index];
            if (!data) return;
            iconEl.textContent = data.icon;
            badgeEl.textContent = data.badge;
            subtitleEl.textContent = data.subtitle;
            titleEl.textContent = data.title;
            descEl.textContent = data.desc;

            benefitsEl.innerHTML = '';
            data.benefits.forEach(function (b) {
                const div = document.createElement('div');
                div.className = 'flex items-center gap-2 text-white/90';
                div.innerHTML =
                    '<span class="material-symbols-outlined text-[#40e0d0] text-lg">check_circle</span>' +
                    '<span class="text-xs font-semibold tracking-wide uppercase font-label-md">' + b + '</span>';
                benefitsEl.appendChild(div);
            });
        }

        function handleEducTabClick(index) {
            if (index === activeEducTab || isEducTransitioning) return;
            isEducTransitioning = true;

            // Update active tab styles
            tabs.forEach(function (t, i) {
                if (i === index) {
                    t.className = 'educ-tab font-label-md text-xs uppercase tracking-wider py-3 px-6 rounded-full border-2 transition-all duration-300 bg-[#006a6a] text-white border-[#006a6a] shadow-md';
                } else {
                    t.className = 'educ-tab font-label-md text-xs uppercase tracking-wider py-3 px-6 rounded-full border-2 transition-all duration-300 bg-white/5 text-white/70 border-white/10 hover:bg-white/10 hover:text-white';
                }
            });

            // Show blinds and animate
            blindsContainer.classList.remove('hidden');
            blinds.forEach(function (blind) {
                blind.classList.remove('animate-blind');
                // Force reflow
                void blind.offsetWidth;
                blind.classList.add('animate-blind');
            });

            // Mid-point switch content
            setTimeout(function () {
                updateEducContent(index);
            }, 380);

            // After animation completes
            setTimeout(function () {
                blindsContainer.classList.add('hidden');
                blinds.forEach(function (blind) {
                    blind.classList.remove('animate-blind');
                });
                activeEducTab = index;
                isEducTransitioning = false;
            }, 800);
        }

        tabs.forEach(function (tab) {
            tab.addEventListener('click', function () {
                var index = parseInt(tab.getAttribute('data-tab-index'));
                handleEducTabClick(index);
            });
        });

        // Set initial tab as active
        tabs[0].className = 'educ-tab font-label-md text-xs uppercase tracking-wider py-3 px-6 rounded-full border-2 transition-all duration-300 bg-[#006a6a] text-white border-[#006a6a] shadow-md';
        updateEducContent(0);
    }

    /* =====================================================================
       Scroll-triggered animations via Intersection Observer
       ===================================================================== */
    const scrollObserver = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-visible');
                scrollObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1, rootMargin: '-80px' });

    document.querySelectorAll('.animate-on-scroll').forEach(function (el) {
        scrollObserver.observe(el);
    });

    // Also observe stagger containers
    document.querySelectorAll('.stagger-children').forEach(function (el) {
        scrollObserver.observe(el);
    });

    // --- Subtly Fade-in Element Observer (Global) ---
    const fadeObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.remove('opacity-0', 'translate-y-12', 'translate-y-8');
                entry.target.classList.add('opacity-100', 'translate-y-0');
                fadeObserver.unobserve(entry.target);
            }
        });
    }, { rootMargin: '0px 0px -50px 0px', threshold: 0.15 });

    document.querySelectorAll('.observer-fade-in').forEach(el => fadeObserver.observe(el));

    /* =====================================================================
       Hero Parallax (scroll-based opacity fade)
       ===================================================================== */
    const heroSection = document.getElementById('hero-section');
    const heroContent = heroSection ? heroSection.querySelector('.relative.z-10') : null;

    if (heroSection && heroContent) {
        window.addEventListener('scroll', function () {
            const rect = heroSection.getBoundingClientRect();
            const viewportHeight = window.innerHeight;
            // Progress from 0 (hero top at viewport top) to 1 (hero top at viewport bottom)
            const progress = Math.min(1, Math.max(0, (viewportHeight - rect.top) / (viewportHeight + rect.height)));
            // Blend from fully visible to faded as hero scrolls up
            const opacity = 1 - progress * 0.5;
            heroContent.style.opacity = opacity;
        }, { passive: true });
    }

    /* =====================================================================
       Plan Section Parallax
       ===================================================================== */
    const planSection = document.getElementById('plan-section');
    const planCols = planSection ? planSection.querySelectorAll('.flex-1.text-center') : null;
    const planWatermark = document.getElementById('plan-watermark');

    if (planSection) {
        window.addEventListener('scroll', function () {
            const rect = planSection.getBoundingClientRect();
            const viewportHeight = window.innerHeight;
            const progress = Math.min(1, Math.max(0, (viewportHeight - rect.top) / (viewportHeight + rect.height)));

            if (planCols && planCols.length >= 3) {
                if (window.innerWidth >= 768) {
                    // Column 1: moves from 60px up to -60px
                    var y1 = 60 - progress * 120; // 60 to -60
                    planCols[0].style.transform = 'translateY(' + y1 + 'px)';

                    // Column 2: stays centered
                    planCols[1].style.transform = 'translateY(0px)';

                    // Column 3: moves from 100px up to -100px
                    var y3 = 100 - progress * 200; // 100 to -100
                    planCols[2].style.transform = 'translateY(' + y3 + 'px)';
                } else {
                    planCols[0].style.transform = '';
                    planCols[1].style.transform = '';
                    planCols[2].style.transform = '';
                }
            }

            if (planWatermark) {
                var xOffset = -80 + progress * 160; // -80 to 80
                planWatermark.style.transform = 'translateX(' + xOffset + 'px)';
            }
        }, { passive: true });

        // Set initial parallax state
        var initEvent = new Event('scroll');
        window.dispatchEvent(initEvent);
    }

    /* =====================================================================
       Education Watermark Parallax
       ===================================================================== */
    const educSection = document.getElementById('education-section');
    const educWatermark = document.getElementById('educ-watermark');

    if (educSection && educWatermark) {
        window.addEventListener('scroll', function () {
            const rect = educSection.getBoundingClientRect();
            const viewportHeight = window.innerHeight;

            if (rect.top < viewportHeight && rect.bottom > 0) {
                const totalScrollable = viewportHeight + rect.height;
                const progress = Math.min(1, Math.max(0, (viewportHeight - rect.top) / totalScrollable));
                const xOffset = -60 + progress * 120; // moves horizontally
                educWatermark.style.transform = 'translate(-50%, -50%) translateX(' + xOffset + 'px)';
            }
        }, { passive: true });

        // Trigger scroll once to initialize position
        window.dispatchEvent(new Event('scroll'));
    }

    /* =====================================================================
       Navbar Animations and Interactivity
       ===================================================================== */
    const navHoverPill = document.getElementById('nav-hover-pill');
    const navItems = document.querySelectorAll('nav.hidden.xl\\:flex .nav-item');
    const mobileMenuBtn = document.getElementById('mobile-menu-btn');
    const mobileDrawer = document.getElementById('mobile-drawer');

    // Hover Pill logic
    if (navHoverPill && navItems.length > 0) {
        const parentNav = navItems[0].parentElement;
        navItems.forEach(item => {
            item.addEventListener('mouseenter', function () {
                const rect = item.getBoundingClientRect();
                const parentRect = parentNav.getBoundingClientRect();

                navHoverPill.style.left = (rect.left - parentRect.left) + 'px';
                navHoverPill.style.width = rect.width + 'px';
                navHoverPill.style.opacity = '1';
            });
        });

        parentNav.addEventListener('mouseleave', function () {
            navHoverPill.style.opacity = '0';
        });
    }

    // Burger Menu Logic
    if (mobileMenuBtn && mobileDrawer) {
        mobileMenuBtn.addEventListener('click', function () {
            const isVisible = !mobileDrawer.classList.contains('invisible');
            if (isVisible) {
                mobileDrawer.classList.add('invisible', 'opacity-0', '-translate-y-4');
                mobileMenuBtn.querySelector('span').textContent = 'menu';

                // Collapse any expanded accordions inside the drawer when closing
                document.querySelectorAll('.mobile-accordion-content').forEach(content => {
                    content.style.maxHeight = '0px';
                });
                document.querySelectorAll('.mobile-accordion-btn .material-symbols-outlined').forEach(arrow => {
                    arrow.style.transform = 'rotate(0deg)';
                });
            } else {
                mobileDrawer.classList.remove('invisible', 'opacity-0', '-translate-y-4');
                mobileMenuBtn.querySelector('span').textContent = 'close';
            }
        });
    }

    // Mobile Accordion Drawer Logic
    const accordionBtns = document.querySelectorAll('.mobile-accordion-btn');
    accordionBtns.forEach(btn => {
        btn.addEventListener('click', function () {
            const content = btn.nextElementSibling;
            const arrow = btn.querySelector('.material-symbols-outlined');
            if (content.style.maxHeight && content.style.maxHeight !== '0px') {
                content.style.maxHeight = '0px';
                arrow.style.transform = 'rotate(0deg)';
            } else {
                content.style.maxHeight = content.scrollHeight + 'px';
                arrow.style.transform = 'rotate(180deg)';
            }
        });
    });


    /* =====================================================================
       Page Transition Animation (Datamosh / Scanlines)
       ===================================================================== */
    const overlay = document.getElementById('gma-transition-overlay');
    const scanlineNodes = document.querySelectorAll('.gma-scanline');

    // Entrance Animation
    if (overlay && scanlineNodes.length > 0) {
        const scanlinesJson = sessionStorage.getItem('gmaScanlines');
        if (scanlinesJson) {
            try {
                const scanlines = JSON.parse(scanlinesJson);
                scanlineNodes.forEach((node, i) => {
                    if (scanlines[i]) {
                        gsap.to(node, {
                            x: '100vw',
                            duration: scanlines[i].duration,
                            delay: scanlines[i].delay,
                            ease: 'power3.inOut',
                        });
                    }
                });
                
                const maxTime = Math.max(...scanlines.map(s => s.duration + s.delay));
                setTimeout(() => {
                    overlay.remove();
                    sessionStorage.removeItem('gmaTransitionColor');
                    sessionStorage.removeItem('gmaScanlines');
                }, maxTime * 1000 + 100);
            } catch (e) {
                console.error("Failed to parse scanlines in app.js", e);
                overlay.remove();
            }
        } else {
            overlay.remove();
        }
    }

    // Intercept clicks for Exit Animation
    document.querySelectorAll('a').forEach(link => {
        link.addEventListener('click', function (e) {
            if (
                link.hostname === window.location.hostname &&
                link.pathname !== window.location.pathname &&
                !link.hasAttribute('download') &&
                link.getAttribute('target') !== '_blank' &&
                !link.hash &&
                !link.href.includes('mailto:') &&
                !link.href.includes('tel:')
            ) {
                let path = link.pathname;
                if (path.length > 1 && path.endsWith('/')) {
                    path = path.slice(0, -1);
                }

                let currentPath = window.location.pathname;
                if (currentPath.length > 1 && currentPath.endsWith('/')) {
                    currentPath = currentPath.slice(0, -1);
                }

                const allowedPaths = ['/', '/about', '/events', '/committees', '/who-we-serve', '/research-insights'];

                if (!allowedPaths.includes(path) || !allowedPaths.includes(currentPath)) {
                    return; // Allow default navigation without animation
                }

                e.preventDefault();
                
                const color = 'linear-gradient(90deg, #0f172a 0%, #1e3a8a 50%, #40e0d0 100%)';
                
                // Generate strips (overshoot by 1.5x to ensure it covers if viewport resizes)
                const strips = [];
                let totalHeight = 0;
                const targetHeight = window.innerHeight * 1.5;
                
                while (totalHeight < targetHeight) {
                    const h = Math.floor(Math.random() * (60 - 10 + 1)) + 10;
                    const dur = 0.4 + Math.random() * 0.4; // 0.4s to 0.8s
                    const del = Math.random() * 0.2; // 0s to 0.2s
                    strips.push({ height: h, duration: dur, delay: del });
                    totalHeight += h;
                }
                
                sessionStorage.setItem('gmaScanlines', JSON.stringify(strips));
                sessionStorage.setItem('gmaTransitionColor', color);
                
                const outOverlay = document.createElement('div');
                outOverlay.style.cssText = 'position: fixed; inset: 0; z-index: 99999; pointer-events: none; overflow: hidden; background: transparent; display: flex; flex-direction: column; justify-content: flex-start;';
                
                const outNodes = [];
                strips.forEach((strip, i) => {
                    const el = document.createElement('div');
                    const mt = i === 0 ? '0' : '-1px';
                    el.style.cssText = `width: 100vw; height: ${strip.height}px; background: ${color}; transform: translateX(-100vw); flex-shrink: 0; will-change: transform; margin-top: ${mt};`;
                    outOverlay.appendChild(el);
                    outNodes.push({ el, dur: strip.duration, del: strip.delay });
                });
                
                document.body.appendChild(outOverlay);
                
                let maxTime = 0;
                outNodes.forEach(node => {
                    const time = node.dur + node.del;
                    if (time > maxTime) maxTime = time;
                    gsap.to(node.el, {
                        x: 0,
                        duration: node.dur,
                        delay: node.del,
                        ease: 'power3.inOut'
                    });
                });
                
                setTimeout(() => {
                    window.location.href = link.href;
                }, maxTime * 1000 + 50);
            }
        });
    });
};

document.addEventListener('DOMContentLoaded', initApp);
document.addEventListener('livewire:navigated', initApp);