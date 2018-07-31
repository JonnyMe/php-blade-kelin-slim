<?php 
    function uploadFile($file, $nomeFile, $uploadPath, $mimetypes){

        try {
            // Undefined | Multiple Files | $_FILES Corruption Attack
            // If this request falls under any of them, treat it invalid.
            if (
                !isset($file['error'][0]) ||
                is_array($file['error'][0])
                ) {
                    throw new RuntimeException('Invalid parameters.');
                }
                
                // Check $_FILES['upfile']['error'] value.
                switch ($file['error'][0]) {
                    case UPLOAD_ERR_OK:
                        break;
                    case UPLOAD_ERR_NO_FILE:
                        throw new RuntimeException('No file sent.');
                    case UPLOAD_ERR_INI_SIZE:
                    case UPLOAD_ERR_FORM_SIZE:
                        throw new RuntimeException('Exceeded filesize limit.');
                    default:
                        throw new RuntimeException('Unknown errors.');
                }
                
                // You should also check filesize here.
                if ($file['size'][0] > 10000000) {
                    throw new RuntimeException('Exceeded filesize limit.');
                }
                
                // DO NOT TRUST $_FILES['upfile']['mime'] VALUE !!
                // Check MIME Type by yourself.
                /*array(
                    'jpg' => 'image/jpeg',
                    'png' => 'image/png'
                )*/
                $finfo = new finfo(FILEINFO_MIME_TYPE);
                if (false === $ext = array_search($finfo->file($file['tmp_name'][0]), $mimetypes, true)) {
                    throw new RuntimeException('Invalid file format.');
                }

                // You should name it uniquely.
                // DO NOT USE $_FILES['upfile']['name'] WITHOUT ANY VALIDATION !!
                // On this example, obtain safe unique name from its binary data.
                $dir = dirname(__FILE__);
                
                if (!file_exists($dir.'/../'.$uploadPath)) {
                    mkdir($dir.'/../'.$uploadPath, 0777, true);
                }

                if (!move_uploaded_file(
                    $file['tmp_name'][0],
                    sprintf($dir.'/../'.$uploadPath.'/%s.%s', $nomeFile, $ext)
                    )) {
                        throw new RuntimeException('Failed to move uploaded file.');
                    }
                    
                    return sprintf('/'. $uploadPath .'/%s.%s', $nomeFile, $ext);
                        
        } catch (RuntimeException $e) {
            
            return false;
            
        }
    }
    
    function reArrayFiles($file){
        
        $file_ary = array();
        
        if(isset($file['name'])){
            $file_count = count($file['name']);
            $file_key = array_keys($file);
            
            for($i=0;$i<$file_count;$i++)
            {
                foreach($file_key as $val)
                {
                    $file_ary[$i][$val] = $file[$val][$i];
                }
            }
        }
        
        return $file_ary;
    }
?>
