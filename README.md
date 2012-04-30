RDSImage
=================

RDSImage is a PHP class that can be used to manipulate image. It helps you
to resize images, to write a text to an image and to add watermark.

It supports .jpg, .gif and .png images

Example 1 - Resizing an image with defined width and height
==========

```
$image = new RDSImage();
$image->setSourceImage('image.jpg');
$image->setNewWidth(50);
$image->setNewHeight(50);
$image->setDestination('destinationfolder');
$image->create();
```

Example 2 - Resizing an image giving only the width
==========

In this case the class will calculate the proportional height

```
$image = new RDSImage();
$image->setSourceImage('image.jpg');
$image->setNewWidth(100);
$image->setDestination('destinationfolder');
$image->create();
```

Example 3 - Resizing an image giving only the height
==========

In this case the class will calculate the proportional width

```
$image = new RDSImage();
$image->setSourceImage('image.jpg');
$image->setNewHeight(200);
$image->setDestination('destinationfolder');
$image->create();
```

Example 4 - Writing an text to the image
==========

You may want to use the setPosition method to tell where to write the image.
The first parameter is the X position and the second the Y position. You also 
can use the setColor method to change the text color

```
$image = new RDSImage();
$image->setSourceImage($sourceImage);
$image->setPosition(10,10) // optional
$image->setText('Hello World!');
$image->setDestination('tests/images');
$image->create();
```

Example 5 - Watermark
==========

Just use the method setWaterMark to inform the watermark location. Use the 
setPosition method to tell where to put the watermark

```
$image = new RDSImage();
$image->setSourceImage($sourceImage);
$image->setPosition(10,10) // optional
$image->setWaterMark('mylogo.png');
$image->setDestination('tests/images');
$image->create();
```