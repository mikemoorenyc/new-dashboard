<?php
header('Content-Type: application/javascript');
require_once("../../../wp-load.php");
$clist = '';
if(is_dir(get_template_directory().'/dashview/components/js')) {
  $dir = new DirectoryIterator(get_template_directory().'/dashview/components/js');

  foreach($dir as $d) {
    if(!$d->isDot()) {
      $clist = $clist.file_get_contents(get_template_directory().'/dashview/components/js/'.$d->getFilename(), true);
    }
  }

}
$clist = str_replace("'use strict';","",$clist);
$clist = '"use strict";'.$clist;
echo preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $clist);


 ?>
