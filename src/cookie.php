<?php
include __DIR__ . '/../vendor/autoload.php';

$storage = new \Cookies\Model\Storage();

while (fscanf(STDIN, '%s', $input) === 1) {
    if (is_numeric($input)) {
        $cookie = new \Cookies\Model\Cookie($input);
        $storage->add($cookie);
    } else {
        fprintf(STDOUT, "%d\n", $storage->retrieveACookie()->getDiameter());
    }
}
