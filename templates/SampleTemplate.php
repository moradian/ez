<html>
<head>
	<title><?= $this->getTitle(); ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=<?= $this->getEncoding(); ?>"/>
</head>
<body>
<?php include_once PATH_TO_VIEWS . $this->getContentFile(); ?>
</body>
</html>

