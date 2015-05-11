<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta content="IE=edge" http-equiv="X-UA-Compatible">
	<meta content="width=device-width, initial-scale=1" name="viewport">
	<meta name="language" content="ru" />
	<title><?=CHtml::encode($this->pageTitle)?></title>
	<meta content="<?=CHtml::encode($this->description)?>" name="description">
	<meta content="<?=CHtml::encode($this->keywords)?>" name="keywords">
	<link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css" />
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
	<link href="/favico.png" rel="icon">
	<?=(isset($this->pageImg))?
	'<meta property="og:image" content="http://cityquest.ru'.$this->pageImg.'" /><link rel="image_src" href="http://cityquest.ru'.$this->pageImg.'" />'
	:'<meta property="og:image" content="http://cityquest.ru/images/q/3.jpg" /><link rel="image_src" href="http://cityquest.ru/images/q/3.jpg" />'?>

	<meta property="og:title" content="<?=CHtml::encode($this->pageTitle)?>" />
	<meta property="og:url" content="http://cityquest.ru<?=$_SERVER['REQUEST_URI']?>" />
	<meta property="og:description" content="<?=CHtml::encode($this->description)?>" />
	<link rel="alternate" hreflang="ru" href="http://cityquest.ru/" />
	<link rel="alternate" hreflang="x-default" href="http://cityquest.kz/" />
	<script src="/js/jquery.min.js"></script>
</head>