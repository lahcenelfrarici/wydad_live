$(document).ready(function () {


    $(".single-image-carousel").owlCarousel({
      items: 1, // Une seule image visible
      loop: true, // Boucle infinie
      nav: true, // Activer les boutons de navigation
      dots: false, // Désactiver les puces
      navText: ["&#8249;", "&#8250;"], // Utilisation de symboles "‹" et "›"
    });

  // Lorsqu'on clique sur .cover
  $('.cover .play-icon').on('click', function () {
    const cover = $(this).closest('.cover'); // Récupère l'élément parent `.cover`
    const video = cover.find('video'); // Trouve la vidéo associée

    // Modifie les styles de la vidéo
    video.css({
        'z-index': 1,
        'opacity': 1
    });

    // Lance la vidéo si elle est en pause
    if (video[0].paused) {
        video.trigger('play');
    }

    // Masque l'icône "play"
    $(this).hide();
});
$('.cover-orange .play-icon').on('click', function () {
  const cover = $(this).closest('.cover-orange'); // Récupère l'élément parent `.cover`
  const video = cover.find('video'); // Trouve la vidéo associée

  // Modifie les styles de la vidéo
  video.css({
      'z-index': 1,
      'opacity': 1
  });

  // Lance la vidéo si elle est en pause
  if (video[0].paused) {
      video.trigger('play');
  }

  // Masque l'icône "play"
  $(this).hide();
});

  // Appliquer une image d'arrière-plan à un élément avec la classe .cover
  $('.cover').css('background-image', 'url("/themes/custom/desktech/Desktech/assets/images/pwc1.png")');
  // Appliquer une image d'arrière-plan à un élément avec la classe .cover
  $('.cover-orange').css('background-image', 'url("/themes/custom/desktech/Desktech/assets/images/orange1.png")');
  // Appliquer une image d'arrière-plan à un élément avec la classe .cover
  $('.play-icon').css('background-image', 'url("/themes/custom/desktech/Desktech/assets/images/iconoir_play-solid.png")');



$('.playicon').on('click', function () {
  // Ajoute la classe "play-icon-hiden" pour masquer l'icône
  $(this).addClass('play-icon-hiden');

  // Optionnel : Si tu veux lancer une action comme lire une vidéo, ajoute ton code ici
  // Par exemple :
  // const video = $(this).siblings('video')[0];
  // video.play();
});

});
