<?

function ResizeImage(&$image,$new_width,$new_height)
	{
		$width = imagesx ($image)-1;
		$height = imagesy ($image)-1;
		$image_p = imagecreatetruecolor($new_width, $new_height);
		imagecopyresampled($image_p, $image, 0, 0,0,0, $new_width, $new_height, $width, $height);
		return $image_p;
	}
$TMP = "12345678900987y6t5r4e3w21wserahdblkjasfksjdnfkb.jpg";
	header('Content-type: image/jpg'); // ������������� ��� ��������� - "����������� � ������� PNG".
	$image = imagecreatefromjpeg($TMP) // ������� �����������...
	or die('Cannot create image');     // ...��� ��������� ������ ������� � ������ ������
	$w = imagesx ($image)-1;
	$h = imagesy ($image)-1;
	imagejpeg (ResizeImage($image,floor(120*$h/$w),120));
	
?>