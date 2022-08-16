<?php
require_once("assets/interface.php");
$title="Iniciar sesión";
$description="Iniciar sesión en el sistema de documentación de Por Amor a Ellxs";
interface_header($title,$description); ?>
<div id="loginInterface" class="container text-center">
	<p>Bienvenidx, para iniciar sesión oprime el botón:</p>
	<div class="G_login">
		<a href="https://accounts.google.com/o/oauth2/auth?response_type=code&client_id=<?php echo($DaoSesiones->getParam("Google_ClientID")); ?>&redirect_uri=<?php echo(urlencode($DaoSesiones->getParam("protocolo")."://".$DaoSesiones->getParam("dominio")."/oauth/Google")); ?>&state=login&access_type=offline&include_granted_scopes=true&scope=<?php echo(urlencode("profile email")); ?>">
			<img src="assets/img/login_with_G_normal.svg" class="normal" />
			<img src="assets/img/login_with_G_focus.svg" class="focus" />
			<img src="assets/img/login_with_G_pressed.svg" class="pressed" />
		</a>
	</div>
</div>
<?php
interface_footer();