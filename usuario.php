<?php
require_once "header.php";
// # +---------------------------------------------------------------------------+
// # | 1. Creating & Calling: |
// # +---------------------------------------------------------------------------+
// # *** define a relative (virtual) path to datagrid.class.php file
// # *** (relatively to the current file)
// # *** RELATIVE PATH ONLY ***
define("DATAGRID_DIR", "class/"); /* Ex.: "datagrid/" */
require_once (DATAGRID_DIR . "datagrid.class.php");

// includes database connection parameters
include_once ("conexion.php");

ob_start();
// # *** set needed options and create a new class instance
$debug_mode = false; /* display SQL statements while processing */
$messaging = true; /* display system messages on a screen */
$unique_prefix = "cat_"; /* prevent overlays - must be started with a letter */
$dgrid = new DataGrid($debug_mode, $messaging, $unique_prefix);
// # *** set encoding and collation (default: utf8/utf8_unicode_ci)
$dg_encoding = "utf8";
$dg_collation = "utf8_spanish_ci";
$dgrid->SetEncoding($dg_encoding, $dg_collation);
// # *** set data source with needed options
// # *** put a primary key on the first place
$sql = "SELECT usuario.id, usuario.nombre_usuario, usuario.clave_usuario, rol.descripcion_rol, usuario.estado_usuario FROM usuario INNER JOIN rol ON usuario.id_rol = rol.id";
$default_order = array(
    "nombre_usuario" => "ASC"
);
$dgrid->DataSource("PEAR", "mysql", $DB_HOST, $DB_NAME, $DB_USER, $DB_PASS, $sql, $default_order);

// # +---------------------------------------------------------------------------+
// # | 2. General Settings: |
// # +---------------------------------------------------------------------------+
// # +-- PostBack Submission Method ---------------------------------------------+
// # *** defines postback submission method for DataGrid: AJAX, POST or GET(default)
$postback_method = "post";
$dgrid->SetPostBackMethod($postback_method);
// # *** set interface language (default - English)
// # *** (en) - English (de) - German (se) - Swedish (hr) - Bosnian/Croatian
// # *** (hu) - Hungarian (es) - Espanol (ca) - Catala (fr) - Francais
// # *** (nl) - Netherlands/"Vlaams"(Flemish) (it) - Italiano (pl) - Polish
// # *** (ch) - Chinese (sr) - Serbian (bg) - Bulgarian (pb) - Brazilian Portuguese
// # *** (ar) - Arabic (tr) - Turkish (cz) - Czech (ro/ro_utf8) - Romanian
// # *** (gk) - Greek (he) - Hebrew (ru_utf8) - Russian
$dg_language = "es";
$dgrid->SetInterfaceLang($dg_language);
// # *** set direction: "ltr" or "rtr" (default - "ltr")
$direction = "ltr";
$dgrid->SetDirection($direction);
// # *** set layouts: "0" - tabular(horizontal) - default, "1" - columnar(vertical), "2" - customized
$layouts = array(
    "view" => "0",
    "edit" => "1",
    "details" => "1",
    "filter" => "2"
);
$dgrid->SetLayouts($layouts);
// / $details_template = "<table><tr><td>{field_name_1}</td><td>{field_name_2}</td></tr>...</table>";
// / $dgrid->SetTemplates("","",$details_template);
// # *** set modes for operations ("type" => "link|button|image")
// # *** "view" - view mode | "edit" - add/edit/details modes
// # *** "byFieldValue"=>"fieldName" - make the field to be a link to edit mode page
$modes = array(
    "add" => array(
        "view" => true,
        "edit" => false,
        "type" => "link",
        "show_add_button" => "inside|outside"
    ),
    "edit" => array(
        "view" => true,
        "edit" => true,
        "type" => "link",
        "byFieldValue" => ""
    ),
    "details" => array(
        "view" => false,
        "edit" => false,
        "type" => "link"
    ),
    "delete" => array(
        "view" => true,
        "edit" => true,
        "type" => "image"
    )
);
$dgrid->SetModes($modes);
// # *** allow scrolling on datagrid
$scrolling_option = false;
$dgrid->AllowScrollingSettings($scrolling_option);
// # *** set scrolling settings (optional)
$scrolling_height = "200px";
$dgrid->SetScrollingSettings($scrolling_height);
// # *** allow multirow operations
$multirow_option = false;
$dgrid->AllowMultirowOperations($multirow_option);
$multirow_operations = array(
    "edit" => array(
        "view" => false
    ),
    "delete" => array(
        "view" => true
    ),
    "details" => array(
        "view" => true
    )
);
$dgrid->SetMultirowOperations($multirow_operations);
// # *** set CSS class for datagrid
// # *** "default" or "blue" or "gray" or "green" or "pink" or your own css file
$css_class = "x-blue";
$dgrid->SetCssClass($css_class);
// # *** set variables that used to get access to the page (like: my_page.php?act=34&id=56 etc.)
// / $http_get_vars = array("act", "id");
// / $dgrid->SetHttpGetVars($http_get_vars);
// # *** set other datagrid/s unique prefixes (if you use few datagrids on one page)
// # *** format (in which mode to allow processing of another datagrids)
// # *** array("unique_prefix"=>array("view"=>true|false, "edit"=>true|false, "details"=>true|false));
// / $anotherDatagrids = array("abcd_"=>array("view"=>true, "edit"=>true, "details"=>true));
// / $dgrid->SetAnotherDatagrids($anotherDatagrids);
// # *** set DataGrid caption
$dg_caption = "<h2 style='margin-top: 20px;'>ADMINISTRACIÓN DE USUARIOS</h2>";
$dgrid->SetCaption($dg_caption);

// # +---------------------------------------------------------------------------+
// # | 3. Printing & Exporting Settings: |
// # +---------------------------------------------------------------------------+
// # +-- Printing ---------------------------------------------------------------+
// # *** set printing option: true(default) or false
$printing_option = false;
$dgrid->AllowPrinting($printing_option);
// #
// # +-- Exporting --------------------------------------------------------------+
// # *** initialize the session with session_start();
// # *** default exporting directory: tmp/export/
$exporting_option = false;
$export_all = false;
$dgrid->AllowExporting($exporting_option, $export_all);
$exporting_types = array(
    "csv" => "true",
    "xls" => "true",
    "pdf" => "true",
    "xml" => "true"
);
$dgrid->AllowExportingTypes($exporting_types);

// # +---------------------------------------------------------------------------+
// # | 4. Sorting & Paging Settings: |
// # +---------------------------------------------------------------------------+
// # *** set sorting option: true(default) or false
$sorting_option = true;
$dgrid->AllowSorting($sorting_option);
// # *** set paging option: true(default) or false
$paging_option = true;
$rows_numeration = false;
$numeration_sign = "N #";
$dgrid->AllowPaging($paging_option, $rows_numeration, $numeration_sign);
// # *** set paging settings
$bottom_paging = array(
    "results" => true,
    "results_align" => "left",
    "pages" => true,
    "pages_align" => "center",
    "page_size" => true,
    "page_size_align" => "right"
);
$top_paging = array();
$pages_array = array(
    "5" => "5",
    "10" => "10",
    "25" => "25",
    "50" => "50",
    "100" => "100",
    "250" => "250",
    "500" => "500",
    "1000" => "1000"
);
$default_page_size = 10;
$paging_arrows = array(
    "first" => "|&lt;&lt;",
    "previous" => "&lt;&lt;",
    "next" => "&gt;&gt;",
    "last" => "&gt;&gt;|"
);
$dgrid->SetPagingSettings($bottom_paging, $top_paging, $pages_array, $default_page_size, $paging_arrows);

// # +---------------------------------------------------------------------------+
// # | 5. Filter Settings: |
// # +---------------------------------------------------------------------------+
// # *** set filtering option: true or false(default)
$filtering_option = false;
$show_search_type = false;
$dgrid->AllowFiltering($filtering_option, $show_search_type);
// # *** set additional filtering settings
// # *** tips: use "," (comma) if you want to make search by some words, for ex.: hello, bye, hi
// / $fill_from_array = array("0"=>"No", "1"=>"Yes"); /* as "value"=>"option" */
$filtering_fields = array(
    "Country <br />(start typing to see autocomplete in work)" => array(
        "type" => "textbox",
        "autocomplete" => "true",
        "handler" => "examples/autosuggest_countries.php",
        "maxresults" => "12",
        "shownoresults" => "true",
        "table" => "demo_countries",
        "field" => "name",
        "show_operator" => "false",
        "default_operator" => "like%",
        "case_sensitive" => "false",
        "comparison_type" => "string|numeric|binary",
        "width" => "",
        "on_js_event" => ""
    )
);
$dgrid->SetFieldsFiltering($filtering_fields);

// # +---------------------------------------------------------------------------+
// # | 6. View Mode Settings: |
// # +---------------------------------------------------------------------------+
// # *** set view mode table properties
$vm_table_properties = array(
    "width" => "30%"
);
$dgrid->SetViewModeTableProperties($vm_table_properties);
// # *** set columns in view mode
// # *** Ex.: "on_js_event"=>"onclick="alert(\"Yes!!!\");""
// # *** "barchart" : number format in SELECT SQL must be equal with number format in max_value
// / $fill_from_array = array("0"=>"Banned", "1"=>"Active", "2"=>"Closed", "3"=>"Removed"); /* as "value"=>"option" */
$vm_colimns = array(
    "id" => array(
        "header" => "ID",
        "type" => "label",
        "header_tooltip_type" => "floating",
        "align" => "center",
        "wrap" => "wrap",
        "text_length" => "20",
        "case" => "normal"
    ),
    "nombre_usuario" => array(
        "header" => "Nombre del Usuario",
        "type" => "label",
        "align" => "left",
        "wrap" => "nowrap",
        "text_length" => "-1",
        "case" => "normal"
    ),
    "descripcion_rol" => array(
        "header" => "Rol Asignado",
        "type" => "label",
        "align" => "left",
        "wrap" => "nowrap",
        "text_length" => "-1",
        "case" => "normal"
    )
);
$dgrid->SetColumnsInViewMode($vm_colimns);
// # *** set auto-generated columns in view mode
// $auto_column_in_view_mode = false;
// $dgrid->SetAutoColumnsInViewMode($auto_column_in_view_mode);

// # +---------------------------------------------------------------------------+
// # | 7. Add/Edit/Details Mode Settings: |
// # +---------------------------------------------------------------------------+
// # *** set add/edit mode table properties
$em_table_properties = array(
    "width" => "30%"
);
$dgrid->SetEditModeTableProperties($em_table_properties);
// # *** set details mode table properties
$dm_table_properties = array(
    "width" => "30%"
);
$dgrid->SetDetailsModeTableProperties($dm_table_properties);
// # *** set settings for add/edit/details modes
$table_name = "usuario";
$primary_key = "id";
$condition = "";
$dgrid->SetTableEdit($table_name, $primary_key, $condition);
// # *** set columns in edit mode
// # *** first letter: r - required, s - simple (not required)
// # *** second letter: t - text(including datetime), n - numeric, a - alphanumeric,
// # e - email, f - float, y - any, l - login name, z - zipcode,
// # p - password, i - integer, v - verified, c - checkbox, u - URL
// # *** third letter (optional):
// # for numbers: s - signed, u - unsigned, p - positive, n - negative
// # for strings: u - upper, l - lower, n - normal, y - any
// # *** Ex.: "on_js_event"=>"onclick="alert(\"Yes!!!\");""
// # *** Ex.: type = textbox|textarea|label|date(yyyy-mm-dd)|datedmy(dd-mm-yyyy)|datetime(yyyy-mm-dd hh:mm:ss)|datetimedmy(dd-mm-yyyy hh:mm:ss)|time(hh:mm:ss)|image|password|enum|print|checkbox
// # *** make sure your WYSIWYG dir has 777 permissions
// / $fill_from_array = array("0"=>"No", "1"=>"Yes", "2"=>"Don"t know", "3"=>"My be"); /* as "value"=>"option" */

$em_columns = array(
    "nombre_usuario" => array(
        "header" => "Nombre del Usuario",
        "type" => "textbox",
        "req_type" => "ry",
        "width" => "150px",
        "title" => "",
        "readonly" => "false",
        "maxlength" => "15",
        "default" => "",
        "unique" => true,
        "unique_condition" => "",
        "visible" => "true",
        "on_js_event" => ""
    ),
    "clave_usuario"  =>array(
        "header"=>"Contraseña", 
        "type"=>"password",   
        "req_type"=>"rp", 
        "width"=>"150px", 
        "title"=>"", 
        "readonly"=>"false", 
        "maxlength"=>"-1", 
        "default"=>"", 
        "unique"=>"false", 
        "unique_condition"=>"", 
        "visible"=>"true", 
        "on_js_event"=>"", 
        "hide"=> true, 
        "generate"=> false, 
        "cryptography"=> true, 
        "cryptography_type"=>"md5", 
        "aes_password"=>"aes_password"),
    "validator"    =>array(
        "header"=>"Verificar Contraseña", 
        "type"=>"validator",  
        "req_type"=>"rv", 
        "width"=>"150px", 
        "title"=>"", 
        "readonly"=>"false", 
        "maxlength"=>"-1", 
        "default"=>"", 
        "visible"=>"true", 
        "on_js_event"=>"", 
        "for_field"=>"clave_usuario", 
        "validation_type"=>"password"),
    "id_rol" => array(
        "header" => "Rol Asignado",
        "type" => "foreign_key",
        "req_type" => "ri",
        "width" => "150px",
        "title" => "",
        "readonly" => "false",
        "default" => "",
        "unique" => "false",
        "unique_condition" => "",
        "visible" => "true"
    )    
);
$dgrid->SetColumnsInEditMode($em_columns);
// # *** set auto-generated columns in edit mode
// $auto_column_in_edit_mode = false;
// $dgrid->SetAutoColumnsInEditMode($auto_column_in_edit_mode);
// # *** set foreign keys for add/edit/details modes (if there are linked tables)
// # *** Ex.: "field_name"=>"CONCAT(field1,","field2) as field3"
// # *** Ex.: "condition"=>"TableName_1.FieldName > "a" AND TableName_1.FieldName < "c""
// # *** Ex.: "on_js_event"=>"onclick="alert(\"Yes!!!\");""
$foreign_keys = array(
    "id_rol" => array(
        "table" => "rol",
        "field_key" => "id",
        "field_name" => "descripcion_rol",
        "view_type" => "dropdownlist",
        "radiobuttons_alignment" => "horizontal|vertical",
        "condition" => "",
        "order_by_field" => "id",
        "order_type" => "ASC",
        "on_js_event" => ""
    )
);
$dgrid->SetForeignKeysEdit($foreign_keys);
// # +---------------------------------------------------------------------------+
// # | 8. Bind the DataGrid: |
// # +---------------------------------------------------------------------------+
// # *** bind the DataGrid and draw it on the screen
// # call of this method between HTML <HEAD> tags
$dgrid->WriteCssClass();
$dgrid->Bind();
ob_end_flush();

// ###############################################################################
require_once "footer.php";
?>