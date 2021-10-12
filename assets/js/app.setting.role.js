function syncChecked() {
	$('input:checkbox').each(function () {
		let elem_id = $(this).attr("id");
		if (elem_id !== "checked-all") {
			if ($(this).is(":checked")) {
				$(this).parent().removeClass("bg-success").addClass("bg-success");
			} else {
				$(this).parent().removeClass("bg-success");
			}
		}
	});
}


$(function () {

	datatable_render({
		"container": "#table-data",
		"model": "setting/role_model",
		"url": "api/common/datatable",
		"columns": [{
				"data": "id",
				render: function (data, type, row, meta) {
					return meta.row + meta.settings._iDisplayStart + 1;
				}
			},
			{
				data: 'name',
				render: function (data, type, row, meta) {
					return data.toUpperCase();
				}
			},
			{
				data: 'action',
				"orderable": false,
				"className": "text-center"
			},
		]
	});

	$(".route_id").change(function (e) {
		e.preventDefault();
		$(".route_id").each(function () {
			$(this).parent().removeClass("bg-primary");
		});
		$(this).parent().removeClass("bg-primary").addClass("bg-primary");
		return false;
	});

	$("#checked-all").change(function (e) {
		e.preventDefault();
		$('input:checkbox').not(this).not(":disabled").prop('checked', this.checked);
		syncChecked();
		return false;
	});

	$("#checked-view").change(function (e) {
		e.preventDefault();
		$('input:checkbox.view').not(this).prop('checked', this.checked).change();
		syncChecked();
		return false;
	});

	$("#checked-create").change(function (e) {
		e.preventDefault();
		$('input:checkbox.create').not(this).prop('checked', this.checked).change();
		syncChecked();
		return false;
	});

	$("#checked-edit").change(function (e) {
		e.preventDefault();
		$('input:checkbox.edit').not(this).prop('checked', this.checked).change();
		syncChecked();
		return false;
	});

	$("#checked-delete").change(function (e) {
		e.preventDefault();
		$('input:checkbox.delete').not(this).prop('checked', this.checked).change();
		syncChecked();
		return false;
	});

	$("#checked-upload").change(function (e) {
		e.preventDefault();
		$('input:checkbox.upload').not(this).prop('checked', this.checked).change();
		syncChecked();
		return false;
	});

	$("#checked-download").change(function (e) {
		e.preventDefault();
		$('input:checkbox.download').not(this).prop('checked', this.checked).change();
		syncChecked();
		return false;
	});

	$("#checked-approve").change(function (e) {
		e.preventDefault();
		$('input:checkbox.approve').not(this).prop('checked', this.checked).change();
		syncChecked();
		return false;
	});

	$(".checked-header").change(function (e) {
		e.preventDefault();
		var count = $('input:checkbox.checked-header:checked').length;
		if (count < 4) {
			$('input:checkbox.menu').prop('checked', true);
		}
		if (count == 0) {
			$('input:checkbox.menu').prop('checked', false);
			$('#checked-all').prop('checked', false);
		}
		if (count == 4) {
			$('#checked-all').prop('checked', true);
		}
		syncChecked();
		return false;
	});

	$("body").on("change", ".is_parent", function (e) {
		e.preventDefault();
		var parent_id = $(this).attr("data-parent-id");
		$('input:checkbox.is_child[data-parent-id="' + parent_id + '"]').not(this).not(":disabled").prop('checked', this.checked).change();
		$('input:checkbox.permission[data-parent-id="' + parent_id + '"]').not(this).not(":disabled").prop('checked', this.checked).change();
		syncChecked();
	});

	$("body").on("change", ".is_child", function (e) {
		e.preventDefault();
		var menu_id = $(this).val();
		var parent_id = $(this).attr("data-parent-id");

		$('input:checkbox.permission[data-menu-id="' + menu_id + '"]').not(this).not(":disabled").prop('checked', this.checked);
		$('input:checkbox.permission[data-parent-id="' + menu_id + '"]').not(this).not(":disabled").prop('checked', this.checked);

		var checkedParent = $('input:checkbox.is_parent[data-menu-id="' + parent_id + '"]:checked').length;
		var checkedChild = $('input:checkbox.is_child[data-parent-id="' + parent_id + '"]:checked').length;


		if (checkedParent == 0 && checkedChild > 0) {
			$('input:checkbox.is_parent[data-menu-id="' + parent_id + '"]').not(this).not(":disabled").prop('checked', true);
		}

		if (checkedParent > 0 && checkedChild == 0) {
			$('input:checkbox.is_parent[data-menu-id="' + parent_id + '"]').not(this).not(":disabled").prop('checked', false);
		}

		$('input:checkbox.is_child[data-parent-id="' + menu_id + '"]').not(this).not(":disabled").prop('checked', this.checked);
		$('input:checkbox.is_child[data-menu-id="' + parent_id + '"]').not(this).not(":disabled").prop('checked', this.checked);

		$('input:checkbox.permission[data-parent-id="' + menu_id + '"]').not(this).not(":disabled").prop('checked', this.checked);
		$('input:checkbox.permission[data-menu-id="' + parent_id + '"]').not(this).not(":disabled").prop('checked', this.checked);


		syncChecked();

	});

	$("body").on("change", ".permission", function (e) {
		e.preventDefault();
		var menu_id = $(this).attr("data-menu-id");
		var parent_id = $(this).attr("data-parent-id");
		var checked = $(this).is(":checked");

		var actionChecked = $('input:checkbox.permission[data-menu-id="' + menu_id + '"]:checked').length;
		if (actionChecked > 0) {
			$('input:checkbox.is_parent[data-menu-id="' + menu_id + '"]').prop('checked', true);
			$('input:checkbox.is_parent[data-parent-id="' + parent_id + '"]').prop('checked', true);
			$('input:checkbox.is_child[data-menu-id="' + menu_id + '"][data-parent-id="' + parent_id + '"]').prop('checked', true);
		} else {
			$('input:checkbox.is_parent[data-menu-id="' + menu_id + '"][data-parent-id="' + parent_id + '"]').prop('checked', false);
			var checkedMenu = $('input:checkbox.is_child[data-parent-id="' + parent_id + '"]:checked').not(".is_parent").length;
			var permissionChecked = $('input:checkbox.permission[data-menu-id="' + menu_id + '"][data-parent-id="' + parent_id + '"]:checked').length;
			if (permissionChecked == 0) {
				$('input:checkbox.is_child[data-menu-id="' + menu_id + '"][data-parent-id="' + parent_id + '"]').prop('checked', false).change();
			}

		}
		syncChecked();
		return false;
	});

	if ($("#table-show").length > 0) {
		var route_id = $("#route_id").val();
		var permissions = $("#permissions").val();
		var json = JSON.parse(permissions);


		json.forEach(function (row) {

			$("table #menu" + row.route_id).hide();

			if (parseInt(row.can_create) == 1) {
				$('input:checkbox.create[data-menu-id="' + row.route_id + '"]').prop('checked', true).replaceWith("<i class='fa fa-check'></i>&nbsp;");
			}

			if (parseInt(row.can_delete) == 1) {
				$('input:checkbox.delete[data-menu-id="' + row.route_id + '"]').prop('checked', true).replaceWith("<i class='fa fa-check'></i>&nbsp;");
			}

			if (parseInt(row.can_edit) == 1) {
				$('input:checkbox.edit[data-menu-id="' + row.route_id + '"]').prop('checked', true).replaceWith("<i class='fa fa-check'></i>&nbsp;");
			}

			if (parseInt(row.can_view) == 1) {
				$('input:checkbox.view[data-menu-id="' + row.route_id + '"]').prop('checked', true).replaceWith("<i class='fa fa-check'></i>&nbsp;");
			}

			if (parseInt(row.can_upload) == 1) {
				$('input:checkbox.upload[data-menu-id="' + row.route_id + '"]').prop('checked', true).replaceWith("<i class='fa fa-check'></i>&nbsp;");
			}

			if (parseInt(row.can_download) == 1) {
				$('input:checkbox.download[data-menu-id="' + row.route_id + '"]').prop('checked', true).replaceWith("<i class='fa fa-check'></i>&nbsp;");
			}

			if (parseInt(row.can_approve) == 1) {
				$('input:checkbox.approve[data-menu-id="' + row.route_id + '"]').prop('checked', true).replaceWith("<i class='fa fa-check'></i>&nbsp;");
			}

		});

		$('input:radio.route_id[data-id="' + route_id + '"]').prop('checked', true).replaceWith("<i class='fas fa-home'></i>&nbsp;");
		$('input:radio:not(:checked)').replaceWith("<i class='fa fa-circle'></i>&nbsp;");
		$(".checked-header").replaceWith("<i class='fa fa-circle'></i>&nbsp;");
		$("#table-show input:checkbox:not(:checked).permission").replaceWith("<i class='fa fa-ban'></i>&nbsp;");
		$("#table-show input:checkbox:not(:checked).menu").replaceWith("");
		$("#table-show").removeClass("d-none");

	}

	if ($(".is_edit").length > 0) {
		var route_id = $("#route_id_").val();
		var permissions = $("#permissions").val();
		var json = JSON.parse(permissions);
		json.forEach(function (row) {

			$("table #menu" + row.route_id).prop('checked', true);

			if (parseInt(row.can_create) == 1) {
				$('input:checkbox.create[data-menu-id="' + row.route_id + '"]').prop('checked', true);
			}

			if (parseInt(row.can_delete) == 1) {
				$('input:checkbox.delete[data-menu-id="' + row.route_id + '"]').prop('checked', true);
			}

			if (parseInt(row.can_edit) == 1) {
				$('input:checkbox.edit[data-menu-id="' + row.route_id + '"]').prop('checked', true);
			}

			if (parseInt(row.can_view) == 1) {
				$('input:checkbox.view[data-menu-id="' + row.route_id + '"]').prop('checked', true);
			}

			if (parseInt(row.can_upload) == 1) {
				$('input:checkbox.upload[data-menu-id="' + row.route_id + '"]').prop('checked', true);
			}

			if (parseInt(row.can_download) == 1) {
				$('input:checkbox.download[data-menu-id="' + row.route_id + '"]').prop('checked', true);
			}

			if (parseInt(row.can_approve) == 1) {
				$('input:checkbox.approve[data-menu-id="' + row.route_id + '"]').prop('checked', true);
			}


		});
		$('input:radio.route_id[data-id="' + route_id + '"]').prop('checked', true)
		$('input:radio.route_id[data-id="' + route_id + '"]').parent().removeClass("bg-primary").addClass("bg-primary");
		syncChecked();
	}

});
