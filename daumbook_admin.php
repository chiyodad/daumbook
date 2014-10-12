<div class="wrap">
	<h2>Daumbook Settings</h2>
	<h3>API Key Setting</h3>
	<form method="post" action="options-general.php?page=daumbook.php">
		<table class="form-table">
			<tr valign="top">
				<th scope="row"><label for="daumbook_apikey">Daumbook API Key</label></th>
				<td>
					<input name="daumbook_apikey" type="text" style="width:325px" id="daumbook_apikey" value="<?php echo $daumbook_apikey ?>" />
					<span class="submit"><input name="Submit" class="button-primary" value="Save change" type="submit"></span>
					<p class="description">Please register the daum seach API key</p>
					<a href="http://dna.daum.net/apis/search" target="_blank" class="button button-big">Get daumbook search API Key</a>
				</td>
			</tr>
		</table>
	</form>
	<div>© 2004. Bsidesoft All rights are reserved.</div>
</div>
