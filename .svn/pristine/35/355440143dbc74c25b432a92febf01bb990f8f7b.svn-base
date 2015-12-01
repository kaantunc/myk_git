function hepsiniSec( flag )
{
    if (flag == 0)
    {
        jQuery(".soruId").removeAttr('checked');
    }
    else
    {
        jQuery(".soruId").removeAttr('checked');
        jQuery(".soruId").attr('checked', 'checked');
    }
}


function secilenleriSil(){
	if(confirm ("Seçilenleri SİLMEK istediğinize emin misiniz?")){
		var url = 'index.php?option=com_itembank&task=secilenleriSil&format=raw';
		var veriler=jQuery(".soruId").serialize();
		jQuery.post(
	        url,
	        veriler, 
	        function(data) {
	            	jQuery(".soruId").filter(":checked").each(function(e){            		
	            		jQuery(this).parent().parent().remove();
	            	});
	            	alert (data);
	    	}
		);
	}
}
function durumDegistir(){
	var url = 'index.php?option=com_itembank&task=durumDegistir&format=raw';
	if(confirm ("Seçilenlerin DURUMUNU DEĞİŞTİRMEK istediğinize emin misiniz?")){
		var idler=jQuery(".soruId").serialize();
		var durum=jQuery("#yeni_durum_id").serialize();
		jQuery.post(
	        url,
	        idler+"&"+durum, 
	        function(data) {
	            	ara ();
	    	}
		);
	}
}