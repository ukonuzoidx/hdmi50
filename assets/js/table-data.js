$(function (e) {
    
	$("#example1").DataTable({
		// responsive: true,
        'aoColumnDefs': [{
        'bSortable': false,
        'aTargets': ['nosort']
    }],
        // language: {
        //     searchPlaceholder: "Search...",
        //     sSearch: "",
        //     lengthMenu: "_MENU_",
        // },
    });
});
