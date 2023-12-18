<style>
  .custom-navbar {
    background-color: #3498db;
    /* Warna biru contoh */
  }

  .custom-navbar .navbar-brand,
  .custom-navbar .navbar-nav .nav-link {
    color: #ffffff;
    /* Warna teks putih contoh */
  }

  .custom-navbar .navbar-nav .nav-link:hover {
    color: #DDDD;
    /* Warna teks putih pada hover contoh */
  }
</style>

<nav class="navbar navbar-expand-lg custom-navbar">
  <div class="container">
    <a class="navbar-brand mx-2 font-weight-bold" href="/">Drink Store</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
      <div class="navbar-nav">
        <a class="nav-link" href="/status">Status</a>
        <a class="nav-link" href="/login">Login</a>
        <a class="nav-link" href="/checkout">Checkout</a>
      </div>
    </div>
  </div>
</nav>

<!-- Rekomen Buat nunjukkin login pas belom in, logout pas loggedin -->
<!-- <nav class="navbar navbar-expand-lg custom-navbar">
  <div class="container">
    <a class="navbar-brand mx-2" href="/">Drink Store</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
      <div class="navbar-nav ml-auto">
        Dynamic login/logout button will be added here using JavaScript
      </div>
    </div>
  </div>
</nav>

<script>
  // Assume isLoggedIn is a variable indicating the user's login status
  const isLoggedIn = false; // Set this to true if the user is logged in

  // Function to update the navbar based on login status
  function updateNavbar() {
    const navbarNav = document.querySelector(".navbar-nav.ml-auto");

    // Clear existing content
    navbarNav.innerHTML = '';

    // Add appropriate button based on login status
    if (isLoggedIn) {
      navbarNav.innerHTML += '<a class="nav-link" href="/logout">Logout</a>';
    } else {
      navbarNav.innerHTML += '<a class="nav-link" href="/login">Login</a>';
    }
  }

  // Initial update when the page loads
  updateNavbar();
</script> -->
