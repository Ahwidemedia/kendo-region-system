$(document).ready(function() {
    var
    	
        sourceTable = $('#addelement-table'),
        sourceBody = sourceTable.find('tbody'),
        sourceTemplate = _.template($('#addelement-template').remove().text()),
        numberRows = sourceTable.find('tbody > tr').length;

    sourceTable
        .on('click', 'a.add', function(e) {
      
            e.preventDefault();
			
            $(sourceTemplate({key: numberRows++}))
                .hide()
                .appendTo(sourceBody)
                .fadeIn('fast');
        })
        .on('click', 'a.remove', function(e) {
                e.preventDefault();

            $(this)
                .closest('tr')
                .fadeOut('fast', function() {
                    $(this).remove();
                });
        });

        
});