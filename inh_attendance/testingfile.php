


<form name="callingform">
<!--- <input type="text" id="receivedate" readonly>
<img src="../images/calendaropen.gif" onclick="javascript:document.getElementById('calendarframe').style.display='inline';">
</form>
<iframe id="calendarframe"  style="position:absolute;width:200px;height:200px;display:none" src="calendar.html"></iframe> --->
<input type="text" id="receivedate" name="date1" readonly>
<a href="#" border="0" id="atagclicked" onclick="calobj=this.parentNode.previousSibling;document.getElementById('calendarframe').style.display='inline';clicked='true';"><img id="btnimg" border="0" src="../calendar/calendaropen.gif" style="position:relative"></a>
<iframe align="center" src="calendar.html" id="calendarframe" align="left" marginheight="0" marginwidth="0" scrolling="no"  style="position:absolute;z-index:100;display:none;width:160px;height:200px" frameborder="none"></iframe>

</body>
</html>
