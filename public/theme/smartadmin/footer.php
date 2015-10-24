</body>

<!-- #PLUGINS -->
    <script src="<?php echo $rutaLayout['js']; ?>libs/jquery-ui-1.10.3.min.js"></script> 

    <!-- IMPORTANT: APP CONFIG -->
    <script src="<?php echo $rutaLayout['js']; ?>app.config.js"></script>

    <!-- JS TOUCH : include this plugin for mobile drag / drop touch events-->
    <script src="<?php echo $rutaLayout['js']; ?>plugin/jquery-touch/jquery.ui.touch-punch.min.js"></script> 

    <!-- BOOTSTRAP JS -->
    <script src="<?php echo $rutaLayout['js']; ?>bootstrap/bootstrap.min.js"></script>

    <!-- CUSTOM NOTIFICATION -->
    <script src="<?php echo $rutaLayout['js']; ?>notification/SmartNotification.min.js"></script>

    <!-- JARVIS WIDGETS -->
    <script src="<?php echo $rutaLayout['js']; ?>smartwidgets/jarvis.widget.min.js"></script>

    <!-- EASY PIE CHARTS -->
    <script src="<?php echo $rutaLayout['js']; ?>plugin/easy-pie-chart/jquery.easy-pie-chart.min.js"></script>

    <!-- SPARKLINES -->
    <script src="<?php echo $rutaLayout['js']; ?>plugin/sparkline/jquery.sparkline.min.js"></script>
    
    <!-- JQUERY VALIDATE -->
    <script src="<?php echo $rutaLayout['js']; ?>plugin/jquery-validate/jquery.validate.min.js"></script>

    <!-- JQUERY MASKED INPUT -->
    <script src="<?php echo $rutaLayout['js']; ?>plugin/masked-input/jquery.maskedinput.min.js"></script>

    <!-- JQUERY SELECT2 INPUT -->
    <script src="<?php echo $rutaLayout['js']; ?>plugin/select2/select2.min.js"></script>
    
    <!-- JQUERY CLOCKPICKER -->
    <script src="<?php echo $rutaLayout['js']; ?>plugin/clockpicker/clockpicker.min.js"></script>

    <!-- JQUERY UI + Bootstrap Slider -->
    <script src="<?php echo $rutaLayout['js']; ?>plugin/bootstrap-slider/bootstrap-slider.min.js"></script>

    <!-- browser msie issue fix -->
    <script src="<?php echo $rutaLayout['js']; ?>plugin/msie-fix/jquery.mb.browser.min.js"></script>

    <!-- CONTEXTMENU -->
    <script src="<?php echo BASE_URL; ?>public/js/menuRight/menuRight.js"></script>
    
    <!-- JQUERY CHOSEN INPUT -->
    <script src="<?php echo BASE_URL ?>public/theme/smartadmin/js/plugin/chosen/chosen.jquery.js"></script>
    
    <!-- FastClick: For mobile devices: you can disable this in app.js -->
    <script src="<?php echo $rutaLayout['js']; ?>plugin/fastclick/fastclick.min.js"></script>

    <!--[if IE 8]>
            <h1>Your browser is out of date, please update your browser by going to www.microsoft.com/download</h1>
    <![endif]-->

    <!-- Demo purpose only -->
    <script src="<?php echo $rutaLayout['js']; ?>demo.min.js"></script>

    <!-- MAIN APP JS FILE -->
    <script src="<?php echo $rutaLayout['js']; ?>app.min.js"></script>

    <!-- ENHANCEMENT PLUGINS : NOT A REQUIREMENT -->
    <!-- Voice command : plugin -->
    <script src="<?php echo $rutaLayout['js']; ?>speech/voicecommand.min.js"></script>
    
    <!-- SCRIPT CORE -->
    <script src="<?php echo BASE_URL; ?>vendor/ax/Class.js"></script>
    <script src="<?php echo BASE_URL; ?>vendor/ax/Exe.js"></script>
    
    <!-- SCRIPT DATAGRID -->
    <script src="<?php echo BASE_URL; ?>public/js/dataGrid/dataGrid.jquery.js"></script>
    
    <!-- SCRIPT CROLLTABLE -->
    <script src="<?php echo BASE_URL; ?>public/js/scrollTable/scrollTable.js"></script>
    
    <!-- EXCEL FACTORY -->
    <script type="text/javascript" src="<?php echo BASE_URL; ?>public/js/excelFactory/js/require.min.js"></script>
    <script type="text/javascript" src="<?php echo BASE_URL; ?>public/js/excelFactory/js/underscore.min.js"></script>
    <script type="text/javascript" src="<?php echo BASE_URL; ?>public/js/excelFactory/js/json2.js"></script>
    <!-- <script type="text/javascript" src="<?php echo BASE_URL; ?>public/js/excelFactory/js/swfobject.js"></script> -->
    <script type="text/javascript" src="<?php echo BASE_URL; ?>public/js/excelFactory/js/downloadify.min.js"></script>
    <script type="text/javascript" src="<?php echo BASE_URL; ?>public/js/excelFactory/excelFactory.js"></script>
    
    <!-- JSPDF -->
    <script src="<?php echo BASE_URL; ?>public/js/jsPDF/jspdf.js"></script>
    <script src="<?php echo BASE_URL; ?>public/js/jsPDF/jspdf.plugin.from_html.js"></script>

    <script src="<?php echo BASE_URL; ?>public/js/jsPDF/jspdf.plugin.addimage.js"></script>
    <script src="<?php echo BASE_URL; ?>public/js/jsPDF/libs/png_support/png.js"></script>
    <script src="<?php echo BASE_URL; ?>public/js/jsPDF/libs/png_support/zlib.js"></script>
    <script src="<?php echo BASE_URL; ?>public/js/jsPDF/jspdf.plugin.png_support.js"></script>
    <script src="<?php echo BASE_URL; ?>public/js/jsPDF/jspdf.plugin.cell.js"></script>
    <script src="<?php echo BASE_URL; ?>public/js/jsPDF/jspdf.plugin.standard_fonts_metrics.js"></script>
    <script src="<?php echo BASE_URL; ?>public/js/jsPDF/jspdf.plugin.split_text_to_size.js"></script>
    <script src="<?php echo BASE_URL; ?>public/js/jsPDF/jspdf.plugin.total_pages.js"></script>
    <script src="<?php echo BASE_URL; ?>public/js/jsPDF/libs/FileSaver/FileSaver.js"></script>
    
    <?php require_once (ROOT . 'config' . DS . 'prefix' . DS . 'PrefixJs.php'); ?>
    <!--se cierra tabs a prefijosJS JS debido a q en el archivo debe permanecer abierto para agregar las constantes con CREATOR-->
    </script>
    
</html>
<script>
    /*obtener el src de los js incluidos, para verificar que no sean suplantados*/
    /*
    $.each($('script'),function(){
        alert($(this).attr('src'))
    });
    */
   
   /*si no esta logueado, bloqueo de pantalla no se activa*/
    var inactvo = function(){};

    /*contenedor de html null, para bloqueadr app*/
    localStorage.setItem('mainBodyHtml',null);
    
    /*cargar requires*/
    Exe.require("config/lang/js/lang_<?php echo APP_LANG?>");
    Exe.require("vendor/ax/Tools");
    Exe.require("vendor/ax/Ajax",function(){
        var $ajax = new Ajax();
        tostring = $ajax.cadena();
        Exe.require({aplication: 'index::LoginView'});
    });
    Exe.require("libs/Aes/js/aes",function(){
        Exe.require("libs/Aes/js/aesctr");
    });    
    Exe.require("libs/Aes/js/base64");
    Exe.require("libs/Aes/js/utf8");
//    Exe.require("libs/Aes/js/aesctr");
</script>

<?php if(Obj()->Session->get('sys_usuario')):?>
<script>
    /*evento para bloquear por inactividad*/
    var activityTimeout = 0;    
    var inactvo = function() {
        var activityTimeout = null;
        $(document).mousemove(function(event) {
            if (activityTimeout) {
                clearTimeout(activityTimeout);
            }
            activityTimeout = setTimeout(function() {
                Index.inactividad();
            }, 1000);
        });
    };
    
    /*activando menu top*/
//    localStorage.setItem("sm-setmenu", "top");
//    $('input[type="checkbox"]#smart-fixed-header').prop("checked", !0);
//    $('input[type="checkbox"]#smart-fixed-navigation').prop("checked", !0);
//    $('input[type="checkbox"]#smart-fixed-ribbon').prop("checked", !0);
//    $.root_.addClass("fixed-header");
//    $.root_.addClass("fixed-navigation");
//   // $.root_.addClass("fixed-ribbon");
//    $('input[type="checkbox"]#smart-fixed-container').prop("checked", !1);
//    $.root_.removeClass("container");
</script>
<?php endif; ?>
