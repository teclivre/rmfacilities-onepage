(function () {
	const header = document.querySelector('.site-header');
	const toggle = document.querySelector('.menu-toggle');
	const nav = document.querySelector('.main-navigation');

	if (toggle && nav) {
		toggle.addEventListener('click', function () {
			const isOpen = nav.classList.toggle('is-open');
			toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
		});
	}

	const menuLinks = document.querySelectorAll('.main-navigation a[href*="#"], .footer-menu a[href*="#"]');

	menuLinks.forEach(function (link) {
		link.addEventListener('click', function (event) {
			const href = link.getAttribute('href');
			if (!href) {
				return;
			}

			const hashIndex = href.indexOf('#');
			if (hashIndex === -1) {
				return;
			}

			const targetId = href.slice(hashIndex + 1);
			if (!targetId) {
				return;
			}

			const target = document.getElementById(targetId);
			if (!target) {
				return;
			}

			event.preventDefault();

			const offset = header ? header.offsetHeight + 8 : 0;
			const y = target.getBoundingClientRect().top + window.scrollY - offset;

			window.scrollTo({
				top: y,
				behavior: 'smooth'
			});

			if (nav) {
				nav.classList.remove('is-open');
			}
			if (toggle) {
				toggle.setAttribute('aria-expanded', 'false');
			}
		});
	});

	// Intersection Observer para animar elementos ao scroll
	const observerOptions = {
		threshold: 0.1,
		rootMargin: '0px 0px -50px 0px'
	};

	const observer = new IntersectionObserver(function (entries) {
		entries.forEach(function (entry) {
			if (entry.isIntersecting) {
				entry.target.classList.add('in-viewport');
				observer.unobserve(entry.target);
			}
		});
	}, observerOptions);

	// Aplicar observer a elementos animáveis
	const animatableElements = document.querySelectorAll('.card, .post-card, .section h2, .section h3, .btn, .highlight-box');
	animatableElements.forEach(function (element) {
		if (!element.classList.contains('in-viewport')) {
			observer.observe(element);
		}
	});

	// Adicionar classe de animação ao scroll
	window.addEventListener('scroll', function () {
		if (header && window.scrollY > 10) {
			header.classList.add('scrolled');
		} else if (header) {
			header.classList.remove('scrolled');
		}
	});

	// Efeito de paralax suave
	const heroSection = document.querySelector('.hero');
	if (heroSection) {
		window.addEventListener('scroll', function () {
			const scrolled = window.scrollY;
			heroSection.style.backgroundPosition = '0 ' + (scrolled * 0.5) + 'px';
		});
	}
})();
				toggle.setAttribute('aria-expanded', 'false');
			}
		});
	});
})();
