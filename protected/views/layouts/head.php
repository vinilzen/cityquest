<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta content="IE=edge" http-equiv="X-UA-Compatible">
	<meta content="width=device-width, initial-scale=1" name="viewport">
	<meta name="language" content="ru" />
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
	<meta content="<?php echo CHtml::encode($this->pageTitle); ?>" name="description">
	<link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css" />
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
	<link href="/favico.png" rel="icon">
	<?php if (isset($this->pageImg)) {
		echo '<meta property="og:image" content="http://cityquest.ru'.$this->pageImg.'" /><link rel="image_src" href="http://cityquest.ru'.$this->pageImg.'" />';
	} else {
		echo '<meta property="og:image" content="http://cityquest.ru/images/q/3.jpg" /><link rel="image_src" href="http://cityquest.ru/images/q/3.jpg" />';
	} ?>

	<meta property="og:title" content="<?php echo CHtml::encode($this->pageTitle); ?>" />
	<meta property="og:url" content="http://cityquest.ru<?php echo $_SERVER['REQUEST_URI'] ?>" />
	<meta property="og:description" content="<?php echo CHtml::encode($this->pageTitle); ?>" />

</head>