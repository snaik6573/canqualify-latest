<?php
$dir = "contractor_ans/";

echo '<h3>Contractor Answers Files</h3>';
// Open a directory, and read its contents
if (is_dir($dir)){
  if ($dh = opendir($dir)){
    while (($file = readdir($dh)) !== false){
      echo '<a target="_BLANK" href="'.$dir.$file.'">' . $file . "</a><br>";
    }
    closedir($dh);
  }
}
else { 
  echo '<p>Folder not found</p>';
}


$dir = "forms_n_docs/";
echo '<h3>forms_n_docs Files</h3>';
// Open a directory, and read its contents
if (is_dir($dir)){
  if ($dh = opendir($dir)){
    while (($file = readdir($dh)) !== false){
      echo '<a target="_BLANK" href="'.$dir.$file.'">' . $file . "</a><br>";
    }
    closedir($dh);
  }
}
else { 
  echo '<p>Folder not found</p>';
}
?>
