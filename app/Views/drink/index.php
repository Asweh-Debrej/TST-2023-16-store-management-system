<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container">
  <div class="row">
    <div class="col">

      <h1 class="mt-2">Featured Drinks</h1>
      <div class="card-deck mb-4">
        <!-- Recommendation 1: Es Kopi Susu -->
        <div class="card">
          <img src="/img/eskopisusu.png" class="card-img-top" alt="Es Kopi Susu" style="max-width: 200px;">
          <div class="card-body">
            <h5 class="card-title">Es Kopi Susu</h5>
            <p class="card-text">Creamy and delicious coffee with milk.</p>
          </div>
        </div>

        <!-- Recommendation 2: Es Matcha -->
        <div class="card">
          <img src="/img/esmatcha.png" class="card-img-top" alt="Es Matcha" style="max-width: 200px;">
          <div class="card-body">
            <h5 class="card-title">Es Matcha</h5>
            <p class="card`-text">Refreshing green tea matcha served iced.</p>
          </div>
        </div>
      </div>

      <h1 class="mt-2">List of Drinks</h1>
      <a href="/cart/checkout" class="btn btn-primary float-right">Checkout</a>
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
                <?php if (in_array($d['id'], session('cart') ?: [])) : ?>
                  <span class="text-success">Added to Cart</span>
                <?php else : ?>
                  <a href="#" class="btn btn-primary add-to-cart" data-id="<?= $d['id']; ?>">Add to Cart</a>
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
<script>
  $(document).ready(function() {
    $(".add-to-cart").click(function(e) {
      e.preventDefault();

      // Dapatkan ID produk dari atribut data
      var productId = $(this).data('id');

      // Kirim ID produk ke server atau simpan dalam sesi/cookie
      // Contoh menggunakan AJAX untuk mengirim ke server
      $.ajax({
        type: "POST",
        url: "/cart/add", // Ganti dengan URL yang sesuai
        data: {
          id: productId
        },
        success: function(response) {
          // Handle respons jika diperlukan
          alert('Product added to cart! Product ID: ' + response.productId);

          // Ubah tombol menjadi "Added to Cart" setelah ditambahkan
          $(".add-to-cart[data-id='" + productId + "']").replaceWith('<span class="text-success">Added to Cart</span>');
        }
      });
    });
  });
</script>

<?= $this->endSection(); ?>