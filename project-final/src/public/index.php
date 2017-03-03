<?php
require '../init.php';

$context = [];
$context['hi'] = "Hello Airbc.";

$template = $twig->load('home.twig');
echo $template->render($context);
