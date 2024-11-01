var cny_payee_mail = WPDONATORS.cny_payee_mail;
var paypal_sandbox = WPDONATORS.paypal_sandbox;
var wd_plugindir_url = WPDONATORS.wd_plugindir_url;
var target_value = WPDONATORS.target_value;
var target_value_global = WPDONATORS.target_value_global;


function isMail(mail) { 
    return (new RegExp(/^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/).test(mail)); 
} 

if(isMail(cny_payee_mail) == false) cny_payee_mail = 'ericwzywang@gmail.com';
var $jdonators = jQuery.noConflict(); 
$jdonators(document).ready(function(){
	$jdonators('.sponsor_box').tabs();
	
  $jdonators('#text_link_dialog').dialog({
  	autoOpen: false,
  	bgiframe: true,
  	height: 345,
  	width: 500,
  	modal: true
  });
  $jdonators('#text_dialog_link').click(function(){
  	$jdonators('#text_link_dialog').dialog('open');
    return false;
  });
  $jdonators('#text_link_dialog_global').dialog({
  	autoOpen: false,
  	bgiframe: true,
  	height: 345,
  	width: 500,
  	modal: true
  });
  $jdonators('#text_dialog_link_global').click(function(){
  	$jdonators('#text_link_dialog_global').dialog('open');
    return false;
  });
  
  $jdonators('#target_dialog').dialog({
  	autoOpen: false,
  	bgiframe: true,
  	height: 365,
  	width: 500,
  	modal: true
  });
  $jdonators('#target_link').click(function(){
  	$jdonators('#target_dialog').dialog('open');
    return false;
  });

  $jdonators('#target_dialog_global').dialog({
  	autoOpen: false,
  	bgiframe: true,
  	height: 365,
  	width: 500,
  	modal: true
  });
  $jdonators('#target_link_global').click(function(){
  	$jdonators('#target_dialog_global').dialog('open');
    return false;
  });
  
	$jdonators("#target_progress").progressbar({
		value: target_value
	});
	
	$jdonators("#target_progress_global").progressbar({
		value: target_value_global
	});

	var paypalurl = $jdonators('.sponsor_form').attr("action");
	var paypalmail = $jdonators(".sponsor_form input[name='business']").val();
	var base = $jdonators('.sponsor_form select').val();
	base = base.toLowerCase();
	$jdonators('.sponsor_form .pay_flag').load(wd_plugindir_url+"function.php?info=get_flag&target="+base);
	$jdonators(".sponsor_form select").change(function(){
		var amount = parseFloat($jdonators(this).siblings('.s_currency').html());
		var target = $jdonators(this).val();
//		$jdonators(".sponsor_form select").val(target);
		target= target.toLowerCase();
		$jdonators(this).siblings('.currency').load(wd_plugindir_url+"function.php?info=get_currency&amount="+amount+"&base="+base+"&target="+target);
		$jdonators(this).siblings('.pay_flag').load(wd_plugindir_url+"function.php?info=get_flag&target="+target);	
		if ($jdonators(this).val()=='CNY' && paypal_sandbox == false){
//			$jdonators('.dialog_form').attr("action","https://www.paypal.com.cn/cgi-bin/webscr");
			$jdonators(this).siblings("input[name='business']").val(cny_payee_mail);		
//			alert($jdonators("input[name='business']").val()+'  '+paypal_sandbox);
		}
		if ($jdonators(this).val()!='CNY' && paypal_sandbox == false){
//			$jdonators('.dialog_form').attr("action",paypalurl);
			$jdonators(this).siblings("input[name='business']").val(paypalmail);
//			alert($jdonators("input[name='business']").val()+'  '+paypal_sandbox);
		}
	});
});



