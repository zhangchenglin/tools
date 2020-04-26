<?php
require_once dirname(__FILE__) . "/captcha.php";

$captcha_dir = dirname(__DIR__) . '/wwwroot/captcha/';
if (!file_exists($captcha_dir)) mk_dir($captcha_dir);

$captcha
  ->setBackgroundImages(array())
  ->setBackgroundColor(233, 236, 239)
  ->setIgnoreAllEffects(true)
  ->build(100, 36);
