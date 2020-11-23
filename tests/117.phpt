--TEST--
rar_entry_get() function
--SKIPIF--
<?php if(!extension_loaded("rar") || version_compare(phpversion(), '8.0') == -1) print "skip"; ?>
--FILE--
<?php

$rar_file1 = rar_open(dirname(__FILE__).'/multi.part1.rar');
$entry = rar_entry_get($rar_file1, "file1.txt");
echo "$entry\n";
$entry = rar_entry_get($rar_file1, "nonexistent_file.txt");
var_dump($entry);
echo "\n";

$rar_file2 = rar_open(dirname(__FILE__).'/nonexistent.rar'); 
$entry = rar_entry_get($rar_file2, "file1.txt");
var_dump($entry);
echo "\n";

echo "Done\n";
?>
--EXPECTF--
RarEntry for file "file1.txt" (52b28202)

Warning: rar_entry_get(): cannot find file "nonexistent_file.txt" in Rar archive "%s" in %s on line %d
bool(false)


Warning: rar_open(): Failed to open %s: ERAR_EOPEN (file open error) in %s on line %d

Fatal error: Uncaught TypeError: rar_entry_get(): Argument #1 ($rarfile) must be of type RarArchive, bool given in %s:%d
Stack trace:
#0 %s(%d): rar_entry_get(false, 'file1.txt')
#1 {main}
  thrown in %s on line %d