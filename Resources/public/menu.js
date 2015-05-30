$(function() {
    $.fn.menuItems = function() {
        
        function menuItemType($tr) {
            var value = $tr.find('select[name*="type"]').val();
            
            if(value === 'section'){
                $tr.find('select[name*="routeKey"]').prop('disabled', null);
                $tr.find('input[name*="uri"]').prop('disabled', 'disabled');
            }
            else{
                $tr.find('select[name*="routeKey"]').prop('disabled', 'disabled');
                $tr.find('input[name*="uri"]').prop('disabled', null);
            }
        }
        return this.each(function() {
            $(this).find('tbody tr').each(function() {
                $tr = $(this);
                menuItemType($tr);
                $tr.find('select[name*="type"]').change(function() {
                    menuItemType($tr);
                });

            });
        });

    };
});