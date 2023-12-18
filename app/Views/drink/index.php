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
            <div class="carousel-item active justify-content-center">
              <h5 class="text-center">Es Kopi Susu</h5>
              <p class="text-center">Creamy and delicious coffee with milk.</p>
              <img src="/img/eskopisusu.png" class="d-block" alt="Es Kopi Susu" style="max-height: 400px; min-height: 400px">
              <div class="carousel-caption d-none d-md-block text-dark">
              </div>
            </div>

            <!-- Recommendation 2: Es Matcha -->
            <div class="carousel-item justify-content-center">
              <h5 class="text-center">Es Matcha</h5>
              <p class="text-center">Refreshing green tea matcha served iced.</p>
              <img src="/img/esmatcha.png" class="d-block" alt="Es Matcha" style="max-height: 400px; min-height: 400px">
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
      <div class="container">

        <div class="row gap-1">
          <button href="/checkout" class="col-auto btn btn-primary float-right" id="checkoutBtn">Checkout</button>
          <form id="saveCartForm" action="<?= url_to('saveCart') ?>" method="post">
            <?php foreach ($drink as $d) : ?>
              <input type="hidden" name="amountsInput[<?= $d['id'] ?>]" id="amountsInput[<?= $d['id'] ?>]" value="1">
            <?php endforeach; ?>
            <button class="col-auto btn btn-success float-right mr-4" id="saveBtn" onclick="saveOrder()">Save</button>
          </form>
          <p class="col-auto text-danger" id="unsavedWarning" style="display:none">You have unsaved changes.</p>
        </div>
      </div>
      <table class="table">
        <thead>
          <tr>
            <th scope="col">No</th>
            <th scope="col">Gambar Produk</th>
            <th scope="col">Nama Produk</th>
            <th scope="col">Harga</th>
            <th scope="col">Buy</th>
            <th scope="col">Jumlah</th>
          </tr>
        </thead>
        <tbody>
          <?php $i = 1; ?>
          <?php foreach ($drink as $d) : ?>
            <tr>
              <th scope="row"><?= $i++; ?></th>
              <td><img src="/img/<?= $d['gambar']; ?>" alt="" class="product" style="max-height: 80px; min-height: 80px"></td>
              <td><?= $d['produk']; ?></td>
              <td>Rp.<?= $d['harga']; ?>.00</td>
              <td>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <button class="btn btn-outline-secondary" type="button" id="minus<?= $d['id'] ?>Btn" onclick="minusItem(<?= $d['id'] ?>)">-</button>
                  </div>
                  <input type="text" class="form-control" value="1" id="amount<?= $d['id'] ?>Input" style="min-width: 54px; max-width: 60px;" onblur="onBlurHandler('amount<?= $d['id'] ?>Input')" onchange="onInputHandler()">
                  <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="button" id="plus<?= $d['id'] ?>Btn" onclick="plusItem(<?= $d['id'] ?>)">+</button>
                  </div>
                </div>
              </td>
              <td>
                <p>
                  Rp. <span id="price<?= $d['id'] ?>Span" data-price="<?= $d['harga']; ?>"><?= $d['total'] ?? $d['harga']; ?></span>.00
                </p>
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
  var unsavedChanges = false;
  $(document).ready(function() {
    $(window).on('beforeunload', function() {
      if (unsavedChanges !== undefined ? unsavedChanges : false) {
        return 'You have unsaved changes. Are you sure you want to leave this page?';
      }
    });

    // prevent default save button
    $("#saveBtn").click(function(e) {
      e.preventDefault();
    });

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

  function onBlurHandler(inputId) {
    if ($("#" + inputId).val() == "") {
      $("#" + inputId).val(0);
    }
  }

  function onInputHandler() {
    setChangesSaved(false);
    onAmountChanged(<?= count($drink); ?>);

  }

  function onAmountChanged(i) {
    var amount = parseInt($("#amount" + i + "Input").val());
    var price = parseInt($("#price" + i + "Span").attr("data-price"));
    var totalPrice = amount * price;
    console.log(totalPrice, amount, price);
    $("#price" + i + "Span").html(totalPrice);
    $("#amountsInput[<?= $d['id'] ?>]").val(amount);
  }

  function setChangesSaved(changesSaved) {
    if (changesSaved) {
      $("#unsavedWarning").hide();
    } else {
      $("#unsavedWarning").show();
    }
  }

  function plusItem(i) {
    var amount = parseInt($("#amount" + i + "Input").val());
    amount++;
    $("#amount" + i + "Input").val(amount);
    setChangesSaved(false);
    onAmountChanged(i);
  }

  function minusItem(i) {
    var amount = parseInt($("#amount" + i + "Input").val());
    amount--;
    if (amount < 0) {
      amount = 0;
    }
    $("#amount" + i + "Input").val(amount);
    setChangesSaved(false);
    onAmountChanged(i);
  }

  function saveOrder() {
    // console log drink
    <?php foreach ($drink as $d) : ?>
      var amount = parseInt($("#amount<?= $d['id'] ?>Input").val());
      document.getElementById("amountsInput[<?= $d['id'] ?>]").value = amount;
    <?php endforeach; ?>

    // Mendapatkan elemen form
    var form = document.getElementById('saveCartForm');

    // // Submit formulir
    form.submit();

    setChangesSaved(true);
  }
</script>

<?= $this->endSection(); ?>
