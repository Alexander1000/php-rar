--TEST--
RarArchive::isBroken/rar_broken_is test
--SKIPIF--
<?php if(!extension_loaded("rar") || version_compare(phpversion(), '8.0') == -1) print "skip"; ?>
--FILE--
<?php

$f = dirname(__FILE__) . "/latest_winrar.rar";
$b = dirname(__FILE__) . "/multi_broken.part1.rar";

echo "\n* unbroken file; bad arguments\n";
$a = RarArchive::open($f);
try {
    var_dump($a->isBroken("jjj"));
    die("should have thrown exception.");
} catch (ArgumentCountError $e) {
    echo "\nOK, threw ArgumentCountError: " . $e->getMessage() . "\n";
}
try {
    var_dump(rar_broken_is($a, "jjj"));
    die("should have thrown exception.");
} catch (ArgumentCountError $e) {
    echo "\nOK, threw ArgumentCountError: " . $e->getMessage() . "\n";
}

echo "\n* unbroken file; as first call\n";
var_dump($a->isBroken());

echo "\n* unbroken file; as second call\n";
$a = RarArchive::open($f);
$a->getEntries();
var_dump($a->isBroken());

echo "\n* broken file; as first call; don't allow broken\n";
$a = RarArchive::open($b);
var_dump($a->isBroken());

echo "\n* broken file; as first call; don't allow broken; kill warning\n";
function retnull() { return null; }
$a = RarArchive::open($b, null, 'retnull');
var_dump($a->isBroken());

echo "\n* broken file; as first call; don't allow broken; kill warning; non OOP\n";
$a = RarArchive::open($b, null, 'retnull');
var_dump(rar_broken_is($a));

echo "\n* broken file; as second call; don't allow broken\n";
$a = RarArchive::open($b);
$a->getEntries();
var_dump($a->isBroken());


echo "\n";
echo "Done.\n";
--EXPECTF--
* unbroken file; bad arguments

OK, threw ArgumentCountError: RarArchive::isBroken() expects exactly 0 arguments, 1 given

OK, threw ArgumentCountError: rar_broken_is() expects exactly 1 argument, 2 given

* unbroken file; as first call
bool(false)

* unbroken file; as second call
bool(false)

* broken file; as first call; don't allow broken

Warning: RarArchive::isBroken(): Volume %smulti_broken.part2.rar was not found in %s on line %d
bool(true)

* broken file; as first call; don't allow broken; kill warning
bool(true)

* broken file; as first call; don't allow broken; kill warning; non OOP
bool(true)

* broken file; as second call; don't allow broken

Warning: RarArchive::getEntries(): Volume %smulti_broken.part2.rar was not found in %s on line %d

Warning: RarArchive::getEntries(): ERAR_EOPEN (file open error) in %s on line %d
bool(true)

Done.