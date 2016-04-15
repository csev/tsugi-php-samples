<?php
require_once "../config.php";
require_once "files_util.php";

use \Tsugi\Core\Debug;
use \Tsugi\Core\LTIX;

// Sanity checks
$LTI = LTIX::requireData();

$fn = $_REQUEST['file'];
if ( strlen($fn) < 1 ) {
    die("File name not found");
}

$fn = fixFileName($fn);
$foldername = getFolderName();
$filename = $foldername . '/' . fixFileName($fn);

if ( isset($_POST["doDelete"]) ) {
    $foldername = getFolderName();
    $filename = $foldername . '/' . fixFileName($_POST['file']);
    if ( unlink($filename) ) {
        $_SESSION['success'] = 'File deleted';
        header( 'Location: '.addSession('index.php') ) ;
    } else {
        $_SESSION['err'] = 'File delete failed';
        header( 'Location: '.addSession('index.php') ) ;
    }
    return;
}

// Switch to view / controller
$OUTPUT->header();
$OUTPUT->flashMessages();

echo '<h4 style="color:red">Are you sure you want to delete: ' .$fn. "</h4>\n";
?>
<form name=myform enctype="multipart/form-data" method="post">
    <input type=hidden name="file" value="<?php echo $_REQUEST['file']; ?>">
<p><input type=submit name=doCancel onclick="location='<?php echo(addSession('index.php'));?>'; return false;" value="Cancel">
<input type=submit name=doDelete value="Delete"></p>
</form>
<?php

Debug::log('Folder: '.$foldername);

$OUTPUT->footer();
