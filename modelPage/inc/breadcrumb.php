<?php
// var_dump($_SESSION);
function breadcrumbName($name1="", $name2="")
{
$html = "";
$html.='<ol style="display: flex;flex: 1;" class="breadcrumb">';
  $html.='<li class="breadcrumb-item">';
    $html.='<a href="#">Inicio</a>';
  $html.='</li>';
  if(!empty($name1))
  {
    $html.='<li class="breadcrumb-item '.($name2=='' ? 'active' : '').'">';
      $html.='<a href="list.php">'.$name1.'</a>';
    $html.='</li>';
  }
  if(!empty($name2))
  {
    $html.='<li class="breadcrumb-item active">'.$name2.'</li>';
  }

$html.='</ol>';

if(isset($_SESSION['alert']))
{
  $typeAlert = $_SESSION['alert']['type'];
  $sessionMessage = $_SESSION['alert']['reason'];
  $html.='<div class="alert alert-'.$typeAlert.'" role="alert" style="/* position: absolute; */display: flex;flex-direction: column;align-self: center;/* right: 150px; */"><h4 class="alert-heading" style="margin-bottom: 0px;font-size: 19px;">'.$sessionMessage.'</h4></div>';
  unset($_SESSION['alert']);
}
return $html;
}


?>
