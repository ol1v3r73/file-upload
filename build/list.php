<?php
$pathLen = 0;

function prePad($level)
{
  $ss = "";

  for ($ii = 0;  $ii < $level;  $ii++)
  {
    $ss = $ss . "|&nbsp;&nbsp;";
  }

  return $ss;
}

function myScanDir($dir, $level, $rootLen)
{
  global $pathLen;

  if ($handle = opendir($dir)) {

    $allFiles = array();

    while (false !== ($entry = readdir($handle))) {
      if ($entry != "." && $entry != "..") {
        if (is_dir($dir . "/" . $entry))
        {
          $allFiles[] = "D: " . $dir . "/" . $entry;
        }
        else
        {
          $allFiles[] = "F: " . $dir . "/" . $entry;
        }
      }
    }
    closedir($handle);

    natsort($allFiles);

    foreach($allFiles as $value)
    {
      $displayName = substr($value, $rootLen + 4);
      $fileName    = substr($value, 3);
      $linkName    = str_replace(" ", "%20", substr($value, $pathLen + 3));
      if (is_dir($fileName)) {
        echo prePad($level) . $linkName . "<br>\n";
        myScanDir($fileName, $level + 1, strlen($fileName));
      } else {
        echo prePad($level) . "<a href=\"/dl/" . $linkName . "\" style=\"text-decoration:none;\">" . $displayName . "</a><br>\n";
      }
    }
  }
}

?><!DOCTYPE HTML>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Available Files</title>
</head>

<body>
<nav>
  <a href="/index.php">Upload</a>
</nav>
<h1>Available Files</h1>
<p style="font-family:'Courier New', Courier, monospace; font-size:small;">
<?php
  $root = '/home/someuser/www/website.com/public';

  $pathLen = strlen($root);

  myScanDir($root, 0, strlen($root)); ?>
</p>
</body>

</html>
