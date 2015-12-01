<?php
/**
 * @version		$Id: controller.php 16385 2010-04-23 10:44:15Z ian $
 * @package		Joomla
 * @subpackage	Content
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant to the
 * GNU General Public License, and as distributed it includes or is derivative
 * of works licensed under the GNU General Public License or other free or open
 * source software licenses. See COPYRIGHT.php for copyright notices and
 * details.
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );
require_once('libraries/form/form_config.php');
require_once('libraries/form/form.php');
require_once('libraries/form/captcha.php');


jimport('joomla.application.component.controller');

/**
 * User Component Controller
 *
 * @package		Joomla
 * @subpackage	Weblinks
 * @since 1.5
 */
class UserController extends JController
{
	/**
	 * Method to display a view
	 *
	 * @access	public
	 * @since	1.5
	 */
	function display()
	{
		parent::display();
	}
    
    function ajaxChangePassword(){
        $model = $this->getModel('Changepass');
        $model->ajaxSaveRow();

    }

	function edit()
	{
		global $mainframe, $option;

		$db		=& JFactory::getDBO();
		$user	=& JFactory::getUser();

		if ( $user->get('guest')) {
			JError::raiseError( 403, JText::_('Access Forbidden') );
			return;
		}

		JRequest::setVar('layout', 'form');

		parent::display();
	}

	function save()
	{
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );

		$user	 =& JFactory::getUser();
		$userid = JRequest::getVar( 'id', 0, 'post', 'int' );
echo $user->get('id')."-".$userid."-";
exit;
		// preform security checks
		if ($user->get('id') == 0 || $userid == 0 || $userid <> $user->get('id')) {
			JError::raiseError( 403, JText::_('Access Forbidden') );
			return;
		}

		//clean request
		$post = JRequest::get( 'post' );
		$post['username']	= JRequest::getVar('username', '', 'post', 'username');
		$post['password']	= JRequest::getVar('password', '', 'post', 'string', JREQUEST_ALLOWRAW);
		$post['password2']	= JRequest::getVar('password2', '', 'post', 'string', JREQUEST_ALLOWRAW);
	
		// get the redirect
		$return = JURI::base();
		
		// do a password safety check
		if(strlen($post['password']) || strlen($post['password2'])) { // so that "0" can be used as password e.g.
			if($post['password'] != $post['password2']) {
				$msg	= JText::_('PASSWORDS_DO_NOT_MATCH');
				// something is wrong. we are redirecting back to edit form.
				// TODO: HTTP_REFERER should be replaced with a base64 encoded form field in a later release
				$return = str_replace(array('"', '<', '>', "'"), '', @$_SERVER['HTTP_REFERER']);
				if (empty($return) || !JURI::isInternal($return)) {
					$return = JURI::base();
				}
				$this->setRedirect($return, $msg, 'error');
				return false;
			}
		}

		// we don't want users to edit certain fields so we will unset them
		unset($post['gid']);
		unset($post['block']);
		unset($post['usertype']);
		unset($post['registerDate']);
		unset($post['activation']);

		// store data
		$model = $this->getModel('user');

		if ($model->store($post)) {
			$msg	= JText::_( 'Your settings have been saved.' );
		} else {
			//$msg	= JText::_( 'Error saving your settings.' );
			$msg	= $model->getError();
		}

		
		$this->setRedirect( $return, $msg );
	}

	function cancel()
	{
		$this->setRedirect( 'index.php' );
	}

	function login()
	{
		// Check for request forgeries
		JRequest::checkToken('request') or jexit( 'Invalid Token' );
		
		captcha::check("index.php");

		global $mainframe;

		if ($return = JRequest::getVar('return', '', 'method', 'base64')) {
			$return = base64_decode($return);
			if (!JURI::isInternal($return)) {
				$return = '';
			}
		}

		$options = array();
		$options['remember'] = JRequest::getBool('remember', false);
		$options['return'] = $return;

		$credentials = array();
		$credentials['username'] = JRequest::getVar('username', '', 'method', 'username');
		$credentials['password'] = JRequest::getString('passwd', '', 'post', JREQUEST_ALLOWRAW);

		//preform the login action
		$error = $mainframe->login($credentials, $options);

		if(!JError::isError($error))
		{
			// Redirect if the return url is not registration or login
			if ( ! $return ) {
				$return	= 'index.php?option=com_user';
				
			}else{
				$db			=& JFactory::getDBO(); 		 //Mysql
				$user 		=& JFactory::getUser();
				
				$tgUserId 	= $user->getOracleUserId ();
				$active 	= $user->getActive();

				if ($tgUserId != null){// Kurum kaydi yapmissa
					$dbOrc		=& JFactory::getOracleDBO(); //Oracle
					
					if ($active == null or $active==0){ //Sadece 1 kere girmeli
						if ($this->getPersonelDurum ($dbOrc, $tgUserId)){
							$this->activateUser ($db, $user->id);
							
							$tips = $this->getBasvuruTip ($dbOrc, $tgUserId);
							
							for ($i = 0; $i < count($tips); $i++){		
								switch ($tips[$i]){
									case 1: 
										//Meslek Standardi
										$role 		= T1_ROLE_ID;
										$group 		= T1_GROUP_ID;
										$function 	= T1_FUNCTION_ID;
										break;
									case 2:
										//Yeterlilik
										$role 		= T2_ROLE_ID;
										$group 		= T2_GROUP_ID;
										$function 	= T2_FUNCTION_ID;
										break;
									case 3:	
										//Sinav ve Belgelendirme
										$role 		= T3_ROLE_ID;
										$group 		= T3_GROUP_ID;
										$function 	= T3_FUNCTION_ID;
										break;
									case 4:	
										//Akreditasyon
										$role 		= T4_ROLE_ID;
										$group 		= T4_GROUP_ID;
										$function 	= T4_FUNCTION_ID;
										break;
									
								}
							
								if ($i == 0) //ilk seferde update et
									$this->updateAclGroup ($db, $user, $group, $role, $function);
								else {//digerlerini insert et
									$this->insertAclGroup ($db, $user, $group, $role, $function);
								}	
							}//End for
						}else if ($active == null){ //Daha Kurulus basvuru onay almamis
							//Mesaj
						}	
					}else if ($active == 1){	//Kurulus Basvurusu Onaylanmis
						$kurulus_durum = $this->getKurulusDurum ($dbOrc, $tgUserId);
						
						if ($kurulus_durum != 1){ //En az bir basvurusu onaylanmis
							switch ($kurulus_durum){
								case 2:
									//Yetkilendirilmis Meslek Standardi Kurulusu
									//$role		= YT1_ROLE_ID;
									//$group 		= YT1_GROUP_ID;
									//$function 	= YT1_FUNCTION_ID;
									$roleArr = array (YT1_ROLE_ID);
									$groupArr = array (YT1_GROUP_ID);
									$functionArr = array (YT1_FUNCTION_ID);
									
									//YET ve SvB sil
									//$this->deleteAclGroup ($db, $user, YT2_GROUP_ID);
									//$this->deleteAclGroup ($db, $user, YT3_GROUP_ID);
									
									//Gruba Uye Degilse Ekle
									//if (!FormFactory::checkAclGroupId ($user->id, $group))
									//	$this->insertAclGroup ($db, $user, $group, $role, $function);
									break;
								case 3:	
									//Yetkilendirilmis Yeterlilik Kurulusu
									//$role		= YT2_ROLE_ID;
									//$group 		= YT2_GROUP_ID;
									//$function 	= YT2_FUNCTION_ID;
									$roleArr = array (YT2_ROLE_ID);
									$groupArr = array (YT2_GROUP_ID);
									$functionArr = array (YT2_FUNCTION_ID);
									
									//MSTD ve SvB sil
									//$this->deleteAclGroup ($db, $user, YT1_GROUP_ID);
									//$this->deleteAclGroup ($db, $user, YT3_GROUP_ID);
									
									//Gruba Uye Degilse Ekle
									//if (!FormFactory::checkAclGroupId ($user->id, $group))
									//	$this->insertAclGroup ($db, $user, $group, $role, $function);											
									break;
								case 4:	
									//Yetkilendirilmis Belgelendirme Kurulusu
									//$role		= YT3_ROLE_ID;
									//$group 		= YT3_GROUP_ID;
									//$function 	= YT3_FUNCTION_ID;
									
									$roleArr = array (YT3_ROLE_ID);
									$groupArr = array (YT3_GROUP_ID);
									$functionArr = array (YT3_FUNCTION_ID);
									
									//MSTD ve YET sil
									//$this->deleteAclGroup ($db, $user, YT1_GROUP_ID);
									//$this->deleteAclGroup ($db, $user, YT2_GROUP_ID);

									//Gruba Uye Degilse Ekle
									//if (!FormFactory::checkAclGroupId ($user->id, $group))
									//	$this->insertAclGroup ($db, $user, $group, $role, $function);
									break;
								case 5:
									$roleArr = array (YT4_ROLE_ID);
									$groupArr = array (YT4_GROUP_ID);
									$functionArr = array (YT4_FUNCTION_ID);
									break;									
								case 6:	
									//MSTD ve YET
									$roleArr = array (YT1_ROLE_ID, YT2_ROLE_ID);
									$groupArr = array (YT1_GROUP_ID, YT2_GROUP_ID);
									$functionArr = array (YT1_FUNCTION_ID, YT2_FUNCTION_ID);
									
									//SvB sil
									//$this->deleteAclGroup ($db, $user, YT3_GROUP_ID);
									break;
								case 7:	
									//MSTD ve SvB
									$roleArr = array (YT1_ROLE_ID, YT3_ROLE_ID);
									$groupArr = array (YT1_GROUP_ID, YT3_GROUP_ID);
									$functionArr = array (YT1_FUNCTION_ID, YT3_FUNCTION_ID);
									
									//YET sil
									//$this->deleteAclGroup ($db, $user, YT2_GROUP_ID);
									break;
								case 8:	
									//MSTD ve AKR
									$roleArr = array (YT1_ROLE_ID , YT4_ROLE_ID);
									$groupArr = array (YT1_GROUP_ID, YT4_GROUP_ID);
									$functionArr = array (YT1_FUNCTION_ID,YT4_FUNCTION_ID);
									break;
								case 9:
									//YET ve SvB	
									$roleArr = array (YT2_ROLE_ID, YT3_ROLE_ID);
									$groupArr = array (YT2_GROUP_ID, YT3_GROUP_ID);
									$functionArr = array (YT2_FUNCTION_ID, YT3_FUNCTION_ID);
									
									//MSTD sil
									//$this->deleteAclGroup ($db, $user, YT1_GROUP_ID);
									break;
								case 10:	
									//YET ve AKR
									$roleArr = array (YT2_ROLE_ID , YT4_ROLE_ID);
									$groupArr = array (YT2_GROUP_ID, YT4_GROUP_ID);
									$functionArr = array (YT2_FUNCTION_ID,YT4_FUNCTION_ID);
									break;
								case 11:	
									//SvB ve AKR
									$roleArr = array (YT3_ROLE_ID , YT4_ROLE_ID);
									$groupArr = array (YT3_GROUP_ID, YT4_GROUP_ID);
									$functionArr = array (YT3_FUNCTION_ID,YT4_FUNCTION_ID);
									break;
								case 12:	
									//MSTD, YET ve SvB
									$roleArr = array (YT1_ROLE_ID,YT2_ROLE_ID, YT3_ROLE_ID);
									$groupArr = array (YT1_GROUP_ID, YT2_GROUP_ID, YT3_GROUP_ID);
									$functionArr = array (YT1_FUNCTION_ID,YT2_FUNCTION_ID, YT3_FUNCTION_ID);
									break;
								case 13:	
									//MSTD, YET ve AKR
									$roleArr = array (YT1_ROLE_ID,YT2_ROLE_ID, YT4_ROLE_ID);
									$groupArr = array (YT1_GROUP_ID, YT2_GROUP_ID, YT4_GROUP_ID);
									$functionArr = array (YT1_FUNCTION_ID,YT2_FUNCTION_ID, YT4_FUNCTION_ID);
									break;
								case 14:	
									//MSTD, SvB ve AKR
									$roleArr = array (YT1_ROLE_ID,YT3_ROLE_ID, YT4_ROLE_ID);
									$groupArr = array (YT1_GROUP_ID, YT3_GROUP_ID, YT4_GROUP_ID);
									$functionArr = array (YT1_FUNCTION_ID,YT3_FUNCTION_ID, YT4_FUNCTION_ID);
									break;
								case 15:	
									//SvB, YET ve AKR
									$roleArr = array (YT2_ROLE_ID,YT3_ROLE_ID, YT4_ROLE_ID);
									$groupArr = array (YT2_GROUP_ID, YT3_GROUP_ID, YT4_GROUP_ID);
									$functionArr = array (YT2_FUNCTION_ID,YT3_FUNCTION_ID, YT4_FUNCTION_ID);
									break;
								case 16:	
									//4'u Birden
									$roleArr = array (YT1_ROLE_ID,YT2_ROLE_ID, YT3_ROLE_ID, YT4_ROLE_ID);
									$groupArr = array (YT1_GROUP_ID, YT2_GROUP_ID, YT3_GROUP_ID, YT4_GROUP_ID);
									$functionArr = array (YT1_FUNCTION_ID,YT2_FUNCTION_ID, YT3_FUNCTION_ID, YT4_FUNCTION_ID);
									break;
							}
							
							//T1, T2, T3, T4 silinmeyecek
							$this->deleteAllAclGroups ($db, $user);							
							
							for ($i = 0; $i < count($roleArr); $i++){
								$role		= $roleArr[$i];
								$group 		= $groupArr[$i];
								$function 	= $functionArr[$i];
							
								//Gruba Uye Degilse Ekle
								if (!FormFactory::checkAclGroupId ($user->id, $group))
									$this->insertAclGroup ($db, $user, $group, $role, $function);
							}
						}else{ // Hicbir basvurusu onayli degil
							//T1, T2, T3, T4 silinmeyecek
							$this->deleteAllAclGroups ($db, $user);		
						}
					}else if ($active == 2){ // SEKTOR SORUMLUSU
						//Meslek veya Yeterlilik grubunu sec
						$tip = $this->getSektorSorumlusuTip ($dbOrc, $tgUserId);
						
						switch ($tip){
							case MS_SEKTOR_TIPI: 
								//Meslek Standart Sektor Sorumlusu 
								$role		= MS_SEKTOR_SORUMLUSU_ROLE_ID;
								$group 		= MS_SEKTOR_SORUMLUSU_GROUP_ID;
								$function 	= MS_SEKTOR_SORUMLUSU_FUNCTION_ID;
								
								$this->deleteAclGroup ($db, $user, YET_SEKTOR_SORUMLUSU_GROUP_ID);
								//Gruba Uye Degilse Ekle
								if (!FormFactory::checkAclGroupId ($user->id, $group))
									$this->insertAclGroup ($db, $user, $group, $role, $function);
								break;
							case YET_SEKTOR_TIPI:
								//Yeterlilik Sektor Sorumlusu
								$role		= YET_SEKTOR_SORUMLUSU_ROLE_ID;
								$group 		= YET_SEKTOR_SORUMLUSU_GROUP_ID;
								$function 	= YET_SEKTOR_SORUMLUSU_FUNCTION_ID;
								
								$this->deleteAclGroup ($db, $user, MS_SEKTOR_SORUMLUSU_GROUP_ID);
								//Gruba Uye Degilse Ekle
								if (!FormFactory::checkAclGroupId ($user->id, $group))
									$this->insertAclGroup ($db, $user, $group, $role, $function);											
								break;
							case 3:	
								//Ikisi birden
								$roleArr = array (YET_SEKTOR_SORUMLUSU_ROLE_ID, MS_SEKTOR_SORUMLUSU_ROLE_ID);
								$groupArr = array (YET_SEKTOR_SORUMLUSU_GROUP_ID, MS_SEKTOR_SORUMLUSU_GROUP_ID);
								$functionArr = array (YET_SEKTOR_SORUMLUSU_FUNCTION_ID, MS_SEKTOR_SORUMLUSU_FUNCTION_ID);
								
								for ($i = 0; $i < count($roleArr); $i++){
									$role		= $roleArr[$i];
									$group 		= $groupArr[$i];
									$function 	= $functionArr[$i];
								
									//Gruba Uye Degilse Ekle
									if (!FormFactory::checkAclGroupId ($user->id, $group))
										$this->insertAclGroup ($db, $user, $group, $role, $function);
								}
						}		
							
						//$mainframe->redirect( $return , "sektor sorumlusu");
					}else if($active == 7)/* Matbaa Kullanıcısı için*/{
						$role		= 26;
						$group 		= 26;
						$function 	= 18;
						
						$this->deleteAclGroup ($db, $user, 26);
						//Gruba Uye Degilse Ekle
						if (!FormFactory::checkAclGroupId ($user->id, $group))
							$this->insertAclGroup ($db, $user, $group, $role, $function);
					}
				}

				
			}


			$mainframe->redirect( $return );
		}
		else
		{
			// Facilitate third party login forms
			if ( ! $return ) {
				$return	= 'index.php?option=com_user&view=login';
			}

			// Redirect to a login form
			$mainframe->redirect( $return );
		}
	}

	function logout()
	{
		global $mainframe;

		//preform the logout action
		$error = $mainframe->logout();

		if(!JError::isError($error))
		{
			$mainframe->redirect( "index.php" );
			/*
			if ($return = JRequest::getVar('return', '', 'method', 'base64')) {
				$return = base64_decode($return);
				if (!JURI::isInternal($return)) {
					$return = '';
				}
			}

			// Redirect if the return url is not registration or login
			if ( $return && !( strpos( $return, 'com_user' )) ) {
				$mainframe->redirect( $return );
			}*/
		} 
		else 
		{
			parent::display();
		}
	}

	/**
	 * Prepares the registration form
	 * @return void
	 */
	function register()
	{
		$usersConfig = &JComponentHelper::getParams( 'com_users' );
		if (!$usersConfig->get( 'allowUserRegistration' )) {
			JError::raiseError( 403, JText::_( 'Access Forbidden' ));
			return;
		}

		$user 	=& JFactory::getUser();

		if ( $user->get('guest')) {
			JRequest::setVar('view', 'register');
		} else {
			$this->setredirect('index.php?option=com_user&task=edit',JText::_('You are already registered.'));
		}

		parent::display();
	}

	/**
	 * Save user registration and notify users and admins if required
	 * @return void
	 */
	function register_save()
	{
		global $mainframe;

		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );

		// Get required system objects
		$db			=& JFactory::getDBO(); 		// -> Bu yoktu
		$user 		= clone(JFactory::getUser());
		$pathway 	=& $mainframe->getPathway();
		$config		=& JFactory::getConfig();
		$authorize	=& JFactory::getACL();
		$document   =& JFactory::getDocument();

		// If user registration is not allowed, show 403 not authorized.
		$usersConfig = &JComponentHelper::getParams( 'com_users' );
		if ($usersConfig->get('allowUserRegistration') == '0') {
			JError::raiseError( 403, JText::_( 'Access Forbidden' ));
			return;
		}

		// Initialize new usertype setting
		$newUsertype = $usersConfig->get( 'new_usertype' );
		if (!$newUsertype) {
			$newUsertype = 'Registered';
		}

		// Bind the post array to the user object
		if (!$user->bind( JRequest::get('post'), 'usertype' )) {
			JError::raiseError( 500, $user->getError());
		}

		// Set some initial user values
		$user->set('id', 0);
		$user->set('usertype', $newUsertype);
		$user->set('gid', $authorize->get_group_id( '', $newUsertype, 'ARO' ));

		$date =& JFactory::getDate();
		$user->set('registerDate', $date->toMySQL());

		// If user activation is turned on, we need to set the activation information
		$useractivation = $usersConfig->get( 'useractivation' );
		if ($useractivation == '1')
		{
			jimport('joomla.user.helper');
			$user->set('activation', JUtility::getHash( JUserHelper::genRandomPassword()) );
			$user->set('block', '1');
		}

		// If there was an error with registration, set the message and display form
		if ( !$user->save() )
		{
			JError::raiseWarning('', JText::_( $user->getError()));
			$this->register();
			return false;
		}

		// Send registration confirmation mail
		$password = JRequest::getString('password', '', 'post', JREQUEST_ALLOWRAW);
		$password = preg_replace('/[\x00-\x1F\x7F]/', '', $password); //Disallow control chars in the email
		UserController::_sendMail($user, $password);

		// Everything went fine, set relevant message depending upon user activation state and display message
		if ( $useractivation == 1 ) {
			$message  = JText::_( 'REG_COMPLETE_ACTIVATE' );
		} else {
			$message = JText::_( 'REG_COMPLETE' );
		}
		//insert acl group (Kurulus Kaydi Olmayan Kullanici)
		$this->insertAclGroup ($db, $user, 10, 9, 9);

		$this->setRedirect('index.php', $message);
	}

	function activate()
	{
		global $mainframe;

		// Initialize some variables
		$db			=& JFactory::getDBO();
		$user 		=& JFactory::getUser();
		$document   =& JFactory::getDocument();
		$pathway 	=& $mainframe->getPathWay();

		$usersConfig = &JComponentHelper::getParams( 'com_users' );
		$userActivation			= $usersConfig->get('useractivation');
		$allowUserRegistration	= $usersConfig->get('allowUserRegistration');

		// Check to see if they're logged in, because they don't need activating!
		if ($user->get('id')) {
			// They're already logged in, so redirect them to the home page
			$mainframe->redirect( 'index.php' );
		}

		if ($allowUserRegistration == '0' || $userActivation == '0') {
			JError::raiseError( 403, JText::_( 'Access Forbidden' ));
			return;
		}

		// create the view
		require_once (JPATH_COMPONENT.DS.'views'.DS.'register'.DS.'view.html.php');
		$view = new UserViewRegister();

		$message = new stdClass();

		// Do we even have an activation string?
		$activation = JRequest::getVar('activation', '', '', 'alnum' );
		$activation = $db->getEscaped( $activation );

		if (empty( $activation ))
		{
			// Page Title
			$document->setTitle( JText::_( 'REG_ACTIVATE_NOT_FOUND_TITLE' ) );
			// Breadcrumb
			$pathway->addItem( JText::_( 'REG_ACTIVATE_NOT_FOUND_TITLE' ));

			$message->title = JText::_( 'REG_ACTIVATE_NOT_FOUND_TITLE' );
			$message->text = JText::_( 'REG_ACTIVATE_NOT_FOUND' );
			$view->assign('message', $message);
			$view->display('message');
			return;
		}

		// Lets activate this user
		jimport('joomla.user.helper');
		if (JUserHelper::activateUser($activation))
		{
			// Page Title
			$document->setTitle( JText::_( 'REG_ACTIVATE_COMPLETE_TITLE' ) );
			// Breadcrumb
			$pathway->addItem( JText::_( 'REG_ACTIVATE_COMPLETE_TITLE' ));

			$message->title = JText::_( 'REG_ACTIVATE_COMPLETE_TITLE' );
			$message->text = JText::_( 'REG_ACTIVATE_COMPLETE' );
		}
		else
		{
			// Page Title
			$document->setTitle( JText::_( 'REG_ACTIVATE_NOT_FOUND_TITLE' ) );
			// Breadcrumb
			$pathway->addItem( JText::_( 'REG_ACTIVATE_NOT_FOUND_TITLE' ));

			$message->title = JText::_( 'REG_ACTIVATE_NOT_FOUND_TITLE' );
			$message->text = JText::_( 'REG_ACTIVATE_NOT_FOUND' );
		}

		$view->assign('message', $message);
		$view->display('message');
	}

	/**
	 * Password Reset Request Method
	 *
	 * @access	public
	 */
	function requestreset()
	{
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );

		// Get the input
		$email		= JRequest::getVar('email', null, 'post', 'string');

		// Get the model
		$model = &$this->getModel('Reset');

		// Request a reset
		if ($model->requestReset($email) === false)
		{
			$message = JText::sprintf('PASSWORD_RESET_REQUEST_FAILED', $model->getError());
			$this->setRedirect('index.php?option=com_user&view=reset', $message);
			return false;
		}

		$this->setRedirect('index.php?option=com_user&view=reset&layout=confirm');
	}

	/**
	 * Password Reset Confirmation Method
	 *
	 * @access	public
	 */
	function confirmreset()
	{
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );

		// Get the input
		$token = JRequest::getVar('token', null, 'post', 'alnum');
		$username = JRequest::getVar('username', null, 'post');

		// Get the model
		$model = &$this->getModel('Reset');

		// Verify the token
		if ($model->confirmReset($token, $username) !== true)
		{
			$message = JText::sprintf('PASSWORD_RESET_CONFIRMATION_FAILED', $model->getError());
			$this->setRedirect('index.php?option=com_user&view=reset&layout=confirm', $message);
			return false;
		}
		$this->setRedirect('index.php?option=com_user&view=reset&layout=complete');
	}

	/**
	 * Password Reset Completion Method
	 *
	 * @access	public
	 */
	function completereset()
	{
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );

		// Get the input
		$password1 = JRequest::getVar('password1', null, 'post', 'string', JREQUEST_ALLOWRAW);
		$password2 = JRequest::getVar('password2', null, 'post', 'string', JREQUEST_ALLOWRAW);

		// Get the model
		$model = &$this->getModel('Reset');

		// Reset the password
		if ($model->completeReset($password1, $password2) === false)
		{
			$message = JText::sprintf('PASSWORD_RESET_FAILED', $model->getError());
			$this->setRedirect('index.php?option=com_user&view=reset&layout=complete', $message);
			return false;
		}

		$message = JText::_('PASSWORD_RESET_SUCCESS');
		$this->setRedirect('index.php?option=com_user&view=login', $message);
	}

	/**
	 * Username Reminder Method
	 *
	 * @access	public
	 */
	function remindusername()
	{
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );

		// Get the input
		$email = JRequest::getVar('email', null, 'post', 'string');

		// Get the model
		$model = &$this->getModel('Remind');

		// Send the reminder
		if ($model->remindUsername($email) === false)
		{
			$message = JText::sprintf('USERNAME_REMINDER_FAILED', $model->getError());
			$this->setRedirect('index.php?option=com_user&view=remind', $message);
			return false;
		}

		$message = JText::sprintf('USERNAME_REMINDER_SUCCESS', $email);
		$this->setRedirect('index.php?option=com_user&view=login', $message);
	}

	function _sendMail(&$user, $password)
	{
		global $mainframe;

		$db		=& JFactory::getDBO();

		$name 		= $user->get('name');
		$email 		= $user->get('email');
		$username 	= $user->get('username');

		$usersConfig 	= &JComponentHelper::getParams( 'com_users' );
		$sitename 		= $mainframe->getCfg( 'sitename' );
		$useractivation = $usersConfig->get( 'useractivation' );
		$mailfrom 		= $mainframe->getCfg( 'mailfrom' );
		$fromname 		= $mainframe->getCfg( 'fromname' );
		$siteURL		= JURI::base();

		$subject 	= sprintf ( JText::_( 'Account details for' ), $name, $sitename);
		$subject 	= html_entity_decode($subject, ENT_QUOTES);

		if ( $useractivation == 1 ){
			$message = sprintf ( JText::_( 'SEND_MSG_ACTIVATE' ), $name, $sitename, $siteURL."index.php?option=com_user&task=activate&activation=".$user->get('activation'), $siteURL, $username, $password);
		} else {
			$message = sprintf ( JText::_( 'SEND_MSG' ), $name, $sitename, $siteURL);
		}

		$message = html_entity_decode($message, ENT_QUOTES);

		//get all super administrator
		$query = 'SELECT name, email, sendEmail' .
				' FROM #__users' .
				' WHERE LOWER( usertype ) = "super administrator"';
		$db->setQuery( $query );
		$rows = $db->loadObjectList();

		// Send email to user
		if ( ! $mailfrom  || ! $fromname ) {
			$fromname = $rows[0]->name;
			$mailfrom = $rows[0]->email;
		}

		JUtility::sendMail($mailfrom, $fromname, $email, $subject, $message);

		// Send notification to all administrators
		$subject2 = sprintf ( JText::_( 'Account details for' ), $name, $sitename);
		$subject2 = html_entity_decode($subject2, ENT_QUOTES);

		// get superadministrators id
		foreach ( $rows as $row )
		{
			if ($row->sendEmail)
			{
				$message2 = sprintf ( JText::_( 'SEND_MSG_ADMIN' ), $row->name, $sitename, $name, $email, $username);
				$message2 = html_entity_decode($message2, ENT_QUOTES);
				JUtility::sendMail($mailfrom, $fromname, $row->email, $subject2, $message2);
			}
		}
	}
	function getKurulusDurum ($dbOrc, $user_id){
		$sql = "SELECT kurulus_durum_id 
				FROM m_kurulus 
				WHERE user_id = ?";
		
		$param = array ($user_id);
		$data = $dbOrc->prep_exec_array($sql, $param);
		
		return $data[0];
	}
	
	function getPersonelDurum ($dbOrc, $user_id){
		$sql = "SELECT personel_durum_id 
				FROM ".DB_PREFIX.".p_personel 
				WHERE user_id = ?";
		
		$param = array ($user_id);
		$data = $dbOrc->prep_exec_array($sql, $param);
		
		return $data[0];
	}
	
	function getBasvuruTip ($dbOrc, $user_id){
		$sql = "SELECT basvuru_tip_id 
				FROM pm_user_basvuru_tip 
				WHERE user_id = ?";
		
		$param = array ($user_id);
		$data = $dbOrc->prep_exec_array($sql, $param);
		
		return $data; 
	}
	
	function getSektorSorumlusuTip ($dbOrc, $user_id){
		$sql = "SELECT DISTINCT (YETKI_ALANI) 
				FROM M_YETKI_SEKTOR_SORUMLUSU  
				WHERE user_id = ?";
		
		$param = array ($user_id);
		$data = $dbOrc->prep_exec_array($sql, $param);
		
		if (!isset ($data[0]))
			return -1;
		else{
			if (count($data) > 1)
				return 3;
			else
				return $data[0];
		}
	}
	
	function updateAclGroup ($db,$user, $group, $role, $function){
		/*************************************************************************/
		//UPDATE COMMUNITY_ACL GROUP 					
		$sql = "UPDATE #__community_acl_users 
				SET group_id = ".$group.",  role_id = ".$role.",  function_id = ".$function." 
				WHERE user_id = ".$user->id;

		return $db->Execute ($sql);
		/*************************************************************************/
	}
	
	function activateUser ($db, $user_id){
		/*************************************************************************/
		//UPDATE COMMUNITY_ACL GROUP 					
		$sql = "UPDATE #__users 
				SET active = 1	
				WHERE id = ".$user_id;

		return $db->Execute ($sql);
		/*************************************************************************/
	}
	
	function insertAclGroup ($db, $user, $group, $role, $function){
		/*************************************************************************/
		//ADD TO COMMUNITY_ACL GROUP
		$sql = "INSERT INTO #__community_acl_users (user_id, group_id, role_id, function_id) 
				VALUES (".$user->get('id').", ".$group.", ".$role.", ".$function.")";  
		
		return $db->Execute ($sql);
		/*************************************************************************/
	}
	
	function deleteAclGroup ($db, $user, $group){
		/*************************************************************************/
		//DELETE FROM COMMUNITY_ACL GROUP
		$sql = "DELETE FROM #__community_acl_users  
				WHERE  user_id = ".$user->get('id')." AND group_id = ".$group;  
		
		return $db->Execute ($sql);
		/*************************************************************************/
	}
	
	function deleteAllAclGroups ($db, $user){
		$sql = "DELETE FROM #__community_acl_users  
				WHERE  user_id = ".$user->get('id')." 
					   AND group_id NOT IN ( ".T1_GROUP_ID.", ".T2_GROUP_ID." , ".T3_GROUP_ID.", ".T4_GROUP_ID." )";  
		
		return $db->Execute ($sql);
		
	}
	
	
}
?>
