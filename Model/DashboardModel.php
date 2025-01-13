<?php
class DashboardModel {
    // Exemple de méthode pour obtenir des partenaires
    public function getPartners() {
        return [
            ['id' => 1, 'name' => 'Partenaire A', 'reduction' => '10%'],
            ['id' => 2, 'name' => 'Partenaire B', 'reduction' => '20%'],
            ['id' => 3, 'name' => 'Partenaire C', 'reduction' => '30%'],
        ];
    }

    // Exemple de méthode pour obtenir des offres
    public function getOffers() {
        return [
            ['id' => 101, 'partner_id' => 1, 'offer' => 'Offre 1', 'quantity' => 50],
            ['id' => 102, 'partner_id' => 2, 'offer' => 'Offre 2', 'quantity' => 30],
        ];
    }
}
?>
