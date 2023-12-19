<style>
  .custom-navbar {
    background-color: #247DFF;
    /* Warna biru contoh */
  }

  .not-bold {
    font-weight: normal;
  }

  .custom-navbar .navbar-brand {
    color: #ffffff;
    /* Warna teks putih contoh */
    font-weight: bold;
    /* Make the text bold */
  }

  .custom-navbar .navbar-nav .nav-link,
  .custom-navbar .navbar-nav .login-link {
    color: #ffffff;
    /* Warna teks putih contoh */
  }

  .custom-navbar .navbar-nav .nav-link:hover,
  .custom-navbar .navbar-nav .login-link:hover {
    color: #DDDD;
    /* Warna teks putih pada hover contoh */
  }
</style>


<nav class="navbar navbar-expand-lg custom-navbar">
  <div class="container">
    <a class="navbar-brand" href="/">
      <i class="fas fa-truck delivery-icon"></i> Janji Jiwa
    </a>
    <a class="navbar-brand" href="/">
      <span class="not-bold">Buy Beverages</span>
    </a>
    <a class="navbar-brand" href="/status">
      <span class="not-bold">My Orders</span>
    </a>
    <a class="navbar-brand" href="/checkout">
      <span class="not-bold">Checkout</span>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navbarNavAltMarkup">
      <div class="navbar-nav">
        <?php if (auth()->loggedIn()) : ?>
          <a class="nav-link" href="/cart">
            <i class="fas fa-shopping-cart"></i> Cart
          </a>
          <a class="nav-link login-link" href="/logout">
            <i class="fas fa-sign-out-alt"></i> Logout
          </a>
        <?php else : ?>
          <a class="nav-link login-link" href="/register">
            <i class="fas fa-user-plus"></i> Register
          </a>
          <a class="nav-link login-link" href="/login">
            <i class="fas fa-sign-out-alt"></i> Login
          </a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</nav>
