<?php
/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

if (PHP_SAPI == 'cli')
	die('This example should only be run from a Web Browser');

require '/var/www/html/vendor/autoload.php';

date_default_timezone_set('Asia/Tokyo');


use mikehaertl\wkhtmlto\Pdf;


$pdf = new Pdf([

     // バイナリの位置とエンコード形式
    'binary'   => '/usr/local/bin/wkhtmltox/bin/wkhtmltopdf',
    'encoding' => 'utf-8',

]);
$html = file_get_contents('invoice.tpl');
// ページを追加
$pdf->addPage($html);

// ブラウザにPDFを表示
$pdf->send();

?>