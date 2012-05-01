<?php

/**
 * RDS Image is a PHP class to manipulate images
 * 
 * PHP Version 5.3.8
 * 
 * @category Pet_Projects
 * @package  RDSImage
 * @author   Rodrigo dos Santos <falecom@rodrigodossantos.ws>
 * @license  http://www.opensource.org/licenses/bsd-license.php BSD License
 * @link     www.rodrigodossantos.ws
 */

/**
 * RDS Image is a PHP class to manipulate images
 * 
 * @category Pet_Projects
 * @package  RDSImage
 * @author   Rodrigo dos Santos <falecom@rodrigodossantos.ws>
 * @license  http://www.opensource.org/licenses/bsd-license.php BSD License
 * @version  Release: <1.0>
 * @link     www.rodrigodossantos.ws
 */
class RDSImage
{
    protected $sourceImage;
    protected $sourceImageWidth;
    protected $sourceImageHeight;
    protected $sourceImageExtension;
    protected $newWidth;
    protected $newHeight;
    protected $destination;
    protected $waterMark;
    protected $addWaterMark = false;
    protected $addText = false;
    protected $fontSize = 10;
    protected $fontColor = array(255, 255, 255);
    protected $fontName;
    protected $trueTypeFont = false;
    protected $positionX = 20;
    protected $positionY = 20;
    protected $text;

    /**
     * Defines the source image that is going to be used.
     * Also uses the methods setSourceImageExtension to define the image's extension
     * and getSourceImageSize to define the width and height
     * 
     * @param string $image Path to the image
     * 
     * @throws InvalidArgumentException If an unsupported image type is informed
     * 
     * @return void
     */
    public function setSourceImage($image)
    {
        $this->sourceImage = $image;

        $extension = array();

        if (!@preg_match('@\.(jpg|jpeg|png|gif)@', $this->sourceImage, $extension)) {
            throw new InvalidArgumentException('type of image unsupported');
        }

        $this->setSourceImageExtension($extension);
        $this->getSourceImageSize();
    }

    /**
     * Returns the source image's name and path
     * 
     * @return string
     */
    public function getSourceImage()
    {
        return $this->sourceImage;
    }

    /**
     * Gets the source image width and height
     * 
     * @return void 
     */
    protected function getSourceImageSize()
    {
        $src_size = getimagesize($this->sourceImage);
        $this->sourceImageWidth = $src_size[0];
        $this->newWidth = $src_size[0];
        $this->sourceImageHeight = $src_size[1];
        $this->newHeight = $src_size[1];
    }

    /**
     * Set the source image's extension 
     * 
     * @param array $extension result array from preg_match 
     * function called in setSourceImage method
     * 
     * @return void
     */
    protected function setSourceImageExtension($extension)
    {
        $this->sourceImageExtension = $extension[1];
    }

    /**
     * Returns the source image's extension (jpg, gif, png)
     * 
     * @return string
     */
    public function getSourceImageExtension()
    {
        return $this->sourceImageExtension;
    }

    /**
     * Returns the source image's width
     * 
     * @return int
     */
    public function getSourceImageWidth()
    {
        return $this->sourceImageWidth;
    }

    /**
     * Returns the source image's height
     * 
     * @return int
     */
    public function getSourceImageHeight()
    {
        return $this->sourceImageHeight;
    }

    /**
     * Set the new image's width and 
     * calculates the proportional width if only the height is not provided
     * 
     * @param int $width The new image's width (pixels)
     * 
     * @return void
     */
    public function setNewWidth($width)
    {
        $this->newWidth = $width;

        if (!$this->getNewHeight()) {
            $this->newHeight = ( $this->getSourceImageHeight() * $this->newWidth )
                / $this->getSourceImageWidth();
        }
    }

    /**
     * Returns the new image's width
     * 
     * @return type 
     */
    public function getNewWidth()
    {
        return $this->newWidth;
    }

    /**
     * Set the new image's height and
     * calculates the proportional height if only the width is not provided
     * 
     * @param int $height The new image's height (pixels)
     * 
     * @return void;
     */
    public function setNewHeight($height)
    {
        $this->newHeight = $height;

        if (!$this->getNewWidth()) {
            $this->newWidth = ($this->getSourceImageWidth() * $this->newHeight )
                / $this->getSourceImageHeight();
        }
    }

    /**
     * Returns the new image's height
     * 
     * @return mixed;
     */
    public function getNewHeight()
    {
        return $this->newHeight;
    }

    /**
     * Set the destination folder
     * 
     * @param string $destination Destination folder's path
     * 
     * @return void
     */
    public function setDestination($destination)
    {
        $this->destination = $destination;
    }

    /**
     * Returns the destination folder
     * 
     * @return string
     */
    public function getDestination()
    {
        return $this->destination;
    }

    /**
     * Generates the new filename for the image if none is provided
     * and prepends the destination folder to the filename.
     * 
     * @param string $filename The new image's name
     * 
     * @return string 
     */
    private function _generateFileName($filename = null)
    {
        if (!$filename) {
            return $this->getDestination()
                . '/'
                . md5(uniqid(time()))
                . '.'
                . $this->sourceImageExtension;
        }

        return $this->getDestination()
            . '/'
            . $filename
            . '.'
            . $this->sourceImageExtension;
    }

    /**
     * Set the font size to use on the image
     * 
     * @param mixed $fontSize The font size
     * 
     * @return void
     */
    public function setFontSize($fontSize)
    {
        $this->fontSize = $fontSize;
    }

    /**
     * Returns the font size to use on the image
     * 
     * @return mixed
     */
    public function getFontSize()
    {
        return $this->fontSize;
    }

    /**
     * Set the position X and Y for the text to be used on the image
     * 
     * @param int $positionX The position X where the text will be showed
     * @param int $positionY The position Y where the text will be showed
     * 
     * @return void
     */
    public function setPosition($positionX, $positionY)
    {
        $this->positionX = $positionX;
        $this->positionY = $positionY;
    }

    /**
     * Returns the position X
     * 
     * @return int
     */
    public function getPositionX()
    {
        return $this->positionX;
    }

    /**
     * Returns the position Y
     * 
     * @return int
     */
    public function getPositionY()
    {
        return $this->positionY;
    }

    /**
     * Defines the font color in RGB format, where each index represents 
     * a part of the color's code. Ex: array(255, 255,255) is white.
     * For a RGB chart please see http://www.tayloredmktg.com/rgb/
     * 
     * @param array $color Font's color code in RGB format
     * 
     * @return void
     */
    public function setColor(array $color)
    {
        $this->fontColor = $color;
    }

    /**
     * Returns the font color's array in RGB format
     * 
     * @return array
     */
    public function getColor()
    {
        return $this->fontColor;
    }

    /**
     * Define if a true type font is going to be used
     * 
     * @param boolena $flag true or false
     * 
     * @return void
     */
    public function trueTypeFont($flag = true)
    {
        $this->trueTypeFont = $flag;
    }

    /**
     * Is a true type font going to be used?
     * 
     * @return boolean
     */
    public function isTrueTypeFont()
    {
        return $this->trueTypeFont;
    }

    /**
     * Set the font to be used on the image
     * 
     * @param string $font The font name like 'Arial', 'Verdana', etc.
     * 
     * @return void
     */
    public function setFontName($font)
    {
        $this->fontName = $font;
    }

    /**
     * Returns the font to be used on the image
     * 
     * @return string
     */
    public function getFontName()
    {
        return $this->fontName;
    }

    /**
     * Set the text to be written on the image
     * 
     * @param string $text A text or phrase
     * 
     * @return void
     */
    public function setText($text)
    {
        $this->addText = true;
        $this->text = $text;
    }

    /**
     * Returns the text to be written on the image
     * 
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Writes an text to the image
     * 
     * @param string $image The image's path
     * 
     * @return void
     */
    protected function addText($image)
    {
        if ($this->isTrueTypeFont()) {
            imagettftext(
                $image, $this->fontSize, 0, $this->getPositionX(),
                $this->getPositionY(), $this->fontColor, $this->fontName, $this->text
            );
        } else {

            $fontColor = imagecolorallocate(
                $image, $this->fontColor[0], $this->fontColor[1], $this->fontColor[2]
            );

            imagestring(
                $image, $this->fontSize, $this->getPositionX(),
                $this->getPositionY(), $this->text, $fontColor
            );
        }
    }

    /**
     * Sets the watermark's path
     * 
     * @param string $image Path to watermark
     * 
     * @return void
     */
    public function setWaterMark($image)
    {
        $this->addWaterMark = true;
        $this->waterMark = $image;
    }

    /**
     * Return the watermark' path
     * 
     * @return string
     */
    public function getWaterMark()
    {
        return $this->waterMark;
    }

    /**
     * Adds a watermark to the image
     * 
     * @param string $thumb Path to the water mark
     * 
     * @return void 
     */
    protected function addWaterMark($thumb)
    {
        $pathinfo = pathinfo($this->getWaterMark());

        switch (strtolower($pathinfo['extension'])) {
        case 'jpg':
        case 'jpeg':
            $waterMark = imagecreatefromjpeg($this->waterMark);
            break;
        case 'png':
            $waterMark = imagecreatefrompng($this->waterMark);
            break;
        case 'gif':
            $waterMark = imagecreatefromgif($this->waterMark);
            break;
        default:
            break;
        }

        $waterMarkWidth = imagesx($waterMark);
        $waterMarkHeight = imagesy($waterMark);

        imagecopy(
            $thumb, $waterMark, $this->getPositionX(), $this->getPositionY(), 0, 0,
            $waterMarkWidth, $waterMarkHeight
        );
    }

    /**
     * Creates the new image
     * 
     * @param string $filename New image's name
     * 
     * @return string New image's path and name
     * @throws UnexpectedValueException 
     */
    public function create($filename = null)
    {
        $destination = $this->getDestination();

        if (!$destination) {
            throw new UnexpectedValueException(
                'Destination folder has not been informed'
            );
        }

        $extension = ($this->sourceImageExtension == 'jpg') 
        ? 'jpeg' : $this->sourceImageExtension;

        $functions = array(
            'imagecreatefrom' . $extension,
            'image' . $extension,
        );

        $thumbnail = imagecreatetruecolor(
            $this->getNewWidth(), $this->getNewHeight()
        );

        imagecopyresized(
            $thumbnail, $functions[0]($this->sourceImage), 0, 0, 0, 0,
            $this->getNewWidth(), $this->getNewHeight(),
            $this->getSourceImageWidth(), $this->getSourceImageHeight()
        );

        $filename = $this->_generateFileName($filename);


        if ($this->addText) {
            $this->addText($thumbnail);
        }

        if ($this->addWaterMark) {
            $this->addWaterMark($thumbnail);
        }

        switch ($extension) {
        case 'jpeg':
            imagejpeg($thumbnail, $filename, 100);
            break;
        case 'gif':
            imagegif($thumbnail, $filename);
            break;
        case 'png':
            imagepng($thumbnail, $filename, 9);
        default:
            break;
        }

        return $filename;
    }

}