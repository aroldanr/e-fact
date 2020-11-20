<?php
require_once 'header.php';

$mode = isset($_REQUEST['prd_mode']) ? $_REQUEST['prd_mode'] : "";

// ###############################################################################
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

ob_start();
// # *** set needed options and create a new class instance
$debug_mode = false; /* display SQL statements while processing */
$messaging = true; /* display system messages on a screen */
$unique_prefix = "prd_"; /* prevent overlays - must be started with a letter */
$dgrid = new DataGrid($debug_mode, $messaging, $unique_prefix);
// # *** set encoding and collation (default: utf8/utf8_unicode_ci)
$dg_encoding = "utf8";
$dg_collation = "utf8_spanish_ci";
$dgrid->SetEncoding($dg_encoding, $dg_collation);
// # *** set data source with needed options
// # *** put a primary key on the first place
$sql = "SELECT
            articulo.id,
            articulo.id_categoria,
            articulo.codigo_articulo,
            articulo.ingreso_articulo,
            categoria.nombre_categoria,
            proveedor.nombre_proveedor,
            articulo.nombre_articulo,
            articulo.imagen1_articulo,
            articulo.imagen2_articulo,
            articulo.costo_articulo,
            articulo.precio_articulo,
            articulo.existencia_articulo
        FROM
            articulo
        INNER JOIN categoria ON articulo.id_categoria = categoria.id
        INNER JOIN proveedor ON articulo.id_proveedor = proveedor.id";
$default_order = array(
    "articulo.nombre_articulo" => "ASC"
);
$dgrid->DataSource("PEAR", "mysql", $DB_HOST, $DB_NAME, $DB_USER, $DB_PASS, $sql, $default_order);

// # +---------------------------------------------------------------------------+
// # | 2. General Settings: |
// # +---------------------------------------------------------------------------+
$dg_language = "es";
$dgrid->SetInterfaceLang($dg_language);
// # *** allow multirow operations
$multirow_option = true;
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
// # *** "default|blue|gray|green|pink|empty|x-blue|x-gray|x-green" or your own css style
$css_class = "x-blue";
$dgrid->SetCssClass($css_class);

// # *** "default" or "blue" or "gray" or "green" or "pink" or your own css file
// # *** set DataGrid caption
$dg_caption = "<h2 style='margin-top: 20px;'>CAT&Aacute;LOGO DE PRODUCTOS</h2>";
$dgrid->SetCaption($dg_caption);

// # +---------------------------------------------------------------------------+
// # | 3. Printing & Exporting Settings: |
// # +---------------------------------------------------------------------------+
// # *** set printing option: true(default) or false
$printing_option = true;
$dgrid->AllowPrinting($printing_option);

// # +---------------------------------------------------------------------------+
// # | 4. Sorting & Paging Settings: |
// # +---------------------------------------------------------------------------+
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
    "10" => "10",
    "25" => "25",
    "50" => "50",
    "100" => "100",
    "250" => "250",
    "500" => "500",
    "1000" => "1000"
);
$default_page_size = 10;
$dgrid->SetPagingSettings($bottom_paging, $top_paging, $pages_array, $default_page_size);

// # +---------------------------------------------------------------------------+
// # | 5. Filter Settings: |
// # +---------------------------------------------------------------------------+
// # *** set filtering option: true or false(default)
$filtering_option = true;
$show_search_type = true;
$dgrid->AllowFiltering($filtering_option, $show_search_type);
// # *** set additional filtering settings
// # *** tips: use "," (comma) if you want to make search by some words, for ex.: hello, bye, hi
$filtering_fields = array(
    "Código del producto: " => array(
        "type" => "textbox",
        "table" => "articulo",
        "table_alias" => "",
        "field" => "codigo_articulo",
        "filter_condition" => "",
        "show_operator" => "false",
        "default_operator" => "like%",
        "case_sensitive" => "false",
        "comparison_type" => "string",
        "width" => "",
        "on_js_event" => "",
        "default" => ""
    ),
    "Nombre del producto: " => array(
        "type" => "textbox",
        "table" => "articulo",
        "table_alias" => "",
        "field" => "nombre_articulo",
        "filter_condition" => "",
        "show_operator" => "false",
        "default_operator" => "%like%",
        "case_sensitive" => "false",
        "comparison_type" => "string",
        "width" => "",
        "on_js_event" => "",
        "default" => ""
    ),
    "Proveedor: " => array(
        "type" => "enum",
        "table" => "proveedor",
        "field" => "nombre_proveedor",
        "order" => "ASC",
        "source" => "self",
        "show" => "",
        "condition" => "",
        "show_operator" => "false",
        "default_operator" => "=",
        "case_sensitive" => "false",
        "comparison_type" => "string",
        "width" => "",
        "multiple" => "false",
        "multiple_size" => "4",
        "on_js_event" => ""
    ),
    "Desde: " => array(
        "type" => "calendar",
        "table" => "articulo",
        "field" => "ingreso_articulo",
        "calendar_type" => "floating",
        "field_type" => "from",
        "show_operator" => "false",
        "default_operator" => ">=",
        "case_sensitive" => "false",
        "comparison_type" => "string",
        "width" => "",
        "on_js_event" => ""
    ),
    "Hasta: " => array(
        "type" => "calendar",
        "table" => "articulo",
        "field" => "ingreso_articulo",
        "calendar_type" => "floating",
        "field_type" => "to",
        "show_operator" => "false",
        "default_operator" => "<=",
        "case_sensitive" => "false",
        "comparison_type" => "string",
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
    "width" => "65%"
);
$dgrid->SetViewModeTableProperties($vm_table_properties);
// # *** set columns in view mode
// # *** Ex.: "on_js_event"=>"onclick='alert(\"Yes!!!\");'"
// # *** "barchart" : number format in SELECT SQL must be equal with number format in max_value
$vm_colimns = array(
    "codigo_articulo" => array(
        "header" => "Código",
        "type" => "linktoedit",
        "header_tooltip" => "",
        "header_tooltip_type" => "simple",
        "align" => "left",
        "width" => "",
        "wrap" => "nowrap",
        "text_length" => "-1",
        "tooltip" => "false",
        "tooltip_type" => "floating|simple",
        "case" => "normal",
        "summarize" => "false",
        "sort_type" => "string",
        "sort_by" => "",
        "visible" => "true",
        "on_js_event" => ""
    ),
    "nombre_articulo" => array(
        "header" => "Nombre del Producto",
        "type" => "linktoedit",
        "header_tooltip" => "",
        "header_tooltip_type" => "simple",
        "align" => "left",
        "width" => "",
        "wrap" => "nowrap",
        "text_length" => "-1",
        "tooltip" => "false",
        "tooltip_type" => "floating|simple",
        "case" => "normal",
        "summarize" => "false",
        "sort_type" => "string",
        "sort_by" => "",
        "visible" => "true",
        "on_js_event" => ""
    ),
    "ingreso_articulo" => array(
        "header" => "Fecha de Ingreso",
        "type" => "label",
        "header_tooltip" => "",
        "header_tooltip_type" => "simple",
        "align" => "left",
        "width" => "",
        "wrap" => "nowrap",
        "text_length" => "-1",
        "tooltip" => "false",
        "tooltip_type" => "floating|simple",
        "case" => "normal",
        "summarize" => "false",
        "sort_type" => "string",
        "sort_by" => "",
        "visible" => "true",
        "on_js_event" => ""
    ),
    "imagen1_articulo" => array(
        "header" => "Imagen",
        "type" => "image",
        "align" => "center",
        "width" => "58x",
        "wrap" => "nowrap",
        "text_length" => "-1",
        "tooltip" => "false",
        "tooltip_type" => "floating|simple",
        "case" => "normal|upper|lower|camel",
        "summarize" => "false",
        "sort_type" => "string|numeric",
        "sort_by" => "",
        "visible" => "true",
        "on_js_event" => "",
        "target_path" => "uploads/",
        "default" => "default_image.ext",
        "image_width" => "50px",
        "image_height" => "30px",
        "magnify" => "true",
        "magnify_type" => "magnifier",
        "magnify_power" => "3"
    ),
    "nombre_categoria" => array(
        "header" => "Categor&iacute;a",
        "type" => "linktoview",
        "align" => "center",
        "width" => "",
        "wrap" => "nowrap",
        "text_length" => "-1",
        "tooltip" => "false",
        "tooltip_type" => "floating|simple",
        "case" => "normal",
        "summarize" => "false",
        "sort_type" => "string",
        "sort_by" => "",
        "visible" => "true",
        "on_js_event" => ""
    ),
    "nombre_proveedor" => array(
        "header" => "Proveedor",
        "type" => "linktoview",
        "align" => "center",
        "width" => "",
        "wrap" => "nowrap",
        "text_length" => "-1",
        "tooltip" => "false",
        "tooltip_type" => "floating|simple",
        "case" => "normal",
        "summarize" => "false",
        "sort_type" => "string",
        "sort_by" => "",
        "visible" => "true",
        "on_js_event" => ""
    ),
    "costo_articulo" => array(
        "header" => "Costo",
        "type" => "money",
        "align" => "right",
        "width" => "",
        "wrap" => "nowrap",
        "text_length" => "-1",
        "tooltip" => "false",
        "tooltip_type" => "floating|simple",
        "case" => "normal|upper|lower|camel",
        "summarize" => "true",
        "sort_type" => "string|numeric",
        "sort_by" => "",
        "visible" => "true",
        "on_js_event" => "",
        "sign" => "C$",
        "decimal_places" => "2",
        "dec_separator" => ".",
        "thousands_separator" => ","
    ),
    "precio_articulo" => array(
        "header" => "Precio",
        "type" => "money",
        "align" => "right",
        "width" => "",
        "wrap" => "nowrap",
        "text_length" => "-1",
        "tooltip" => "false",
        "tooltip_type" => "floating|simple",
        "case" => "normal|upper|lower|camel",
        "summarize" => "true",
        "sort_type" => "string|numeric",
        "sort_by" => "",
        "visible" => "true",
        "on_js_event" => "",
        "sign" => "C$",
        "decimal_places" => "2",
        "dec_separator" => ".",
        "thousands_separator" => ","
    ),
    "existencia_articulo" => array(
        "header" => "Existencia",
        "type" => "textbox",
        "header_tooltip" => "",
        "header_tooltip_type" => "simple",
        "align" => "right",
        "width" => "",
        "wrap" => "nowrap",
        "text_length" => "-1",
        "tooltip" => "false",
        "tooltip_type" => "floating|simple",
        "case" => "normal",
        "summarize" => "false",
        "sort_type" => "numeric",
        "sort_by" => "",
        "visible" => "true",
        "on_js_event" => ""
    )
);
$dgrid->SetColumnsInViewMode($vm_colimns);

// # +---------------------------------------------------------------------------+
// # | 7. Add/Edit/Details Mode Settings: |
// # +---------------------------------------------------------------------------+
// # *** set add/edit mode table properties
$em_table_properties = array(
    "width" => "50%"
);
$dgrid->SetEditModeTableProperties($em_table_properties);
// # *** set details mode table properties
$dm_table_properties = array(
    "width" => "50%"
);
$dgrid->SetDetailsModeTableProperties($dm_table_properties);
// # *** set settings for add/edit/details modes
$table_name = "articulo";
$primary_key = "id";
$condition = "";
$dgrid->SetTableEdit($table_name, $primary_key, $condition);

$fill_from_array_sales = array();
for ($i = 1; $i < 100; $i ++) {
    $fill_from_array_sales[$i] = $i;
}

$em_columns = array(
    "delimiter_0" => array(
        "inner_html" => "<div style='padding:5px;'>Calcule el precio de venta basado en el costo del art&iacute;culo.</div>"
    ),
    "codigo_articulo" => array(
        "header" => "Código del Producto",
        "type" => "textbox",
        "req_type" => "rt",
        "width" => "210px",
        "title" => "",
        "readonly" => "false",
        "maxlength" => "-1",
        "default" => "",
        "unique" => "false",
        "unique_condition" => "",
        "visible" => "true",
        "on_js_event" => ""
    ),
    "nombre_articulo" => array(
        "header" => "Nombre del Producto",
        "type" => "textbox",
        "req_type" => "rt",
        "width" => "210px",
        "title" => "",
        "readonly" => "false",
        "maxlength" => "-1",
        "default" => "",
        "unique" => "false",
        "unique_condition" => "",
        "visible" => "true",
        "on_js_event" => ""
    ),
    "id_categoria" => array(
        "header" => "Categor&iacute;a",
        "type" => "foreign_key",
        "req_type" => "ri",
        "width" => "210px",
        "title" => "",
        "readonly" => "false",
        "default" => "",
        "unique" => "false",
        "unique_condition" => "",
        "visible" => "true"
    ),
    "id_proveedor" => array(
        "header" => "Proveedor",
        "type" => "foreign_key",
        "req_type" => "ri",
        "width" => "210px",
        "title" => "",
        "readonly" => "false",
        "default" => "",
        "unique" => "false",
        "unique_condition" => "",
        "visible" => "true"
    ),
    "imagen1_articulo" => array(
        "header" => "Imagen Peque&ntilde;a",
        "type" => "image",
        "req_type" => "st",
        "width" => "220px",
        "title" => "",
        "readonly" => "false",
        "maxlength" => "-1",
        "default" => "",
        "unique" => "false",
        "unique_condition" => "",
        "visible" => "true",
        "on_js_event" => "",
        "target_path" => "uploads/",
        "max_file_size" => "200K",
        "image_width" => "120px",
        "image_height" => "90px",
        "magnify" => "true",
        "magnify_type" => "lightbox",
        "file_name" => "img_" . (($mode == "add") ? $dgrid->GetRandomString("10") : $dgrid->GetCurrentId()),
        "host" => "local",
        "pre_addition" => "Clic en la imagen para agrandar...<br>"
    ),
    "imagen2_articulo" => array(
        "header" => "Imagen Grande",
        "type" => "image",
        "req_type" => "st",
        "width" => "220px",
        "title" => "",
        "readonly" => "false",
        "maxlength" => "-1",
        "default" => "",
        "unique" => "false",
        "unique_condition" => "",
        "visible" => "true",
        "on_js_event" => "",
        "target_path" => "uploads/",
        "max_file_size" => "500K",
        "image_width" => "240px",
        "image_height" => "180px",
        "magnify" => "true",
        "magnify_type" => "lightbox",
        "file_name" => "img_" . (($mode == "add") ? $dgrid->GetRandomString("10") : $dgrid->GetCurrentId()),
        "host" => "local",
        "pre_addition" => "Clic en la imagen para agrandar...<br>"
    ),
    "ingreso_articulo" => array(
        "header" => "Fecha de ingreso",
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
        "calendar_type" => "floating"
    ),
    "costo_articulo" => array(
        "header" => "Precio de Costo",
        "type" => "textbox",
        "req_type" => "rf",
        "width" => "90px",
        "title" => "",
        "readonly" => "false",
        "maxlength" => "12",
        "default" => "",
        "unique" => "false",
        "unique_condition" => "",
        "visible" => "true",
        "on_js_event" => "",
        "pre_addition" => "C$"
    ),
    "precio_articulo" => array(
        "header" => "Precio de Venta",
        "type" => "textbox",
        "req_type" => "rf",
        "width" => "90px",
        "title" => "",
        "readonly" => "false",
        "maxlength" => "12",
        "default" => "",
        "unique" => "false",
        "unique_condition" => "",
        "visible" => "true",
        "on_js_event" => "",
        "pre_addition" => "C$"
    ),
    "existencia_articulo" => array(
        "header" => "Productos en existencia",
        "type" => "textbox",
        "req_type" => "st",
        "width" => "55px",
        "title" => "",
        "readonly" => true,
        "maxlength" => "-1",
        "default" => "",
        "unique" => "false",
        "unique_condition" => "",
        "visible" => "true",
        "on_js_event" => ""
    )
);
$dgrid->SetColumnsInEditMode($em_columns);
// # *** set auto-generated columns in edit mode
$auto_column_in_edit_mode = false;
$dgrid->SetAutoColumnsInEditMode($auto_column_in_edit_mode);
// # *** set foreign keys for add/edit/details modes (if there are linked tables)
// # *** Ex.: "field_name"=>"CONCAT(field1,','field2) as field3"
// # *** Ex.: "condition"=>"TableName_1.FieldName > 'a' AND TableName_1.FieldName < 'c'"
// # *** Ex.: "on_js_event"=>"onclick='alert(\"Yes!!!\");'"
$foreign_keys = array(
    "id_categoria" => array(
        "table" => "categoria",
        "field_key" => "id",
        "field_name" => "nombre_categoria",
        "view_type" => "dropdownlist",
        "radiobuttons_alignment" => "horizontal|vertical",
        "condition" => "",
        "order_by_field" => "nombre_categoria",
        "order_type" => "ASC",
        "on_js_event" => ""
    ),
    "id_proveedor" => array(
        "table" => "proveedor",
        "field_key" => "id",
        "field_name" => "nombre_proveedor",
        "view_type" => "dropdownlist",
        "radiobuttons_alignment" => "horizontal|vertical",
        "condition" => "",
        "order_by_field" => "nombre_proveedor",
        "order_type" => "ASC",
        "on_js_event" => ""
    )
);
$dgrid->SetForeignKeysEdit($foreign_keys);

// # +---------------------------------------------------------------------------+
// # | 8. Bind the DataGrid: |
// # +---------------------------------------------------------------------------+
// # *** bind the DataGrid and draw it on the screen
$dgrid->Bind();
ob_end_flush();

// ###############################################################################
function my_format_date($last_login_time)
{
    $last_login = @mktime(substr($last_login_time, 11, 2), substr($last_login_time, 14, 2), substr($last_login_time, 17, 2), substr($last_login_time, 5, 2), substr($last_login_time, 8, 2), substr($last_login_time, 0, 4));
    if ($last_login_time != "") {
        return @date("M d, Y g:i A", $last_login);
    } else
        return "";
}
require_once 'footer.php';
?>