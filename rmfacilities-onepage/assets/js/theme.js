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

	const sectionIds = ['inicio', 'sobre', 'resultados', 'servicos', 'contato', 'blog'];
	const sections = sectionIds
		.map(function (id) {
			return document.getElementById(id);
		})
		.filter(Boolean);

	function setActiveMenuLink() {
		if (!sections.length) {
			return;
		}

		const scrollOffset = (header ? header.offsetHeight : 0) + 80;
		let currentId = sections[0].id;

		sections.forEach(function (section) {
			if (window.scrollY >= section.offsetTop - scrollOffset) {
				currentId = section.id;
			}
		});

		const topMenuLinks = document.querySelectorAll('.main-navigation .menu a[href*="#"]');
		topMenuLinks.forEach(function (menuLink) {
			const href = menuLink.getAttribute('href') || '';
			const hashIndex = href.indexOf('#');
			const id = hashIndex > -1 ? href.slice(hashIndex + 1) : '';
			menuLink.classList.toggle('is-active', id === currentId);
		});
	}

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

	const animatableElements = document.querySelectorAll('.card, .post-card, .section h2, .section h3, .btn, .highlight-box, .trust-item, .logo-wall span, .testimonial-card');
	animatableElements.forEach(function (element) {
		if (!element.classList.contains('in-viewport')) {
			observer.observe(element);
		}
	});

	const heroSection = document.querySelector('.hero');
	if (heroSection) {
		window.requestAnimationFrame(function () {
			window.setTimeout(function () {
				heroSection.classList.add('is-ready');
			}, 60);
		});
	}

	window.addEventListener('scroll', function () {
		if (header && window.scrollY > 10) {
			header.classList.add('scrolled');
		} else if (header) {
			header.classList.remove('scrolled');
		}

		setActiveMenuLink();
	});

	if (heroSection) {
		window.addEventListener('scroll', function () {
			const scrolled = window.scrollY;
			heroSection.style.backgroundPosition = '0 ' + (scrolled * 0.25) + 'px';
		});
	}

	setActiveMenuLink();
})();
