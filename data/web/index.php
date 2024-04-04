<?php

session_start();

if(empty($_SESSION['session_id']))
{
  $_SESSION['session_id'] = session_id();
  $_SESSION['count'] = 1; 
}
else
{
  ++$_SESSION['count'];
}

echo "session_id: " . $_SESSION['session_id'];
echo "<br>";
echo "page updates: " . $_SESSION['count'];
