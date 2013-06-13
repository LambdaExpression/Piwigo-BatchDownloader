<?php
define('PHPWG_ROOT_PATH', '../../');
include(PHPWG_ROOT_PATH.'include/common.inc.php');

check_status(ACCESS_GUEST);

try {
  $BatchDownloader = new BatchDownloader($_GET['set_id']);
  $file = $BatchDownloader->getArchivePath();
  
  if (isset($conf['batch_download_direct']) and $conf['batch_download_direct'])
  {
    header('Location: '.$file);
  }
  else
  {
    header('Content-Type: application/force-download; name="'.basename($file).'"');
    header('Content-Disposition: attachment; filename="'.basename($file).'"');
    header('Content-Description: File Transfer');
    header('Content-Transfer-Encoding: binary');
    header('Content-Length: '.filesize($file).'');

    header('Cache-Control: no-cache, must-revalidate');
    header('Pragma: no-cache');
    header('Expires: 0');

    readlargefile($file);
  }
}
catch (Exception $e)
{
  echo $e->getMessage();
}

exit(0);

?>