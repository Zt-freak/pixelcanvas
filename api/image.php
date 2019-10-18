<?php
header("Content-type: image/png");

$json = file_get_contents("../data/data.json");
$data = json_decode($json, true);
$colour = [[]];

$canvas = imagecreatetruecolor( 500, 500 );
imagealphablending($canvas, true);
imagesavealpha($canvas, true);
imagefill($canvas,0,0,0x7fff0000);


for ($x = 0; $x < 50; $x++) {
    for ($y = 0; $y < 50; $y++) {
        $trimmedHex = ltrim($data["grid"][$x][$y][0], '#');
        $splittedHex = str_split($trimmedHex, 2);

        $red = hexdec($splittedHex[0]);
        $green = hexdec($splittedHex[1]);
        $blue = hexdec($splittedHex[2]);

        $colour[$x][$y] = imagecolorallocate( $canvas, $red, $green, $blue );
        imagerectangle($canvas, ($y*10), ($x*10), ($y*10+10), ($x*10+10), $colour[$x][$y]);
        imagefill($canvas, ($y*10+1), ($x*10+1), $colour[$x][$y]);
    }
}


imagepng( $canvas );



for ($x = 0; $x < 50; $x++) {
    for ($y = 0; $y < 50; $y++) {
        imagecolordeallocate( $colour[$x][$y] );
    }
}

imagedestroy( $canvas );
?>