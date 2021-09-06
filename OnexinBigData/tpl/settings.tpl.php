<?php if (!defined('OBD_CONTENT')) {
    exit('Access Denied');
} ?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo __('OBD Settings', 'onexin-bigdata'); ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!--<link href="https://apps.bdimg.com/libs/bootstrap/2.3.2/css/bootstrap.min.css" rel="stylesheet">-->
<style>
.wrap { max-width: 940px; }
input,form { margin-bottom: inherit!important; }
.btn { color: #fff!important; font-size: 1.05em; height: 29px; padding: 2px 18px 3px 18px; margin: 0 0.5em 0 0; background: #3a6ea5; /*border: 1px solid #046190;*/ cursor: pointer; }
.headerMenu .btn { color: #333!important; background: #e0e1e2; }
.pagination { margin:inherit; }
.pagination .input-mini {border-radius: none; font-size: 14px; height: 8px; width: 20px; line-height: 10px; overflow:hidden; }
</style>
<!--<script src="https://apps.bdimg.com/libs/jquery/1.8.3/jquery.min.js"></script>-->
</head>

<body>
<!--remove-admin-header-->

<div class="content-box container-fluid wrap">

<div class="headerMenu" style="float:right;">
  <a href="<?php echo $baseurl;?>" id="settings-link" class="btn" ><?php echo __('OBD', 'onexin-bigdata'); ?></a>
  <a href="<?php echo $baseurl;?>&amp;op=settings" id="settings-link" class="btn" ><?php echo __('OBD Settings', 'onexin-bigdata'); ?> <span class="caret"></span></a>
  <a href="<?php echo $baseurl;?>&amp;op=readme" id="help-link" class="btn" target="_blank"><?php echo __('Help', 'onexin-bigdata'); ?></a>
  <!--<a href="<?php echo $baseurl;?>&amp;op=logout" id="logout-link" class="btn"><?php echo __('Logout', 'onexin-bigdata'); ?></a>-->
</div>
  <h2>
    <?php echo __('OBD Settings', 'onexin-bigdata'); ?>
  </h2>
  <form method="post" action="<?php echo $baseurl;?>&op=settings">
    <?php //wp_nonce_field( 'onexin-bigdata_options', 'onexin-bigdata' ); ?>
    <table class="form-table">
      <tr>
        <td valign="top"><strong>
          <?php echo __('OBD Enable', 'onexin-bigdata'); ?>
          </strong></td>
        <td valign="top">
            <input type="radio" name="isopen" value="1"<?php if ($options['isopen'] == '1') {
                echo ' checked';
                                                       } ?>><?php echo __('Yes', 'onexin-bigdata') ?></input>&nbsp;
            <input type="radio" name="isopen" value="0"<?php if ($options['isopen'] == '0') {
                echo ' checked';
                                                       } ?>><?php echo __('No', 'onexin-bigdata') ?></input>
        </td>
      </tr>
      <tr>
        <td valign="top"><strong>
          <?php echo __('Via HTML Style:', 'onexin-bigdata'); ?>
          </strong></td>
        <td valign="top"><textarea cols="50" rows="3" class="large-text code" name="from_style2"><?php echo htmlspecialchars(stripslashes($options['from_style2'])); ?></textarea>
          via: {occsite} &lt;a href=&quot;{occurl}&quot;&gt;{occurl}&lt;/a&gt;</td>
      </tr>
      <tr>
        <td valign="top"><strong>
          <?php echo __('Simulated users:', 'onexin-bigdata'); ?>
          </strong></td>
        <td valign="top"><textarea cols="50" rows="3" class="large-text code" name="portal_users"><?php echo htmlspecialchars(stripslashes($options['portal_users'])); ?></textarea>
          <?php echo __('Multiple | separated', 'onexin-bigdata'); ?></td>
      </tr>
      
      
      <tr>
        <td valign="top"><strong><?php echo __('Title add prefix', 'onexin-bigdata'); ?></strong></td>
        <td valign="top"><input type="text" name="title_prefix" class="regular-text code" size="50" value="<?php echo htmlspecialchars($options['title_prefix']); ?>" />
            <?php echo __('Multiple | separated', 'onexin-bigdata'); ?></td>
      </tr>
      <tr>
        <td valign="top"><strong><?php echo __('Title add suffix', 'onexin-bigdata'); ?></strong></td>
        <td valign="top"><input type="text" name="title_suffix" class="regular-text code" size="50" value="<?php echo htmlspecialchars($options['title_suffix']); ?>" />
            <?php echo __('Multiple | separated', 'onexin-bigdata'); ?></td>
      </tr>
        
      <tr>
        <td valign="top"><strong><?php echo __('Title filter', 'onexin-bigdata'); ?></strong><br /><br /></td>
        <td valign="top"><textarea cols="50" rows="3" class="large-text code" name="filter_title"><?php echo htmlspecialchars(stripslashes($options['filter_title'])); ?></textarea>
            <?php echo __('One per line, between the old words and the new words with lines connecting, e.g.: ', 'onexin-bigdata'); ?><code>oldcar|||newcar</code></td>
      </tr>  
      <tr>
        <td valign="top"><strong><?php echo __('Content filter', 'onexin-bigdata'); ?></strong><br /><br /></td>
        <td valign="top"><textarea cols="50" rows="3" class="large-text code" name="filter_content"><?php echo htmlspecialchars(stripslashes($options['filter_content'])); ?></textarea>
            <?php echo __('One per line, between the old words and the new words with lines connecting, e.g.: ', 'onexin-bigdata'); ?><code>oldcar|||newcar</code></td>
      </tr>
      
      <tr>
        <td valign="top"><strong>
          <?php echo __('Rest Time:', 'onexin-bigdata'); ?>
          </strong></td>
        <td valign="top"><input type="text" name="worktime" class="regular-text code" value="<?php echo trim($options['worktime']); ?>" /></td>
      </tr>
      <tr>
        <td valign="top"><strong>
          <?php echo __('Trigger N/PV:', 'onexin-bigdata'); ?>
          </strong></td>
        <td valign="top"><input type="text" name="perpv" class="regular-text code" value="<?php echo intval($options['perpv']); ?>" /></td>
      </tr>
      <tr>
        <td valign="top"><strong>
          <?php echo __('OID:', 'onexin-bigdata'); ?>
          </strong></td>
        <td valign="top"><input type="text" name="oid" class="regular-text code" value="<?php echo intval($options['oid']); ?>" />
            <?php echo __('Account ID, ONEXIN platform to obtain and maintain consistent: http://we.onexin.com.', 'onexin-bigdata'); ?></td>
      </tr>
      <tr>
        <td valign="top"><strong>
          <?php echo __('Token:', 'onexin-bigdata'); ?>
          </strong></td>
        <td valign="top"><input type="text" name="token" class="regular-text code" value="<?php echo htmlspecialchars(stripslashes($options['token'])); ?>" />
            <?php echo __('Communication TOKEN, ONEXIN platform to obtain and maintain consistent: http://we.onexin.com.', 'onexin-bigdata'); ?></td>
      </tr>
    </table>
    <p class="submit">
      <input type="submit" name="optionssubmit" class="btn btn-success" value="<?php echo __('Save Changes', 'onexin-bigdata', 'onexin-bigdata'); ?>" />
    </p>
  </form>
</div>

<!--remove-admin-footer--> 
  
</body>
</html>
