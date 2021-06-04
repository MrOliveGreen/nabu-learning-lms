// const { nodeName } = require("jquery");

// const { parseHTML } = require("jquery");

// const { forEach } = require("lodash");

var h = (window.innerHeight || (window.document.documentElement.clientHeight || window.document.body.clientHeight));

var baseURL = window.location.protocol + "//" + window.location.host;
// var baseURL = window.location.protocol + "//" + window.location.host + '/newlms';
var filteritem = null;
var grouptab = null,
    detailtags = null;
var detailtag1 = null;
var activedTab = '#groups';

var window_level = 1;

var input_group_position = null,
    expired_date = $('#expired_date_input .input-group');

var heightToggleLeft = false;
var heightToggleRight = false;

var userDateSort = false,
    userNameSort = false,
    cateDateSort = false,
    cateNameSort = false,
    showDateSort = false,
    showNameSort = false;

// Dashmix.helpers('notify', {message: 'Your message!'});

var notification = function(str, type) {
    switch (type) {
        case 1:
            Dashmix.helpers('notify', {
                type: 'info',
                icon: 'fa fa-info-circle mr-1',
                message: str
            });
            break;

        case 2:
            Dashmix.helpers('notify', {
                type: 'danger',
                icon: 'fa fa-times mr-1',
                message: str
            });
            break;

        default:
            break;
    }

};

var clearClassName = function(i, highlighted) {
    $(highlighted).find(".btn").each(function(index, btnelement) {
        $(btnelement).removeClass("active");
    });
    if ($(highlighted).hasClass('highlight')) {
        $(highlighted).removeClass('highlight');
    }
};

var leftItemClick = function(e) {
    if (!$(this).hasClass("active")) {
        $(this).addClass("active");
    } else {
        $(this).removeClass("active");
    }

};

var itemDBlClick = function() {
    $(this).parents('.list-group').children(".list-group-item").each(function(i, e) {
        if ($(e).hasClass("active")) {
            $(e).removeClass("active");
        }
    });
};

var btnClick = function(e) {
    if (!$(this).hasClass('toggle2-btn')) {
        e.stopPropagation();
        $(this).parents('.window').find('.list-group-item').each(clearClassName);
        $(this).parents('.list-group-item').addClass('highlight');
        switch ($(this).parents('.window').attr("id")) {
            case "div_A":
                if ($('#div_D').find('.highlight').length != 0)
                    $('#div_D').find('.highlight').each(function(i, e) {
                        $(e).removeClass("highlight");
                        $(e).find('.btn').each(function(i, item) {
                            $(item).removeClass('active');
                        });
                    });
                break;
            case "div_B":
                if ($('#div_C').find('.highlight').length != 0 && activedTab == '#groups')
                    $('#div_C').find('.highlight').each(function(i, e) {
                        $(e).removeClass("highlight");
                        $(e).find('.btn').each(function(i, item) {
                            $(item).removeClass('active');
                        });
                    });
                break;
            case "div_C":
                if ($('#div_B').find('.highlight').length != 0 && activedTab == '#groups')
                    $('#div_B').find('.highlight').each(function(i, e) {
                        $(e).removeClass("highlight");
                        $(e).find('.btn').each(function(i, item) {
                            $(item).removeClass('active');
                        });
                    });
                break;
            case "div_D":
                if ($('#div_A').find('.highlight').length != 0)
                    $('#div_A').find('.highlight').each(function(i, e) {
                        $(e).removeClass("highlight");
                        $(e).find('.btn').each(function(i, item) {
                            $(item).removeClass('active');
                        });
                    });
                break;

            default:
                break;
        }

    } else {
        $(this).parents('.window').find('.list-group-item').each(clearClassName);
        $(this).parents('.list-group').children(".list-group-item").each(function(i, e) {
            if ($(e).hasClass("active")) {
                $(e).removeClass("active");
            }
        });
    }
    $(this).parents('.list-group').find('.btn.active').removeClass('active');
    $(this).addClass("active");
};

var clearTable = function(element) {
    element.each(function(i, em) {
        if ($(em).find('.list-group-item').length != 0) {
            $(em).find('.list-group-item').detach();
        }
    });
};

var clearFrom = function(element) {
    element.find('input, select').each(function(i, forminput) {
        if ($(forminput).attr('name') != '_token' && $(forminput).attr('name') != '_method') {
            $(forminput).val('');
        }
    });
    if (element.has('#preview-rect').length != 0) {
        element.find('#preview-rect').attr('src', '');
    }

};

//@param : div_b | div_d
var toggleFormOrTable = function(element, flag = null, flag1 = true) {
    var form = element.find('form');
    var table = element.find('.second-table');
    clearFrom(form);
    clearTable(table);
    if (flag1) {
        if (flag) {
            if (form.css('display') == "none") {

                form.css('display', 'block');
                table.each(function(i, em) {
                    $(em).css('display', 'none');
                });
                return form;
            }
        } else if (!flag) {
            if (table.css('display') == "none") {
                form.css('display', 'none');
                table.each(function(i, em) {
                    $(em).css('display', 'block');
                });
                return table;
            }
        } else if (flag == null) {
            if ($(table[0]).css('display') == "block") {
                table.each(function(i, em) {
                    $(em).css('display', 'none');
                });
                form.css('display', 'block');

                return form;
            } else {
                if (form.css('display') == "block") {
                    form.css('display', 'none');
                    table.each(function(i, em) {
                        $(em).css('display', 'block');
                    });

                    return table;
                }
            }
        }
    } else {
        form.toggle(false);
        table.each(function(i, em) {
            $(em).toggle(false);
        });
        return null;
    }

};

var filterToggleShow = function(event) {
    var parent = $(this).parents('.toolkit');
    parent.children(".toolkit-filter").toggle();

    parent.children('.toolkit-filter input').each(function(i, e) {
        $(e).attr('checked', false);
    });
    parent.children('.search-filter').val('');


    parent.find('.search-filter').val('');
    parent.find('input[name=status]').each(function(i, e) {
        $(e).prop('checked', false);
    });
    searchfilter(event);

    parent.find('.filter-name-btn i').toggleClass('fa-sort-alpha-down', false);
    parent.find('.filter-name-btn i').toggleClass('fa-sort-alpha-up', false);
    parent.find('.filter-date-btn i').toggleClass('fa-sort-numeric-up', false);
    parent.find('.filter-date-btn i').toggleClass('fa-sort-numeric-down', false);
};

var secondShow1 = function(event) {
    var parent = $(this).parents('.list-group-item');
    var id = parent.attr('id').split('_')[1];

    if ($(this).parents('fieldset').attr('id') == "RightPanel") {

        var item_group = parent.find('input[name="item-group"]').val();
        var arr_group = item_group.split('_');

        arr_group.map(function(group) {
            // console.log(group);
            $('#groups').find('.list-group-item').each(function(i, e) {
                if (group == $(this).attr('id').split('_')[1]) {
                    var element = $(e).clone(false);
                    var unlinkbtn = null;
                    var sectId = $(event.target).parents('.window').attr('id');
                    if (sectId == 'div_B' || sectId == 'div_D') {
                        unlinkbtn = $('<button class="btn toggle1-btn"><i class="px-2 fas fa-unlink"></i></button>').on('click', detachLinkTo);
                    } else {
                        unlinkbtn = $('<button class="btn toggle1-btn"><i class="px-2 fas fa-unlink"></i></button>').on('click', detachLinkFrom);
                    }
                    if (element.hasClass('highlight')) {
                        element.removeClass('highlight');
                        element.find('.btn.active').each(function(i, e) {
                            $(e).removeClass('active');
                        });
                    }

                    if (element.hasClass('active')) {
                        element.removeClass('active');
                    }
                    // unlinkbtn = $('<button class="btn toggle1-btn"><i class="px-2 fas fa-unlink"></i></button>').on('click', detachLinkFrom);
                    element.find('.btn-group').append(unlinkbtn);
                    element.find('button.btn').click(btnClick);
                    element.find('.item-show').bind('click', divBDshow);
                    element.find('.item-show').bind('click', secondShow1);
                    element.find('.item-edit').bind('click', function() {
                        item_edit($(this));
                    });
                    element.find('.item-delete').click(itemDelete);

                    element.toggle(true);
                    element.attr('data-src', parent.attr('id'));
                    element.parents('.list-group').attr('data-src', parent.attr('id'));
                    element.removeClass('active');
                    $("#table-groups .list-group").append(element);
                }
            });
        });

        if (!$(document).has("#user-form-tags"))
            grouptab.appendTo("#user-form-tags");

    } else if ($(this).parents('fieldset').attr('id') == "LeftPanel") {

        var activetab = $("#LeftPanel").find(".ui-state-active:first a").attr('href').split('#')[1];
        var items = $('#' + activetab).find('.list-group-item input[name="item-group"]');
        items.map(function(i, e) {
            // var item = $(e).parents('.list-group-item');
            var arr_group = $(e).val().split('_');
            var unlinkbtn = null;
            arr_group.map(function(group) {
                // console.log(group);
                if (id == group) {
                    var element = $(e).parents('.list-group-item').clone(false);
                    var sectId = $(event.target).parents('.window').attr('id');
                    if (sectId == 'div_B' || sectId == 'div_D') {
                        unlinkbtn = $('<button class="btn toggle1-btn"><i class="px-2 fas fa-unlink"></i></button>').on('click', detachLinkFrom);
                    } else {
                        unlinkbtn = $('<button class="btn toggle1-btn"><i class="px-2 fas fa-unlink"></i></button>').on('click', detachLinkTo);
                    }
                    if (element.hasClass('highlight')) {
                        element.removeClass('highlight');
                        element.find('.btn.active').each(function(i, e) {
                            $(e).removeClass('active');
                        });
                    }
                    if (element.hasClass('active')) {
                        element.removeClass('active');
                    }
                    element.find('button.btn').click(btnClick);
                    element.find('.btn-group').append(unlinkbtn);
                    element.find('.item-show').bind('click', divBDshow);
                    element.find('.item-show').bind('click', secondShow1);
                    element.find('.item-edit').bind('click', function() {
                        item_edit($(this));
                    });
                    element.find('.item-delete').click(itemDelete);

                    element.toggle(true);
                    element.attr('data-src', parent.attr('id'));
                    element.parents('.list-group').attr('data-src', parent.attr('id'));
                    element.removeClass('active');
                    $("#category-form-tags .list-group").append(element);
                }
            });
        });
    }
};

var toolkitAddItem = function(event) {
    event.preventDefault();
    event.stopPropagation();
    toggleFormOrTable($(this).parents('fieldset'), true);
    var parent = $(this).parents('fieldset');
    var parent_id = parent.attr('id');
    if (parent_id == 'RightPanel') {
        $('#training-status-icon').val('true');
        $('#training-status-icon').prop('checked', true);
        $('#div_B').find('.list-group-item').each(clearClassName);
        $("#training_form").attr('action', baseURL + '/training');
        $('#preview-rect').attr('src', baseURL + '/assets/media/default.png');
    } else if (parent_id == "LeftPanel") {
        $('#div_A').find('.list-group-item').each(clearClassName);
        $('#lesson_form').attr('action', baseURL + '/lesson');
    }
    parent.find(".method-select").val('POST');
    parent.attr('data-item', '');
};


var formInputChange = function(event) {
    console.log($(event.target).val());
};

var item_edit = function(element) {
    var parent = element.parents('.list-group-item');
    var id = parent.attr('id').split('_')[1];


    switch (element.attr('data-content')) {
        case 'lesson':
            toggleFormOrTable($('#LeftPanel'), true);
            clearFrom($('LeftPanel'));
            $("#lesson_form").attr('action', baseURL + '/lesson/' + id);
            $('#lesson_form').attr('data-item', parent.attr('id'));
            $('#lesson_form .method-select').val('PUT');
            $.get({
                url: baseURL + '/lesson/' + id,
                success: function(data, state) {
                    notification('We got lesson data successfully!', 1);
                    $("#lesson_name").val(data.name);
                    $("#lesson_duration").val("");
                    $("#lesson_target").val(data.publicAudio);
                    $("#lesson_status").val(data.status);
                    $("#lesson_language").val(data.lang);
                    $("#lesson-description").html(data.description);
                },
                error: function(err) {
                    notification("Sorry, You can't get lesson data!", 2);
                }
            });

            break;

        case 'training':
            toggleFormOrTable($('#RightPanel'), true);
            clearFrom($('RightPanel'));
            $("#training_form").attr('action', baseURL + '/training/' + id);
            $('#training_form').attr('data-item', parent.attr('id'));
            $('#training_form .method-select').val('PUT');
            $.get({
                url: baseURL + '/training/' + id,
                success: function(data, state) {
                    notification('We got train data successfully!', 1);
                    $("#preview-rect").attr("src", data.training_icon);
                    $("#base64_img_data").val(data.training_icon);
                    $("#training-status-icon").prop('checked', data.status == 1 ? true : false);
                    $("#training_name").val(data.name);
                    $("#training_duration").val("");
                    $("#training_language").val(data.lang);
                    $("#training_type").val(data.type);
                    $("#training-description").html(data.description);
                },
                error: function(err) {
                    notification("Sorry, You can't get training data!", 2);
                }
            });
            break;

        default:
            notification('How dare you can do this!<br>Please contact me about this error :)');
            break;
    }
};

var itemEdit = function(event) {
    item_edit($(this));
};

var formStatusChange = function(e) {
    $(this).val($(this).prop('checked'));
};

var item_delete = function(element) {
    var parent = element.parents('.list-group-item');
    var id = parent.attr('id').split('_')[1];
    switch (element.attr('data-content')) {
        case 'lesson':
            $.ajax({
                type: "DELETE",
                url: baseURL + '/lesson/' + id,
                success: function(result) {
                    console.log(result);
                    parent.detach();
                    notification('Successfully deleted!', 1);
                },
                error: function(err) {
                    console.log(err);
                    notification("Sorry, You can't delete!", 2);
                }
            });
            break;

        case 'training':
            $.ajax({
                type: "DELETE",
                url: baseURL + '/traning/' + id,
                success: function(result) {
                    console.log(result);
                    parent.detach();
                    notification('Successfully deleted!', 1);
                },
                error: function(err) {
                    console.log(err);
                    notification("Sorry, You can't delete!", 2);
                }
            });
            break;

        default:
            break;
    }
};

var itemDelete = function(event) {
    elem = $(this);
    cate = $(this).attr('data-content');
    var e = Swal.mixin({
        buttonsStyling: !1,
        customClass: {
            confirmButton: 'btn btn-success m-1',
            cancelButton: 'btn btn-danger m-1',
            input: 'form-control'
        }
    });
    e.fire({
        title: 'Are you sure you want to delete this item ?',
        text: cate == 'student' ? ' This user and all his historic and reports will be permanently deleted' : '',
        icon: 'warning',
        showCancelButton: !0,
        customClass: {
            confirmButton: 'btn btn-danger m-1',
            cancelButton: 'btn btn-secondary m-1'
        },
        confirmButtonText: 'Yes, delete it!',
        html: !1,
        preConfirm: function(e) {
            return new Promise((function(e) {
                setTimeout((function() {
                    e();
                    item_delete(elem);
                }), 50);
            }));
        }
    }).then((function(n) {
        if (n.value) {
            e.fire('Deleted!', 'Your ' + cate + ' has been deleted.', 'success');
            console.log();
            $(elem).parents('.list-group-item').remove();
        } else {
            'cancel' === n.dismiss && e.fire('Cancelled', 'Your data is safe :)', 'error');
        }
    }));


};

var itemShow = function(event) {
    if ($(this).parents('.window').attr('id') == "div_A" || $(this).parents('.window').attr('id') == "div_D") {
        toggleFormOrTable($("#LeftPanel"), false);
    } else {
        toggleFormOrTable($("#RightPanel"), false);
    }
    var parent = $(this).parents('.list-group-item');
    var id = $(this).attr('data-item-id');
    var cate = $(this).attr('data-content');
    $.post({
            url: baseURL + "/" + cate + "show/" + id,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        }).done(function(data) {
            console.log(data);
            if (data) {
                var detachIcon, addedbutton;
                if (cate == "lesson") {
                    JSON.parse(data).data.forEach(e => {
                        detachIcon = $('<button class="btn toggle1-btn" data-content="training"><i class="px-2 fas fa-unlink"></i></button>').on('click', detachLink);
                        addedbutton = createTrainingData(e);
                        addedbutton.find(".btn-group").append(detachIcon).attr('data-src', parent.attr('id'));
                        $("#div_B .list-group").append(addedbutton);
                    });

                } else if (cate == "training") {
                    JSON.parse(data).data.forEach(e => {
                        detachIcon = $('<button class="btn toggle1-btn" data-content="lesson"><i class="px-2 fas fa-unlink"></i></button>').on('click', detachLink);
                        addedbutton = createLessonData(e);
                        addedbutton.find(".btn-group").append(detachIcon).attr('data-src', parent.attr('id'));
                        $("#div_D .list-group").append(addedbutton);
                    });
                }
            }
        })
        .fail(function(err) {
            console.log(err);
            notification('You have an error getting data');
        });
};
var itemPlay = function(event) {
    var parent = $(this).parents('.list-group-item');
};
var itemTemplate = function(event) {
    var parent = $(this).parents('.list-group-item');
};
var itemRefresh = function(event) {
    var parent = $(this).parents('.list-group-item');
};
var itemType = function(event) {
    var parent = $(this).parents('.list-group-item');
    if ($(this).attr('data-type') == "1") {
        $(this).attr('data-type', "2");
        $(this).find('i').toggleClass('fa-wave-square', false);
        $(this).find('i').toggleClass('fa-sort-amount-down-alt', true);
    } else {
        $(this).attr('data-type', "1");
        $(this).find('i').toggleClass('fa-wave-square', true);
        $(this).find('i').toggleClass('fa-sort-amount-down-alt', false);
    }
};

var submitFunction = function(event) {
    console.log($(this).attr('action'));
    console.log($("#cate-status").attr("checked"));

    return false;
};

//TODO: make function for detach
var detachLink = function(e) {
    var parent = $(this).parents('.list-group-item');
    var showeditem = parent.attr('data-src');
    var show_id = showeditem.splite("_")[1];
    var id = parent.attr('id').split('_')[1];
    var cate = parent.attr('id').split('_')[0];
    var value, result;
    if (cate == 'lesson') {
        value = $(this).attr('data-training');
        if (value || value.indexOf(show_id) != -1) {
            $(this).attr('data-training', value.splite('_').slice(show_id).join('_'));
        }
        result = $(this).attr('data-training');
        var srcValue = $("#" + showeditem).attr('data-lesson');
        var jsonValue = JSON.parse(srcValue);
        $("#" + showeditem).attr('data-lesson', JSON.stringify(jsonRemove(jsonValue, show_id)));

    } else if (cate == 'training') {
        value = $(this).attr('data-lesson');
        var jsonValue = JSON.parse(value);
        $(this).attr('data-lesson', JSON.stringify(jsonRemove(jsonValue, show_id)));
        $("#" + showeditem).attr('data-training', value.splite('_').slice(id).join('_'));
        result = $(this).attr('data-lesson');
    }
    detachCall(cate, {
        id: showeditem.split('_')[1],
        target: result,
        flag: false
    }, $(this));
};

var jsonRemove = function(obj, item) {

    var detachedList;
    if (obj) {
        detachedList = obj.filter(function(e, i, t) {
            return (e.item != item)
        });
    }
    return detachedList;
};

var combine = function(value, id) {
    var combineArray = value.split('_').filter(function(item, i, d) {
        return item != id && item != null;
    });
    console.log(combineArray);
    return combineArray;
};

var detachCall = function(cate, connectiondata, element) {
    $.post({
        url: baseURL + '/traininglinkfromlesson',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            'data': JSON.stringify(Array(connectiondata))
        }
    }).done(function(data) {
        notification('Successfully unliked!', 1);
        if (element.parents('fieldset').attr('id') == 'RightPanel') {
            toggleFormOrTable($("#LeftPanel"), false, false);
        } else {
            toggleFormOrTable($("#RightPanel"), false, false);
        }
        element.parents('.list-group-item').detach();
        return true;
    }).fail(function(err) {
        notification("Sorry, Your action brocken!", 2);
        return false;
    }).always(function(data) {
        console.log(data);
    });
};

var submitBtn = function(event) {
    var formname = $(this).attr('data-form');
    if ($("#" + formname).attr('data-item')) {
        $("#" + $(this).parents('form').attr('data-item')).toggleClass('highlight', false);
        $("#" + $(this).parents('form').attr('data-item') + " .btn").each(function(i, em) {
            $(em).toggleClass('active', false);
        });
    }
    var validate = true;
    //TODO: We have to check this function again after a while;


    if (validate) {
        event.preventDefault(); // stops the "normal" <form> request, so we can post using ajax instead, below
        var submit_data = Array();

        $('#' + formname).find('input, switch').each(function(i, e) {
            submit_data[$(e).attr('name')] = $(e).val();
        });

        console.log($('#' + formname).serializeArray());
        var serialval = $('#' + formname).serializeArray().map(function(item) {
            if (item.name == 'training-status-icon') {
                item.value = $('#user-status-icon').prop('checked') == true ? 1 : 0;
            }
            return item;
        });
        if (!serialval.filter(function(em, t, arr) {
                return em.name == 'training-status-icon';
            }).length) {
            if (formname == 'traininig_form') {
                serialval.push({
                    name: 'traininig-status-icon',
                    value: $('#training-status-icon').prop('checked') == true ? 1 : 0
                });
            }
        }
        if (!$("#" + formname).find('input[type=checkbox]').prop('checked')) {
            if (formname == 'training_form') {
                serialval.push({
                    name: 'training-status-icon',
                    value: 0
                });
            }
        }
        console.log(serialval);
        $.ajax({
            url: $('#' + formname).attr('action'),
            method: $('#' + formname).find('.method-select').val(),
            data: serialval,
            success: function(data) {
                console.log(data);
                if ($("#" + formname).attr('data-item') == '' || $("#" + formname).attr('data-item') == null) {
                    var arr_url = $('#' + formname).attr('action').split('/');
                    var groupName = arr_url[arr_url.length - 1];
                    if (formname == "lesson_form") {
                        notification('The lesson has been saved sucessfully!', 1);
                        $('#groups .list-group').append(createLessonData(data));
                    } else if (formname == "training_form") {
                        notification('The training has been saved sucessfully!', 1);
                        $('#groups .list-group').append(createTrainingData(data));
                    }
                } else {
                    var target = $("#" + formname).attr('data-item');
                    if (formname == "lesson_form") {
                        notification('The lesson has been saved sucessfully!', 1);
                        updateLessonData(data, target);
                    } else if (formname == "training_form") {
                        notification('The training has been saved sucessfully!', 1);
                        updateTrainingData(data, target);
                    }
                }
            },
            error: function(err) {
                notification("Sorry, You have an error!", 2);
            }
        });
        var type = $('#user_type').val();
        submit_data = null;
        toggleFormOrTable($(this).parents('fieldset'), true, false);
        $('#user_type').val(type);
    }
    if ($("#" + formname).attr('data-item') != '' && $("#" + formname).attr('data-item') != null) {
        var targetName = $("#" + formname).attr('data-item').split('_')[0],
            sourceId;
        if (targetName == 'lesson') {
            sourceId = $("#lesson_form").attr('data-item');
        } else {
            sourceId = $("#training_form").attr('data-item');
        }
        $('#' + sourceId).toggleClass('highlight', false);
        $('#' + sourceId + ' .item-edit').toggleClass('active', false);
    }

};

var createLessonData = function(data) {

    var status_temp;
    switch (data['status']) {
        case 1:
            status_temp = '<i class="fa fa-circle  m-2" style="color:green;"></i>' +
                '<input type="hidden" name="item-status" class="status-notification" value="1">';
            break;
        case 2:
            status_temp = '<i class="fa fa-circle  m-2" style="color:green;"></i>' +
                '<input type="hidden" name="item-status" class="status-notification" value="2">';
            break;
        case 3:
            status_temp = '<i class="fa fa-circle  m-2" style="color:green;"></i>' +
                '<input type="hidden" name="item-status" class="status-notification" value="3">';
            break;
        case 4:
            status_temp = '<i class="fa fa-circle  m-2" style="color:green;"></i>' +
                '<input type="hidden" name="item-status" class="status-notification" value="4">';
            break;
        case 5:
            status_temp = '<i class="fa fa-circle  m-2" style="color:green;"></i>' +
                '<input type="hidden" name="item-status" class="status-notification" value="5">';
            break;
        default:
            break;
    }
    var lessonItem = $('<a class="list-group-item list-group-item-action p-0 border-transparent border-5x lesson_' + data['id'] + '"' +
        'data-date="' + data['creation_date'] + '" data-training = "' + data['training'].join('_') + '" id="lesson_' + data['id'] + '">' +
        '<div class="float-left">' +
        status_temp +
        '<span class="item-name">' + data['name'] + '</span>' +
        '</div>' +
        '<div class="btn-group float-right">' +
        '<span class=" p-2 font-weight-bolder item-lang">' + data['lang'] + '</span>' +
        '</div>' +
        '</a>');
    var btnShow = $('<button class="btn  item-show" data-content="lesson" data-item-id="' + data['id'] + '">' +
        '<i class="px-2 fa fa-eye"></i>' +
        '</button>');
    var btnEdit = $('<button class="btn item-edit" data-content="lesson" data-item-id="' + data['id'] + '">' +
        '<i class="px-2 fa fa-edit"></i>' +
        '</button>');
    var btnDelete = $('<button class="btn item-delete" data-content="lesson" data-item-id="' + data['id'] + '">' +
        '<i class="px-2 fa fa-trash-alt"></i>' +
        '</button>');
    var btnPlay = $('<button class="btn item-play" data-content="lesson" data-fabrica ="' + data['idFabrica'] + '">' +
        '<i class="px-2 fa fa-play"></i>' +
        '</button>');
    var btnTemplate = $('<button class="btn item-template" data-content="lesson" data-template = "' + data['template_player_id'] + '">' +
        '<i class="px-2 fa fa-cube"></i>' +
        '</button>');
    var btnRefresh = $('<button class="btn item-refresh" data-content="lesson" data-item-id = "' + data['id'] + '">' +
        '<i class="px-2 fa fa-sync-alt"></i>' +
        '</button>');


    btnShow.click(btnClick).click(itemShow);

    btnEdit.click(btnClick).click(itemEdit);

    btnDelete.click(btnClick).click(itemDelete);

    btnPlay.click(btnClick).click(itemPlay);

    btnTemplate.click(btnClick).click(itemTemplate);

    btnRefresh.click(btnClick).click(itemRefresh);

    lessonItem.find('.btn-group')
        .append(btnShow)
        .append(btnEdit)
        .append(btnDelete)
        .append(btnPlay)
        .append(btnTemplate)
        .append(btnRefresh)
        .dblclick(itemDBlClick)
        .click(leftItemClick)
        .bind('dragstart', dragStart)
        .bind('dragend', dragEnd)
        .attr('draggable', true);
    return lessonItem;
};

var createTrainingData = function(data) {
    var status_temp;
    switch (data['status']) {
        case 0:
            status_temp = '<i class="fa fa-circle  m-2" style="color:red;"></i>' +
                '<input type="hidden" name="item-status" class="status-notification" value="0">';
            break;
        case 1:
            status_temp = '<i class="fa fa-circle  m-2" style="color:green;"></i>' +
                '<input type="hidden" name="item-status" class="status-notification" value="1">';
            break;
        default:
            break;
    }
    var trainingItem = $('<a class="list-group-item list-group-item-action p-0 border-transparent border-5x training_' + data['id'] + '"' +
        'data-date="' + data['creation_date'] + '" data-lesson = "' + data.lesson_content + '" id="training_' + data['id'] + '">' +
        '<div class="float-left">' +
        status_temp +
        '<span class="item-name">' + data['name'] + '</span>' +
        '</div>' +
        '<div class="btn-group float-right">' +
        '<span class=" p-2 font-weight-bolder item-lang">' + data['lang'] + '</span>' +
        '</div>' +
        '</a>');

    var btnType = data.type == 1 ? $('<button class="btn  item-type" data-content="training" data-value="{{$training->type}}" data-item-id = "{{$training->id}}">' +
            '+<i class="px-2 fas fa-wave-square"></i></button>') :
        $('<button class="btn  item-type" data-content="training" data-value="{{$training->type}}" data-item-id = "{{$training->id}}">' +
            '<i class="px-2 fas fa-sort-amount-down-alt"></i></button>');

    var btnShow = $('<button class="btn  item-show" data-content="lesson" data-item-id="' + data['id'] + '">' +
        '<i class="px-2 fa fa-eye"></i>' +
        '</button>');
    var btnEdit = $('<button class="btn item-edit" data-content="lesson" data-item-id="' + data['id'] + '">' +
        '<i class="px-2 fa fa-edit"></i>' +
        '</button>');
    var btnDelete = $('<button class="btn item-delete" data-content="lesson" data-item-id="' + data['id'] + '">' +
        '<i class="px-2 fa fa-trash-alt"></i>' +
        '</button>');

    btnType.click(btnClick).click(itemType);

    btnShow.click(btnClick).click(itemShow);

    btnEdit.click(btnClick).click(itemEdit);

    btnDelete.click(btnClick).click(itemDelete);

    trainingItem.find('.btn-group')
        .append(btnType)
        .append(btnShow)
        .append(btnEdit)
        .append(btnDelete)
        .on('drop', dropEnd);
    return trainingItem;
};

var updateLessonData = function(data, target) {
    $('.' + target).each(function(i, im) {
        $(im).find('.item-name').html(data.name);
        $(im).find('input[name="item-name"]').val(data.name);
        $(im).find('.item-lang').val(data.lesson_language);
        $(im).find('.status-notification').val(data.status);
        $(im).find('.status-notification').prev().css('color', data.status == '1' ? 'green' : data.status == '2' ? 'blue' : data.status == '3' ? 'yellow' : data.status == '4' ? 'orange' : 'white');
    });

};

var updateTrainingData = function(data, target) {
    $('.' + target).each(function(i, im) {
        $(im).find('.item-name').html(data.name);
        $(im).find('input[name="item-name"]').html(data.name);
        $(im).find('.item-lang').val(data.lesson_language);
        $(im).find('.status-notification').val(data.status);
        $(im).find('.status-notification').prev().css('color', data.status == '1' ? 'green' : 'red');
    });
};

var cancelBtn = function(event) {
    var parent = $(this).parents('fieldset');
    if ($(this).parents('form').attr('data-item')) {
        $("#" + $(this).parents('form').attr('data-item')).toggleClass('highlight');
        $("#" + $(this).parents('form').attr('data-item') + " .btn").each(function(i, em) {
            $(em).toggleClass('active', false);
        });
    }
    toggleFormOrTable(parent, null, false);
};

var clearFilterCategory = function(element, category, defaultStr) {
    $(element).val('');
    $(element).html(defaultStr);
    $(element).change();
    $('#' + category).find('.list-group-item').each(clearClassName);
    $('#' + category).find('.toggle1-btn').toggle(true);
    $('#' + category).find('.toggle2-btn').toggle(false);
};

var toggleAndSearch = function(element, category, defaultStr) {
    if ($('#' + category).find('.list-group-item.active').length) {
        var items = [],
            itemVal = [];
        $('#' + category).find('.list-group-item.active').each(function(i, el) {
            items.push($(el).find('.item-name').html());
            itemVal.push($(el).attr('id').split('_')[1]);
        });
        $(element).val(itemVal.join('_'));
        $(element).html(items.join(', ') + "&nbsp; X");
        // searchfilter(event);
        $(element).change();
    } else {
        $(element).html(defaultStr);
    }
    if ('#' + category != activedTab) {
        $('#' + category).fadeOut(1);
        $(activedTab).fadeIn(1);
    } else {
        $(activedTab).find('.toggle2-btn').each(function(i, e) {
            $(e).toggle(false);
            $(e).siblings('.toggle1-btn').toggle(true);
            $(e).parents('.list-group-item').toggleClass('active', false);
        });
    }
};

var getFilterCategory = function(element, category) {
    $(activedTab).fadeOut(1);
    $('#' + category).fadeIn(1);
    $('#' + category + " .list-group").attr('data-filter', $(element).parents('.toolkit').attr('id'));
    $(element).html('Cancel');
    $("#" + category).find('.toggle2-btn').each(function(i, e) {
        $(e).toggle(true);
    });
    $("#" + category).find('.toggle1-btn').each(function(i, e) {
        $(e).toggle(false);
    });
    $('#' + category).find('.list-group-item').each(clearClassName);
};

var cancelFilterCategoryAll = function() {
    $('.filter-function-btn').each(function(i, e) {
        if ($(e).html() != 'function +<i></i>') {
            $(e).html('function +<i></i>');
            $(e).val('');
            $('#positions').fadeOut(1);
            $(activedTab).fadeIn(1);
        }
    });
    $('.filter-company-btn').each(function(i, e) {
        if ($(e).html() != 'company +<i></i>') {
            $(e).html('company +<i></i>');
            $(e).val('');
            $('#companies').fadeOut(1);
            $(activedTab).fadeIn(1);
        }
    });
};
//filter

var searchfilter = function(event) {
    var parent = $(event.target).parents('.toolkit');
    var items = null;
    var str = parent.find('input.search-filter').val();
    var opt = parent.find('input[name=status]:checked').val();
    var ctgc = parent.find('button.filter-company-btn').val();
    var ctgf = parent.find('button.filter-function-btn').val();

    if ($(event.target).is('input.search-filter')) {
        str = event.target.value;
        console.log(str);
    }

    if (parent.attr('id') == 'lesson-toolkit') {
        items = $("#div_A").find('.list-group .list-group-item');
    } else if (parent.attr('id') == 'training-toolkit') {
        items = $("#div_C").find('.list-group .list-group-item');

    }
    // console.log(items);

    items.map(function(i, e) {
        var item_name = $(e).find('input[name="item-name"]').val();
        var item_status = $(e).find('input[name="item-status"]').val();

        // console.log(item_name);

        if (str == null || str == '' || item_name.toLowerCase().indexOf(str.replace(/\s+/g, '')) >= 0) {

            switch (opt) {
                case 'on':
                case '1':
                    if (item_status == 1) {
                        $(e).toggle(true);
                    } else {
                        $(e).toggle(false);
                    }
                    break;
                case 'all':
                    $(e).toggle(true);
                    break;

                case 'off':
                    if (item_status == 1) {
                        $(e).toggle(false);
                    } else {
                        $(e).toggle(true);
                    }
                    break;
                case '2':
                    if (item_status == 2) {
                        $(e).toggle(false);
                    } else {
                        $(e).toggle(true);
                    }
                    break;
                case '3':
                    if (item_status == 3) {
                        $(e).toggle(false);
                    } else {
                        $(e).toggle(true);
                    }
                    break;
                case '4':
                    if (item_status == 4) {
                        $(e).toggle(false);
                    } else {
                        $(e).toggle(true);
                    }
                    break;
                case '5':
                    if (item_status == 5) {
                        $(e).toggle(false);
                    } else {
                        $(e).toggle(true);
                    }
                    break;
                case 'orphans':
                    if ($(e).attr('data-training')) {
                        $(e).toggle(false);
                    } else {
                        $(e).toggle(true);
                    }
                    break;
                default:
                    $(e).toggle(true);
                    break;
            }
        } else {
            $(e).toggle(false);
        }

    });
    if ($(this).parents('fieldset').attr('id') == "LeftPanel") {
        heightToggleLeft = true;
        $('#div_left').dblclick();
    } else if ($(this).parents('fieldset').attr('id') == "RightPanel") {
        heightToggleRight = true;
        $('#div_right').dblclick();
    }
};

var sortfilter = function(event) {
    var parent = $(event.target).parents('.toolkit');
    var $items = null,
        $itemgroup;
    var nameIcon = $(event.target).parents('.toolkit').find('.filter-name-btn i');
    var dateIcon = $(event.target).parents('.toolkit').find('.filter-date-btn i');


    if ($(this).siblings('button').find('i').hasClass('fa-sort-numeric-down')) {
        $(this).siblings('button').find('i').removeClass('fa-sort-numeric-down');
    }

    if ($(this).siblings('button').find('i').hasClass('fa-sort-numeric-up')) {
        $(this).siblings('button').find('i').removeClass('fa-sort-numeric-up');
    }

    if ($(this).siblings('button').find('i').hasClass('fa-sort-alpha-down')) {
        $(this).siblings('button').find('i').removeClass('fa-sort-alpha-down');
    }

    if ($(this).siblings('button').find('i').hasClass('fa-sort-alpha-up')) {
        $(this).siblings('button').find('i').removeClass('fa-sort-alpha-up');
    }

    if (parent.prev().is('.nav')) {
        var selector = parent.prev().find('.ui-state-active a').attr('href').split('#')[1];
        $itemgroup = $("#" + selector).find('.list-group');
        // items = $("#" + selector).find('.list-group .list-group-item');
    } else {
        // items = parent.next('.list-group').find('.list-group-item');
        $itemgroup = parent.next('.list-group');
    }
    $items = $itemgroup.children('.list-group-item');
    switch ($(this).parents('.toolkit').attr('id')) {
        case 'lesson-toolkit':
            if ($(this).is('.filter-name-btn')) {
                userNameSort = !userNameSort;
                $items.sort(function(a, b) {
                    var an = $(a).find('span.item-name').html().split('&nbsp;').join('').toLowerCase(),
                        bn = $(b).find('span.item-name').html().split('&nbsp;').join('').toLowerCase();

                    if (userNameSort) {
                        nameIcon.toggleClass('fa-sort-alpha-down', true);
                        nameIcon.toggleClass('fa-sort-alpha-up', false);
                        if (an > bn) {
                            return 1;
                        }
                        if (an < bn) {
                            return -1;
                        }
                        return 0;

                    } else {
                        nameIcon.toggleClass('fa-sort-alpha-down', false);
                        nameIcon.toggleClass('fa-sort-alpha-up', true);
                        if (an < bn) {
                            return 1;
                        }
                        if (an > bn) {
                            return -1;
                        }
                        return 0;
                    }
                });
                $items.detach().appendTo($itemgroup);

            } else {
                userDateSort = !userDateSort;
                $items.sort(function(a, b) {
                    var an = new Date(a.dataset.date),
                        bn = new Date(b.dataset.date);
                    if (userDateSort) {
                        dateIcon.toggleClass('fa-sort-numeric-down', true);
                        dateIcon.toggleClass('fa-sort-numeric-up', false);
                        if (an > bn) {
                            return 1;
                        }
                        if (an < bn) {
                            return -1;
                        }
                        return 0;
                    } else {
                        dateIcon.toggleClass('fa-sort-numeric-down', false);
                        dateIcon.toggleClass('fa-sort-numeric-up', true);
                        if (an < bn) {
                            return 1;
                        }
                        if (an > bn) {
                            return -1;
                        }
                        return 0;
                    }
                });

                $items.detach().appendTo($itemgroup);
            }
            break;
        case 'training-toolkit':
            if ($(this).is('.filter-name-btn')) {
                cateNameSort = !cateNameSort;
                $items.sort(function(a, b) {
                    var an = $(a).find('span.item-name').html().split('&nbsp;').join('').toLowerCase(),
                        bn = $(b).find('span.item-name').html().split('&nbsp;').join('').toLowerCase();

                    if (cateNameSort) {
                        nameIcon.toggleClass('fa-sort-alpha-down', true);
                        nameIcon.toggleClass('fa-sort-alpha-up', false);
                        if (an > bn) {
                            return 1;
                        }
                        if (an < bn) {
                            return -1;
                        }
                        return 0;
                    } else {
                        nameIcon.toggleClass('fa-sort-alpha-down', false);
                        nameIcon.toggleClass('fa-sort-alpha-up', true);
                        if (an < bn) {
                            return 1;
                        }
                        if (an > bn) {
                            return -1;
                        }
                        return 0;
                    }
                });

                $items.detach().appendTo($itemgroup);

            } else {
                cateDateSort = !cateDateSort;
                $items.sort(function(a, b) {
                    var an = new Date(a.dataset.date),
                        bn = new Date(b.dataset.date);
                    if (cateDateSort) {
                        dateIcon.toggleClass('fa-sort-numeric-down', true);
                        dateIcon.toggleClass('fa-sort-numeric-up', false);
                        if (an > bn) {
                            return 1;
                        }
                        if (an < bn) {
                            return -1;
                        }
                        return 0;
                    } else {
                        dateIcon.toggleClass('fa-sort-numeric-down', false);
                        dateIcon.toggleClass('fa-sort-numeric-up', true);
                        if (an < bn) {
                            return 1;
                        }
                        if (an > bn) {
                            return -1;
                        }
                        return 0;
                    }
                });

                $items.detach().appendTo($itemgroup);
            }
            break;

        default:
            break;
    }

    $(this).addClass('active');
    $(this).siblings('button').toggleClass('.active', false);
};


var handlerDBClick = function(event) {
    var heightToggle;
    if ($(this).parents('fieldset').attr('id') == 'LeftPanel') {
        heightToggleLeft = !heightToggleLeft;
        heightToggle = heightToggleLeft;
    } else if ($(this).parents('fieldset').attr('id') == 'RightPanel') {
        heightToggleRight = !heightToggleRight;
        heightToggle = heightToggleRight;
    }
    var divHight = 20 + parseInt($("#div_left").height()) + parseInt($('.content-header').height());
    if (heightToggle) {
        $(this).prev().css('height', (h - parseInt($('.toolkit').css('height')) - divHight) - 90 + 'px');
    } else {
        var activeTabHeight = parseInt($($(this).parents('fieldset').find('.ui-state-active a').first().attr('href')).find('.list-group').css('height'));
        var newHeight = (h - parseInt($('.toolkit').css('height')) - divHight) / 2 - 90;
        if (newHeight > activeTabHeight) {
            $(this).prev().css('height', activeTabHeight + "px");
        } else {
            $(this).prev().css('height', newHeight + "px");
        }
    }
};
//////////////////////////////////
///////////////////////////////////
//////////////////////////////////

var dragitem = null;

function dragStart(event) {
    dragitem = Array();
    $(this).parents(".list-group").children('.active.list-group-item').each(function(i, dragelem) {
        dragitem.push($(dragelem).attr("id"));
    });
    if (dragitem.indexOf($(this).attr('id')) == -1) {
        dragitem.push($(this).attr('id'));
    }
    console.log($(this).css('cursor'));
    // console.log(dragitem);
}

function dragOver(event) {
    $(event.target).css('opacity', '50%');
    event.preventDefault();
}

function dragLeave(event) {
    $(event.target).css('opacity', '100%');
    event.preventDefault();
}

function dragEnd(event) {
    $('main').css('cursor', 'default');
}

function dropEnd(event, item) {
    $(event.target).css('opacity', '100%');
    $('main').css('cursor', 'default');
    var parent = $(event.target);
    var showCate = null,
        showItem = null;
    if (parent.hasClass('highlight')) {
        showCate = parent.attr('id');
    }

    var requestData = Array();

    var cate_id = $(event.target).attr("id").split('_')[1];
    var cate = $(event.target).attr("id").split('_')[0];
    var rowData = Array();
    if (dragitem != null) {
        // var category = dragitem[0].split('_')[0];
        dragitem.map(function(droppeditem) {
            var original = $(this).attr('data-lesson');

            rowData = $("#" + droppeditem).attr('id');
            JSON.parse(original).map(function(e) {
                if (e != rowData) {
                    requestData.push({
                        "item": rowData
                    });
                }
            });
            // console.log(droppeditem.split('_')[1]);

            if ($('#' + droppeditem).hasClass('highlight')) {
                showItem = droppeditem;
            }
        });
        // requestData.forEach(itemData => {
        //     itemData =JSON.stringify(itemData)
        // })

        $.post({
            url: baseURL + '/traininglinkfromlesson' + cate,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                'id': cate_id,
                'data': JSON.stringify(requestData)
            }
        }).done(function(data) {

            if (showCate) {
                $('#div_C #' + showCate + " .item-show").click();
            }
            if (showItem) {
                $('#div_A #' + showItem + " .item-show").click();
            }
            if (dragitem[0]) {
                notification(dragitem.length + ' ' + lessons + 's linked to ' + $(event.target).find('.item-name').html() + '!', 1);
            }
            $(this).attr('data-lesson', JSON.stringify(requestData));
            dragitem.map(function(droppeditem) {
                if ($("#" + droppeditem).attr('data-training').split('_').indexOf(cate_id) == -1) {
                    $("#" + droppeditem).attr('data-training').split('_').push(cate_id).join('_');
                }
            });
            requestData = [];
        }).fail(function(err) {
            notification("Sorry, You have an error!", 2);
            requestData = [];
        }).always(function(data) {
            console.log(data);
            dragitem = null;
        });
    }
    $("#LeftPanel").find('.list-group-item').each(function() {
        if ($(this).hasClass('active')) {
            $(this).removeClass('active');
        }
    });
}

$(document).ready(function() {

    $("#RightPanel .list-group-item").each(function(i, elem) {
        $(elem).attr('draggable', false);
        $(elem).on('drop', dropEnd);

        elem.addEventListener('dragover', dragOver);
        elem.addEventListener('dragleave', dragLeave);
    });

    $("#LeftPanel .list-group-item").each(function(i, elem) {
        elem.addEventListener('dragstart', dragStart);
        elem.addEventListener('dragend', dragEnd);
        $(elem).attr('draggable', true);
    });

    document.getElementById('preview-rect').addEventListener('resize', function(event) {
        $(this).height(($(this).width() * 9 / 16) + "px");
    });

    $("#div_D .list-group").sortable();
    $("#div_D .list-group").disableSelection();
});
$('input[name=status], input.search-filter, button.filter-company-btn, button.filter-function-btn').change(searchfilter);
$('input.search-filter').on('keydown change keyup', searchfilter);
$("button.filter-company-btn, button.filter-function-btn").on('drop', searchfilter);

$("#LeftPanel .list-group-item").click(leftItemClick);
$("#LeftPanel .list-group-item").dblclick(itemDBlClick);
$(".list-group-item button.btn").click(btnClick);
$('.item-delete').click(itemDelete);
$('.item-edit').click(itemEdit);
$('.item-show').click(itemShow);
$('.item-play').click(itemPlay);
$('.item-template').click(itemTemplate);
$('.item-refresh').click(itemRefresh);
$('.item-type').click(itemType);

$('.toolkit-add-item').click(toolkitAddItem);
$('form input, form select').change(formInputChange);
$('.submit-btn').click(submitBtn);
$('.cancel-btn').click(cancelBtn);

$(".toolkit-show-filter").click(filterToggleShow);
$('.filter-name-btn').click(sortfilter);
$('.filter-date-btn').click(sortfilter);
$('.handler_horizontal').dblclick(handlerDBClick);