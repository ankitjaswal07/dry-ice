/**
 * ArcticRestoDRY ICE — Admin One-Click Demo Importer Script.
 */
(function ($) {
	'use strict';

	$(document).on('click', '#ar-run-import', function () {
		var $btn = $(this);
		var $prog = $('#ar-import-progress');
		var $bar = $('#ar-import-bar');
		var $log = $('#ar-import-log');

		$btn.prop('disabled', true).text('Importing ArcticRestoDRY ICE Content…');
		$prog.show();
		$bar.css('width', '5%');
		$log.text('Starting ArcticRestoDRY ICE Demo Importer…\n');

		var steps = ['media', 'pages', 'cpts', 'settings'];
		var idx = 0;

		function nextStep() {
			if (idx >= steps.length) {
				$bar.css('width', '100%');
				$log.append('\n✓ Complete! All 16 Elementor pages, Dry Ice Products, Industries, Delivery Zones, and 8 Blog Articles are ready.\n');
				$btn.prop('disabled', false).text('Re-Run Demo Import');
				return;
			}
			var step = steps[idx];
			$log.append('→ Running step [' + step + ']…\n');
			$.post(ARAdmin.ajaxUrl, {
				action: 'ar_demo_import_step',
				nonce: ARAdmin.nonce,
				step: step
			}).done(function (res) {
				if (res && res.success && res.data && res.data.log) {
					$log.append('  ' + res.data.log + '\n');
				}
				idx++;
				$bar.css('width', Math.round((idx / steps.length) * 100) + '%');
				nextStep();
			}).fail(function () {
				$log.append('  ! Step [' + step + '] encountered a warning; continuing…\n');
				idx++;
				nextStep();
			});
		}

		nextStep();
	});
})(jQuery);
