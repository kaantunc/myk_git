<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
class HTML_kexport
{

	function showFiles( $option,$lists ){
?>
	
    <form action="index.php" method="post" name="form" id="form" enctype="multipart/form-data">
      <fieldset>
        <table>
        <tr>  
          <td>
          	<?php echo $lists['id']; ?>
          </td>
          <td>
          	<input type="submit" value="<?php echo JText::_('Download'); ?>" />
          </td>
        </tr>
		</table>
	</fieldset>
      <input type="hidden" name="option" value="<?php echo $option;?>" />
      <input type="hidden" name="task" value="download" />
	</form>
<?php
	}
}
?>