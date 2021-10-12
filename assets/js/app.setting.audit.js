$(function(){

	datatable_render({
		"container":"#table-data",
        "model":"setting/audit_model",
        "url":"api/common/datatable",
        "columns": [
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
                data: 'created_at',
            },
            {
                data: 'event',
			},
			{
                data: 'url',
			},
			{
                data: 'ip_address',
			},
			{
                data: 'username',
            },
        ]
    });

});
