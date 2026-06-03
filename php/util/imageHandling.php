<?php
define("IMAGE_PATH", $abs_path."/img/");

function checkAndUploadImage($key){
    if(!$_FILES[$key]["error"] === UPLOAD_ERR_OK){
        $_SESSION["message"] = "upload_error";
        return null;
    }
    $types = ['image/jpg', 'image/jpeg', 'image/png', 'image/gif'];
    if(!in_array($_FILES[$key]["type"], $types)){
        error_log("Dateityp nicht erlaubt");
        $_SESSION["message"] = "upload_type_not_allowed";
        return null;
    }
    //Namen prüfen
    $file_type = ".". explode("/", $_FILES[$key]["type"])[1];
    $new_name = $_SESSION["userID"].time().$file_type;
    $new_dest = IMAGE_PATH.$new_name;
    error_log("New destination: ".$new_dest);
    $success = move_uploaded_file($_FILES[$key]["tmp_name"], $new_dest);
    if(!$success){
        $_SESSION["message"] = "upload_error";
        return null;
    }
    return $new_name;
}

function isImageSet($key){
    return ((isset($_FILES[$key]) && $_FILES[$key]["error"] !== UPLOAD_ERR_NO_FILE));
}

?>