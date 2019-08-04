<?php
header("Content-type: image/gif");
$img =ImageCreateFromGIF("M.gif");
$balck=ImageColorAllocate($img,0,0,0);
$yellow=ImageColorAllocate($img, 255, 255,0);
$white=ImageColorAllocate($img,255,255,255);
ImageFill($img, 1, 1, $black);
ImageString($img, 2, 6, 10, "1 000 000", $yellow);
ImageGIF($img);
ImageDestroy($img);
?>
