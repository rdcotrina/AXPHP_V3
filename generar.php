<?php
require_once './Factory.php';

$tipo = isset($_POST['rd_tipo']) ? $_POST['rd_tipo'] : null;
$modulo = isset($_POST['txt_modulo']) ? trim(strtolower($_POST['txt_modulo'])) : '';

$modulo2 = isset($_POST['lst_modulo']) ? trim(strtolower($_POST['lst_modulo'])) : '';
$opcion = isset($_POST['txt_opcion']) ? trim(strtolower($_POST['txt_opcion'])) : '';

$opcion2 = isset($_POST['lst_opcion']) ? trim(strtolower($_POST['lst_opcion'])) : '';
$control = isset($_POST['txt_controller']) ? trim($_POST['txt_controller']) : '';
$alias = isset($_POST['txt_alias']) ? trim($_POST['txt_alias']) : '';
$chk_reemplaza = isset($_POST['chk_reemplazaCN']) ? trim($_POST['chk_reemplazaCN']) : '0';

if($chk_reemplaza){
    $opcion2 = isset($_POST['txt_opcionreemplaza']) ? trim($_POST['txt_opcionreemplaza']) : '';
}



if (!is_null($tipo)) {
    switch ($tipo) {
        case 'MN': # crear carpeta de modulo 
            if (empty($modulo)) {
                $msn = 'Debe ingresar el nombre del módulo';
            } else {
                $ruta = 'app/' . $modulo;
                if (Factory::createModulo($ruta)) {
                    $msn = 'Módulo se creo correctamente';
                } else {
                    $msn = 'Módulo ya existe';
                }
            }
            break;
        case 'OP':
            if (empty($modulo2)) {
                $msn = 'Debe seleccionar un modulo';
            } elseif (empty($opcion)) {
                $msn = 'Debe ingresar el nombre de la opcion';
            } else {
                $ruta = 'app/' . $modulo2 . '/' . $opcion;
                if (Factory::createOpcion($ruta)) {
                    $msn = 'Opcion se creo correctamente';
                } else {
                    $msn = 'Opcion ya existe';
                }
            }
            break;
        case 'CN':
            if (empty($opcion2)) {
                $msn = 'Debe seleccionar una opción';
            } elseif (empty($control)) {
                $msn = 'Debe ingresar el nombre del controlador';
            } elseif(empty ($alias)){
                $msn = 'Debe ingresar el nombre del alias';
            } else {
                $ruta = 'app/' . $opcion2;
                if (Factory::createController($ruta, $control,$alias)) {
                    $msn = 'Controlador se creo correctamente';
                } else {
                    $msn = 'Controlador ya existe';
                }
            }
            break;
    }

    echo '<div class="msn">'.$msn.'</div>';
}
?>

<html>
    <head>
        <title>FACTORY</title>
        <script src="http://localhost/PROYECTOERP/public/theme/smartadmin/js/plugin/pace/pace.min.js"></script>
        <script src="http://localhost/PROYECTOERP/public/theme/smartadmin/js/libs/jquery-2.0.2.min.js"></script>
        <style>
            form{
                font-family: arial;
                font-size: 12px;
            }
            .msn{
                border:1px solid #990000;
                color: red;
                padding: 10px;
                border-radius: 5px;
                margin-bottom: 10px;
            }
            .ops{
                border: 1px solid #ddd;
                border-radius: 5px;
                padding: 10px;
                background: #e2e2e2;
            }
            .lb{
                margin-bottom: 5px;
                display: inline-block;
                width: 150px;
            }
            .ab{
                position: absolute;
            }
        </style>
    </head>
    <body>
        <form method="POST">
            <div class="ops">
                <label>
                    <input class="rd_tipo" type="radio" name="rd_tipo" value="MN" id="rd_tipoMN"> Módulo (Namespace)
                </label>
                <label>
                    <input class="rd_tipo" type="radio" name="rd_tipo" value="OP"> Opción
                </label>
                <label>
                    <input class="rd_tipo" type="radio" name="rd_tipo" value="CN"> Controlador
                </label>
            </div>
            
            <hr>
            
            <fieldset id="fl_modulo">
                <legend>Crear Módulo</legend>
                <div>
                    <label class="lb">Módulo - Namespace:</label>
                    <label class="lb">
                        <input type="text" id="txt_modulo" name="txt_modulo">
                        <i class="ab">Nombre de módulo debe ser en minúscula</i>
                    </label>
                </div>
            </fieldset>

            <fieldset id="fl_opcion" style="display: none">
                <legend>Crear Opción</legend>
                <div>
                    <label class="lb">Módulo - Namespace:</label>
                    <label class="lb">
                        <select id="lst_modulo" name="lst_modulo">
                            <option value="">Seleccionar</option>
                            <?php foreach (Factory::readDir('app/') as $value): ?>
                                <option value="<?php echo $value['dir']; ?>"><?php echo $value['dir']; ?></option>    
                            <?php endforeach; ?>
                        </select>
                        <i class="ab">Nombre de módulo al que pertenecera la opción</i>
                    </label>
                </div>
                <div>
                    <label class="lb">Opción:</label>
                    <label class="lb">
                        <input type="text" id="txt_opcion" name="txt_opcion">
                        <i class="ab">Nombre de opción debe ser en minúscula</i>
                    </label>
                </div>
            </fieldset>

            <fieldset id="fl_controler" style="display: none">
                <legend>Crear Controlador</legend>
                <div>
                    <label class="lb">Módulo - Opción:</label>
                    <label class="lb" style="width: 400px">
                        <select id="lst_opcion" name="lst_opcion">
                            <option value="">Seleccionar</option>
                            <?php foreach (Factory::scanSubDir('app/') as $value): ?>
                                <option value="<?php echo $value['dir']; ?>"><?php echo $value['dir']; ?></option>    
                            <?php endforeach; ?>
                        </select>
                        <i class="ab">Opción al que pertenecera el controlador</i>
                    </label>
                </div>
                <div>
                    <label class="lb"></label>
                    <label class="lb" style="width: 350px">
                        <input type="checkbox" id="chk_reemplazaCN" name="chk_reemplazaCN" value="1"> Reemplazar módulo - opción
                        <input type="text" id="txt_opcionreemplaza" name="txt_opcionreemplaza" placeholder="módulo - opción" style="display: none">
                    </label>
                </div>
                <div>
                    <label class="lb">Controlador:</label>
                    <label class="lb" >
                        <input type="text" id="txt_controller" name="txt_controller">
                        <i class="ab">Nombre de controlador debe ser en Pascalcase. Se crearán: filter, model, views, js</i>
                    </label>
                </div>
                <div>
                    <label class="lb">Alias:</label>
                    <label class="lb">
                        <input type="text" id="txt_alias" name="txt_alias">
                    </label>
                </div>
            </fieldset>
            <div>
                <button type="submit">Grabar</button>
            </div>
        </form>
    </body>
    <script>
        $('.rd_tipo').click(function(){
            var t = this.value;
            
            switch(t){
                case 'MN':
                    $('#fl_modulo').show();
                    $('#fl_opcion').hide();
                    $('#fl_controler').hide();
                    break;
                case 'OP':
                    $('#fl_opcion').show();
                    $('#fl_modulo').hide();
                    $('#fl_controler').hide();
                    break;    
                case 'CN':
                    $('#fl_controler').show();
                    $('#fl_modulo').hide();
                    $('#fl_opcion').hide();
                    $('#chk_reemplazaCN').attr('checked',false);
                    $('#txt_opcionreemplaza').hide().val('');
                    break;
            }
        });
        
        $('#rd_tipoMN').click();
        
        $('#chk_reemplazaCN').click(function(){
            if($(this).is(':checked')){
                $('#txt_opcionreemplaza').show();
            }else{
                $('#txt_opcionreemplaza').hide().val('');
            }
        });
    </script>
</html>

