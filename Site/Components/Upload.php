<?php
namespace Site\Components;

use Site\Library\Utilities as Utilities;
use Site\Library\Image as Image;

class Upload
{
    public function ImageLarge($fieldName, $fieldIndex = null, $path = null, 
        $width = 0, $height = 0) {
        
        $tempName = $this->getTempFileName($fieldName, $fieldIndex);
        
        $path = IMAGE_DIR.$path;

        $processing = new Image\Processing($tempName);

        if(empty($width) || empty($height)) {
            $width = IMAGE_WIDTH;
            $height = IMAGE_HEIGHT;
        }

        $processing->resize($width, $height);
        $imageName = $processing->save($path);

        return $imageName;
    }
	
    public function ImageThumb($fieldName, $fieldIndex = null, $path = null, 
        $width = 0, $height = 0) {
        
        $tempName = $this->getTempFileName($fieldName, $fieldIndex);

        $path = THUMB_DIR.$path;

        $processing = new Image\Processing($tempName);

        if(empty($width) || empty($height)) {
            $width = THUMB_WIDTH;
            $height = THUMB_HEIGHT;
        }

        $processing->resize($width, $height);
        $imageName = $processing->save($path);

        return $imageName;
    }

    public function getFileName($fieldName, $fieldIndex) {
        if(isset($fieldIndex)) {
            $fileName = stripslashes($_FILES[$fieldName]['name'][$fieldIndex]);
        }
        else {
            $fileName = stripslashes($_FILES[$fieldName]['name']);
        }

        return $fileName;
    }

    public function getTempFileName($fieldName, $fieldIndex) {
        if (isset($fieldIndex)) {
            $fileTempName = $_FILES[$fieldName]['tmp_name'][$fieldIndex];
        }
        else {
            $fileTempName = $_FILES[$fieldName]['tmp_name'];
        }

        return $fileTempName;
    }
}