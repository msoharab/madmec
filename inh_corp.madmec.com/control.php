<?php

define("MODULE_0", "config.php");
define("MODULE_1", "database.php");
require_once (MODULE_0);
require_once(CONFIG_ROOT . MODULE_0);
require_once(CONFIG_ROOT . MODULE_1);
//$doc_path = $_SERVER['DOCUMENT_ROOT'] . "/";
//define("DOC_ROOT", $doc_path);
$parameters = array(
    "autoloader" => isset($_POST["autoloader"]) ? $_POST["autoloader"] : false,
    "action" => isset($_POST["action"]) ? $_POST["action"] : false,
);

function main($parameters) {
    $link = MySQLconnect(DBHOST, DBUSER, DBPASS);
    if (($db_select = selectDB(DBNAME_ZERO, $link)) == 1) {
        switch ($parameters['action']) {
            case "signIn":
                userLogin();
                break;
            case "jobPost" :
                echo json_encode(jobPost());
                break;

            case "blogPost" :
                echo json_encode(blogPost());
                break;

            case "messages" :
                echo json_encode(messages());
                break;

            case "jobs":
                echo json_encode(jobs());
                break;

            case "blogs":
                echo json_encode(blogs());
                break;

            case "jobreply":
                echo json_encode(jobreply());
                break;

            case "blogreply":
                echo json_encode(blogreply());
                break;

            case "jobreplylist":
                echo json_encode(jobReplyList());
                break;

            case "blogreviewlist":
                echo json_encode(blogReviewList());
                break;
        }
    }
}

function userLogin() {
    $name = isset($_POST['username']) ? $_POST['username'] : false;
    $Password = isset($_POST['password']) ? $_POST['password'] : false;
    $result = executeQuery('SELECT * FROM `users` WHERE name = "' . $name . '" and password ="' . $Password . '"');

    $row = mysql_fetch_array($result);

    if ($row["name"] == $name && $row["password"] == $Password) {
        $userdata = array(
            "USER_ID" => $row["id"],
            "NAME" => $row["name"],
            "PASSWORD" => $row["password"],
        );
        $_SESSION['USER_LOGIN_DATA'] = $userdata;
        echo "success";
    } else {
        echo "error";
    }
}

function jobPost() {
    //var_dump($_POST);
    $title = isset($_POST['title']) ? $_POST['title'] : false;
    $industry = isset($_POST['industry']) ? $_POST['industry'] : false;
    $employeeType = isset($_POST['EmployeeTY']) ? $_POST['EmployeeTY'] : false;
    $experience = isset($_POST['experience']) ? $_POST['experience'] : false;
    $doj = isset($_POST['doj']) ? date("Y-m-d", strtotime('doj')) : NULL;
    $responsibilities = isset($_POST['responsibilities']) ? $_POST['responsibilities'] : false;
    $skills = isset($_POST['skills']) ? $_POST['skills'] : false;
    $description = isset($_POST['description']) ? $_POST['description'] : false;
    $stat = 1;
    $flag = true;
    //var_dump($doj);
    $qy = "INSERT INTO jobs(title,industry,employment_type,experience,doj,responsibilities,skills,description,status)VALUES('" . mysql_real_escape_string($title) . "','" . mysql_real_escape_string($industry) . "','" . mysql_real_escape_string($employeeType) . "','" . mysql_real_escape_string($experience) . "','" . mysql_real_escape_string($doj) . "','" . mysql_real_escape_string($responsibilities) . "','" . mysql_real_escape_string($skills) . "','" . mysql_real_escape_string($description) . "','" . mysql_real_escape_string($stat) . "');";
    return executeQuery($qy);
}

function blogPost() {
    $blogtitle = isset($_POST['blogtitle']) ? $_POST['blogtitle'] : false;
    $blogimage = isset($_POST['blogimage']) ? $_POST['blogimage'] : false;
    $blogdesc = isset($_POST['blogdesc']) ? $_POST['blogdesc'] : false;
    $stat = 1;
    $flag = true;
    $query1 = 'INSERT INTO photo(original_pic,ver1,ver2,ver3,ver4,ver5)VALUES(NULL,NULL,NULL,NULL,NULL,NULL)';
    if (executeQuery($query1)) {
        $photo = mysql_result(executeQuery('SELECT LAST_INSERT_ID();'), 0);
        $qy = "INSERT INTO blog(title,user_id,image,description,status)VALUES('" . mysql_real_escape_string($blogtitle) . "','" . mysql_real_escape_string($_SESSION['USER_LOGIN_DATA']['USER_ID']) . "','" . mysql_real_escape_string($photo) . "','" . mysql_real_escape_string($blogdesc) . "','" . mysql_real_escape_string($stat) . "');";
        return executeQuery($qy);
        if ($blogimage) {
            $verImages = uploadFileToServer(array(
                "file_name" => $blogimage['name'],
                "file_size" => $blogimage['size'],
                "file_tmp" => $blogimage['tmp_name'],
                "file_type" => $blogimage['type'],
                "directory" => DOC_ROOT . 'uploads/blog_files/',
                "target" => $blogtitle,
                "picid" => (integer) $photo,
            ));
            if ($verImages["status"] == "error") {
                $flag = false;
            }
        }
    }
}

function messages() {
    $name = isset($_POST['name']) ? $_POST['name'] : false;
    $email = isset($_POST['email']) ? $_POST['email'] : false;
    $phone = isset($_POST['phone']) ? $_POST['phone'] : false;
    $password = generateRandomString($length = 6);
    $company = isset($_POST['company']) ? $_POST['company'] : false;
    $companyaddress = isset($_POST['companyaddress']) ? $_POST['companyaddress'] : false;
    $companyprofile = isset($_POST['companyprofile']) ? $_POST['companyprofile'] : false;
    $type = 'Associate';
    $subject = isset($_POST['subject']) ? $_POST['subject'] : false;
    $message = isset($_POST['message']) ? $_POST['message'] : false;
    $stat = 1;
    $flag = true;
    $query1 = 'INSERT INTO photo(original_pic,ver1,ver2,ver3,ver4,ver5)VALUES(NULL,NULL,NULL,NULL,NULL,NULL)';
    if (executeQuery($query1)) {
        $photo = mysql_result(executeQuery('SELECT LAST_INSERT_ID();'), 0);
        $qy = "INSERT INTO users(name,email,phone,address,password,photo_id,type,status)VALUES('" . mysql_real_escape_string($name) . "','" . mysql_real_escape_string($email) . "','" . mysql_real_escape_string($phone) . "','" . mysql_real_escape_string($companyaddress) . "','" . mysql_real_escape_string($password) . "','" . mysql_real_escape_string($photo) . "','" . mysql_real_escape_string($type) . "','" . mysql_real_escape_string($stat) . "')";
        if (executeQuery($qy)) {
            $id = mysql_result(executeQuery('SELECT LAST_INSERT_ID();'), 0);
            $q = "INSERT INTO contact(user_id,company,subject,message,profile,address,status)VALUES('" . mysql_real_escape_string($id) . "','" . mysql_real_escape_string($company) . "','" . mysql_real_escape_string($subject) . "','" . mysql_real_escape_string($message) . "','" . mysql_real_escape_string($photo) . "','" . mysql_real_escape_string($companyaddress) . "','" . mysql_real_escape_string($stat) . "')";
            return executeQuery($q);
            if ($companyprofile) {
                $verImages = uploadFileToServer(array(
                    "file_name" => $picture['name'],
                    "file_size" => $picture['size'],
                    "file_tmp" => $picture['tmp_name'],
                    "file_type" => $picture['type'],
                    "directory" => DOC_ROOT . 'uploads/company_profile/',
                    "target" => $name,
                    "picid" => (integer) $photo,
                ));
                if ($verImages["status"] == "error") {
                    $flag = false;
                }
            }
        }
    }
}

function jobs() {
    $fetchdata = array();
    $alldata = array();
    $data = '';
    $query = 'SELECT * FROM jobs WHERE status=1 ORDER BY id DESC';
    $result = executeQuery($query);
    if (mysql_num_rows($result)) {
        while ($row = mysql_fetch_assoc($result)) {
            $fetchdata[] = $row;
        }
        for ($i = 0; $i < sizeof($fetchdata); $i++) {
            $data .='<tr><td>' . ($i + 1) . '</td><td>' . $fetchdata[$i]['title'] . '</td><td>' . $fetchdata[$i]['industry'] . '</td><td>' . $fetchdata[$i]['employment_type'] . '</td><td>' . $fetchdata[$i]['experience'] . '</td>
                        <td>' . date("d-M-Y",$fetchdata[$i]['doj']) . '</td><td>' . date("d-M-Y",$fetchdata[$i]['dop']) . '</td><td><a href="view.php?id=' . $fetchdata[$i]['id'] . '" class="btn btn-primary">View</a></td></tr>';
            $alldata[$i] = $fetchdata[$i];
        }
        $jsondata = array(
            "status" => "success",
            "data" => $data,
            "alldata" => $alldata,
        );
        return $jsondata;
    } else {
        $jsondata = array(
            "status" => "failure",
            "data" => NULL
        );
        return $jsondata;
    }
}

function blogs() {
    $fetchdata = array();
    $alldata = array();
    $data = '';
    $query = 'SELECT bg.id AS id,
            bg.title AS title,bg.description AS description,
            ph.ver2 AS img
            FROM users AS ad
            LEFT JOIN photo AS ph ON ad.photo_id=ph.id
            LEFT JOIN blog AS bg ON ph.id=bg.image AND ad.id=bg.user_id
            WHERE ad.status=1 AND bg.status=1 AND ph.status=1 ORDER BY bg.id DESC';
    $result = executeQuery($query);
    if (mysql_num_rows($result)) {
        while ($row = mysql_fetch_assoc($result)) {
            $fetchdata[] = $row;
        }
        for ($i = 0; $i < sizeof($fetchdata); $i++) {
            $data .='<tr><td>' . ($i + 1) . '</td><td>' . $fetchdata[$i]['title'] . '</td><td>' . $fetchdata[$i]['description'] . '</td><td class="text-center"><a href="blogview.php?id=' . $fetchdata[$i]['id'] . '" class="btn btn-danger">View<a>&nbsp;&nbsp;<a href="blogreview.php?id=' . $fetchdata[$i]['id'] . '" class="btn btn-success">Review</a></td></tr>';
            $alldata[$i] = $fetchdata[$i];
        }
        $jsondata = array(
            "status" => "success",
            "data" => $data,
            "alldata" => $alldata,
        );
        return $jsondata;
    } else {
        $jsondata = array(
            "status" => "failure",
            "data" => NULL
        );
        return $jsondata;
    }
}

function jobreply() {
    $name = isset($_POST['name']) ? $_POST['name'] : false;
    $email = isset($_POST['email']) ? $_POST['email'] : false;
    $phone = isset($_POST['phone']) ? $_POST['phone'] : false;
    $title = isset($_POST['id']) ? $_POST['id'] : false;
    $picture = isset($_POST['picture']) ? $_POST['picture'] : false;
    $resume = isset($_POST['resume']) ? $_POST['resume'] : false;
    $message = isset($_POST['message']) ? $_POST['message'] : false;
    $type = "Employee";
    $stat = 1;
    $flag = true;
    $query1 = 'INSERT INTO photo(original_pic,ver1,ver2,ver3,ver4,ver5)VALUES(NULL,NULL,NULL,NULL,NULL,NULL)';
    if (executeQuery($query1)) {
        $photo = mysql_result(executeQuery('SELECT LAST_INSERT_ID();'), 0);
        $qy = "INSERT INTO users(name,email,phone,photo_id,type,status)VALUES('" . mysql_real_escape_string($name) . "','" . mysql_real_escape_string($email) . "','" . mysql_real_escape_string($phone) . "','" . mysql_real_escape_string($photo) . "','" . mysql_real_escape_string($type) . "','" . mysql_real_escape_string($stat) . "');";
        if (executeQuery($qy)) {
            $id = mysql_result(executeQuery('SELECT LAST_INSERT_ID();'), 0);
            $q = "INSERT INTO job_reply(job_id,user_id,resume,msg,status)VALUES('" . mysql_real_escape_string($title) . "','" . mysql_real_escape_string($id) . "','" . mysql_real_escape_string($resume) . "','" . mysql_real_escape_string($message) . "','" . mysql_real_escape_string($stat) . "');";
            return executeQuery($q);
            if ($picture) {
                $verImages = uploadFileToServer(array(
                    "file_name" => $picture['name'],
                    "file_size" => $picture['size'],
                    "file_tmp" => $picture['tmp_name'],
                    "file_type" => $picture['type'],
                    "directory" => DOC_ROOT . 'uploads/job_profile/',
                    "target" => $name,
                    "picid" => (integer) $photo,
                ));
                if ($verImages["status"] == "error") {
                    $flag = false;
                }
            }
        }
    }
}

function blogreply() {
    $blog_id = isset($_POST['id']) ? $_POST['id'] : false;
    $name = isset($_POST['name']) ? $_POST['name'] : false;
    $email = isset($_POST['email']) ? $_POST['email'] : false;
    $message = isset($_POST['message']) ? $_POST['message'] : false;
    $stat = 1;
    $type = "Blogger";
    $flag = true;
    $qy = "INSERT INTO users(name,email,type,status)VALUES('" . mysql_real_escape_string($name) . "','" . mysql_real_escape_string($email) . "','" . mysql_real_escape_string($type) . "','" . mysql_real_escape_string($stat) . "')";
    if (executeQuery($qy)) {
        $id = mysql_result(executeQuery('SELECT LAST_INSERT_ID();'), 0);
        $q = "INSERT INTO blog_reply(blog_id,user_id,msg,status)VALUES('" . mysql_real_escape_string($blog_id) . "','" . mysql_real_escape_string($id) . "','" . mysql_real_escape_string($message) . "','" . mysql_real_escape_string($stat) . "')";
        return executeQuery($q);
    }
}

function jobReplyList() {
    $fetchdata = array();
    $alldata = array();
    $data = '';
    $query = 'SELECT ad.name AS name,ad.email AS email,ad.phone AS phone,jb.title AS title,
            jr.msg AS message,jr.timeofapply AS time,
            ver2 AS img
            FROM users AS ad
            LEFT JOIN photo AS ph ON ad.photo_id=ph.id
            LEFT JOIN job_reply AS jr ON ad.id=jr.user_id
            LEFT JOIN jobs AS jb ON jr.job_id=jb.id
            WHERE ad.status=1 AND jb.status=1 AND jr.status=1 AND ph.status=1 ORDER BY jr.id DESC';
    $result = executeQuery($query);
    if (mysql_num_rows($result)) {
        while ($row = mysql_fetch_assoc($result)) {
            $fetchdata[] = $row;
        }
        for ($i = 0; $i < sizeof($fetchdata); $i++) {
            $data .='<tr><td>' . ($i + 1) . '</td><td>' . $fetchdata[$i]['name'] . '</td><td>' . $fetchdata[$i]['email'] . '</td><td>' . $fetchdata[$i]['phone'] . '</td><td>' . $fetchdata[$i]['title'] . '</td><td><a href="' . URL . $fetchdata[$i]['img'] . '" target="_new" class="btn btn-block btn-primary">View<a></td><td>' . $fetchdata[$i]['message'] . '</td><td>' . $fetchdata[$i]['time'] . '</td>
                        </tr>';
            $alldata[$i] = $fetchdata[$i];
        }
        $jsondata = array(
            "status" => "success",
            "data" => $data,
            "alldata" => $alldata,
        );
        return $jsondata;
    } else {
        $jsondata = array(
            "status" => "failure",
            "data" => NULL
        );
        return $jsondata;
    }
}

function blogReviewList() {
    $fetchdata = array();
    $alldata = array();
    $data = '';
    $query = 'SELECT ad.name AS name,
            bg.title AS title,
            br.msg AS message,br.timeofreply AS time
            FROM users AS ad
            LEFT JOIN blog_reply AS br ON ad.id=br.user_id
            LEFT JOIN blog AS bg ON br.blog_id=bg.id
            WHERE ad.status=1 AND bg.status=1 AND br.status=1 ORDER BY br.id DESC';
    $result = executeQuery($query);
    if (mysql_num_rows($result)) {
        while ($row = mysql_fetch_assoc($result)) {
            $fetchdata[] = $row;
        }
        for ($i = 0; $i < sizeof($fetchdata); $i++) {
            $data .='<tr><td>' . ($i + 1) . '</td><td>' . $fetchdata[$i]['name'] . '</td><td>' . $fetchdata[$i]['title'] . '</td><td>' . $fetchdata[$i]['message'] . '</td><td>' . $fetchdata[$i]['time'] . '</td>

                        </tr>';
            $alldata[$i] = $fetchdata[$i];
        }
        $jsondata = array(
            "status" => "success",
            "data" => $data,
            "alldata" => $alldata,
        );
        return $jsondata;
    } else {
        $jsondata = array(
            "status" => "failure",
            "data" => NULL
        );
        return $jsondata;
    }
}

function uploadFileToServer($fileparam) {
    $errors = array();
    $verImages = array(
        "error" => NULL,
        "status" => "error",
    );
    $file = '';
    $path1 = '';
    $relativepath = '';
    $absolutepath = '';

    $target = $fileparam["target"];
    $directory = $fileparam["directory"];
    $pic_id = (integer) $fileparam["picid"];
    $file_name = $fileparam['file_name'];
    $file_size = $fileparam['file_size'];
    $file_tmp = $fileparam['file_tmp'];
    $file_type = $fileparam['file_type'];

    $file_ext = explode('.', $fileparam['file_name']);
    $file_ext = $file_ext[count($file_ext) - 1];
    $file_ext = strtolower($file_ext);

    $extensions = array("jpeg", "jpg", "jpe", "gif", "wbmp", "xbm", "png");

    if (in_array($file_ext, $extensions) === false) {
        $errors[] = "Extension not allowed, please choose a JPEG or PNG file.";
    }

    if ($file_size > 20971520) {
        $errors[] = 'File size must be less than or equal to 2 MB';
    }

    if (empty($errors) == true) {
        $path1 = DOC_ROOT . $directory . '/' . $target;
        $relativepath = $directory . '/' . $target;
        $file = 'ori_pic' . time() . '.' . $file_ext;
        $absolutepath = $path1 . '/' . $file;

        if (move_uploaded_file($file_tmp, $absolutepath)) {
            $temp = ProcessImg($path1, $file);
            if (is_array($temp) && count($temp) > 0) {
                foreach ($temp as &$value) {
                    $value = $relativepath . '/' . $value;
                }
                $temp["original_pic"] = $relativepath . '/' . $file;
                if (updatePortalPhotoDetails($temp, $pic_id)) {
                    $verImages["status"] = "success";
                }
            }
        }
    }
    $verImages["error"] = (array) $errors;
    return $verImages;
}

function updatePortalPhotoDetails($photo = false, $picid = 0) {
    $res3 = false;
    if (is_array($photo) && $picid > 0) {
        if (count($photo) > 0) {
            $query3 = 'UPDATE photo SET original_pic = "' . mysql_real_escape_string($photo['original_pic']) . '",
                        ver1 = "' . mysql_real_escape_string($photo[0]) . '",
                        ver2 = "' . mysql_real_escape_string($photo[1]) . '",
                        ver3 = "' . mysql_real_escape_string($photo[2]) . '",
                        ver4 = "' . mysql_real_escape_string($photo[3]) . '",
                        ver5 = "' . mysql_real_escape_string($photo[4]) . '",
                    WHERE id = "' . mysql_real_escape_string($picid) . '"';
            executeQuery($query3);
        }
    }
    return $res3;
}

function ProcessImg($path, $file) {
    $imageproperties = getimagesize($path . "/" . $file);
    $srcW = $imageproperties[0];
    $srcH = $imageproperties[1];
    $imgtype = $imageproperties[2];
    if ($srcW <= 650)
        return createMultipleVersions($path, $file, $srcW, $srcH, $imgtype, 0.65, 0.55, 0.45, 0.35, 0.25);
    else if ($srcW >= 651 && $srcW <= 1250)
        return createMultipleVersions($path, $file, $srcW, $srcH, $imgtype, 0.55, 0.45, 0.35, 0.25, 0.15);
    else if ($srcW >= 1251 && $srcW <= 1800)
        return createMultipleVersions($path, $file, $srcW, $srcH, $imgtype, 0.45, 0.35, 0.25, 0.15, 0.075);
    else if ($srcW >= 1801 && $srcW <= 2200)
        return createMultipleVersions($path, $file, $srcW, $srcH, $imgtype, 0.35, 0.25, 0.15, 0.075, 0.0375);
    else
        return createMultipleVersions($path, $file, $srcW, $srcH, $imgtype, 0.35, 0.25, 0.15, 0.075, 0.0375);
}

function createMultipleVersions($path, $file, $srcW, $srcH, $imgtype, $ratio1, $ratio2, $ratio3, $ratio4, $ratio5) {
    $versions[0] = floor($srcW * $ratio1) . "_" . floor($srcH * $ratio1);
    $versions[1] = floor($srcW * $ratio2) . "_" . floor($srcH * $ratio2);
    $versions[2] = floor($srcW * $ratio3) . "_" . floor($srcH * $ratio3);
    $versions[3] = floor($srcW * $ratio4) . "_" . floor($srcH * $ratio4);
    $versions[4] = floor($srcW * $ratio5) . "_" . floor($srcH * $ratio5);
    $verimages = array();
    for ($i = 0, $j = 1; $i < sizeof($versions); $i++, $j++) {
        $temp = explode("_", $versions[$i]);
        $desW = $temp[0];
        $desH = $temp[1];
        $image_p = imagecreatetruecolor($desW, $desH);
        $image = createImage($imgtype, $path, $file);
        imagecopyresampled($image_p, $image, 0, 0, 0, 0, $desW, $desH, $srcW, $srcH);
        $temp = explode(".", $file);
        $extension = strtolower($temp[1]);
        $name = $temp[0] . "_ver" . $j . "_." . $extension;
        outputImageToBrowser($image_p, $path, $name, $extension);
        array_push($verimages, $name);
    }
    imagedestroy($image_p);
    return $verimages;
}

function createImage($imageprop, $path, $file) {
    switch ($imageprop) {
        case IMAGETYPE_JPEG:
            return imagecreatefromjpeg($path . "/" . $file);
        case IMAGETYPE_JPEG2000:
            return imagecreatefromjpeg($path . "/" . $file);
        case IMAGETYPE_GIF:
            return imagecreatefromgif($path . "/" . $file);
        case IMAGETYPE_PNG:
            $imgPng = imagecreatefrompng($path . "/" . $file);
            $imgPng = imagetranstowhite($imgPng);
            return $imgPng;
        case IMAGETYPE_WBMP:
            return imagecreatefromwbmp($path . "/" . $file);
        case IMAGETYPE_XBM:
            return imagecreatefromxbm($path . "/" . $file);
        default:
            return false;
    }
}

function outputImageToBrowser($image_p, $path, $name, $extension) {
    if ($extension == "jpg" || $extension == "JPG")
        imagejpeg($image_p, $path . "/" . $name);
    if ($extension == "jpe" || $extension == "JPE")
        imagejpeg($image_p, $path . "/" . $name);
    if ($extension == "jpeg" || $extension == "JPEG")
        imagejpeg($image_p, $path . "/" . $name);
    if ($extension == "png" || $extension == "PNG")
        imagepng($image_p, $path . "/" . $name);
    if ($extension == "gif" || $extension == "GIF")
        imagegif($image_p, $path . "/" . $name);
    if ($extension == "wbmp" || $extension == "WBMP")
        imagewbmp($image_p, $path . "/" . $name);
    if ($extension == "xbm" || $extension == "XBM")
        imagexbm($image_p, $path . "/" . $name);
}

function imagetranstowhite($trans) {
// Create a new true color image with the same size
    $w = imagesx($trans);
    $h = imagesy($trans);
    $white = imagecreatetruecolor($w, $h);
// Fill the new image with white background
    $bg = imagecolorallocate($white, 255, 255, 255);
    imagefill($white, 0, 0, $bg);
// Copy original transparent image onto the new image
    imagecopy($white, $trans, 0, 0, 0, 0, $w, $h);
    return $white;
}

if (isset($parameters["autoloader"]) && $parameters["autoloader"] == 'true') {
    main($parameters);
    unset($_POST);
    exit(0);
}
?>