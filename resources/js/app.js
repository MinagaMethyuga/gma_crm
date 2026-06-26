document.addEventListener('DOMContentLoaded', function () {

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
    if (tabs.length > 0) {
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
                // Column 1: moves from 60px up to -60px
                var y1 = 60 - progress * 120; // 60 to -60
                planCols[0].style.transform = 'translateY(' + y1 + 'px)';

                // Column 2: stays centered
                planCols[1].style.transform = 'translateY(0px)';

                // Column 3: moves from 100px up to -100px
                var y3 = 100 - progress * 200; // 100 to -100
                planCols[2].style.transform = 'translateY(' + y3 + 'px)';

                // Only apply if all 3 are visible (desktop layout)
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

});
