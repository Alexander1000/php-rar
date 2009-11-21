--TEST--
RarEntry::getStream() on unicode entry
--SKIPIF--
<?php if(!extension_loaded("rar")) print "skip"; ?>
--FILE--
<?php

$rar_file1 = rar_open(dirname(__FILE__).'/rar_unicode.rar');
$entry = rar_entry_get($rar_file1, "file1À۞.txt");
var_dump($entry);
echo "\n";
$stream = $entry->getStream();
if ($stream !== false)
	while (!feof($stream)) {
		echo fread($stream, 8192);
	}

echo "\n";
	
echo "Done\n";
?>
--EXPECTF--
object(RarEntry)#%d (%d) {
  ["rarfile"]=>
  resource(%d) of type (Rar file)
  ["name"]=>
  string(13) "file1À۞.txt"
  ["unpacked_size"]=>
  int(18)
  ["packed_size"]=>
  int(18)
  ["host_os"]=>
  int(2)
  ["file_time"]=>
  string(19) "2009-11-18 23:52:24"
  ["crc"]=>
  string(8) "52b28202"
  ["attr"]=>
  int(32)
  ["version"]=>
  int(29)
  ["method"]=>
  int(48)
}

contents of file 1
Done
