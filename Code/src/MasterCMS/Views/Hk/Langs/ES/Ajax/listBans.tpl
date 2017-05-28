<tr>
	<td>{@bans_id}</td>
	<td>{@bans_value}</td>
	<td>{@bans_reason}</td>
	<td><?php if ($bans_bantype == 'user') { $type = 'Usuario'; } if ($bans_bantype == 'ip') { $type = 'IP'; if ($bans_bantype == 'machine') { $type = 'Maquina'; } } echo $type; ?></td>
	<td>{@users_username}</td>
	<td>{@bans_date}</td>
	<td>{@bans_expire_date}</td>
	<td class="td-actions text-right">	
	<?php if ($this->hotel->getMasterType() == 'min' && $this->hotel->getMasterType($users_rank) == 'medium' || $this->hotel->getMasterType() == 'min' && $this->hotel->getMasterType($users_rank) == 'max' || $this->hotel->getMasterType() == 'medium' && $this->hotel->getMasterType($users_rank) == 'max') { ?>
	Nothing
	<?php } else { ?>
		<button type="button" rel="tooltip" title="Remove" class="btn btn-danger btn-simple btn-xs deleteBan" id="deleteBan{@bans_id}" data-delete="{@bans_id}">
			<i class="material-icons">close</i>
		</button>
	<?php } ?>
	</td>
</tr>