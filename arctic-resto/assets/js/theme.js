/**
 * ArcticRestoDRY ICE — Front-End Interactive Behaviors.
 *
 * Handles mobile navigation drawer, conditional B2B quote/bulk form fields,
 * REST lead submission, sublimation buffer calculator, visual format comparison
 * slider, delivery coverage lookup, and technical advisor Q&A.
 *
 * @package ArcticResto
 * @version 2.0.0
 */
(function () {
	'use strict';

	var cfg = window.ArcticResto || {
		restUrl: '/wp-json/ar/v1/',
		nonce: ''
	};

	// 1. Mobile Navigation Drawer
	var burger = document.querySelector('[data-ar-burger]');
	var drawer = document.querySelector('[data-ar-drawer]');
	var closeBtn = document.querySelector('[data-ar-drawer-close]');

	function setDrawer(open) {
		if (!drawer || !burger) return;
		if (open) {
			drawer.removeAttribute('hidden');
			burger.setAttribute('aria-expanded', 'true');
			document.body.style.overflow = 'hidden';
		} else {
			drawer.setAttribute('hidden', '');
			burger.setAttribute('aria-expanded', 'false');
			document.body.style.overflow = '';
		}
	}

	if (burger && drawer) {
		burger.addEventListener('click', function () {
			var isOpen = !drawer.hasAttribute('hidden');
			setDrawer(!isOpen);
		});
		if (closeBtn) {
			closeBtn.addEventListener('click', function () { setDrawer(false); });
		}
		drawer.addEventListener('click', function (e) {
			if (e.target === drawer) setDrawer(false);
		});
		document.addEventListener('keydown', function (e) {
			if (e.key === 'Escape' && !drawer.hasAttribute('hidden')) {
				setDrawer(false);
			}
		});
	}

	// 2. Conditional Form Fields & REST Submission
	document.querySelectorAll('[data-ar-form]').forEach(function (form) {
		var freqSel = form.querySelector('[data-ar-cond-source="frequency"]');
		var recPanel = form.querySelector('[data-ar-cond-panel="recurring"]');

		if (freqSel && recPanel) {
			var syncFreq = function () {
				var val = freqSel.value || '';
				if (val.indexOf('One-Time') === -1) {
					recPanel.removeAttribute('hidden');
				} else {
					recPanel.setAttribute('hidden', '');
				}
			};
			freqSel.addEventListener('change', syncFreq);
			syncFreq();
		}

		form.addEventListener('submit', function (e) {
			e.preventDefault();
			var statusEl = form.querySelector('.ar-form__status');
			var submitBtn = form.querySelector('button[type="submit"]');

			if (!form.checkValidity()) {
				form.reportValidity();
				return;
			}

			var fd = new FormData(form);
			var payload = {};
			fd.forEach(function (v, k) { payload[k] = v; });

			if (submitBtn) submitBtn.disabled = true;
			if (statusEl) {
				statusEl.className = 'ar-form__status';
				statusEl.textContent = 'Submitting your dry ice inquiry…';
			}

			fetch(cfg.restUrl + 'lead', {
				method: 'POST',
				headers: {
					'Content-Type': 'application/json',
					'X-WP-Nonce': cfg.nonce || ''
				},
				body: JSON.stringify(payload)
			})
				.then(function (r) { return r.json(); })
				.then(function (data) {
					if (submitBtn) submitBtn.disabled = false;
					if (!statusEl) return;
					if (data && data.ok) {
						statusEl.className = 'ar-form__status is-ok';
						statusEl.textContent = data.message || 'Thank you — your dry ice inquiry has been received.';
						form.reset();
					} else {
						statusEl.className = 'ar-form__status is-err';
						statusEl.textContent = (data && data.message) ? data.message : 'Please check all required fields and try again.';
					}
				})
				.catch(function () {
					if (submitBtn) submitBtn.disabled = false;
					if (statusEl) {
						statusEl.className = 'ar-form__status is-err';
						statusEl.textContent = 'Network error while submitting form. Please verify your connection and try again.';
					}
				});
		});
	});

	// 3. Visual Format Comparison Slider (Pellets vs. Blocks)
	document.querySelectorAll('[data-ar-ba]').forEach(function (wrap) {
		var range = wrap.querySelector('[data-ar-ba-range]');
		var clip = wrap.querySelector('[data-ar-ba-clip]');
		if (!range || !clip) return;
		var update = function () {
			clip.style.width = range.value + '%';
		};
		range.addEventListener('input', update);
		update();
	});

	// 4. Dry Ice Sublimation & Buffer Weight Estimator
	document.querySelectorAll('[data-ar-sublimation-calc]').forEach(function (box) {
		var netInput = box.querySelector('[data-ar-calc-net]');
		var daysInput = box.querySelector('[data-ar-calc-days]');
		var rateSel = box.querySelector('[data-ar-calc-rate]');
		var netOut = box.querySelector('[data-ar-calc-net-out]');
		var daysOut = box.querySelector('[data-ar-calc-days-out]');
		var totalOut = box.querySelector('[data-ar-calc-total]');
		var bufOut = box.querySelector('[data-ar-calc-buffer]');

		function recalc() {
			var net = parseFloat(netInput ? netInput.value : 300) || 300;
			var days = parseInt(daysInput ? daysInput.value : 2, 10) || 2;
			var rate = parseFloat(rateSel ? rateSel.value : 0.08) || 0.08;
			if (netOut) netOut.textContent = String(net);
			if (daysOut) daysOut.textContent = String(days);

			var remainingFraction = Math.pow(1 - rate, days);
			var recommended = Math.ceil((net / remainingFraction) / 5) * 5;
			var buffer = Math.max(10, recommended - net);

			if (totalOut) totalOut.textContent = recommended.toLocaleString();
			if (bufOut) bufOut.textContent = buffer.toLocaleString() + ' lbs';
		}

		if (netInput) netInput.addEventListener('input', recalc);
		if (daysInput) daysInput.addEventListener('input', recalc);
		if (rateSel) rateSel.addEventListener('change', recalc);
		recalc();
	});

	// 5. Delivery & Supply Area Lookup
	document.querySelectorAll('[data-ar-terr-checker]').forEach(function (checker) {
		var form = checker.querySelector('[data-ar-terr-form]');
		var out = checker.querySelector('[data-ar-terr-result]');
		if (!form || !out) return;

		form.addEventListener('submit', function (e) {
			e.preventDefault();
			var input = form.querySelector('input[name="zip"]');
			var val = input ? input.value.trim() : '';
			if (!val) return;

			out.innerHTML = '<p>Checking configured supply zones for <strong>' + val.replace(/[<>&"]/g, '') + '</strong>…</p>';

			fetch(cfg.restUrl + 'territory-check?zip=' + encodeURIComponent(val))
				.then(function (r) { return r.json(); })
				.then(function (d) {
					var title = (d && d.title) ? d.title : 'Coverage Check';
					var msg = (d && d.message) ? d.message : '';
					var cta = (d && d.cta_url) ? d.cta_url : '#quote';
					out.innerHTML =
						'<div style="padding:14px;border-radius:10px;background:rgba(56,189,248,0.1);border:1px solid rgba(56,189,248,0.3);">' +
						'<strong style="display:block;color:#fff;margin-bottom:6px;">' + title + '</strong>' +
						'<p style="margin:0 0 10px;font-size:13.5px;">' + msg + '</p>' +
						'<a class="ar-btn ar-btn--primary ar-btn--sm" href="' + cta + '">Submit Location & Volume Inquiry →</a>' +
						'</div>';
				})
				.catch(function () {
					out.innerHTML = '<p>Please use the Delivery & Supply Area Inquiry form below to confirm coverage for your location.</p>';
				});
		});
	});

	// 6. Interactive Dry Ice Advisor Q&A
	document.querySelectorAll('[data-ar-advisor]').forEach(function (adv) {
		var form = adv.querySelector('[data-ar-advisor-form]');
		var input = form ? form.querySelector('input[name="prompt"]') : null;
		var out = adv.querySelector('[data-ar-advisor-out]');

		function ask(question) {
			if (!out || !question) return;
			out.innerHTML = '<p>Checking technical guidance…</p>';
			fetch(cfg.restUrl + 'ai-assist', {
				method: 'POST',
				headers: { 'Content-Type': 'application/json' },
				body: JSON.stringify({ prompt: question })
			})
				.then(function (r) { return r.json(); })
				.then(function (d) {
					out.innerHTML = '<p>' + ((d && d.response) ? d.response : '') + '</p>';
				});
		}

		adv.querySelectorAll('[data-ar-advisor-q]').forEach(function (chip) {
			chip.addEventListener('click', function () {
				var q = chip.getAttribute('data-ar-advisor-q') || '';
				if (input) input.value = q;
				ask(q);
			});
		});

		if (form) {
			form.addEventListener('submit', function (e) {
				e.preventDefault();
				if (input && input.value.trim()) {
					ask(input.value.trim());
				}
			});
		}
	});
})();
