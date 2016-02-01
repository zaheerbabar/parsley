<?php
namespace Site\Library\Image;

use Site\Library\Utilities as Utilities;

class Processing
{
    private $_imageObj;

	private $_imageCreateFunc;
	private $_imageSaveFunc;
    
	private $_newImageIdentifier;
    
    public function __construct($imageTempName) {
        $this->imageTempName = $imageTempName;

		if (!file_exists($this->imageTempName)) {
            throw new \Exception('File ' . $this->imageTempName . ' does not exist.');
		}
	    
        $this->_load();
    }

    private function _load() {
		$info = getimagesize($this->imageTempName);
        $mime = exif_imagetype($this->imageTempName);

        if ($mime == false) {
	        throw new \Exception('The file ' . $this->imageTempName . ' is not a valid image.');
        }
        
		switch ($mime) {
			case IMAGETYPE_JPEG:
				$this->_imageCreateFunc = 'ImageCreateFromJPEG';
				$this->_imageSaveFunc = 'ImageJPEG';
				$ext = Extension::IMAGETYPE_JPEG;
				break;
				
			case IMAGETYPE_PNG:
				$this->_imageCreateFunc = 'ImageCreateFromPNG';
				$this->_imageSaveFunc = 'ImagePNG';
				$ext = Extension::IMAGETYPE_PNG;
				break;
			
			case IMAGETYPE_BMP:
				$this->_imageCreateFunc = 'ImageCreateFromBMP';
				$this->_imageSaveFunc = 'ImageBMP';
				$ext = Extension::IMAGETYPE_BMP;
				break;
			
			case IMAGETYPE_GIF:
				$this->_imageCreateFunc = 'ImageCreateFromGIF';
				$this->_imageSaveFunc = 'ImageGIF';
				$ext = Extension::IMAGETYPE_GIF;
				break;
			
			case IMAGETYPE_WBMP:
				$this->_imageCreateFunc = 'ImageCreateFromWBMP';
				$this->_imageSaveFunc = 'ImageWBMP';
				$ext = Extension::IMAGETYPE_BMP;
				break;
			
			case IMAGETYPE_XBM:
				$this->_imageCreateFunc = 'ImageCreateFromXBM';
				$this->_imageSaveFunc = 'ImageXBM';
				$ext = Extension::IMAGETYPE_XBM;
				break;
			
			default:
                throw new \Exception('Unknown image type.');
			}

        $this->_imageObj = (object) [
                        'width' => $info[0],
                        'height' => $info[1],
                        'mime' => $mime,
                        'extension' => $ext
                        ];

        return true;
    }
	
	public function resize($newWidth, $newHeight = 0, $ratio = true, $keepTransparency = true) {
        if (empty($newHeight)) {
            $newHeight = $this->_imageObj->height;
        }

		if ($ratio) {
            if ($newWidth < $this->_imageObj->width && $newHeight < $this->_imageObj->height) {
                $isLarge = false;
            }
            
            if ($newWidth >= $this->_imageObj->width || $newHeight >= $this->_imageObj->height) {
                $isLarge = true;
            }

			if($isLarge){
				if ($newWidth >= $this->_imageObj->width) {
					$x = ($newWidth / $this->_imageObj->width);
					$newHeight = ($this->_imageObj->height * $x);
				}
				elseif ($newHeight >= $this->_imageObj->height){
					$x = ($newHeight / $this->_imageObj->height);
					$newWidth = ($this->_imageObj->width * $x);
				}
			}
            else {
				if ($newWidth > $newHeight) {
					$x = ($this->_imageObj->width / $newWidth);
					$newHeight = ($this->_imageObj->height / $x);
				}
                else {
					$x = ($this->_imageObj->height / $newHeight);
					$newWidth = ($this->_imageObj->width / $x);
				}
			}
		}

		// New Temp Image
		$this->_newImageIdentifier = \imagecreatetruecolor($newWidth, $newHeight);

        $newImage = call_user_func('\\'.$this->_imageCreateFunc, $this->imageTempName);
		
        if ($keepTransparency ) {
            $this->keepTransparency($newImage, $newWidth, $newHeight);
        }
        
		\imagecopyresampled($this->_newImageIdentifier, $newImage, 0, 0, 0, 0, $newWidth, $newHeight, 
            $this->_imageObj->width, $this->_imageObj->height);
		
        return true;
	}

    private function keepTransparency($newImage, $newWidth, $newHeight) {
        if ($this->_imageObj->mime == IMAGETYPE_GIF || $this->_imageObj->mime == IMAGETYPE_PNG) {
            $transparency = imagecolortransparent($newImage);
            $palletsize = imagecolorstotal($newImage);

            if ($transparency >= 0 && $transparency < $palletsize) {
                $transparentColor = imagecolorsforindex($image, $transparency);
                $transparency = imagecolorallocate($this->_newImageIdentifier, $transparentColor['red'], 
                    $transparentColor['green'], $transparentColor['blue']);
                imagefill($this->_newImageIdentifier, 0, 0, $transparency);
                imagecolortransparent($this->_newImageIdentifier, $transparency);
            }

            elseif ($this->_imageObj->mime == IMAGETYPE_PNG) {
                imagealphablending($this->_newImageIdentifier, false);
                $bgColor = imagecolorallocatealpha($this->_newImageIdentifier, 0, 0, 0, 127);
                imagefill($this->_newImageIdentifier, 0, 0, $bgColor);
                //$bgColor = imagecolorallocatealpha($this->_newImageIdentifier, 255, 255, 255, 127);
                //imagefilledrectangle($this->_newImageIdentifier, 0, 0, $newWidth, $newHeight, $bgColor);
                imagesavealpha($this->_newImageIdentifier, true);
            }
        }
    }

    public function save($savePath, $newImageName = null, $keepImageTempName = false, 
        $quality = 80, $permissions = null) {

		if (!empty($newImageName)) {
		    $newName = $newImageName;
		}
		elseif ($keepImageTempName) {
		    $newName = Utilities\File::cleanName(basename($this->imageTempName)) . '_resized';
		}
        else {
            $newName = Utilities\File::genDateTimeName();
        }

        $newName = sprintf('%s.%s', $newName, $this->_imageObj->extension);

        $savePath = realpath($savePath);
        if (empty($savePath)) throw new \Exception('Save path is not valid.');

        $savePath = $savePath.DS.$newName;

        if ($this->_imageObj->mime == IMAGETYPE_JPEG) {
            $process = call_user_func('\\'.$this->_imageSaveFunc, $this->_newImageIdentifier, 
                            $savePath, $quality);
        }
        elseif ($this->_imageObj->mime == IMAGETYPE_PNG) {
            $quality = 9 - (int) ((0.9 * $quality) / 10.0);
            $process = call_user_func('\\'.$this->_imageSaveFunc, $this->_newImageIdentifier, 
                            $savePath, $quality);
        }
        else {
            $process = call_user_func('\\'.$this->_imageSaveFunc, $this->_newImageIdentifier, 
                            $savePath);
        }
        
        if(empty($permissions) == false) {
            chmod($savePath, $permissions);
        }
        
        // if (DEBUG) return ['result' => $process, 'newPath' => $savePath];

        return $newName;
    }

    public function __destruct() {
        if(isset($this->_newImageIdentifier))
            \imagedestroy($this->_newImageIdentifier);
    }
}