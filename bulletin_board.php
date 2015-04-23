<html>
 <head><title>Bulletin board</title>
  </head> 
   <body>
    
	<p>掲示板</p>

	<form method = "POST" action = "<?php print($_SERVER["PHP_SELF"]);?>">
	名前を入力してください<br>
	<input type = "text" name = "personal_name"> <br><br>
	
	内容 <br>
	<textarea name = "contents" rows = "3" cols = "50"></textarea> <br><br>
	<input type = "submit" name = "button1" value = "投稿！">
	</form> 

	<?php 

	if($_SERVER["REQUEST_METHOD"] == "POST"){

		writeData();
	}

	readData();

	function writeData(){
		 $personal_name = $_POST['personal_name'];
        	 $contents = $_POST['contents'];
        	 $contents = nl2br($contents);                                                      
       		 $data = "<hr>\r\n";    
		 $data = $data."<p>投稿者:'".$personal_name."</p>\r\n";
        	 $data = $data."<p>内容:</p>\r\n";
        	 $data = $data."<p>".$contents."</p>\r\n";

		$keijiban_file = 'keijiban.txt';
		$fp = fopen($keijiban_file, 'ab');

		if($fp){
			if(flock($fp, LOCK_EX)){
				if(fwrite($fp, $data) === FALSE){
					print('fale to writing');
				}
			flock ($fp, LOCK_UN);
			}else{
				print('fale to filelock');
			}
		}

		fclose($fp);
	}

	function readData(){
		$keijiban_file = 'keijiban.txt';
                $fp = fopen($keijiban_file, 'rb');
		
		if($fp){
			if(flock($fp, LOCK_SH)){
				while (!feof($fp)){
					$buffer = fgets($fp);
					print($buffer);
				}
			}
			
			flock($fp, LOCK_UN);
		} else {
			print('fale to filelock');
		}
	}
	

	?>  

   </body>
</html>

