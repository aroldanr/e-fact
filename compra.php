<?php
require_once 'header.php';

$mode = isset($_REQUEST['f_mode']) ? $_REQUEST['f_mode'] : "";

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
$unique_prefix = "f_"; /* prevent overlays - must be started with a letter */
$dgrid = new DataGrid($debug_mode, $messaging, $unique_prefix);
// # *** set data source with needed options
// # *** put a primary key on the first place
$sql = "SELECT
            enc_compra.id,
            enc_compra.numero,
            enc_compra.fecha,
            enc_compra.id_proveedor,
            proveedor.nombre_proveedor,
            enc_compra.activa,
            'Imprimir' as link_to_print
        FROM
            enc_compra
        INNER JOIN proveedor ON enc_compra.id_proveedor = proveedor.id";
$default_order = array(
    "enc_compra.numero" => "DESC",
    "enc_compra.fecha" => "DESC"
);
$dgrid->DataSource("PEAR", "mysql", $DB_HOST, $DB_NAME, $DB_USER, $DB_PASS, $sql, $default_order);
$dgrid->controlsDisplayingType = "grouped";

// # +---------------------------------------------------------------------------+
// # | 2. General Settings: |
// # +---------------------------------------------------------------------------+
// # *** set encoding and collation (default: utf8/utf8_unicode_ci)
$dg_encoding = "utf8";
$dg_collation = "utf8_spanish_ci";
$dgrid->SetEncoding($dg_encoding, $dg_collation);
// # *** set interface language (default - English)
// # *** (en) - English (de) - German (se) Swedish (hr) - Bosnian/Croatian
// # *** (hu) - Hungarian (es) - Espanol (ca) - Catala (fr) - Francais
// # *** (nl) - Netherlands/"Vlaams"(Flemish) (it) - Italiano (pl) - Polish
// # *** (ch) - Chinese (sr) - Serbian
$dg_language = "es";
$dgrid->SetInterfaceLang($dg_language);
// # *** set direction: "ltr" or "rtr" (default - "ltr")
$direction = "ltr";
$dgrid->SetDirection($direction);
// # *** set layouts: 0 - tabular(horizontal) - default, 1 - columnar(vertical)
$layouts = array(
    "view" => "0",
    "edit" => "1",
    "details" => "2",
    "filter" => "1"
);
$dgrid->SetLayouts($layouts);

$details_template = array(
    "header" => "",
    "body" => "",
    "footer" => ""
);
$details_template['body'] = "        
        <table dir='ltr' class='x-blue_dg_table' align='center' width='60%' height='140px'>
        <tr class='class_tr' bgcolor='#F7F9FB'>
            <td width='20%' class='class_td' align='center'>{delimiter_1}{picture_url}</td>
            <td width='20%' class='class_td' align='center'>{delimiter_2}{picture_url_1}</td>
            <td width='60%'>
                <table border=0>
                    <tr class='class_tr'><td class='x-blue_dg_td class_left' style='border:0px' nowrap><b>Region:</b> </td><td class='x-blue_dg_td class_left'  style='border:0px'>{region_id}</td></tr>
                    <tr class='class_tr'><td class='x-blue_dg_td class_left' style='border:0px' nowrap><b>Country:</b> </td><td class='x-blue_dg_td class_left'  style='border:0px'>{name}</td></tr>
                    <tr class='class_tr'><td class='x-blue_dg_td class_left' style='border:0px' nowrap><b>Independence Day:</b> </td><td class='x-blue_dg_td class_left'  style='border:0px'>{independent_date}</td></tr>
                    <tr class='class_tr'><td class='x-blue_dg_td class_left' style='border:0px' nowrap><b>Democracy?</b> </td><td class='x-blue_dg_td class_left'  style='border:0px'>{is_democracy}</td></tr>
                    <tr class='class_tr'><td class='x-blue_dg_td class_left' style='border:0px' nowrap><b>Population:</b> </td><td class='x-blue_dg_td class_left'  style='border:0px'>{population}</td></tr>
                    <tr class='class_tr'><td class='x-blue_dg_td class_left' style='border:0px' nowrap><b>Description:</b> </td><td class='x-blue_dg_td class_left' style='border:0px'>{description}</td></tr>
                </table>
            </td>
        </tr>    
        </table>
        <br>
        <table dir='ltr'  class='x-blue_dg_table' align='center' width='60%'>
        <tr class='class_tr'>    
            <th width='100px' class='x-blue_dg_th class_right' align='right' wrap >[BACK]</th>
        </tr>
        </table>
        <br><br><br>";
$dgrid->SetTemplates("", "", $details_template);

$scrolling_option = false;
$dgrid->AllowScrollingSettings($scrolling_option);
// # *** set scrolling settings (optional)
$scrolling_width = "90%";
$scrolling_height = "100%";
$dgrid->SetScrollingSettings($scrolling_width, $scrolling_height);

// # *** set modes for operations ("type" => "link|button|image")
// # *** "byFieldValue"=>"fieldName" - make the field to be a link to edit mode page
$modes = array(
    "add" => array(
        "view" => true,
        "edit" => true,
        "type" => "link"
    ),
    "edit" => array(
        "view" => true,
        "edit" => true,
        "type" => "image",
        "byFieldValue" => ""
    ),
    "details" => array(
        "view" => false,
        "edit" => false,
        "type" => "image"
    ),
    "delete" => array(
        "view" => true,
        "edit" => true,
        "type" => "image"
    )
);
$dgrid->SetModes($modes);

// # *** allow mulirow operations
$multirow_option = false;
$dgrid->AllowMultirowOperations($multirow_option);
$multirow_operations = array(
    "delete" => array(
        "view" => false
    ),
    "details" => array(
        "view" => false
    )
);
$dgrid->SetMultirowOperations($multirow_operations);
// # *** set CSS class for datagrid
// # *** "default" or "blue" or "gray" or "green" or your css file relative path with name
$css_class = "x-blue";
$dgrid->SetCssClass($css_class);
// # *** set variables that used to get access to the page (like: my_page.php?act=34&id=56 etc.)
// / $http_get_vars = array("id");
// / $dgrid->SetHttpGetVars($http_get_vars);
// # *** set other datagrid/s unique prefixes (if you use few datagrids on one page)
// # *** format (in wich mode to allow processing of another datagrids)
// # *** array("unique_prefix"=>array("view"=>true|false, "edit"=>true|false, "details"=>true|false));
$anotherDatagrids = array(
    "fp_" => array(
        "view" => false,
        "edit" => true,
        "details" => false
    )
);
$dgrid->SetAnotherDatagrids($anotherDatagrids);
// # *** set DataGrid caption
$dg_caption = "<h2 style='margin-top: 20px;'>REGISTRO DE COMPRAS</h2>";
$dgrid->SetCaption($dg_caption);

// # +---------------------------------------------------------------------------+
// # | 3. Printing & Exporting Settings: |
// # +---------------------------------------------------------------------------+
// # *** set printing option: true(default) or false
$printing_option = true;
$dgrid->AllowPrinting($printing_option);
// # *** set exporting option: true(default) or false
$exporting_option = true;
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
$dgrid->AllowFiltering($filtering_option);
// # *** set aditional filtering settings
$fill_from_array = array(
    "10000" => "10000",
    "250000" => "250000",
    "5000000" => "5000000",
    "25000000" => "25000000",
    "100000000" => "100000000"
);
$filtering_fields = array(
    "Factura No.:" => array(
        "type" => "textbox",
        "table" => "enc_compra",
        "field" => "numero",
        "source" => "self",
        "operator" => true,
        "default_operator" => "=",
        "case_sensitive" => true,
        "comparison_type" => "numeric"
    ),
    "Desde: " => array(
        "type" => "calendar",
        "table" => "enc_compra",
        "field" => "fecha",
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
        "table" => "enc_compra",
        "field" => "fecha",
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
    "width" => "50%"
);
$dgrid->SetViewModeTableProperties($vm_table_properties);
// # *** set columns in view mode
// # *** Ex.: "on_js_event"=>"onclick='alert(\"Yes!!!\");'"
// # *** "barchart" : number format in SELECT SQL must be equal with number format in max_value
$vm_colimns = array(
    "numero" => array(
        "header" => "Factura No.",
        "type" => "label",
        "width" => "130px",
        "align" => "left",
        "wrap" => "nowrap",
        "text_length" => "-1",
        "case" => "normal"
    ),
    "fecha" => array(
        "header" => "Fecha",
        "type" => "label",
        "width" => "130px",
        "align" => "left",
        "wrap" => "nowrap",
        "text_length" => "-1",
        "case" => "normal"
    ),
    "nombre_proveedor" => array(
        "header" => "Proveedor",
        "type" => "linktoedit",
        "align" => "left",
        "width" => "130px",
        "wrap" => "nowrap",
        "text_length" => "-1",
        "case" => "normal",
        "summarize" => false,
        "on_js_event" => ""
    ),
    "activa" => array(
        "header" => "Activa",
        "type" => "checkbox",
        "align" => "center",
        "width" => "80px",
        "wrap" => "wrap|nowrap",
        "sort_type" => "numeric",
        "sort_by" => "",
        "visible" => "true",
        "on_js_event" => "",
        "true_value" => "SI",
        "false_value" => "NO"
    ),
    "link_to_print" => array(
        "header" => "Acci&oacute;n",
        "type" => "link",
        "align" => "left",
        "width" => "5px",
        "wrap" => "wrap|nowrap",
        "text_length" => "-1",
        "tooltip" => "false",
        "tooltip_type" => "floating|simple",
        "case" => "normal|upper|lower|camel",
        "summarize" => "false",
        "summarize_sign" => "",
        "sort_type" => "string|numeric",
        "sort_by" => "",
        "visible" => "true",
        "on_js_event" => "",
        "field_key" => "id",
        "field_key_1" => "field_name_1",
        "field_data" => "link_to_print",
        "rel" => "",
        "title" => "",
        "target" => "_blank",
        "href" => "http://localhost/inventory/print_comp.php?id={0}"
    )
);
$dgrid->SetColumnsInViewMode($vm_colimns);

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
// # *** set settings for add/edit/details modes
$table_name = "enc_compra";
$primary_key = "id";
$condition = "";
$dgrid->SetTableEdit($table_name, $primary_key, $condition);
// # *** set columns in edit mode
// # *** first letter: r - required, s - simple (not required)
// # *** second letter: t - text(including datetime), n - numeric, a - alphanumeric, e - email, f - float, y - any, l - login name, z - zipcode, p - password, i - integer, v - verified
// # *** third letter (optional):
// # for numbers: s - signed, u - unsigned, p - positive, n - negative
// # for strings: u - upper, l - lower, n - normal, y - any
// # *** Ex.: "on_js_event"=>"onclick='alert(\"Yes!!!\");'"
// # *** Ex.: type = textbox|textarea|label|date(yyyy-mm-dd)|datedmy(dd-mm-yyyy)|datetime(yyyy-mm-dd hh:mm:ss)|datetimedmy(dd-mm-yyyy hh:mm:ss)|image|password|enum|print|checkbox
// # *** make sure your WYSIWYG dir has 755 permissions

$em_columns = array(
    "numero" => array(
        "header" => "Factura No.",
        "type" => "textbox",
        "width" => "210px",
        "req_type" => "ry",
        "title" => "",
        "unique" => true
    ),
    "fecha" => array(
        "header" => "Fecha",
        "type" => "date",
        "req_type" => "rt",
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
    "activa" => array(
        "header" => "Activa",
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
        "true_value" => "SI",
        "false_value" => "NO"
    )
);
$dgrid->SetColumnsInEditMode($em_columns);
// # *** set auto-genereted eName_1.FieldName > 'a' AND TableName_1.FieldName < 'c'"
// # *** Ex.: "on_js_event"=>"onclick='alert(\"Yes!!!\");'"
$foreign_keys = array(
    "id_proveedor" => array(
        "table" => "proveedor",
        "field_key" => "id",
        "field_name" => "nombre_proveedor",
        "view_type" => "dropdownlist",
        "order_by_field" => "nombre_proveedor",
        "order_type" => "ASC"
    )
);
$dgrid->SetForeignKeysEdit($foreign_keys);

// # +---------------------------------------------------------------------------+
// # | 8. Bind the DataGrid: |
// # +---------------------------------------------------------------------------+
// # *** bind the DataGrid and draw it on the screen
$dgrid->Bind();
ob_end_flush();
// #
// ###############################################################################

// if we in EDIT mode of the first datagrid
if ($mode == "edit") {

    // # +---------------------------------------------------------------------------+
    // # | 1. Creating & Calling: |
    // # +---------------------------------------------------------------------------+

    ob_start();
    // # *** set needed options and create a new class instance
    $debug_mode = false; /* display SQL statements while processing */
    $messaging = true; /* display system messages on a screen */
    $unique_prefix = "fp_"; /* prevent overlays - must be started with a letter */
    $dgrid1 = new DataGrid($debug_mode, $messaging, $unique_prefix, DATAGRID_DIR);
    // # *** set data source with needed options
    // # *** put a primary key on the first place
    $sql = "SELECT
                det_compra.id,
                det_compra.id_enc_compra,
                articulo.nombre_articulo,
                det_compra.precio,
                det_compra.cantidad,
                det_compra.descuento,
                det_compra.total
            FROM
                det_compra
            INNER JOIN articulo ON det_compra.id_articulo = articulo.id
            WHERE det_compra.id_enc_compra = " . $dgrid->GetCurrentId() . " ";
    $default_order = array(
        "id" => "DESC"
    );
    $dgrid1->DataSource("PEAR", "mysql", $DB_HOST, $DB_NAME, $DB_USER, $DB_PASS, $sql, $default_order);

    // # +---------------------------------------------------------------------------+
    // # | 2. General Settings: |
    // # +---------------------------------------------------------------------------+
    // # *** set encoding and collation (default: utf8/utf8_unicode_ci)
    $dg_encoding = "utf8";
    $dg_collation = "utf8_spanish_ci";
    $dgrid1->SetEncoding($dg_encoding, $dg_collation);
    // # *** set interface language (default - English)
    // # *** (en) - English (de) - German (se) Swedish (hr) - Bosnian/Croatian
    // # *** (hu) - Hungarian (es) - Espanol (ca) - Catala (fr) - Francais
    // # *** (nl) - Netherlands/"Vlaams"(Flemish) (it) - Italiano (pl) - Polish
    // # *** (ch) - Chinese (sr) - Serbian
    $dg_language = "es";
    $dgrid1->SetInterfaceLang($dg_language);
    // # *** set direction: "ltr" or "rtr" (default - "ltr")
    $direction = "ltr";
    $dgrid1->SetDirection($direction);
    // # *** set layouts: 0 - tabular(horizontal) - default, 1 - columnar(vertical)
    $layouts = array(
        "view" => 0,
        "edit" => 1,
        "filter" => 1
    );
    $dgrid1->SetLayouts($layouts);
    // # *** set modes for operations ("type" => "link|button|image")
    // # *** "byFieldValue"=>"fieldName" - make the field to be a link to edit mode page
    if ($mode == "edit") {
        $modes = array(
            "add" => array(
                "view" => true,
                "edit" => false,
                "type" => "link"
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
                "edit" => false,
                "type" => "image"
            )
        );
    } else {
        $modes = array(
            "add" => array(
                "view" => false,
                "edit" => false,
                "type" => "link"
            ),
            "edit" => array(
                "view" => false,
                "edit" => false,
                "type" => "link",
                "byFieldValue" => ""
            ),
            "details" => array(
                "view" => false,
                "edit" => false,
                "type" => "link"
            ),
            "delete" => array(
                "view" => false,
                "edit" => false,
                "type" => "image"
            )
        );
    }
    $dgrid1->SetModes($modes);
    // # *** allow scrolling on datagrid
    $scrolling_option = false;
    $dgrid1->AllowScrollingSettings($scrolling_option);
    // # *** set scrolling settings (optional)
    $scrolling_width = "90%";
    $scrolling_height = "100%";
    $dgrid1->SetScrollingSettings($scrolling_width, $scrolling_height);
    // # *** allow mulirow operations
    $multirow_option = true;
    $dgrid1->AllowMultirowOperations($multirow_option);
    $multirow_operations = array(
        "delete" => array(
            "view" => true
        ),
        "details" => array(
            "view" => true
        )
    );
    $dgrid1->SetMultirowOperations($multirow_operations);
    // # *** set CSS class for datagrid
    // # *** "default" or "blue" or "gray" or "green" or your css file relative path with name
    $css_class = "x-blue";
    $dgrid1->SetCssClass($css_class);
    // # *** set variables that used to get access to the page (like: my_page.php?act=34&id=56 etc.)
    // / $http_get_vars = array("act", "id");
    // / $dgrid1->SetHttpGetVars($http_get_vars);
    // # *** set other datagrid/s unique prefixes (if you use few datagrids on one page)
    // # *** format (in wich mode to allow processing of another datagrids)
    // # *** array("unique_prefix"=>array("view"=>true|false, "edit"=>true|false, "details"=>true|false));
    $anotherDatagrids = array(
        "f_" => array(
            "view" => true,
            "edit" => true,
            "details" => true
        )
    );
    $dgrid1->SetAnotherDatagrids($anotherDatagrids);
    // # *** set DataGrid caption
    $dg_caption = "<h4 style='margin-top: 50px;'>DETALLE DE COMPRAS POR PRODUCTOS</h4>";
    $dgrid1->SetCaption($dg_caption);

    // # +---------------------------------------------------------------------------+
    // # | 3. Printing & Exporting Settings: |
    // # +---------------------------------------------------------------------------+
    // # *** set printing option: true(default) or false
    $printing_option = false;
    $dgrid1->AllowPrinting($printing_option);
    // # *** set exporting option: true(default) or false
    $exporting_option = false;
    $dgrid1->AllowExporting($exporting_option);

    // # +---------------------------------------------------------------------------+
    // # | 4. Sorting & Paging Settings: |
    // # +---------------------------------------------------------------------------+
    // # *** set sorting option: true(default) or false
    $sorting_option = true;
    $dgrid1->AllowSorting($sorting_option);
    // # *** set paging option: true(default) or false
    $paging_option = true;
    $rows_numeration = false;
    $numeration_sign = "N #";
    $dgrid1->AllowPaging($paging_option, $rows_numeration, $numeration_sign);
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
    $dgrid1->SetPagingSettings($bottom_paging, $top_paging, $pages_array, $default_page_size);

    // # +---------------------------------------------------------------------------+
    // # | 5. Filter Settings: |
    // # +---------------------------------------------------------------------------+
    // # *** set filtering option: true or false(default)
    $filtering_option = false;
    $dgrid1->AllowFiltering($filtering_option);
    // # *** set aditional filtering settings
    // / $fill_from_array = array("0"=>"No", "1"=>"Yes"); /* as "value"=>"option" */
    // / $filtering_fields = array(
    // / "Caption_1"=>array("table"=>"tableName_1", "field"=>"fieldName_1", "source"=>"self"|$fill_from_array, "operator"=>false|true, "default_operator"=>"=", "order"=>"ASC|DESC" (optional), "type"=>"textbox|dropdownlist", "case_sensitive"=>false|true, "comparison_type"=>"string|numeric|binary"),
    // / "Caption_2"=>array("table"=>"tableName_2", "field"=>"fieldName_2", "source"=>"self"|$fill_from_array, "operator"=>false|true, "default_operator"=>"=", "order"=>"ASC|DESC" (optional), "type"=>"textbox|dropdownlist", "case_sensitive"=>false|true, "comparison_type"=>"string|numeric|binary"),
    // / "Caption_3"=>array("table"=>"tableName_3", "field"=>"fieldName_3", "source"=>"self"|$fill_from_array, "operator"=>false|true, "default_operator"=>"=", "order"=>"ASC|DESC" (optional), "type"=>"textbox|dropdownlist", "case_sensitive"=>false|true, "comparison_type"=>"string|numeric|binary")
    // / );
    // / $dgrid1->SetFieldsFiltering($filtering_fields);

    // # +---------------------------------------------------------------------------+
    // # | 6. View Mode Settings: |
    // # +---------------------------------------------------------------------------+
    // # *** set view mode table properties
    $vm_table_properties = array(
        "width" => "70%"
    );
    $dgrid1->SetViewModeTableProperties($vm_table_properties);
    // # *** set columns in view mode
    // # *** Ex.: "on_js_event"=>"onclick='alert(\"Yes!!!\");'"
    // # *** "barchart" : number format in SELECT SQL must be equal with number format in max_value
    $vm_colimns = array(
        "nombre_articulo" => array(
            "header" => "Descripci&oacute;n del Producto",
            "type" => "label",
            "align" => "left",
            "wrap" => "wrap",
            "text_length" => "20",
            "case" => "normal"
        ),
        "cantidad" => array(
            "header" => "Cantidad",
            "type" => "label",
            "align" => "right",
            "wrap" => "wrap",
            "text_length" => "20",
            "case" => "normal"
        ),
        "precio" => array(
            "header" => "Precio",
            "type" => "money",
            "align" => "right",
            "width" => "",
            "wrap" => "nowrap",
            "text_length" => "-1",
            "tooltip" => "false",
            "tooltip_type" => "floating|simple",
            "case" => "normal|upper|lower|camel",
            "summarize" => false,
            "sort_type" => "numeric",
            "sort_by" => "",
            "visible" => "true",
            "on_js_event" => "",
            "sign" => "C$",
            "decimal_places" => "2",
            "dec_separator" => ".",
            "thousands_separator" => ","
        ),
        "descuento" => array(
            "header" => "Descuento",
            "type" => "percent",
            "align" => "right",
            "width" => "X%|Xpx",
            "wrap" => "wrap|nowrap",
            "text_length" => "-1",
            "tooltip" => "false",
            "tooltip_type" => "floating|simple",
            "case" => "normal|upper|lower|camel",
            "summarize" => "false",
            "summarize_sign" => "",
            "sort_type" => "numeric",
            "sort_by" => "",
            "visible" => "true",
            "on_js_event" => "",
            "decimal_places" => "2",
            "dec_separator" => "."
        ),
        "total" => array(
            "header" => "Total",
            "type" => "money",
            "align" => "right",
            "width" => "",
            "wrap" => "nowrap",
            "text_length" => "-1",
            "tooltip" => "false",
            "tooltip_type" => "floating|simple",
            "case" => "normal|upper|lower|camel",
            "summarize" => "true",
            "sort_type" => "numeric",
            "sort_by" => "",
            "visible" => "true",
            "on_js_event" => "",
            "sign" => "C$",
            "decimal_places" => "2",
            "dec_separator" => ".",
            "thousands_separator" => ","
        )
    );
    $dgrid1->SetColumnsInViewMode($vm_colimns);
    // # *** set auto-genereted columns in view mode
    // $auto_column_in_view_mode = false;
    // $dgrid1->SetAutoColumnsInViewMode($auto_column_in_view_mode);

    // # +---------------------------------------------------------------------------+
    // # | 7. Add/Edit/Details Mode Settings: |
    // # +---------------------------------------------------------------------------+
    // # *** set add/edit mode table properties
    $em_table_properties = array(
        "width" => "70%"
    );
    $dgrid1->SetEditModeTableProperties($em_table_properties);
    // # *** set details mode table properties
    $dm_table_properties = array(
        "width" => "70%"
    );
    $dgrid1->SetDetailsModeTableProperties($dm_table_properties);
    // # *** set settings for add/edit/details modes
    $table_name = "det_compra";
    $primary_key = "id";
    $condition = "det_compra.id_enc_compra = " . $dgrid->rid . " ";
    $dgrid1->SetTableEdit($table_name, $primary_key, $condition);
    // # *** set columns in edit mode
    // # *** first letter: r - required, s - simple (not required)
    // # *** second letter: t - text(including datetime), n - numeric, a - alphanumeric, e - email, f - float, y - any, l - login name, z - zipcode, p - password, i - integer, v - verified
    // # *** third letter (optional):
    // # for numbers: s - signed, u - unsigned, p - positive, n - negative
    // # for strings: u - upper, l - lower, n - normal, y - any
    // # *** Ex.: "on_js_event"=>"onclick='alert(\"Yes!!!\");'"
    // # *** Ex.: type = textbox|textarea|label|date(yyyy-mm-dd)|datedmy(dd-mm-yyyy)|datetime(yyyy-mm-dd hh:mm:ss)|datetimedmy(dd-mm-yyyy hh:mm:ss)|image|password|enum|print|checkbox
    // # *** make sure your WYSIWYG dir has 777 permissions
    // / $fill_from_array = array("0"=>"No", "1"=>"Yes", "2"=>"Don't know", "3"=>"My be"); /* as "value"=>"option" */
    $em_columns = array(
        "id_enc_compra" => array(
            "header" => "ID_compra",
            "type" => "hidden",
            "req_type" => "ri",
            "width" => "210px",
            "title" => "",
            "readonly" => "false",
            "default" => $dgrid->GetCurrentId(),
            "unique" => "false",
            "unique_condition" => "",
            "visible" => false
        ),
        "id_articulo" => array(
            "header" => "Nombre del Producto",
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
        "cantidad" => array(
            "header" => "Cantidad",
            "type" => "textbox",
            "width" => "50px",
            "req_type" => "rt",
            "title" => "Name"
        ),
        "precio" => array(
            "header" => "Precio",
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
            "pre_addition" => "C$: "
        ),
        "descuento" => array(
            "header" => "Descuento",
            "type" => "percent",
            "req_type" => "st",
            "width" => "80px",
            "title" => "",
            "readonly" => "false",
            "maxlength" => "-1",
            "default" => "",
            "unique" => "false",
            "unique_condition" => "",
            "visible" => "true",
            "on_js_event" => "",
            "decimal_places" => "2",
            "dec_separator" => "."
        )
    );
    $dgrid1->SetColumnsInEditMode($em_columns);
    // # *** set auto-genereted columns in edit mode
    // $auto_column_in_edit_mode = false;
    // $dgrid1->SetAutoColumnsInEditMode($auto_column_in_edit_mode);
    // # *** set foreign keys for add/edit/details modes (if there are linked tables)
    // # *** Ex.: "condition"=>"TableName_1.FieldName > 'a' AND TableName_1.FieldName < 'c'"
    // # *** Ex.: "on_js_event"=>"onclick='alert(\"Yes!!!\");'"
    $foreign_keys = array(
        "id_articulo" => array(
            "table" => "articulo",
            "field_key" => "id",
            "field_name" => "CONCAT(articulo.nombre_articulo, ' | Precio: C$', articulo.precio_articulo) AS producto",
            "view_type" => "dropdownbox",
            "order_by_field" => "producto",
            "order_type" => "ASC"
            // "condition" => "id=" . $dgrid->rid
        )
        // / "For_js_event"=>"")
    );
    $dgrid1->SetForeignKeysEdit($foreign_keys);

    // # +---------------------------------------------------------------------------+
    // # | 8. Bind the DataGrid: |
    // # +---------------------------------------------------------------------------+
    // # *** bind the DataGrid and draw it on the screen
    $dgrid1->Bind();
    ob_end_flush();
    // #
    // ###############################################################################
}
require_once 'footer.php';
?>