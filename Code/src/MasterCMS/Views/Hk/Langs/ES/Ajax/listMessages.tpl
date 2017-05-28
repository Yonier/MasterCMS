<tr>
	<td>
		<p>Mensaje de <b>{@owner_message}</b> para los Staff <i><b>{@time}</b></i></b>:</p>
		<?php echo $message; ?>
	</td>
	<?php if (in_array($this->users->get('rank'), $this->hotel->getMaster()) || in_array($this->users->get('rank'), $this->hotel->getMaster('medium')) || in_array($this->users->get('rank'), $this->hotel->getMaster('max')) || $owner_message == $this->users->get('username')) { ?>
	<td class="td-actions text-right">
		<button type="button" rel="tooltip" title="Remove" class="btn btn-danger btn-simple btn-xs deleteMessage" id="deleteMessage{@id}" data-delete="{@id}">
			<i class="material-icons">close</i>
		</button>
	</td>
	<?php } ?>
</tr>