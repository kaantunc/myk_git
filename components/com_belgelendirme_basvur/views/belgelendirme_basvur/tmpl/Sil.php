<?php
	$evrak_id = $_GET['evrak_id'];
	$silme_hata = "Hata olustu!!!";
	if ($evrak_id)
	{
		$_db = JFactory::getOracleDBO ();
		$sql = "DELETE FROM m_yeterlilik_talebi
				 WHERE evrak_id = ?";
		$params = Array($evrak_id);
		return $_db->prep_exec_insert($sql, $params);
		header("Cache-Control: no-cache, must-revalidate");
		header("location: index.php?option=com_belgelendirme_basvur&layout=giris");
		exit();
	}
	else{
		echo $silme_hata;
		header("Cache-Control: no-cache, must-revalidate");
		header("location: index.php?option=com_belgelendirme_basvur&layout=giris");
		exit();
	}
?>
