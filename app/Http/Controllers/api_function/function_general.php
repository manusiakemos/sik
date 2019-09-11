<?php

namespace App\Http\Controllers\api_function;

class function_general{

    public function getDayOfMonth($month,$year)
    {

        $list=array();

        for ($d = 1; $d <= 31; $d++) {
            $time = mktime(12, 0, 0, $month, $d, $year);
            if (date('m', $time) == $month && date('Y-m-d', $time) <= date('Y-m-d'))
                $list[] = date('Y-m-d', $time);
        }

        return $list;
    }

    function json_convert($data){

        return json_decode(json_encode($data),true);

    }

    function image_url($imageName = ''){
        return $this->public_host().'/images/'.$imageName;
    }

    function public_host(){

        $ArrUrl = explode('/',($_SERVER['HTTP_HOST']=='localhost') ? $_SERVER['REQUEST_URI'] : "/".$_SERVER['REQUEST_URI'] );
        $HOST_URI = ($_SERVER['HTTP_HOST']=='localhost') ? "/".$ArrUrl[1] : "";
        $SITE_HOST = "http://".$_SERVER['HTTP_HOST'].$HOST_URI;

        return $SITE_HOST;

    }

    function testing(){

        return 'testing';
    }

    function get_domain($url) {
        $pieces = parse_url($url);
        $domain = isset($pieces['host']) ? $pieces['host'] : '';
        if (preg_match('/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i', $domain, $regs)) {
            return $regs['domain'];
        }
        return false;
    }

    function parseurl($var)
    {
        $result = (isset($var)) ? $var : "";
        if (strpos($var, "?") > 0)
            $result = substr($var, 0, strpos($var, "?"));
        return $result;
    }

    function current_url()
    {
        $url = "http://";
        if ($_SERVER['HTTP_HOST'] != "localhost") {
            $url .= (strpos($_SERVER['HTTP_HOST'], "www.") === false) ? "www." . $_SERVER['HTTP_HOST'] : $_SERVER['HTTP_HOST'];
        } else {
            $url .= $_SERVER['HTTP_HOST'];
        }
        if ($_SERVER['REQUEST_URI'] != "/" && $_SERVER['REQUEST_URI'] != "") {
            $url .= $_SERVER['REQUEST_URI'];
        }
        return $url;
    }

    function direct_host()
    {

        if (($_SERVER['HTTP_HOST'] != "localhost") && (strpos($_SERVER['HTTP_HOST'], "www.") === false)) {
            header("Location:" . current_url());
            exit;
        }
    }

    function generate_html_desc($string){
        $text = "<!DOCTYPE html><html><head><meta charset=\"utf-8\" /><meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\"><title>Tes</title><meta name=\"viewport\" content=\"width=device-width, initial-scale=1\"></head><body><p>".$string."</p></body></html>";
        return $text;
    }

    function generate_alias($str)
    {
        setlocale(LC_ALL, 'en_US.UTF8');
        $plink = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
        $plink = str_replace(" &amp; ", " ", $plink);
        $plink = preg_replace("/[^a-zA-Z0-9\/_| -]/", '', $plink);
        $plink = strtolower(trim($plink, '-'));
        $plink = preg_replace("/[\/_| -]+/", '-', $plink);
        return $plink;
    }

    function parse_alphanumeric($str)
    {
        $str = strtolower($str);
        setlocale(LC_ALL, 'en_US.UTF8');
        //$plink = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
        $plink = preg_replace("/[^a-zA-Z0-9\/_| -\s]/", '', $str);
        $plink = strtolower(trim($plink, ' '));
        $plink = preg_replace("/[\/_| -]+/", ' ', $plink);
        return $plink;
    }

    function parse_number($str)
    {
        $num = preg_replace('#[^0-9]#', '', $str);

        return $num;
    }

    function realias($var)
    {
        $result = str_replace(".html", "", htmlspecialchars($var));
        $result = str_replace(".php", "", $result);
        $result = str_replace("&", "&amp", $result);
        $result = str_replace("'", null, $result);
        $result = str_replace('"', null, $result);
        $result = str_replace('.', "", $result);
        return $result;
    }

    function security($var)
    {
        $result = "";
        if (isset($var)) {
            $result = str_replace("'", '&apos;', trim($var));
            //$result = htmlentities($result);
            $result = str_replace("&nbsp;", " ", $result);
        }
        return $result;
    }

    function secure($var)
    {
        return md5(md5($var));
    }

    function pagename($var)
    {
        $result = strtolower(str_replace("'", "", str_replace(" ", "-", $var)));
        return $result;
    }

    function securePost($param)
    {
        if (isset($_POST[$param])) {
            if (is_array($_POST[$param])) {
                foreach ($_POST[$param] as $key => $value) {
                    $_POST[$param][$key] = htmlspecialchars(str_replace("&amp;nbsp;", " ", trim($_POST[$param][$key])));
                }
                return $_POST[$param];
            } elseif (isset($_POST[$param])) {
                $getPost = str_replace("&amp;nbsp;", " ", $_POST[$param]);
                return htmlspecialchars(trim($_POST[$param]), ENT_QUOTES, "UTF-8");
            } else {
                return false;
            }
        }
        return false;
    }

    function className($var)
    {
        $result = str_replace(" ", "", ucwords($var));
        return $result;
    }

    function tablename($var)
    {
        $result = str_replace("'", "", $var);
        $result = str_replace(" ", "_", $result);
        $result = strtolower($result);
        return $result;
    }

    function shortdesc($var, $word)
    {
        $shortdesc = "";
        if (isset($var) && $var != "") {
            $data = explode(" ", strip_tags(html_entity_decode($var), "<p><span><strong><blockquote>"));
            $count = count($data);
            for ($i = 0; $i < $word; $i++) {
                $shortdesc .= $data[$i] . " ";
                if ($i == $count - 1)
                    break;
            }
        }

        $shortdesc = strrpos($shortdesc, "<") > strrpos($shortdesc, ">") ? rtrim(substr($shortdesc, 0, strrpos($shortdesc, "<"))) : rtrim($shortdesc);
        return closetags($shortdesc);
    }

    function closetags($html)
    {
        preg_match_all("#<([a-z]+)( .*)?(?!/)>#iU", $html, $result);
        $openedtags = $result[1];

        preg_match_all("#</([a-z]+)>#iU", $html, $result);
        $closedtags = $result[1];
        $len_opened = count($openedtags);

        if (count($closedtags) == $len_opened) {
            return $html;
        }
        $openedtags = array_reverse($openedtags);
        for ($i = 0; $i < $len_opened; $i++) {
            if (!in_array($openedtags[$i], $closedtags)) {
                $html .= "</" . $openedtags[$i] . ">";
            } else {
                unset($closedtags[array_search($openedtags[$i], $closedtags)]);
            }
        }
        return $html;
    }

    function success_notif($var)
    {
        if (isset($var)) {
            return click_hide('successtext') . '<div class="successtext">' . $var . '</div>';
        }
    }

    function error_notif($var)
    {
        if (isset($var)) {
            return click_hide('errortext') . '<div class="errortext">' . $var . '</div>';
        }
    }

    function error_notif2($var)
    {
        if (isset($var)) {
            return click_hide('errortex2t') . '<div class="errortext2">' . $var . '</div>';
        }
    }

    function warning_notif($var)
    {
        if (isset($var)) {
            echo '<div class="warningtext">' . $var . '</div>';
        }
    }

    function info_notif($var)
    {
        if (isset($var)) {
            echo click_hide('info') . '<div class="info">' . $var . '</div>';
        }
    }

    function error_field(&$var)
    {
        if (isset($var)) {
            echo '<div class="errorfield">' . $var . '</div>';
        }
    }

    function error_form($var)
    {
        if (isset($var)) {
            echo '<div class="errorform">' . $var . '</div>';
        }
    }

    function error_class(&$var)
    {
        if (isset($var)) {
            echo ' error';
        }
    }

    function text_value(&$var1, $var2)
    {
        if (isset($var1) && $var1 != "") {
            return $var1;
        } else {
            return $var2;
        }
    }

    function select_value(&$var1, $var2, $var3)
    {
        if (isset($var1) && $var1 != "") {
            if ($var1 == $var3) {
                return ' selected="selected" ';
            }
        } else {
            if ($var2 == $var3) {
                return ' selected="selected" ';
            }
        }
    }

    function check_value(&$var1, $var2, $var3)
    {
        if (isset($var1) && $var1 != "") {
            if ($var1 == $var3) {
                return ' checked="checked" ';
            }
        } else {
            if ($var2 == $var3) {
                return ' checked="checked" ';
            }
        }
    }

    function check_value_multi($var1 = array(), $var2 = array(), $var3)
    {
        if (count($var1) > 0) {
            if (in_array(trim($var3), $var1)) {
                return ' checked="checked"';
            }
        } elseif (count($var2) > 0) {
            if (in_array(trim($var3), $var2)) {
                return ' checked="checked"';
            }
        }
    }

//NEW FUNCTION
// --------------------------------------------------------------------
    function delTree($dir)
    {
        $files = array_diff(scandir($dir), array('.', '..'));
        foreach ($files as $file) {
            (is_dir("$dir/$file")) ? delTree("$dir/$file") : unlink("$dir/$file");
        }
        return rmdir($dir);
    }

    /**
     * Get the value from a form
     *
     * Permits you to repopulate a form field with the value it was submitted
     * with, or, if that value doesn't exist, with the default
     *
     * @access    public
     * @param    string    the field name
     * @param    string
     * @return    void
     */
    function set_value($field = '', $default = '')
    {
        if (!isset($_POST[$field])) {
            return $default;
        }

        // If the data is an array output them one at a time.
        //     E.g: form_input('name[]', set_value('name[]');
        if (is_array($_POST[$field])) {
            return array_shift($_POST[$field]);
        }

        return $_POST[$field];
    }

// --------------------------------------------------------------------
    /**
     * Set Select
     *
     * Enables pull-down lists to be set to the value the user
     * selected in the event of an error
     *
     * @access    public
     * @param    string
     * @param    string
     * @return    string
     */
    function set_select($field = '', $value = '', $default = FALSE)
    {

        if (!isset($_POST[$field])) {
            if ($default === TRUE) {
                return ' selected="selected"';
            } elseif ($default == $value) {
                return ' selected="selected"';
            } elseif (is_array($default) && in_array($value, $default)) {
                return ' selected="selected"';
            }
            return '';
        }

        $field = $_POST[$field];

        if (is_array($field)) {
            if (!in_array($value, $field)) {
                return '';
            }
        } else {
            if (($field == '' OR $value == '') OR ($field != $value)) {
                return '';
            }
        }

        return ' selected="selected"';
    }

// --------------------------------------------------------------------
    /**
     * Set Checkbox
     *
     * Enables checkboxes to be set to the value the user
     * selected in the event of an error
     *
     * @access    public
     * @param    string
     * @param    string
     * @return    string
     */
    function set_checkbox($field = '', $value = '', $default = FALSE)
    {

        if (!isset($_POST[$field])) {
            if ($default === TRUE) {
                return ' checked="checked"';
            } elseif ($default !== FALSE) {
                return ' checked="checked"';
            } elseif (is_array($default) && in_array($value, $default)) {
                return ' checked="checked"';
            }
            return '';
        }

        $field = $_POST[$field];

        if (is_array($field)) {
            if (!in_array($value, $field)) {
                return '';
            }
        } else {
            if (($field == '' OR $value == '') OR ($field != $value)) {
                return '';
            }
        }

        return ' checked="checked"';
    }

// --------------------------------------------------------------------
    /**
     * Set Checkbox
     *
     * Enables checkboxes to be set to the value the user
     * selected in the event of an error
     *
     * @access    public
     * @param    string
     * @param    string
     * @return    string
     */
    function set_radio($field = '', $value = '', $default = FALSE)
    {

        if (!is_array($field) && !isset($_POST[$field])) {
            if ($default === TRUE) {
                return ' checked="checked"';
            } elseif ($default !== FALSE && $value == $default) {
                return ' checked="checked"';
            } elseif (is_array($default) && in_array($value, $default)) {
                return ' checked="checked"';
            }
            return '';
        }

        if (is_array($field)) {
            if (!in_array($value, $field)) {
                return '';
            }
        } else {
            $field = $_POST[$field];
            if (($field == '' OR $value == '') OR ($field != $value)) {
                return '';
            }
        }
        return ' checked="checked"';
    }

// --------------------------------------------------------------------
    function detail($content)
    {
        echo SITE_HOST . "/info/" . $content;
    }

    function direct_root()
    {
        header("Location:" . SITE_HOST);
        exit;
    }

    function direct_root_member()
    {
        header("Location:" . MEMBER_HOST);
        exit;
    }

    function direct_root_admin()
    {
        header("Location:" . ADMIN_HOST);
        exit;
    }

    function direct($success = "", $error = "", $post = "")
    {
        if (isset($success) && $success != "") {
            $_SESSION['MsgText'][$post] = success_notif($success);
        }
        if (isset($error) && $error != "") {
            $_SESSION['MsgText'][$post] = error_notif($error);
        }
        header("Location:" . $_SERVER['HTTP_REFERER']);
        exit;
    }

    function cek_status($arg)
    {
        if ($arg) {
            $stat = "Active";
        } else {
            $stat = "Blocked";
        }
        return $stat;
    }

    function set_status($arg)
    {
        if ($arg) {
            $stat = "block";
        } else {
            $stat = "unblock";
        }
        return $stat;
    }

    function status_approve($arg)
    {
        if ($arg == "1") {
            $stat = '<span class="green t11px">APPROVED</span>';
        } else {
            $stat = '<span class="red t11px">UN-APPROVED</span>';;
        }
        return $stat;
    }

    function get_status_icon($arg)
    {
        if ($arg == 0) {
            $stat = "<img src='" . ADMIN_TEMPLINK . "/images/draft.png' alt='Draft' Title='Draft' />";
        } elseif ($arg == '1') {
            $stat = "<img src='" . ADMIN_TEMPLINK . "/images/active.png' alt='Active' title='Publish' />";
        } elseif ($arg == '2') {
            $stat = "<img src='" . ADMIN_TEMPLINK . "/images/delete.png' alt='Trash' title='Trash' />";
        }
        return $stat;
    }

    function status_name($var)
    {
        if ($var == "1") {
            $stat = "Active";
        }
        if ($var == "0") {
            $stat = "Non-Active";
        }
        return $stat;
    }

    function label_status($status)
    {
        $label = "";
        $status = strtolower($status);
        $statusName = $status;
        if ($status == "0") $statusName = "non-active";
        if ($status == "1") $statusName = "active";
        if ($status == "publish" || $status == "active" || $status == "1")
            $label = '<span class="label label-success label-mini">' . $statusName . '</span>';
        if ($status == "draft" || $status == "non-active" || $status == "0")
            $label = '<span class="label label-warning label-mini">' . $statusName . '</span>';
        if ($status == "block")
            $label = '<span class="label label-danger label-mini">' . $statusName . '</span>';
        return $label;
    }

    function pesan_label($label)
    {
        $showLabel = "&mdash;";
        $labelName = ucwords(str_replace("-", " ", $label));

        switch ($label) {
            case 'open':
                $showLabel = '<span class="label label-info">' . $labelName . '</span>';
                break;
            case 'terjawab':
                $showLabel = '<span class="label label-success">' . $labelName . '</span>';
                break;
            case 'terbaca':
                $showLabel = '<span class="label label-primary">' . $labelName . '</span>';
                break;
            case 'terjawab_customer':
                $showLabel = '<span class="label label-warning">' . $labelName . '</span>';
                break;
            case 'closed':
                $showLabel = '<span class="label label-danger">' . $labelName . '</span>';
                break;
            case '':
                $showLabel = '<span class="label label-info">Send</span>';
                break;
            default:
                $showLabel = '';
                break;
        }

        return $showLabel;
    }

    function highlight_status($status)
    {
        $label = "";
        $status = strtolower($status);
        $statusName = $status;
        if ($status == "0") $statusName = "no";
        if ($status == "1") $statusName = "yes";
        if ($status == "1")
            $label = '<span class="label label-success label-mini">' . $statusName . '</span>';
        if ($status == "0")
            $label = '<span class="label label-warning label-mini">' . $statusName . '</span>';
        return $label;
    }

    function ppob_label($label)
    {
        $showLabel = "&mdash;";
        $labelName = ucwords(str_replace("-", " ", $label));
        if ($label == "new") $showLabel = '<span class="label label-info">' . $labelName . '</span>';
        if ($label == "pending") $showLabel = '<span class="label label-warning">' . $labelName . '</span>';
        if ($label == "success") $showLabel = '<span class="label label-success">' . $labelName . '</span>';
        if ($label == "cancel") $showLabel = '<span class="label label-danger">' . $labelName . '</span>';
        if ($label == "failed") $showLabel = '<span class="label label-danger">' . $labelName . '</span>';
        return $showLabel;
    }

    function product_label($label)
    {
        $showLabel = "&mdash;";
        $labelName = ucwords(str_replace("-", " ", $label));
        if ($label == "new-arrival") $showLabel = '<span class="label label-success label-mini">' . $labelName . '</span>';
        if ($label == "hot-item") $showLabel = '<span class="label label-danger label-mini">' . $labelName . '</span>';
        if ($label == "promo") $showLabel = '<span class="label label-info label-mini">' . $labelName . '</span>';
        return $showLabel;
    }

    function product_stock($label)
    {
        $showLabel = "&mdash;";
        $labelName = ucwords($label);
        function pesan_label($label)
        {
            $showLabel = "&mdash;";
            $labelName = ucwords(str_replace("-", " ", $label));

            switch ($label) {
                case 'open':
                    $showLabel = '<span class="label label-info">' . $labelName . '</span>';
                    break;
                case 'terjawab':
                    $showLabel = '<span class="label label-success">' . $labelName . '</span>';
                    break;
                case 'terjawab_customer':
                    $showLabel = '<span class="label label-warning">' . $labelName . '</span>';
                    break;
                case 'closed':
                    $showLabel = '<span class="label label-danger">' . $labelName . '</span>';
                    break;
                default:
                    $showLabel = '';
                    break;
            }

            return $showLabel;
        }

        if ($label == "ready") $showLabel = '<span class="label label-success label-mini">' . $labelName . '</span>';
        if ($label == "sold") $showLabel = '<span class="label label-danger label-mini">' . $labelName . '</span>';
        return $showLabel;
    }



    function yes_no($var)
    {
        if ($var == "1") {
            $stat = "Yes";
        }
        if ($var == "0") {
            $stat = "No";
        }
        return $stat;
    }

    function null_to_dash($data)
    {
        foreach ($data as &$value) {
            if ($value == "" || $value == NULL) {
                $value = "-";
            }
        }
        return $data;
    }

    function dollar($data)
    {
        return number_format($data, '2', '.', ',');
    }

    function rupiah($data)
    {
        return number_format($data, '2', ',', '.');
    }

    function number($data)
    {
        return number_format(intval($data), 0, ',', '.');
    }

    function now()
    {
        return date('Y-m-d H:i:s');
    }

    function response($status, $text)
    {

        return array('status' => $status, 'text' => $text);

    }


    function click_hide($opt)
    {
        return "
        <script type='text/javascript'>
        jQuery(document).ready(function(){
            jQuery('." . $opt . "').click(function() {
              jQuery('." . $opt . "').fadeOut('slow', function() {
              });
            });
        });
        </script>
        ";
    }

    function p($var, $exit = FALSE)
    {
        echo "<pre>";
        print_r($var);
        echo "</pre>";
        if ($exit) {
            exit;
        }
    }

    function recurse_array($values)
    {
        $content = '';
        if (is_array($values)) {
            foreach ($values as $key => $value) {
                if (is_array($value)) {
                    $content .= $key . "<br />" . recurse_array($value);
                } else {
                    $content .= $key . " = " . $value . "<br />";
                }
            }
        }
        return $content;
    }

    function arrDays($opt = "")
    {
        if ($opt == "") {
            $arrDays = array("Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday");
        } elseif ($opt == "id") {
            $arrDays = array("Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu");
        }
        return $arrDays;
    }

    function arrMonths($opt = "")
    {
        if ($opt == "") {
            $arrMonths = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
        } else if ($opt == "id") {
            $arrMonths = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
        }
        return $arrMonths;
    }

    function get_date_id($date)
    {
        $value = array("date" => "", "month" => "", "year" => "");
        if ($date != "") {
            $monthId = arrMonths("id");
            $value['date'] = (substr($date, 8, 2));
            $value['month'] = $monthId[intval(substr($date, 5, 2)) - 1];
            $value['year'] = substr($date, 0, 4);
        }
        return $value;
    }

//IRFAN

    function arrWords($text = "")
    {
        $arrText = explode(" ", strtolower($text));
        $count = count($arrText);
        $value = array();
        $key = 0;
        $first = 0;

        if ($count > 0) {
            for ($i = 0; $i < $count; $i++) {
                $len = $count - $i;
                $next = 1;
                $start = 0;
                while ($next == 1) {
                    $value[$key] = "";
                    for ($j = 0; $j < $len; $j++) {
                        $value[$key] .= $arrText[$start] . " ";
                        $start++;
                    }
                    $value[$key] = trim($value[$key]);
                    $last = $arrText[$len - 1];
                    if ($start == $count) {
                        $next = 0;
                    }
                    $key++;
                    $first = $first + 1;
                    $start = $first;
                }
                $first = 0;
                $start = 0;
            }
        }
        return $value;
    }

    function get_mime_type($file)
    {
        $mime_types = array(
            "pdf" => "application/pdf"
        , "exe" => "application/octet-stream"
        , "zip" => "application/zip"
        , "docx" => "application/vnd.openxmlformats-officedocument.wordprocessingml.document"
        , "doc" => "application/msword"
        , "xls" => "application/vnd.ms-excel"
        , "xlsx" => "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
        , "ppt" => "application/vnd.ms-powerpoint"
        , "gif" => "image/gif"
        , "png" => "image/png"
        , "jpeg" => "image/jpg"
        , "jpg" => "image/jpg"
        , "mp3" => "audio/mpeg"
        , "wav" => "audio/x-wav"
        , "mpeg" => "video/mpeg"
        , "mpg" => "video/mpeg"
        , "mpe" => "video/mpeg"
        , "mov" => "video/quicktime"
        , "avi" => "video/x-msvideo"
        , "3gp" => "video/3gpp"
        , "css" => "text/css"
        , "jsc" => "application/javascript"
        , "js" => "application/javascript"
        , "php" => "text/html"
        , "htm" => "text/html"
        , "html" => "text/html"
        );
        $extension = strtolower(end(explode('.', $file)));
        $mimeType = $mime_types[$extension];
        if ($extension == "doc" || $extension == "docx") {
            $icon = "data-word.png";
        } elseif ($extension == "xls" || $extension == "xlsx") {
            $icon = "data-excel.png";
        } elseif ($extension == "pdf") {
            $icon = "data-pdf.png";
        }
        //return $mime_types[$extension];
        return $icon;
    }

    function gotoScroll($id)
    {
        echo '<script>
            $(document).ready(function(){
                $("html,body").animate({scrollTop: $("#' . $id . '").offset().top},"slow");
            });
        </script>';
    }

    function isValidMethodPost($param)
    {
        $valid = FALSE;
        if (isset($_POST[$param]) && $_POST[$param] != "" && $_SERVER['REQUEST_METHOD'] == "POST") {
            $valid = TRUE;
        }
        return $valid;
    }

    function sanitize($data)
    {
        return str_replace("+", " ", $data);
    }

    function securePostSearch($param)
    {
        if (isset($_POST[$param])) {
            $getPost = $_POST[$param] != "" ? trim($_POST[$param]) : $_POST[$param];
            $getPost = str_replace(" ", "+", $getPost);
            return htmlspecialchars($getPost, ENT_QUOTES, "UTF-8");
        } else {
            return false;
        }
    }

    function unlink_image($param)
    {
        if (is_array($param) && count($param) > 0) {
            foreach ($param as $img) {
                if (file_exists(UPLOADS_PATH . "/" . $img)) {
                    unlink(UPLOADS_PATH . "/" . $img);
                }
            }
        } else {
            if (file_exists(UPLOADS_PATH . "/" . $img)) {
                unlink(UPLOADS_PATH . "/" . $img);
            }
        }
    }

//HTML TAG HELPER

    /**
     * Image HTML Tag
     * Generates an <img /> element
     */
    function img_tag($src, $attr = array(), $thumb = FALSE)
    {
        $img = '<img';

        $dataStr = explode('|', $src);
        $src = $dataStr[0];
        //THUMB or DEFAULT
        $path = IMAGES_HOST;
        if ($thumb) {
            $path = IMAGES_THUMB;
        }

        //Is image exists?
//    return IMAGES_PATH . "/" . $src;exit;
        if (!file_exists(IMAGES_PATH . "/" . $src)) {
            $src = 'no_image.jpg';
            $dataStr[1] = 'No Image';
        }

        //images
        $img .= ' src="' . $path . '/' . $src . '"';

        //is alt attr exists?
        if (isset($dataStr[1])) {
            $img .= ' alt="' . $dataStr[1] . '"';
        }

        //is another attr exists?
        if (is_array($attr) && count($attr) > 0) {
            foreach ($attr as $key => $value) {
                $img .= ' ' . $key . '="' . $value . '"';
            }
        }

        $img .= '/>';

        return $img;
    }

    /**
     * Comment
     */
    function echo_session(&$data)
    {
        if (isset($data)) {
            echo $data;
        }
    }

    function array_short($a, $b)
    {
        return $a['menu_order'] - $b['menu_order'];
    }

    function arrayToObject($d)
    {
        if (is_array($d)) {
            /*
             * Return array converted to object
             * Using __FUNCTION__ (Magic constant)
             * for recursive call
             */
            return (object)array_map(__FUNCTION__, $d);
        } else {
            // Return object
            return $d;
        }
    }

    function objectToArray($d)
    {
        if (is_object($d)) {
            // Gets the properties of the given object
            // with get_object_vars function
            $d = get_object_vars($d);
        }

        if (is_array($d)) {
            /*
             * Return array converted to object
             * Using __FUNCTION__ (Magic constant)
             * for recursive call
             */
            return array_map(__FUNCTION__, $d);
        } else {
            // Return array
            return $d;
        }
    }

    /**
     * get image tag
     */
    function get_img($data)
    {

        $doc = new DOMDocument();
        @$doc->loadHTML($data);

        $tags = $doc->getElementsByTagName('img')->item(0);
        if ($tags) {
            return $tags;
        }
        return FALSE;
    }

    function lang($data = NULL)
    {
        $setting = Setting::get_instance();
        if (is_string($data)) {
            $result = search_array($setting->language, 'lang_key', $data);
            if (isset($result) && count($result) > 0) {
//            $resultq = array_map('reset', $result);
                return $result['text_' . $_SESSION['language']];
            } else {
                return $data . '_' . $_SESSION['language'];
            }
        }
        return 'Key ' . $data . ' is not defined.';
//    if (is_array($data)) {
//        foreach ($array as $key => $value) {
//            return $data[$key . '_' . $_SESSION['language']];
//        }
//        $key = array_keys($data);
//    }
    }

// search array for specific key = value
    function search_array($array, $key, $value)
    {
        $return = array();
        foreach ($array as $k => $subarray) {
            if (isset($subarray[$key]) && $subarray[$key] == $value) {
//      $return[$k] = $subarray; //RESULT WITH INDEX ASSOCIATED
                $return = $subarray;   //RESULT WITHOUT INDEX ASSOCIATED
                return $return;
            }
        }
    }

    /**
     * Parse HTML Element
     */
    function parse_html($html = '', $tag = '', $attr = '', $type = 'string')
    {
        $dom = new DOMDocument();
        if ($type != 'string') {
            $html = file_get_contents($html);
        }
        @$dom->loadHTML($html);

        $a = $dom->getElementsByTagName($tag);
        return $a->item(0)->getAttribute($attr);
    }

    /**
     * parse_youtube_url
     */
    function parse_youtube_url($url, $return = '', $width = '', $height = '', $rel = 0)
    {
        $urls = parse_url($url);

        //url is http://youtu.be/xxxx
        if ($urls['host'] == 'youtu.be') {
            $id = ltrim($urls['path'], '/');
        } //url is http://www.youtube.com/embed/xxxx
        elseif (strpos($urls['path'], 'embed') !== FALSE) {
            $dt = explode('/', $urls['path']);
            $id = end($dt);
        } //url is xxxx only
        else if (strpos($url, '/') === false) {
            $id = $url;
        }
        //http://www.youtube.com/watch?feature=player_embedded&v=m-t4pcO99gI
        //url is http://www.youtube.com/watch?v=xxxx
        else {
            parse_str($urls['query']);
            $id = $v;
            if (!empty($feature)) {
                $id = end(explode('v=', $urls['query']));
            }
        }
        //return embed iframe
        if ($return == 'embed') {
            return '</pre><iframe src="http://www.youtube.com/embed/' . $id . '?rel=' . $rel . '" frameborder="0" width="' . ($width ? $width : 560) . '" height="' . ($height ? $height : 349) . '"></iframe><pre>';
        } //return normal thumb
        else if ($return == 'thumb') {
            return 'http://i1.ytimg.com/vi/' . $id . '/default.jpg';
        } //return hqthumb
        else if ($return == 'hqthumb') {
            return 'http://i1.ytimg.com/vi/' . $id . '/hqdefault.jpg';
        } // else return id
        else {
            return $id;
        }
    }

    function hi()
    {
        $jam = intval(date('H'));
        if ($jam >= 5 && $jam <= 11) {
            $hi = "Pagi";
        } elseif ($jam > 11 && $jam <= 15) {
            $hi = "Siang";
        } elseif ($jam > 15 && $jam <= 19) {
            $hi = "Sore";
        } else {
            $hi = "Malam";
        }
        return $hi;
    }

    function hepipayuserid($id)
    {

        $showId = "HP" . (intval($id) + 10425);

        return $showId;

    }

    function getIPuser()
    {

        $ip = "";

        if (!empty($_SERVER["HTTP_CLIENT_IP"])) {
            //check for ip from share internet
            $ip = $_SERVER["HTTP_CLIENT_IP"];
        } elseif (!empty($_SERVER["HTTP_X_FORWARDED_FOR"])) {
            // Check for the Proxy User
            $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
        } else {
            $ip = $_SERVER["REMOTE_ADDR"];
        }
        return $ip;


    }

    function show_notif($var = array())
    {
        $notif = "";
        if (isset($var)) {
            if ($var['status'] == "0") {
                $notif = '
			<div class="alert alert-block alert-danger fade in">
				<button type="button" class="close close-sm" data-dismiss="alert">
					<i class="fa fa-times"></i>
				</button>
				<i class="fa fa-warning"></i> ' . $var['text'] . '
			</div>';
            }
            if ($var['status'] == "1") {
                $notif = '
			<div class="alert alert-block alert-success fade in">
				<button type="button" class="close close-sm" data-dismiss="alert">
					<i class="fa fa-times"></i>
				</button>
				<i class="fa fa-check"></i> ' . $var['text'] . '
			</div>';
            }
        }
        return $notif;
    }

    function waktu_lalu($timestamp)
    {
        $selisih = time() - strtotime($timestamp);

        $detik = $selisih;
        $menit = round($selisih / 60);
        $jam = round($selisih / 3600);
        $hari = round($selisih / 86400);
        $minggu = round($selisih / 604800);
        $bulan = round($selisih / 2419200);
        $tahun = round($selisih / 29030400);

        if ($detik <= 60) {
            $waktu = $detik . ' detik yang lalu';
        } else if ($menit <= 60) {
            $waktu = $menit . ' menit yang lalu';
        } else if ($jam <= 24) {
            $waktu = $jam . ' jam yang lalu';
        } else if ($hari <= 7) {
            $waktu = $hari . ' hari yang lalu';
        } else if ($minggu <= 4) {
            $waktu = $minggu . ' minggu yang lalu';
        } else if ($bulan <= 12) {
            $waktu = $bulan . ' bulan yang lalu';
        } else {
            $waktu = $tahun . ' tahun yang lalu';
        }

        return $waktu;
    }

    function coordinate_distance($lat1, $lon1, $lat2, $lon2)
    {
        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;

        return ($miles * 1.609344);
        //return in Kilometer
    }

    function date_indo($data, $format = "")
    {
        if (substr($data, 0, 10) == "0000-00-00") {
            $newDate = "-";
        } else {
            $dayIndo = date('D', strtotime($data));
            $dayName = array(
                'Sun' => 'Minggu',
                'Mon' => 'Senin',
                'Tue' => 'Selasa',
                'Wed' => 'Rabu',
                'Thu' => 'Kamis',
                'Fri' => 'Jumat',
                'Sat' => 'Sabtu'
            );

            $newDate = "";
            $arrMonth = $this->arrMonths("id");
            $day = substr($data, 8, 2);
            $month = $arrMonth[substr($data, 5, 2) - 1];
            $year = substr($data, 0, 4);
            $hour = substr($data, 11, 2);
            $minute = substr($data, 14, 2);
            $second = substr($data, 17, 2);

            $newDate = $day . " " . substr($month, 0, 3) . " " . $year;
            if ($format == "dd FF YYYY") {
                $newDate = $day . " " . $month . " " . $year;
            } elseif ($format == "datetime") {
                $newDate = $day . " " . substr($month, 0, 3) . " " . $year . " " . $hour . ":" . $minute . ":" . $second;
            } elseif ($format == "dateonly") {
                $newDate = $day . " " . substr($month, 0, 3) . " " . $year;
            } elseif ($format == "dateorder") {
                $newDate = $day . " " . substr($month, 0, 3) . " " . $year . " " . $hour . ":" . $minute;
            } elseif ($format == "dateday") {
                $newDate = $dayName[$dayIndo] . ", " . $day . " " . substr($month, 0, 3) . " " . $year;
            }
        }
        return $newDate;
    }

    function date_different($datesecond, $datefirst)
    {

        $tgl1 = strtotime($datefirst);
        $tgl2 = strtotime($datesecond);
        $diff_secs = abs($tgl2 - $tgl1);
        $base_year = min(date("Y", $tgl2), date("Y", $tgl1));
        $diff = mktime(0, 0, $diff_secs, 1, 1, $base_year);
        $diff_array = array("years" => date("Y", $diff) - $base_year, "months_total" => (date("Y", $diff) - $base_year) * 12 + date("n", $diff) - 1, "months" => date("n", $diff) - 1, "days_total" => floor($diff_secs / (3600 * 24)), "days" => date("j", $diff) - 1, "hours_total" => floor($diff_secs / 3600), "hours" => date("G", $diff), "minutes_total" => floor($diff_secs / 60), "minutes" => (int)date("i", $diff), "seconds_total" => $diff_secs, "seconds" => (int)date("s", $diff));
        if ($diff_array['minutes'] != 0) {
            return $diff_array['hours'] . " jam " . $diff_array['minutes'] . " menit";
        } else {
            return $diff_array['hours'] . " jam";
        }

    }

    function color_progress($var)
    {
        if ($var <= 35) {
            $bg = " background:#dd514c;";
        } elseif ($var > 35 && $var <= 70) {
            $bg = " background:#faa732;";
        } else {
            $bg = " background:#4bb1cf;";
        }
        return $bg;
    }

    function get_size($size)
    {
        if ($size > 1000000) {
            $sizeNew = round(($size / 1000000), 2) . " MB";
        } else {
            $sizeNew = round(($size / 1000), 2) . " KB";
        }
        return $sizeNew;
    }

    function min2provider($min = "")
    {
        $prefix = substr($min, 0, 5);
        $arrMinSF = array('51028', '51009');
        if (in_array($prefix, $arrMinSF)) {
            $provider = "SF";
        } else {
            $provider = "";
        }
        return $provider;
    }

    function save_xml_file($filename = "", $xml = "")
    {
        if ($filename == "")
            $filename = $filename;
        if ($xml == "")
            $xml = $xml;

        $fp = @fopen($filename, "w");
        if ($fp) {
            @fputs($fp, $xml);
            $result = true;
        } else    $result = false;
        @fclose($fp);

        return $result;
    }

    function check_gateway($ip = "")
    {
        $connected = @fsockopen($ip, 80, $errno, $errstr, 3); //website, port  (try 80 or 443)
        if ($connected) {
            $is_conn = 1; //action when connected
            fclose($connected);
        } else {
            $is_conn = 0; //action in connection failure
        }
        return $is_conn;
    }

    function get_status_charge($no)
    {
        if ($no == "0") {
            $status = "Transaksi berhasil";
        } elseif ($no == "14") {
            $status = "Transaksi gagal, pulsa anda tidak mencukupi.";
        } elseif ($no == "96") {
            $status = "Transaksi gagal, terjadi gangguan koneksi internet.";
        } else {
            $status = "Transaksi gagal, silahkan coba beberapa saat lagi.";
        }
        return $status;
    }




    function resize_image($imageFile, $width, $height, $name)
    {
        $info = getimagesize($imageFile);
        $mime = $info['mime'];


        switch ($mime) {
            case 'image/jpeg':
                $image_create_func = 'imagecreatefromjpeg';
                $image_save_func = 'imagejpeg';
                $new_image_ext = 'jpg';
                break;

            case 'image/png':
                $image_create_func = 'imagecreatefrompng';
                $image_save_func = 'imagepng';
                $new_image_ext = 'png';
                break;

            case 'image/gif':
                $image_create_func = 'imagecreatefromgif';
                $image_save_func = 'imagegif';
                $new_image_ext = 'gif';
                break;

            default:
                return '';
        }

        list($w, $h) = getimagesize($imageFile);

        if (empty($height))
            $height = $width / $w * $h;
        elseif (empty($width))
            $width = $height / $h * $w;

        $ratio = max($width / $w, $height / $h);
        $h = ceil($height / $ratio);
        $x = ($w - $width / $ratio) / 2;
        $w = ceil($width / $ratio);

        $path = $name;
        $image = $image_create_func($imageFile);
        $tmp = imagecreatetruecolor($width, $height);

        imagecopyresampled($tmp, $image, 0, 0, $x, 0, $width, $height, $w, $h);

        $image_save_func($tmp, $path);

        return $path;

        imagedestroy($image);
        imagedestroy($tmp);
    }

    function get_icon_section($section = "")
    {
        $icon = "";
        switch ($section) {
            case "" :
                $icon = '<i class="fa fa-home"></i>';
                break;
            case "customer" :
                $icon = '<i class="fa fa-users"></i>';
                break;
            case "user" :
                $icon = '<i class="fa fa-user"></i>';
                break;
            case "setting" :
                $icon = '<i class="fa fa-cogs"></i>';
                break;
            case "beritamu" :
                $icon = '<i class="fa fa-rss"></i>';
                break;
            case "inspirasimu" :
                $icon = '<i class="fa fa-lightbulb-o"></i>';
                break;
            case "kalendermu" :
                $icon = '<i class="fa fa-calendar"></i>';
                break;
            case "bukumu" :
                $icon = '<i class="fa fa-book"></i>';
                break;
            case "aplikasimu" :
                $icon = '<i class="fa fa-th"></i>';
                break;
            case "tokomu" :
                $icon = '<i class="fa fa-shopping-cart"></i>';
                break;
            case "bisnismu" :
                $icon = '<i class="fa fa-briefcase"></i>';
                break;
            case "contact" :
                $icon = '<i class="fa fa-envelope"></i>';
                break;
            case "pages" :
                $icon = '<i class="fa fa-file"></i>';
                break;
            case "mutasi" :
                $icon = '<i class="fa fa-money"></i>';
                break;
            case "report" :
                $icon = '<i class="fa fa-bar-chart-o"></i>';
                break;
            case "notification" :
                $icon = '<i class="fa fa-bullhorn"></i>';
                break;
            case "pesan" :
                $icon = '<i class="fa fa-comments"></i>';
                break;
            default:
                $icon = '<i class="fa fa-file"></i>';
                break;
        }
        return $icon;
    }

    function get_age($date1, $date2)
    {
        $diff = abs(strtotime($date2) - strtotime($date1));
        $years = floor($diff / (365 * 60 * 60 * 24));
        $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
        $days = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));

        return "<strong>" . $years . "</strong> Tahun, <strong>" . $months . "</strong> Bulan";

    }

    function generate_trxid()
    {
        $pattern0 = ((date('Y') - 2015) * 12) + (intval(date('m')) - 5) + 1;
        $pattern1 = substr("0" . (date('d') * 24) + intval(date('H')), -3);
        $pattern2 = substr("00" . ((intval(date('i')) * 60) + intval(date('s'))) . substr(microtime(), 2, 4), -8);
        $trxId = $pattern0 . $pattern1 . $pattern2;
        return $trxId;
    }

    function Terbilang($x)
    {
        $abil = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
        if ($x < 12)
            return " " . $abil[$x];
        elseif ($x < 20)
            return Terbilang($x - 10) . " belas";
        elseif ($x < 100)
            return Terbilang($x / 10) . " puluh" . Terbilang($x % 10);
        elseif ($x < 200)
            return " seratus" . Terbilang($x - 100);
        elseif ($x < 1000)
            return Terbilang($x / 100) . " ratus" . Terbilang($x % 100);
        elseif ($x < 2000)
            return " seribu" . Terbilang($x - 1000);
        elseif ($x < 1000000)
            return Terbilang($x / 1000) . " ribu" . Terbilang($x % 1000);
        elseif ($x < 1000000000)
            return Terbilang($x / 1000000) . " juta" . Terbilang($x % 1000000);
    }


    function ppob_status($opt = "", $status = "")
    {
        $label = $status;
        switch ($opt) {
            case "transaction":
                if ($status == "success") $label = "Sukses";
                if ($status == "pending") $label = "Sedang Diproses";
                if ($status == "failed") $label = "Gagal";
                break;

            case "deposit":
                if ($status == "new") $label = "Menunggu Pembayaran";
                if ($status == "pending") $label = "Sedang diproses";
                if ($status == "success") $label = "Sukses";
                if ($status == "cancel") $label = "Dibatalkan";
                if ($status == "failed") $label = "Gagal";
                break;

            default:
                $label = $status;
                break;
        }
        return $label;
    }

    function img_upload($file = '', $path = '', $filename = '')
    {
        $name = explode('.', $file['name']);
        $ext = strtolower(end($name));
        $path = MEDIA_IMAGE_PATH . '/' . $path;


        $file_name = $filename . '.' . $ext;
        $file_path = $path . $file_name;

        move_uploaded_file($file['tmp_name'], $file_path);
        //echo $file_path;exit;
        return $file_name;
    }

    function alias_vendor($str = '')
    {
        if (empty($str))
            return '';

        $vendor = strtolower($str);

        switch ($vendor) {
            case 'bimasakti' :
                return 'BMS';
                break;
            case 'idbiller' :
                return 'IDB';
                break;
            default :
                return '';
                exit;
        }
    }

    function valid_email($email)
    {
        return (bool)filter_var($email, FILTER_VALIDATE_EMAIL);
    }

}



?>