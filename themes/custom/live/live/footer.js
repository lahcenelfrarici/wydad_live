document.addEventListener('DOMContentLoaded', function () {
  // Create header HTML content
  const footerContent = `
  <footer class="footer---btm bg-dark-red text-white pt-5 pb-3">
    <div class="container">
      <div class="row">
        <!-- Logo and slogan -->
        <div class="col-md-3 mb-4">
          <a class="navbar-brand" href="#"> <img class="two--sc--img mb-3" src="/themes/custom/live/live/assets/images/logo.png"></a>



          <p>Créer l'excellence architecturale à travers le Maroc et au-delà.</p>
        </div>

        <!-- Quick links -->
        <div class="col-md-3 mb-4">
          <h6 class="mb-3">Liens rapides</h6>
          <ul class="list-unstyled">
            <li><a href="#" class="footer-link">À propos</a></li>
            <li><a href="#" class="footer-link">Projets</a></li>
            <li><a href="#" class="footer-link">Carrières</a></li>
            <li><a href="#" class="footer-link">Contact</a></li>
          </ul>
        </div>

        <!-- Contact information -->
        <div class="col-md-3 mb-4 localed-icon">
          <h6 class="mb-3">Informations de contact</h6>
          <p><i class="fa-solid fa-location-dot"></i>Casablanca, Morocco</p>
          <p><i class="fa-solid fa-phone"></i>+212 522 22 24 45</p>
          <p><i class="fa-solid fa-envelope"></i>secretariat@agencelive.com</p>
        </div>

        <!-- Social links -->
        <div class="col-md-3 mb-4">
          <h6 class="mb-3">Suivez-nous</h6>
          <a href="#" class="footer-social"><i class="fa-brands fa-linkedin"></i></a>
          <a href="#" class="footer-social"><i class="fa-brands fa-instagram"></i></a>
          <a href="#" class="footer-social"><i class="fa-brands fa-facebook"></i></a>
        </div>
      </div>

      <hr class="border-light">

      <div class="text-center">
        <small>© 2025 Agence live. All rights reserved.</small>
      </div>
    </div>
  </footer>
  `;

  // Insert the header at the beginning of the body
  document.body.insertAdjacentHTML('afterbegin', footerContent);
});
