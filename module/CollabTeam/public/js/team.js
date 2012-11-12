$(document).ready(function() {
    var teamMemberCache = {};

    $('#team-members-list a.delete').live('click', function() {
        $(this).closest('li').fadeOut('slow', function() {
            $(this).remove();
        });
        return false;
    });

    $('#team-members-list button').click(function() {
        var input = $('#team-members-ajax'), id = input.attr('data-id'), li;

        if (!$('#team-members-list li input[value="' + id + '"]').length) {
            li = $('<li />');
            li.append('<input type="hidden" name="team[members][][id]" value="' + id + '" />');
            li.append(input.attr('data-display-name'));
            li.append('&nbsp;<a class="delete" href="">(remove)</a>');
            $('#team-members-list ul').append(li);
        }

        input.val('');
        input.attr('data-id', false);
        input.attr('data-identity', false);
        input.attr('data-display-name', false);

        return false;
    });

    $('#team-members-ajax').typeahead({
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
                        value = data[i].identity;
                        teamMemberCache[value] = data[i];
                        result.push(value);
                    }

                    typeahead(result);
                }
            });
        },
        'updater': function(item) {
            this.$element.attr('data-id', teamMemberCache[item].id);
            this.$element.attr('data-identity', teamMemberCache[item].identity);
            this.$element.attr('data-display-name', teamMemberCache[item].displayName);
            return item;
        }
    });
});