<?php
   header("Cache-Control: no-cache");
   header("Expires: -1");
   session_start();
   session_destroy();
   header("Location: ./index.php");
