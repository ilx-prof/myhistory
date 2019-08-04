<?php
$data = 'iVBORw0KGgoAAAANSUhEUgAAABwAAAASCAMAAAB/2U7WAAAABl'
       . 'BMVEUAAAD///+l2Z/dAAAASUlEQVR4XqWQUQoAIAxC2/0vXZDr'
       . 'EX4IJTRkb7lobNUStXsB0jIXIAMSsQnWlsV+wULF4Avk9fLq2r'
       . '8a5HSE35Q3eO2XP1A1wQkZSgETvDtKdQAAAABJRU5ErkJggg==';

//var_dump ( $data ) ."\n";


$file = "untitled.JPG";

$fp = fopen ( $file, "rb" );
$data = fread ( $fp, filesize ( $file ) );
fclose ( $fp );

$data = base64_decode ( base64_encode ( $data ) );

//var_dump ( $data );

$image = imagecreatefromstring ( $data );
if ( $image !== false )
{
	header ( 'Content-Type: image/png' );
	ImagePNG ( $image );
}
else
{
	echo 'An error occured.';
}



?>
