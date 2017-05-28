<?php

	if (in_array($this->users->get('rank'), $this->hotel->getMaster('medium+')) && in_array($rank_id, $this->hotel->getMaster('min'))
		||
		in_array($this->users->get('rank'), $this->hotel->getMaster('max')) && in_array($rank_id, $this->hotel->getMaster('medium'))
		||
		in_array($this->users->get('rank'), $this->hotel->getMaster('medium+')) && in_array($rank_id, $this->hotel->getMaster('medium+')) && $this->users->get('rank') > $rank_id
		||
		in_array($this->users->get('rank'), $this->hotel->getMaster('medium+')) && !in_array($rank_id, $this->hotel->getMaster('all'))) {
		$can = true;
	} else {
		$can = false;
	}

?>
<tr>
	<td>{@rank_id}</td>
	<td>{@rank_name}</td>
	<td>{@rank_type}</td>
	<td><div class="color-box" style="background: {@rank_color};"></div></td>
	<td><img src="{@badges_cdn}/{@rank_badge}.gif" title="{@rank_badge}" alt="{@rank_badge}"></td>
	<?php

		if (!$visibility) {
			$this->setParam('visibility', 'Oculto');
		} else {
			$this->setParam('visibility', 'Visible');
		}

	?>
	<td>{@visibility}</td>
	
	<?php 
		if ($can) { 
	?>
	<td class="td-actions text-right">
		<a href="{@url}/hk/web/ranks/{@rank_id}" title="Edit" class="btn btn-success btn-simple btn-xs">
			<i class="material-icons">edit</i>
		</a>
		<button type="button" rel="tooltip" title="Remove" class="btn btn-danger btn-simple btn-xs deleteRank" id="deleteRank{@rank_id}" data-delete="{@rank_id}">
			<i class="material-icons">close</i>
		</button>
	</td>
	<?php } else { ?>
	<td>
		No tienes acceso
	</td>
	<?php } ?>
</tr>