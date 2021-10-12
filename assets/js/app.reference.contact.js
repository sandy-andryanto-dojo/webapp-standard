$(function(){

	datatable_render({
		"container":"#table-data",
        "model":"reference/contact_model",
        "url":"api/common/datatable",
        "columns": [
            {
                "data": "id",
                render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            {
                data: 'name',
			},
			{
                data: 'phone',
			},
			{
                data: 'email',
			},
            {
                data: 'action',
                "orderable": false,
                "className": "text-center"
            },
        ]
    });

});
