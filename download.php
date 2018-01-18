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
header('Content-Type: application/octet-stream');
if($type == 'xlsx')
{
  header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
}
elseif($type == 'xls')
{
  header('Content-Type: application/vnd.ms-excel');
}
elseif($type == 'docx')
{
  header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
}
elseif($type == 'doc')
{
  header('Content-Type: application/msword');
}
elseif($type == 'pdf')
{
  header('Content-Type: application/pdf');
}
elseif($type == 'ppt')
{
  header('Content-Type: application/vnd.ms-powerpoint');
}
elseif($type == 'pptx')
{
  header('Content-Type:   application/vnd.openxmlformats-officedocument.presentationml.presentation');
}
header("Content-Disposition: attachment; filename=$file");
ob_clean();
flush();
echo $file;

?>