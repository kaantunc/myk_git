<?php
// no direct access
defined('_JEXEC') or die('Restricted access');

require_once("libraries/joomla/utilities/browser_detection.php");
$user_browser = browser_detection('browser');

$document = &JFactory::getDocument();
//DataTables
$document->addStyleSheet( SITE_URL.'/includes/js/DataTables-1.9.0/media/css/demo_page.css' );
$document->addStyleSheet( SITE_URL.'/includes/js/DataTables-1.9.0/media/css/demo_table.css' );
$document->addStyleSheet( SITE_URL.'/includes/js/DataTables-1.9.0/media/css/validation.css' );
$document->addScript (SITE_URL.'/includes/js/DataTables-1.9.0/examples/examples_support/jquery.jeditable.js');
$document->addScript (SITE_URL.'includes/js/DataTables-1.9.0/media/js/jquery.dataTables.js');
$document->addScript (SITE_URL.'components/com_datatable/assets/datatable.js');
$document->addScript (SITE_URL.'includes/js/DataTables-1.9.0/media/js/validation.js');
//jQueryUI
$document->addScript (SITE_URL.'includes/js/jquery-ui-1.8.18.custom/js/jquery-ui-1.8.18.custom.min.js');
$document->addStyleSheet (SITE_URL.'includes/js/jquery-ui-1.8.18.custom/css/smoothness/jquery-ui-1.8.18.custom.css');

$data = $this->data;
?>
<div id="bilgilendirme" style="width:100%;margin-bottom:5px;color:red;"></div>

<div id="container">
	<p><a id="new" href=""><?php echo JText::_("ADD_ROW_TEXT");?></a></p>

	<div id="demo">
		<form id="form">
			<table cellpadding="0" cellspacing="0" border="0" class="display"
				id="example">
				<thead>
					<tr>
						<th>Column 1</th>
						<th>Column 2</th>
						<th>Column 3</th>
						<th>Column 4</th>
						<th>Column 5</th>
						<th><?php echo JText::_("EDIT_TEXT");?></th>
						<th><?php echo JText::_("DELETE_TEXT");?></th>
					</tr>
				</thead>
				<tbody>
				<?php 				
				foreach ($data as $row){				
					$elm = "<tr id='".$row['ID']."'>";
						
					$elm .= "<td>".$row['COLUMN1']."</td>";
					$elm .= "<td>".$row['COLUMN2']."</td>";
					$elm .= "<td>".$row['COLUMN3']."</td>";
					$elm .= "<td>".$row['COLUMN4']."</td>";
					$elm .= "<td>".$row['COLUMN5']."</td>";
					
					$elm .= "<td><a class='edit' href=''>".JText::_("EDIT_TEXT")."</a></td>";
					$elm .= "<td><a class='delete' href=''>".JText::_("DELETE_TEXT")."</a></td>";
						
					$elm .= "</tr>";
					
					echo $elm;
				}		
				?> 
				</tbody>
			</table>
		</form>
	</div>
</div>

<div id="dialog-confirm" title="<?php echo JText::_("DELETE_CONFIRM_TITLE");?>">
	<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span><?php echo JText::_("DELETE_CONFIRM_TEXT");?></p>
</div>

<script type="text/javascript">
var msg = 'Sayfayı terketmek üzeresiniz. Kaydedilmemiş verileriniz kaybolacak.';

jQuery(window).bind('beforeunload', function(e) {
	// For IE and Firefox prior to version 4
	if (e) {
		e.returnValue = msg;
	}

	// For Safari
	return msg;
}); 

jQuery(document).ready(function() {
	var nEditing = null;
	
	//INIT TABLE
    var oTable = jQuery('#example').dataTable({
		<?php if ($user_browser != "msie7" ) {?>
		//Not Working in IE7
    	"bStateSave": false,
    	<?php }?>
    	"oLanguage": {
			"sLengthMenu": "<?php echo JText::_("LENGTH_MENU");?>",
			"sZeroRecords": "<?php echo JText::_("ZERO_RECORDS");?>",
			"sInfo": "<?php echo JText::_("INFO");?>",
			"sInfoEmpty": "<?php echo JText::_("INFO_EMPTY");?>",
			"sInfoFiltered": "<?php echo JText::_("INFO_FILTERED");?>",
			"sSearch": "<?php echo JText::_("SEARCH");?>",
			"oPaginate": {
				"sFirst":    "<?php echo JText::_("FIRST");?>",
				"sPrevious": "<?php echo JText::_("PREVIOUS");?>",
				"sNext":     "<?php echo JText::_("NEXT");?>",
				"sLast":     "<?php echo JText::_("LAST");?>"
			}
		}
    });

	///////////////////////////////////////////////////////////////////////////////////////
	
    //EDIT ROW
    jQuery('#example a.edit').live('click', function (e) {
        e.preventDefault();
         
        /* Get the row as a parent of the link that was clicked on */
        var nRow = jQuery(this).parents('tr')[0];
         
        if ( nEditing == nRow && this.innerHTML == "<?php echo JText::_("SAVE_TEXT");?>" ) {
            /* This row is being edited and should be saved */
            saveRow( oTable, nEditing, false);
            nEditing = null;
        }
        else {
            /* No row currently being edited */
            editRow( oTable, nRow, false );
            nEditing = nRow;
        }

     	// Stop event handling in IE
        return false;
    } );

	///////////////////////////////////////////////////////////////////////////////////////
	
    //SAVE ROW
    jQuery('#example a.save').live('click', function (e) {
        e.preventDefault();

        if (validate (nEditing)){
        	saveRow( oTable, nEditing, true);
        }

     	// Stop event handling in IE
        return false;
    } );

	///////////////////////////////////////////////////////////////////////////////////////
	
    //NEW ROW
    jQuery('#new').click( function (e) {
        e.preventDefault();
         
        var aiNew = oTable.fnAddData( [ '', //Column1 
                                        '', //Column2
                                        '', //Column3
                                        '', //Column4
                                        '', //Column5
                                        '<a class="edit" href=""><?php echo JText::_("EDIT_TEXT");?></a>', //Guncelle
                                        '<a class="delete" href=""><?php echo JText::_("DELETE_TEXT");?></a>' //Sil
                                        ] );
        var nRow = oTable.fnGetNodes( aiNew[0] );
        editRow( oTable, nRow, true);
        nEditing = nRow;

     	// Stop event handling in IE
        return false;
    } );

	///////////////////////////////////////////////////////////////////////////////////////
	
    //DELETE ROW
    jQuery('#example a.delete').live('click', function (e) {
        e.preventDefault();
        var nRow = jQuery(this).parents('tr')[0];
        var id = nRow.getAttribute('id');

        //Satir yeni eklenmemisse
        if (id != null){
	        jQuery( "#dialog-confirm" ).dialog({
		        buttons: {
					"<?php echo JText::_("DELETE_TEXT");?>": function() {
				        deleteRow( oTable, nRow );
				        jQuery( this ).dialog( "close" );
					},
					"<?php echo JText::_("CANCEL_TEXT");?>": function() {
						jQuery( this ).dialog( "close" );
					}
		        }
			});
	        
	        jQuery( "#dialog-confirm" ).dialog("open");     
        }else{
        	oTable.fnDeleteRow( nRow );
        }

     	// Stop event handling in IE
        return false;
    } );

	///////////////////////////////////////////////////////////////////////////////////////
	
    //CANCEL EDIT
    jQuery('#example a.cancel').live('click', function (e) {
    	e.preventDefault();
        
        var nRow = jQuery(this).parents('tr')[0];
        cancelEdit( oTable, nRow );

     	// Stop event handling in IE
        return false;
    } );

	///////////////////////////////////////////////////////////////////////////////////////

	//DIALOG
	jQuery( "#dialog:ui-dialog" ).dialog( "destroy" );
	
	jQuery( "#dialog-confirm" ).dialog({
		resizable: false,
		modal: true,
		autoOpen: false
	});
} );

function editRow ( oTable, nRow, isSave )
{
    var aData = oTable.fnGetData(nRow);
    var jqTds = jQuery('>td', nRow);
    jqTds[0].innerHTML = '<input class="required" value="'+aData[0]+'" type="text" name="column1">';
    jqTds[1].innerHTML = '<input value="'+aData[1]+'" class="required url" type="text" name="column2">';
    jqTds[2].innerHTML = '<input class="e-mail" value="'+aData[2]+'" type="text" name="column3">';
    jqTds[3].innerHTML = '<input value="'+aData[3]+'" type="text" name="column4">';
    jqTds[4].innerHTML = '<input value="'+aData[4]+'" type="text" name="column5">';

    if (!isSave)
    	jqTds[5].innerHTML = '<a class="edit" href=""><?php echo JText::_("SAVE_TEXT");?></a> <a class="cancel" href=""><?php echo JText::_("CANCEL_TEXT");?></a>';
    else
    	jqTds[5].innerHTML = '<a class="save" href=""><?php echo JText::_("SAVE_TEXT");?></a>';
}

function cancelEdit ( oTable, nRow )
{
    var aData = oTable.fnGetData(nRow);
    var jqTds = jQuery('>td', nRow);
    jqTds[0].innerHTML = aData[0];
    jqTds[1].innerHTML = aData[1];
    jqTds[2].innerHTML = aData[2];
    jqTds[3].innerHTML = aData[3];
    jqTds[4].innerHTML = aData[4];
    jqTds[5].innerHTML = '<a class="edit" href=""><?php echo JText::_("EDIT_TEXT");?></a>';
}

function saveRow ( oTable, nRow, isSave )
{
	var jqInputs = jQuery('input', nRow);
	var sendData = jqInputs.serializeArray();
	var url = 'index.php?option=com_datatable&task=ajaxSaveRow&format=raw';

	if (!isSave){
		url = 'index.php?option=com_datatable&task=ajaxEditRow&format=raw';

		var obj = new Object;
		obj.name= 'id';
		obj.value= nRow.getAttribute('id');

		sendData.push(obj);
	}
			
	jQuery.ajax({
		  url: url,
		  data: sendData,
		  type: "POST",
		  dataType: 'json',
		  success: function(data) {
			  if(data['success']){
				jQuery("#bilgilendirme").html(data['data']);

				if (isSave){
					nRow.setAttribute('id', data['id']);
				}
				
			    oTable.fnUpdate( jqInputs[0].value, nRow, 0, false );
			    oTable.fnUpdate( jqInputs[1].value, nRow, 1, false );
			    oTable.fnUpdate( jqInputs[2].value, nRow, 2, false );
			    oTable.fnUpdate( jqInputs[3].value, nRow, 3, false );
			    oTable.fnUpdate( jqInputs[4].value, nRow, 4, false );
			    oTable.fnUpdate( '<a class="edit" href=""><?php echo JText::_("EDIT_TEXT");?></a>', nRow, 5, false );
			  }else{
			  	jQuery("#bilgilendirme").html(data['data']);
			  }

			  oTable.fnDraw();
		  }
	});
	
}

function deleteRow ( oTable, nRow)
{
	var jqInputs = jQuery('input', nRow);
	var sendData = jqInputs.serializeArray();

	var obj = new Object;
	obj.name= 'id';
	obj.value= nRow.getAttribute('id');

	sendData.push(obj);
			
	jQuery.ajax({
		  url: "index.php?option=com_datatable&task=ajaxDeleteRow&format=raw",
		  data: sendData,
		  type: "POST",
		  dataType: 'json',
		  success: function(data) {
			  if(data['success']){
				jQuery("#bilgilendirme").html(data['data']);
				
				oTable.fnDeleteRow( nRow );
			  }else{
			  	jQuery("#bilgilendirme").html(data['data']);

			  	oTable.fnDraw();
			  }
		  }
	});
	
}
</script>