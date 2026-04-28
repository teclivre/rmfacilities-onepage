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
})();
