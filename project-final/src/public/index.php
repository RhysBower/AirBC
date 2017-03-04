<?php
require '../init.php';

$context = [];
$context['page'] = "home";
$context['hi'] = "Hello AirBC.";

$template = $twig->load('home.twig');
echo $template->render($context);
