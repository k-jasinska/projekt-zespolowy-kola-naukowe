<?php
	function modal($id, $title, $content){
	?>
	<div class="modal fade" id="<?php echo $id; ?>" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
				<h4 class="modal-title"><?php echo $title; ?></h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
					<?php echo $content; ?>
				</div>
				<div class="modal-footer">
				<button type="button" class="btn btn-outline-danger pinkbtn" data-dismiss="modal">Zamknij</button>
				</div>
			</div>	
		</div>
	</div>
	<script>
		$("#<?php echo $id; ?>").modal('show');
	</script>
	<?php
	}
?>