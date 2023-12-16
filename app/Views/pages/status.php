<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container">
  <div class="row">
    <div class="col">
      <div class="container mt-5 mb-4">
        <h1><strong>Your Orders</strong></h1>
        <div class="container mt-5">
          <table class="table">
            <thead>
              <tr>
                <th scope="col">ID</th>
                <th scope="col">Last Updated</th>
                <th scope="col">Address</th>
                <th scope="col">Paid Amount</th>
                <th scope="col">Status</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($order as $o) : ?>
                <tr>
                  <td><?= $o['id']; ?></td>
                  <td><?= $o['updated_at']; ?></td>
                  <td><?= $o['address']; ?></td>
                  <td>Rp.<?= $o['total_price']; ?></td>
                  <td><?= $o['status']; ?></span> </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection(); ?>