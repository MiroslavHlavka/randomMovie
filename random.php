<!doctype html>

<html lang="en">
<head>
  <meta charset="utf-8">

  <title>Ivany Random Generator</title>
  <meta name="description" content="The HTML5 Herald">
  <meta name="author" content="SitePoint">

  <link rel="stylesheet" href="css/styles.css?v=1.0">

  <!--[if lt IE 9]>
  <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->
</head>

<body>
<h1>Ivany Random Generator</h1>

<?php
$number = rand(1, 420000);
$better = rand(1, 2000);
echo "<a href='http://www.csfd.cz/film/".$number."'>Link to random movie (Hardcore)</a><br>";
echo "<a href='http://www.csfd.cz/film/".$better."'>Link to random movie (Popular)</a>";
?>
<br>
<input type="button" value="Random" onClick="window.location.reload()">




</body>
</html>