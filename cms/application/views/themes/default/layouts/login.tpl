<!doctype html>
<!--[if lte IE 9]> <html class="lte-ie9" lang="en"> <![endif]-->
<!--[if gt IE 9]><!--> <html lang="en"> <!--<![endif]-->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Remove Tap Highlight on Windows Phone IE -->
    <meta name="msapplication-tap-highlight" content="no"/>

    <link rel="icon" type="image/png" href="{base_url()}public/assets/img/favicon-16x16.png" sizes="16x16">
    <link rel="icon" type="image/png" href="{base_url()}public/assets/img/favicon-32x32.png" sizes="32x32">

    <title>Altair Admin v2.9.1 - Login Page</title>

    <link href='http://fonts.googleapis.com/css?family=Roboto:300,400,500' rel='stylesheet' type='text/css'>

    <!-- uikit -->
    <link rel="stylesheet" href="{base_url()}public/bower_components/uikit/css/uikit.almost-flat.min.css"/>

    <!-- altair admin login page -->
    <link rel="stylesheet" href="{base_url()}public/assets/css/login_page.min.css" />
    <link rel="stylesheet" href="{base_url()}public/assets/css/main.min.css" media="all">

</head>
<body class="login_page">
	<div class="login_page_wrapper">
		{partial('content')}
	</div>

	<!-- common functions -->
    <script src="{base_url()}public/assets/js/common.min.js"></script>
    <!-- uikit functions -->
    <script src="{base_url()}public/assets/js/uikit_custom.min.js"></script>
    <!-- altair core functions -->
    <script src="{base_url()}public/assets/js/altair_admin_common.min.js"></script>
    <!-- custom js -->
	<script src="{base_url()}public/assets/js/custom.js"></script>

    <script>
    	// load parsley config (altair_admin_common.js)
    	altair_forms.parsley_validation_config();
    </script>

</body>
</html>



