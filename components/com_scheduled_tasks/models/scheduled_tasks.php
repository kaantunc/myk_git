<?php
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.model');
require_once('libraries/form/functions.php');
require_once('libraries'.DS.'form'.DS.'form.php');
require_once('libraries'.DS.'form'.DS.'form_config.php');

class Scheduled_TasksModelScheduled_Tasks extends JModel {
	
	function  getScheduledTasks(){
		$db = JFactory::getOracleDBO ();
		
		$sql = "SELECT ID,
					   TASK_NAME,
					   TASK_STARTTIME,
					   TASK_ENDTIME,
					   PM_TASK_TYPE.TASK_TYPENAME AS TASK_TYPE,
					   TASK_STATUS
				FROM M_SCHEDULED_TASKS
		  INNER JOIN PM_TASK_TYPE ON PM_TASK_TYPE.TASK_TYPEID = M_SCHEDULED_TASKS.TASK_TYPE_ID ORDER BY ID";
		$datas = $db->prep_exec($sql, array());
	
		return $datas;
	} 
	
	
	function  getScheduledTaskById($task_id){
		$db = JFactory::getOracleDBO ();
	
		$sql = "SELECT ID AS TASK_ID,
						TASK_NAME,
						TASK_STARTTIME,
						TASK_ENDTIME,
						TASK_TYPE_ID,
						TASK_WORKTYPE_ID,
						TASK_STATUS,
						TASK_CONTENT
				  FROM M_SCHEDULED_TASKS 
			     WHERE ID = ? ORDER BY ID";
		$datas = $db->prep_exec($sql, array($task_id));
		
		if(count($datas) > 0){
			$data['STATUS']  = true;
			$data['MESSAGE'] = 'Zamanlanmış görev detayına ektedir';
			$data['DATA']    = current($datas);
		}else{
			$data['STATUS']  = false;
			$data['MESSAGE'] = 'Zamanlanmış görev detayına ulaşılamadı'; 
			$data['DATA']    = $datas;
		}
		return $data;
	}
	
	function addScheduledTask($post){
	
		$db = JFactory::getOracleDBO ();		
		$user 	= &JFactory::getUser();
	
		$sql = "INSERT INTO M_SCHEDULED_TASKS(TASK_NAME,TASK_TYPE_ID,TASK_CONTENT,USER_ID,TASK_STARTTIME,TASK_ENDTIME,TASK_WORKTYPE_ID,TASK_STATUS) 
				VALUES(?,?,?,?,?,?,?,?)";

		$return = $db->prep_exec_insert($sql, array($post['task_name'],
												   $post['task_type'],
												   $post['task_content'],
												   $user->getOracleUserId(),
												   $post['task_starttime'],
												   $post['task_endtime'],
												   $post['task_worktype'],
												   $post['task_status']));
		if($return){
			$data['STATUS'] = true;
			$data['MESSAGE'] = "Zamanlanmış görev başarıyla oluşturuldu";
		}else{
			$data['STATUS'] = true;
			$data['MESSAGE'] = "Zamanlanmış oluşturulurken hata oluştu";
		}
		return $data;
	}
	
	function editScheduledTask($post){
		$db = JFactory::getOracleDBO ();
	
		$sql = "UPDATE M_SCHEDULED_TASKS SET TASK_NAME = ?,
											 TASK_TYPE_ID = ?, 
											 TASK_CONTENT = ?,
											 TASK_STARTTIME =?,
											 TASK_ENDTIME =?,
											 TASK_WORKTYPE_ID = ?,
											 TASK_STATUS = ? 
				   					   WHERE ID = ?";
		
		$return = $db->prep_exec_insert($sql, array($post['task_name'],
													$post['task_type'],
													$post['task_content'],
													$post['task_starttime'],
													$post['task_endtime'],
													$post['task_worktype'],
													$post['task_status'],
													$post['task_id']));
		if($return){
			$data['STATUS'] = true;
			$data['MESSAGE'] = "Zamanlanmış görev başarıyla düzenlendi";
		}else{
			$data['STATUS'] = true;
			$data['MESSAGE'] = "Zamanlanmış düzenlenirken hata oluştu";
		}
		return $data;
	}
	
	function deleteScheduledTaskById($task_id){
		$db = JFactory::getOracleDBO ();
		
		$sql = "DELETE FROM M_SCHEDULED_TASKS WHERE ID = ?";
		
		$return = $db->prep_exec_insert($sql, array($task_id));
		
		if($return){
			$data['STATUS']  = true;
			$data['MESSAGE'] = 'Zamanlanmış görev silme işlemibaşarıyla gerçekleştirildi';
		}else{
			$data['STATUS']  = false;
			$data['MESSAGE'] = 'Zamanlanmış görev silme işleminde hata oluştu';
		}
		
		return $data;
	}
	
	function changeTaskStatus($taskid,$status){

		$db = JFactory::getOracleDBO ();
	
		$sql = "UPDATE M_SCHEDULED_TASKS SET TASK_STATUS = ? WHERE ID = ?";
		
		$return = $db->prep_exec_insert($sql, array($status,$taskid));
	
		$gorev = ($status == "0" ? "pasif" : "aktif");
		if($return){
			$data['STATUS']  = true;
			$data['MESSAGE'] = 'Zamanlanmış görev '.$gorev.' etme işlemi başarıyla gerçekleştirildi';
		}else{
			$data['STATUS']  = false;
			$data['MESSAGE'] = 'Zamanlanmış görev '.$gorev.' etme işleminde hata oluştu';
		}
		
		return $data;
	}
	
	function scheduledTasksLog($text){
		
			$conf =& JFactory::getConfig();
	
			if(is_array($text)){
		
				foreach($text as $key => $val){
					$log_text = $key."  :  ".$val."\n";
				}
		
			}else{
				$log_text = $text;
			}
			$log_path = $conf->getValue('config.scheduled_tasks_log');
			$log = "------------------------------------------\n".
					"------------------------------------------\n".
					date('Y-m-d H:i:s')."\n".
					$log_text."\n".
					"------------------------------------------\n".
					"------------------------------------------\n\n";
		
		
			$content = file_get_contents($log_path);
			$content .= $log;
			file_put_contents($log_path, $content);
	}
	
	function readFromZiraatTxt(){
		$db  = JFactory::getOracleDBO ();
		
		$sql = "SELECT ID FROM M_BELGE_TESVIK_ISTEK WHERE DURUM = ?";
		$tesviks = $db->prep_exec($sql, array('4'));
		
		$componentA_modelpath = JPATH_ROOT.DS.'components'.DS.'com_tesvik'.DS.'models';
		JModel::addIncludePath( $componentA_modelpath);
		$tesvik_model =& JModel::getInstance('tesvik','TesvikModel');
		
		$file = $tesvik_model->readFromZiraatTxt($tesviks[0]['ID']);
		
		if($file['STATUS'] == true && $file['FILE'] <> ""){
			$tesvik_model->explodeAndCommitTxt($file['FILE']);
		}

        $sql = "SELECT DISTINCT MBS.KURULUS_ID FROM M_BELGE_TESVIK_ADAY MBTA
                INNER JOIN M_BELGE_SORGU MBS ON(MBTA.BELGE_NO = MBS.BELGENO)
                WHERE TESVIK_ID = ? AND (MBTA.ODENDI = -1 OR MBTA.ODENDI = -2)";
        $dat = $db->prep_exec($sql, array($tesviks[0]['ID']));

        if($dat){
            foreach($dat as $row){
                $kurBilgi = FormFactory::getKurulusBilgi($row['KURULUS_ID']);
                $link = 'http://portal.myk.gov.tr/index.php?option=com_belgelendirme_tesvik&view=belgelendirme_tesvik&layout=tesvik_adaylar_hata';
                $aciklamaText = 'Devlet Teşviği Kapsamında talep ettiğiniz geri ödemelerden bazı adaylara ödeme yapılamamıştır.
                            Bir sonraki ödeme döneminde bu adaylara ödeme yapılabilmesi için bu adayların eksik bilgilerini sistem üzerinden
                            düzenlemeniz gerekmektedir.';
                $body = '<div style="font-size:20px;">';
                $body .='<p>'.$aciklamaText.' Ödeme yapılamayan adaylara ilişkin bilgilere ve ödenememe sebeplerine
                        ulaşmak için <a target="_blank" href="'.$link.'">tıklayınız</a>.</p>';
                $body .='<p>Mesleki Yeterlilik Kurumu</p>';
                $body .= '</div>';
                FormFactory::sentEmail('Devlet Teşviği Kapsamında Ücret İadesi Yapılamayan Adaylar', $body, array($kurBilgi['KURULUS_EPOSTA']), true);

                FormFactory::sektorSorumlusunaNotificationGonder($aciklamaText, $link, $row['KURULUS_ID']);
            }
        }
	}
	
}