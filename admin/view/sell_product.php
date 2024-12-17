<?php
session_start();

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include SweetAlert2
echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';

// Initialize the session cart array if we're on the correct page
if (isset($_GET['page']) && $_GET['page'] === 'manage_sell_product') {
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Add to cart functionality
    if (isset($_GET['add_to_cart'], $_GET['catch_item'], $_GET['quantity'], $_GET['price'])) {
        $catch_item = htmlspecialchars($_GET['catch_item']);
        $quantity = (int)$_GET['quantity'];
        $price = (float)$_GET['price'];

        // Check if item already in cart; if so, increase quantity
        $item_exists = false;
        foreach ($_SESSION['cart'] as &$cart_item) {
            if ($cart_item['catch_item'] === $catch_item) {
                $cart_item['quantity'] += $quantity;
                $item_exists = true;
                break;
            }
        }

        // Add new item if it doesn’t already exist
        if (!$item_exists) {
            $_SESSION['cart'][] = [
                'catch_item' => $catch_item,
                'quantity' => $quantity,
                'price' => $price,
            ];
        }

        // Show success notification and refresh page to prevent re-submission
        echo "<script>
                Swal.fire({
                    icon: 'success',
                    title: 'Item added to cart!',
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => window.location.href = '?page=manage_sell_product');
              </script>";
        exit();
    }

    // Remove from cart functionality
    if (isset($_GET['remove_from_cart'], $_GET['catch_item'])) {
        $catch_item = htmlspecialchars($_GET['catch_item']);
        foreach ($_SESSION['cart'] as $key => $cart_item) {
            if ($cart_item['catch_item'] === $catch_item) {
                unset($_SESSION['cart'][$key]);
                $_SESSION['cart'] = array_values($_SESSION['cart']); // Re-index the cart array
                break;
            }
        }

        // Show success notification and refresh page to prevent re-submission
        echo "<script>
                Swal.fire({
                    icon: 'success',
                    title: 'Item removed from cart!',
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => window.location.href = '?page=manage_sell_product');
              </script>";
        exit();
    }

    // Fetch unique items and calculate totals
    $sql = "SELECT catch_item, SUM(catch_kilo) AS total_quantity, AVG(catch_amount + 30) AS price_with_addition
            FROM catch_records_sell
            GROUP BY catch_item";
    $result = mysqli_query($con, $sql);
?>

<!-- CSS Styling -->
<style>
    /* General styling */
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f6f9;
        color: #333;
    }
    .content-header h1 { color: #0056b3; }
    .table-responsive { margin-top: 20px; }
    .card { background-color: #fff; border: 1px solid #eaeaea; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); margin-top: 20px; padding: 20px; }
    .card-header h3 { font-size: 1.5em; color: #333; margin-bottom: 10px; }
    .form-group { margin-top: 15px; }
    .form-group label { font-weight: bold; color: #555; }
    .form-control { padding: 8px; border-radius: 4px; border: 1px solid #ddd; width: 100%; }
    .btn { padding: 10px 20px; border-radius: 4px; font-size: 14px; cursor: pointer; }
    .btn-primary { background-color: #007bff; border: none; color: #fff; }
    .btn-danger { background-color: #dc3545; border: none; color: #fff; }
    .btn-success { background-color: #28a745; border: none; color: #fff; }
    
    /* Validation Styling */
    .valid { border-color: green; }
    .invalid { border-color: red; }
    .disabled { pointer-events: none; opacity: 0.6; }
</style>

<!-- HTML Content -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2 align-items-center">
            <div class="col-6"><h1>Sold Products</h1></div>
            <div class="col-6">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Sold Products</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<section class="content container-fluid">
    <div class="box-body">
        <div class="table-responsive">
            <table id="example2" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Catch Item</th>
                        <th>Quantity Available</th>
                        <th>Price (₱)</th>
                        <th>Quantity</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($result) > 0) :
                        $count = 1;
                        while ($row = mysqli_fetch_assoc($result)) :
                            $catch_item = htmlspecialchars($row['catch_item']);
                            $total_quantity = htmlspecialchars($row['total_quantity']);
                            $price_with_addition = number_format($row['price_with_addition'], 2);
                    ?>
                        <tr>
                        <td><?= $count ?></td>
                        <td><?= $catch_item ?></td>
                        <td><?= $total_quantity ?></td>
                        <td>&#8369; <?= $price_with_addition ?></td>
                        <td>
                            <form action="" method="get" style="display: flex; align-items: center;">
                                <input type="number" name="quantity" min="1" max="<?= $total_quantity ?>" value="1" required style="width: 60px; text-align: center;">
                                <input type="hidden" name="page" value="manage_sell_product">
                                <input type="hidden" name="add_to_cart" value="1">
                                <input type="hidden" name="catch_item" value="<?= urlencode($catch_item) ?>">
                                <input type="hidden" name="price" value="<?= $price_with_addition ?>">
                        </td>
                        <td>
                                <button type="submit" class="btn btn-primary"><i class="fa fa-cart-plus"></i> Add to Cart</button>
                            </form>
                        </td>
                        </tr>

                    <?php
                            $count++;
                        endwhile;
                    else : ?>
                        <tr><td colspan="6">No fish items available</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>

<!-- Cart Section -->
<section class="content container-fluid">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Your Cart</h3>
        </div>
        <div class="card-body">
            <?php if (!empty($_SESSION['cart'])) : ?>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Items</th>
                            <th>Quantity (Kg)</th>
                            <th>Price (₱)</th>
                            <th>Total (₱)</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $total_price = 0;
                        foreach ($_SESSION['cart'] as $item) :
                            $item_total = $item['quantity'] * $item['price'];
                            $total_price += $item_total;
                        ?>
                            <tr>
                                <td><?= htmlspecialchars($item['catch_item']) ?></td>
                                <td><?= htmlspecialchars($item['quantity']) ?></td>
                                <td>&#8369; <?= number_format($item['price'], 2) ?></td>
                                <td>&#8369; <?= number_format($item_total, 2) ?></td>
                                <td><a href="?page=manage_sell_product&remove_from_cart=1&catch_item=<?= urlencode($item['catch_item']) ?>" class="btn btn-danger"><i class="fa fa-trash"></i> Remove</a></td>
                            </tr>
                        <?php endforeach; ?>
                        <tr>
                            <td colspan="4" class="text-right"><strong>Total:</strong></td>
                            <td><strong>&#8369; <?= number_format($total_price, 2) ?></strong></td>
                        </tr>
                    </tbody>
                </table>
                <form id="checkoutForm" action="function/function_crud.php" method="post" class="mt-4">
                    <input type="hidden" id="cart_total" value="<?= number_format($total_price, 2, '.', '') ?>">
                    <div class="form-group">
                        <label for="amount">Amount (₱)</label>
                        <input type="text" class="form-control" name="amount" id="amount" required>
                        <small id="amountError" style="color: red; display: none;">Amount must be at least the total cart amount of ₱<?= number_format($total_price, 2) ?>.</small>
                    </div>
                    <div class="form-group">
                        <label for="full_name">Full Name</label>
                        <input type="text" class="form-control" name="full_name" id="full_name" required>
                    </div>
                    <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" class="form-control" name="address" id="address" required>
                    </div>
                    <div class="form-group">
                        <label for="phone_number">Phone Number</label>
                        <input type="text" class="form-control" name="phone_number" id="phone_number" maxlength="11" required>
                    </div>
                    <button type="submit" name="checkout" id="checkoutButton" class="btn btn-success disabled" disabled>Checkout</button>
                </form>
            <?php else : ?>
                <p>Your cart is empty.</p>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php } ?>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const amountField = document.getElementById("amount");
        const cartTotal = parseFloat(document.getElementById("cart_total").value);
        const amountError = document.getElementById("amountError");
        const checkoutButton = document.getElementById("checkoutButton");

        const fullNameField = document.getElementById("full_name");
        const addressField = document.getElementById("address");
        const phoneNumberField = document.getElementById("phone_number");
        const phoneError = document.getElementById("phoneError");

        // Regex patterns for validation
        const fullNameRegex = /^[A-Z][a-z]*(\s[A-Z][a-z]*)*(\s[A-Z]\.)?\s[A-Z][a-z]+$/;
        const addressRegex = /^[A-Za-z\s]+,\s[A-Za-z\s]+,\s[A-Za-z\s]+,\s[A-Za-z\s]+$/; 
        const phoneRegex = /^09\d{9}$/;  // Ensures it starts with "09" and has exactly 11 digits

        // Function to enforce numeric input only
        function enforceNumericInput(event) {
            const charCode = event.which ? event.which : event.keyCode;
            if (charCode < 48 || charCode > 57) {
                event.preventDefault();
            }
        }

        // Function to validate field with regex
        function validateField(field, regex, errorElement = null, errorMessage = "") {
            field.classList.remove("valid", "invalid");
            if (regex.test(field.value.trim())) {
                field.classList.add("valid");
                if (errorElement) errorElement.style.display = "none";
                return true;
            } else {
                field.classList.add("invalid");
                if (errorElement) {
                    errorElement.textContent = errorMessage;
                    errorElement.style.display = "block";
                }
                return false;
            }
        }

        // Function to validate the amount field against the cart total
        function validateAmount() {
            const enteredAmount = amountField.value.trim();

            // Check if enteredAmount is a valid number
            if (/^\d*\.?\d*$/.test(enteredAmount)) {  // Regular expression to allow only numbers and a single decimal
                const numericAmount = parseFloat(enteredAmount);
                if (!isNaN(numericAmount) && numericAmount >= cartTotal) {
                    amountError.style.display = "none";
                    amountField.classList.add("valid");
                    amountField.classList.remove("invalid");
                    return true;
                } else {
                    amountError.textContent = "Amount should be at least the total of ₱" + cartTotal.toFixed(2);
                    amountError.style.display = "block";
                    amountField.classList.add("invalid");
                    amountField.classList.remove("valid");
                    return false;
                }
            } else {
                amountError.textContent = "Please enter a valid number.";
                amountError.style.display = "block";
                amountField.classList.add("invalid");
                amountField.classList.remove("valid");
                return false;
            }
        }

        // Function to validate all fields before enabling the checkout button
        function validateCheckout() {
            const isValidAmount = validateAmount();
            const isValidFullName = validateField(fullNameField, fullNameRegex);
            const isValidAddress = validateField(addressField, addressRegex);
            const isValidPhone = validateField(phoneNumberField, phoneRegex, phoneError, "Phone number must start with '09' and contain exactly 11 digits.");

            // Enable the checkout button only if all fields are valid
            if (isValidAmount && isValidFullName && isValidAddress && isValidPhone) {
                checkoutButton.disabled = false;
                checkoutButton.classList.remove("disabled");
            } else {
                checkoutButton.disabled = true;
                checkoutButton.classList.add("disabled");
            }
        }

        // Event listeners for real-time validation
        amountField.addEventListener("input", validateCheckout);
        amountField.addEventListener("keypress", enforceNumericInput);
        fullNameField.addEventListener("input", validateCheckout);
        addressField.addEventListener("input", validateCheckout);
        phoneNumberField.addEventListener("input", function() {
            if (phoneNumberField.value.length > 11) {
                phoneNumberField.value = phoneNumberField.value.slice(0, 11); // Limit to 11 digits
            }
            validateCheckout();
        });
        phoneNumberField.addEventListener("keypress", enforceNumericInput);

        // Initial validation to set the correct state of the checkout button
        validateCheckout();
    });
</script>



