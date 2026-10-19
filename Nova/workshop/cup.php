<?php
    require_once "includes/parts/header.php";
    require_once 'config/init.php';
?>

<body>
    <section>
        <div class="wrapper">
            <h1 class="cup">Votre shaker à votre image</h1>
            <article class="presentation">
                <img class="shake" src="assets/img/cups/shaker-bgr-crop.png" alt="produit">
                <div class="presentation">
                    <p class="grand">Adapter selon vos envies</p>
                    <p class="moyen">Taille</p>
                        <div class="checkbox">
                            <ul class="quantite">
                                <li class="quantite"><input class="medium" type="radio" id="medium" name="Taille" value="M" checked /><label for="medium">500ml</label></li>
                                <li class="quantite"><input class="large" type="radio" id="large" name="Taille" value="L" checked /><label for="large">750ml</label></li>
                                <li class="quantite"><input class="large" type="radio" id="large" name="Taille" value="XL" checked /><label for="extra-large">1000ml</label></li>
                            </ul>
                        </div>
                    
                    <p class="moyen">Texte</p>
                    
                    <div class="form-group">
                        <textarea class="cup-text" name="cup-message" id="message-cup"></textarea>
                    </div>

                    <div class=button>
                        <ul>
                            <li><a class="ajout" href="#"><img class="svg-prod" img src="assets/img/svg/image.svg" alt="log">Ajouter</a></li>
                        </ul>
                    </div>

                    <p class="moyen">Image</p>

                    <div class=button>
                        <ul>
                            <li><a class="ajout" href="#"><img class="svg-prod" img src="assets/img/svg/image.svg" alt="log">Joindre un fichier (JPG, JPEG, PNG)</a></li>
                            <li><a class="ajout" href="#"><img class="svg-prod" img src="assets/img/svg/tdesign_cart.svg" alt="log">Ajouter au panier</a></li>
                        </ul>
                    </div>
                </div>
            </article>
        </div>
    </section>
</body>

<?php
    require_once "includes/parts/footer.php"
?>
</html>