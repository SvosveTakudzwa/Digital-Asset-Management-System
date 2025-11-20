<?php
$id = $_GET['qrcode'];
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>QR Viewer</title>
</head>
<body>
	<style type="text/css">
		img.center{
			 
			  display: block;
			  margin-left: auto;
			  margin-right: auto;
			  width: 50%;
			}
		
	</style>
	<img src='./qrcodes/<?php echo $id; ?>' alt="Asset Card QR Code" class="center">
</body>
</html>