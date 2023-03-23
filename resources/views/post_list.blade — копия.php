
@extends('_template')

@section('title', 'Blog Posts - list')

@section('content')

	<script defer src="/js/app-box.js" type="text/javascript"></script>

	<div id="blogPosts">
		<div id="blogPost_0" class="my-4 d-none">

			<div class="row">
				<h1 class="col-12" name="post_title"></h1>
			</div>

			<div class="row">
				<div class="col-12 col-lg-4" name="post_id"></div>
				<div class="col-12 col-lg-4 text-lg-center" name="created_at"></div>
				<div class="col-12 col-lg-4 text-lg-end my-2 my-lg-0">
					<button type="button" class="btn btn-primary" name="btnEdit">Edit</button>
					<button type="button" class="btn btn-danger" name="btnDel">Del</button>
				</div>
			</div>

			<div class="row">
				<div class="col-12" name="post_content"></div>
			</div>

		</div>
	</div>

	<div class="row">
		<div class="col-12">
			<button id="pgPrev" type="button" class="btn btn-secondary"> <<< Prev </button>
			<label id="pgPage" class="col-form-label text-center px-3">Page</label>
			<button id="pgNext" type="button" class="btn btn-secondary"> Next >>> </button>
		</div>
	</div>

	<br><br><br>

	<script>

		var paginator = { "page": 1, "pages": 0 };

		$(document).ready(function() {
			rowsLoad();
		});

		// paginator Prev
		$("#pgPrev").click(function() {
			paginator.page--;
			if ( paginator.page < 1 ) {
				paginator.page = 1;
			}
			rowsLoad();
		});

		// paginator Next
		$("#pgNext").click(function() {
			paginator.page++;
			if ( paginator.page > paginator.pages ) {
				paginator.page = paginator.pages;
			}
			rowsLoad();
		});

		function rowsLoad() {
			$.ajax({
				url: "/api/posts",
				data: {
					page: paginator.page
				},
				success: function(result) {
					console.log(result);
					// paginator
					paginator.pages = result.last_page;
					$("#pgPage").html("Page: " + paginator.page + " / " + paginator.pages);
					// rows clean & restore 1 row
					var row = $("#blogPost_0").clone();
					var rows = $("#blogPosts").html("");
					$("#blogPosts").append(row);
					// rows create
					$.each(result.data, function(index, value) {
						var row = $("#blogPost_0").clone();
						row.prop("id", "blogPost_" + value.post_id);
						row.removeClass("d-none");
						row.find("[name='post_title']").html(value.post_title);
						row.find("[name='post_id']").html(value.post_id);
						row.find("[name='created_at']").html(value.created_at);
						row.find("[name='post_content']").html(value.post_content);
						row.find("[name='btnEdit']").click(function() {
							location.href = "/post/" + value.post_id;
						});
						row.find("[name='btnDel']").click(function() {
							rowDel(value);
						});
						$("#blogPosts").append(row);
					});
				}
			});
		}

		function rowDel(value) {
			var aBox = new appBox();
			aBox.picture = "Trash";
			aBox.message = "<big>Delete entry ID = " + value.post_id + "?</big><br><small>This action is irreversible.</small>";
			aBox.buttons = ["Trash", "Cancel"];
			aBox.buttonClick = function(name) {
				if (name == "Trash") {
					console.log("Delete ID = " + value.post_id);
					$.ajax({
						url: "/api/post/" + value.post_id,
						type: "DELETE",
						success: function(result) {
							rowsLoad();
						}
					});
				}
			}
			aBox.show();
			// Customization (after .show())
			aBox.elms.footer.style.backgroundColor = "White";
			aBox.elms.picture.style.minWidth = "2.5rem";
			aBox.elms.picture.style.color = "Grey";
		}

	</script>

@stop
