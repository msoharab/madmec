<?php
/**
 * Header file
 */
error_reporting(E_ALL);
define('CLI', (PHP_SAPI == 'cli') ? true : false);
define('EOL', CLI ? PHP_EOL : '<br />');
define('SCRIPT_FILENAME', basename($_SERVER['SCRIPT_FILENAME'], '.php'));
define('IS_INDEX', SCRIPT_FILENAME == 'index');
require_once 'inc/PhpWord/Autoloader.php';
\PhpOffice\PhpWord\Autoloader::register();
// Set writers
$writers = array('Word2007' => 'docx', 'ODText' => 'odt', 'RTF' => 'rtf', 'HTML' => 'html', 'PDF' => 'pdf');
// Set PDF renderer
$rendererName = \PhpOffice\PhpWord\Settings::PDF_RENDERER_DOMPDF;
$rendererLibraryPath = ''; // DomPDF library path
if (!\PhpOffice\PhpWord\Settings::setPdfRenderer($rendererName, $rendererLibraryPath)) {
    $writers['PDF'] = null;
}
// Return to the caller script when runs by CLI
if (CLI) {
    return;
}
// Set titles and names
$pageHeading = str_replace('_', ' ', SCRIPT_FILENAME);
$pageTitle = IS_INDEX ? 'Welcome to ' : "{$pageHeading} - ";
$pageTitle .= 'PHPWord';
$pageHeading = IS_INDEX ? '' : "<h1>{$pageHeading}</h1>";
// Populate samples
$files = '';
if ($handle = opendir('.')) {
    while (false !== ($file = readdir($handle))) {
        if (preg_match('/^Sample_\d+_/', $file)) {
            $name = str_replace('_', ' ', preg_replace('/(Sample_|\.php)/', '', $file));
            $files .= "<li><a href='{$file}'>{$name}</a></li>";
        }
    }
    closedir($handle);
}
/**
 * Write documents
 *
 * @param \PhpOffice\PhpWord\PhpWord $phpWord
 * @param string $filename
 * @param array $writers
 */
function write($phpWord, $filename, $writers)
{
    $result = '';
    // Write documents
    foreach ($writers as $writer => $extension) {
        $result .= date('H:i:s') . " Write to {$writer} format";
        if (!is_null($extension)) {
            $xmlWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, $writer);
            $xmlWriter->save("{$filename}.{$extension}");
            rename("{$filename}.{$extension}", "results/{$filename}.{$extension}");
        } else {
            $result .= ' ... NOT DONE!';
        }
        $result .= EOL;
    }
    $result .= getEndingNotes($writers);
    return $result;
}
/**
 * Get ending notes
 *
 * @param array $writers
 */
function getEndingNotes($writers)
{
    $result = '';
    // Do not show execution time for index
    if (!IS_INDEX) {
        $result .= date('H:i:s') . " Done writing file(s)" . EOL;
        $result .= date('H:i:s') . " Peak memory usage: " . (memory_get_peak_usage(true) / 1024 / 1024) . " MB" . EOL;
    }
    // Return
    if (CLI) {
        $result .= 'The results are stored in the "results" subdirectory.' . EOL;
    } else {
        if (!IS_INDEX) {
            $types = array_values($writers);
            $result .= '<p>&nbsp;</p>';
            $result .= '<p>Results: ';
            foreach ($types as $type) {
                if (!is_null($type)) {
                    $resultFile = 'results/' . SCRIPT_FILENAME . '.' . $type;
                    if (file_exists($resultFile)) {
                        $result .= "<a href='{$resultFile}' class='btn btn-primary'>{$type}</a> ";
                    }
                }
            }
            $result .= '</p>';
        }
    }
    return $result;
}
?>