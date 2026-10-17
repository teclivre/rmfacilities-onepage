(function () {
	document.documentElement.classList.add('has-js');

	const header = document.querySelector('.site-header');
	const toggle = document.querySelector('.menu-toggle');
	const nav = document.querySelector('.main-navigation');
	const footer = document.querySelector('.site-footer');
	const contactForm = document.querySelector('.rmf-contact-form');

	if (contactForm) {
		const startedField = contactForm.querySelector('[name="rmf_form_started"]');
		if (startedField) {
			startedField.value = String(Math.floor(Date.now() / 1000));
		}
	}

	if (toggle && nav) {
		toggle.addEventListener('click', function () {
			const isOpen = nav.classList.toggle('is-open');
			toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
			toggle.setAttribute('aria-label', isOpen ? 'Fechar menu' : 'Abrir menu');
		});

		document.addEventListener('keydown', function (event) {
			if (event.key === 'Escape' && nav.classList.contains('is-open')) {
				nav.classList.remove('is-open');
				toggle.setAttribute('aria-expanded', 'false');
				toggle.setAttribute('aria-label', 'Abrir menu');
				toggle.focus();
			}
		});

		document.addEventListener('click', function (event) {
			if (header && !header.contains(event.target) && nav.classList.contains('is-open')) {
				nav.classList.remove('is-open');
				toggle.setAttribute('aria-expanded', 'false');
				toggle.setAttribute('aria-label', 'Abrir menu');
			}
		});

		nav.addEventListener('click', function (event) {
			if (event.target.closest('a')) {
				nav.classList.remove('is-open');
				toggle.setAttribute('aria-expanded', 'false');
				toggle.setAttribute('aria-label', 'Abrir menu');
			}
		});
	}

	const menuLinks = document.querySelectorAll('.main-navigation a[href*="#"], .footer-menu a[href*="#"]');

	menuLinks.forEach(function (link) {
		link.addEventListener('click', function (event) {
			const href = link.getAttribute('href');
			if (!href) {
				return;
			}

			const destination = new URL(href, window.location.href);
			if (!destination.hash || destination.origin !== window.location.origin || destination.pathname !== window.location.pathname) {
				return;
			}

			const targetId = decodeURIComponent(destination.hash.slice(1));
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
				behavior: window.matchMedia('(prefers-reduced-motion: reduce)').matches ? 'auto' : 'smooth'
			});

			if (nav) {
				nav.classList.remove('is-open');
			}
			if (toggle) {
				toggle.setAttribute('aria-expanded', 'false');
			}
		});
	});

	const sectionIds = ['inicio', 'sobre', 'como-trabalhamos', 'porque', 'servicos', 'contato', 'faq', 'blog'];
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
			if (id === currentId) {
				menuLink.setAttribute('aria-current', 'location');
			} else {
				menuLink.removeAttribute('aria-current');
			}
		});
	}

	const observerOptions = {
		threshold: 0.1,
		rootMargin: '0px 0px -50px 0px'
	};

	const animatableElements = document.querySelectorAll('.card, .post-card, .section h2, .section h3, .btn, .highlight-box, .trust-item, .logo-wall span, .testimonial-card, .why-item, .faq-item');
	if ('IntersectionObserver' in window) {
		const observer = new IntersectionObserver(function (entries) {
			entries.forEach(function (entry) {
				if (entry.isIntersecting) {
					entry.target.classList.add('in-viewport');
					observer.unobserve(entry.target);
				}
			});
		}, observerOptions);

		animatableElements.forEach(function (element) {
			if (!element.classList.contains('in-viewport')) {
				observer.observe(element);
			}
		});
	} else {
		animatableElements.forEach(function (element) {
			element.classList.add('in-viewport');
		});
	}

	const heroSection = document.querySelector('.hero');
	if (heroSection) {
		window.requestAnimationFrame(function () {
			window.setTimeout(function () {
				heroSection.classList.add('is-ready');
			}, 60);
		});
	}

	if (header && footer && 'IntersectionObserver' in window) {
		const footerObserver = new IntersectionObserver(function (entries) {
			header.classList.toggle('is-footer-visible', entries[0].isIntersecting);
		});
		footerObserver.observe(footer);
	}

	window.addEventListener('scroll', function () {
		if (header && window.scrollY > 10) {
			header.classList.add('scrolled');
		} else if (header) {
			header.classList.remove('scrolled');
		}

		setActiveMenuLink();
	});

	setActiveMenuLink();

	function localizeCookieSettings() {
		const modal = document.getElementById('cliSettingsPopup');
		if (!modal) {
			return;
		}

		const translations = [
			['Privacy Overview', 'Visão geral de privacidade'],
			[
				'This website uses cookies to improve your experience while you navigate through the website.',
				'Este site usa cookies para melhorar sua experiência durante a navegação. Os cookies classificados como necessários ficam armazenados no navegador, pois são essenciais para o funcionamento básico do site.'
			],
			['Necessary', 'Necessários'],
			[
				'Necessary cookies are absolutely essential for the website to function properly.',
				'Os cookies necessários são essenciais para que o site funcione corretamente. Esta categoria inclui apenas cookies que garantem funcionalidades básicas e recursos de segurança. Esses cookies não armazenam informações pessoais.'
			],
			['Necessary', 'Necessários'],
			['Non-necessary', 'Opcionais'],
			[
				'Any cookies that may not be particularly necessary for the website to function',
				'Cookies opcionais podem ser usados para coletar dados de uso por meio de análises, anúncios ou conteúdos incorporados. Eles só são ativados após o seu consentimento.'
			],
			['SALVAR E ACEITAR', 'Salvar preferências']
		];
		const walker = document.createTreeWalker(modal, NodeFilter.SHOW_TEXT);
		let node;

		while ((node = walker.nextNode())) {
			const original = node.nodeValue.trim();
			const translation = translations.find(function (entry) {
				return original === entry[0] || original.startsWith(entry[0]);
			});

			if (translation) {
				node.nodeValue = node.nodeValue.replace(original, translation[1]);
			}
		}
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', localizeCookieSettings);
	} else {
		localizeCookieSettings();
	}

	// Accordion FAQ
	document.querySelectorAll('.faq-question').forEach(function (button) {
		button.addEventListener('click', function () {
			const item = button.closest('.faq-item');
			const isOpen = item.classList.contains('open');
			document.querySelectorAll('.faq-item.open').forEach(function (openItem) {
				openItem.classList.remove('open');
				const openButton = openItem.querySelector('.faq-question');
				const answer = openItem.querySelector('.faq-answer');
				if (openButton && answer) {
					openButton.setAttribute('aria-expanded', 'false');
					answer.hidden = true;
				}
			});
			if (!isOpen) {
				item.classList.add('open');
				button.setAttribute('aria-expanded', 'true');
				const answer = document.getElementById(button.getAttribute('aria-controls'));
				if (answer) {
					answer.hidden = false;
				}
			}
		});
	});
})();
