<?php if(!defined('OBD_CONTENT')) exit('Access Denied'); ?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo __( 'OBD BigData', 'onexin-bigdata' ); ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!--<link href="https://apps.bdimg.com/libs/bootstrap/2.3.2/css/bootstrap.min.css" rel="stylesheet">-->
<style>
.wrap { max-width: 940px; margin-bottom: 50px; }
input,form { margin-bottom: inherit!important; }
.btn { color: #fff!important; font-size: 1.05em; height: 29px; padding: 2px 18px 3px 18px; margin: 0 0.5em 0 0; background: #3a6ea5; /*border: 1px solid #046190;*/ cursor: pointer; }
.headerMenu .btn { color: #333!important; background: #e0e1e2; }
.pagination { margin:inherit; padding: 1em 0 2em 0; }
.pagination span { color: #333; font-weight: bolder; padding: 3px 5px 2px 5px; margin: 1px; }
.pagination .input-mini {border-radius: none; font-size: 14px; height: 20px; width: 20px; line-height: 20px; overflow:hidden; }
</style>
<!--<script src="https://apps.bdimg.com/libs/jquery/1.8.3/jquery.min.js"></script>-->
</head>

<body>
  <div class="divHeader z"> <?php echo __( 'OBD BigData', 'onexin-bigdata' ); ?> </div>
 
<div class="content-box container-fluid wrap">

    <div class="headerMenu" style="float:right;">
      <a href="<?php echo $baseurl;?>" id="settings-link" class="btn" ><?php echo __( 'OBD', 'onexin-bigdata' ); ?></a>
      <a href="<?php echo $baseurl;?>&amp;op=settings" id="settings-link" class="btn" ><?php echo __( 'OBD Settings', 'onexin-bigdata' ); ?> <span class="caret"></span></a>
      <a href="<?php echo $baseurl;?>&amp;op=readme" id="help-link" class="btn" target="_blank"><?php echo __( 'Help', 'onexin-bigdata' ); ?></a>
      <!--<a href="<?php echo $baseurl;?>&amp;op=logout" id="logout-link" class="btn"><?php echo __( 'Logout', 'onexin-bigdata' ); ?></a>-->
    </div>

    <ul class="nav nav-pills content-box-tabs">
      <li><a <?php if(!isset($_GET['status'])) echo ' class="current"';?> href="<?php echo $baseurl;?>&amp;op=stats"><?php echo __( 'Stats', 'onexin-bigdata' ); ?></a></li>
      <li><a <?php if($_GET['status']=='0') echo ' class="current"';?> href="<?php echo $baseurl;?>"><?php echo __( 'Standby List', 'onexin-bigdata' ); ?></a></li>
      <li><a <?php if($_GET['status']=='1') echo ' class="current"';?> href="<?php echo $baseurl;?>&amp;op=stats&amp;status=1"><?php echo __( 'Posted', 'onexin-bigdata' ); ?></a></li>
      <li><a href="javascript:;" class="btn-mini iconEdit" data-id="0"><?php echo __( 'Add New', 'onexin-bigdata' ); ?></a></li>
    </ul>
    <div class="clear"></div>
    
  <div id="obd-content"><!-- style="min-width:660px; max-width:780px;" -->
    <div class="tablenav top">
      <div class="alignleft actions">
      <form method="get" action="<?php echo $baseurl;?>">
        <input type="hidden" name="page" value="onexin-bigdata.php">
        <input type="hidden" name="op" value="stats">
          <input type="text" name="name" value="<?php echo !empty($_GET['name']) ? bigdata_htmlspecialchars($_GET['name']) : "";?>" placeholder="<?php echo __( 'Enter the search content', 'onexin-bigdata' ); ?>" class="input-large">
          <input type="text" name="status" value="<?php echo !empty($_GET['status']) ? (int)$_GET['status'] : "";?>" size="3" placeholder="<?php echo __( 'Status', 'onexin-bigdata' ); ?>" class="input-mini">
          <span><?php echo __( 'Start date:', 'onexin-bigdata' ); ?></span>
          <input type="text" size="16" name="starttime" class="input-medium" value="<?php echo gmdate('Y-m-d H:i', $starttime)?>">
          -
          <input type="text" size="16" name="endtime" class="input-medium" value="<?php echo gmdate('Y-m-d H:i', $endtime)?>">
          <input type="submit" class="btn" value="<?php echo __( 'Search', 'onexin-bigdata' ); ?>">
      </form>
      </div>
      <?php if($multi) {echo $multi;}?>
    </div>
    <div class="clear"></div>
    
      <div class="xld xlda mtm" id="obd-list">
          <table class="table widefat fixed tags">
            <thead>
              <tr>
                <td width="20"><input type="checkbox" class="vm" id="chkall"></td>
                <th width="60"><?php echo __( 'Status', 'onexin-bigdata' ); ?></th>
                <th><?php echo __( 'Name', 'onexin-bigdata' ); ?></th>
                <th width="160"><?php echo __( 'Catid / Module / Time', 'onexin-bigdata' ); ?></th>
                <th width="60"><?php echo __( 'Options', 'onexin-bigdata' ); ?></th>
              </tr>
            </thead>
            <tbody>
              <?php if(is_array($list)) foreach($list as $value) { ?>
              <tr id="post-<?php echo $value['bid'];?>">
                <td title="<?php echo $value['resid'];?>"><input type="checkbox" name="bidarray[]" value="<?php echo $value['bid'];?>" class="vm"></td>
                <td title="<?php echo $value['resid'];?>"><?php if($value['status']=='1') { ?>
                  <?php echo __( 'Posted', 'onexin-bigdata' ); ?>
                  <?php } elseif($value['status']=='2') { ?>
                  <?php echo __( 'Draft', 'onexin-bigdata' ); ?>
                  <?php } elseif($value['status']=='0') { ?>
                  <?php echo __( 'Standby', 'onexin-bigdata' ); ?>
                  <?php } else { ?>
                  <?php echo __( 'Disable', 'onexin-bigdata' ); ?>
                  <?php } ?></td>
                <td><div style="max-width:500px;">
                    <?php if($value['link']) { ?>
                    (<a href="<?php echo $value['link'][0];?>" target="_blank">View</a>)
                    (<a href="<?php echo $value['link'][1];?>" target="_blank">Edit</a>)
                    <?php } elseif($value['ip']) { ?>
                    (<?php echo $value['ip'];?>)
                    <?php } ?>
                    (<a href="<?php echo $baseurl;?>&amp;op=stats&amp;bid=<?php echo $value['bid'];?>"><?php echo $value['bid'];?></a>) <a href="<?php echo $value['url'];?>" target="_blank">
                    <?php if($value['name']) { ?>
                    <?php echo $value['name'];?><br>
                    <?php } ?>
                    <?php echo $value['url'];?></a></div></td>
                <td><?php echo $value['catid'];?> / <?php echo $value['i'];?><br>
                  <?php echo gmdate('Y-m-d H:i:s', $value['dateline'] + 8 * 3600)?></td>
                <td><a href="javascript:;" title="edit" class="iconEdit" data-id="<?php echo $value['bid'];?>"><?php echo __( 'Edit', 'onexin-bigdata' ); ?></a> <a href="javascript:;" title="delete" class="iconDel" data-id="<?php echo $value['bid'];?>"><?php echo __( 'Delete', 'onexin-bigdata' ); ?></a></td>
              </tr>
              <?php } ?>
              <tr>
                <td><input type="checkbox" class="vm" id="chkall"></td>
                <td colspan="4"><?php echo __( 'Select All', 'onexin-bigdata' ); ?> &nbsp;&nbsp;
                  <a class="btn pull-right" id="bigdatasubmit" data-value="bigdatasubmit"><?php echo __( 'Batch Deletion', 'onexin-bigdata' ); ?></a>
                  &nbsp;&nbsp;
                  <a class="btn" id="bigdatasubmit" data-value="bigdatasubmit3"><?php echo __( 'Batch Disable', 'onexin-bigdata' ); ?></a>
                  &nbsp;&nbsp;
                  <a class="btn" id="bigdatasubmit" data-value="bigdatasubmit0"><?php echo __( 'Batch Standby', 'onexin-bigdata' ); ?></a>
                  &nbsp;&nbsp; </td>
              </tr>
            </tbody>
          </table>
      </div>
    <div class="clear"></div>
      
    <div class="tablenav bottom">
      <?php if($multi) {echo $multi;}?>   
    </div>
      
  </div>
  <!--#obd-content--> 
</div>
<script>
	
$("div #bigdatasubmit").on("click", function() {
	var value = $(this).data("value");
	$.post("<?php echo $baseurl;?>&op=bigdata&"+value, $("#obd-list input").serialize(), function(data) {
		window.location.reload();
	}, "html");
});

$("div .iconEdit").on("click", function() {
	var id = $(this).data("id");	
	$("#edit-" + id).remove();	
	$("#post-" + id).hide();
	var trtd = '<tr id="edit-'+ id +'"><td colspan="5" id="edit-loading-'+ id +'"> loading... </td></tr>';
	if(id > 0){
		$(trtd).insertAfter($("#post-" + id));
	}else{
		$(trtd).insertBefore($("#obd-list tbody>tr:eq(0)"));
	}
	$.get("<?php echo $baseurl;?>&op=manage&bid=" + id, function(data) {
		data = data.split("<!--remove-admin-header-->")[1];
		data = data.split("<!--remove-admin-footer-->")[0];
		$("#edit-loading-"+ id).html(data);
	}, "html");
});

$("div .iconDel").on("click", function() {
	var id = $(this).data("id");
	$.get("<?php echo $baseurl;?>&op=delete&bid="+id, function(data) {
		$("#post-" + id).remove();
	}, "html");
});

$("div #chkall").on("click", function(){
	$("div input[type='checkbox']").prop("checked", (($(this).prop("checked") == true) ? true : false));
});
</script> 

</body>
</html>