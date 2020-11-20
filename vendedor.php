<?php
require_once 'header.php';

// # wee need this if we want to prevent FF sending double request
// header("content-type: text/html; charset=utf-8");

// # uncomment, if your want to prevent "Web Page exired" message when use $submission_method = "post";
// # (don't uncomment, if your export feature is active)
// session_cache_limiter ('private, must-revalidate');
// # uncomment, if your export feature (or movable rows) is active
// session_start();

// # +---------------------------------------------------------------------------+
// # | 1. Creating & Calling: |
// # +---------------------------------------------------------------------------+
// # *** define a relative (virtual) path to datagrid.class.php file
// # *** (relatively to the current file)
// # *** RELATIVE PATH ONLY ***
define("DATAGRID_DIR", "class/"); /* Ex.: "datagrid/" */
require_once (DATAGRID_DIR . 'datagrid.class.php');

// includes database connection parameters
include_once ('conexion.php');

// ob_start();
// session_start();
// # *** set needed options and create a new class instance
$debug_mode = false; /* display SQL statements while processing */
$messaging = true; /* display system messages on a screen */
$unique_prefix = "vend_"; /* prevent overlays - must be started with a letter */
$mode = isset($_REQUEST[$unique_prefix . 'mode']) ? $_REQUEST[$unique_prefix . 'mode'] : "";
$rid = isset($_REQUEST[$unique_prefix . 'rid']) ? $_REQUEST[$unique_prefix . 'rid'] : "";

$dgrid = new DataGrid($debug_mode, $messaging, $unique_prefix);
// # *** set encoding and collation (default: utf8/utf8_unicode_ci)
$dg_encoding = "utf-8";
$dg_collation = "utf8_general_ci";
$dgrid->SetEncoding($dg_encoding, $dg_collation);
// # *** set data source with required settings
// # *** 1. write all fields separated by commas(,) like: field1, field2 etc.. DON'T USE table.*
// # *** 2. write the primary key in the first place (MUST BE AUTO-INCREMENT NUMERIC!)
$sql = "SELECT id, ingreso_vendedor, cedula_vendedor, nombre_vendedor, comision_vendedor, estado_vendedor FROM vendedor";
$default_order = array(
    "nombre_vendedor" => "ASC"
); /* Ex.: array("field_1"=>"ASC", "field_2"=>"DESC") */
$dgrid->DataSource("PEAR", "mysql", $DB_HOST, $DB_NAME, $DB_USER, $DB_PASS, $sql, $default_order);

// # +---------------------------------------------------------------------------+
// # | 2. General Settings: |
// # +---------------------------------------------------------------------------+
// # +-- PostBack Submission Method ---------------------------------------------+
// # *** defines postback submission method for DataGrid: AJAX, POST(default) or GET
$postback_method = "post";
$dgrid->SetPostBackMethod($postback_method);

// # +-- Cache Settings ---------------------------------------------------------+
// # *** make sure your cache/ dir has 755 (write) permissions
// # *** define caching parameters: 1st - allow caching or not, 2nd - caching lifetime in minutes
// / $dgrid->SetCachingParameters(true, 5);
// # *** delete all caching pages (only if needed)
// / $dgrid->DeleteCache();

// # +-- Languages --------------------------------------------------------------+
// # *** set interface language (default - English)
$dg_language = "es";
$dgrid->SetInterfaceLang($dg_language);
// # *** set direction: "ltr" or "rtr" (default - "ltr")
// / $direction = "ltr";
// / $dgrid->SetDirection($direction);

// # +-- Layouts, Templates & CSS -----------------------------------------------+
// # *** datagrid layouts: "0" - tabular(horizontal) - default, "1" - columnar(vertical), "2" - customized
// # *** use "view"=>"0" and "edit"=>"0" only if you work on the same tables
// # *** filter layouts: "0" - tabular(horizontal) - default, "1" - columnar(vertical), "2" - advanced(inline)
$layouts = array(
    "view" => "0",
    "edit" => "1",
    "details" => "1",
    "filter" => "2"
);
$dgrid->SetLayouts($layouts);
// / *** $mode_template = array("header"=>"", "body"=>"", "footer"=>"");
// / @field_name_1@ - field header
// / {field_name_1} - field value
// / [ADD][CREATE][EDIT][DELETE][BACK][CANCEL][UPDATE][MULTIROW_CHECKBOX][ROWS_NUMERATION] - allowed elements and operations (must be placed in $template['body'] only)
// / $view_template = "";
// / $add_edit_template = "";
// / $details_template = array("header"=>"", "body"=>"", "footer"=>"");
// / $details_template['header'] = "";
// / $details_template['body'] = "<table><tr><td>{field_name_1}</td><td>{field_name_2}</td></tr><tr><td>[BACK]</td></tr></table>";
// / $details_template['footer'] = "";
// / $dgrid->SetTemplates($view_template, $add_edit_template, $details_template);
// # *** set modes operations ("type" => "link|button|image")
// # *** "view" - view mode, "edit" - add/edit/details modes,
// # *** "byFieldValue"=>"fieldName" - make the field to be a link to edit mode page
// / $modes = array(
// / "add" =>array("view"=>true, "edit"=>false, "type"=>"link", "show_button"=>true, "show_add_button"=>"inside|outside"),
// / "edit" =>array("view"=>true, "edit"=>true, "type"=>"link", "show_button"=>true, "byFieldValue"=>""),
// / "details" =>array("view"=>true, "edit"=>false, "type"=>"link", "show_button"=>true),
// / "delete" =>array("view"=>true, "edit"=>true, "type"=>"image", "show_button"=>true)
// / );
// / $dgrid->SetModes($modes);
// # *** set CSS class for datagrid
// # *** "default|blue|gray|green|pink|empty|x-blue|x-gray|x-green" or your own css style
$css_class = "x-blue";
$dgrid->SetCssClass($css_class);
// # *** set DataGrid caption
$dg_caption = "<h2 style='margin-top: 20px;'>CAT&Aacute;LOGO DE VENDEDORES</h2>";
$dgrid->SetCaption($dg_caption);
// #
// # +-- Scrolling --------------------------------------------------------------+
// # *** allow scrolling on datagrid
// / $scrolling_option = false;
// / $dgrid->AllowScrollingSettings($scrolling_option);
// # *** set scrolling settings (optional)
// / $scrolling_height = "100px"; /* ex.: "190px" or "190" */
// / $dgrid->SetScrollingSettings($scrolling_height);
// #
// # +-- Multirow Operations ----------------------------------------------------+
// # *** allow multirow operations
$multirow_option = true;
$dgrid->AllowMultirowOperations($multirow_option);
$multirow_operations = array(
    "edit" => array(
        "view" => true
    ),
    "details" => array(
        "view" => true
    ),
    "clone" => array(
        "view" => false
    ),
    "delete" => array(
        "view" => true
    )
    // / "my_operation_name" => array("view"=>true, "flag_name"=>"my_flag_name", "flag_value"=>"my_flag_value", "tooltip"=>"Do something with selected", "image"=>"image.gif")
);
$dgrid->SetMultirowOperations($multirow_operations);
// #
// # +-- Passing parameters & setting up other DataGrids ------------------------+
// # *** set variables that used to get access to the page (like: my_page.php?act=34&id=56 etc.)
// / $http_get_vars = array("act", "id");
// / $dgrid->SetHttpGetVars($http_get_vars);
// # *** set other datagrid/s unique prefixes (if you use few datagrids on one page)
// # *** format (in which mode to allow processing of another datagrids)
// # *** array("unique_prefix"=>array("view"=>true|false, "edit"=>true|false, "details"=>true|false));
// / $anotherDatagrids = array("abcd_"=>array("view"=>true, "edit"=>true, "details"=>true));
// / $dgrid->SetAnotherDatagrids($anotherDatagrids);

// # +---------------------------------------------------------------------------+
// # | 3. Printing & Exporting Settings: |
// # +---------------------------------------------------------------------------+
// # *** set printing option: true(default) or false
$printing_option = false;
$dgrid->AllowPrinting($printing_option);
// #
// # +-- Exporting --------------------------------------------------------------+
// # *** initialize the session with session_start();
// # *** default exporting directory: tmp/export/
$exporting_option = true;
$export_all = true;
$dgrid->AllowExporting($exporting_option, $export_all);
$exporting_types = array(
    'csv' => 'true',
    'xls' => 'true',
    'pdf' => 'true',
    'xml' => 'true'
);
$dgrid->AllowExportingTypes($exporting_types);

// # +---------------------------------------------------------------------------+
// # | 4. Sorting & Paging Settings: |
// # +---------------------------------------------------------------------------+
// # *** set sorting option: true(default) or false
// / $sorting_option = true;
// / $dgrid->AllowSorting($sorting_option);
// # *** set paging option: true(default) or false
$paging_option = true;
$rows_numeration = false;
$numeration_sign = "N #";
$dropdown_paging = false;
$dgrid->AllowPaging($paging_option, $rows_numeration, $numeration_sign, $dropdown_paging);
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
    "10" => "10",
    "12" => "12",
    "25" => "25",
    "50" => "50",
    "100" => "100",
    "250" => "250",
    "500" => "500",
    "1000" => "1000"
);
$default_page_size = 12;
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
$filtering_option = true;
$show_search_type = true;
$dgrid->AllowFiltering($filtering_option, $show_search_type);
// # *** set additional filtering settings
// # *** use "," (comma) if you want to make search by some words, for ex.: hello, bye, hi
// # *** you have to change search type to OR when you search multi-fields, for ex.: "first_name, last_name"
// # *** "field_type" (optional, for range search) may be "from" or "to"
// # *** "date_format" may be "date|datedmy|datemdy|datetime|time"
// # *** "default_operator" may be =|<|>|like|%like|like%|%like%|not like
// # *** "handler"=>"" - write here path relatively to DATAGRID_DIR (where datagrid.class.php is found)
// # *** "field_view"=>"fieldName_2" or "field_view"=>"CONCAT(first_name, ' ', last_name) as full_name"
// / $fill_from_array = array("0"=>"No", "1"=>"Yes"); /* as "value"=>"option" */
$filtering_fields = array(
    "Identificaci&oacute;n" => array(
        "type" => "textbox",
        "table" => "vendedor",
        "table_alias" => "",
        "field" => "cedula_vendedor",
        "filter_condition" => "",
        "show_operator" => "false",
        "default_operator" => "like%",
        "case_sensitive" => "false",
        "comparison_type" => "string",
        "width" => "120px",
        "on_js_event" => "",
        "default" => ""
    ),
    "Nombre del Vendedor" => array(
        "type" => "textbox",
        "table" => "vendedor",
        "table_alias" => "",
        "field" => "nombre_vendedor",
        "filter_condition" => "",
        "show_operator" => "false",
        "default_operator" => "%like%",
        "case_sensitive" => "false",
        "comparison_type" => "string",
        "width" => "120px",
        "on_js_event" => "",
        "default" => ""
    ),
    "Ingreso" => array(
        "type" => "calendar",
        "table" => "vendedor",
        "table_alias" => "",
        "field" => "ingreso_vendedor",
        "filter_condition" => "",
        "show_operator" => "false",
        "default_operator" => "=",
        "case_sensitive" => "false",
        "comparison_type" => "string",
        "width" => "120px",
        "on_js_event" => "",
        "default" => "",
        "calendar_type" => "popup|floating",
        "date_format" => "date",
        "field_type" => ""
    )
);
$dgrid->SetFieldsFiltering($filtering_fields);
// # *** allow default filtering: default - false
// / $default_filtering_option = true;
// / $dgrid->AllowDefaultFiltering($default_filtering_option);

// # +---------------------------------------------------------------------------+
// # | 6. View Mode Settings: |
// # +---------------------------------------------------------------------------+
// # *** set view mode table properties
// / $vm_table_properties = array("width"=>"90%");
// / $dgrid->SetViewModeTableProperties($vm_table_properties);
// # *** set columns in view mode
// # *** Ex.: "on_js_event"=>"onclick='alert(\"Yes!!!\");'"
// # *** "barchart" : number format in SELECT SQL must be equal with number format of max_value
$fill_from_array = array(
    "0" => "No",
    "1" => "Yes",
    "2" => "Don't know",
    "3" => "My be"
); /* as "value"=>"option" */
$vm_columns = array(
    "ingreso_vendedor" => array(
        "header" => "Ingreso",
        "type" => "label",
        "align" => "center",
        "width" => "90px",
        "wrap" => "wrap",
        "text_length" => "-1",
        "tooltip" => "false",
        "tooltip_type" => "simple",
        "case" => "normal",
        "summarize" => "false",
        "sort_type" => "string",
        "sort_by" => "",
        "visible" => "true",
        "on_js_event" => ""
    ),
    "cedula_vendedor" => array(
        "header" => "Identificaci&oacute;n",
        "type" => "label",
        "align" => "left",
        "width" => "14",
        "wrap" => "wrap",
        "text_length" => "14",
        "maxlength" => "14",
        "tooltip" => "false",
        "tooltip_type" => "simple",
        "case" => "normal",
        "summarize" => "false",
        "sort_type" => "string",
        "sort_by" => "",
        "visible" => "true",
        "on_js_event" => ""
    ),
    "nombre_vendedor" => array(
        "header" => "Nombre del vendedor",
        "type" => "label",
        "align" => "left",
        "width" => "",
        "wrap" => "wrap",
        "text_length" => "",
        "maxlength" => "",
        "tooltip" => "false",
        "tooltip_type" => "simple",
        "case" => "normal",
        "summarize" => "false",
        "sort_type" => "string",
        "sort_by" => "",
        "visible" => "true",
        "on_js_event" => ""
    ),
    "estado_vendedor" => array(
        "header" => "Activo",
        "type" => "checkbox",
        "align" => "center",
        "width" => "80px",
        "wrap" => "wrap|nowrap",
        "sort_type" => "numeric",
        "sort_by" => "",
        "visible" => "true",
        "on_js_event" => "",
        "true_value" => 1,
        "false_value" => 0
    ),
    "comision_vendedor" => array(
        "header" => "Comisi&oacute;n",
        "type" => "percent",
        "align" => "right",
        "width" => "90px",
        "wrap" => "wrap|nowrap",
        "text_length" => "-1",
        "tooltip" => "false",
        "tooltip_type" => "floating|simple",
        "case" => "normal",
        "summarize" => "true",
        "summarize_sign" => "PROM. %=",
        "summarize_function" => "AVG",
        "sort_type" => "numeric",
        "sort_by" => "",
        "visible" => "true",
        "on_js_event" => "",
        "decimal_places" => "2",
        "dec_separator" => "."
    )
);
$dgrid->SetColumnsInViewMode($vm_columns);
// # *** set auto-generated columns in view mode
// $auto_column_in_view_mode = false;
// $dgrid->SetAutoColumnsInViewMode($auto_column_in_view_mode);

// # +---------------------------------------------------------------------------+
// # | 7. Add/Edit/Details Mode Settings: |
// # +---------------------------------------------------------------------------+
// # *** set add/edit mode table properties
$em_table_properties = array(
    "width" => "70%"
);
$dgrid->SetEditModeTableProperties($em_table_properties);
// # *** set details mode table properties
$dm_table_properties = array(
    "width" => "70%"
);
$dgrid->SetDetailsModeTableProperties($dm_table_properties);
// # *** define settings for add/edit/details modes
$table_name = "vendedor";
$primary_key = "id";
// # for ex.: "table_name.field = ".$_REQUEST['abc_rid'];
$condition = "";
$dgrid->SetTableEdit($table_name, $primary_key, $condition);
// # *** set columns in edit mode
$em_columns = array(

    "ingreso_vendedor" => array(
        "header" => "Fecha de Ingreso",
        "type" => "date",
        "req_type" => "st",
        "width" => "187px",
        "title" => "",
        "readonly" => "false",
        "maxlength" => "-1",
        "default" => "",
        "unique" => "false",
        "unique_condition" => "",
        "visible" => "true",
        "on_js_event" => "",
        "calendar_type" => "dropdownlist"
    ),
    "cedula_vendedor" => array(
        "header" => "C&eacute;dula de identificaci&oacute;n",
        "type" => "textbox",
        "req_type" => "ry",
        "width" => "210px",
        "title" => "",
        "readonly" => "false",
        "maxlength" => "14",
        "text_length" => "14",
        "default" => "",
        "unique" => true,
        "unique_condition" => "",
        "visible" => "true",
        "on_js_event" => ""
    ),
    "nombre_vendedor" => array(
        "header" => "Nombre del vendedor",
        "type" => "textbox",
        "req_type" => "ry",
        "width" => "210px",
        "title" => "",
        "readonly" => "false",
        "maxlength" => "",
        "text_length" => "-1",
        "default" => "",
        "unique" => "false",
        "unique_condition" => "",
        "visible" => "true",
        "on_js_event" => ""
    ),
    "comision_vendedor" => array(
        "header" => "Comisi&oacute;n",
        "type" => "percent",
        "req_type" => "rt",
        "width" => "70px",
        "title" => "",
        "readonly" => "false",
        "maxlength" => "4",
        "default" => "",
        "unique" => "false",
        "unique_condition" => "",
        "visible" => "true",
        "on_js_event" => "",
        "decimal_places" => "2",
        "dec_separator" => "."
    ),
    "estado_vendedor" => array(
        "header" => "Activo",
        "type" => "checkbox",
        "req_type" => "st",
        "width" => "210px",
        "title" => "",
        "readonly" => "false",
        "maxlength" => "-1",
        "default" => "",
        "unique" => "false",
        "unique_condition" => "",
        "visible" => "true",
        "on_js_event" => "",
        "true_value" => 1,
        "false_value" => 0
    )
);

if ($mode == "details") {
    $em_columns["field_link"] = array(
        "header" => "Link (details mode)",
        "type" => "link",
        "req_type" => "st",
        "width" => "210px",
        "title" => "",
        "readonly" => "false",
        "maxlength" => "-1",
        "default" => "",
        "unique" => "false",
        "unique_condition" => "",
        "visible" => true,
        "on_js_event" => "",
        "field_key" => "field_link",
        "field_data" => "field_link",
        "rel" => "",
        "title" => "",
        "target" => "_blank",
        "href" => "{0}"
    );
}

$dgrid->SetColumnsInEditMode($em_columns);
// # *** set auto-generated columns in edit mode
// $auto_column_in_edit_mode = false;
// $dgrid->SetAutoColumnsInEditMode($auto_column_in_edit_mode);

// #
// ###############################################################################
$dgrid->WriteCssClass();
// ###############################################################################
// # +---------------------------------------------------------------------------+
// # | 9. Bind the DataGrid: |
// # +---------------------------------------------------------------------------+
// # *** bind the DataGrid and draw it on the screen
// # *** you may use $dgrid->Bind(false) and then $dgrid->Show() to separate
// # *** binding and displaying id datagrid
$dgrid->Bind();
// ob_end_flush();
// ###############################################################################
require_once 'footer.php';
?>