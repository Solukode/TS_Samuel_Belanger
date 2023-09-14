<?php
include_once __DIR__ . DIRECTORY_SEPARATOR . "partials/header.php";


if(isset($_GET["action"]) && $_GET["action"] === "clear") {
    setcookie("shopping_cart", "", time() - 3600, "/");
    header("location:checkout.php?clearAll=1");
}

if(isset($_GET["action"]) && $_GET["action"] === "delete"){
    $cookie_data = stripslashes($_COOKIE['shopping_cart']);
    $cart_data = json_decode($cookie_data, true);
    foreach($cart_data as $key => $value) {
        if($cart_data[$key]["hidden_id"] == $_GET['id']) {
            unset($cart_data[$key]);
            $item_data = json_encode($cart_data);
            setcookie('shopping_cart', $item_data, time() + (86400 * 30), "/");
            header("location:checkout.php?remove=1");
        }
    } 
}

?>

<div >
    <a class="clear_cart" href="<?php echo $_SERVER['PHP_SELF']; ?>?action=clear">Vider le panier</a>
    <h3>Details de la commande</h3>
    <div class="cart_flex">
        <table class="cart_table">
            <tr>
                <td width="40%">Article</td>
                <td width="20%">Quantité</td>
                <td width="20%">Prix</td>
                <td width="20%">Total</td>
                <td width="20%">Action</td>
            </tr>
            <?php
            if (isset($_COOKIE["shopping_cart"])) {
                $total = 0;
                $cookie_data = stripslashes($_COOKIE["shopping_cart"]);
                $cart_data = json_decode($cookie_data, true);
                foreach ($cart_data as $key => $value) {
                    ?>
                    <tr>
                        <td>
                            <?php echo $value["hidden_name"]; ?>
                        </td>
                        <td>
                            <?php echo $value["quantity"]; ?>
                        </td>
                        <td>
                            <?php echo $value["hidden_price"]; ?>
                        </td>
                        <td>
                            <?php
                            $subtotal = $value["quantity"] * $value["hidden_price"];
                            $total += $subtotal; 
                            echo number_format($subtotal, 2) . "$";
                            ?>
                        </td>
                        <td><a href="src/pages/checkout.php?action=delete&id=<?php echo $value["hidden_id"]; ?>">Effacer</a></td>
                    </tr>

                <?php
                }
            } else {
                echo "<tr><td>Le panier est vide</td></tr>";
            }
                ?>
        </table>
        <div>
            <p id="cart_total" data-total="<?= isset($total) ? $total : 0 ?>">Total : <?= isset($total) ? $total : 0 ?>$</p> 
        </div>
        <div class="payment">
            <form action="/src/pages/charge.php" method="post" id="checkout" class="CheckoutForm">
                <input type="hidden" name="total_price" id="total_price" value="<?= $total ?>">
                <div class="form-row">
                    <label for="card-element">carte de crédit ou de débit</label>
                    <div id="card-element">
                        <!-- a Stripe Element will be inserted here. -->
                    </div>
                    <div id="card-errors">
                        <!-- Used to display form errors -->
                    </div>
                </div>
                <button type="submit" class="btn CheckoutForm__submit">Payé avec STRIPE</button>
            </form>
            <div id="paypal-payment-button" style="margin-top:10px";></div>
        </div>
    </div>
</div>

<script src="https://www.paypal.com/sdk/js?client-id=AV6mKL_7Il7FaBj60u17lyAseWjd0iERpsIjAnU5avwRO3vWagsid5eGK0OARJiYB7y2y0xy9bdeNkgO&disable-funding=credit,card&currency=CAD"></script>
<script src="src/resources/js/paypal.js"></script>
<script src="https://js.stripe.com/v3/"></script>
<script src="src/resources/js/charge.js"></script>

<?php
include_once __DIR__ . DIRECTORY_SEPARATOR . "partials/footer.php";
?>