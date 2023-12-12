<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container">
  <div class="row">
    <div class="col">

      <h1 class="mt-2">Recommendation Drinks</h1>
      <ul>
        <li class="fw-bold">Es Kopi Susu</li>
        <li class="fw-bold">Es Matcha</li>
      </ul>

      <h1 class="mt-2">List of Drinks</h1>
      <table class="table">
        <thead>
          <tr>
            <th scope="col">No</th>
            <th scope="col">Gambar Produk</th>
            <th scope="col">Nama Produk</th>
            <th scope="col">Harga</th>
            <th scope="col">Quantity</th>
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
                <a href="" class="btn btn-danger">-</a>
                <a href="" class="btn btn-success">+</a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<?= $this->endSection(); ?>