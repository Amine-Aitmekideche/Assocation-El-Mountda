<?php
require_once __DIR__ . '/../Controller/Partenaire_controller.php';
require_once __DIR__ . '/../Controller/Offers_controller.php';

class Offers_view {

    public function display_offers_table($partenaireId) {
        $partenaireController = new Partenaire_controller();
        $offersController = new Offers_controller();

        $partenaire = $partenaireController->get_Partenaire_by_id_controller($partenaireId);
        $remises = $offersController->get_Offres_by_partenaire_controller($partenaireId);

        if (!empty($partenaire) && !empty($remises)) {
            echo '<table class="offres-table">';
            echo '<thead>';
            echo '<tr>';
            echo '<th>Ville</th>';
            echo '<th>Nom</th>';
            echo '<th>Catégorie</th>';
            echo '<th>Carte</th>';
            echo '<th>Réduction</th>';
            echo '<th>Avantage</th>';
            echo '<th>Date Fin</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';
            
            foreach ($remises as $remise) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($partenaire[0]['willya']) . '</td>';
                echo '<td>' . htmlspecialchars($partenaire[0]['nom']) . '</td>';
                echo '<td>' . htmlspecialchars($partenaire[0]['categorie']) . '</td>';
                echo '<td>' . htmlspecialchars($remise['carte']) . '</td>';
                echo '<td>' . htmlspecialchars($remise['reduction']) . '%</td>';
                echo '<td>' . htmlspecialchars($remise['avantage']) . '</td>';
                echo '<td>' . (!empty($remise['date_fin']) ? htmlspecialchars($remise['date_fin']) : 'Illimité') . '</td>';
                echo '</tr>';
            }
            
            echo '</tbody>';
            echo '</table>';
        } else {
            echo '<p>Aucune offre disponible pour ce partenaire.</p>';
        }
    }

    public function display_all_offers_table($limite) {
        $offersController = new Offers_controller();
        $partenaireController = new Partenaire_controller();
    
        $partenaires = $partenaireController->get_Partenaire_controller();
    
        if (!empty($partenaires)) {
            echo '<table class="offres-table">';
            echo '<thead>';
            echo '<tr>';
            echo '<th>Ville</th>';
            echo '<th>Nom</th>';
            echo '<th>Catégorie</th>';
            echo '<th>Carte</th>';
            echo '<th>Réduction</th>';
            echo '<th>Avantage</th>';
            if($limite) echo '<th>Date Fin</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';
    
            foreach ($partenaires as $partenaire) {
                $remises = $offersController->get_Offres_by_partenaire_controller($partenaire['id']);
    
                if (!empty($remises)) {
                    foreach ($remises as $remise) {
                        if($limite &&  !empty($remise['date_fin'])){
                            echo '<tr>';
                            echo '<td>' . htmlspecialchars($partenaire['willya']) . '</td>';
                            echo '<td>' . htmlspecialchars($partenaire['nom']) . '</td>';
                            echo '<td>' . htmlspecialchars($partenaire['categorie']) . '</td>';
                            echo '<td>' . htmlspecialchars($remise['carte']) . '</td>';
                            echo '<td>' . htmlspecialchars($remise['reduction']) . '%</td>';
                            echo '<td>' . htmlspecialchars($remise['avantage']) . '</td>';
                            echo '<td>' . htmlspecialchars($remise['date_fin']) . '</td>';
                            echo '</tr>';
                        }
                        if(!($limite) &&  empty($remise['date_fin'])){
                            echo '<tr>';
                            echo '<td>' . htmlspecialchars($partenaire['willya']) . '</td>';
                            echo '<td>' . htmlspecialchars($partenaire['nom']) . '</td>';
                            echo '<td>' . htmlspecialchars($partenaire['categorie']) . '</td>';
                            echo '<td>' . htmlspecialchars($remise['carte']) . '</td>';
                            echo '<td>' . htmlspecialchars($remise['reduction']) . '%</td>';
                            echo '<td>' . htmlspecialchars($remise['avantage']) . '</td>';
                            echo '</tr>';
                        }
                        
                    }
                } 
            }
    
            echo '</tbody>';
            echo '</table>';
        } else {
            echo '<p>Aucun partenaire trouvé.</p>';
        }
    }

    public function display_all_offers_table_home() {
        $offersController = new Offers_controller();
        $partenaireController = new Partenaire_controller();
    
        // Récupération des partenaires
        $partenaires = $partenaireController->get_Partenaire_controller();
    
        // Récupération des offres
        $allOffers = [];
        foreach ($partenaires as $partenaire) {
            $remises = $offersController->get_Offres_by_partenaire_controller($partenaire['id']);
            if (!empty($remises)) {
                foreach ($remises as $remise) {
                    $allOffers[] = [
                        'willya' => $partenaire['willya'],
                        'nom' => $partenaire['nom'],
                        'categorie' => $partenaire['categorie'],
                        'carte' => $remise['carte'],
                        'reduction' => $remise['reduction'],
                        'avantage' => $remise['avantage'],
                        'date_fin' => $remise['date_fin'],
                    ];
                }
            }
        }
    
        // Convertir les données en JSON pour les envoyer au client
        echo '<script>';
        echo 'let allOffers = ' . json_encode($allOffers) . ';';
        echo 'let offersPerPage = 10;';
        echo 'let currentPage = 1;';
        echo '</script>';
    
        // Affichage du tableau avec les 10 premières offres
        echo '<table class="offres-table">';
        echo '<thead>';
        echo '<tr>';
        echo '<th>Ville</th>';
        echo '<th>Nom</th>';
        echo '<th>Catégorie</th>';
        echo '<th>Carte</th>';
        echo '<th>Réduction</th>';
        echo '<th>Avantage</th>';
        echo '<th>Date Fin</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody id="offers-table-body">';
        echo '</tbody>';
        echo '</table>';
    
        // Pagination
        echo '<div class="pagination" id="pagination-links"></div>';
    
        // Affichage du script pour le rendu dynamique
        echo '<script>
            function renderOffersRows(pageNumber) {
                let start = (pageNumber - 1) * offersPerPage;
                let end = start + offersPerPage;
                let pageOffers = allOffers.slice(start, end);
    
                let tableBody = document.getElementById("offers-table-body");
                tableBody.innerHTML = "";
                pageOffers.forEach(offer => {
                    let row = `<tr>
                        <td>${offer.willya}</td>
                        <td>${offer.nom}</td>
                        <td>${offer.categorie}</td>
                        <td>${offer.carte}</td>
                        <td>${offer.reduction}%</td>
                        <td>${offer.avantage}</td>
                        <td>${offer.date_fin}</td>
                    </tr>`;
                    tableBody.innerHTML += row;
                });
            }
    
            function setupPagination() {
                let totalPages = Math.ceil(allOffers.length / offersPerPage);
                let paginationLinks = document.getElementById("pagination-links");
                paginationLinks.innerHTML = "";
    
                for (let page = 1; page <= totalPages; page++) {
                    let link = `<a href="javascript:void(0);" onclick="changePage(${page})">${page}</a>`;
                    paginationLinks.innerHTML += link;
                }
            }
    
            function changePage(pageNumber) {
                currentPage = pageNumber;
                renderOffersRows(currentPage);
            }
    
            // Initial render
            renderOffersRows(currentPage);
            setupPagination();
        </script>';
    }
    
   
    
}


?>