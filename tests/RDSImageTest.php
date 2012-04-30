<?php

require_once '../RDSImage.php';

class RsCorreiosTest extends PHPUnit_Framework_TestCase
{

    protected $RDSImage;
    protected $sourceImage;

    protected function setUp()
    {
        $this->RDSImage = new RDSImage();
        $this->sourceImage = '../image.jpg';
        parent::setUp();
    }

    protected function tearDown()
    {
        if (file_exists('images/image1.jpg')) {
            unlink('images/image1.jpg');
        }
        parent::tearDown();
    }

    /**
     * @test
     */
    public function verifySourceImageGetterAndSetter()
    {
        $this->RDSImage->setSourceImage($this->sourceImage);
        $this->assertEquals($this->sourceImage, $this->RDSImage->getSourceImage());
    }

    /**
     * @test 
     */
    public function verifySourceImageSizeGetter()
    {
        $this->RDSImage->setSourceImage($this->sourceImage);
        $this->assertEquals(600, $this->RDSImage->getSourceImageWidth());
        $this->assertEquals(400, $this->RDSImage->getSourceImageHeight());
    }

    /**
     * @test 
     */
    public function verifyNewWidthGetterAndSetter()
    {
        $this->RDSImage->setSourceImage($this->sourceImage);
        $this->RDSImage->setNewWidth('100');
        $this->assertEquals('100', $this->RDSImage->getNewWidth());
    }

    /**
     * @test 
     */
    public function verifyNewHeightGetterAndSetter()
    {
        $this->RDSImage->setSourceImage($this->sourceImage);
        $this->RDSImage->setNewHeight('200');
        $this->assertEquals('200', $this->RDSImage->getNewHeight());
    }

    /**
     * @test 
     */
    public function verifyDestinationGetterAndSetter()
    {
        $this->RDSImage->setDestination('../images/');
        $this->assertEquals('../images/', $this->RDSImage->getDestination());
    }

    /**
     * @test 
     */
    public function verifySourceImageExtensionGetterAndSetter()
    {
        $this->RDSImage->setSourceImage($this->sourceImage);
        $this->assertEquals('jpg', $this->RDSImage->getSourceImageExtension());
    }

    /**
     * @test
     * @expectedException InvalidArgumentException 
     */
    public function verifySourceImageExtensionInvalidArgumentException()
    {
        $this->RDSImage->setSourceImage('invalidImage.psd');
    }

    /**
     * @test
     * @expectedException UnexpectedValueException 
     */
    public function verifyIfTheDestinationFolderHasBeenInformed()
    {
        $this->RDSImage->setSourceImage($this->sourceImage);
        $this->RDSImage->create();
    }

    /**
     * @test  
     */
    public function verifyIfTheNewFileNameIsCreated()
    {
        $this->RDSImage->setSourceImage($this->sourceImage);
        $this->RDSImage->setDestination('images');
        $this->RDSImage->setNewWidth('100');
        $this->RDSImage->setNewHeight('100');
        $newFile = $this->RDSImage->create('image1');
        $this->assertEquals($newFile, 'images/image1.jpg');
    }

    /**
     * @test  
     */
    public function verifyIfANewImageWithFixedWidthAndFixedHeightIsCreated()
    {
        $this->RDSImage->setSourceImage($this->sourceImage);
        $this->RDSImage->setDestination('images');
        $this->RDSImage->setNewWidth('100');
        $this->RDSImage->setNewHeight('80');
        $newFile = $this->RDSImage->create('image1');

        $newImageSize = getimagesize($newFile);

        $this->assertEquals('100', $newImageSize[0]);
        $this->assertEquals('80', $newImageSize[1]);
    }

    /**
     * @test
     */
    public function verifyIfANewImageIsCreatedWithProportionalHeight()
    {
        $this->RDSImage->setSourceImage($this->sourceImage);
        $this->RDSImage->setDestination('images');
        $this->RDSImage->setNewWidth('300');
        $newFile = $this->RDSImage->create('image1');
        $newImageSize = getimagesize($newFile);
        $this->assertEquals('300', $newImageSize[0]);
        $this->assertEquals('200', $newImageSize[1]);
    }

    /**
     * @test
     */
    public function verifyIfANewImageIsCreatedWithProportionalWidth()
    {
        $this->RDSImage->setSourceImage($this->sourceImage);
        $this->RDSImage->setDestination('images');
        $this->RDSImage->setNewHeight('100');
        $newFile = $this->RDSImage->create('image1');
        $newImageSize = getimagesize($newFile);
        $this->assertEquals('100', $newImageSize[1]);
        $this->assertEquals('150', $newImageSize[0]);
    }

    /**
     * @test 
     */
    public function verifyTextFontSizeGetterAndSetter()
    {
        $fontSize = 14;
        $this->RDSImage->setFontSize($fontSize);
        $this->assertEquals($fontSize, $this->RDSImage->getFontSize());
    }

    /**
     * @test 
     */
    public function verifyTextPositionXGetterAndSetter()
    {
        $positionX = 30;
        $positionY = 15;
        $this->RDSImage->setPosition($positionX, $positionY);
        $this->assertEquals($positionX, $this->RDSImage->getPositionX());
        $this->assertEquals($positionY, $this->RDSImage->getPositionY());
    }

    /**
     * @test 
     */
    public function verifyFontColorGetterAndSetter()
    {
        $color = array(255, 255, 0); // yellow

        $this->RDSImage->setColor($color);
        $result = $this->RDSImage->getColor();

        $this->assertEquals($color[0], $result[0]);
        $this->assertEquals($color[1], $result[1]);
        $this->assertEquals($color[2], $result[2]);
    }

    /**
     * @test 
     */
    public function verifyTrueTypeFontGetterAndSetter()
    {
        $this->RDSImage->trueTypeFont(false);
        $this->assertFalse($this->RDSImage->isTrueTypeFont());

        $this->RDSImage->trueTypeFont(true);
        $this->assertTrue($this->RDSImage->isTrueTypeFont());
    }

    /**
     * @test 
     */
    public function verifyFontNameSizeGetterAndSetter()
    {
        $fontName = 'Arial';
        $this->RDSImage->setFontName($fontName);
        $this->assertEquals($fontName, $this->RDSImage->getFontName());
    }

    /**
     * @test 
     */
    public function verifyTextGetterAndSetter()
    {
        $text = 'Hello World';
        $this->RDSImage->setText($text);
        $this->assertEquals($text, $this->RDSImage->getText());
    }

    /**
     * @test 
     */
    public function verifyWaterMarkGetterAndSetter()
    {
        $waterMark = '../sample_logo.png';
        $this->RDSImage->setWaterMark($waterMark);
        $this->assertEquals($waterMark, $this->RDSImage->getWaterMark());
    }

}