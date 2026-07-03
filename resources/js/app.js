import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

gsap.registerPlugin(ScrollTrigger);

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
       GSAP Mission & Vision Pinned Sequence (about.blade.php)
       ===================================================================== */
    const pinnedContainer = document.getElementById('mv-pinned-container');
    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    if (pinnedContainer && !prefersReducedMotion) {
        const mLayer = document.querySelector('.gs-mission-layer');
        const mLeft = document.querySelector('.gs-mission-left');
        const mRight = document.querySelector('.gs-mission-right');
        
        const vLayer = document.querySelector('.gs-vision-layer');
        const vLeft = document.querySelector('.gs-vision-left');
        const vRight = document.querySelector('.gs-vision-right');

        const centerMission = document.querySelector('.gs-center-mission');
        const centerVision = document.querySelector('.gs-center-vision');

        if (mLayer && vLayer) {
            gsap.set(vLayer, { visibility: 'visible' });

            const tl = gsap.timeline({
                scrollTrigger: {
                    trigger: pinnedContainer,
                    start: 'top top',
                    end: '+=200%', // Increased scroll space for the cool split effect
                    pin: true,
                    scrub: 1, // Smoothing
                }
            });

            // 1. Initial short hold
            tl.to({}, { duration: 0.2 })
              // 2. Split Screen Transition
              // Mission Left goes UP (-100%), Mission Right goes DOWN (100%)
              .to(mLeft, { y: '-100%', duration: 1, ease: 'power2.inOut' }, 'split')
              .to(mRight, { y: '100%', duration: 1, ease: 'power2.inOut' }, 'split')
              
              // Vision Left comes UP from 100% to 0%, Vision Right comes DOWN from -100% to 0%
              .to(vLeft, { y: '0%', duration: 1, ease: 'power2.inOut' }, 'split')
              .to(vRight, { y: '0%', duration: 1, ease: 'power2.inOut' }, 'split')

              // Center Icon Transition
              .to(centerMission, { scale: 0.5, opacity: 0, duration: 0.5, ease: 'power2.in' }, 'split')
              .to(centerVision, { scale: 1, opacity: 1, duration: 0.5, ease: 'power2.out' }, 'split+=0.5')
              
              // 3. Short hold on Vision
              .to({}, { duration: 0.2 });
        }
    } else if (pinnedContainer && prefersReducedMotion) {
        // Accessibility Fallback
        const animWrapper = document.getElementById('mv-anim-wrapper');
        const fallback = document.querySelector('.gs-fallback');
        if (animWrapper) animWrapper.style.display = 'none';
        if (fallback) {
            fallback.classList.remove('hidden');
            fallback.classList.add('block');
        }
    }

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
    const header = document.getElementById('gma-header');
    if (header) {
        const logo = header.querySelector('img');
        window.addEventListener('scroll', function () {
            if (window.scrollY > 50) {
                header.classList.remove('py-4');
                header.classList.add('py-2', 'shadow-md');
                if (logo) {
                    logo.classList.remove('h-20', 'md:h-28');
                    logo.classList.add('h-16', 'md:h-20');
                }
            } else {
                header.classList.remove('py-2', 'shadow-md');
                header.classList.add('py-4');
                if (logo) {
                    logo.classList.remove('h-16', 'md:h-20');
                    logo.classList.add('h-20', 'md:h-28');
                }
            }
        }, { passive: true });
        
        // Run once on load/navigation
        if (window.scrollY > 50) {
            header.classList.remove('py-4');
            header.classList.add('py-2', 'shadow-md');
            if (logo) {
                logo.classList.remove('h-20', 'md:h-28');
                logo.classList.add('h-16', 'md:h-20');
            }
        }
    }

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
    // --- Founder Story Sequence Animation ---
    const founderSection = document.getElementById('founder-story-section');
    const founderWrapper = document.getElementById('founder-anim-wrapper');
    const founderFallback = document.querySelector('.founder-fallback');
    
    if (founderSection && founderWrapper) {
        const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        
        if (prefersReducedMotion) {
            founderWrapper.style.display = 'none';
            if (founderFallback) {
                founderFallback.classList.remove('hidden');
                founderFallback.classList.add('flex');
            }
            founderSection.style.height = 'auto';
        } else {
            const title = founderSection.querySelector('.founder-title');
            const card = founderSection.querySelector('.founder-card');
            const p1 = founderSection.querySelector('.founder-p1');
            const p2 = founderSection.querySelector('.founder-p2');
            const p3 = founderSection.querySelector('.founder-p3');
            
            // Set initial states
            gsap.set(title, { y: 150, opacity: 0, filter: 'blur(10px)' });
            gsap.set(card, { scale: 0.8, opacity: 0, filter: 'blur(5px)' });
            gsap.set([p1, p2], { x: 50, opacity: 0, filter: 'blur(5px)' });
            gsap.set(p3, { x: -50, opacity: 0, filter: 'blur(5px)' });
            
            const founderTl = gsap.timeline({
                scrollTrigger: {
                    trigger: founderSection,
                    start: "top top",
                    end: "+=600%", // 6 viewport heights
                    pin: true,
                    scrub: 1,
                    anticipatePin: 1
                }
            });
            
            // 1. Title rises and fades in
            founderTl.to(title, {
                y: 0,
                opacity: 1,
                filter: 'blur(0px)',
                duration: 1,
                ease: "power2.out"
            });
            
            founderTl.addLabel("titleHold", "+=0.5");
            
            // Title fades out as Bob fades in
            founderTl.to(title, {
                scale: 1.1,
                opacity: 0,
                filter: 'blur(10px)',
                duration: 0.8
            });
            
            // 2. Bob Lafon image fades in and scales up in center
            founderTl.to(card, {
                scale: 1.2,
                opacity: 1,
                filter: 'blur(0px)',
                duration: 1,
                ease: "power2.out"
            }, "<0.2");
            
            founderTl.addLabel("bobCenter", "+=0.5");
            
            // 3. Image shifts left, P1 appears
            founderTl.to(card, {
                x: () => window.innerWidth > 1024 ? - (window.innerWidth * 0.18) : 0, // Shifting less to the left to close the gap
                y: () => window.innerWidth > 1024 ? 0 : - (window.innerHeight * 0.28), // Move up much further on mobile to clear text
                scale: 1,
                duration: 1,
                ease: "power2.inOut"
            });
            
            founderTl.to(p1, {
                x: 0,
                opacity: 1,
                filter: 'blur(0px)',
                duration: 1,
                ease: "power2.out"
            }, "<0.3");
            
            founderTl.addLabel("p1Hold", "+=1.5");
            
            // 4. P1 fades out, Image shifts further left/shrinks, P2 appears
            founderTl.to(p1, {
                x: -50,
                opacity: 0,
                filter: 'blur(5px)',
                duration: 0.8
            });
            
            founderTl.to(card, {
                x: () => window.innerWidth > 1024 ? - (window.innerWidth * 0.22) : 0, // Shifting less to the left
                y: () => window.innerWidth > 1024 ? 0 : - (window.innerHeight * 0.3),
                scale: 0.9,
                duration: 1,
                ease: "power2.inOut"
            }, "<");
            
            founderTl.to(p2, {
                x: 0,
                opacity: 1,
                filter: 'blur(0px)',
                duration: 1,
                ease: "power2.out"
            }, "<0.3");
            
            founderTl.addLabel("p2Hold", "+=1.5");
            
            // 5. P2 fades out, Image moves to the right, P3 appears on the left
            founderTl.to(p2, {
                x: -50,
                opacity: 0,
                filter: 'blur(5px)',
                duration: 0.8
            });
            
            founderTl.to(card, {
                x: () => window.innerWidth > 1024 ? (window.innerWidth * 0.24) : 0, // Shift to the right
                y: () => window.innerWidth > 1024 ? 0 : - (window.innerHeight * 0.28), // Move up on mobile to clear text
                scale: 1,
                duration: 1,
                ease: "power2.inOut"
            }, "<");
            
            founderTl.to(p3, {
                x: 0,
                opacity: 1,
                filter: 'blur(0px)',
                duration: 1,
                ease: "power2.out"
            }, "<0.3");
            
            founderTl.addLabel("p3Hold", "+=2");
        }
    }

    // --- Team Member Sequence Animation (Leadership Hierarchy Flow) ---
    const teamSection = document.getElementById('team-sequence-section');
    const teamWrapper = document.getElementById('team-anim-wrapper');
    const teamFallback = document.querySelector('.team-fallback');
    
    if (teamSection && teamWrapper) {
        const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        
        if (prefersReducedMotion) {
            // Show fallback, hide animated wrapper
            if (teamWrapper) teamWrapper.style.display = 'none';
            if (teamFallback) {
                teamFallback.classList.remove('hidden');
                teamFallback.classList.add('flex');
            }
            teamSection.style.height = 'auto'; // Remove h-screen constraint
        } else {
            const titleOur = teamSection.querySelector('.team-title-our');
            const titleLead = teamSection.querySelector('.team-title-lead');
            const leaderContainer = document.getElementById('leader-dana-container');
            const leaderProfile = leaderContainer.querySelector('.leader-profile-block');
            const leaderAvatar = leaderContainer.querySelector('.leader-avatar');
            const leaderInfo = leaderContainer.querySelector('.leader-info');
            const leaderBio = leaderContainer.querySelector('.leader-bio');
            
            const boardContainer = document.getElementById('board-container');
            const boardHeading = boardContainer.querySelector('.board-heading');
            const boardCards = boardContainer.querySelectorAll('.board-card');
            
            // Set initial states
            gsap.set(titleOur, { opacity: 1, y: 0 });
            gsap.set(titleLead, { opacity: 0, y: 30, scale: 0.95 });
            gsap.set(leaderContainer, { opacity: 0, y: 50 });
            gsap.set(boardContainer, { opacity: 0 });
            
            const teamTl = gsap.timeline({
                scrollTrigger: {
                    trigger: teamSection,
                    start: "top top",
                    end: "+=450%", // 4.5 viewport heights scroll distance
                    pin: true,
                    scrub: 1.5,
                    anticipatePin: 1
                }
            });
            
            // Step 1: Reveal Dana & title "Our Team" is active
            teamTl.to(leaderContainer, {
                opacity: 1,
                y: 0,
                duration: 1,
                ease: "power2.out"
            });
            
            // Step 2: Scroll transitions "Our Team" to "Leadership", Bio fades out, and Dana shifts to center/top
            teamTl.to(titleOur, {
                opacity: 0,
                y: -30,
                scale: 0.95,
                duration: 1,
                ease: "power2.inOut"
            }, "+=0.3");
            
            teamTl.to(titleLead, {
                opacity: 1,
                y: 0,
                scale: 1,
                duration: 1,
                ease: "power2.inOut"
            }, "<");
            
            // Dana's Bio fades out concurrently
            teamTl.to(leaderBio, {
                opacity: 0,
                y: -20,
                duration: 1,
                ease: "power2.inOut"
            }, "<");
            
            // Dana's Avatar & details scale down and move upward into the "Leader" top center position concurrently
            teamTl.to(leaderProfile, {
                x: () => window.innerWidth > 1024 ? (leaderBio.offsetWidth + 48) / 2 : 0, // Slide to center horizontally
                y: () => window.innerWidth > 1024 ? - (window.innerHeight * 0.08) : - (window.innerHeight * 0.14),
                scale: 0.85,
                duration: 1.2,
                ease: "power3.inOut"
            }, "<0.1");
            
            teamTl.addLabel("danaPinned", "+=0.5");
            
            // Step 5: Reveal Board of Directors heading & cards below Dana
            teamTl.to(boardContainer, {
                opacity: 1,
                pointerEvents: "auto",
                duration: 0.5
            }, "<");
            
            teamTl.to(boardHeading, {
                opacity: 1,
                y: 0,
                duration: 1,
                ease: "power2.out"
            }, "<0.3");
            
            // Staggered reveal of the board members cards
            teamTl.to(boardCards, {
                opacity: 1,
                y: 0,
                stagger: 0.2,
                duration: 1.2,
                ease: "power3.out"
            }, "<0.3");
            
            teamTl.addLabel("sequenceEnd", "+=1.5");
        }
    }
};

document.addEventListener('DOMContentLoaded', initApp);
document.addEventListener('livewire:navigated', initApp);
document.addEventListener('livewire:navigated', initApp);