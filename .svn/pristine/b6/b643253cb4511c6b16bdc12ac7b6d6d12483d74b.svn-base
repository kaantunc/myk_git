<?php 
$finans_bilgi = $this->finans_bilgi;
?>

<div>
	<table id="finans_listesi">
		<thead>
			<tr>
				<th>Dekont</th>
				<th>Masraf</th>
				<th>Tür</th>
				<th>Tarih</th>
				<th>Süre</th>
			</tr>
		</thead>
		<tbody>
		<?php
		foreach ($finans_bilgi as $row){
			echo '<tr>';
			echo '<td>'.$row['DEKONT'].'</td>';
			echo '<td>'.$row['MASRAF'].'</td>';
			echo '<td>'.$row['TUR'].'</td>';
			echo '<td>'.$row['TARIH'].'</td>';
			echo '<td>'.$row['SURE'].'</td>';
			echo '</tr>';
		}
		?>
		</tbody>
	</table>
</div>

<script type="text/javascript">
jQuery(document).ready(function() {
	var oTable = jQuery('#finans_listesi').dataTable({
		"iDisplayLength": 50,
        "aoColumns" : [null,
                        null,
                        null,
                        null,
                        {sClass: "ortala"}],
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
});
</script>