<?php 
/*$backupfile = "images/bet.png";
$extension = "png";*/
if(file_exists($backupfile)) {   

switch ($extension) {
  case "pdf": $ctype="application/pdf"; break;
  case "exe": $ctype="application/octet-stream"; break;
    case "txt" : $ctype="text/plain"; break;
  case "zip": $ctype="application/zip"; break;
  case "docx":
  case "doc": $ctype="application/msword"; break;
  case "csv":
  case "xls":
  case "xlsx": $ctype="application/vnd.ms-excel"; break;
  case "ppt": $ctype="application/vnd.ms-powerpoint"; break;
  case "gif": $ctype="image/gif"; break;
  case "png": $ctype="image/png"; break;
  case "jpeg":
  case "jpg": $ctype="image/jpg"; break;
  case "tif":
  case "tiff": $ctype="image/tiff"; break;
  case "psd": $ctype="image/psd"; break;
  case "bmp": $ctype="image/bmp"; break;
  case "ico": $ctype="image/vnd.microsoft.icon"; break;
  default: $ctype="application/force-download";
}

header("Pragma: public"); // required
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private",false); // required for certain browsers
header("Content-Type: $ctype");
header('Content-Disposition: attachment; filename="'.$backupfile.'"');
 //header('Content-Disposition: attachment; filename="'.$real.'.'.$extension.'"');
header("Content-Transfer-Encoding: binary");
header("Content-Length: ".$fsize);
ob_clean();
flush();
readfile($backupfile);
}
 
?>