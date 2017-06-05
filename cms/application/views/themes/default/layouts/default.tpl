<!doctype html>
<!--[if lte IE 9]> <html class="lte-ie9" lang="en"> <![endif]-->
<!--[if gt IE 9]><!--> <html lang="en"> <!--<![endif]-->

<!-- BEGIN HEAD -->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Remove Tap Highlight on Windows Phone IE -->
    <meta name="msapplication-tap-highlight" content="no"/>

    <link rel="icon" type="image/png" href="{base_url()}public/assets/img/favicon-16x16.png" sizes="16x16">
    <link rel="icon" type="image/png" href="{base_url()}public/assets/img/favicon-32x32.png" sizes="32x32">

    <title>{$title}</title>


    <!-- uikit -->
    <link rel="stylesheet" href="{base_url()}public/bower_components/uikit/css/uikit.almost-flat.min.css" media="all">

    <!-- flag icons -->
    <!--<link rel="stylesheet" href="{base_url()}assets/icons/flags/flags.min.css" media="all">-->

    <!-- style switcher -->
    <!--<link rel="stylesheet" href="{base_url()}assets/css/style_switcher.min.css" media="all">-->
    
    <!-- altair admin -->
    <link rel="stylesheet" href="{base_url()}public/assets/css/main.min.css" media="all">

    <!-- themes -->
    <link rel="stylesheet" href="{base_url()}public/assets/css/themes/themes_combined.min.css" media="all">

    <!-- matchMedia polyfill for testing media queries in JS -->
    <!--[if lte IE 9]>
        <script type="text/javascript" src="bower_components/matchMedia/matchMedia.js"></script>
        <script type="text/javascript" src="bower_components/matchMedia/matchMedia.addListener.js"></script>
        <link rel="stylesheet" href="assets/css/ie.css" media="all">
    <![endif]-->

    <!-- BEGIN PAGE LEVEL STYLES -->

	{partial('header')}

	<!-- END PAGE LEVEL STYLES -->

</head>
<!-- END HEAD -->

<!-- BEGIN BODY -->
<body class="sidebar_main_swipe footer_active">

	<!-- BEGIN MAIN HEADER -->
    <header id="header_main">
        <div class="header_main_content">
            <nav class="uk-navbar">
                                
                <!-- main sidebar switch -->
                <a href="#" id="sidebar_main_toggle" class="sSwitch sSwitch_left">
                    <span class="sSwitchIcon"></span>
                </a>
                
                <div class="uk-navbar-flip">
                    <ul class="uk-navbar-nav user_actions">
                        <li data-uk-dropdown="{ mode:'click',pos:'bottom-right' }">
                            <a href="javascript:;" class="user_action_image"><img class="md-user-image" src="{base_url()}public/assets/img/avatars/avatar_11_tn@4x.png" alt=""/></a>
                            <div class="uk-dropdown uk-dropdown-small">
                                <ul class="uk-nav js-uk-prevent">
                                    <li><a href="javascript:;" class="open-modal-2" data-url="{base_url('public/users/edit/')}{$this->session->userdata('user_id')}">My profile</a></li>
                                    <li><a href="{base_url()}public/users/logout">Logout</a></li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>

        
    </header>
    <!-- END MAIN HEADER -->

    <!-- BEGIN MAIN SIDEBAR -->
    <aside id="sidebar_main">
        
        <div class="sidebar_main_header">
            <div class="sidebar_logo">
                <a href="{base_url()}public/" class="sSidebar_hide sidebar_logo_large">
                	<!--
                    <img class="logo_regular" src="{base_url()}public/assets/img/logo_main.png" alt="" height="15" width="71"/>
                    <img class="logo_light" src="{base_url()}public/assets/img/logo_main_white.png" alt="" height="15" width="71"/>
                	-->
                	<h3 class="">ELEOS</h3>
                </a>
                <a href="{base_url()}public/" class="sSidebar_show sidebar_logo_small">
                    <h3 class="">E</h3>
                </a>
            </div>
        </div>
        
        <div class="menu_section">
            {partial('navigation')}
        </div>
    </aside>
    <!-- END MAIN SIDEBAR -->

    <!-- BEGIN PAGE CONTENT -->
    <div id="page_content">

    	{partial('content')}
        
    </div>
    <!-- END PAGE CONTENT -->

    <!-- BEGIN MODAL AJAX -->
    <div class="uk-modal uk-modal-card-fullscreen ajax-modal-2">
	<div class="uk-modal-dialog uk-modal-dialog-blank">
	   		<div class="md-card uk-height-viewport">
	   			<div class="md-card-toolbar">
		            <div class="uk-float-right">
		                <a href="javascript:;" class="uk-modal-close"><i class="md-icon material-icons">&#xE14C;</i></a>
		            </div>
		            <span class="md-icon material-icons uk-modal-close">&#xE5C4;</span>
		        </div>  
	   			<div class="md-card-content uk-vertical-align uk-text-center">
	   					<img src="{base_url()}public/assets/img/spinners/spinner.gif" class="uk-vertical-align-middle" alt="" width="32" height="32">
	   			</div>
	   		</div>
	    </div>
	</div>
	<!-- END MODAL AJAX -->

	<!-- BEGIN FOOTER -->
	<footer id="footer">
	    &copy; 2017 Eleos, All rights reserved. Page rendered in <strong>{elapsed_time()}</strong> seconds.
	</footer>
	
	<!-- END FOOTER -->

	<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
	<!-- GOOGLE WEB FONTS -->
    <script>
    	var base_url = "{base_url()}public/";

    	{literal}
        WebFontConfig = {
            google: {
                families: [
                    'Source+Code+Pro:400,700:latin',
                    'Roboto:400,300,500,700,400italic:latin'
                ]
            }
        };
        (function() {
            var wf = document.createElement('script');
            wf.src = ('https:' == document.location.protocol ? 'https' : 'http') +
            '://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
            wf.type = 'text/javascript';
            wf.async = 'true';
            var s = document.getElementsByTagName('script')[0];
            s.parentNode.insertBefore(wf, s);
        })();
        {/literal}
     </script>

	<!-- BEGIN CORE PLUGINS -->

	<!-- common functions -->
    <script src="{base_url()}public/assets/js/common.min.js"></script>
    <!-- uikit functions -->
    <script src="{base_url()}public/assets/js/uikit_custom.min.js"></script>
    <!-- altair common functions/helpers -->
    <script src="{base_url()}public/assets/js/altair_admin_common.min.js"></script>
    <!-- custom js -->
	<script src="{base_url()}public/assets/js/custom.js"></script>

    <!-- END CORE PLUGINS -->
    <script>
    	// load parsley config (altair_admin_common.js)
    	altair_forms.parsley_validation_config();
    </script>

	{partial('footer')}

	<script type="text/javascript">
		{literal}
	    $(document).ready(function(){

	        var url = window.location.href;
	        $('ul.navku li').each(function(){
	                if($(this).hasClass('act_item'))
	                {
	                    $(this).removeClass('act_item');
	                    //alert('tes');
	                }

	                if($(this).hasClass('current_section'))
	                {
	                    $(this).removeClass('current_section');
	                    //alert('tes');
	                }
	        });


	        var link = $('ul.navku li a').filter(function() {
	        	return this.href == url;
	        });

	        if( link.parents('li').parents('li').length > 0 )
	        {
	            link.parents('li').parents('li').addClass('current_section');
	            link.parents('li').addClass('act_item');
	            //link.parent().parent().parent().addClass('active');
	        }
	        else
	        {
	            link.parents('li').addClass('current_section');
	        }



	    });
		{/literal}

		{literal}
        $(function() {
            if(isHighDensity()) {
                $.getScript( base_url+"bower_components/dense/src/dense.js", function() {
                    // enable hires images
                    altair_helpers.retina_images();
                });
            }
            if(Modernizr.touch) {
                // fastClick (touch devices)
                FastClick.attach(document.body);
            }
        });
        $window.load(function() {
            // ie fixes
            altair_helpers.ie_fix();
        });
        {/literal}
    </script>

</body>
<!-- END BODY -->
</html>