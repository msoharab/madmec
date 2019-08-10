<?php
//  +------------------------------------------------------------------------+
//  | netjukebox, Copyright © 2001-2016 Willem Bartels                       |
//  |                                                                        |
//  | http://www.netjukebox.nl                                               |
//  | http://forum.netjukebox.nl                                             |
//  |                                                                        |
//  | This program is free software: you can redistribute it and/or modify   |
//  | it under the terms of the GNU General Public License as published by   |
//  | the Free Software Foundation, either version 3 of the License, or      |
//  | (at your option) any later version.                                    |
//  |                                                                        |
//  | This program is distributed in the hope that it will be useful,        |
//  | but WITHOUT ANY WARRANTY; without even the implied warranty of         |
//  | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the          |
//  | GNU General Public License for more details.                           |
//  |                                                                        |
//  | You should have received a copy of the GNU General Public License      |
//  | along with this program.  If not, see <http://www.gnu.org/licenses/>.  |
//  +------------------------------------------------------------------------+




//  +------------------------------------------------------------------------+
//  | footer.inc.php                                                         |
//  +------------------------------------------------------------------------+
//$footer = '<ul id="footer">' . "\n\t";
//$footer .= ($cfg['username'] != '') ? '<li><a href="index.php?authenticate=logout">Logout: ' . html($cfg['username']) . '</a></li><!--' . "\n\t" . '-->' : '';
//$footer .= '<li><a href="about.php">netjukebox ' . html(NJB_VERSION) . '</a></li><!--' . "\n";
//$footer .= "\t" . '--><li><span>Script execution time: ' . executionTime() . '</span></li>' . "\n";
//$footer .= '</ul>' . "\n";
$footer = '<footer style="width:90%; margin-left:5%; margin-right:5%;">
<div class="container">
<div class="pull-right hidden-xs">
<b>Version</b> 1.0.1
</div>
' . "\n\t";
$footer .= '<strong>Copyright © 2014-2015 <a href="http://www.madmec.com">MadMec &copy;</a>.</strong> All rights reserved.
</div><!-- /.container -->
</footer>
' . "\n";
$footer .= '<script type="text/javascript">' . (@$_COOKIE['netjukebox_sid'] ? 'init(); sessionCookie(); window.onbeforeunload = sessionCookie;' : 'init();') . '</script>' . "\n";
$footer .= '<script type="text/javascript" src="javascript-src/jQuery-2.1.4.min.js"></script>' . "\n";
$footer .= '<script type="text/javascript" src="javascript-src/bootstrap.js"></script>' . "\n";
$footer .= '<link rel="stylesheet" type="text/css" href="skin/Clean/bootstrap.css" />' . "\n";
$footer .= '<link rel="stylesheet" type="text/css" href="skin/Clean/AdminLTE2/css/AdminLTE.css" />' . "\n";
$footer .= '<link rel="stylesheet" type="text/css" href="skin/Clean/AdminLTE2/css/skins/skin-blue.min.css" />' . "\n";
$footer .= '<link rel="stylesheet" type="text/css" href="assets/fonts-ionicons-2.0.1/css/ionicons.min.css" />' . "\n";
$footer .= '<link rel="stylesheet" type="text/css" href="assets/font-awesome-4.4.0/css/font-awesome.min.css" />' . "\n";

require_once(NJB_HOME_DIR . 'skin/' . $cfg['skin'] . '/template.footer.php');
exit();

	  