<?php
date_default_timezone_set('Asia/Kolkata');
class configure {

    private $temp, $doc_path, $libroot;
    public $config, $idHolders;

    public function __construct() {
        $this->temp = explode("/", rtrim($_SERVER["DOCUMENT_ROOT"], "/"));
        $this->doc_path = $_SERVER["DOCUMENT_ROOT"] . "/";
        $this->libroot = str_replace($this->temp[count($this->temp) - 1], "library", $_SERVER["DOCUMENT_ROOT"]) . "/";
        $this->config = array(
            //"URL" => "http://local.pic3pic.com/",
            //"URL" => "http://pic3pic.localmm.com/",
            "URL" => "http://code.madmec.com/",
            "DBHOST" => "localhost",
            "DBUSER" => "root",
            //"DBPASS" => "9743967575",
            "DBPASS" => "madmec@418133",
            "DBNAME_ZERO" => "pic3pic_india",
            "DOC_ROOT" => $this->doc_path,
            "LIB_ROOT" => $this->libroot,
            "DIRS" => "appDirectories/",
            "LIBS" => "libs/",
            "CONTROLLERS" => "controllers/",
            "MODELS" => "models/",
            "VIEWS" => "views/",
            "ASSSET" => "assets/",
            "ASSSET_JSF" => "assets/js/",
            "ASSSET_IMG" => "assets/img/",
            "ASSSET_PLG" => "assets/plugins/",
            "PLG_01" => "bootstrap-slider/",
            "PLG_02" => "bootstrap-wysihtml5/",
            "PLG_03" => "chartjs/",
            "PLG_04" => "ckeditor/",
            "PLG_05" => "colorpicker/",
            "PLG_06" => "datatables/",
            "PLG_07" => "datepicker/",
            "PLG_08" => "daterangepicker/",
            "PLG_09" => "fancybox/",
            "PLG_10" => "fastclick/",
            "PLG_11" => "flot/",
            "PLG_12" => "fullcalendar/",
            "PLG_13" => "iCheck/",
            "PLG_14" => "input-mask/",
            "PLG_15" => "ionslider/",
            "PLG_16" => "jQuery/",
            "PLG_17" => "jQuery-File-Upload-9.10.4/",
            "PLG_18" => "jQueryUI/",
            "PLG_19" => "jvectormap/",
            "PLG_20" => "knob/",
            "PLG_21" => "morris/",
            "PLG_22" => "pace/",
            "PLG_23" => "picedit/",
            "PLG_24" => "select2/",
            "PLG_25" => "slimScroll/",
            "PLG_26" => "sparkline/",
            "PLG_27" => "timepicker/",
            "ASSSET_PIC" => "assets/js/pic3pic/",
            "ASSSET_BST" => "assets/bootstrap/",
            "FONT_0" => "font-awesome-4.4.0/",
            "FONT_1" => "fonts-ionicons-2.0.1/",
            "INC" => "inc/",
            "MODULE_0" => "config.php",
            "MODULE_1" => "database.php",
            "MODULE_2" => "model.php",
            "MODULE_3" => "view.php",
            "MODULE_4" => "controller.php",
            "MODULE_5" => "bootstrap.php",
            "MODULE_6" => "sessions.php",
            "DEFAULT_CNTRL" => "Index.php",
            "CTRL_0" => "Help/",
            "CTRL_1" => "Channel/",
            "CTRL_2" => "Error/",
            "CTRL_3" => "Login/",
            "CTRL_4" => "Logout/",
            "CTRL_5" => "Profile/",
            "CTRL_6" => "Register/",
            "CTRL_7" => "Wall/",
            "CTRL_8" => "Popular/",
            "CTRL_9" => "NewPost/",
            "CTRL_10" => "Geography/",
            "CTRL_11" => "Languages/",
            "CTRL_12" => "LoadJS/",
            "CTRL_13" => "LoadJSON/",
            "CTRL_14" => "Post/",
            "CTRL_15" => "Report/",
            "CTRL_16" => "Sections/",
            "CTRL_17" => "Visitor/",
            "CTRL_18" => "Picture/",
            "START_DATE" => "2015-10-01",
        );
        $this->idHolders = array(
            "wall" => array(
                "header" => array(
                    "autoloader" => true,
                    "action" => "fetchSections",
                    "geograph" => "geograph",
                    "world" => "worldd",
                    "country" => "countryy",
                    "login" => array(
                        "but" => "loginBut",
                        "target" => "login",
                    ),
                    "register" => array(
                        "but" => "registerBut",
                        "target" => "register",
                    ),
                    "help" => array(
                        "but" => "helpBut",
                        "target" => "",
                    ),
                    "continents" => array(
                        "autoloader" => true,
                        "action" => "ListContinents",
                        "type" => "post",
                        "dataType" => "JSON",
                        "but" => "show-me0",
                        "icheckCH" => "icheckbox_futurico",
                        "class" => "show-me",
                        "outputDiv" => "HdappendConti",
                        "listtype" => "checkbox",
                        "url" => $this->config["URL"] . "Header/getContinents",
                    ),
                    "countries" => array(
                        "autoloader" => true,
                        "action" => "ListCountries",
                        "type" => "post",
                        "dataType" => "JSON",
                        "but" => "show-me1",
                        "icheckCH" => "icheckbox_futurico",
                        "class" => "show-me",
                        "listtype" => "checkbox",
                        "outputDiv" => "HdappendContr",
                        "url" => $this->config["URL"] . "Header/getCountries",
                    ),
                    "languages" => array(
                        "autoloader" => true,
                        "action" => "ListLanguages",
                        "type" => "post",
                        "dataType" => "JSON",
                        "but" => "show-me2",
                        "icheckCH" => "icheckbox_futurico",
                        "class" => "show-me",
                        "listtype" => "checkbox",
                        "outputDiv" => "HdappendLang",
                        "url" => $this->config["URL"] . "Header/getLanguages",
                    ),
                    "sections" => array(
                        "autoloader" => true,
                        "action" => "fetchSections",
                        "type" => "post",
                        "dataType" => "JSON",
                        "listtype" => "checkbox",
                        "icheckCH" => "icheckbox_futurico",
                        "class" => "show-me",
                        "listtype" => "checkbox",
                        "outputDiv" => "HdSections",
                        "url" => $this->config["URL"] . "Header/getSectionsNames",
                    ),
                ),
                "channel" => array(
                    "moodalBut" => "popCh",
                    "create" => array(
                        "autoloader" => true,
                        "action" => "create",
                        "type" => "post",
                        "dataType" => "JSON",
                        "parentDiv" => "CreateChannel",
                        "parentBut" => "popCh",
                        "form" => "channelForm",
                        "name" => "chname",
                        "target" => "targetCh",
                        "parentFild" => "chappendfild",
                        "continent" => "continent",
                        "country" => "country",
                        "language" => "language",
                        "anyoneC" => ".anyoneC",
                        "continents" => "continentsCH",
                        "countries" => "countriesCH",
                        "languages" => "languagesCH",
                        "sel2" => ".select2-container",
                        "close" => "chclose",
                        "botton" => "chCreateButton",
                        "outputDiv" => "exlist",
                        "url" => $this->config["URL"] . "Channel/CreateChannel",
                        "continents" => array(
                            "autoloader" => true,
                            "action" => "ListContinents",
                            "type" => "post",
                            "dataType" => "JSON",
                            "url" => $this->config["URL"] . "Channel/getContinents",
                        ),
                        "countries" => array(
                            "autoloader" => true,
                            "action" => "ListCountries",
                            "type" => "post",
                            "dataType" => "JSON",
                            "url" => $this->config["URL"] . "Channel/getCountries",
                        ),
                        "languages" => array(
                            "autoloader" => true,
                            "action" => "ListLanguages",
                            "type" => "post",
                            "dataType" => "JSON",
                            "url" => $this->config["URL"] . "Channel/getLanguages",
                        ),
                    ),
                    "list" => array(
                        "parentDiv" => "exlist",
                        "item" => "lich",
                        "autoloader" => true,
                        "action" => "ListChannels",
                        "type" => "post",
                        "dataType" => "JSON",
                        "outputDiv" => "exlist",
                        "url" => $this->config["URL"] . "Channel/ListChannels"
                    ),
                ),
                "post" => array(
                    "moodalBut" => "createPO",
                    "create" => array(
                        "parentDiv" => "postindividual",
                        "parentBut" => "createPO",
                        "form" => "postForm",
                        "imgURL" => "chname",
                        "postImg" => "picedit_box",
                        "postImgMsg" => "picedit_message",
                        "postImgNav" => "picedit_nav_box",
                        "postImgBox" => "picedit_canvas_box",
                        "postVid" => "picedit_video",
                        "postImgDrag" => "picedit_drag_resize",
                        "title" => "targetPs",
                        "target" => "targetPost",
                        "iagree" => "iagree",
                        "parentFild" => "poappendfild",
                        "continent" => "continentsPo",
                        "countrie" => "countriesPo",
                        "language" => "languagesPo",
                        "section" => "PoSections",
                        "sel2" => ".select2-container",
                        "close" => "Poclose",
                        "create" => "PoCreateButton",
                        "outputDiv" => "exlist",
                        "type" => "post",
                        "dataType" => "JSON",
                        "defaultImage" => $this->config["URL"] . $this->config["VIEWS"] . $this->config["ASSSET_IMG"] . "photo1.png",
                        "url" => $this->config["URL"] . "NewPost/CreateNew_Post",
                    ),
                    "continents" => array(
                        "autoloader" => true,
                        "action" => "ListContinents",
                        "type" => "post",
                        "dataType" => "JSON",
                        "outputDiv" => "poappendfild",
                        "url" => $this->config["URL"] . "NewPost/getContinents",
                    ),
                    "countries" => array(
                        "autoloader" => true,
                        "action" => "ListCountries",
                        "type" => "post",
                        "dataType" => "JSON",
                        "outputDiv" => "poappendfild",
                        "url" => $this->config["URL"] . "NewPost/getCountries",
                    ),
                    "languages" => array(
                        "autoloader" => true,
                        "action" => "ListLanguages",
                        "type" => "post",
                        "dataType" => "JSON",
                        "outputDiv" => "poappendfild",
                        "url" => $this->config["URL"] . "NewPost/getLanguages",
                    ),
                    "sections" => array(
                        "autoloader" => true,
                        "action" => "fetchSections",
                        "type" => "post",
                        "dataType" => "JSON",
                        "icheckCH" => "icheckbox_futurico",
                        "outputDiv" => "PoSections",
                        "url" => $this->config["URL"] . "NewPost/getSectionsNames",
                    ),
                    "list" => array(
                        "outputDiv" => "wallContent",
                        "parentDiv" => "postContent",
                        "autoloader" => true,
                        "action" => "listWallPost",
                        "type" => "post",
                        "dataType" => "HTML",
                        "post" => array(
                            "id" => 'poid',
                            "title" => 'potitle',
                            "photo_id" => 'poto_id',
                            "section_id" => '',
                            "user_id" => 'pouser_id',
                            "created_at" => 'pocreated_at',
                            "photo" => array(
                                "parentDiv" => "allphotos",
                                "outputDiv" => "aplistpoto",
                                "p_phid" => 'p_phid',
                                "p_ph" => 'p_ph',
                                "p_pv1" => 'p_pv1',
                                "p_pv2" => 'p_pv2',
                                "p_pv3" => 'p_pv3',
                                "p_pv4" => 'p_pv4',
                                "p_pv5" => 'p_pv5',
                            ),
                            "allphotos" => array(
                                "parentDiv" => "allphotos",
                                "outputDiv" => "aplistpoto",
                                "p_phid" => 'allp_phid',
                                "p_ph" => 'allp_ph',
                                "p_pv1" => 'allp_pv1',
                                "p_pv2" => 'allp_pv2',
                                "p_pv3" => 'allp_pv3',
                                "p_pv4" => 'allp_pv4',
                                "p_pv5" => 'allp_pv5',
                            ),
                        ),
                        "post_location" => array(
                            "post_location" => '',
                            "pcont_id" => '',
                            "pcont_time" => '',
                            "pcont_contid" => '',
                            "pcont_contname" => '',
                        ),
                        "share" => array(
                            "pr_uname" => '',
                            "pr_id" => '',
                            "pr_uid" => '',
                            "pr_time" => '',
                            "pr_repid" => '',
                            "pr_repname" => '',
                        ),
                        "report" => array(
                            "pr_uname" => '',
                            "pr_id" => '',
                            "pr_uid" => '',
                            "pr_time" => '',
                            "pr_repid" => '',
                            "pr_repname" => '',
                        ),
                        "preferences" => array(
                            "outputDiv" => "poprefrnce",
                            "parentDiv" => "polistpre",
                            "pp_preid" => 'pp_preid',
                            "pp_id" => 'pp_id',
                            "pp_uid" => 'pp_uid',
                            "pp_time" => 'pp_time',
                            "pp_preid" => 'pp_preid',
                            "pp_pref" => 'pp_pref',
                        ),
                        "likes" => array(
                            "outputDiv" => "polike",
                            "parentDiv" => "polikeparent",
                            "lk_p_uname" => 'lk_p_uname',
                            "lk_p_id" => 'lk_p_id',
                            "lk_p_uid" => 'lk_p_uid',
                            "lk_p_time" => 'lk_p_time',
                        ),
                        "sections" => array(
                            "ps_id" => '',
                            "ps_time" => '',
                            "ps_secid" => '',
                            "pr_secname" => '',
                        ),
                        "languages" => array(
                            "plng_id" => '',
                            "plng_time" => '',
                            "plng_lngid" => '',
                            "plng_lngname" => '',
                        ),
                        "poster" => array(
                            "poster_id" => '',
                            "poster_pic" => '',
                            "poster_name" => '',
                        ),
                        "tags" => array(
                            "outputDiv" => "potags",
                            "parentBut" => "potagsBut",
                            "parentDiv" => "potagsPDiv",
                        ),
                        "comments" => array(
                            "outputDiv" => "polike",
                            "parentBut" => "showComments",
                            "parentDiv" => "polikeparent",
                            "commenter" => array(
                                "commenter_id" => '',
                                "commenter_pic" => '',
                                "commenter_name" => '',
                            ),
                            "pc_id" => 'pc_id',
                            "pc_uid" => 'pc_uid',
                            "commenter" => 'commenter',
                            "comments" => 'comments',
                            "pc_phid" => 'pc_phid',
                            "pc_ph" => 'pc_ph',
                            "pc_pv1" => 'pc_pv1',
                            "pc_pv2" => 'pc_pv2',
                            "pc_pv3" => 'pc_pv3',
                            "pc_pv4" => 'pc_pv4',
                            "pc_pv5" => 'pc_pv5',
                            "pc_time" => 'pc_time',
                            "pcp_id" => 'pcp_id',
                            "pcp_uid" => 'pcp_uid',
                            "pcp_time" => 'pcp_time',
                            "pcp_preid" => 'pcp_preid',
                            "pcp_pref" => 'pcp_pref',
                            "pcp_uname" => 'pcp_uname',
                            "lk_pc_id" => 'lk_pc_id',
                            "lk_pc_uid" => 'lk_pc_uid',
                            "lk_pc_time" => 'lk_pc_time',
                            "lk_pc_uname" => 'lk_pc_uname',
                            "replys" => array(
                                "outputDiv" => "polike",
                                "parentDiv" => "polikeparent",
                                "replyer" => array(
                                    "replyer_id" => '',
                                    "replyer_pic" => '',
                                    "replyer_name" => '',
                                ),
                                "pcr_id" => 'pcr_id',
                                "pcr_uid" => 'pcr_uid',
                                "reply" => 'reply',
                                "pcr_time" => 'pcr_time',
                                "pcrp_id" => 'pcrp_id',
                                "pcrp_uid" => 'pcrp_uid',
                                "pcrp_time" => 'pcrp_time',
                                "pcrp_preid" => 'pcrp_preid',
                                "pcrp_pref" => 'pcrp_pref',
                                "pcrp_uname" => 'pcrp_uname',
                                "lk_rep_id" => 'lk_rep_id',
                                "lk_replyer_id" => 'lk_replyer_id',
                                "lk_replytime" => 'lk_replytime',
                                "lk_replyer_name" => 'lk_replyer_name',
                                "pcr_phid" => 'pcr_phid',
                                "pcr_ph" => 'pcr_ph',
                                "pcr_pv1" => 'pcr_pv1',
                                "pcr_pv2" => 'pcr_pv2',
                                "pcr_pv3" => 'pcr_pv3',
                                "pcr_pv4" => 'pcr_pv4',
                                "pcr_pv5" => 'pcr_pv5',
                            ),
                        ),
                        "url" => $this->config["URL"] . "NewPost/listWallPost"
                    ),
                ),
                "subscription" => array(
                    "list" => array(
                    ),
                ),
                "adminchannels" => array(
                    "list" => array(
                    ),
                ),
            ),
        );
    }
    public function createdirectories($directory) {
        $this->createDirectory($this->config["DOC_ROOT"] . $this->config["DIRS"]);
        $flag = false;
        $curr_dir = $this->getCurrUserDir();
        $sruct_array = array(
            $this->config["DOC_ROOT"] . $this->config["DIRS"] . "$curr_dir/$directory/channel/",
            $this->config["DOC_ROOT"] . $this->config["DIRS"] . "$curr_dir/$directory/posts/",
            $this->config["DOC_ROOT"] . $this->config["DIRS"] . "$curr_dir/$directory/profile/");
        for ($i = 0; $i < sizeof($sruct_array); $i++) {
            if (PHP_OS == 'WINNT' || PHP_OS == 'WIN32') {
                if (!file_exists($sruct_array[$i])) {
                    if (!mkdir($sruct_array[$i], 0, true) && !is_dir($sruct_array[$i])) {
                        $flag = false;
                        break;
                    } else {
                        $flag = true;
                    }
                }
            }
            if (PHP_OS == 'Linux') {
                if (!file_exists($sruct_array[$i])) {
                    if (!mkdir($sruct_array[$i], 0777, true) && !is_dir($sruct_array[$i])) {
                        $flag = false;
                        break;
                    } else {
                        $flag = true;
                    }
                }
            }
            file_put_contents($sruct_array[$i] . "index.php", "<?php header('Location:" . $this->config["URL"] . "'); ?>");
        }
        if ($flag) {
            $curr_dir = $curr_dir . "/" . $directory;
            return $this->config["DIRS"] . $curr_dir;
        } else
            return NULL;
    }
    public function getCurrUserDir() {
        $i = 2;
        $dir = $this->config["DOC_ROOT"] . $this->config["DIRS"];
        $curr = 'res_';
        if (is_dir($dir)) {
            if ($dh = opendir($dir)) {
                while (($file = readdir($dh)) !== false) {
                    $curr = "res_" . $i;
                    if (is_dir($dir . $file)) {
                        if ($file != "." && $file != ".." && $file == $curr && file_exists($dir . $file . $curr) && is_dir($dir . $file . $curr)) {
                            $num = $this->Number_directories($dir . $file . $curr);
                            if ($num > 9999) {
                                $i++;
                                continue;
                            }
                        }
                    }
                }
            }
            closedir($dh);
        }
        $this->createDirectory($dir . $file . $curr);
        return $curr;
        return $curr;
    }
    public function Number_directories($dir) {
        $i = 0;
        if (is_dir($dir)) {
            if ($dh = opendir($dir)) {
                while ($file = readdir($dh)) {
                    if (is_dir($dir . "/" . $file) && $file != "." && $file != "..") {
                        $i++;
                    }
                }
            }
            closedir($dh);
        }
        return $i;
    }
    public function createDirectory($path1) {
        if (PHP_OS == 'WINNT' || PHP_OS == 'WIN32') {
            if (!file_exists($path1)) {
                mkdir($path1, 0, true);
            }
        }
        if (PHP_OS == 'Linux') {
            if (!file_exists($path1)) {
                mkdir($path1, 0777, true);
            }
        }
        file_put_contents($path1 . "index.php", "<?php header('Location:" . $this->config["URL"] . "'); ?>");
    }
    public function getIdHolders() {
        $data = array(
            "status" => 'error',
            "JSON" => array()
        );
        if (is_array($this->idHolders)) {
            $data["status"] = "success";
            $data["JSON"] = (array) $this->idHolders;
        }
        $this->baseview->setjsonData($data);
        echo $this->baseview->renderJson();
    }
    public function multiExplode($delimiters, $string) {
        $ary = explode($delimiters[0], $string);
        array_shift($delimiters);
        if ($delimiters != NULL) {
            foreach ($ary as $key => $val) {
                $ary[$key] = $this->multiexplode($delimiters, $val);
            }
        }
        return $ary;
    }
}