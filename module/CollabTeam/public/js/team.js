$(document).ready(function() {
    // TODO: Clean up the JS code. It's late right now and I wanna finish this...

    var teamMemberCache = {};
    var teamProjectCache = {};

    $('#team-members-list a.delete, #team-projects-list a.delete').live('click', function() {
        $(this).closest('li').fadeOut('slow', function() {
            $(this).remove();
        });
        return false;
    });

    $('#team-projects-list button').click(function() {
        var input = $('#team-projects-ajax'), id = input.attr('data-id'), li;

        if (id && !$('#team-projects-list li input[value="' + id + '"]').length) {
            li = $('<li />');
            li.append('<input type="hidden" name="team[projects][][id]" value="' + id + '" />');
            li.append(input.attr('data-name'));
            li.append('&nbsp;<a class="delete" href="">(remove)</a>');
            $('#team-projects-list ul').append(li);
        }

        input.val('');
        input.removeAttr('data-id');
        input.removeAttr('data-name');

        return false;
    });

    $('#team-members-list button').click(function() {
        var input = $('#team-members-ajax'), id = input.attr('data-id'), li;

        if (id && !$('#team-members-list li input[value="' + id + '"]').length) {
            li = $('<li />');
            li.append('<input type="hidden" name="team[members][][id]" value="' + id + '" />');
            li.append(input.attr('data-display-name'));
            li.append('&nbsp;<a class="delete" href="">(remove)</a>');
            $('#team-members-list ul').append(li);
        }

        input.val('');
        input.removeAttr('data-id');
        input.removeAttr('data-identity');
        input.removeAttr('data-display-name');

        return false;
    });

    $('#team-projects-ajax').typeahead({
        'minLength': 3,
        'source': function(query, typeahead) {
            $.ajax({
                'dataType': 'json',
                'data': {
                    'ajax': true,
                    'type': 'project',
                    'query': query
                },
                'success': function(data) {
                    var i, value, result = [];

                    for (i = 0; i < data.length; ++i) {
                        value = data[i].name;
                        teamProjectCache[value] = data[i];
                        result.push(value);
                    }

                    typeahead(result);
                }
            });
        },
        'updater': function(item) {
            this.$element.attr('data-id', teamProjectCache[item].id);
            this.$element.attr('data-name', teamProjectCache[item].name);
            return item;
        }
    });


    $('#team-members-ajax').typeahead({
        'minLength': 3,
        'source': function(query, typeahead) {
            $.ajax({
                'dataType': 'json',
                'data': {
                    'ajax': true,
                    'type': 'user',
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