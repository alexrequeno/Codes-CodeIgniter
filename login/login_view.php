<style type="text/css">
body {
  padding-top: 40px;
  padding-bottom: 40px;
  background-color: #000;
}

.form-signin {
  max-width: 330px;
  padding: 15px;
  margin: 0 auto;
}
.form-signin .form-signin-heading,
.form-signin .checkbox {
  margin-bottom: 10px;
}
.form-signin .checkbox {
  font-weight: normal;
}
.form-signin .form-control {
  position: relative;
  font-size: 16px;
  height: auto;
  padding: 10px;
  -webkit-box-sizing: border-box;
     -moz-box-sizing: border-box;
          box-sizing: border-box;
}
.form-signin .form-control:focus {
  z-index: 2;
}
.form-signin input[type="text"] {
  margin-bottom: -1px;
  border-bottom-left-radius: 0;
  border-bottom-right-radius: 0;
}
.form-signin input[type="password"] {
  margin-bottom: 10px;
  border-top-left-radius: 0;
  border-top-right-radius: 0;
}
</style>
</head> 
<body>

    <div class="container">
      <form class="form-signin" action="<?php echo base_url()?>login/log_user" method="post">
        <h2 class="form-signin-heading"><i class="fa fa-compress"></i> Bodeger</h2>
        <input name="nombre_usuario" type="text" class="form-control" placeholder="Tu Usuario" autofocus>
        <input name="pass_usuario" type="password" class="form-control" placeholder="Tu Password">
        <input name="token" value="<?=$token ?>" type="hidden">
        <button class="btn btn-lg btn-primary btn-block" type="submit"><span class="glyphicon glyphicon-log-in"></span> Iniciar Sesión</button>
      </form>
    </div>
