function isset(variable) {
    if (typeof variable !== 'undefined' && variable !== 'undefined' && variable !== null) {
        return !0
    } else {
        return !1
    }
}

function isEmpty(selector) {
    if (!$.trim($(selector).val()).length) {
        return !0
    } else if ($.trim($(selector).val()).length) {
        return !1
    }
}

function isHovered(selector) {
    return $(selector + ':hover').length > 0
}

function isClicked(selector) {
    return $(selector + ':active').length > 0
}

function isFocused(selector) {
    return $(selector + ':focus').length > 0
}

function isBlurred(selector) {
    return $(selector + ':not(:focus)').length > 0
}

function isChild(parentSelector, childSelector) {
    if ($(parentSelector).find(childSelector).length > 0) {
        return !0
    } else if (!($(parentSelector).find(childSelector).length > 0)) {
        return !1
    }
}

function interval(duration, fn) {
    this.baseline = undefined
    this.run = function() {
        if (this.baseline === undefined) {
            this.baseline = new Date().getTime()
        }
        fn()
        var end = new Date().getTime()
        this.baseline += duration
        var nextTick = duration - (end - this.baseline)
        if (nextTick < 0) {
            nextTick = 0
        }(function(i) {
            i.timer = setTimeout(function() {
                i.run(end)
            }, nextTick)
        }(this))
    }
    this.stop = function() {
        clearTimeout(this.timer)
    }
}

function accurateInterval(func, interval, opts) {
    if (!opts) opts = {};
    var clear, nextAt, timeout, wrapper, now;
    now = new Date().getTime();
    nextAt = now;
    if (opts.aligned) {
        nextAt += interval - (now % interval)
    }
    if (!opts.immediate) {
        nextAt += interval
    }
    timeout = null;
    wrapper = function wrapper() {
        var scheduledTime = nextAt;
        nextAt += interval;
        timeout = setTimeout(wrapper, nextAt - new Date().getTime());
        func(scheduledTime)
    };
    clear = function clear() {
        return clearTimeout(timeout)
    };
    timeout = setTimeout(wrapper, nextAt - new Date().getTime());
    return {
        clear: clear
    }
}
jQuery.fn.selectText = function() {
    var doc = document;
    var element = this[0];
    console.log(this, element);
    if (doc.body.createTextRange) {
        var range = document.body.createTextRange();
        range.moveToElementText(element);
        range.select()
    } else if (window.getSelection) {
        var selection = window.getSelection();
        var range = document.createRange();
        range.selectNodeContents(element);
        selection.removeAllRanges();
        selection.addRange(range)
    }
}

function selectText(element) {
    $(element).selectText();
}

function copyToClipboard(element) {
    var $temp = $('<input>');
    $('body').append($temp);
    $temp.val($(element).text()).select();
    document.execCommand('copy');
    $temp.remove();
    switch ($('html').attr('lang')) {
        case 'vi':
            $.notify('Đã sao chép', 'success');
            break;
        case 'en':
            $.notify('Copied', 'success');
            break;
    }
}

function countChar(string, character) {
    var charRegex = new RegExp(character, 'g');
    return (string.match(charRegex) || []).length
}

function escapeRegExp(str) {
    return str.replace(/[\-\[\]\/\{\}\(\)\*\+\?\.\\\^\$\|]/g, '\\$&')
}

function replaceAll(find, replace, str) {
    return str.replace(new RegExp(escapeRegExp(find), 'g'), replace)
}

function getUrlVars() {
    var vars = [],
        hash;
    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    var hashesLength = hashes.length;
    for (var i = 0; i < hashesLength; ++i) {
        hash = hashes[i].split('=');
        vars.push(hash[0]);
        vars[hash[0]] = hash[1]
    }
    return vars
}

function dateDiff(start, end) {
    var start_ts = new Date(start);
    var end_ts = new Date(end);
    var diff = end_ts.getTime() - start_ts.getTime();
    return Math.round(diff / 86400000)
}

function isDate(txtDate) {
    var currVal = txtDate;
    if (currVal === '') {
        return !1
    }
    var rxDatePattern = /^(\d{4})(-)(\d{2})(-)(\d{2})$/;
    var dtArray = currVal.match(rxDatePattern);
    if (dtArray === null) {
        return !1
    }
    dtMonth = dtArray[3];
    dtDay = dtArray[5];
    dtYear = dtArray[1];
    if (dtMonth < 1 || dtMonth > 12) {
        return !1
    } else if (dtDay < 1 || dtDay > 31) {
        return !1
    } else if ((dtMonth == 4 || dtMonth == 6 || dtMonth == 9 || dtMonth == 11) && dtDay == 31) {
        return !1
    } else if (dtMonth == 2) {
        var isleap = (dtYear % 4 === 0 && (dtYear % 100 !== 0 || dtYear % 400 === 0));
        if (dtDay > 29 || (dtDay == 29 && !isleap)) {
            return !1
        }
    }
    return !0
}

function pad(s) {
    return (s < 10) ? '0' + s : s
}

function dateFromISO(isostr) {
    var parts = isostr.match(/\d+/g);
    return new Date(parts[0], parts[1] - 1, parts[2])
}

function convertDate(inputFormat) {
    var d = (typeof inputFormat == 'string') ? dateFromISO(inputFormat) : new Date(inputFormat);
    return [d.getFullYear(), pad(d.getMonth() + 1), pad(d.getDate())].join('-')
}

function maskInput(input, textbox, location, delimiter) {
    var locs = location.split(',');
    var locsLength = locs.length;
    var inputLength = input.length;
    for (var delimCount = 0; delimCount <= locsLength; ++delimCount) {
        for (var inputCharCount = 0; inputCharCount <= inputLength; ++inputCharCount) {
            if (inputCharCount == locs[delimCount]) {
                if (input.substring(inputCharCount, inputCharCount + 1) != delimiter) {
                    input = input.substring(0, inputCharCount) + delimiter + input.substring(inputCharCount, input.length)
                }
            }
        }
    }
    textbox.val(input)
}

function randomFromTo(from, to) {
    return Math.floor(Math.random() * (to - from + 1) + from)
}

function retDate(dateObj) {
    var formatted = '';
    var pm = !1;
    formatted = dateObj.getHours();
    if (dateObj.getMinutes() < 10) {
        formatted = formatted + ":0" + dateObj.getMinutes()
    } else {
        formatted = formatted + ":" + dateObj.getMinutes()
    }
    return formatted
}

function analogClock() {}
analogClock.prototype.run = function() {
    var date = new Date();
    var second = date.getSeconds() * 6;
    var minute = date.getMinutes() * 6 + second / 60;
    var hour = ((date.getHours() % 12) / 12) * 360 + 90 + minute / 12;
    $('#hour').css('transform', 'rotate(' + hour + 'deg)');
    $('#minute').css('transform', 'rotate(' + minute + 'deg)');
    $('#second').css('transform', 'rotate(' + second + 'deg)')
};
$.fn.textWidth = function() {
    var htmlOrg = $(this).html();
    var htmlCalc = '<span>' + htmlOrg + '</span>';
    $(this).html(htmlCalc);
    var width = $(this).find('span:first').width();
    $(this).html(htmlOrg);
    return width
};
$.fn.longTap = function(options) {
    options = $.extend({
        delay: 1000,
        onRelease: null
    }, options);
    var eventType = {
        mousedown: 'ontouchstart' in window ? 'touchstart' : 'mousedown',
        mouseup: 'ontouchend' in window ? 'touchend' : 'mouseup'
    };
    return this.each(function() {
        $(this).on(eventType.mousedown + '.longtap', function() {
            $(this).data('touchstart', +new Date)
        }).on(eventType.mouseup + '.longtap', function(e) {
            var now = +new Date,
                than = $(this).data('touchstart');
            now - than >= options.delay && options.onRelease && options.onRelease.call(this, e)
        })
    })
};
(function(H) {
    H.Series.prototype.point = {};
    H.Chart.prototype.callbacks.push(function(chart) {
        $(chart.container).bind('mousemove touchmove', function() {
            var legendOptions = chart.legend.options,
                hoverPoints = chart.hoverPoints;
            if (!hoverPoints && chart.hoverPoint) {
                hoverPoints = [chart.hoverPoint]
            }
            if (hoverPoints) {
                H.each(hoverPoints, function(point) {
                    point.series.point = point
                });
                H.each(chart.legend.allItems, function(item) {
                    item.legendItem.attr({
                        text: legendOptions.labelFormat ? H.format(legendOptions.labelFormat, item) : legendOptions.labelFormatter.call(item)
                    })
                });
                chart.legend.render()
            }
        })
    })
}(Highcharts));
q = ($('span#variables').attr('data-q') !== '') ? $('span#variables').attr('data-q') : decodeURIComponent(getUrlVars()['q']);
p = ($('span#variables').attr('data-p') !== '') ? $('span#variables').attr('data-p') : decodeURIComponent(getUrlVars()['p']);
dob = ($('span#variables').attr('data-dob') !== '') ? $('span#variables').attr('data-dob') : decodeURIComponent(getUrlVars()['dob']);
fullname = ($('span#variables').attr('data-fullname') !== '') ? $('span#variables').attr('data-fullname') : replaceAll('+', ' ', decodeURIComponent(getUrlVars()['fullname']));
givenLang = window.location.pathname.substr(1, 2);
lang = $('body').attr('lang');
dobText = '';
fullnameText = '';
dobTexts = {
    'vi': 'Ngày sinh',
    'en': 'Date of birth',
    'ru': 'Дата рождения',
    'es': 'Fecha de nacimiento',
    'zh': '出生日期',
    'ja': '生まれた日'
};
fullnameTexts = {
    'vi': 'Họ tên',
    'en': 'Full name',
    'ru': 'Полное имя',
    'es': 'Nombre',
    'zh': '全名',
    'ja': 'フルネーム'
};

function disableInput(fieldName) {
    $('#' + fieldName).on('keypress', function(e) {
        return !1
    }).on('keyup', function(e) {
        return !1
    }).on('keydown', function(e) {
        return !1
    })
}

function disableHyphen(fieldName) {
    $('#' + fieldName).on('keypress', function(e) {
        if (e.which == 45) {
            return !1
        }
    }).on('keyup', function(e) {
        if (e.which == 189 || e.which == 173 || e.which == 109) {
            return !1
        }
    }).on('keydown', function(e) {
        if (e.which == 189 || e.which == 173 || e.which == 109) {
            return !1
        }
    })
}

function updateHeadTitle(langCode) {
    ajaxData = {
        lang: langCode
    };
    if (isset($('span#variables').attr('data-q'))) {
        ajaxData.q = $('span#variables').attr('data-q')
    }
    if (isset($('span#variables').attr('data-p'))) {
        ajaxData.p = $('span#variables').attr('data-p')
    }
    if (isset($('span#variables').attr('data-dob'))) {
        ajaxData.dob = $('span#variables').attr('data-dob')
    }
    if (isset($('span#variables').attr('data-fullname'))) {
        ajaxData.fullname = $('span#variables').attr('data-fullname')
    }
    $.ajax({
        url: '/triggers/text/head_title.php',
        type: 'GET',
        cache: !1,
        data: ajaxData,
        dataType: 'text'
    }).done(function(data) {
        $('head').find('title').html(data)
    })
}

function updateHeadTitleBirthday(langCode, time) {
    ajaxData = {
        lang: langCode,
        time: time
    };
    if (isset($('span#variables').attr('data-q'))) {
        ajaxData.q = $('span#variables').attr('data-q')
    }
    if (isset($('span#variables').attr('data-dob'))) {
        ajaxData.dob = $('span#variables').attr('data-dob')
    }
    if (isset($('span#variables').attr('data-fullname'))) {
        ajaxData.fullname = $('span#variables').attr('data-fullname')
    }
    $.ajax({
        url: '/triggers/text/head_title_birthday.php',
        type: 'GET',
        cache: !1,
        data: ajaxData,
        dataType: 'text'
    }).done(function(data) {
        $('head').find('title').html(data)
    })
}

function updateHeadingH1(langCode) {
    ajaxData = {
        lang: langCode
    };
    if (isset($('span#variables').attr('data-q'))) {
        ajaxData.q = $('span#variables').attr('data-q')
    }
    if (isset($('span#variables').attr('data-p'))) {
        ajaxData.p = $('span#variables').attr('data-p')
    }
    if (isset($('span#variables').attr('data-dob'))) {
        ajaxData.dob = $('span#variables').attr('data-dob')
    }
    if (isset($('span#variables').attr('data-fullname'))) {
        ajaxData.fullname = $('span#variables').attr('data-fullname')
    }
    $.ajax({
        url: '/triggers/text/heading_h1.php',
        type: 'GET',
        cache: !1,
        data: ajaxData,
        dataType: 'text'
    }).done(function(data) {
        $('h1#heading').html(data)
    })
}

function updateHeadingH1Birthday(langCode, time) {
    ajaxData = {
        lang: langCode,
        time: time
    };
    if (isset($('span#variables').attr('data-q'))) {
        ajaxData.q = $('span#variables').attr('data-q')
    }
    if (isset($('span#variables').attr('data-dob'))) {
        ajaxData.dob = $('span#variables').attr('data-dob')
    }
    if (isset($('span#variables').attr('data-fullname'))) {
        ajaxData.fullname = $('span#variables').attr('data-fullname')
    }
    $.ajax({
        url: '/triggers/text/heading_h1_birthday.php',
        type: 'GET',
        cache: !1,
        data: ajaxData,
        dataType: 'text'
    }).done(function(data) {
        $('h1#heading').html(data)
    })
}

function updateHeadDescription(langCode) {
    ajaxData = {
        lang: langCode
    };
    if (isset($('span#variables').attr('data-q'))) {
        ajaxData.q = $('span#variables').attr('data-q')
    }
    if (isset($('span#variables').attr('data-dob'))) {
        ajaxData.dob = $('span#variables').attr('data-dob')
    }
    if (isset($('span#variables').attr('data-fullname'))) {
        ajaxData.fullname = $('span#variables').attr('data-fullname')
    }
    $.ajax({
        url: '/triggers/text/head_description.php',
        type: 'GET',
        cache: !1,
        data: ajaxData,
        dataType: 'text'
    }).done(function(data) {
        $('head').find('meta[name="description"]').attr('content', data)
    })
}

function updateHeadDescriptionBirthday(langCode, time) {
    ajaxData = {
        lang: langCode,
        time: time
    };
    if (isset($('span#variables').attr('data-q'))) {
        ajaxData.q = $('span#variables').attr('data-q')
    }
    if (isset($('span#variables').attr('data-dob'))) {
        ajaxData.dob = $('span#variables').attr('data-dob')
    }
    if (isset($('span#variables').attr('data-fullname'))) {
        ajaxData.fullname = $('span#variables').attr('data-fullname')
    }
    $.ajax({
        url: '/triggers/text/head_description_birthday.php',
        type: 'GET',
        cache: !1,
        data: ajaxData,
        dataType: 'text'
    }).done(function(data) {
        $('head').find('meta[name="description"]').attr('content', data)
    })
}

function updateInputInterface(inputId, langCode) {
    ajaxData = {
        input_id: inputId,
        lang: langCode
    };
    $.ajax({
        url: '/triggers/text/input_interface.php',
        type: 'GET',
        cache: !1,
        data: ajaxData,
        dataType: 'text'
    }).done(function(data) {
        $('input[id="' + inputId + '"].translate').attr('placeholder', data)
    })
}

function updateButtonInterface(buttonId, langCode) {
    ajaxData = {
        button_id: buttonId,
        lang: langCode
    };
    $.ajax({
        url: '/triggers/text/button_interface.php',
        type: 'GET',
        cache: !1,
        data: ajaxData,
        dataType: 'text'
    }).done(function(data) {
        $('a[id="' + buttonId + '"].translate').find('span').html(data)
    })
}

function updateChromeWebstoreItem(langCode) {
    ajaxData = {
        lang: langCode
    };
    $.ajax({
        url: '/triggers/text/chrome_webstore_item.php',
        type: 'GET',
        cache: !1,
        data: ajaxData,
        dataType: 'text'
    }).done(function(data) {
        $('link[rel="chrome-webstore-item"]').attr('href', data)
    })
}

function updateExplanation(langCode) {
    if ($('#explanation').length) {
        $.ajax({
            url: '/triggers/html/explanation.php',
            type: 'GET',
            cache: !1,
            data: {
                lang: langCode
            },
            dataType: 'html'
        }).done(function(data) {
            $('#explanation').html(data)
        })
    }
}

function updateIntroduction(langCode) {
    if ($('#introduction').length) {
        $.ajax({
            url: '/triggers/html/intro.php',
            type: 'GET',
            cache: !1,
            data: {
                lang: langCode
            },
            dataType: 'html'
        }).done(function(data) {
            $('#introduction').html(data)
        })
    }
}

function updateProverbsList(langCode) {
    if ($('#proverbs_wrapper').length) {
        $.ajax({
            url: '/triggers/html/proverbs_list.php',
            type: 'GET',
            cache: !1,
            data: {
                page: '1',
                lang: langCode
            },
            dataType: 'html'
        }).done(function(data) {
            $('#proverbs_wrapper').html(data)
        })
    }
}

function updateTextInterface(langCode) {
    ajaxData = {
        lang: langCode
    };
    if (isset($('span#variables').attr('data-q'))) {
        ajaxData.q = $('span#variables').attr('data-q')
    }
    if (isset($('span#variables').attr('data-p'))) {
        ajaxData.p = $('span#variables').attr('data-p')
    }
    if (isset($('span#variables').attr('data-dob'))) {
        ajaxData.dob = $('span#variables').attr('data-dob')
    }
    if (isset($('span#variables').attr('data-fullname'))) {
        ajaxData.fullname = $('span#variables').attr('data-fullname')
    }
    var headTitleAjaxCall = $.ajax({
            url: '/triggers/text/head_title.php',
            type: 'GET',
            cache: !1,
            data: ajaxData,
            dataType: 'text'
        }),
        headingH1AjaxCall = $.ajax({
            url: '/triggers/text/heading_h1.php',
            type: 'GET',
            cache: !1,
            data: ajaxData,
            dataType: 'text'
        }),
        headDescriptionAjaxCall = $.ajax({
            url: '/triggers/text/head_description.php',
            type: 'GET',
            cache: !1,
            data: ajaxData,
            dataType: 'text'
        }),
        chromeWebstoreItemAjaxCall = $.ajax({
            url: '/triggers/text/chrome_webstore_item.php',
            type: 'GET',
            cache: !1,
            data: ajaxData,
            dataType: 'text'
        }),
        youtubeAjaxCall = $.ajax({
            url: '/triggers/text/youtube.php',
            type: 'GET',
            cache: !1,
            data: ajaxData,
            dataType: 'text'
        });
    $.when(headTitleAjaxCall, headingH1AjaxCall, headDescriptionAjaxCall, chromeWebstoreItemAjaxCall, youtubeAjaxCall).done(function(headTitleAjaxResponse, headingH1AjaxResponse, headDescriptionAjaxResponse, chromeWebstoreItemAjaxResponse, youtubeAjaxResponse) {
        $('head').find('title').html(headTitleAjaxResponse[0]);
        $('h1#heading').html(headingH1AjaxResponse[0]);
        $('head').find('meta[name="description"]').attr('content', headDescriptionAjaxResponse[0]);
        $('link[rel="chrome-webstore-item"]').attr('href', chromeWebstoreItemAjaxResponse[0]);
        $('#youtube').find('iframe').attr('src', 'https://www.youtube.com/embed/' + youtubeAjaxResponse[0])
    })
}

function updateBirthdayTextInterface(langCode, time) {
    ajaxData = {
        lang: langCode,
        time: time
    };
    if (isset($('span#variables').attr('data-q'))) {
        ajaxData.q = $('span#variables').attr('data-q')
    }
    if (isset($('span#variables').attr('data-dob'))) {
        ajaxData.dob = $('span#variables').attr('data-dob')
    }
    if (isset($('span#variables').attr('data-fullname'))) {
        ajaxData.fullname = $('span#variables').attr('data-fullname')
    }
    var headTitleBirthdayAjaxCall = $.ajax({
            url: '/triggers/text/head_title_birthday.php',
            type: 'GET',
            cache: !1,
            data: ajaxData,
            dataType: 'text'
        }),
        headingH1BirthdayAjaxCall = $.ajax({
            url: '/triggers/text/heading_h1_birthday.php',
            type: 'GET',
            cache: !1,
            data: ajaxData,
            dataType: 'text'
        }),
        headDescriptionBirthdayAjaxCall = $.ajax({
            url: '/triggers/text/head_description_birthday.php',
            type: 'GET',
            cache: !1,
            data: ajaxData,
            dataType: 'text'
        });
    $.when(headTitleBirthdayAjaxCall, headingH1BirthdayAjaxCall, headDescriptionBirthdayAjaxCall).done(function(headTitleBirthdayAjaxResponse, headingH1BirthdayAjaxResponse, headDescriptionBirthdayAjaxResponse) {
        $('head').find('title').html(headTitleBirthdayAjaxResponse[0]);
        $('h1#heading').html(headingH1BirthdayAjaxResponse[0]);
        $('head').find('meta[name="description"]').attr('content', headDescriptionBirthdayAjaxResponse[0])
    })
}

function updateElementLanguage(langCode) {
    $('#pham_tung').find('span.translate').attr('data-title', $('#pham_tung').find('span.translate').attr('data-lang-' + langCode));
    $('span.translate').each(function() {
        if ($(this).parent().hasClass('html')) {
            $(this).html($(this).attr('data-lang-' + langCode))
        } else {
            $(this).text($(this).attr('data-lang-' + langCode))
        }
    });
    $('input.translate').each(function() {
        $(this).text($(this).attr('data-lang-' + langCode)).attr('placeholder', $(this).attr('data-lang-' + langCode))
    });
    $('input[type="submit"].translate').each(function() {
        $(this).val($(this).attr('data-lang-' + langCode))
    });
    $('label.placeholder').each(function() {
        $(this).text($(this).next().attr('data-lang-' + langCode))
    })
}

function updateInterfaceLanguage(langCode) {
    var langCodes = ['vi', 'en', 'ru', 'es', 'zh', 'ja'];
    var langCodeIndex = $.inArray(langCode, langCodes);
    if ($('#lang_bar').length && langCodeIndex != -1) {
        langCodes.splice(langCodeIndex, 1);
        remainingLangCodeIds = '';
        remainingLangCodesCount = langCodes.length;
        for (i = 0; i < remainingLangCodesCount; ++i) {
            remainingLangCodeIds += '#' + langCodes[i] + '_toggle';
            if (i < remainingLangCodesCount - 1) {
                remainingLangCodeIds += ', '
            }
        }
        $('#' + langCode + '_toggle').addClass('clicked').addClass('disabled');
        $(remainingLangCodeIds).removeClass('clicked').removeClass('disabled');
        updateTextInterface(langCode);
        updateExplanation(langCode);
        updateIntroduction(langCode);
        updateProverbsList(langCode);
        updateElementLanguage(langCode);
        $('#explanation').attr('data-lang', langCode);
        $('html, body').attr('lang', langCode);
        $.cookie('BIO:lang', langCode);
        $(document).ready(function() {
            $.datepicker.setDefaults($.datepicker.regional[langCode]);
            $('.hasDatepicker').each(function() {
                $(this).datepicker('hide')
            })
        })
    }
}

function loadResults(dob, diff, isSecondary, dtChange, partnerDob, langCode) {
    if ($('#ajax-chart').length && $('#ajax-info').length) {
        ajaxData = {
            dob: dob,
            diff: diff,
            is_secondary: isSecondary,
            dt_change: dtChange,
            partner_dob: partnerDob,
            lang_code: langCode
        };
        var chartAjaxCall = $.ajax({
                url: $('#baseUrl').val() + '/templates/chart.tpl.php',
                type: 'GET',
                cache: false,
                data: ajaxData
            }),
            infoAjaxCall = $.ajax({
                url: $('#baseUrl').val() + '/templates/info.tpl.php',
                type: 'GET',
                cache: false,
                data: ajaxData
            });
        $.when(chartAjaxCall, infoAjaxCall).done(function(chartAjaxResponse, infoAjaxResponse) {
            $('#ajax-chart').html(chartAjaxResponse[0]);
            $('#ajax-info').html(infoAjaxResponse[0]);
            var date = new Date(dtChange);
            var dateString = moment(date);
            dateString.locale(langCode);
            $.notify(dateString.format('LL'), 'info');
        });
    }
}

function loadExplanationChartResults(dob, diff, isSecondary, dtChange, partnerDob, langCode) {
    if ($('#explanation_chart_results').length) {
        $.ajax({
            url: '/triggers/html/explanation_chart_results.php',
            type: 'GET',
            cache: !1,
            data: {
                dob: dob,
                diff: diff,
                is_secondary: isSecondary,
                dt_change: dtChange,
                partner_dob: partnerDob,
                lang_code: langCode
            },
            dataType: 'html'
        }).done(function(data) {
            var date = new Date(dtChange);
            var dateString = moment(date);
            dateString.locale(langCode);
            $.notify(dateString.format('LLLL'));
            $('#explanation_chart_results').html(data)
        })
    }
}

function loadEmbedChartResults(dob, diff, isSecondary, dtChange, partnerDob, langCode) {
    if ($('#embed_chart_results').length) {
        $.ajax({
            url: '/triggers/html/embed_chart_results.php',
            type: 'GET',
            cache: !1,
            data: {
                dob: dob,
                diff: diff,
                is_secondary: isSecondary,
                dt_change: dtChange,
                partner_dob: partnerDob,
                lang_code: langCode
            },
            dataType: 'html'
        }).done(function(data) {
            var date = new Date(dtChange);
            var dateString = moment(date);
            dateString.locale(langCode);
            $.notify(dateString.format('LLLL'));
            $('#embed_chart_results').html(data)
        })
    }
}

function loadProverb(langCode) {
    if ($('#proverb').length) {
        $.ajax({
            url: $('#baseUrl').val() + '/templates/proverb_json.tpl.php',
            type: 'GET',
            cache: !1,
            data: {
                lang_code: langCode
            },
            dataType: 'json'
        }).done(function(data) {
            $('#proverb').find('#proverb_text').children('span.content').text(data.content);
            $('#proverb').find('#proverb_author').text(data.author);
            switch (langCode) {
                case 'vi':
                    $.notify('Thành ngữ mới', 'success');
                    break;
                case 'en':
                    $.notify('New proverb', 'success');
                    break;
            }
        })
    }
}

function loadNews(langCode) {
    if ($('#news').length) {
        $.ajax({
            url: '/triggers/html/news.php',
            type: 'GET',
            cache: !1,
            global: !1,
            data: {
                lang_code: langCode
            },
            dataType: 'html'
        }).done(function(data) {
            $('#news ul').html(data)
        })
    }
}

function loadComments(langCode) {
    if ($('#comments').length) {
        if (window.FB) {
            $('#facebook-jssdk, #fb-root').remove();
            delete window.FB
        }
        $.ajax({
            url: '/triggers/html/comments.php',
            type: 'GET',
            cache: !1,
            global: !1,
            data: {
                lang_code: langCode
            },
            dataType: 'html'
        }).done(function(data) {
            $('#comments').html(data)
        })
    }
}

function loadFeed(url, id) {
    if ($('#' + id).length) {
        $.ajax({
            url: '/triggers/html/feed.php',
            type: 'GET',
            cache: !1,
            data: {
                url: url
            },
            dataType: 'html'
        }).done(function(data) {
            $('#' + id).find('div.feed').html(data)
        })
    }
}

function loadHash(password) {
    $.ajax({
        url: '/triggers/text/hash.php',
        type: 'POST',
        cache: !1,
        data: {
            unhashed: password
        },
        dataType: 'text'
    }).done(function(data) {
        $('#hashed').val(data)
    })
}

function searchBirthdates(keyword) {
    if ($('#birthdates').length) {
        $.ajax({
            url: '/triggers/html/birthdates.php',
            type: 'GET',
            cache: !1,
            data: {
                keyword: keyword
            },
            dataType: 'html'
        }).done(function(data) {
            $('#birthdates').html(data)
        })
    }
}

function showBirthdates() {
    if ($('#birthdates').length) {
        $.ajax({
            url: '/triggers/html/birthdates.php',
            type: 'GET',
            cache: !1,
            dataType: 'html'
        }).done(function(data) {
            $('#birthdates').html(data).show();
            if (!isEmpty('#user_birthdates_search')) {
                searchBirthdates($('#user_birthdates_search').val())
            }
        })
    }
}

function hideBirthdates() {
    $('#birthdates').html('').hide()
}

function toggleFade(selector, state) {
    switch (state) {
        case 'show':
            $(selector).addClass('fade_toggle');
            break;
        case 'hide':
            $(selector).removeClass('fade_toggle');
            break;
        default:
            break
    }
}

function checkFade(selector) {
    if ($(selector).hasClass('fade_toggle')) {
        return 'show'
    } else if (!$(selector).hasClass('fade_toggle')) {
        return 'hide'
    }
}

function toggleCookie(cookieName, objectSelector, toggleSelector, containerSelector) {
    if (!isset($.cookie(cookieName))) {
        if (checkFade(objectSelector) == 'hide' && !$(toggleSelector).hasClass('clicked')) {
            $(toggleSelector).addClass('clicked');
            $.cookie(cookieName, 'hide')
        } else if (checkFade(objectSelector) == 'show' && $(toggleSelector).hasClass('clicked')) {
            $(toggleSelector).removeClass('clicked');
            $.cookie(cookieName, 'show')
        }
    }
    if ($.cookie(cookieName) == 'show') {
        toggleFade(objectSelector, 'show');
        $(toggleSelector).addClass('clicked')
    } else if ($.cookie(cookieName) == 'hide') {
        toggleFade(objectSelector, 'hide');
        $(toggleSelector).removeClass('clicked')
    }
    $(containerSelector).on('click', toggleSelector, function() {
        if (checkFade(objectSelector) == 'hide' && !$(toggleSelector).hasClass('clicked')) {
            toggleFade(objectSelector, 'show');
            $(toggleSelector).addClass('clicked');
            $.cookie(cookieName, 'show')
        } else if (checkFade(objectSelector) == 'show' && $(toggleSelector).hasClass('clicked')) {
            toggleFade(objectSelector, 'hide');
            $(toggleSelector).removeClass('clicked');
            $.cookie(cookieName, 'hide')
        }
    })
}

function toggleRhythm(chartSelector, rhythmId, type) {
    var chart = $(chartSelector).highcharts();
    var series = chart.series[rhythmId];
    var cookieName = 'BIO:rhythm-' + type + '-id-' + rhythmId;
    if (!isset($.cookie(cookieName))) {
        if (!series.visible) {
            $.cookie(cookieName, 'hide')
        } else if (series.visible) {
            $.cookie(cookieName, 'show')
        }
    }
    if ($.cookie(cookieName) == 'show') {
        series.show()
    } else if ($.cookie(cookieName) == 'hide') {
        series.hide()
    }
}

function toggleRhythms(chartSelector, type) {
    var chart = $(chartSelector).highcharts();
    var seriesCount = chart.series.length;
    for (i = 0; i < seriesCount; ++i) {
        toggleRhythm(chartSelector, i, type)
    }
}

function generatePlotLines(todayIndex) {
    var plotLinesArray = [];
    plotLinesArray.push({
        color: '#c0c0c0',
        width: 4,
        value: 14,
        zIndex: 2
    });
    for (var i = 0; i <= 13; ++i) {
        plotLinesArray.push({
            color: '#e0e0c0',
            width: 2,
            value: i,
            zIndex: 1
        }, {
            color: '#c0e0e0',
            width: 2,
            value: i + 15,
            zIndex: 1
        })
    }
    if (todayIndex >= 0 && todayIndex <= 28 && todayIndex !== '') {
        plotLinesArray.push({
            color: '#c0e0c0',
            width: 4,
            value: todayIndex,
            zIndex: 2
        })
    }
    return plotLinesArray
}

function setChartOptions(viewFullscreenText, downloadJPEGText, downloadPDFText, downloadPNGText, downloadSVGText, printChartText, resetZoomText) {
    Highcharts.setOptions({
        global: {
            canvasToolsURL: "http://nhipsinhhoc.vn/js/highcharts/modules/canvas-tools.js"
        },
        lang: {
            viewFullscreen: viewFullscreenText,
            downloadJPEG: downloadJPEGText,
            downloadPDF: downloadPDFText,
            downloadPNG: downloadPNGText,
            downloadSVG: downloadSVGText,
            printChart: printChartText,
            resetZoom: resetZoomText
        }
    })
}

function getLegendItemWidth() {
    switch ($('body').attr('lang')) {
        case 'vi':
            return 140;
            break;
        case 'en':
            return 140;
            break;
        case 'ru':
            return 190;
            break;
        case 'es':
            return 140;
            break;
        case 'zh':
            return 120;
            break;
        case 'ja':
            return 130;
            break
    }
}

function renderChart(selector, titleText, percentageText, dateText, datesArray, todayIndex, dob, diff, isSecondary, dateDiff, seriesData, type) {
    var plotLinesArray = generatePlotLines(todayIndex);
    var chart = $(selector);
    chart.highcharts({
        chart: {
            type: 'spline',
            style: {
                fontFamily: 'Muli, sans-serif'
            }
        },
        colors: ['#a3abbe', '#ef7955', '#4fc281', '#4b98dc', '#81d8d1', '#5c95cc', '#434348', '#90ed7d', '#f7a35c', '#7075d9'],
        credits: {
            href: 'https://biorhythm.xyz/',
            text: 'Biorhythm . XYZ',
            position: {
                align: 'right',
                x: -10,
                verticalAlign: 'bottom',
                y: -10
            }
        },
        exporting: {
            url: 'https://export.highcharts.com/'
        },
        title: {
            text: titleText
        },
        navigation: {
            buttonOptions: {
                theme: {
                    stroke: '#e2e2e2',
                    r: 0,
                    states: {
                        hover: {
                            stroke: '#c2c2c2',
                            fill: '#d2d2d2'
                        },
                        select: {
                            stroke: '#a2a2a2',
                            fill: '#b2b2b2'
                        }
                    }
                }
            },
            menuItemStyle: {
                fontWeight: 'bold',
                fontSize: '12px'
            },
            menuItemHoverStyle: {
                background: '#848484',
                color: '#e5e5e5',
                fontWeight: 'bold',
                fontSize: '12px'
            }
        },
        yAxis: {
            title: {
                text: percentageText + ' (%)'
            },
            min: 0,
            max: 100,
            maxPadding: 0,
            tickInterval: 10,
            plotLines: [{
                color: '#c0c0c0',
                width: 4,
                value: 50
            }]
        },
        xAxis: {
            categories: datesArray,
            tickmarkPlacement: 'on',
            tickPosition: 'inside',
            tickColor: 'transparent',
            tickPixelInterval: 50,
            labels: {
                rotation: -45,
                x: 0
            },
            type: 'datetime',
            plotBands: [{
                color: '#ffffe0',
                from: 0,
                to: 14
            }, {
                color: '#e0ffff',
                from: 14,
                to: 28
            }],
            plotLines: plotLinesArray,
            crosshair: {
                color: '#e0c0c0',
                dashStyle: 'solid',
                width: 4,
                snap: !0
            }
        },
        tooltip: {
            enabled: !0,
            shared: !0,
            followPointer: !1,
            backgroundColor: 'rgba(250,250,250,0.84)',
            borderColor: '#c0c0c0',
            borderRadius: 4,
            snap: 4,
            useHTML: !0,
            headerFormat: '<strong><u>' + dateText + ': {point.key}</u></strong><table id="rhythms_table">',
            pointFormat: '<tr class="rhythm_value" id="rhythm_id_{series.index}"><td class="rhythm_label"><span style="color: {series.color}">{series.name}:</span></td><td class="value"><span style="color: {series.color}"><strong>{point.y} %<strong></span></td></tr>',
            footerFormat: '</table>'
        },
        legend: {
            enabled: !0,
            align: 'center',
            itemWidth: null,
            labelFormat: '<span style="color:{color}">{name}: </span><strong>{point.y} %</strong>'
        },
        plotOptions: {
            line: {
                dataLabels: {
                    enabled: !1
                },
                enableMouseTracking: !0
            },
            series: {
                animation: !1,
                stickyTracking: !1,
                cursor: 'pointer',
                lineWidth: 3,
                events: {
                    legendItemClick: function(e) {
                        e.preventDefault();
                        if (!this.visible) {
                            this.show();
                            $.cookie('BIO:rhythm-' + type + '-id-' + this.index, 'show');
                            $('i.rhythm_toggle[data-rhythm-id="' + this.index + '"]').removeClass('icon-unchecked').addClass('icon-check')
                        } else if (this.visible) {
                            this.hide();
                            $.cookie('BIO:rhythm-' + type + '-id-' + this.index, 'hide');
                            $('i.rhythm_toggle[data-rhythm-id="' + this.index + '"]').removeClass('icon-check').addClass('icon-unchecked')
                        }
                    }
                },
                marker: {
                    radius: 2,
                    fillColor: null,
                    lineWidth: 2,
                    lineColor: '#fff',
                    symbol: 'circle',
                    enabled: !1,
                    states: {
                        hover: {
                            enabled: !0
                        }
                    }
                },
                states: {
                    hover: {
                        halo: null
                    }
                },
                point: {
                    events: {
                        click: function() {
                            loadResults(dob, diff + this.x - 14, isSecondary, convertDate(+new Date(dateDiff) + (this.x - 14) * 864e5), dob, $('html').attr('lang'));
                        },
                        mouseOver: function() {
                            $('#rhythm_id_' + this.series.index).addClass('rhythm_hover');
                            $('#rhythm_id_' + this.series.index).find('td.value').find('span').css('color', this.series.color)
                        },
                        mouseOut: function() {
                            $('#rhythm_id_' + this.series.index).removeClass('rhythm_hover');
                            $('#rhythm_id_' + this.series.index).find('td.value').find('span').css('color', 'black')
                        }
                    }
                }
            }
        },
        series: seriesData
    });
    $('.highcharts-xaxis-labels').find('text').on('click', function() {
        var labelText = this.textContent || this.innerText;
        var x = datesArray.indexOf(labelText);
        loadResults(dob, diff + x - 14, isSecondary, convertDate(+new Date(dateDiff) + (x - 14) * 864e5), dob, $('html').attr('lang'));
    });
    if (type == 'main') {
        chart = $(selector).highcharts();
        $('i.rhythm_toggle').each(function() {
            id = $(this).attr('data-rhythm-id');
            series = chart.series[id];
            if (series.visible) {
                series.show();
                $.cookie('BIO:rhythm-' + type + '-id-' + id, 'show');
                $(this).removeClass('icon-unchecked').addClass('icon-check')
            } else if (!series.visible) {
                series.hide();
                $.cookie('BIO:rhythm-' + type + '-id-' + id, 'hide');
                $(this).removeClass('icon-check').addClass('icon-unchecked')
            }
        });
        $('i.rhythm_toggle').on('click', function() {
            id = $(this).attr('data-rhythm-id');
            series = chart.series[id];
            if (!series.visible) {
                series.show();
                $.cookie('BIO:rhythm-' + type + '-id-' + id, 'show');
                $(this).removeClass('icon-unchecked').addClass('icon-check')
            } else if (series.visible) {
                series.hide();
                $.cookie('BIO:rhythm-' + type + '-id-' + id, 'hide');
                $(this).removeClass('icon-check').addClass('icon-unchecked')
            }
        })
    }
}

function createPerson() {
    if ($('body').hasClass('member')) {
        ajaxData = {
            fullname: $('input[name="person_fullname"]').val(),
            dob: $('input[name="person_dob"]').val()
        };
        $.ajax({
            url: '/triggers/person_create.php',
            type: 'POST',
            cache: !1,
            data: ajaxData,
            dataType: 'text'
        }).done(function(lastId) {
            $.ajax({
                url: '/triggers/html/person_list.php',
                type: 'GET',
                cache: !1,
                dataType: 'html'
            }).done(function(data) {
                $('#persons_list').html(data);
                window.location = $('#my_birthdate').attr('href') + '?pid=' + lastId
            })
        })
    }
}

function editPerson() {
    if ($('body').hasClass('member')) {
        ajaxData = {
            pid: decodeURIComponent(getUrlVars()['pid']),
            fullname: $('input[name="person_fullname"]').val(),
            dob: $('input[name="person_dob"]').val()
        };
        $.ajax({
            url: '/triggers/person_edit.php',
            type: 'POST',
            cache: !1,
            data: ajaxData,
            dataType: 'text'
        }).done(function() {
            $.ajax({
                url: '/triggers/html/person_list.php',
                type: 'GET',
                cache: !1,
                dataType: 'html'
            }).done(function(data) {
                $('#persons_list').html(data);
                window.location = $('#my_birthdate').attr('href') + '?pid=' + decodeURIComponent(getUrlVars()['pid'])
            })
        })
    }
}

function removePerson() {
    if ($('body').hasClass('member')) {
        ajaxData = {
            pid: decodeURIComponent(getUrlVars()['pid'])
        };
        $.ajax({
            url: '/triggers/person_remove.php',
            type: 'POST',
            cache: !1,
            data: ajaxData,
            dataType: 'text'
        }).done(function() {
            $.ajax({
                url: '/triggers/html/person_list.php',
                type: 'GET',
                cache: !1,
                dataType: 'html'
            }).done(function(data) {
                $('#persons_list').html(data);
                window.location = $('#my_birthdate').attr('href')
            })
        })
    }
}