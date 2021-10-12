function load_routes(role_id, selected){
	var roles 		= role_id.join();
	let csrf_name 	= $('meta[name="csrf-token-name"]').attr('content');
	let csrf_value 	= $('meta[name="csrf-token-value"]').attr('content');
	let obj 		= JSON.parse('{ "' + csrf_name + '":"' + csrf_value + '" , "roles" : "'+roles+'" }');
	$.post(BASE_URL+"api/common/userroutes	", obj, function(result){
		if(result.length > 0){
			var elem = '';
			result.forEach(function(row){
				var str_selected = parseInt(row.id) === parseInt(selected) ? 'selected' : '';
				elem += `<option `+str_selected+` value='`+row.id+`'>`+row.name+`</option>`;
			});
			$("#default_route_id").html(elem);
		}
	});
}

$(function(){

	datatable_render({
		"container":"#table-data",
        "model":"setting/user_model",
        "url":"api/common/datatable",
        "columns": [
            {
                "data": "id",
                render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
			{
                data: 'image',
				render: function (data, type, row, meta) {
					if(data !== null){
						return `<img src="`+BASE_URL+`/`+data+`" width="85" class="img-responsive img-thumbnail">`;
					}else{
						if(parseInt(row.gender) === 1){
							return `<img src="`+BASE_URL+`/assets/img/male.png" width="85" class="img-responsive img-thumbnail">`;
						}else if(parseInt(row.gender) === 2){
							return `<img src="`+BASE_URL+`/assets/img/female.png" width="85" class="img-responsive img-thumbnail">`;
						}else{
							return `<img src="`+BASE_URL+`/assets/img/user.png" width="85" class="img-responsive img-thumbnail">`;
						}
					}
                }
            },
            {
                data: 'username',
            },
            {
                data: 'email',
			},
			{
                data: 'phone',
			},
			{
				data: 'groups',
            },
            {
                data: 'action',
                "orderable": false,
                "className": "text-center"
            },
        ]
	});
	
	if($("#default_route_id").length){
		$("#roles").change(function(e){
			e.preventDefault();
			if($(this).val()){
				var role_id = $(this).val();
				load_routes(role_id);
			}
			return false;
		});
	}

	if($("#selected_route_id").length){
		var role_id = $("#roles").val();
		var selected_route_id = $("#selected_route_id").val();
		load_routes(role_id, selected_route_id);
	}

});
