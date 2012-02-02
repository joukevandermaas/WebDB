<?php include_once("tools/helperfuncs.php"); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
<!-- deze pagina gebruikt als enige een andere css, namelijk homepagecss.css -->
<link rel="stylesheet" type="text/css" href="homepagecss.css">
<!-- print de website naam die als variable voor de beheerder word opgeslagen -->
<title><?php echo $websiteName; ?></title>
</head>
<body>
<h2><?php echo $websiteName; ?></h2>
<!-- de 3 verschillende knoppen om je door de site te navigeren -->
<ul>
<li><a href="programlist.php?level=3" class="bachelor"> <span><img src="img/pic2.png" alt="Bacheloropleidingen"></span></a></li>
<li><a href="programlist.php?level=4" class="master"><span><img src="img/pic1.png" alt="Masteropleidingen"></span></a></li>
<li><a href="organizations.php" class="orgs"><span><img src="img/pic3.png" alt="Instellingen"></span></a></li>
</ul>

</body>

</html>
