<?php

 define ('PRO', 1);
 include('options.php');
 include('maketop.php');
 include('links.php');

 if (isset($_GET['act']))

 {
  if ($_GET['act']==1)
  {
    $file = 'template/news.html';
  }
  elseif ($_GET['act']==2)
   {
    $file = 'template/download.html';
   }
   elseif ($_GET['act']==3)
     {
    $file = 'template/story.html';
     }
    elseif ($_GET['act']==4)
     {
     $file = 'template/contacts.html';
     }

  else
   {
   	//��� ��� ���
   	//header('Location: error404.php');
   }
  include($file);
 }

 include("rlinks.php");
 include("makebottom.php");
?>

&lt;&gt;