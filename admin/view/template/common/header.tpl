<!DOCTYPE html>
<html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>">
<head>
<meta charset="UTF-8" />
<title><?php echo $title; ?></title>
<base href="<?php echo $base; ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">


<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css" rel="stylesheet">
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
			<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->


<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" type="text/css" rel="stylesheet" />
<link type="text/css" href="view/stylesheet/stylesheet.css" rel="stylesheet" media="screen" />
<link href="https://cdn.rawgit.com/maechabin/bootstrap-material-button-color/master/dist/cb-materialbtn.0.5.5.min.css" type="text/css" rel="stylesheet" />

<!--script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
<!-- link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css" -->
<!--script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script -->
<link rel="stylesheet" href="https://unpkg.com/flatpickr/dist/flatpickr.min.css">
<script src="https://unpkg.com/flatpickr"></script>
<!-- script src="https://npmcdn.com/flatpickr/dist/l10n/ja.js"></script -->
<script src="view/javascript/common.js" type="text/javascript"></script>

</head>
<body>
<div id="container">
<header id="header" class="navbar navbar-static-top">
	<?php if ($logged) { ?>
  	<div class="navbar-header">
    	<a type="button" id="button-menu" class="pull-left"><i class="fa fa-indent fa-lg"></i></a>
    	<a href="<?php echo $home; ?>" class="navbar-brand"></a>
		</div>
		<ul class="nav pull-left">
			<li><a href="<?php echo $home; ?>"><span class="hidden-xs hidden-sm hidden-md"> <i class="fa fa-home fa-lg"></i> <?php echo $text_homepage; ?></span></a></li>
    </ul>
  	<ul class="nav pull-right">
			<li><p class="navbar-text"><i class="fa fa-pencil fa-lg"><?php echo $login_name;?></i></p></li>
    	<li><a href="<?php echo $logout; ?>"><span class="hidden-xs hidden-sm hidden-md"><?php echo $text_logout; ?></span> <i class="fa fa-sign-out fa-lg"></i></a></li>
  	</ul>
  <?php } ?>
</header>
