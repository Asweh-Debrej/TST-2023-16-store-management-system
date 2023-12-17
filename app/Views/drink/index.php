<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container">
  <div class="row">
    <div class="col">

      <h1 class="mt-2 text-center">Featured Drinks</h1>

      <!-- Carousel -->
      <div class="mx-auto" style="max-width: 400px;">
        <div id="drinkCarousel" class="carousel slide" data-ride="carousel">
          <div class="carousel-inner">
            <!-- Recommendation 1: Es Kopi Susu -->
            <div class="carousel-item active">
              <h5 class="text-center">Es Kopi Susu</h5>
              <p class="text-center">Creamy and delicious coffee with milk.</p>
              <img src="/img/eskopisusu.png" class="d-block w-100" alt="Es Kopi Susu">
              <div class="carousel-caption d-none d-md-block text-dark">
              </div>
            </div>

            <!-- Recommendation 2: Es Matcha -->
            <div class="carousel-item">
              <h5 class="text-center">Es Matcha</h5>
              <p class="text-center">Refreshing green tea matcha served iced.</p>
              <img src="/img/esmatcha.png" class="d-block w-100" alt="Es Matcha">
              <div class="carousel-caption d-none d-md-block text-dark">
              </div>
            </div>

            <!-- Add more carousel items for other recommendations -->
          </div>
          <a class="carousel-control-prev" href="#drinkCarousel" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only text-dark">Next</span>
          </a>
          <a class="carousel-control-next" href="#drinkCarousel" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only text-dark">Previous</span>
          </a>
        </div>
      </div>

      <h1 class="mt-4">List of Drinks</h1>
      <a href="/checkout" class="btn btn-primary float-right" id="checkoutBtn">Checkout</a>
      <table class="table">
        <thead>
          <tr>
            <th scope="col">No</th>
            <th scope="col">Gambar Produk</th>
            <th scope="col">Nama Produk</th>
            <th scope="col">Harga</th>
            <th scope="col">Buy</th>
          </tr>
        </thead>
        <tbody>
          <?php $i = 1; ?>
          <?php foreach ($drink as $d) : ?>
            <tr>
              <th scope="row"><?= $i++; ?></th>
              <td><img src="/img/<?= $d['gambar']; ?>" alt="" class="product"></td>
              <td><?= $d['produk']; ?></td>
              <td>Rp.<?= $d['harga']; ?></td>
              <td>
                <?php
                // Generate a unique session key for each product
                $sessionKey = 'cart_' . $d['id'];

                if (session()->has($sessionKey)) : ?>
                  <span class="text-success">Added to Checkout</span>
                <?php else : ?>
                  <a href="#" class="btn btn-primary add-to-cart" data-id="<?= $d['id']; ?>">Add to Checkout</a>
                <?php endif; ?>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Script JavaScript -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
  $(document).ready(function() {
    // Initialize the carousel
    $('#drinkCarousel').carousel();

    $(".add-to-cart").click(function(e) {
      e.preventDefault();
      var productId = $(this).data('id');
      $.ajax({
        type: "POST",
        url: "/drink/addToCheckout",
        data: {
          id: productId
        },
        success: function(response) {
          alert('Product added to checkout! Product ID: ' + response.productId);
          $("[data-id='" + productId + "']").replaceWith('<span class="text-success">Added to Checkout</span>');
        },
        error: function() {
          alert('Error adding product to checkout.');
        }
      });
    });
  });
</script>

<?= $this->endSection(); ?>