<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
    <div class="row">
        <div class="container mt-3 mb-2">
            <div class="row">
                <!-- Contact and Delivery Information Form -->
                <div class="col-md-6">
                    <div class="card shadow-sm">
                        <div class="card-header font-weight-bold">
                            Contact and Delivery Information
                        </div>

                        <form action="<?= url_to('placeOrder') ?>" method="POST">
                            <?= csrf_field() ?> <!-- Add CSRF field -->

                            <div class="card-body">
                                <div class="form-group">
                                    <label for="name">Recipient</label>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter recipient name" required autofocus value=<?= old('name') ? old('name') : $recipient ?>>
                                </div>
                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <input type="text" class="form-control" id="address" name="address" placeholder="Enter your address" required value=<?= old('address') ?>>
                                </div>
                                <div class="form-group">
                                    <label for="phone">Phone Number</label>
                                    <input type="tel" class="form-control" id="phone" name="phone" placeholder="Enter your phone number" required value=<?= old('phone') ?>>
                                </div>
                            </div>
                    </div>
                </div>

                <!-- Order Summary Card -->
                <div class="col-md-6">
                    <div class="card shadow-sm">
                        <div class="card-header font-weight-bold">
                            Order Summary
                        </div>
                        <div class="card-body">
                            <!-- Product List -->
                            <table class="table" id="productTable">
                                <tbody>
                                    <?php foreach ($products as $product) : ?>
                                        <tr>
                                            <td><img src="/img/<?= $product['image'] ?>" style="width: 50px; height: 50px;"></td>
                                            <td><?= $product['name'] ?></td>
                                            <td>
                                                <input type="number" name="amounts[<?= $product['id'] ?>]" value=<?= $product['quantity'] ?> min="0" class="small-input quantity-input">
                                            </td>
                                            <td class="price-column">Rp. <?= $product['price'] ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                    <!-- Add more rows for other products -->
                                </tbody>
                            </table>

                            <!-- Subtotal, Shipping, and Total Price -->
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td>Subtotal</td>
                                        <td class="text-right" id="subtotal">$35.00</td>
                                    </tr>
                                    <tr>
                                        <td>Shipping</td>
                                        <td class="text-right" id='shippingcost'>Rp. 5000</td>
                                    </tr>
                                    <tr class="font-weight-bold">
                                        <td>Total Price</td>
                                        <td class="text-right" id="totalPrice">$40.00</td>
                                    </tr>
                                </tbody>
                            </table>
                            <!-- ... existing form fields ... -->
                            <button type="submit" class="btn btn-primary btn-block" id="placeOrderBtn">Place Order</button>
                            <input type="hidden" name="subtotal" id="hiddenSubtotal" value="35.00" disabled>
                            <input type="hidden" name="shippingcost" id="hiddenShippingCost" value="5000" disabled>
                            <input type="hidden" name="totalPrice" id="hiddenTotalPrice" value="40.00" disabled>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add Bootstrap JS and Popper.js scripts -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script>
            //TODO Implement DOM manipulation
            document.addEventListener('DOMContentLoaded', function() {
                calcprice()
            });

            const quantityInputs = document.querySelectorAll('.quantity-input');


            // Add event listener to each quantity input
            quantityInputs.forEach(function(input) {
                input.addEventListener('input', function() {
                    updateSubtotal();
                });
            });

            // Function to update subtotal based on quantity
            function updateSubtotal() {
                calcprice()
            }

            function calcprice() {
                let subtotal = 0;
                let total = 0;

                // Iterate through each row in the product table
                document.querySelectorAll('#productTable tbody tr').forEach(function(row, index) {
                    const priceElement = row.querySelector('.price-column');
                    const quantityInput = row.querySelector('.quantity-input');
                    const price = parseFloat(priceElement.innerText.replace('Rp. ', ''));
                    const quantity = parseInt(quantityInput.value);

                    // Update subtotal for each row
                    subtotal += price * quantity;
                    // Check if quantity is 0 and remove the row
                    // if (quantity === 0) {
                    //     row.remove();
                    //     showRemoveAlert();
                    // }
                });
                const shippingprice = parseFloat(shippingcost.innerText.replace('Rp. ', ''));
                total = subtotal + shippingprice
                // Update hidden input fields
                document.getElementById('hiddenSubtotal').value = subtotal.toFixed(2);
                document.getElementById('hiddenTotalPrice').value = total.toFixed(2);

                // Display the updated subtotal
                document.getElementById('subtotal').innerText = 'Rp. ' + subtotal.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
                document.getElementById('totalPrice').innerText = 'Rp. ' + total.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
            }

            // Function to show remove alert
            function showRemoveAlert() {
                removeAlert.classList.remove('d-none'); // Show the alert
                setTimeout(function() {
                    removeAlert.classList.add('d-none'); // Hide the alert after a short delay
                }, 3000); // Adjust the delay (in milliseconds) as needed
            }
        </script>

        </html>

        <style>
            .small-input {
                width: 40px;
            }
        </style>

        <?= $this->endSection(); ?>
