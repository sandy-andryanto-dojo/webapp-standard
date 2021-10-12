const BASE_URL 		= $('meta[name="base-url"]').attr('content');
const CAN_VIEW 		= parseInt($('meta[name="can_view"]').attr('content')) || 0;
const CAN_EDIT 		= parseInt($('meta[name="can_edit"]').attr('content')) || 0;
const CAN_CREATE 	= parseInt($('meta[name="can_create"]').attr('content')) || 0;
const CAN_DELETE 	= parseInt($('meta[name="can_delete"]').attr('content')) || 0;


function string_to_slug (str) {
    str = str.replace(/^\s+|\s+$/g, ''); // trim
    str = str.toLowerCase();
  
    // remove accents, swap ñ for n, etc
    var from = "àáäâèéëêìíïîòóöôùúüûñç·/_,:;";
    var to   = "aaaaeeeeiiiioooouuuunc------";
    for (var i=0, l=from.length ; i<l ; i++) {
        str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
    }

    str = str.replace(/[^a-z0-9 -]/g, '') // remove invalid chars
        .replace(/\s+/g, '-') // collapse whitespace and replace by -
        .replace(/-+/g, '-'); // collapse dashes

    return str;
}


function datatable_language(){
	var elemenet = {
		"sProcessing": "<i class='fa fa-refresh fa-spin'></i>&nbsp;&nbsp;Sedang memuat data...",
		"sLengthMenu": "Tampilkan _MENU_ entri",
		"sZeroRecords": "Tidak ditemukan data yang sesuai",
		"sInfo": "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
		"sInfoEmpty": "Menampilkan 0 sampai 0 dari 0 entri",
		"sInfoFiltered": "(disaring dari _MAX_ entri keseluruhan)",
		"sInfoPostFix": "",
		"sSearch": "Cari:",
		"sUrl": "",
		"oPaginate": {
			"sFirst": "Pertama",
			"sPrevious": "Sebelumnya",
			"sNext": "Selanjutnya",
			"sLast": "Terakhir"
		}
	};
	return elemenet;
}

function show_toast(option){
	var title = option.title;
    var message = option.message;
    var mode = option.mode;
    if (mode == 'warning') {
        toastr.warning(message, title);
    } else if (mode == 'success') {
        toastr.success(message, title);
    } else if (mode == 'error') {
        toastr.error(message, title);
    } else if (info == 'info') {
        toastr.info(message, title);
    }
}


function datatable_render(option){
	
	var oTable = $(option.container).DataTable({
		'processing': true,
		'serverSide': true,
		'ajax': {
			'url': BASE_URL+""+option.url,
			'type': 'POST',
			"data": function (d) {
				let csrf_name = $('meta[name="csrf-token-name"]').attr('content');
				let csrf_value = $('meta[name="csrf-token-value"]').attr('content');
                let model = btoa(option.model);
				let obj = JSON.parse('{ "' + csrf_name + '":"' + csrf_value + '" , "model" : "' + model + '" }');
				if (option.additional && option.additional.length > 0) {
					option.additional.forEach(function (row) {
						obj[row.key] = row.value;
					});
				}
				return $.extend({}, d, obj);
			}
		},
		'columns': option.columns,
		"order": [option.sort_index || 0, option.sort_key || "DESC"],
		"initComplete": function (settings, json) {
			$(option.container + '_filter input').attr("placeholder", "Tekan Enter").addClass("form-control");
			$(option.container + '_filter input').unbind();
			$(option.container + '_filter input').bind('keyup', function (e) {
				if (e.keyCode == 13) {
					oTable.search(this.value).draw();
				}
			});
		},
		"rowCallback": function(row, data){

			let model = btoa(option.model);
			let href = $(row).find(".btn-action").attr("href");
			let row_id = $(row).find(".btn-action").attr("data-id");
			$(row).find(".btn-action").attr("data-model", model);
			$(row).find(".btn-action").attr("data-url", option.url);
			$(row).find(".btn-detail").attr("href", BASE_URL+""+href+"/detail/"+row_id);
			$(row).find(".btn-delete").attr("href", BASE_URL+""+href+"/delete/"+row_id);
			$(row).find(".btn-edit").attr("href", BASE_URL+""+href+"/edit/"+row_id);

			if(CAN_VIEW !== 1){
				$(row).find(".btn-detail").remove();
			}

			if(CAN_DELETE !== 1){
				$(row).find(".btn-delete").remove();
			}

			if(CAN_EDIT !== 1){
				$(row).find(".btn-edit").remove();
			}

		},
		"language": datatable_language(),
		"autoWidth": false,
      	"responsive": true,
	});

	$("body").on("click", ".btn-delete", function(e){
		
		let url 		= $(this).attr("data-url").replace("datatable", "datatabledelete");
		let id 			= $(this).attr("data-id");
		let model 		= $(this).attr("data-model");
		let csrf_name 	= $('meta[name="csrf-token-name"]').attr('content');
		let csrf_value 	= $('meta[name="csrf-token-value"]').attr('content');

		swal({
			title: "Konfirmasi",
			text: "Apakah anda yaking akan menghapus data ini ?",
			type: "warning",
			html: true,
			showLoaderOnConfirm: true,
			showCancelButton: true,
			confirmButtonClass: "btn-success",
			cancelButtonClass: "btn-warning",
			confirmButtonText: 'Ya',
			cancelButtonText: 'Tidak',
			closeOnConfirm: false,
		},
		function(){
			let obj = JSON.parse('{ "' + csrf_name + '":"' + csrf_value + '" , "model" : "' + model + '", "id" : "'+id+'" }');
			$.post(BASE_URL+""+url, obj, function(result){
				swal.close();
				show_toast({
					"title": "Pesan Berhasil",
					"message": "Berhasil hapus data!",
					"mode": "success"
				});
				$(option.container).DataTable().ajax.reload();
			});
		});

		return false;
	});

}



$(document).ajaxComplete(function() {
	$('[data-toggle="tooltip"]').tooltip();
});



$(function(){


	$('[data-toggle="tooltip"]').tooltip();

	if($(".ckeditor").length){
		$(".ckeditor").each(function(){
			var ckeditor_id = $(this).attr("name");
			CKEDITOR.replace(ckeditor_id);
		});
	}

	$("body").on("click", ".btn-delete-data", function(e){
		let url = $(this).attr("href");
		swal({
			title: "Konfirmasi",
			text: "Apakah anda yaking akan menghapus data ini ?",
			type: "warning",
			html: true,
			showLoaderOnConfirm: true,
			showCancelButton: true,
			confirmButtonClass: "btn-success",
			cancelButtonClass: "btn-warning",
			confirmButtonText: 'Ya',
			cancelButtonText: 'Tidak',
			closeOnConfirm: false,
		},
		function(){
			window.location.href = url;
		});
		return false;
	});

	if ($("#form-submit,.form-submit").length) {
		$("#form-submit,.form-submit").submit(function (e) {
			e.preventDefault();
			let form = this;
			swal({
				title: "Konfirmasi",
				text: "Apakah anda yakin isian form ini sudah benar !",
				type: "warning",
				html: true,
				showLoaderOnConfirm: true,
				showCancelButton: true,
				confirmButtonClass: "btn-success",
				cancelButtonClass: "btn-warning",
				confirmButtonText: 'Ya',
				cancelButtonText: 'Tidak',
				closeOnConfirm: false,
			},
			function(){
				$(form).unbind('submit').submit();
			});
			return false;
		});
	}

	if ($(".select2").length > 0) {
		$(".select2").select2();
	}

	if ($(".input-datepicker").length) {
		$(".input-datepicker").daterangepicker({
			singleDatePicker: true,
			drops: 'top',
			autoApply: true,
			autoUpdateInput: true,
			showDropdowns: true,
			locale: {
				format: 'YYYY-MM-DD',
			}
		});
	}

	if ($(".input-datetimepicker").length) {
		$(".input-datetimepicker").daterangepicker({
			singleDatePicker: true,
			drops: 'top',
			autoApply: true,
			autoUpdateInput: true,
			showDropdowns: true,
			timePicker: true,
			locale: {
				format: 'YYYY-MM-DD hh:mm',
			}
		});
	}

	if ($(".file-input").length) {
		$(".file-input").fileinput({
			showPreview: false,
			showRemove: true,
			showUpload: false,
			showUploadStats: true,
		});
	}

	if ($(".file-input-image").length) {
		if ($(".file-input-image-preview").length) {
			var imageUrl = $(".file-input-image-preview").val();
			$(".file-input-image").fileinput({
				initialPreview: [imageUrl],
				initialPreviewAsData: true,
				showUpload: false,
				allowedFileExtensions: ["jpg", "png", "gif"],
				showRemove: false,
				maxFileCount: 1,
				removeLabel: '',
			});
		} else {
			$(".file-input-image").fileinput({
				showUpload: false,
				showRemove: false,
				allowedFileExtensions: ["jpg", "png", "gif"],
				initialPreviewAsData: true,
				maxFileCount: 1,
			});
		}
	}

	var parent_id = -1;
	$("li.nav-link").each(function(){
		if($(this).hasClass("active")){
			parent_id = $(this).attr("data-parent");
		}
	});

	if(parseInt(parent_id) > 0){
		$("li.treeview[data-id="+parent_id+"]").addClass("active");
	}

	var current_url = window.location.pathname;
	if(current_url === '/account/password' || current_url === '/account/profile'){
		$("#menu-pengguna").addClass("active");
	}

	
	

});
