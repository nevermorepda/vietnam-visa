<div class="cluster">
	<div class="container-fluid">
		<div class="tool-bar clearfix">
			<h1 class="page-title">
				Q&A
				<div class="pull-right">
					<ul class="action-icon-list">
						<li><a href="#" class="btn-unpublish"><i class="fa fa-eye-slash" aria-hidden="true"></i> Hide</a></li>
						<li><a href="#" class="btn-publish"><i class="fa fa-eye" aria-hidden="true"></i> Show</a></li>
						<li><a href="#" class="btn-delete"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</a></li>
					</ul>
				</div>
			</h1>
		</div>
		<? if (empty($items) || !sizeof($items)) { ?>
		<p class="help-block">No item found.</p>
		<? } else { ?>
		<form id="frm-admin" name="adminForm" action="" method="POST">
			<input type="hidden" id="task" name="task" value="">
			<input type="hidden" id="boxchecked" name="boxchecked" value="0" />
			<table class="table table-bordered">
				<tr>
					<th class="text-center" width="30px">#</th>
					<th class="text-center" width="30px">
						<input type="checkbox" id="toggle" name="toggle" onclick="checkAll('<?=sizeof($items)?>');" />
					</th>
					<th width="200">Author</th>
					<th>Question</th>
				</tr>
				<?
					$i = 0;
					$q = 0;
					foreach ($items as $item) {
						$answer_info = new stdClass();
						$answer_info->parent_id = $item->id;
						$answers = $this->m_question->items($answer_info);
				?>
				<tr class="row<?=$item->active?>">
					<td class="text-center">
						<?=($q + 1) + (($page - 1) * ADMIN_ROW_PER_PAGE)?>
					</td>
					<td class="text-center">
						<input type="checkbox" id="cb<?=$i?>" name="cid[]" value="<?=$item->id?>" onclick="isChecked(this.checked);">
					</td>
					<td>
						<div class="media">
							<div class="media-left">
								<img class="media-object" src="<?=IMG_URL?>no-avatar.gif" width="40px">
							</div>
							<div class="media-body">
								<h5 class="media-heading"><?=$item->author?></h5>
								<p class="help-block"><?=$item->nationality?></p>
							</div>
						</div>
					</td>
					<td>
						<h5><a href="<?=site_url("syslog/questions/edit/{$item->id}")?>"><?=$item->title?></a></h5>
						<p class="help-block"><?=date("Y-m-d H:i:s", strtotime($item->created_date))?></p>
						<?=$item->content?>
						<ul class="action-icon-list">
							<li><?=number_format($item->view_num)?> Views</li>
							<li><a href="<?=site_url("syslog/questions/edit/{$item->id}")?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</a></li>
							<li><a href="<?=site_url("syslog/questions/answer/{$item->id}")?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Answer</a></li>
							<li><a href="#" onclick="return confirmBox('Delete items', 'Are you sure you want to delete the selected items?', 'itemTask', ['cb<?=$i?>', 'delete']);"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</a></li>
							<? if ($item->active) { ?>
							<li><a href="#" onclick="return itemTask('cb<?=$i?>','unpublish');"><i class="fa fa-eye-slash" aria-hidden="true"></i> Hide</a></li>
							<? } else { ?>
							<li><a href="#" onclick="return itemTask('cb<?=$i?>','publish');"><i class="fa fa-eye" aria-hidden="true"></i> Show</a></li>
							<? } ?>
							<li><a href="#" onclick="return itemTask('cb<?=$i?>','orderup');"><i class="fa fa-level-up" aria-hidden="true"></i> Up</a></li>
							<li><a href="#" onclick="return itemTask('cb<?=$i?>','orderdown');"><i class="fa fa-level-down" aria-hidden="true"></i> Down</a></li>
						</ul>
					</td>
				</tr>
				<?
						$i++;
						$q++;
						if (!empty($answers)) {
							foreach ($answers as $answer) {
				?>
				<tr class="row<?=$answer->active?>">
					<td class="text-center"></td>
					<td class="text-center">
						<input type="checkbox" id="cb<?=$i?>" name="cid[]" value="<?=$answer->id?>" onclick="isChecked(this.checked);">
					</td>
					<td></td>
					<td>
						<div class="row">
							<div class="col-sm-1 col-xs-2" style="width: 40px; margin-right: 20px;">
								<? if ($answer->email == MAIL_INFO) { ?>
								<img class="media-object" src="<?=IMG_URL?>support.png" width="40px">
								<? } else { ?>
								<img class="media-object" src="<?=IMG_URL?>no-avatar.gif" width="40px">
								<? } ?>
							</div>
							<div class="col-sm-11 col-xs-10">
								<h5><?=$answer->author?></h5>
								<p class="help-block"><?=date("Y-m-d H:i:s", strtotime($answer->created_date))?></p>
								<?=$answer->content?>
								<ul class="action-icon-list">
									<li><a href="<?=site_url("syslog/questions/edit/{$answer->id}")?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</a></li>
									<li><a href="<?=site_url("syslog/questions/answer/{$item->id}")?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Answer</a></li>
									<li><a href="#" onclick="return confirmBox('Delete items', 'Are you sure you want to delete the selected items?', 'itemTask', ['cb<?=$i?>', 'delete']);"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</a></li>
									<? if ($answer->active) { ?>
									<li><a href="#" onclick="return itemTask('cb<?=$i?>','unpublish');"><i class="fa fa-eye-slash" aria-hidden="true"></i> Hide</a></li>
									<? } else { ?>
									<li><a href="#" onclick="return itemTask('cb<?=$i?>','publish');"><i class="fa fa-eye" aria-hidden="true"></i> Show</a></li>
									<? } ?>
								</ul>
							</div>
						</div>
					</td>
				</tr>
				<?
								$i++;
							}
						}
					}
				?>
			</table>
			<div><?=$pagination?></div>
		</form>
		<? } ?>
	</div>
</div>

<script>
$(document).ready(function() {
	$(".btn-publish").click(function(e){
		e.preventDefault();
		if ($("#boxchecked").val() == 0) {
			messageBox("ERROR", "Error", "Please make a selection from the list to publish.");
		}
		else {
			submitButton("publish");
		}
	});
	$(".btn-unpublish").click(function(e){
		e.preventDefault();
		if ($("#boxchecked").val() == 0) {
			messageBox("ERROR", "Error", "Please make a selection from the list to unpublish.");
		}
		else {
			submitButton("unpublish");
		}
	});
	$(".btn-delete").click(function(e){
		e.preventDefault();
		if ($("#boxchecked").val() == 0) {
			messageBox("ERROR", "Error", "Please make a selection from the list to delete.");
		}
		else {
			confirmBox("Delete items", "Are you sure you want to delete the selected items?", "submitButton", "delete");
		}
	});
});
</script>