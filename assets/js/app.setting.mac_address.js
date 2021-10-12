$(function(){

	datatable_render({
		"container":"#table-data",
        "model":"setting/mac_address_model",
        "url":"api/common/datatable",
        "columns": [
            {
                "data": "id",
                render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            {
                data: 'code',
			},
			{
                data: 'description',
			},
            {
                data: 'action',
                "orderable": false,
                "className": "text-center"
            },
        ]
    });

});
