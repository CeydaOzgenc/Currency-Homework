<?php
	$db= new mysqli("localhost","root","","bourse_project");
	function alt_replace($string){
                $search = array(
                    chr(0xC2) . chr(0xA0),
                    chr(0xC2) . chr(0x90),
                    chr(0xC2) . chr(0x9D),
                    chr(0xC2) . chr(0x81),
                    chr(0xC2) . chr(0x8D),
                    chr(0xC2) . chr(0x8F),
                    chr(0xC2) . chr(0xAD),
                    chr(0xAD)
                );
                $string = str_replace($search, '', $string);
                return trim($string);
            }

            function p($par, $st = false){
            	if ($st){
            		return htmlspecialchars(alt_replace(addslashes(trim(@$_POST[$par]))));
            	}else{
            		return addslashes(alt_replace(trim(@$_POST[$par])));
            	}
            }
?>