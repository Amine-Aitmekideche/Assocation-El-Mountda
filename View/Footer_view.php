<?php

class Footer_view {

    public function display_footer() {
        echo '<footer class="footer">
            <div class="footer-container">
                <div class="footer-section">
                    <h4>À propos de nous</h4>
                    <p>Découvrez notre entreprise et nos offres spéciales.</p>
                </div>
                <div class="footer-section">
                    <h4>Liens utiles</h4>
                    <ul>
                        <li><a href="#">Accueil</a></li>
                        <li><a href="#">Nos offres</a></li>
                        <li><a href="#">Contactez-nous</a></li>
                        <li><a href="#">FAQ</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h4>Contact</h4>
                    <p>Email : contact@exemple.com</p>
                    <p>Téléphone : +123 456 789</p>
                </div>
                <div class="footer-section">
                    <h4>Suivez-nous</h4>
                    <div class="social-links">
                        <a href="#" class="social-icon">
                            <i class="fab fa-facebook" style="font-size: 24px;"></i> <!-- Icône Facebook -->
                        </a>
                        <a href="#" class="social-icon">
                            <i class="fab fa-twitter" style="font-size: 24px;"></i> <!-- Icône Twitter -->
                        </a>
                        <a href="#" class="social-icon">
                            <i class="fab fa-instagram" style="font-size: 24px;"></i> <!-- Icône Instagram -->
                        </a>
                    </div>
                </div>
            </div>
            <div class="footer-bottom2025">
                <p>&copy; 2025 Votre Entreprise. Tous droits réservés.</p>
            </div>
        </footer>';

        
    }
}
?>
