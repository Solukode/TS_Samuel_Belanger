<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <base href="http://localhost/">
    <title>Sam-GPT | Produits esthétiques automobiles</title>

    <link rel="stylesheet" href='src/resources/css/main.css'>
    


</head>
<body>
    <header>
        <h1>Sam-GPT | Produits esthétiques automobiles</h1>

        <nav>
            <ul>
                <li><a href="">Acceuil</a></li>
                <li><a href="?brand=Carpro">Carpro</a></li>
                <li><a href="?brand=MaxShine">MaxShine</a></li>
                <li><a href="src/pages/checkout.php">Voir le panier</a></li>
            </ul>
        </nav>

        <div class="message">
            <?php 
                if(isset($_GET['msg']) && $_GET['msg'] === 'failed'){
                    echo "<p class='msgR'>Une erreur s'est produite</p>";
                }
                if(isset($_GET['msg']) && $_GET['msg'] === 'success'){
                    echo "<p class='msgV'>Merci de votre achat</p>";
                    setcookie("shopping_cart", "", time() - 3600, "/");
                }  
                if(isset($_GET['success'])) {
                    echo "<p class='msgW'>Le produit a été ajouté avec succes</p>";
                }
                if(isset($_GET['remove'])){
                    echo "<p class='msgW'>Le produit a été enlevé</p>";
                }
                if(isset($_GET['clearAll'])){
                    echo "<p class='msgW'>Le panier a été vidé</p>";
                }
            ?>
        </div>

    </header>