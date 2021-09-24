<?php

include_once 'dbconnect.php';

/*
ob_start();
$file_name_zip = "backup_file.zip";
$zip = new ZipArchive; 
$zip->open($file_name_zip,  ZipArchive::CREATE  | ZipArchive::OVERWRITE);

$srcDir = "foto/"; //location of the directory
$files= scandir($srcDir);
//print_r($files);

unset($files[0],$files[1]);
foreach ($files as $file) {
    $zip->addFile($srcDir.'\\'.$file, $file);
}
$zip->close();
header('Content-Type: application/zip');
header("Content-Disposition: attachment; filename=" . $file_name_zip);
header('Content-Length: ' . filesize($file_name_zip));
header("Location: " . $file_name_zip);
*/



$dir = 'foto';
$zip_file = 'bck_file.zip';

// Get real path for our folder
$rootPath = realpath($dir);

// Initialize archive object
$zip = new ZipArchive();
$zip->open($zip_file, ZipArchive::CREATE | ZipArchive::OVERWRITE);

// Create recursive directory iterator
/** @var SplFileInfo[] $files */
$files = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($rootPath),
    RecursiveIteratorIterator::LEAVES_ONLY
);

foreach ($files as $name => $file)
{
    // Skip directories (they would be added automatically)
    if (!$file->isDir())
    {
        // Get real and relative path for current file
        $filePath = $file->getRealPath();
        $relativePath = substr($filePath, strlen($rootPath) + 1);

        // Add current file to archive
        $zip->addFile($filePath, $relativePath);
    }
}

// Zip archive will be created only after closing object
$zip->close();


header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename='.basename($zip_file));
header('Content-Transfer-Encoding: binary');
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
header('Content-Length: ' . filesize($zip_file));
readfile($zip_file);


//delete file
unlink($zip_file);
   


?>