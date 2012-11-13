$(document).ready(function() {
    // TODO: Clean up the JS code. It's late right now and I wanna finish this...

    var userTeamsCache = {};

    $('#user-teams-list a.delete').live('click', function() {
        $(this).closest('li').fadeOut('slow', function() {
            $(this).remove();
        });
        return false;
    });

    $('#user-teams-list button').click(function() {
        var input = $('#user-teams-ajax'), id = input.attr('data-id'), li;

        if (!$('#user-teams-list li input[value="' + id + '"]').length) {
            li = $('<li />');
            li.append('<input type="hidden" name="teams[][id]" value="' + id + '" />');
            li.append(input.attr('data-name'));
            li.append('&nbsp;<a class="delete" href="">(remove)</a>');
            $('#user-teams-list ul').append(li);
        }

        input.val('');
        input.attr('data-id', false);
        input.attr('data-name', false);

        return false;
    });

    $('#user-teams-ajax').typeahead({
        'minLength': 3,
        'source': function(query, typeahead) {
            $.ajax({
                'dataType': 'json',
                'data': {
                    'ajax': true,
                    'query': query
                },
                'success': function(data) {
                    var i, value, result = [];

                    for (i = 0; i < data.length; ++i) {
                        value = data[i].name;
                        userTeamsCache[value] = data[i];
                        result.push(value);
                    }

                    typeahead(result);
                }
            });
        },
        'updater': function(item) {
            this.$element.attr('data-id', userTeamsCache[item].id);
            this.$element.attr('data-name', userTeamsCache[item].name);
            return item;
        }
    });
});