<h1>RavenNuke&trade; - Split Topic Type Mod</h1>
<form action="{S_CONFIG_ACTION}" method="post">
<table width="99%" cellpadding="4" cellspacing="1" border="0" align="center" class="forumline">
	<tr>
		<th class="thHead" colspan="2">{L_ANNOUNCEMENT_SETTINGS}</th>
	</tr>
	<tr>
		<td class="row1">{L_SPLIT_ANNOUNCE}</td>
		<td class="row2"><input type="radio" name="split_announce" value="1" {SPLIT_ANNOUNCE_YES} /> {L_YES}&nbsp;&nbsp;<input type="radio" name="split_announce" value="0" {SPLIT_ANNOUNCE_NO} /> {L_NO}</td>
	</tr>
	<!-- add v 1.0.3 -->
	<!-- BEGIN switch_global_announce -->
	<tr>
		<td class="row1">{L_SPLIT_GLOBAL_ANNOUNCE}</td>
		<td class="row2"><input type="radio" name="split_global_announce" value="1" {SPLIT_GLOBAL_ANNOUNCE_YES} /> {L_YES}&nbsp;&nbsp;<input type="radio" name="split_global_announce" value="0" {SPLIT_GLOBAL_ANNOUNCE_NO} /> {L_NO}</td>
	</tr>
	<!-- END switch_global_announce -->
	<!-- -->
	<tr>
		<td class="row1">{L_SPLIT_STICKY}</td>
		<td class="row2"><input type="radio" name="split_sticky" value="1" {SPLIT_STICKY_YES} /> {L_YES}&nbsp;&nbsp;<input type="radio" name="split_sticky" value="0" {SPLIT_STICKY_NO} /> {L_NO}</td>
	</tr>
	<tr>
		<td class="catBottom" colspan="2" align="center">{S_HIDDEN_FIELDS}<input type="submit" name="submit" value="{L_SUBMIT}" class="mainoption" />&nbsp;&nbsp;<input type="reset" value="{L_RESET}" class="liteoption" />
		</td>
	</tr>
</table>
</form>
<br clear="all" />
