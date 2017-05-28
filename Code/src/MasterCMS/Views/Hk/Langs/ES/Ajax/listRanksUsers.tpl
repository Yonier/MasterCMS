<?php 

	if (in_array($this->users->get('rank'), $this->hotel->getMaster('medium+')) && in_array($staff_rank_id, $this->hotel->getMaster('min'))
		||
		in_array($this->users->get('rank'), $this->hotel->getMaster('max')) && in_array($staff_rank_id, $this->hotel->getMaster('medium'))
		||
		in_array($this->users->get('rank'), $this->hotel->getMaster('medium+')) && in_array($staff_rank_id, $this->hotel->getMaster('medium+')) && $this->users->get('rank') > $staff_rank_id
		||
		in_array($this->users->get('rank'), $this->hotel->getMaster('medium+')) && !in_array($staff_rank_id, $this->hotel->getMaster('all'))) {
		$can = true;
	} else {
		$can = false;
	}

?>
<tr>
	<td>{@staff_id}</td>
	<td>{@staff_username}</td>
	<td>{@staff_rank}</td>
	<?php

	if ($staff_occult) {
		$this->setParam('occult', 'Oculto');
	} else {
		$this->setParam('occult', 'Visible');
	}

	?>
	<td>{@occult}</td>
	<td><img src="{@hk_cdn}/img/flags/{@staff_country}.png" style="width: auto;"></td>
	<td><img src="{@hk_cdn}/img/{@staff_status}.gif" style="width: auto;"></td>
	
	<?php if ($can) {  ?>
	<td>{@staff_ip_last}</td>
	<td class="td-actions text-right">
		<a href="{@url}/hk/web/users/{@staff_id}" title="Edit" class="btn btn-success btn-simple btn-xs"">
			<i class="material-icons">edit</i>
		</a>
		<button type="button" rel="tooltip" title="Remove" class="btn btn-danger btn-simple btn-xs deleteRankUser" id="deleteRankUser{@staff_id}" data-delete="{@staff_id}">
			<i class="material-icons">close</i>
		</button>
	</td>
	<?php } else { ?>
	<td>
		No tienes acceso
	</td>
	<td>
		No tienes acceso
	</td>
	<?php } ?>
</tr>