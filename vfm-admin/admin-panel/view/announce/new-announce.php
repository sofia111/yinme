<form role="form" method="post" id ="newAnnounceForm">
	<div class="col-sm-6">
		<textarea name="announce" id="announce" style="width: 100%;height: 150px;" placeholder="100字以内" required></textarea>
	</div>
	<div class="col-sm-6">
	    <button class="btn btn-info btn-lg" data-toggle="modal" data-target="#newshoppanel">发布</button>
	</div>
</form>

<script type="text/javascript">
	$(function (e) {
		$('#newAnnounceForm').submit(function (e) {
			var announce = $('#announce').val();
			$.ajax({
				url:'../vfm-admin/users/announce.php',
				type:'POST',
				data:{
					'announce': announce
				},
				success: function (res) {
					alert("已发布");
				}
			})
			e.preventDefault();
	        return false;
		})
	})
</script>