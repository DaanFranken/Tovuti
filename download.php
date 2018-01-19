<?php
include_once 'autoloader.php';
$fileID=$_GET['file_id'];
$db = new Database();
$sth = $db->selectDatabase('upload','upload_ID',$fileID,'');
$result = $sth->fetch();
$size = strlen($result['uploadContent']);
$file = $result['uploadContent'];
$type = $result['type'];

header("Content-length: $size");
// header('Content-Type: application/octet-stream');
switch($type)
{
	case 'xlsx':
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		break;
	case 'xls':
		header('Content-Type: application/vnd.ms-excel');
		break;
	case 'docx':
		header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
		break;
	case 'doc':
		header('Content-Type: application/msword');
		break;
	case 'pdf':
		header('Content-Type: application/pdf');
		break;
	case 'ppt':
		header('Content-Type: application/vnd.ms-powerpoint');
		break;
	case 'pptx':
		header('Content-Type:   application/vnd.openxmlformats-officedocument.presentationml.presentation');
		break;
	case 'zip':
		header('Content-Type:   application/zip');
		break;
}
header("Content-Disposition: attachment; filename=$file");
ob_clean();
flush();
echo $file;

?>