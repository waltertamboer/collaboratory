(function() {
    $(document).ready(function() {
        var timeout, didLookup;

        var filterData = function(data, list, keyName) {
            var i, j, found = false, result = [];
            for (i = 0; i < data.length; ++i) {
                found = false;

                for (j = 0; j < list.length; ++j) {
                    if ($('input:hidden', list[j]).val() == data[i][keyName]) {
                        found = true;
                    }
                }

                if (!found) {
                    result.push(data[i]);
                }
            }
            return result;
        };

        var search = function(listener) {
            var i, url = listener.data('url'),
                keyName = listener.data('key') || 'id',
                lblName = listener.data('lbl') || 'name';

            $.getJSON(url, function(data) {
                var li, list = createList(listener), key, lbl, dataList,
                    pills = listener.closest('.autocomplete').find('.pills');

                didLookup = true;
                dataList = filterData(data.data, pills.find('li'), keyName);

                for (i = 0; i < dataList.length; ++i) {
                    (function(item) {
                        key = item[keyName];
                        lbl = item[lblName];

                        li = $('<li>').appendTo(list);
                        li.attr('data-key', key);
                        li.html(lbl);
                        (function(listItem, key, lbl) {
                            listItem.mousedown(function() {
                                listener.val(lbl).attr('data-key-value', key);
                                listener.siblings('ul').hide();

                                didLookup = false;
                                return false;
                            });
                        })(li, key, lbl);
                    })(dataList[i]);
                }
            });
        };

        var createList = function(listener) {
            var list = listener.siblings('ul').empty();
            if (!list.length) {
                list = $('<ul>').insertAfter(listener);
            }
            list.show().parent().css('position', 'relative');
            return list;
        };

        $('.autocomplete .listener').keyup(function() {
            var listener = $(this);

            clearTimeout(timeout);
            didLookup = false;

            if (listener.val().length > 0) {
                timeout = setTimeout(function() {
                    search(listener);
                }, 250);
            } else {
                listener.siblings('ul').hide();
            }
        }).focus(function() {
            if (didLookup) {
                $(this).siblings('ul').show();
            }
        }).blur(function() {
            clearTimeout(timeout);

            $(this).siblings('ul').hide();
        });

        $('.autocomplete button').click(function() {
            var ac = $(this).closest('.autocomplete'),
                pills = $('.pills', ac),
                listener = $('.listener', ac),
                key = listener.attr('data-key-value'),
                lbl = listener.val(),
                count = $('li', pills).length,
                name = listener.attr('data-name');

            if (!lbl || !key) {
                return false;
            }

            var newLi = $('<li>').appendTo(pills);
            newLi.append($('<input type="hidden" name="' + name + '[' + count + '][id]">').val(key));
            newLi.append($('<span>' + lbl + '</span> <a class="remove action" href="">(remove)</a>'));

            listener.val('');
            listener.attr('data-key-value', '');
            didLookup = false;
            return false;
        });

        $('.autocomplete .remove').live('click', function() {
            $(this).closest('li').fadeOut('fast', function() {
                $(this).remove();
            });
            return false;
        });
    });
})();