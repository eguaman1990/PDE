<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta charset="utf-8" />
    <title>Login - Admin Fabrimed</title>
    <meta name="description" content="User login page" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    <!-- bootstrap & fontawesome -->
    <link rel="stylesheet" type="text/css" href="resources/css/bootstrap.min.css"/>
    <link rel="stylesheet" type="text/css" href="resources/css/font-awesome.min.css"/>
    <!-- text fonts -->
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400,300" />

    <!-- ace styles -->
    <link rel="stylesheet" type="text/css" href="resources/css/ace.min.css"/>


    <!--[if lte IE 9]>
    <link rel="stylesheet" type="text/css" href="resources/css/ace-part2.min.css"/>
    
    <![endif]-->
    <link rel="stylesheet" type="text/css" href="resources/css/ace-rtl.min.css"/>
    <!--[if lte IE 9]>
    <link rel="stylesheet" type="text/css" href="resources/css/ace-ie.min.css"/>
    
    <![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->

    <!--[if lt IE 9]>
    <script type="text/javascript" src="resources/js/lib/html5/html5shiv.js"></script>
    <script type="text/javascript" src="resources/js/lib/respond/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class="login-layout blur-login">
    <div class="main-container">
      <div class="main-content">
        <div class="row">
          <div class="col-sm-10 col-sm-offset-1">
            <div class="login-container">
              <div class="center">
                <h1>
                  <i class="ace-icon fa fa-leaf green"></i>
                  <span class="red">Administración</span>
                  <span class="white" id="id-text2">del Sistema</span>
                </h1>
                <h4 class="blue" id="id-company-text">&copy; Fabrimed</h4>
              </div>

              <div class="space-6"></div>

              <div class="position-relative">
                <div id="login-box" class="login-box visible widget-box no-border">
                  <div class="widget-body">
                    <div class="widget-main">
                      <h4 class="header blue lighter bigger">
                        <i class="ace-icon fa fa-coffee green"></i>
                        Ingrese su Informaci&oacute;n
                      </h4>

                      <div class="space-6"></div>

                      <form>
                        <fieldset>
                          <label class="block clearfix">
                            <span class="block input-icon input-icon-right">
                              <input type="text" class="form-control" placeholder="Nombre de Usuario" id="txtUser" />
                              <i class="ace-icon fa fa-user"></i>
                            </span>
                          </label>

                          <label class="block clearfix">
                            <span class="block input-icon input-icon-right">
                              <input type="password" class="form-control" placeholder="Contrase&ntilde;a" id="txtPass" />
                              <i class="ace-icon fa fa-lock"></i>
                            </span>
                          </label>

                          <div class="space"></div>

                          <div class="clearfix">
                            

                            <button type="button" class="width-35 pull-right btn btn-sm btn-primary" id="btnIngresar">
                              <i class="ace-icon fa fa-key"></i>
                              <span class="bigger-110">Ingresar</span>
                            </button>
                          </div>

                          <div class="space-4"></div>
                        </fieldset>
                      </form>

                    </div><!-- /.widget-main -->

                    <div class="toolbar center" style="padding: 9px 18px;">
                      
                        <a href="#" data-target="#forgot-box" class="forgot-password-link">
                          <i class="ace-icon fa fa-arrow-left"></i>
                          Recuperar&nbsp;Contrase&ntilde;a
                        </a>
                      

                      <!--<div>
                        <a href="#" data-target="#signup-box" class="user-signup-link">
                          I want to register
                          <i class="ace-icon fa fa-arrow-right"></i>
                        </a>
                      </div>-->
                    </div>
                  </div><!-- /.widget-body -->
                </div><!-- /.login-box -->

                <div id="forgot-box" class="forgot-box widget-box no-border">
                  <div class="widget-body">
                    <div class="widget-main">
                      <h4 class="header red lighter bigger">
                        <i class="ace-icon fa fa-key"></i>
                        Recuperar Contrase&ntilde;a
                      </h4>

                      <div class="space-6"></div>
                      <p>
                        Ingrese su email para recibir instrucciones
                      </p>

                      <form>
                        <fieldset>
                          <label class="block clearfix">
                            <span class="block input-icon input-icon-right">
                              <input type="email" class="form-control" placeholder="Email" />
                              <i class="ace-icon fa fa-envelope"></i>
                            </span>
                          </label>

                          <div class="clearfix">
                            <button type="button" class="width-35 pull-right btn btn-sm btn-danger">
                              <i class="ace-icon fa fa-lightbulb-o"></i>
                              <span class="bigger-110">Enviar</span>
                            </button>
                          </div>
                        </fieldset>
                      </form>
                    </div><!-- /.widget-main -->

                    <div class="toolbar center">
                      <a href="#" data-target="#login-box" class="back-to-login-link">
                        Volver al Login
                        <i class="ace-icon fa fa-arrow-right"></i>
                      </a>
                    </div>
                  </div><!-- /.widget-body -->
                </div><!-- /.forgot-box -->

              </div>

              <div class="navbar-fixed-top align-right">
                <br />
                &nbsp;
                <a id="btn-login-dark" href="#">Dark</a>
                &nbsp;
                <span class="blue">/</span>
                &nbsp;
                <a id="btn-login-blur" href="#">Blur</a>
                <!--&nbsp;
                <span class="blue">/</span>
                &nbsp;
                <a id="btn-login-light" href="#">Light</a>-->
                &nbsp; &nbsp; &nbsp;
              </div>
            </div>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.main-content -->

    </div><!-- /.main-container -->

    <!-- basic scripts -->

    <!--[if !IE]> -->
    <script type="text/javascript" src="resources/js/lib/jquery/jquery-2.1.1.js"></script>
    <!-- <![endif]-->

    <!--[if IE]>
    <script src="jquery.min-1.js" tppabs="http://www.eguaman.cl/Fabrimed/resources/js/lib/jquery/1.11.1/jquery.min.js"></script>
  <![endif]-->

    <!--[if !IE]> -->
    <script type="text/javascript">
      window.jQuery || document.write("<script src='jquery.min-2.js'/*tpa=http://www.eguaman.cl/Fabrimed/resources/js/lib/jquery/jquery-2.1.1.min.js*/>" + "<" + "/script>");
    </script>

    <!-- <![endif]-->

    <!--[if IE]>
  <script type="text/javascript">
  window.jQuery || document.write("<script src='jquery1x.min.js'/*tpa=http://www.eguaman.cl/Fabrimed/resources/js/lib/jquery/1.11.1/jquery.min.js*/>"+"<"+"/script>");
  </script>
  <![endif]-->
    <script type="text/javascript">
      if ('ontouchstart' in document.documentElement)
        document.write("<script src='jquery.mobile.custom.min.js'/*tpa=http://www.eguaman.cl/Fabrimed/resources/js/lib/jquery/jquery.mobile.custom.min.js*/>" + "<" + "/script>");
    </script>
    <script src="resources/js/functions.js" type="text/javascript"></script>
    <script src="resources/js/login.js" type="text/javascript"></script>
    
    <!-- inline scripts related to this page -->
    <script type="text/javascript">
      jQuery(function($) {
        $(document).on('click', '.toolbar a[data-target]', function(e) {
          e.preventDefault();
          var target = $(this).data('target');
          $('.widget-box.visible').removeClass('visible');//hide others
          $(target).addClass('visible');//show target
        });
      });



      //you don't need this, just used for changing background
      jQuery(function($) {
        $('#btn-login-dark').on('click', function(e) {
          $('body').attr('class', 'login-layout');
          $('#id-text2').attr('class', 'white');
          $('#id-company-text').attr('class', 'blue');

          e.preventDefault();
        });
        $('#btn-login-light').on('click', function(e) {
          $('body').attr('class', 'login-layout light-login');
          $('#id-text2').attr('class', 'grey');
          $('#id-company-text').attr('class', 'blue');

          e.preventDefault();
        });
        $('#btn-login-blur').on('click', function(e) {
          $('body').attr('class', 'login-layout blur-login');
          $('#id-text2').attr('class', 'white');
          $('#id-company-text').attr('class', 'light-blue');

          e.preventDefault();
        });

      });
    </script>
  </body>
</html>