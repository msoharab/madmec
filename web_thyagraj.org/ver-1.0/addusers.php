<?php
require_once('include/initialize.inc.php');
$cfg['menu'] = 'config';

$action		= @$_REQUEST['action'];
$user_id	= @$_REQUEST['user_id'];

if		($action == '')						home();

elseif	($action == 'editUser')				editUser($user_id);
elseif	($action == 'updateUser')			{updateUser($user_id);	home();}

else	message(__FILE__, __LINE__, 'error', '[b]Unsupported input value for[/b][br]action');
exit();


//  +------------------------------------------------------------------------+
//  | Edit user                                                              |
//  +------------------------------------------------------------------------+
function editUser($user_id) {
	global $cfg, $db;
	authenticate('access_admin');
	
	if ($user_id == '0') {
		// Add user configuraton
		$user['username']			= 'user_' . sprintf('%04x', mt_rand(0, 0xffff));
		$user['access_media']		= true;
		$user['access_popular']		= false;
		$user['access_favorite']	= false;
		$user['access_cover']		= false;
		$user['access_stream']		= false;
		$user['access_download']	= false;
		$user['access_playlist']	= false;
		$user['access_play']		= false;
		$user['access_add']			= false;
		$user['access_record']		= false;
		$user['access_statistics']	= false;
		$user['access_admin']		= false;
		$user['access_search']		= 255;
		// $txt_menu					= 'Add user';
		$txt_password				= 'Password:';
	}
	else {
		// Edit user configutaion
		$query = mysqli_query($db, 'SELECT
			username,
			access_media,
			access_popular,
			access_favorite,
			access_cover,
			access_stream,
			access_download,
			access_playlist,
			access_play,
			access_add,
			access_record,
			access_statistics,
			access_admin,
			access_search
			FROM user
			WHERE user_id = ' . (int) $user_id);
		$user = mysqli_fetch_assoc($query);
		if ($user == false)
			message(__FILE__, __LINE__, 'error', '[b]Error[/b][br]user_id not found in database');
		
		$txt_password	= 'New password:';
	}
	
	// Navigator
	$nav			= array();
	$nav['name'][]	= 'Configuration';
	$nav['url'][]	= 'config.php';
	$nav['name'][]	= 'Users';
	$nav['url'][]	= 'users.php';
	$nav['name'][]	= $user['username'];
	require_once('include/header.inc.php');
	
	// Store seed temporarily in the session database
	// After acepting a new password copy the seed to the user database
	$session_seed = randomSeed();
	mysqli_query($db, 'UPDATE session
		SET seed	= "' . mysqli_real_escape_string($db, $session_seed) . '"
		WHERE sid	= BINARY "' . mysqli_real_escape_string($db, $cfg['sid']) . '"');
?>
<form id="userform" action="users.php" method="post" autocomplete="off">
	<input type="hidden" name="action" value="updateUser">
	<input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
	<input type="hidden" name="sign" value="<?php echo $cfg['sign']; ?>">
<table class="bottom_space table table-table table-striped">
<tr>
	<td class="space"></td>
	<td>Access</td>
	<td class="space"></td>
</tr>
<tr class="odd" <?php echo accessInfoTitle('media'); ?>>
	<td></td>
	<td><label><input type="checkbox" name="access_media" value="1" class="space"<?php if ($user['access_media']) echo ' checked'; ?>>Media</label></td>
	<td></td>
</tr>
<tr class="even" <?php echo accessInfoTitle('popular'); ?>>
	<td></td>
	<td><label><input type="checkbox" name="access_popular" value="1" class="space"<?php if ($user['access_popular']) echo ' checked'; ?>>Popular</label></td>
	<td></td>
</tr>
<tr class="odd" <?php echo accessInfoTitle('favorite'); ?>>
	<td></td>
	<td><label><input type="checkbox" name="access_favorite" value="1" class="space"<?php if ($user['access_favorite']) echo ' checked'; ?>>Favorite</label></td>
	<td></td>
</tr>
<tr class="even" <?php echo accessInfoTitle('playlist'); ?>>
	<td></td>
	<td><label><input type="checkbox" name="access_playlist" value="1" class="space"<?php if ($user['access_playlist']) echo ' checked'; ?>>Playlist</label></td>
	<td></td>
</tr>
<tr class="odd" <?php echo accessInfoTitle('play'); ?>>
	<td></td>
	<td><label><input type="checkbox" name="access_play" value="1" class="space"<?php if ($user['access_play']) echo ' checked'; ?>>Play</label></td>
	<td></td>
</tr>
<tr class="even" <?php echo accessInfoTitle('add'); ?>>
	<td></td>
	<td><label><input type="checkbox" name="access_add" value="1" class="space"<?php if ($user['access_add']) echo ' checked'; ?>>Add</label></td>
	<td></td>
</tr>
<tr class="odd" <?php echo accessInfoTitle('stream'); ?>>
	<td></td>
	<td><label><input type="checkbox" name="access_stream" value="1" class="space"<?php if ($user['access_stream']) echo ' checked'; ?>>Stream</label></td>
	<td></td>
</tr>
<tr class="even" <?php echo accessInfoTitle('download'); ?>>
	<td></td>
	<td><label><input type="checkbox" name="access_download" value="1" class="space"<?php if ($user['access_download']) echo ' checked'; ?>>Download</label></td>
	<td></td>
</tr>
<tr class="odd" <?php echo accessInfoTitle('cover'); ?>>
	<td></td>
	<td><label><input type="checkbox" name="access_cover" value="1" class="space"<?php if ($user['access_cover']) echo ' checked'; ?>>Cover</label></td>
	<td></td>
</tr>
<tr class="even" <?php echo accessInfoTitle('record'); ?>>
	<td></td>
	<td><label><input type="checkbox" name="access_record" value="1" class="space"<?php if ($user['access_record']) echo ' checked'; ?>>Record</label></td>
	<td></td>
</tr>
<tr class="odd" <?php echo accessInfoTitle('statistics'); ?>>
	<td></td>
	<td><label><input type="checkbox" name="access_statistics" value="1" class="space"<?php if ($user['access_statistics']) echo ' checked'; ?>>Statistics</label></td>
	<td></td>
</tr>
<tr class="even" <?php echo accessInfoTitle('admin'); ?>>
	<td></td>
	<td><label><input type="checkbox" name="access_admin" value="1" class="space"<?php if ($user['access_admin']) echo ' checked'; ?>>Admin</label></td>
	<td></td>
</tr>
<tr>
	<td class="space"></td>
	<td>Internet search</td>
	<td class="space"></td>
</tr>
<?php
	for ($i = 0; $i < count($cfg['search_name']); $i++) {
?>
<tr class="<?php echo ($i & 1) ? 'even' : 'odd'; ?>">
	<td></td>
	<td><label><input type="checkbox" name="access_search[]" value="<?php echo pow(2,$i); ?>" class="space"<?php if (pow(2,$i) & $user['access_search']) echo ' checked'; ?>><?php echo html($cfg['search_name'][$i]); ?></label></td>
	<td></td>
</tr>
<?php
	}
?>	
<tr class="footer">
	<td></td>
	<td>Username:</td>
	<td></td>
</tr>
<tr class="footer">
	<td></td>
	<td><input type="text" class="form-control" name="new_username" value="<?php echo html($user['username']); ?>" maxlength="255" <?php echo ($user['username'] == $cfg['anonymous_user']) ? 'readonly class="short readonly" onfocus="this.blur();"' : 'class="short"'; ?>></td>
	<td></td>
</tr>
<tr class="footer">
	<td></td>
	<td><?php echo $txt_password; ?></td>
	<td></td>
</tr>
<tr class="footer">
	<td></td>
	<td><input type="password" class="form-control" name="new_password" <?php echo ($user['username'] == $cfg['anonymous_user']) ? 'readonly class="short readonly" onfocus="this.blur();"' : 'class="short"'; ?>></td>
	<td></td>
</tr>
<tr class="footer">
	<td></td>
	<td>Confirm password:</td>
	<td></td>
</tr>
<tr class="footer">
	<td></td>
	<td><input type="password" class="form-control" name="chk_password" <?php echo ($user['username'] == $cfg['anonymous_user']) ? 'readonly class="short readonly" onfocus="this.blur();"' : 'class="short"'; ?>></td>
	<td></td>
</tr>
<tr class="footer"><td colspan="3"></td></tr>
</table>
<a href="javascript:hashPassword();" class="button space">save</a><!--
--><a href="users.php" class="button">cancel</a>
</form>


<script type="text/javascript">
function hashPassword()	{
	userform.new_username.className = 'short readonly';
	userform.new_password.className = 'short readonly';
	userform.chk_password.className = 'short readonly';
	userform.new_password.value = hmacsha1(hmacsha1(userform.new_password.value, '<?php echo $session_seed; ?>'), '<?php echo $session_seed; ?>');
	userform.chk_password.value = hmacsha1(hmacsha1(userform.chk_password.value, '<?php echo $session_seed; ?>'), '<?php echo $session_seed; ?>');
	userform.submit();
}
</script>
<?php
	require_once('include/footer.inc.php');
}




//  +------------------------------------------------------------------------+
//  | Update user                                                            |
//  +------------------------------------------------------------------------+
function updateUser($user_id) {
	global $cfg, $db;
	authenticate('access_admin', false, true, true);
	
	$new_username		= @$_POST['new_username'];
	$new_password		= @$_POST['new_password'];
	$chk_password		= @$_POST['chk_password'];
	$access_media		= @$_POST['access_media']		? 1 : 0;
	$access_popular		= @$_POST['access_popular']		? 1 : 0;
	$access_favorite	= @$_POST['access_favorite']	? 1 : 0;
	$access_playlist	= @$_POST['access_playlist']	? 1 : 0;
	$access_play		= @$_POST['access_play']		? 1 : 0;
	$access_add			= @$_POST['access_add']			? 1 : 0;
	$access_stream		= @$_POST['access_stream']		? 1 : 0;
	$access_download	= @$_POST['access_download']	? 1 : 0;
	$access_cover		= @$_POST['access_cover']		? 1 : 0;
	$access_record		= @$_POST['access_record']		? 1 : 0;
	$access_statistics	= @$_POST['access_statistics']	? 1 : 0;
	$access_admin		= @$_POST['access_admin']		? 1 : 0;
	$access_search_array= @$_POST['access_search'];

	$access_search = 0;
	
	for ($i = 0; $i < count($access_search_array) && $i < 7; $i++)
		$access_search += (int) $access_search_array[$i];
	
	$query = mysqli_query($db, 'SELECT user_id FROM user WHERE user_id = ' . (int) $user_id);
	if (mysqli_fetch_row($query) == false && $user_id != '0')
		message(__FILE__, __LINE__, 'error', '[b]Error[/b][br]user_id not found in database');
	
	$query = mysqli_query($db, 'SELECT user_id FROM user WHERE user_id != ' . (int) $user_id . ' AND username = "' . mysqli_real_escape_string($db, $new_username) . '"');
	if (mysqli_fetch_row($query))
		message(__FILE__, __LINE__, 'warning', '[b]Username already exist[/b][br]Choose another username[br][url=users.php?action=editUser&user_id='. rawurlencode($user_id) . '][img]small_back.png[/img]Back to previous page[/url]');
	
	
	if ($new_password == hmacsha1(hmacsha1('', $cfg['session_seed']), $cfg['session_seed']))	$password_set = false;
	else																						$password_set = true;
	
	if (preg_match('#^[0-9a-f]{40}$#', $new_password) == false)							message(__FILE__, __LINE__, 'error', '[b]Password error[/b][br]This is not a valid hash');
	if ($new_password != $chk_password) 												message(__FILE__, __LINE__, 'warning', '[b]Passwords are not identical[/b][br][url=users.php?action=editUser&user_id='. rawurlencode($user_id) .'][img]small_back.png[/img]Back to previous page[/url]');
	if (!$password_set && $user_id == '0' && $new_username != $cfg['anonymous_user'])	message(__FILE__, __LINE__, 'warning', '[b]Password must be set for a new user[/b][br][url=users.php?action=editUser&user_id=0][img]small_back.png[/img]Back to previous page[/url]');
	if ($new_username == '') 															message(__FILE__, __LINE__, 'warning', '[b]Username must be set[/b][br][url=users.php?action=editUser&user_id='. rawurlencode($user_id) .'][img]small_back.png[/img]Back to previous page[/url]');
	if ($access_admin == false) {
		if (checkAdminAcount($user_id) == false)
				message(__FILE__, __LINE__, 'warning', '[b]There must be at least one user with admin privilege[/b][br][url=users.php?action=editUser&user_id='. rawurlencode($user_id) .'][img]small_back.png[/img]Back to previous page[/url]');
	}
	
	if (($password_set || $user_id == '0') && $new_username == $cfg['anonymous_user']) {
		$new_password = hmacsha1(hmacsha1($cfg['anonymous_user'], $cfg['session_seed']), $cfg['session_seed']);
		$password_set = true;
	}
	
	if ($user_id == '0') {
		mysqli_query($db, 'INSERT INTO user (username) VALUES ("")');
		$user_id = mysqli_insert_id($db);
	}
	
	if ($password_set) {
		mysqli_query($db, 'UPDATE user SET
			username			= "' . mysqli_real_escape_string($db, $new_username) . '",
			password			= "' . mysqli_real_escape_string($db, $new_password) . '",
			seed				= "' . mysqli_real_escape_string($db, $cfg['session_seed']) . '",
			access_media		= ' . (int) $access_media . ',
			access_popular		= ' . (int) $access_popular . ',
			access_favorite 	= ' . (int) $access_favorite . ',
			access_playlist		= ' . (int) $access_playlist . ',
			access_play			= ' . (int) $access_play . ',
			access_add			= ' . (int) $access_add . ',
			access_stream		= ' . (int) $access_stream . ',
			access_download 	= ' . (int) $access_download . ',
			access_cover		= ' . (int) $access_cover . ',
			access_record		= ' . (int) $access_record . ',
			access_statistics	= ' . (int) $access_statistics . ',
			access_admin		= ' . (int) $access_admin . ',
			access_search		= ' . (int) $access_search . '
			WHERE user_id		= ' . (int) $user_id);
		
		mysqli_query($db, 'UPDATE session
			SET logged_in	= 0
			WHERE user_id	= ' . (int) $user_id);
	}
	else {
		mysqli_query($db, 'UPDATE user SET
			username			= "' . mysqli_real_escape_string($db, $new_username) . '",
			access_media		= ' . (int) $access_media . ',
			access_popular		= ' . (int) $access_popular . ',
			access_favorite		= ' . (int) $access_favorite . ',
			access_playlist		= ' . (int) $access_playlist . ',
			access_play			= ' . (int) $access_play . ',
			access_add			= ' . (int) $access_add . ',
			access_stream		= ' . (int) $access_stream . ',
			access_download 	= ' . (int) $access_download . ',
			access_cover		= ' . (int) $access_cover . ',
			access_record		= ' . (int) $access_record . ',
			access_statistics	= ' . (int) $access_statistics . ',
			access_admin		= ' . (int) $access_admin . ',
			access_search		= ' . (int) $access_search . '
			WHERE user_id		= ' . (int) $user_id);
	}
}

?>
