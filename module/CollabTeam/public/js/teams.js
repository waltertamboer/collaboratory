$(document).ready(function() {
    $('#checkAllPermissions #checkAll').change(function() {
        var val = $(this).is(':checked');
        $(this).closest('.lbl-collection').find('input[type="checkbox"]').attr('checked', val);
    });
});