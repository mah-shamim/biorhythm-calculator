function pulseElement(selector) {
    $(selector).dequeue().transition({
        scale: 1.1
    }, 25).transition({
        scale: 1
    }, 25)
}

function rubberElement(selector) {
    $(selector).dequeue().transition({
        scale: [1.25, 0.75]
    }, 30).transition({
        scale: [0.75, 1.25]
    }, 10).transition({
        scale: [1.15, 0.85]
    }, 20).transition({
        scale: [1, 1]
    }, 40)
}

function shakeElement(selector) {
    $(selector).dequeue().transition({
        x: '-5px'
    }, 5).transition({
        x: '5px'
    }, 10).transition({
        x: '-5px'
    }, 10).transition({
        x: '5px'
    }, 10).transition({
        x: '-5px'
    }, 10).transition({
        x: '5px'
    }, 10).transition({
        x: '-5px'
    }, 10).transition({
        x: '5px'
    }, 10).transition({
        x: '-5px'
    }, 10).transition({
        x: '0px'
    }, 5)
}

function wobbleElement(selector) {
    $(selector).dequeue().transition({
        x: '-25%',
        rotate: '-5deg'
    }, 15).transition({
        x: '20%',
        rotate: '3deg'
    }, 15).transition({
        x: '-15%',
        rotate: '-3deg'
    }, 15).transition({
        x: '10%',
        rotate: '2deg'
    }, 15).transition({
        x: '-5%',
        rotate: '-1deg'
    }, 15).transition({
        x: '0%',
        rotate: '0deg'
    }, 25)
}

function alertField(fieldName) {
    $('#' + fieldName + '_form').submit(function() {
        return !1
    });
    $('#' + fieldName + '_submit').removeClass('green').addClass('red');
    $('#' + fieldName + '_form_status').removeClass('restore_' + fieldName).addClass('alert_' + fieldName);
    $('#' + fieldName).focus()
}

function restoreField(fieldName) {
    $('#' + fieldName + '_form').unbind('submit');
    $('#' + fieldName + '_submit').removeClass('red').addClass('green');
    $('#' + fieldName + '_form_status').removeClass('alert_' + fieldName).addClass('restore_' + fieldName);
    $('#' + fieldName).focus()
}

function alertSearchField() {
    alertField('search')
}

function restoreSearchField() {
    restoreField('search')
}

function validateSearch(isSubmitted) {
    if (!isEmpty('#search')) {
        if (isSubmitted === !0) {
            $('#search_form').submit()
        } else if (isSubmitted === !1) {
            restoreSearchField()
        }
    } else if (isEmpty('#search')) {
        alertSearchField();
        if (isSubmitted === !0) {
            shakeElement('#search')
        }
    }
}

function alertDobField() {
    alertField('dob');
    $('#dob').datepicker('show')
}

function restoreDobField() {
    restoreField('dob');
    $('#dob').datepicker('hide')
}

function alertErase() {
    shakeElement('#dob_erase')
}

function alertFullname() {
    shakeElement('#fullname');
    $('#fullname').focus()
}

function enableFields(isErased) {
    $('#dob, #fullname').removeAttr('disabled').removeAttr('readonly');
    if (isErased === !0) {
        $('#dob, #fullname').val('')
    }
}

function maskField(selector) {
    $(selector).on('keypress', function(e) {
        if (e.keyCode != 8 && e.keyCode != 37 && e.keyCode != 38 && e.keyCode != 39 && e.keyCode != 40 && e.keyCode != 46 && countChar($(selector).val(), '-') < 2) {
            maskInput($(selector).val(), $(selector), '4,7', '-')
        }
    }).on('keyup', function(e) {
        if (e.which != 8 && e.which != 37 && e.which != 38 && e.which != 39 && e.which != 40 && e.which != 46 && countChar($(selector).val(), '-') < 2) {
            maskInput($(selector).val(), $(selector), '4,7', '-')
        }
    }).on('keydown', function(e) {
        if (e.which != 8 && e.which != 37 && e.which != 38 && e.which != 39 && e.which != 40 && e.which != 46 && countChar($(selector).val(), '-') < 2) {
            maskInput($(selector).val(), $(selector), '4,7', '-')
        }
    })
}

function maskDob() {
    maskField('#dob')
}

function helpDobForm() {
    if ($('#dob').prop('disabled') === !0) {
        $('span#dob_form_status').addClass('disabled_dob')
    } else if ($('#dob').prop('disabled') === !1) {
        $('span#dob_form_status').removeClass('disabled_dob')
    }
    if ($('#dob').val() == $('#dob').datepicker('option', 'defaultDate')) {
        $('#dob_form_status').addClass('default_dob')
    } else if ($('#dob').val() != $('#dob').datepicker('option', 'defaultDate')) {
        $('#dob_form_status').removeClass('default_dob')
    }
    if ($('#dob_bar').has('#fullname').length) {
        $('span#dob_form_status').addClass('has_fullname').removeClass('no_fullname')
    } else if (!$('#dob_bar').has('#fullname').length) {
        $('span#dob_form_status').removeClass('has_fullname').addClass('no_fullname')
    }
    if (isEmpty('#dob')) {
        $('span#dob_form_status').addClass('empty_dob').removeClass('correct_dob').removeClass('checked_default_dob')
    } else if (!isEmpty('#dob')) {
        $('span#dob_form_status').removeClass('empty_dob');
        if (isDate($('#dob').val())) {
            $('span#dob_form_status').removeClass('wrong_dob').addClass('correct_dob');
            if (($('#dob_bar').has('#name_toggle').length || $('#fullname').prop('disabled') === !1) && isEmpty('#fullname')) {
                $('span#dob_form_status').addClass('empty_fullname').removeClass('filled_fullname')
            } else {
                $('span#dob_form_status').removeClass('empty_fullname').addClass('filled_fullname')
            }
        } else if (!isDate($('#dob').val())) {
            $('span#dob_form_status').addClass('wrong_dob').removeClass('correct_dob').removeClass('checked_default_dob')
        }
    }
    $('#dob_form').on({
        focusin: function() {
            $('span#dob_form_status').addClass('focus_dob')
        },
        focusout: function() {
            $('span#dob_form_status').removeClass('focus_dob')
        }
    }, '#dob').on({
        focusin: function() {
            $('span#dob_form_status').addClass('focus_fullname')
        },
        focusout: function() {
            $('span#dob_form_status').removeClass('focus_fullname')
        }
    }, '#fullname').on({
        mouseenter: function() {
            $('span#dob_form_status').addClass('hovered')
        },
        mouseleave: function() {
            $('span#dob_form_status').removeClass('hovered')
        }
    })
}

function submitDob() {
    if (!isEmpty('#fullname')) {
        $.cookie('BIO:remembered_fullname', $('#fullname').val())
    } else if (isEmpty('#fullname')) {
        $.cookie('BIO:remembered_fullname', '')
    }
    $.cookie('BIO:remembered_dob', $('#dob').val());
    $('#dob_form').submit()
}

function hintDob() {
    if (!isEmpty('#dob')) {
        if (isDate($('#dob').val())) {
            $.ajax({
                url: '/triggers/json/same_birthday.php',
                type: 'GET',
                cache: !1,
                data: {
                    dob: $('#dob').val()
                },
                dataType: 'json'
            }).done(function(data) {
                for (i = 0; i < data.length; ++i) {
                    console.log(data);
                    $('table#same_birthday_suggestion tbody').append('<tr><td>' + data[i].name + '</td><td>' + data[i].dob + '</td></tr>')
                }
            })
        }
    }
}

function validateDob(isSubmitted, type) {
    if (typeof(isSubmitted) === 'undefined') isSubmitted = !1;
    if (typeof(type) === 'undefined') type = 'submit';
    if (!isEmpty('#dob')) {
        if (isDate($('#dob').val())) {
            if (isSubmitted === !0) {
                if (($('#dob_bar').has('#name_toggle').length || $('#fullname').prop('disabled') === !1) && $('#dob').prop('disabled') === !1) {
                    if ($('#fullname').prop('disabled') === !1 && isEmpty('#fullname')) {
                        alertFullname()
                    } else if ($('span#dob_form_status').hasClass('default_dob') && !$('span#dob_form_status').hasClass('checked_default_dob') && type == 'submit') {
                        $('span#dob_form_status').addClass('checked_default_dob')
                    } else if (!$('span#dob_form_status').hasClass('default_dob') || ($('span#dob_form_status').hasClass('default_dob') && $('span#dob_form_status').hasClass('checked_default_dob')) || type != 'submit') {
                        $('#dob').val(function(i, val) {
                            return convertDate(val)
                        });
                        switch (type) {
                            case 'submit':
                                submitDob();
                                break;
                            case 'create':
                                createPerson();
                                break;
                            case 'edit':
                                editPerson();
                                break;
                            case 'remove':
                                removePerson();
                                break
                        }
                    }
                } else {
                    alertErase()
                }
            } else if (isSubmitted === !1) {
                restoreDobField()
            }
        } else if (!isDate($('#dob').val())) {
            alertDobField();
            if (isSubmitted === !0) {
                shakeElement('#dob')
            }
            maskDob()
        }
    } else if (isEmpty('#dob')) {
        alertDobField();
        if (isSubmitted === !0) {
            shakeElement('#dob')
        }
    }
}

function eraseDobField() {
    $.cookie('BIO:remembered_dob', null);
    $.cookie('BIO:remembered_fullname', null);
    enableFields(!0);
    restoreDobField()
}

function showFullname() {
    enableFields(!1);
    $('#dob, #help_dob').addClass('has_fullname');
    $('#dob_bar').prepend('<a tabindex="4" id="name_remove" class="m-btn green icn-only"><i class="icon-remove icon-white"></i></a><input tabindex="2" data-lang-ja="フルネーム" data-lang-zh="全名" data-lang-es="Nombre" data-lang-ru="Полное имя" data-lang-en="Full name" data-lang-vi="Họ tên" placeholder="' + fullnameText + '" id="fullname" type="text" name="fullname" size="24" maxlength="128" class="required m-wrap translate" value="' + ((isset($('#fullname').val())) ? $('#fullname').val() : '') + '" autocomplete="off" spellcheck="false" />');
    $('#name_remove').ripple();
    $('#name_toggle').remove();
    $('#fullname').trigger('focus')
}

function hideFullname() {
    $.cookie('BIO:remembered_fullname', null);
    $('#dob, #help_dob').removeClass('has_fullname');
    $('#dob_bar').prepend('<a tabindex="2" class="m-btn" id="name_toggle"><span class="translate" data-lang-ja="フルネーム" data-lang-zh="全名" data-lang-es="Nombre" data-lang-ru="Полное имя" data-lang-en="Full name" data-lang-vi="Họ tên">' + fullnameText + '</span></a>');
    $('#name_remove, #fullname').remove()
}

function helpFullname() {
    $('#help_name').text($('#fullname').val());
    if (isEmpty('#fullname')) {
        $('#help_name').addClass('empty')
    } else if (!isEmpty('#fullname')) {
        $('#help_name').removeClass('empty')
    }
}

function marqueeHeading() {
    if ($('h1#heading').textWidth() > $('h1#heading').width()) {
        $('h1#heading').css('textIndent', -($('h1#heading').textWidth() - $('h1#heading').width()) + 'px')
    } else if ($('h1#heading').textWidth() <= $('h1#heading').width()) {
        $('h1#heading').css('textIndent', '0px')
    }
}

function getRandom(min, max) {
    return Math.round(Math.random() * (max - min) + min)
}

function race(playerId) {
    var odometer = $(playerId + ' > span.timer');
    var acceleration = 0;
    var distance = 0;
    var velocity = getRandom(4, 16);
    for (time = 1; time <= 10; ++time) {
        acceleration = getRandom(-4, 8);
        velocity += acceleration * time;
        $(playerId).attrchange(function() {
            distance = parseInt($(playerId).css('left'), 10);
            odometer.html('Quãng đường: ' + distance)
        }).animate({
            left: '+=' + velocity + 'px'
        }, {
            duration: 1000,
            easing: 'linear'
        })
    }
}

function raceRandom(playerId) {
    var coreTime = 100;
    var laneLength = 800;
    var step = 8;
    var stepCount = laneLength / step;
    var players = $('.player');
    var playersCount = players.length;
    var playerRank = 0;
    var odometer = $(playerId + ' > span.timer');
    var odometerText = '';
    var distance = 0;
    var randomTimes = new Array();
    for (i = 0; i < stepCount; ++i) {
        randomTimes[i] = getRandom(getRandom(20, coreTime), getRandom(coreTime, 500))
    }
    $(playerId).attrchange(function() {
        distance = parseInt($(playerId).css('left'), 10);
        for (var i = 1; i <= laneLength; ++i) {
            if (distance == i) {
                odometer.addClass(i + 'px');
                playerRank = $('.' + i + 'px').length;
                if (playerRank == 1) {
                    $(playerId).addClass('first').removeClass('last')
                } else if (playerRank == playersCount) {
                    $(playerId).addClass('last').removeClass('first')
                } else if (playerRank > 1 && playerRank < playersCount) {
                    $(playerId).removeClass('first').removeClass('last')
                }
                odometerText = 'Hạng ' + playerRank
            }
        }
        odometer.text(odometerText)
    });
    for (i = 0; i < stepCount; ++i) {
        $(playerId).animate({
            left: '+=' + step + 'px'
        }, {
            duration: randomTimes[i],
            easing: 'linear'
        })
    }
}

function updateBanner() {
    if (!Modernizr.mq('all and (min-width: 0px) and (max-width: 959px)')) {
        $('.banner.right').load('triggers/banner.php', {
            partner: 'sfi'
        })
    }
}