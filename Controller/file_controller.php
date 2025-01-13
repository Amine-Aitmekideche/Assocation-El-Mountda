<?php
class file_controller {
    
    public static function generateUniqueName($file) {
        if (empty($file['name'])) {
            throw new Exception('Le fichier n\'a pas de nom valide.');
        }
        $fileNameWithoutExtension = pathinfo($file['name'], PATHINFO_FILENAME);
        $fileExtension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $uniqueName = $fileNameWithoutExtension . '_' . uniqid() . '.' . $fileExtension;
        return $uniqueName;
    }

    public static function chargerFile($file, $destinationDirectory) {
        if ($file['error'] === UPLOAD_ERR_OK) {
            $uniqueName = self::generateUniqueName($file); 
            echo $destinationDirectory;
            $destinationPath = $destinationDirectory . '/' . $uniqueName;
            if (move_uploaded_file($file['tmp_name'], $destinationPath)) {
                return $uniqueName; 
            } else {
                throw new Exception('Échec du téléchargement du fichier.');
            }
        } else {
            throw new Exception('Erreur lors de l\'upload du fichier.');
        }
    }
}
?>
