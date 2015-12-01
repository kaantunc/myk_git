<?php
	Class FTPClient
	{
		private $connectionId;
		private $loginOk = false;
		private $messageArray = array();

		public function __construct() {	}

		private function logMessage($message, $clear=true) 
		{
			// if ($clear) {$this->messageArray = array();}

			// $this->messageArray[] = $message;
			
			if(!file_exists("metin.txt")){
				$fileLocation = "log.txt";
				$file = fopen($fileLocation,"w");
				fwrite($file,$message);
				fclose($file);
			}else{
				file_put_contents("log.txt", $message."\n", FILE_APPEND);
			}
		}

		public function getMessages()
		{
			return $this->messageArray;
		}
	
		public function connect ($server, $ftpUser, $ftpPassword, $isPassive = false)
		{
			$this->connectionId = ftp_connect($server);

			$loginResult = ftp_login($this->connectionId, $ftpUser, $ftpPassword);

			ftp_pasv($this->connectionId, $isPassive);

			if ((!$this->connectionId) || (!$loginResult)) {
				$this->logMessage('FTP baðlantý hatasý!');
				$this->logMessage('Sunucuya baðlanýlamadý ' . $server . ' Kullanýcý ile ' . $ftpUser, true);
				return false;
			} else {
				$this->logMessage('Sunucuya baðlanýldý ' . $server . ', Kullanýcý ile ' . $ftpUser);
				$this->loginOk = true;
				return true;
			}
		}

		public function makeDir($directory)
		{
			if (ftp_mkdir($this->connectionId, $directory)) {

				$this->logMessage('Klasör "' . $directory . '" baþarýyla oluþturuldu');
				return true;

			} else {

				$this->logMessage('Klasör oluþturulurken hata oluþtu "' . $directory . '"');
				return false;
			}
		}

		public function uploadFile ($fileFrom, $fileTo)
		{
			$asciiArray = array('txt', 'csv');
			$extension = end(explode('.', $fileFrom));
			if (in_array($extension, $asciiArray)) {
				$mode = FTP_ASCII;		
			} else {
				$mode = FTP_BINARY;
			}

			$upload = ftp_put($this->connectionId, $fileTo, $fileFrom, $mode);

			if (!$upload) {

					$this->logMessage('FTP upload iþleminde hata oluþtu!');
					return false;

				} else {
					$this->logMessage('Upload tamamlandý "' . $fileFrom . '" - "' . $fileTo);
					return true;
				}
		}

		public function changeDir($directory)
		{
			if (ftp_chdir($this->connectionId, $directory)) {
				$this->logMessage('Þu anda baðlý olunan klasör: ' . ftp_pwd($this->connectionId));
				return true;
			} else { 
				$this->logMessage('Klasör deðiþtirilemedi');
				return false;
			}
		}

		public function getDirListing($directory = '.', $parameters = '-la')
		{
			// get contents of the current directory
			$contentsArray = ftp_nlist($this->connectionId, $parameters . '  ' . $directory);

			return $contentsArray;
		}

		public function downloadFile ($fileFrom, $fileTo)
		{


			$asciiArray = array('txt', 'csv');
			$extension = end(explode('.', $fileFrom));
			if (in_array($extension, $asciiArray)) {
				$mode = FTP_ASCII;		
			} else {
				$mode = FTP_BINARY;
			}
			
			//$handle = fopen($fileTo, 'w');

			if (ftp_get($this->connectionId, $fileTo, $fileFrom, $mode, 0)) {

				return true;
				$this->logMessage(' Dosya "' . $fileTo . '" baþarýyla indirildi');
			} else {

				return false;
				$this->logMessage('Ýndirilen dosyada hata var "' . $fileFrom . '" to "' . $fileTo . '"');
			}

		}
		
		public function __deconstruct()
		{
			if ($this->connectionId) {
				ftp_close($this->connectionId);
			}
		}			
	}

?>
