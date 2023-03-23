<x-app-layout>

	<x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
			Blog Posts
        </h2>
    </x-slot>

	<script defer src="/js/app-box.js" type="text/javascript"></script>

	<div id="blogPosts" class="py-3">
		<div id="blogPost_0" class="py-3 hidden">
			<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
				<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg py-6">

					<h1 class="font-semibold text-xl px-6" name="post_title"></h1>

					<div class="px-6 py-3 columns-1 lg:columns-3">
						<div class="text-slate-300" name="post_id"></div>
						<div class="text-slate-300" name="created_at"></div>
						<div class="text-right">
							<button type="button" class="rounded-full text-white bg-blue-400 px-3" name="btnEdit">Edit</button>
							<button type="button" class="rounded-full text-white bg-red-400 px-3 ml-3" name="btnDel">Del</button>
						</div>
					</div>

					<div class="px-6" name="post_content"></div>

				</div>
			</div>
		</div>
	</div>

	<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
		<div class="col-12">
			<button id="pgPrev" type="button" class="rounded-full text-white bg-slate-500 px-3 ml-3"> <<< Prev </button>
			<label id="pgPage" class="rounded-full text-white bg-blue-400 px-3 py-3 ml-3">Page</label>
			<button id="pgNext" type="button" class="rounded-full text-white bg-slate-500 px-3 ml-3"> Next >>> </button>
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
						row.removeClass("hidden");
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
			aBox.elms.buttons.Trash.querySelector("svg").style.display = "inline";
			aBox.elms.buttons.Cancel.querySelector("svg").style.display = "inline";
		}

	</script>

</x-app-layout>
