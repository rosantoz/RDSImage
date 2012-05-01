<?php 
require_once('RDSImage.php');
$image = new RDSImage();
$image->setSourceImage('image.jpg');
$image->setPosition(10,10); // Aqui você informa em que local da imagem a legenda vai aparecer. Sendo que o primeiro parâmetro é a posição X e o segundo á a posição Y
$image->setWaterMark('sample_logo.png'); // Texto da legenda
$image->setDestination('tests/images'); // pasta onde quero salvar a imagem
$image->create();