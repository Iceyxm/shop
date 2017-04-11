<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>

<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->

<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->

<!--[if !IE]><!--> <html lang="en" class="no-js"> <!--<![endif]-->

<!-- BEGIN HEAD -->

<head>

    <meta charset="utf-8" />

    <title>Metronic | Admin Dashboard Template</title>

    <meta content="width=device-width, initial-scale=1.0" name="viewport" />

    <meta content="" name="description" />

    <meta content="" name="author" />

    <!-- BEGIN GLOBAL MANDATORY STYLES -->

    <link href="<?php echo C('ADMIN_CSS_PATH');?>bootstrap.min.css" rel="stylesheet" type="text/css"/>

    <link href="<?php echo C('ADMIN_CSS_PATH');?>bootstrap-responsive.min.css" rel="stylesheet" type="text/css"/>

    <link href="<?php echo C('ADMIN_CSS_PATH');?>font-awesome.min.css" rel="stylesheet" type="text/css"/>

    <link href="<?php echo C('ADMIN_CSS_PATH');?>style-metro.css" rel="stylesheet" type="text/css"/>

    <link href="<?php echo C('ADMIN_CSS_PATH');?>style.css" rel="stylesheet" type="text/css"/>

    <link href="<?php echo C('ADMIN_CSS_PATH');?>style-responsive.css" rel="stylesheet" type="text/css"/>

    <link href="<?php echo C('ADMIN_CSS_PATH');?>default.css" rel="stylesheet" type="text/css" id="style_color"/>

    <link href="<?php echo C('ADMIN_CSS_PATH');?>uniform.default.css" rel="stylesheet" type="text/css"/>

    <!-- END GLOBAL MANDATORY STYLES -->

    <!-- BEGIN PAGE LEVEL STYLES -->


    <!-- END PAGE LEVEL STYLES -->

    <link rel="shortcut icon" href="<?php echo C('ADMIN_IMAGE_PATH');?>favicon.ico" />

</head>

<!-- END HEAD -->

<!-- BEGIN BODY -->

<body class="page-header-fixed">

<!-- BEGIN HEADER -->

<div class="header navbar navbar-inverse navbar-fixed-top">

    <!-- BEGIN TOP NAVIGATION BAR -->

    <div class="navbar-inner">

        <div class="container-fluid">

            <!-- BEGIN LOGO -->

            <a class="brand" href="index.html">

                <img src="<?php echo C('ADMIN_IMAGE_PATH');?>logo.png" alt="logo"/>

            </a>

            <!-- END LOGO -->

            <!-- BEGIN RESPONSIVE MENU TOGGLER -->

            <a href="javascript:;" class="btn-navbar collapsed" data-toggle="collapse" data-target=".nav-collapse">

                <img src="<?php echo C('ADMIN_IMAGE_PATH');?>menu-toggler.png" alt="" />

            </a>

            <!-- END RESPONSIVE MENU TOGGLER -->

            <!-- BEGIN TOP NAVIGATION MENU -->

            <ul class="nav pull-right">

                <!-- BEGIN NOTIFICATION DROPDOWN -->

                <li class="dropdown" id="header_notification_bar">

                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">

                        <i class="icon-warning-sign"></i>

                        <span class="badge">6</span>

                    </a>

                    <ul class="dropdown-menu extended notification">

                        <li>

                            <p>You have 14 new notifications</p>

                        </li>

                        <li>

                            <a href="#">

                                <span class="label label-success"><i class="icon-plus"></i></span>

                                New user registered.

                                <span class="time">Just now</span>

                            </a>

                        </li>

                        <li>

                            <a href="#">

                                <span class="label label-important"><i class="icon-bolt"></i></span>

                                Server #12 overloaded.

                                <span class="time">15 mins</span>

                            </a>

                        </li>

                        <li>

                            <a href="#">

                                <span class="label label-warning"><i class="icon-bell"></i></span>

                                Server #2 not respoding.

                                <span class="time">22 mins</span>

                            </a>

                        </li>

                        <li>

                            <a href="#">

                                <span class="label label-info"><i class="icon-bullhorn"></i></span>

                                Application error.

                                <span class="time">40 mins</span>

                            </a>

                        </li>

                        <li>

                            <a href="#">

                                <span class="label label-important"><i class="icon-bolt"></i></span>

                                Database overloaded 68%.

                                <span class="time">2 hrs</span>

                            </a>

                        </li>

                        <li>

                            <a href="#">

                                <span class="label label-important"><i class="icon-bolt"></i></span>

                                2 user IP blocked.

                                <span class="time">5 hrs</span>

                            </a>

                        </li>

                        <li class="external">

                            <a href="#">See all notifications <i class="m-icon-swapright"></i></a>

                        </li>

                    </ul>

                </li>

                <!-- END NOTIFICATION DROPDOWN -->

                <!-- BEGIN INBOX DROPDOWN -->

                <li class="dropdown" id="header_inbox_bar">

                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">

                        <i class="icon-envelope"></i>

                        <span class="badge">5</span>

                    </a>

                    <ul class="dropdown-menu extended inbox">

                        <li>

                            <p>You have 12 new messages</p>

                        </li>

                        <li>

                            <a href="inbox.html?a=view">

                                <span class="photo"><img src="<?php echo C('ADMIN_IMAGE_PATH');?>avatar2.jpg" alt="" /></span>

                                <span class="subject">

								<span class="from">Lisa Wong</span>

								<span class="time">Just Now</span>

								</span>

                                <span class="message">

								Vivamus sed auctor nibh congue nibh. auctor nibh

								auctor nibh...

								</span>

                            </a>

                        </li>

                        <li>

                            <a href="inbox.html?a=view">

                                <span class="photo"><img src="./<?php echo C('ADMIN_IMAGE_PATH');?>avatar3.jpg" alt="" /></span>

                                <span class="subject">

								<span class="from">Richard Doe</span>

								<span class="time">16 mins</span>

								</span>

                                <span class="message">

								Vivamus sed congue nibh auctor nibh congue nibh. auctor nibh

								auctor nibh...

								</span>

                            </a>

                        </li>

                        <li>

                            <a href="inbox.html?a=view">

                                <span class="photo"><img src="./<?php echo C('ADMIN_IMAGE_PATH');?>avatar1.jpg" alt="" /></span>

                                <span class="subject">

								<span class="from">Bob Nilson</span>

								<span class="time">2 hrs</span>

								</span>

                                <span class="message">

								Vivamus sed nibh auctor nibh congue nibh. auctor nibh

								auctor nibh...

								</span>

                            </a>

                        </li>

                        <li class="external">

                            <a href="inbox.html">See all messages <i class="m-icon-swapright"></i></a>

                        </li>

                    </ul>

                </li>

                <!-- END INBOX DROPDOWN -->

                <!-- BEGIN TODO DROPDOWN -->

                <li class="dropdown" id="header_task_bar">

                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">

                        <i class="icon-tasks"></i>

                        <span class="badge">5</span>

                    </a>

                    <ul class="dropdown-menu extended tasks">

                        <li>

                            <p>You have 12 pending tasks</p>

                        </li>

                        <li>

                            <a href="#">

								<span class="task">

								<span class="desc">New release v1.2</span>

								<span class="percent">30%</span>

								</span>

                                <span class="progress progress-success ">

								<span style="width: 30%;" class="bar"></span>

								</span>

                            </a>

                        </li>

                        <li>

                            <a href="#">

								<span class="task">

								<span class="desc">Application deployment</span>

								<span class="percent">65%</span>

								</span>

                                <span class="progress progress-danger progress-striped active">

								<span style="width: 65%;" class="bar"></span>

								</span>

                            </a>

                        </li>

                        <li>

                            <a href="#">

								<span class="task">

								<span class="desc">Mobile app release</span>

								<span class="percent">98%</span>

								</span>

                                <span class="progress progress-success">

								<span style="width: 98%;" class="bar"></span>

								</span>

                            </a>

                        </li>

                        <li>

                            <a href="#">

								<span class="task">

								<span class="desc">Database migration</span>

								<span class="percent">10%</span>

								</span>

                                <span class="progress progress-warning progress-striped">

								<span style="width: 10%;" class="bar"></span>

								</span>

                            </a>

                        </li>

                        <li>

                            <a href="#">

								<span class="task">

								<span class="desc">Web server upgrade</span>

								<span class="percent">58%</span>

								</span>

                                <span class="progress progress-info">

								<span style="width: 58%;" class="bar"></span>

								</span>

                            </a>

                        </li>

                        <li>

                            <a href="#">

								<span class="task">

								<span class="desc">Mobile development</span>

								<span class="percent">85%</span>

								</span>

                                <span class="progress progress-success">

								<span style="width: 85%;" class="bar"></span>

								</span>

                            </a>

                        </li>

                        <li class="external">

                            <a href="#">See all tasks <i class="m-icon-swapright"></i></a>

                        </li>

                    </ul>

                </li>

                <!-- END TODO DROPDOWN -->

                <!-- BEGIN USER LOGIN DROPDOWN -->

                <li class="dropdown user">

                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">

                        <img alt="" src="<?php echo (session('admin_logo')); ?>" style="height: 30px;width: 30px;"/>

                        <span class="username"><?php echo (session('admin_name')); ?></span>

                        <i class="icon-angle-down"></i>

                    </a>

                    <ul class="dropdown-menu">
                        <li><a href="<?php echo U('Admin/Admin/logout');?>"><i class="icon-user"></i> 切换用户</a></li>
                        <li><a href="<?php echo U('Admin/Admin/logout');?>"><i class="icon-key"></i> 退出</a></li>
                    </ul>

                </li>

                <!-- END USER LOGIN DROPDOWN -->

            </ul>

            <!-- END TOP NAVIGATION MENU -->

        </div>

    </div>

    <!-- END TOP NAVIGATION BAR -->

</div>

<!-- END HEADER -->

<!-- BEGIN CONTAINER -->

<div class="page-container">

    <!-- BEGIN SIDEBAR -->

    <div class="page-sidebar nav-collapse collapse">

        <!-- BEGIN SIDEBAR MENU -->

        <ul class="page-sidebar-menu">

            <li>

                <!-- BEGIN SIDEBAR TOGGLER BUTTON -->

                <div class="sidebar-toggler hidden-phone"></div>

                <!-- BEGIN SIDEBAR TOGGLER BUTTON -->

            </li>

            <li>

                <!-- BEGIN RESPONSIVE QUICK SEARCH FORM -->

                <form class="sidebar-search">

                    <div class="input-box">

                        <a href="javascript:;" class="remove"></a>

                        <input type="text" placeholder="Search..." />

                        <input type="button" class="submit" value=" " />

                    </div>

                </form>

                <!-- END RESPONSIVE QUICK SEARCH FORM -->

            </li>

            <li class="start <?php if(CONTROLLER_NAME == 'Index'){echo 'active';} ?> ">
                <a href="<?php echo U('Admin/Index/index');?>">
                    <i class="icon-home"></i>
                    <span class="title">首页</span>
                    <span class="selected"></span>
                </a>
            </li>
            <?php if(is_array($menu)): foreach($menu as $key=>$v): ?><li class="<?php if($v['pri_name']==$sel_name) {echo 'active';} ?>">
                    <a href="javascript:;">
                        <i class="icon-table "></i>
                        <span class="title"><?php echo ($v["pri_name"]); ?></span>
                        <span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                        <?php if(is_array($v["children"])): foreach($v["children"] as $key=>$v1): ?><li class="<?php if(ACTION_NAME==$v1['action_name']) {echo 'active';} ?>">
                                <a href="<?php echo U($v1['module_name'].'/'.$v1['controller_name'].'/'.$v1['action_name']);?>">
                                    <?php echo ($v1["pri_name"]); ?></a>
                            </li><?php endforeach; endif; ?>
                    </ul>
                </li><?php endforeach; endif; ?>

            <!-- <li class="<?php if(CONTROLLER_NAME == 'Category'){echo 'active';} ?>">
                <a href="javascript:;">
                <i class="icon-cogs"></i>
                <span class="title">分类管理</span>
                <span class="arrow "></span>
                </a>
                <ul class="sub-menu">
                    <li class="<?php if(ACTION_NAME == 'cat_list'){echo 'active';} ?>">
                        <a href="<?php echo U('Admin/Category/cat_list');?>">分类列表</a>
                    </li>
                    <li class="<?php if(ACTION_NAME == 'cat_add'){echo 'active';} ?>" >
                        <a href="<?php echo U('Admin/Category/cat_add');?>">分类添加</a>
                    </li>
                </ul>
            </li>

            <li class="<?php if(CONTROLLER_NAME == 'Admin'){echo 'active';} ?>">
                <a href="javascript:;">
                <i class="icon-cogs"></i>
                <span class="title">管理员管理</span>
                <span class="arrow "></span>
                </a>
                <ul class="sub-menu">
                    <li class="<?php if(ACTION_NAME == 'admin_list'){echo 'active';} ?>">
                        <a href="<?php echo U('Admin/Admin/admin_list');?>">管理员列表</a>
                    </li>
                    <li class="<?php if(ACTION_NAME == 'admin_add'){echo 'active';} ?>" >
                        <a href="<?php echo U('Admin/Admin/admin_add');?>">管理员添加</a>
                    </li>
                </ul>
            </li>

            <li class="<?php if(CONTROLLER_NAME == 'Role'){echo 'active';} ?>">
                <a href="javascript:;">
                <i class="icon-cogs"></i>
                <span class="title">角色管理</span>
                <span class="arrow "></span>
                </a>
                <ul class="sub-menu">
                    <li class="<?php if(ACTION_NAME == 'role_list'){echo 'active';} ?>">
                        <a href="<?php echo U('Admin/Role/role_list');?>">role列表</a>
                    </li>
                    <li class="<?php if(ACTION_NAME == 'admin_add'){echo 'active';} ?>" >
                        <a href="<?php echo U('Admin/Role/role_add');?>">role添加</a>
                    </li>
                </ul>
            </li>

            <li class="<?php if(CONTROLLER_NAME == 'Role'){echo 'active';} ?>">
                <a href="javascript:;">
                <i class="icon-cogs"></i>
                <span class="title">权限管理</span>
                <span class="arrow "></span>
                </a>
                <ul class="sub-menu">
                    <li class="<?php if(ACTION_NAME == 'role_list'){echo 'active';} ?>">
                        <a href="<?php echo U('Admin/Privilege/pri_list');?>">权限列表</a>
                    </li>
                    <li class="<?php if(ACTION_NAME == 'admin_add'){echo 'active';} ?>" >
                        <a href="<?php echo U('Admin/Privilege/pri_add');?>">权限添加</a>
                    </li>
                </ul>
            </li> -->
        </ul>

        <!-- END SIDEBAR MENU -->

    </div>

    <!-- END SIDEBAR -->

    <!-- BEGIN PAGE -->

    <div class="page-content">

        <!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->

        <div id="portlet-config" class="modal hide">

            <div class="modal-header">

                <button data-dismiss="modal" class="close" type="button"></button>

                <h3>Widget Settings</h3>

            </div>

            <div class="modal-body">

                Widget settings form goes here

            </div>

        </div>

        <!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->

        <!-- BEGIN PAGE CONTAINER-->
        <div class="container-fluid">

            <!-- BEGIN PAGE HEADER-->

            <div class="row-fluid">

                <div class="span12">

                    <!-- BEGIN STYLE CUSTOMIZER -->

                    <div class="color-panel hidden-phone">

                        <div class="color-mode-icons icon-color"></div>

                        <div class="color-mode-icons icon-color-close"></div>

                        <div class="color-mode">

                            <p>THEME COLOR</p>

                            <ul class="inline">

                                <li class="color-black current color-default" data-style="default"></li>

                                <li class="color-blue" data-style="blue"></li>

                                <li class="color-brown" data-style="brown"></li>

                                <li class="color-purple" data-style="purple"></li>

                                <li class="color-grey" data-style="grey"></li>

                                <li class="color-white color-light" data-style="light"></li>

                            </ul>

                            <label>

                                <span>Layout</span>

                                <select class="layout-option m-wrap small">

                                    <option value="fluid" selected>Fluid</option>

                                    <option value="boxed">Boxed</option>

                                </select>

                            </label>

                            <label>

                                <span>Header</span>

                                <select class="header-option m-wrap small">

                                    <option value="fixed" selected>Fixed</option>

                                    <option value="default">Default</option>

                                </select>

                            </label>

                            <label>

                                <span>Sidebar</span>

                                <select class="sidebar-option m-wrap small">

                                    <option value="fixed">Fixed</option>

                                    <option value="default" selected>Default</option>

                                </select>

                            </label>

                            <label>

                                <span>Footer</span>

                                <select class="footer-option m-wrap small">

                                    <option value="fixed">Fixed</option>

                                    <option value="default" selected>Default</option>

                                </select>

                            </label>

                        </div>

                    </div>

                    <!-- END BEGIN STYLE CUSTOMIZER -->

                    <!-- BEGIN PAGE TITLE & BREADCRUMB-->

                    <h3 class="page-title">

                        <?php echo ($titles["name"]); ?>

                    </h3>

                    <ul class="breadcrumb">

                        <li>

                            <i class="icon-home"></i>

                            <?php echo ($titles["name"]); ?>

                            <i class="icon-angle-right"></i>

                        </li>

                        <li><?php echo ($titles["sub"]); ?></li>

                        <li class="pull-right no-text-shadow">

                            <div id="dashboard-report-range" class="dashboard-date-range tooltips no-tooltip-on-touch-device responsive" data-tablet="" data-desktop="tooltips" data-placement="top" data-original-title="Change dashboard date range">

                                <i class="icon-calendar"></i>

                                <span></span>

                                <i class="icon-angle-down"></i>

                            </div>

                        </li>

                    </ul>

                    <!-- END PAGE TITLE & BREADCRUMB-->

                </div>

            </div>
            
<link rel="stylesheet" type="text/css" href="<?php echo C('ADMIN_CSS_PATH');?>select2_metro.css" />
<link rel="stylesheet" type="text/css" href="<?php echo C('ADMIN_CSS_PATH');?>chosen.css" />

<!-- 富文本编辑器所需要的文件 -->
<script type="text/javascript" charset="utf-8" src="<?php echo C('ADMIN_PLUGIN_PATH');?>/ueditor/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo C('ADMIN_PLUGIN_PATH');?>/ueditor/ueditor.all.min.js"> </script>
<script type="text/javascript" charset="utf-8" src="<?php echo C('ADMIN_PLUGIN_PATH');?>/ueditor/lang/zh-cn/zh-cn.js"></script>
	

				<!-- END PAGE HEADER-->

				<!-- BEGIN PAGE CONTENT-->


				<div class="row-fluid">

					<div class="span12">

						<!-- BEGIN VALIDATION STATES-->

						<div class="portlet box green">

							<div class="portlet-title">

								<div class="caption"><i class="icon-reorder"></i><?php echo ($title["sub"]); ?></div>

								<div class="tools">

									<a href="javascript:;" class="collapse"></a>

									<a href="#portlet-config" data-toggle="modal" class="config"></a>

									<a href="javascript:;" class="reload"></a>

									<a href="javascript:;" class="remove"></a>

								</div>

							</div>

							<div class="portlet-body form">

								<!-- BEGIN FORM-->

								<form action="" id="form_sample_2" class="form-horizontal" method="post" >

									<div class="alert alert-error hide">

										<button class="close" data-dismiss="alert"></button>

										您的表单尚有未填项，或者非法数据，请仔细检查后再进行提交！

									</div>

									<div class="alert alert-success hide">

										<button class="close" data-dismiss="alert"></button>

										表单验证成功！

									</div>

									<div class="control-group">
										<label class="control-label">父分类<span class="required">*</span></label>
										<div class="controls">
											<select class="span6 m-wrap" name="parent_id">
												<option value="0">请选择父分类</option>
												<?php if(is_array($data)): foreach($data as $key=>$v): ?><option value="<?php echo ($v["id"]); ?>"><?php echo str_repeat("-",$v['level']*8); echo ($v["cat_name"]); ?></option><?php endforeach; endif; ?>
											</select>
										</div>
									</div>

									<div class="control-group">
										<label class="control-label">分类名称<span class="required">*</span></label>
										<div class="controls">
											<input type="text" name="cat_name" data-required="1" class="span6 m-wrap"/>
										</div>
									</div>
								
									
									
									<div class="form-actions">
										<button type="submit" class="btn green">提交</button>
									</div>

								</form>

								<!-- END FORM-->

							</div>

						</div>

						<!-- END VALIDATION STATES-->

					</div>

				</div>

				<!-- END PAGE CONTENT-->         

			</div>

			<!-- END PAGE CONTAINER-->

		</div>

		<!-- END PAGE -->  

	</div>

	<!-- END CONTAINER -->

	<!-- BEGIN FOOTER -->

	<div class="footer">
    <div class="footer-inner">
        <!--这只是测试用的！-->
    </div>
    <div class="footer-tools">
			<span class="go-top">
			<i class="icon-angle-up"></i>
			</span>
    </div>
</div>

<!-- END FOOTER -->

<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->

<!-- BEGIN CORE PLUGINS -->

<script src="<?php echo C('ADMIN_JS_PATH');?>jquery-1.10.1.min.js" type="text/javascript"></script>

<script src="<?php echo C('ADMIN_JS_PATH');?>jquery-migrate-1.2.1.min.js" type="text/javascript"></script>

<!-- IMPORTANT! Load jquery-ui-1.10.1.custom.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->

<script src="<?php echo C('ADMIN_JS_PATH');?>jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>

<script src="<?php echo C('ADMIN_JS_PATH');?>bootstrap.min.js" type="text/javascript"></script>

<!--[if lt IE 9]>

<script src="<?php echo C('ADMIN_JS_PATH');?>excanvas.min.js"></script>

<script src="<?php echo C('ADMIN_JS_PATH');?>respond.min.js"></script>

<![endif]-->

<script src="<?php echo C('ADMIN_JS_PATH');?>jquery.slimscroll.min.js" type="text/javascript"></script>

<script src="<?php echo C('ADMIN_JS_PATH');?>jquery.blockui.min.js" type="text/javascript"></script>

<script src="<?php echo C('ADMIN_JS_PATH');?>jquery.cookie.min.js" type="text/javascript"></script>

<script src="<?php echo C('ADMIN_JS_PATH');?>jquery.uniform.min.js" type="text/javascript" ></script>

<!-- END CORE PLUGINS -->

<!-- BEGIN PAGE LEVEL PLUGINS -->

<script type="text/javascript" src="<?php echo C('ADMIN_JS_PATH');?>jquery.validate.min.js"></script>

<script type="text/javascript" src="<?php echo C('ADMIN_JS_PATH');?>additional-methods.min.js"></script>

<script type="text/javascript" src="<?php echo C('ADMIN_JS_PATH');?>select2.min.js"></script>

<script type="text/javascript" src="<?php echo C('ADMIN_JS_PATH');?>chosen.jquery.min.js"></script>

<!-- END PAGE LEVEL PLUGINS -->

	<!-- BEGIN PAGE LEVEL STYLES -->

	<script src="<?php echo C('ADMIN_JS_PATH');?>app.js"></script>


	<!-- END PAGE LEVEL STYLES -->    

	<script>
		jQuery(document).ready(function() {

		   App.init();

           $('#form_2_select2').select2({
               placeholder: "Select an Option",
               allowClear: true
           });

           var form2 = $('#form_sample_2');
           var error2 = $('.alert-error', form2);
           var success2 = $('.alert-success', form2);

           form2.validate({
               errorElement: 'span', //default input error message container
               errorClass: 'help-inline', // default input error message class
               focusInvalid: false, // do not focus the last invalid input
               ignore: "",
               rules: {
                   cat_name: {
                       minlength: 2,//最小长度2个字符
                       required: true//必填
                   },
                   parent_id: {
                       required: true//必填
                   },
                   
               },

               messages: { // custom messages for radio buttons and checkboxes
                   membership: {
                       required: "Please select a Membership type"
                   },
                   service: {
                       required: "Please select  at least 2 types of Service",
                       minlength: jQuery.format("Please select  at least {0} types of Service")
                   }
               },

               errorPlacement: function (error, element) { // render error placement for each input type
                   if (element.attr("name") == "education") { // for chosen elements, need to insert the error after the chosen container
                       error.insertAfter("#form_2_education_chzn");
                   } else if (element.attr("name") == "membership") { // for uniform radio buttons, insert the after the given container
                       error.addClass("no-left-padding").insertAfter("#form_2_membership_error");
                   } else if (element.attr("name") == "service") { // for uniform checkboxes, insert the after the given container
                       error.addClass("no-left-padding").insertAfter("#form_2_service_error");
                   } else {
                       error.insertAfter(element); // for other inputs, just perform default behavoir
                   }
               },

               invalidHandler: function (event, validator) { //display error alert on form submit   
                   success2.hide();
                   error2.show();
                   App.scrollTo(error2, -200);
               },

               highlight: function (element) { // hightlight error inputs
                   $(element)
                       .closest('.help-inline').removeClass('ok'); // display OK icon
                   $(element)
                       .closest('.control-group').removeClass('success').addClass('error'); // set error class to the control group
               },

               unhighlight: function (element) { // revert the change dony by hightlight
                   $(element)
                       .closest('.control-group').removeClass('error'); // set error class to the control group
               },

               success: function (label) {
                   if (label.attr("for") == "service" || label.attr("for") == "membership") { // for checkboxes and radip buttons, no need to show OK icon
                       label
                           .closest('.control-group').removeClass('error').addClass('success');
                       label.remove(); // remove error label here
                   } else { // display success icon for other inputs
                       label
                           .addClass('valid').addClass('help-inline ok') // mark the current input as valid and display OK icon
                       .closest('.control-group').removeClass('error').addClass('success'); // set success class to the control group
                   }
               },

               submitHandler: function (form) {
            	   form.submit();
            	   //alert('123');
                   //success2.show();
                   //error2.hide();
               }

           });

           //apply validation on chosen dropdown value change, this only needed for chosen dropdown integration.
           $('.chosen, .chosen-with-diselect', form2).change(function () {
               form2.validate().element($(this)); //revalidate the chosen dropdown value and show error or success message for the input
           });

            //apply validation on select2 dropdown value change, this only needed for chosen dropdown integration.
           $('.select2', form2).change(function () {
               form2.validate().element($(this)); //revalidate the chosen dropdown value and show error or success message for the input
           });

		});

	</script>

	<!-- END JAVASCRIPTS -->   

</body>

<!-- END BODY -->

</html>