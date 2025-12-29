<footer class="bg-light pt-5">
  <div class="container">
    <div class="row">
      <!-- Column 1: Logo -->
      <div class="col-12 col-md-3 mb-4">
        <img src="https://i.ibb.co/dHx2ZR3/velstore.png" alt="Velstore Logo" class="img-fluid" style="max-width: 100px;">
      </div>

      <!-- Column 2: Account -->
      <div class="col-6 col-md-3 mb-4">
        <h5> {{ __('store.footer.account') }}</h5>
        <ul class="list-unstyled">
          <li class="mb-2"><a href="#" class="text-muted text-decoration-none">{{ __('store.footer.my_account') }}</a></li>
          <li class="mb-2"><a href="#" class="text-muted text-decoration-none">{{ __('store.footer.wishlist') }}</a></li>
        </ul>
      </div>

      <!-- Column 3: Other Pages -->
      <div class="col-6 col-md-3 mb-4">
        <h5>{{ __('store.footer.pages') }}</h5>
        <ul class="list-unstyled">
          <li class="mb-2"><a href="#" class="text-muted text-decoration-none">{{ __('store.footer.privacy_policy') }}</a></li>
          <li class="mb-2"><a href="#" class="text-muted text-decoration-none">{{ __('store.footer.terms_of_service') }}</a></li>
        </ul>
      </div>

      <!-- Column 4: Social Links -->
    <div class="col-12 col-md-3 mb-4">
    <h5>{{ __('store.footer.follow_us') }}</h5>
    <div class="d-flex gap-3">
        <a href="#" class="text-dark fs-5"><i class="fab fa-facebook-f"></i></a>
        <a href="#" class="text-dark fs-5"><i class="fab fa-twitter"></i></a>
        <a href="#" class="text-dark fs-5"><i class="fab fa-instagram"></i></a>
        <a href="#" class="text-dark fs-5"><i class="fab fa-linkedin-in"></i></a>
    </div>
    </div>

    </div>
  </div>

  <!-- Footer Bottom Strip -->
  <div class="bg-black text-white py-3 mt-4">
    <div class="container">
      <div class="row">
        <div class="col-12 d-flex justify-content-between flex-wrap small">
          <span>{{ __('store.footer.copyright') }}</span>
          <span>{{ __('store.footer.powered_by') }}</span>
        </div>
      </div>
    </div>
  </div>
</footer>
