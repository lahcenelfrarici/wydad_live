jQuery(document).ready(function ($) {
   $('.slider__owl').owlCarousel({
    loop: false,
    margin: 15,
    nav: true,
    dots: false,
    navText: [
      '', // left (hidden)
      `<svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
         <path d="M0 20C0 8.95431 8.95431 0 20 0C31.0457 0 40 8.95431 40 20C40 31.0457 31.0457 40 20 40C8.95431 40 0 31.0457 0 20Z" fill="black" fill-opacity="0.7"/>
         <path d="M17 26L23 20L17 14" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
       </svg>`
    ],
    responsive: {
      0: { items: 1 },
      576: { items: 2 },
      768: { items: 3 },
      992: { items: 6 }
    }
  });
  // Find all .wrapper_img elements that do not contain an <img> tag
  $('.wrapper_img').each(function () {
    if ($(this).find('img').length === 0) {
      $(this).remove(); // Remove the empty .wrapper_img element
    }
  });

  function toggleDropdownAttribute() {
    var $dropdownLink = $('.nav-item.dropdown .nav-link');

    if ($(window).width() >= 992) { // For desktop view (width >= 992px)
      $('.dropdown-menu a').removeAttr('data-bs-toggle');
       $dropdownLink.removeAttr('data-bs-toggle'); // Remove the dropdown toggle attribute
    } else {
      $dropdownLink.attr('data-bs-toggle', 'dropdown'); // Add it back for mobile
        $('header.header-inside .container ul ul a').removeAttr('data-bs-toggle');
    }
  }

  // Call the function on page load
  toggleDropdownAttribute();

  // Call the function whenever the window is resized
  $(window).resize(function () {
    toggleDropdownAttribute();
  });
});

(function ($) {
  //
  // Function to check screen size and modify the attribute

  //
  // Find all .wrapper_img elements that do not contain an <img> tag
  // $('.wrapper_img').each(function () {
  //   if ($(this).find('img').length === 0) {
  //     $(this).remove(); // Remove the empty .wrapper_img element
  //   }
  // });
  //
  $('.galerie-de-projets').each(function () {
    var $section = $(this);

    // Only proceed if there is no .container inside already
    if ($section.find('.container').length === 0) {
      // Create new container
      var $container = $('<div class="container"></div>');

      // Move all .wrapper_img elements into the container
      $section.find('.wrapper_img').appendTo($container);

      // Insert the container right after the .title--sc block
      $section.find('.title--sc').after($container);
    }
  });



  var currentPath = window.location.pathname;

  $('.button-row a').each(function () {
    var linkPath = $(this).attr('href');

    if (linkPath === currentPath) {
      $(this).addClass('active');
    }
  });
  // Get the current path
  var path = window.location.pathname;

  // Normalize the path (remove trailing slash)
  if (path.endsWith('/')) {
    path = path.slice(0, -1);
  }

  // Check if path is home (empty, /fr, or /en)
  if (path === '' || path === '/fr' || path === '/en') {
    // Remove active from other links
    $('.navbar-expand-lg .navbar-nav .nav-link').removeClass('active');

    // Add active to the first menu item
    $('.navbar-expand-lg .navbar-nav .nav-item:first-child .nav-link').addClass('active');
  }
  // $(document).on('click', '.job-card .btn', function (e) {
  //   e.preventDefault(); // prevent page reload
  //   var jobTitle = $(this).closest('.job-card').find('.job-title').text().trim();
  //   $('#edit-titre-hidden').val(jobTitle);
  //   // $('#jobApplyModal').modal('show'); // show Bootstrap modal
  // });

  $('.job-card .btn').on('click', function (e) {
    e.preventDefault(); // Prevent the default anchor behavior
    var jobTitle = $(this).closest('.job-card').find('h5').text().trim();
    $('#edit-titre-hidden').val(jobTitle);
  });
  if ($('.banner_bread').length) {
    // Si l'élément existe, ajouter la classe 'regle_header' à la balise <header>
    $('.header-inside').addClass('regle_header');
  }
  // Trigger modal when "Postuler" button is clicked
  $('a.btn.btn-light.btn-sm').on('click', function (e) {
    e.preventDefault(); // Prevent the default anchor behavior
    $('#modal___carrire').modal('show'); // Show the modal
  });
  // Simulate loading progress
  function simulateLoading() {
    $(".preloader .progress").animate({
      width: "100%"
    }, 2500);

    // Hide preloader and show content after delay
    setTimeout(function () {
      $(".preloader").fadeOut(800);
      $(".content").addClass("visible");
    }, 3000);
  }

  // Start the loading animation
  simulateLoading();

  // Handle reload button click
  $("#reload-button").click(function () {
    $(".preloader .progress").css("width", "0");
    $(".content").removeClass("visible");
    $(".preloader").fadeIn(400);
    simulateLoading();
  });

  // Fallback in case of issues
  setTimeout(function () {
    if ($(".preloader").is(":visible")) {
      $(".preloader").fadeOut(500);
      $(".content").addClass("visible");
    }
  }, 5000);

  $('.notre-histoire .owl-carousel').owlCarousel({
    loop: true,
    margin: 25,
    nav: true,
    navText: [
      '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="34" viewBox="0 0 20 34" fill="none"><path d="M17.4479 2.58854L3.28125 16.7552L17.4479 30.9219" stroke="#5D0000" stroke-width="5" stroke-linecap="round" stroke-linejoin="round"/></svg>',
      '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="34" viewBox="0 0 20 34" fill="none"><path d="M2.55599 2.58854L16.7227 16.7552L2.55599 30.9219" stroke="#5D0000" stroke-width="5" stroke-linecap="round" stroke-linejoin="round"/></svg>'
    ],
    dots: false,
    autoplay: false,
    center: true,
    autoplayTimeout: 5000,
    autoplayHoverPause: true,
    responsive: {
      0: {
        items: 1,
        center: true,
      },
      768: {
        items: 1,
        center: true,
      },
      1200: {
        items: 3
      }
    }
  });

  $('.section--5 .owl-carousel').owlCarousel({
    loop: true,
    margin: 30,
    nav: false,
    dots: false,
    autoplay: true,
    autoplayTimeout: 4000,
    autoplayHoverPause: true,
    responsive: {
      0: {
        items: 1
      },
      768: {
        items: 2
      },
      992: {
        items: 5
      }
    }
  });

  // Function to check if element is in viewport
  function isInViewport(element) {
    const rect = element.getBoundingClientRect();
    return (
      rect.top >= 0 &&
      rect.left >= 0 &&
      rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
      rect.right <= (window.innerWidth || document.documentElement.clientWidth)
    );
  }

  // Counter animation function
  function animateCounter() {
    $('.counter-value').each(function () {
      if (!$(this).hasClass('animated') && isInViewport(this)) {
        $(this).addClass('animated');

        const $this = $(this);
        const target = parseInt($this.data('target'));
        const duration = 2000; // Animation duration in milliseconds
        const steps = 60; // Number of steps
        const increment = target / steps;
        let current = 0;

        const timer = setInterval(() => {
          current += increment;
          if (current >= target) {
            $this.text(target + '+');
            clearInterval(timer);
          } else {
            $this.text(Math.floor(current) + '+');
          }
        }, duration / steps);
      }
    });
  }

  // Run on page load and scroll
  animateCounter();
  $(window).scroll(animateCounter);
  // $('.section--2-modal #videoModal').on('hidden.bs.modal', function () {
  //   var $iframe = $(this).find('iframe');
  //   $iframe.attr('src', $iframe.attr('src')); // reload iframe to stop video
  // });
  // When modal opens → play video
  $('#videoModal').on('shown.bs.modal', function () {
    $('#videoPlayer')[0].play();
  });

  // When modal closes → pause and reset video
  $('#videoModal').on('hidden.bs.modal', function () {
    var video = $('#videoPlayer')[0];
    video.pause();
    video.currentTime = 0; // reset to start
  });

  $(window).scroll(function () {
    if ($(window).scrollTop() > 0) {
      $('.header-inside').addClass('scrolled');
    } else {
      $('.header-inside').removeClass('scrolled');
    }
  });
  // Initialize Owl Carousel with ID targeting
  if ($("#slider--animate").length) {
    $("#slider--animate").owlCarousel({
      items: 1,
      loop: true,
      autoplay: true,
      autoplayTimeout: 6000,
      autoplayHoverPause: true,
      smartSpeed: 1000,
      nav: false,
      dots: true,
      animateOut: 'fadeOut',
      onInitialized: startAnimation,
      onTranslate: resetAnimation,
      onTranslated: startAnimation
    });
  }

  // Start animation for active slide
  function startAnimation(event) {
    // Reset all slide-titles first (in case previous had animation)
    $(".slide-title").removeClass("typewriter");

    // Select active slide
    var activeSlide = $('#slider--animate .owl-item.active .slide-title');

    // Reset opacity & transform to trigger CSS transition
    activeSlide.css({
      'opacity': '1',
      'transform': 'translateY(0)'
    });

    // Force reflow to restart animation
    void activeSlide[0].offsetWidth;

    // Add animation class
    activeSlide.addClass("typewriter");
  }

  function resetAnimation(event) {
    // Reset styles & remove animation class
    $(".slide-title").css({
      'opacity': '0',
      'transform': 'translateY(30px)'
    }).removeClass("typewriter");
  }


  // Header scroll effect


  // Style the background images
  $('.slide-bg').css({
    'position': 'absolute',
    'width': '100%',
    'height': '100%',
    'object-fit': 'cover',
    'z-index': '0'
  });

  //


})(jQuery);
// $(document).ready(function () {
//   $('#exampleModal').modal('show');
// });
