<?php
    require_once "includes/parts/header.php";
    require_once 'config/init.php';
?>
    
    <div class="log">
        
        <h1 class="log">Contact</h1>

        <form class="log" action="contact.php" method="POST">
            <div class="form-group">
                <input class="log" type="text" id="name" name="name" placeholder="Votre nom complet" required>
            </div>

            <div class="form-group">
                <input class="log" type="email" id="email" name="email" placeholder="Votre email" required>
            </div>

            <div class="form-group">
                <select class="log" id="subject" name="subject" required>
                    <option value="">-- Choisir un  sujet --</option>
                    <option value="info">Demande d'information</option>
                    <option value="order">Problème de commande</option>
                    <option value="support">Support technique</option>
                    <option value="other">Autre</option>
                </select>
            </div>

            <p class="grand">Message</p>

            <div class="form-group">
                <textarea class="log" id="message" name="message" rows="5" placeholder="Votre message..." required></textarea>
            </div>

            <button class="log" type="submit">Envoyer</button>
        </form>
    </div> 

<?php
    require_once "includes/parts/footer.php"
?>