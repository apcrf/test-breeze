
@extends('_template')

@section('title', 'Blog Posts - form')

@section('content')

	<form id="blogPost" class="row">
		<div class="col-12">
			<div class="row mt-3">
				<label class="col-form-label col-lg-2 text-lg-end">ID:</label>
				<div class="col-6 col-lg-3">
					<input type="number" class="form-control" name="post_id" disabled>
				</div>
			</div>
			<div class="row mt-3">
				<label class="col-form-label col-lg-2 text-lg-end">Title:</label>
				<div class="col-lg-10">
					<input type="text" class="form-control" name="post_title" placeholder="Title">
				</div>
			</div>
			<div class="row mt-3">
				<label class="col-form-label col-lg-2 text-lg-end">Content:</label>
				<div class="col-lg-10">
					<textarea rows="16" class="form-control" name="post_content" placeholder="Content"></textarea>
				</div>
			</div>
			<div class="row mt-3">
				<div class="offset-lg-2 col-lg-10">
					<button id="btnSave" type="button" class="btn btn-primary">Save</button>
					<button id="btnCancel" type="button" class="btn btn-light" onclick="location.href='{{ route('post-list') }}'">Cancel</button>
				</div>
			</div>
		</div>
	</form>

	<br><br><br>

	<script>

		$(document).ready(function() {
			var id = window.location.pathname.split('/').pop();
			if ( id != "0" ) {
				rowLoad(id);
			}
		});

		function rowLoad(id) {
			$.ajax({
				url: "/api/post/" + id,
				success: function(result) {
					console.log(result);
					var value = result;
					var row = $("#blogPost");
					row.find("[name='post_id']").val(value.post_id);
					row.find("[name='post_title']").val(value.post_title);
					row.find("[name='post_content']").val(value.post_content);
				}
			});
		}

		$("#btnSave").click(function() {
			rowSave();
		});

		function rowSave() {
			var row = $("#blogPost");
			var id = row.find("[name='post_id']").val();
			switch (id) {
				case "" :
					var url = "/api/post";
					var type = "POST";
					break;
				default :
					var url = "/api/post/" + id;
					var type = "PUT";
					break;
			}
			$.ajax({
				url: url,
				type: type,
				contentType: "application/json",
				data: JSON.stringify({
					post_title: row.find("[name='post_title']").val(),
					post_content: row.find("[name='post_content']").val(),
				}),
				success: function(result) {
					location.href = "{{ route('post-list') }}";
				}
			});
		}

	</script>

@stop
