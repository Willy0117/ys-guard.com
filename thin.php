<?php
/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

if (PHP_SAPI == 'cli')
	die('This example should only be run from a Web Browser');

date_default_timezone_set('Asia/Tokyo');

require_once __DIR__ . '/vendor/autoload.php';

$book = PHPExcel_IOFactory::load('details.xlsx');
		// シートの設定を行う
		$book -> setActiveSheetIndex(0);
		$sheet = $book -> getActiveSheet();

$excelWriter = PHPExcel_IOFactory::createWriter($book, 'Excel2007');
$excelWriter->save('/var/www/html/tmp/13-excel.xlsx');


// LibreOfficeでPDF化する
$soffice = '/opt/libreoffice5.4/program/soffice';
$outdir = __DIR__ . '/tmp';
$command = "$soffice --headless --convert-to pdf --outdir $outdir $outdir/13-excel.xlsx";
//echo $command, PHP_EOL;
passthru($command);

// 読み込むPDFファイルを指定
$file = $outdir . '/13-excel.pdf';
 
// PDFを出力する
header("Content-Type: application/pdf");
 
// ファイルを読み込んで出力
readfile($file);
 
exit();
