// (function ($, Drupal) {
//   Drupal.behaviors.vimeoOwlInit = {
//     attach: function (context, settings) {
//       $('.slider__owl', context).once('vimeoOwlInit').each(function () {
//         $(this).owlCarousel({
//           loop: true,
//           margin: 20,
//           autoplay: true,
//           autoplayTimeout: 4000,
//           smartSpeed: 800,
//           dots: true,
//           nav: false,
//           responsive: {
//             0: { items: 1 },
//             768: { items: 2 },
//             992: { items: 3 },
//             1200: { items: 4 },
//           },
//         });
//       });
//     },
//   };
// })(jQuery, Drupal);
jQuery(document).ready(function($) {
    var iframe = $('#vimeo-hero')[0];
    if (iframe) {
        var player = new Vimeo.Player(iframe);

        // Wait 3 seconds after page load
        setTimeout(function() {
            player.setVolume(1); // Full volume
            player.play().catch(function(error) {
                // Autoplay with sound may be blocked; fallback: mute and play
                console.log('Autoplay with sound blocked. Trying muted autoplay.');
                player.setVolume(0).play();
            });
        }, 3000);
    }
});
