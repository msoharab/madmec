<?php
$title = basename($_SERVER['SCRIPT_FILENAME'], '.php');
$title = str_replace('_', ' ', $title);
if (strtolower($title) == 'index') {
    $title = 'MadMec | Admin Login';
}
$title = ucwords($title);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!--<link rel="shortcut icon" href="assets/ico/favicon.png">-->
        <?php
        echo '<title>' . $title . '</title>';
        ?>
        <script src="<?php echo URL . ADMIN . ASSET_JSF; ?>jquery-1.11.1.min.js"></script>
        <script src="<?php echo URL . ADMIN . ASSET_JSF; ?>app/var_config.js"></script>
        <script src="<?php echo URL . ADMIN . ASSET_JSF; ?>app/config.js"></script>
    </head>
    <body>