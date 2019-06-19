<?php
include "autoloader.php";

?>
<head>
	<title>CRM Репетиторы</title>
	<link rel="shortcut icon" href="faviconRep.ico" />
</head>
<body>
	<div class="container">
		<div id="header">	
			<?php include 'views/header.html'; ?>
		</div>
		<div id="container">	
			<?php include 'router.php'; ?>
		</div>
		<div id="footer">	
			<?php include 'views/footer.html'; ?>
		</div>
	</div>
</body>