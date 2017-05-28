<tr>
	<td>{@news_id}</td>
	<td><?php echo $news_title; ?></td>
	<td>{@news_author}</td>
	<td>{@news_published}</td>
	<td class="td-actions text-right">
	<a href="{@url}/web/news/{@news_id}" target="_blank" title="View" class="btn btn-success btn-simple btn-xs">
		<i class="material-icons">remove_red_eye</i>
	</a>	
	<?php if ($this->hotel->getMasterType() == 'min' && $this->hotel->getMasterType($users_rank) == 'medium' || $this->hotel->getMasterType() == 'min' && $this->hotel->getMasterType($users_rank) == 'max' || $this->hotel->getMasterType() == 'medium' && $this->hotel->getMasterType($users_rank) == 'max') { ?>
	
	<?php } else { ?>
		<a href="{@url}/hk/web/news/{@news_id}" title="Edit" class="btn btn-success btn-simple btn-xs">
			<i class="material-icons">edit</i>
		</a>
		<button type="button" rel="tooltip" title="Remove" class="btn btn-danger btn-simple btn-xs deleteNew" id="deleteNew{@news_id}" data-delete="{@news_id}">
			<i class="material-icons">close</i>
		</button>
	<?php } ?>
	</td>
</tr>