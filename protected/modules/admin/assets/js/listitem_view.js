
$(document).ready(function() {
	$('.f-iframe').fancybox({
		maxWidth	: 1000,
		fitToView	: false,
		width		: '90%',
		height		: '90%',
		autoSize	: false,
		nextClick	: false,
		arrows		: false
	});

    if ( '#menu-grid' )
        sortGrid('menu');
});


function fixHelper(e, ui) {
    ui.children().each(function() {
        $(this).width($(this).width());
    });
    return ui;
};




function sortGrid(gridId) {
    var grid = $('#'+gridId+'-grid table.items tbody');
    grid.sortable({
        forcePlaceholderSize: true,
        forceHelperSize: true,
        items: 'tr',
        update : function () {
            var serial = grid.sortable('serialize', {key: 'items[]', attribute: 'id'});
            $.ajax({
                'url': '/admin/'+gridId+'/sort',
                'type': 'post',
                'data': serial,
                'success': function(data){},
                'error': function(request, status, error) {
                    alert('Сортировка сейчас недоступна');
                }
            });
        },
        helper: fixHelper
    }).disableSelection();
}