<?php
require_once('./Controller/News_controller.php');
require_once('./Controller/News_type_controller.php');

class News_view{
    

    public function display_news() {
        echo '<h1 class="page-title">Liste des actualités par type</h1>';
        echo '<div class="news-container">';
        
        try {
            $typeController = new News_type_controller();
            $newsController = new News_controller();
        
            $types = $typeController->get_News_type_controller();
        
            foreach ($types as $type) {
               
                $newsList = $newsController->get_News_by_type_controller($type['id']);
        
                if (count($newsList) > 0) {
                    echo '<div class="news-type">';
                    echo '<h2 class="type-title">' . htmlspecialchars($type['type']) . '</h2>';
                    echo '<div class="news-items">';
                    foreach ($newsList as $news) {
                        echo '<div class="news-item">';
                        echo '<img class="news-image" src="' . htmlspecialchars($news['image']) . '" alt="Image de l\'actualité">';
                        echo '<div>';
                        echo '<h3 class="news-title">' . htmlspecialchars($news['titre']) . '</h3>';
                        echo '<p class="news-description">' . htmlspecialchars($news['description']) . '</p>';
                        echo '<p><strong>Date de début :</strong> ' . htmlspecialchars($news['date_debut']) . '</p>';
                        echo '<p><strong>Date de fin :</strong> ' . htmlspecialchars($news['date_fin']) . '</p>';
                        echo '</div>';
                        
                        echo '</div>';
                    }
                    echo '</div>';
                } 
                echo '</div>';
            }
        } catch (Exception $e) {
            echo '<p class="error-message">Erreur : ' . htmlspecialchars($e->getMessage()) . '</p>';
        }
        
        echo '</div>';
    }
    
    public function display_news_diaporama() {
        echo '<div class="news-container">';
        
        try {
            $newsController = new News_controller();
            
            $news = $newsController->get_News_controller();
            
            echo '<div class="diaporama">';
            echo '<div class="container-image">';
            
            for ($i = 0; $i < 5 && $i < count($news); $i++) {
                $article = $news[$i];
                echo '<img src="' . htmlspecialchars($article['image']) . '" alt="News Image" title="' . htmlspecialchars($article['titre']) . '" />';
            }
            
            echo '</div>'; 
            echo '</div>';
            
        } catch (Exception $e) {
            echo '<p class="error-message">Erreur : ' . htmlspecialchars($e->getMessage()) . '</p>';
        }    
        
        echo '</div>'; 
    }

    public function display_home_news() {
        echo '<div class="news-container_home">';
    
        try {
            $newsController = new News_controller();
            $newsList = $newsController->get_News_controller(); 
            $newsCount = 0;
            foreach ($newsList as $news) {
                if ($newsCount >= 8) break;
    
                echo '<div class="news-item">';
                echo '<img class="news-image" src="' . htmlspecialchars($news['image']) . '" alt="Image de l\'actualité">';
                echo '<div>';
                echo '<h3 class="news-title">' . htmlspecialchars($news['titre']) . '</h3>';
                echo '<p class="news-description">' . htmlspecialchars($news['description']) . '</p>';
                echo '<p><strong>Date de début :</strong> ' . htmlspecialchars($news['date_debut']) . '</p>';
                echo '<p><strong>Date de fin :</strong> ' . htmlspecialchars($news['date_fin']) . '</p>';
                echo '</div>';
                echo '</div>';
    
                $newsCount++;
            }
    
           
            echo '</div>';
            
            echo '<button class="view-more-button" onclick="window.location.href=\'news\'">Voir plus</button>';
        } catch (Exception $e) {
            echo '<p class="error-message">Erreur : ' . htmlspecialchars($e->getMessage()) . '</p>';
        }
    
        echo '</div>';
    }
    
    

   
}



?>