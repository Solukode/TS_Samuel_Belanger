<?php 
include_once __DIR__ . DIRECTORY_SEPARATOR . "src/pages/partials/header.php";
?>

    <main>
    <?php 
    
    if(isset($_POST['add_to_cart'])) {

        if(isset($_COOKIE['shopping_cart'])) {
            $cookie_data = $_COOKIE['shopping_cart'];
            $cart_data = json_decode($cookie_data, true);
        } else {
            $cart_data = array();
        }

        $cart_list = array_column($cart_data, 'hidden_id');

        if(in_array($_POST['hidden_id'], $cart_list)) {
            foreach($cart_data as $key => $value) {
                if($cart_data[$key]['hidden_id'] == $_POST['hidden_id']) {
                    $cart_data[$key]['quantity'] = $cart_data[$key]['quantity'] + $_POST['quantity'];
                }
            }
        } else {
            $item_array = array(
                'hidden_id' => $_POST['hidden_id'],
                'hidden_name' => $_POST['hidden_name'],
                'hidden_price' => $_POST['hidden_price'],
                'quantity' => $_POST['quantity']
            );
            $cart_data[] = $item_array;
        }

        $item_data = json_encode($cart_data);

        setcookie('shopping_cart', $item_data, time() + (86400 * 30), "/");

        header('location:index.php?success=1');

    }
    ?>
        <div class="card_grid">

        <?php
        $productDB = file_get_contents('app/database/productDB.json');
        $data = json_decode($productDB, true);

        if(isset($_GET['brand'])) {
            $brand_filter = $_GET['brand'];
            $filtered_data = array_filter($data, function($product) use ($brand_filter) {
                return $product['brand'] === $brand_filter;
            });
            $data = $filtered_data;
        }

        foreach ($data as $product):
        ?>
            <div class="card">
                <form action="" method="post">
                    <img class="card_image" src="/src/resources/images/<?= $product['image'] ?>" alt="<?= $product['name'] ?>">
                    <h2><?= $product['name'] ?></h2>
                    <h3><?= $product['brand'] ?></h3>
                    <p><?= $product['description'] ?></p>
                    <p id="price" class="price">$<?=  number_format($product['price'], 2) ?></p>
                    <input type="text" name="quantity" value="1">
                    <input type="hidden" name="hidden_name" value="<?= $product['name'] ?>">
                    <input type="hidden" name="hidden_price" value="<?= $product['price'] ?>">
                    <input type="hidden" name="hidden_id" value="<?= $product['id'] ?>">
                    <input type="submit" value="Ajouter au panier" name="add_to_cart">
                </form>
            </div>
        <?php endforeach ?>
        </div>
        
    </main>

<?php
include_once __DIR__ . DIRECTORY_SEPARATOR . "src/pages/partials/footer.php";
?>
