<!DOCTYPE html>

<html lang="es">

	<head>

		<meta charset="utf-8">

		<meta http-equiv="X-UA-Compatible" content="IE=edge">

		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>Quality Assurance Program</title>

		<link rel="shortcut icon" href="css/qap_ico.png">

		<link href="boostrap/css/bootstrap.min.css?v12" rel="stylesheet" media="screen">

		<link href="css/jquery-ui.min.css?v12" rel="stylesheet" media="screen">			

		<link href="css/pagina.css?v12" rel="stylesheet" media="screen">

		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

		<style>

    .password-container {

      position: relative;

    }

    

    .toggle-password {

      position: absolute;

      top: 50%;

      right: 10px;

      transform: translateY(-50%);

      cursor: pointer;

    }

  </style>



	</head>

	<body onload="initialize();" class="body-color bg-body-login">

		<div class="container" id="mainContainer" >
			<div class="row margin-bottom-7">			

				<div class="col margin-top-7" style="max-width: 600px;text-align: center;margin: auto;">

					<div class="sides-margin-10">

						<div class="panel-body">

							<div class="col-xs-12 margin-top-5">

								<center>

									<img src="css/qap_logo.png" style="width: 100%; border-radius: 10px;"></img>

								</center>	

							</div>						

							<div class="col-xs-12 margin-top-5">

							<form id="form1" data-passwordchange-dataform="true">

								<div class="form-group">

									<input type="text" class="form-control input-lg" id="userName" name="username" placeholder="Nombre de usuario" data-passwordchange-userinput="true">

								</div>

								<div class="form-group password-container">

                                <input type="password" class="form-control input-lg" id="userPassword" name="userpassword" placeholder="Contraseña" data-passwordchange-password="true">

                                <i class="fas fa-eye toggle-password" id="togglePassword"></i>

                              </div>

								<div class="form-group">

									<input type="submit" class="btn btn-primary btn-lg btn-block" value="Iniciar sesión">

								</div>

								<div hidden>

									<center>

										<input type="checkbox" id="f1cb1" checked>

										<label for="f1cb1">Mantener sesión iniciada</label>

									</center>	

								</div>								

							</form>

							<center>

								<button type="button" id="passwordRecoveryBtn" class='btn-olvido-contrasena' data-site="qap">He olvidado mi contraseña</button>

							</center>	

							<script type="text/javascript">

								document.getElementById("passwordRecoveryBtn").addEventListener("click",function(){

									window.open("passwordRecovery/emailForm.php?site="+this.getAttribute("data-site"),"Restablecer mi contraseña","width=450,height=450");

								});

							</script>	

							<script>

                            const togglePassword = document.getElementById("togglePassword");

                            const passwordInput = document.getElementById("userPassword");

                        

                            togglePassword.addEventListener("click", function () {

                              if (passwordInput.type === "password") {

                                passwordInput.type = "text";

                                togglePassword.classList.remove("fa-eye");

                                togglePassword.classList.add("fa-eye-slash");

                              } else {

                                passwordInput.type = "password";

                                togglePassword.classList.remove("fa-eye-slash");

                                togglePassword.classList.add("fa-eye");

                              }

                            });

                          </script>

                        </div>

						</div>	

					</div>	

				</div>

				<footer class="col-xs-12 footer" style="font-size: 8pt;">

					<center>

					<span>© Derechos Reservados 2016 - <?php echo Date("Y"); ?> Quik Quality Is The Key S.A.S. Todos los Derechos Reservados.</span>

					<br>

					<span style="font-size: 10pt;"><a href="https://www.quik.com.co" target="_blank">www.quik.com.co</a></span>

					</center>

				</footer>

			</div>

		</div>	

		<script src="jquery/jquery-2.1.4.min.js?v12"></script>	

		<script src="jquery/jquery.md5.js?v12"></script>	

		<script src="jquery/jquery-ui.min.js?v12"></script>

		<script src="jquery/jquery.statusBox.js?v12"></script>

		<script src="jquery/jquery.cookie.js?v12"></script>

		<script src="javascript/bootstrap.min.js?v12"></script>

		<script src="jquery.passwordchange/jquery.passwordchange.js?v12" type="text/javascript"></script>

		<script src="javascript/login.js?v12"></script>

	</body>

</html>	