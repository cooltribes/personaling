<div class="container margin_top tu_perfil">
    <div class="row">
        <aside class="span3">
            <div class="card margin_bottom_medium"> <img width="270" height="270" alt="Avatar" src="images/kitten.png">
                <div class="card_content vcard">
                    <h4 class="fn">Juan Pernia</h4>
                    <p class="muted">Miembro desde: 8 abr 2013</p>
                </div>
            </div>
            <div>
                <ul class="nav nav-tabs nav-stacked">
                    <li class="nav-header">Opciones de edición</li>
                    <li class="dropdown-submenu"> <a href="#" tabindex="-1">Tu perfil</a>
                        <ul class="dropdown-menu">
                            <li> <a href="/site/user/profile/edit">Datos Personales</a> </li>
                            <li> <a href="/site/user/profile/avatar">Avatar</a> </li>
                            <li> <a href="/site/user/profile/edittutipo">Tu Tipo</a> </li>
                        </ul>
                    </li>
                    <li class="dropdown-submenu"> <a href="#" tabindex="-1">Tus Pedidos </a>
                        <ul class="dropdown-menu">
                            <li> <a href="/site/orden/listado" title="Tus pedidos activos">Pedidos Activos</a></li>
                            <li> <a href="/site/orden/listado" title="Tus pedidos nuevos y anteriores">Historial de Pedidos</a></li>
                        </ul>
                    </li>
                    <li class="dropdown-submenu"> <a href="#" tabindex="-1">Tu Estilo </a>
                        <ul class="dropdown-menu">
                            <li><a href="/site/user/profile/edittuestilo/id/coctel" title="Edita tu estilo Coctel">Coctel</a></li>
                            <li><a href="/site/user/profile/edittuestilo/id/fiesta" title="Edita tu estilo Fiesta">Fiesta</a></li>
                            <li><a href="/site/user/profile/edittuestilo/id/playa" title="Edita tu estilo Playa">Playa</a></li>
                            <li><a href="/site/user/profile/edittuestilo/id/Sport" title="Edita tu estilo Sport">Sport</a></li>
                            <li><a href="/site/user/profile/edittuestilo/id/trabajo" title="Edita tu estilo Trabajo">Trabajo</a></li>
                        </ul>
                    </li>
                    <li class="dropdown-submenu"> <a href="#" tabindex="-1"> Tus Encantos/Favoritos </a>
                        <ul class="dropdown-menu">
                            <li><a href="/site/user/profile/looksencantan" title="Looks que te encantan">Looks</a></li>
                            <li><a href="/site/user/profile/encantan" title="Productos que te encantan">Productos</a></li>
                        </ul>
                    </li>
                    <li class="dropdown-submenu"> <a href="#" tabindex="-1"> Correo electrónico y contraseña </a>
                        <ul class="dropdown-menu">
                            <li><a href="/site/user/profile/changeemail" title="Cambia tu correo electrónico">Cambiar correo electrónico</a></li>
                            <li><a href="/site/user/profile/changepassword" title="Cambia tu contraseña">Cambiar Contraseña</a></li>
                        </ul>
                    </li>
                    <li class="dropdown-submenu"> <a href="#" tabindex="-1"> Notificaciones </a>
                        <ul class="dropdown-menu">
                            <li><a href="/site/user/profile/direcciones" title="Gestiona tus direcciones">Gestionar direcciones de Envíos y Pagos.</a></li>
                        </ul>
                    </li>
                    <li class="dropdown-submenu"> <a href="#" tabindex="-1"> Libreta de Direcciones </a>
                        <ul class="dropdown-menu">
                            <li><a href="/site/user/profile/direcciones" title="Gestiona tus direcciones">Gestionar direcciones de Envíos y Pagos.</a></li>
                        </ul>
                    </li>
                    <li class="dropdown-submenu"> <a href="#" tabindex="-1"> Privacidad </a>
                        <ul class="dropdown-menu">
                            <li><a href="/site/user/profile/privacidad" title="Cambia tu Informaciósn pública">Información pública</a></li>
                            <li><a href="/site/user/profile/delete" title="Eliminar Cuenta">Eliminar Cuenta</a> </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </aside>
        <div class="span9 ">
            <div class="bg_mancha_1  box_1">
                <div class="page-header">
                    <h1>Invita tus amig@s a Personaling</h1>
                </div>
                            
            
                
                <div class="row-fluid margin_bottom margin_top padding_top">
                    <div class="span5">
                        <div onclick="invite_friends()" style="cursor: pointer;" id="boton_facebook" class="text_align_center"><a>Invítalos usando Facebook</a></div>
                    </div>
                    <div class="span2 text_align_center T_large">- o -</div>
                    <div class="span5">
                        <div onclick="invite_friends()" style="cursor: pointer;" id="boton_twitter" class="text_align_center"><a>Invítalos usando Twitter</a></div>
                    </div>
                </div>
                <form  class="form-stacked braker_horz_top_1 no_margin_bottom">
                    <fieldset>
                        <legend >O invítal@s por correo electrónico: </legend>
                        <div class="row">
                        <div class="span5">
                            <div class="control-group">
                                <label class="control-label required">Ingresa los emails de tus amig@s: </label>
                                <div class="controls">
                                    <input type="text" maxlength="128" id="RegistrationForm_email" placeholder="correoelectronico@cuenta.com" name="RegistrationForm[email]" class="span5">
                                </div>
                            </div>
                            <div class="control-group">
                                <label  class="control-label required">Escribe un mensaje personal: </label>
                                <div class="controls">
                                    <textarea class="span5" rows="4">Mira looks creados por Daniela Kosan, Chiquibquirá Delgado y más artistas.</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="span3"><img src="images/img_libreta.jpg" width="240" height="240" alt="Correos"></div></div>
                        <div class="form-actions"> <a href="Crear_Perfil_Usuaria_Mi_Tipo.php" class="btn-large btn btn-danger">Enviar invitaciones</a> </div>
                    </fieldset>
                </form>
                
              
                
            </div>
            
             <div class="box_1 margin_top_medium"> <h2 class=" color2 braker_bottom">Historial de invitaciones</h2><p>En la siguiente lista podrás ver el status de las invitaciones que has enviado y los puntos acumulados por cada una: </p>
               
                <table width="100%" class="table table-bordered table-hover table-striped" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <th>Nombre de usuario</th>
                    <th>Fecha de invitación</th>
                    <th>Estado</th>
                    <th>Puntos</th>
                </tr>
                <tr>
                    <td>John Snow</td>
                    <td>17/10/1985</td>
                    <td>Aceptado</td>
                    <td>+3</td>
                </tr>
                <tr>
                    <td>John Snow</td>
                    <td>17/10/1985</td>
                    <td>Aceptado</td>
                    <td>+3</td>
                </tr>
                <tr>
                    <td>John Snow</td>
                    <td>17/10/1985</td>
                    <td>Aceptado</td>
                    <td>+3</td>
                </tr>
                <tr>
                    <td>John Snow</td>
                    <td>17/10/1985</td>
                    <td>Aceptado</td>
                    <td>+3</td>
                </tr>
            </table></div>
            
        </div>
    </div>
</div>
</div>
<!-- /container -->