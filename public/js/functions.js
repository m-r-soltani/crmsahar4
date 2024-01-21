function ajaxForms(e, form, callback = false) {
    e.preventDefault();
    let formbutton = form.find("button[type=submit]");
    let buttonname = formbutton.prop('name');
    let url = window.location.href.split('/').slice(-1)[0];
    // let aa=form.serialize();
    let data=form.serialize();
    // console.log(aa);
    // let data = form.serializeArray();
    console.log(data);
    formbutton.prop("disabled", true);
    $.ajax({
        type: 'post',
        'url': url,
        'Content-Type': 'application/json; charset=utf-8',
        timeout: 12000,
        data: {
            [buttonname]: data,
        },
        dataType: "json",
        success: function(response) {
            formbutton.prop("disabled", false);
            console.log(response);
            if (callback === false) {
                if (check_isset_message(response)) {
                    display_Predefiend_Messages(response);
                }
            } else {
                callback(response);
            }
        },
        error: function(x, e) {
            if (x.status == 0) {
                Custom_Modal_Show('d', `<div class="font-weight-bold">لطفا دسترسی خود را به اینترنت بررسی فرمایید.</div>`);
            } else if (x.status == 404) {
                Custom_Modal_Show('w', `<div class="font-weight-bold">خطایی در برنامه رخ داده مجددا تلاش کنید و یا با پشتیبانی تماس بگیرید</div>`);
            } else if (x.status == 500) {
                Custom_Modal_Show('d', `<div class="font-weight-bold">اررور داخلی سرور.</div>`);
            } else if (e == 'parsererror') {
                Custom_Modal_Show('w', `<div class="font-weight-bold">درخواست ارسال شد اما پاسخی از سرور دریافت نشده.</div>`);
            } else if (e == 'timeout') {
                Custom_Modal_Show('d', `<div class="font-weight-bold">درخواست شما بیش از حد مجاز طول کشید.</div>`);
            } else {
                alert('اررور نامشخص.\n' + x.responseText);
            }
        },
        complete: function(s) {
            formbutton.prop("disabled", false);
        }
    });
}



function ajaxFormsWithConfirm(e, form, callback = false) {
    e.preventDefault();
    if (confirm('از انجام این کار مطمعن هستید؟')) {
        let formbutton = form.find("button[type=submit]");
        let buttonname = formbutton.prop('name');
        let url = window.location.href.split('/').slice(-1)[0];
        // let aa=form.serialize();
        let data=form.serialize();
        // console.log(aa);
        // let data = form.serializeArray();
        console.log(data);
        formbutton.prop("disabled", true);
        
        // var formData = new FormData(form);
        formbutton.prop("disabled", true);
        $.ajax({
            type: 'post',
            'url': url,
            'Content-Type': 'application/json; charset=utf-8',
            timeout: 12000,
            data: {
                [buttonname]: data,
            },
            dataType: "json",
            success: function(response) {
                formbutton.prop("disabled", false);
                console.log(response);
                if (callback === false) {
                    if (check_isset_message(response)) {
                        display_Predefiend_Messages(response);
                    }
                } else {
                    callback(response);
                }
            },
            error: function(x, e) {
                if (x.status == 0) {
                    Custom_Modal_Show('d', `<div class="font-weight-bold">لطفا دسترسی خود را به اینترنت بررسی فرمایید.</div>`);
                } else if (x.status == 404) {
                    Custom_Modal_Show('w', `<div class="font-weight-bold">خطایی در برنامه رخ داده مجددا تلاش کنید و یا با پشتیبانی تماس بگیرید</div>`);
                } else if (x.status == 500) {
                    Custom_Modal_Show('d', `<div class="font-weight-bold">اررور داخلی سرور.</div>`);
                } else if (e == 'parsererror') {
                    Custom_Modal_Show('w', `<div class="font-weight-bold">درخواست ارسال شد اما پاسخی از سرور دریافت نشده.</div>`);
                } else if (e == 'timeout') {
                    Custom_Modal_Show('d', `<div class="font-weight-bold">درخواست شما بیش از حد مجاز طول کشید.</div>`);
                } else {
                    alert('اررور نامشخص.\n' + x.responseText);
                }
            },
            complete: function(s) {
                formbutton.prop("disabled", false);
            }
        });
    }
}
// function ajaxFormsWithConfirm(e, form, callback = false) {
//     e.preventDefault();
//     if (confirm('از انجام این کار مطمعن هستید؟')) {
//         let formbutton = form.find("button[type=submit]");
//         let buttonname = formbutton.prop('name');
//         let url = window.location.href.split('/').slice(-1)[0];
        
//         let data = form.serializeArray();
        
//         // var formData = new FormData(form);
//         formbutton.prop("disabled", true);
//         $.ajax({
//             type: 'post',
//             'url': url,
//             'Content-Type': 'application/json; charset=utf-8',
//             timeout: 12000,
//             data: {
//                 [buttonname]: data,
//             },
//             dataType: "json",
//             success: function(response) {
//                 formbutton.prop("disabled", false);
//                 console.log(response);
//                 if (callback === false) {
//                     if (check_isset_message(response)) {
//                         display_Predefiend_Messages(response);
//                     }
//                 } else {
//                     callback(response);
//                 }
//             },
//             error: function(x, e) {
//                 if (x.status == 0) {
//                     Custom_Modal_Show('d', `<div class="font-weight-bold">لطفا دسترسی خود را به اینترنت بررسی فرمایید.</div>`);
//                 } else if (x.status == 404) {
//                     Custom_Modal_Show('w', `<div class="font-weight-bold">خطایی در برنامه رخ داده مجددا تلاش کنید و یا با پشتیبانی تماس بگیرید</div>`);
//                 } else if (x.status == 500) {
//                     Custom_Modal_Show('d', `<div class="font-weight-bold">اررور داخلی سرور.</div>`);
//                 } else if (e == 'parsererror') {
//                     Custom_Modal_Show('w', `<div class="font-weight-bold">درخواست ارسال شد اما پاسخی از سرور دریافت نشده.</div>`);
//                 } else if (e == 'timeout') {
//                     Custom_Modal_Show('d', `<div class="font-weight-bold">درخواست شما بیش از حد مجاز طول کشید.</div>`);
//                 } else {
//                     alert('اررور نامشخص.\n' + x.responseText);
//                 }
//             },
//             complete: function(s) {
//                 formbutton.prop("disabled", false);
//             }
//         });
//     }
// }

function ajaxRequest(request, data = [], url = window.location.href.split('/').slice(-1)[0], callback) {
    $.ajax({
        type: "post",
        url: url,
        timeout: 12000,
        // dataType: "json",
        data: {
            [request]: data
        },
        success: function(response) {
            response = JSON.parse(response);
            console.log(response);
            return callback(response);
        },
        error: function(req, res, status) {
            return callback(false);
        }
    });
}

function thisPage() {
    return window.location.href.split('/').slice(-1)[0];
}

function isNumberKey(evt) {
    var charCode = (evt.which) ? evt.which : evt.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}

function thousandCommaSep(target){
    target.keyup(function(event) {
        if (event.which >= 37 && event.which <= 40) return;
        $(this).val(function(index, value) {
          return value
            // Keep only digits and decimal points:
            .replace(/[^\d.]/g, "")
            // Remove duplicated decimal point, if one exists:
            .replace(/^(\d*\.)(.*)\.(.*)$/, '$1$2$3')
            // Keep only two digits past the decimal point:
            .replace(/\.(\d{2})\d+/, '.$1')
            // Add thousands separators:
            .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
        });
      });
}

function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

function resetId(elem) {
    $("#id").val("empty");
}

function pageName(currentwindow) {
    return currentwindow.location.href.split('/').slice(-1)[0];
}

function isEmpty(str) {
    if (!str || str.length === 0 || str === 'undefined') {
        return true;
    } else {
        return false;
    }
}

function secondsToTime(SECONDS = 0) {
    return new Date(SECONDS * 1000).toISOString().substr(11, 8);
}

function startTimer(duration, display) {
    var timer = duration,
        minutes, seconds;
    setInterval(function() {
        minutes = parseInt(timer / 60, 10);
        seconds = parseInt(timer % 60, 10);

        minutes = minutes < 10 ? "0" + minutes : minutes;
        seconds = seconds < 10 ? "0" + seconds : seconds;

        display.text(minutes + ":" + seconds);

        if (--timer < 0) {
            timer = duration;
        }
    }, 1000);
}

function checkCodeMeli(code) {
    var L = code.length;
    if (L < 8 || parseInt(code, 10) == 0) return false;
    code = ('0000' + code).substr(L + 4 - 10);
    if (parseInt(code.substr(3, 6), 10) == 0) return false;
    var c = parseInt(code.substr(9, 1), 10);
    var s = 0;
    for (var i = 0; i < 9; i++)
        s += parseInt(code.substr(i, 1), 10) * (10 - i);
    s = s % 11;
    return (s < 2 && c == s) || (s >= 2 && c == (11 - s));
    return true;
}

// function appendOption2(selectElement, result, val, text1, text2 = false, seperator = 'p', callback = false) {
//     $.each(result, function(i, item) {
//         selectElement.append($('<option>', {
//             value: item.id,
//             text: Getor_String(item.rlname, '---') + ' / ' + ' تلفن: ' + ' ' + Getor_String(item.tel, '---')+ ' / ' + ' عنوان: ' + Getor_String(item.onvan50, '---') + ' / ' + ' تاریخ: ' +Getor_String(item.fmtarikh, '---')
//         }));
//     });
// }
function appendOption(selectElement, array, val, text1, text2 = false, seperator = 'p', callback = false) {
    if (selectElement) {
        for (let i = 0; i < array.length; i++) {
            if (!text2) {
                selectElement.append('<option value=' + array[i][val] + '>' + Getor_String(array[i][text1], '----') + '</option>');
            } else {
                switch (seperator) {
                    case 'p':
                        selectElement.append('<option value=' + array[i][val] + '>' + array[i][text1] + '(' + Getor_String(array[i][text2], '----') + ')' + '</option>');
                        break;
                    case 'ps':
                        selectElement.append('<option value=' + array[i][val] + '>' + array[i][text1] + ' (' + Getor_String(array[i][text2], '----') + ') ' + '</option>');
                        break;
                    default:

                        display_Predefiend_Messages();
                        break;
                }
            }
        }
        selectElement.prop("selectedIndex", -1);
        if (callback) return callback();
    }

}


// function appendOption2(elem, result, val, sep=false, txt1='', txt2='', txt3='', txt4='', txt4='', txt5='', txt6=''){
//     if(sep){
//         $.each(result, function (i, item) {
//             elem.append($('<option>', { 
//                 value: item.val,
//                 text : item.txt1+ sep + item.txt2
//             }));
//         });
//     }else{

//     }
// }
function test() {
    console.log('function test called');
}

function check_isset_message(data) {
    if (data) {
        if (data['Error']) {
            return true;
        } else if (data['Warning']) {
            return true;
        } else if (data['Success']) {
            return true;
        } else if (data['Error']) {
            return true;
        } else if (data['Info']) {
            return true;
        } else if (data['errorInfo']) {
            return true;
        } else return false;
    } else return false;
}

function validateEmail(email) {
    const re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}

function displayPredefiendAlert(result) {
    if (result['Success']) {
        alert(result['Success']);
    } else if (result['Warning']) {
        alert(result['Warning']);
    } else if (result['Error']) {
        alert(result['Error']);
    } else {
        alert('پیامی از سرور دریافت نشد.');
    }
}

function display_Predefiend_Messages(response) {
    if (response) {
        if (response['Success']) {
            Custom_Modal_Show('s', `<div class="font-weight-bold">${response['Success']}</div>`);
        } else if (response['Warning']) {
            Custom_Modal_Show('w', `<div class="font-weight-bold">${response['Warning']}</div>`);
        } else if (response['Info']) {
            Custom_Modal_Show('p', `<div class="font-weight-bold">${response['Info']}</div>`);
        } else if (response['Error']) {
            Custom_Modal_Show('d', `<div class="font-weight-bold">${response['Error']}</div>`);
        } else if (response['errorInfo']) {
            //database error
            Custom_Modal_Show('d', `<div class="font-weight-bold">خطا در برنامه</div>`);
        } else {
            Custom_Modal_Show('d', `<div class="font-weight-bold">خطا در برنامه</div>`);
        }
    } else Custom_Modal_Show('d', `<div class="font-weight-bold">خطا در برنامه</div>`);
}

function centerdisplay_Predefiend_Messages(response) {
    if (response) {
        if (response['Success']) {
            centerCustom_Modal_Show('s', `<div class="font-weight-bold">${response['Success']}</div>`);
        } else if (response['Warning']) {
            centerCustom_Modal_Show('w', `<div class="font-weight-bold">${response['Warning']}</div>`);
        } else if (response['Info']) {
            centerCustom_Modal_Show('p', `<div class="font-weight-bold">${response['Info']}</div>`);
        } else if (response['Error']) {
            centerCustom_Modal_Show('d', `<div class="font-weight-bold">${response['Error']}</div>`);
        } else if (response['errorInfo']) {
            //database error
            centerCustom_Modal_Show('d', `<div class="font-weight-bold">خطا در برنامه</div>`);
        } else {
            centerCustom_Modal_Show('d', `<div class="font-weight-bold">خطا در برنامه</div>`);
        }
    } else centerCustom_Modal_Show('d', `<div class="font-weight-bold">خطا در برنامه</div>`);
}

function Custom_Modal_Show(modal_type = "p", msg = false) {
    //modal_type:p=primary,w=warning,d=danger,s=success,i=info
    let modal = "";
    if (!msg) {
        msg = "خطا در برنامه لطفا مجددا تلاش کنید";
    }
    switch (modal_type) {
        case 'p':
            modal = `
            <div id="modal_theme_primary" class="modal fade" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-primary">
                            <h6 class="modal-title"></h6>
                            <button type="button" class="close" data-dismiss="modal"><span>&#215</span></button>
                        </div>
                        <div class="modal-body">
                            <p>${msg}</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn bg-primary" data-dismiss="modal">تایید</button>
                        </div>
                    </div>
                </div>
            </div>`;
            if (document.getElementById("modal_theme_primary")) {
                $("#modal_theme_primary").replaceWith(modal);
            } else {
                $(".content").append(modal);
            }
            $("#modal_theme_primary").modal('show');
            break;
        case 'w':
            modal = `
            <div id="modal_theme_warning" class="modal fade" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-warning">
                            <h6 class="modal-title"></h6>
                            <button type="button" class="close" data-dismiss="modal"><span>&#215</span></button>
                        </div>
                        <div class="modal-body">
                            <p>${msg}</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn bg-warning" data-dismiss="modal">تایید</button>
                        </div>
                    </div>
                </div>
            </div>`;
            if (document.getElementById("modal_theme_warning")) {
                $("#modal_theme_warning").replaceWith(modal);
            } else {
                $(".content").append(modal);
            }
            $("#modal_theme_warning").modal('show');
            break;
        case 'd':
            modal = `
            <div id="modal_theme_danger" class="modal fade" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-danger">
                            <h6 class="modal-title"></h6>
                            <button type="button" class="close" data-dismiss="modal"><span>&#215</span></button>
                        </div>
                        <div class="modal-body">
                            <p>${msg}</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn bg-danger" data-dismiss="modal">تایید</button>
                        </div>
                    </div>
                </div>
            </div>`;
            if (document.getElementById("modal_theme_danger")) {
                $("#modal_theme_danger").replaceWith(modal);
            } else {
                $(".content").append(modal);
            }
            $("#modal_theme_danger").modal('show');
            break;
        case 's':
            modal = `
            <div id="modal_theme_success" class="modal fade" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-success">
                            <h6 class="modal-title"></h6>
                            <button type="button" class="close" data-dismiss="modal"><span>&#215</span></button>
                        </div>
                        <div class="modal-body">
                            <p>${msg}</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn bg-success" data-dismiss="modal">تایید</button>
                        </div>
                    </div>
                </div>
            </div>`;
            if (document.getElementById("modal_theme_success")) {
                $("#modal_theme_success").replaceWith(modal);
            } else {
                $(".content").append(modal);
            }
            $("#modal_theme_success").modal('show');
            break;
        default:
            if (msg != '') {
                modal = `
                <div id="modal_theme_primary" class="modal fade" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header bg-primary">
                                <h6 class="modal-title"></h6>
                                <button type="button" class="close" data-dismiss="modal"><span>&#215</span></button>
                            </div>
                            <div class="modal-body">
                                <p>${msg}</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn bg-primary" data-dismiss="modal">تایید</button>
                            </div>
                        </div>
                    </div>
                </div>`;
                if (document.getElementById("modal_theme_primary")) {
                    $("#modal_theme_primary").replaceWith(modal);
                } else {
                    $(".content").append(modal);
                }
                $("#modal_theme_primary").modal('show');
            }
            break;
    }


}

function centerCustom_Modal_Show(modal_type = "p", msg = false) {
    //modal_type:p=primary,w=warning,d=danger,s=success,i=info
    let modal = "";
    if (!msg) {
        msg = "خطا در برنامه لطفا مجددا تلاش کنید";
    }
    switch (modal_type) {
        case 'p':
            modal = `
            <div id="modal_theme_primary" class="modal fade" tabindex="-1" style="text-align:center;direction: ltr !important;">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-primary">
                            <h6 class="modal-title"></h6>
                            <button type="button" class="close" data-dismiss="modal"><span>&#215</span></button>
                        </div>
                        <div class="modal-body">
                            <p>${msg}</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn bg-primary" data-dismiss="modal">تایید</button>
                        </div>
                    </div>
                </div>
            </div>`;
            if (document.getElementById("modal_theme_primary")) {
                $("#modal_theme_primary").replaceWith(modal);
            } else {
                $(".content").append(modal);
            }
            $("#modal_theme_primary").modal('show');
            break;
        case 'w':
            modal = `
            <div id="modal_theme_warning" class="modal fade" tabindex="-1" style="text-align:center;direction: ltr !important;">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-warning">
                            <h6 class="modal-title"></h6>
                            <button type="button" class="close" data-dismiss="modal"><span>&#215</span></button>
                        </div>
                        <div class="modal-body">
                            <p>${msg}</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn bg-warning" data-dismiss="modal">تایید</button>
                        </div>
                    </div>
                </div>
            </div>`;
            if (document.getElementById("modal_theme_warning")) {
                $("#modal_theme_warning").replaceWith(modal);
            } else {
                $(".content").append(modal);
            }
            $("#modal_theme_warning").modal('show');
            break;
        case 'd':
            modal = `
            <div id="modal_theme_danger" class="modal fade" tabindex="-1" style="text-align:center;direction: ltr !important;">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-danger">
                            <h6 class="modal-title"></h6>
                            <button type="button" class="close" data-dismiss="modal"><span>&#215</span></button>
                        </div>
                        <div class="modal-body">
                            <p>${msg}</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn bg-danger" data-dismiss="modal">تایید</button>
                        </div>
                    </div>
                </div>
            </div>`;
            if (document.getElementById("modal_theme_danger")) {
                $("#modal_theme_danger").replaceWith(modal);
            } else {
                $(".content").append(modal);
            }
            $("#modal_theme_danger").modal('show');
            break;
        case 's':
            modal = `
            <div id="modal_theme_success" class="modal fade" tabindex="-1" style="text-align:center;direction: ltr !important;">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-success">
                            <h6 class="modal-title"></h6>
                            <button type="button" class="close" data-dismiss="modal"><span>&#215</span></button>
                        </div>
                        <div class="modal-body">
                            <p>${msg}</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn bg-success" data-dismiss="modal">تایید</button>
                        </div>
                    </div>
                </div>
            </div>`;
            if (document.getElementById("modal_theme_success")) {
                $("#modal_theme_success").replaceWith(modal);
            } else {
                $(".content").append(modal);
            }
            $("#modal_theme_success").modal('show');
            break;
        default:
            if (msg != '') {
                modal = `
                <div id="modal_theme_primary" class="modal fade" tabindex="-1" style="text-align:center;direction: ltr !important;">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header bg-primary">
                                <h6 class="modal-title"></h6>
                                <button type="button" class="close" data-dismiss="modal"><span>&#215</span></button>
                            </div>
                            <div class="modal-body">
                                <p>${msg}</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn bg-primary" data-dismiss="modal">تایید</button>
                            </div>
                        </div>
                    </div>
                </div>`;
                if (document.getElementById("modal_theme_primary")) {
                    $("#modal_theme_primary").replaceWith(modal);
                } else {
                    $(".content").append(modal);
                }
                $("#modal_theme_primary").modal('show');
            }
            break;
    }


}

function ltrCustom_Modal_Show(modal_type = "p", msg = false) {
    //modal_type:p=primary,w=warning,d=danger,s=success,i=info
    let modal = "";
    if (!msg) {
        msg = "خطا در برنامه لطفا مجددا تلاش کنید";
    }
    switch (modal_type) {
        case 'p':
            modal = `
            <div id="modal_theme_primary" class="modal fade" tabindex="-1" style="text-align:left;direction: ltr !important;">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-primary">
                            <h6 class="modal-title"></h6>
                            <button type="button" class="close" data-dismiss="modal"><span>&#215</span></button>
                        </div>
                        <div class="modal-body">
                            <p>${msg}</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn bg-primary" data-dismiss="modal">تایید</button>
                        </div>
                    </div>
                </div>
            </div>`;
            if (document.getElementById("modal_theme_primary")) {
                $("#modal_theme_primary").replaceWith(modal);
            } else {
                $(".content").append(modal);
            }
            $("#modal_theme_primary").modal('show');
            break;
        case 'w':
            modal = `
            <div id="modal_theme_warning" class="modal fade" tabindex="-1" style="text-align:left;direction: ltr !important;">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-warning">
                            <h6 class="modal-title"></h6>
                            <button type="button" class="close" data-dismiss="modal"><span>&#215</span></button>
                        </div>
                        <div class="modal-body">
                            <p>${msg}</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn bg-warning" data-dismiss="modal">تایید</button>
                        </div>
                    </div>
                </div>
            </div>`;
            if (document.getElementById("modal_theme_warning")) {
                $("#modal_theme_warning").replaceWith(modal);
            } else {
                $(".content").append(modal);
            }
            $("#modal_theme_warning").modal('show');
            break;
        case 'd':
            modal = `
            <div id="modal_theme_danger" class="modal fade" tabindex="-1" style="text-align:left;direction: ltr !important;">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-danger">
                            <h6 class="modal-title"></h6>
                            <button type="button" class="close" data-dismiss="modal"><span>&#215</span></button>
                        </div>
                        <div class="modal-body">
                            <p>${msg}</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn bg-danger" data-dismiss="modal">تایید</button>
                        </div>
                    </div>
                </div>
            </div>`;
            if (document.getElementById("modal_theme_danger")) {
                $("#modal_theme_danger").replaceWith(modal);
            } else {
                $(".content").append(modal);
            }
            $("#modal_theme_danger").modal('show');
            break;
        case 's':
            modal = `
            <div id="modal_theme_success" class="modal fade" tabindex="-1" style="text-align:left;direction: ltr !important;">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-success">
                            <h6 class="modal-title"></h6>
                            <button type="button" class="close" data-dismiss="modal"><span>&#215</span></button>
                        </div>
                        <div class="modal-body">
                            <p>${msg}</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn bg-success" data-dismiss="modal">تایید</button>
                        </div>
                    </div>
                </div>
            </div>`;
            if (document.getElementById("modal_theme_success")) {
                $("#modal_theme_success").replaceWith(modal);
            } else {
                $(".content").append(modal);
            }
            $("#modal_theme_success").modal('show');
            break;
        default:
            if (msg != '') {
                modal = `
                <div id="modal_theme_primary" class="modal fade" tabindex="-1" style="text-align:left;direction: ltr !important;">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header bg-primary">
                                <h6 class="modal-title"></h6>
                                <button type="button" class="close" data-dismiss="modal"><span>&#215</span></button>
                            </div>
                            <div class="modal-body">
                                <p>${msg}</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn bg-primary" data-dismiss="modal">تایید</button>
                            </div>
                        </div>
                    </div>
                </div>`;
                if (document.getElementById("modal_theme_primary")) {
                    $("#modal_theme_primary").replaceWith(modal);
                } else {
                    $(".content").append(modal);
                }
                $("#modal_theme_primary").modal('show');
            }
            break;
    }


}

function validateInteger(selectors = false) {
    if (selectors) {
        for (let i = 0; i < selectors.length; i++) {
            if (selectors[i]) {
                selectors[i].on('keypress blur', function(e) {
                    $(this).val($(this).val().replace(/[^\d].+/, ""));
                    if ((e.which < 48 || e.which > 57)) {
                        e.preventDefault();
                    }
                });
            }
        }
    }
    //////code haye estefade nashode
    // input_integer_only(code_meli);
    // code_meli.on('keypress', function (e) {
    //     let regex = new RegExp(/[0-9]/);
    //     let key = String.fromCharCode(!e.charCode ? e.which : e.charCode);
    //     if (!regex.test(key)) {
    //         e.preventDefault();
    //        return false;
    //     }
    // });
    // code_meli.keypress(function(e){
    //     var txt = String.fromCharCode(e.which);
    //     if(!txt.match(/[0-9]/)) 
    //     {
    //         return false;
    //     }
    // });
}

function input_string_filter_group(selectors = false) {
    if (selectors) {
        for (let i = 0; i < selectors.length; i++) {
            if (selectors[i]) {
                selectors[i].on("keyup blur", function(e) {
                    $(this).val($(this).val().replace(/[^\d].+/, ""));
                    if ((e.which < 48 || e.which > 57)) {
                        e.preventDefault();
                    }
                });
            }
        }
    }
}

function input_filter_only_letter(selectors = false) {
    if (selectors) {
        for (let i = 0; i < selectors.length; i++) {
            selectors[i].on('keydown blur', function(e) {
                if (e.shiftKey || e.altKey) {
                    e.preventDefault();
                } else {
                    let key = e.keyCode;
                    if (!((key == 8) || (key == 32) || (key == 46) || (key >= 35 && key <= 40) || (key >= 65 && key <= 90))) {
                        e.preventDefault();
                    }
                }
            });
        }

    }
}

function input_persian_letters_only(selectors = false) {
    if (selectors) {
        for (let i = 0; i < selectors.length; i++) {
            selectors[i].on('keydown blur', function(e) {
                let key = e.keyCode;
                var txt = String.fromCharCode(e.which);
                if (persianRex.text.test($(this).val())) {
                    e.preventDefault();
                }
                // if (!p.test(key)) {
                //     e.preventDefault();
                // }

            });
        }
    }
}

function tinymce_editor(selector) {
    tinymce.init({
        selector: selector,
        language: 'fa',
        plugins: 'a11ychecker casechange formatpainter linkchecker autolink lists checklist media mediaembed pageembed permanentpen powerpaste table advtable tinycomments',
        menubar: true,
        statusbar: true,
        width: 'auto',
        height: 400,
        responsive: true,
        plugins: 'advlist table autolink link image lists charmap print preview',
        paste_auto_cleanup_on_paste: true,
        branding: false,
        paste_postprocess: function(pl, o) {
            o.node.innerHTML = o.node.innerHTML.replace(/&nbsp;/ig, " ");
        }
    });
}

function Number_3_3(num, sep = ",") {
    var number = typeof num === "number" ? num.toString() : num,
        separator = typeof sep === "undefined" ? ',' : sep;
    return number.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1" + separator);
}

function Set_Val(selector, value, alternitive_value = '') {
    switch (alternitive_value) {
        case '':
            selector.val(Getor_String(value, alternitive_value));
            break;
        case '1':
            alternitive_value = 'ثبت نشده';
            selector.val(Getor_String(value, alternitive_value));
            break;

        default:
            alternitive_value = 'ثبت نشده';
            selector.val(Getor_String(value, alternitive_value));
            break;
    }

}

function DATEPICKER_YYYYMMDD(selector) {
    $(selector).persianDatepicker({
        "inline": false,
        "format": "YYYY/MM/DD",
        "viewMode": "year",
        "initialValue": true,
        //"minDate": 1597225501408,
        //"maxDate": 1598175901435,
        "autoClose": false,
        "position": "auto",
        "onlyTimePicker": false,
        "onlySelectOnDate": false,
        "calendarType": "persian",
        "inputDelay": "400",
        "observer": false,
        "calendar": {
            "persian": {
                "locale": "fa",
                "showHint": true,
                "leapYearMode": "algorithmic"
            },
            "gregorian": {
                "locale": "en",
                "showHint": true
            }
        },
        "navigator": {
            "enabled": true,
            "scroll": {
                "enabled": true
            },
            "text": {
                "btnNextText": "بعد",
                "btnPrevText": "قبل"
            }
        },
        "toolbox": {
            "enabled": true,
            "calendarSwitch": {
                "enabled": true,
                "format": "MMMM"
            },
            "todayButton": {
                "enabled": true,
                "text": {
                    "fa": "امروز",
                    "en": "Today"
                }
            },
            "submitButton": {
                "enabled": true,
                "text": {
                    "fa": "تایید",
                    "en": "Submit"
                }
            },
            "text": {
                "btnToday": "امروز"
            }
        },
        "timePicker": {
            "enabled": true,
            "step": 1,
            "hour": {
                "enabled": true,
                "step": null
            },
            "minute": {
                "enabled": true,
                "step": null
            },
            "second": {
                "enabled": true,
                "step": null
            },
            "meridian": {
                "enabled": true
            }
        },
        "dayPicker": {
            "enabled": true,
            "titleFormat": "YYYY MMMM"
        },
        "monthPicker": {
            "enabled": true,
            "titleFormat": "YYYY"
        },
        "yearPicker": {
            "enabled": true,
            "titleFormat": "YYYY"
        },
        "responsive": true


    });
}

function ajaxForm(selector, url = window.location.href.slice(-1)[0], callback) {
    let formname = selector.prop('name');
    selector.submit(function(e) {
        e.preventDefault();
        var data = selector.serializeArray();
        $.ajax({
            type: 'post',
            'url': url,
            'Content-Type': 'application/json; charset=utf-8',
            timeout: 6000,
            data: {
                [formname]: data,
            },
            dataType: "json",
            success: function(response) {
                // response = JSON.parse(response);
                callback(response);
            },
            error: function(xhr, status, err) {
                // console.log(err);
                callback(err);
                // display_Predefiend_Messages(err);
            },
            complete: function() {
                callback('noError');
                ///////////////hameye onclick return false pak shavad
            }
        });
    });

}

function Ajax_Form_With_Callback(data, request, url = window.location.href, method = 'post', timeout = 10000, filter1 = '', filter2 = '', callback) {
    $.ajax({
        type: method,
        url: url,
        timeout: timeout,
        data: {
            [request]: data,
            'filter1': filter1,
            'filter2': filter2
        },
        success: function(response) {
            response = JSON.parse(response);
            alert(111);
            console.log(response);
            return callback(response);
            //alert("درخواست انجام شد.");
        },
        error: function(req, res, status) {
            alert(222);
            return callback('Error');
            //alert('مشکل در انجام درخواست');
        },
        complete: function() {
            ///////////////hameye onclick return false pak shavad
        }
    });
}

function Set_Unchecked_Checkboxes_Values(form, checkbox_value) {
    // form.submit(function () {
    var this_master = form;
    this_master.find('input[type="checkbox"]').each(function() {
        var checkbox_this = $(this);
        if (checkbox_this.is(":checked") == true) {
            checkbox_this.attr('value', checkbox_value);
        } else {
            checkbox_this.prop('checked', true);
            //DONT' ITS JUST CHECK THE CHECKBOX TO SUBMIT FORM DATA    
            checkbox_this.attr('value', checkbox_value);
        }
    });
    // });
}

function Edit_Form(page, condition, callback) {
    $.ajax({
        type: "post",
        url: "editform" + page,
        // timeout: 5000,
        data: {
            Edit_Form: page,
            condition: condition
        },
        success: function(response) {
            response = JSON.parse(response);
            return callback(response);
        },
        error: function(req, res, status) {
            return callback(false);
        }
    });
}

function Initialize(page, callback) {
    $.ajax({
        type: "post",
        url: page,
        // timeout: 5000,
        data: {
            initialize_request: page,
        },
        success: function(response) {
            response = JSON.parse(response);
            return callback(response);
        },
        error: function(req, res, status) {
            return callback(false);
        }
    });
}

function Initialize_two_param(page, request1, callback) {
    $.ajax({
        type: "post",
        url: page,
        // timeout: 5000,
        data: {
            initialize_request: page,
            'request1': request1,
        },
        success: function(response) {
            response = JSON.parse(response);
            return callback(response);
        },
        error: function(req, res, status) {
            return callback(false);
        }
    });
}

function getsubtelephonesbyid(data, callback) {
    $.ajax({
        type: "post",
        url: window.location.pathname,
        // timeout: 5000,
        data: { getsubtelephonesbyid: data },
        // dataType:'JSON',
        success: function(response) {
            //console.log(response);
            // put on console what server sent back...
            //console.log(response);
            response = JSON.parse(response);
            return callback(response);
        },
        error: function(req, res, status) {
            return callback(false);
        }
    });
}

function get_servicesbybsreserveid(data, callback) {
    $.ajax({
        type: "post",
        url: window.location.href.split('/').slice(-1)[0],
        // timeout: 5000,
        data: { get_servicesbybsreserveid: data },
        // dataType:'JSON',
        success: function(response) {
            //console.log(response);
            // put on console what server sent back...
            //console.log(response);
            response = JSON.parse(response);
            return callback(response);
        },
        error: function(req, res, status) {
            return callback(false);
        }
    });
}

function getosstelephonebyid(data, callback) {
    $.ajax({
        type: "post",
        url: window.location.href.split('/').slice(-1)[0],
        // timeout: 5000,
        data: { getosstelephonebyid: data },
        // dataType:'JSON',
        success: function(response) {
            //console.log(response);
            // put on console what server sent back...
            //console.log(response);
            response = JSON.parse(response);
            return callback(response);
        },
        error: function(req, res, status) {
            return callback(false);
        }
    });
}

function Initialize_three_param(page, filter1 = false, filter2 = false, callback) {
    $.ajax({
        type: "post",
        url: page,
        //timeout: 5000,
        data: {
            initialize_request: page,
            'filter1': filter1,
            'filter2': filter2,
        },
        success: function(response) {
            response = JSON.parse(response);
            return callback(response);
        },
        error: function(req, res, status) {
            return callback(false);
        }
    });
}

function Factors_Initialize(request, condition = '', callback) {
    $.ajax({
        type: "post",
        url: 'factors',
        //timeout: 5000,
        data: {
            factors_initialize: request,
            condition: condition
        },
        success: function(response) {
            response = JSON.parse(response);
            return callback(response);
        },
        error: function(req, res, status) {
            return callback(false);
        }
    });
}

function Print_Adsl_Factor(elem = false) {
    if (elem) {

        // var css = '@page { size: landscape; }',
        //     head = document.head || document.getElementsByTagName('head')[0],
        //     style = document.createElement('style');
        //     style.type = 'text/css';
        //     style.media = 'print';

        //     if (style.styleSheet){
        //     style.styleSheet.cssText = css;
        //     } else {
        //     style.appendChild(document.createTextNode(css));
        //     }
        // head.appendChild(style);
        var mywindow = window.open('', 'PRINT', 'width: 500px;height: 750px;');
        mywindow.document.write('<html><head><title>' + document.title + '</title>');
        // mywindow.document.head.insertAdjacentHTML("beforeend", `@page { size: landscape; }`);
        mywindow.head = mywindow.document.head || mywindow.document.getElementsByTagName('head')[0],
            $('<style>').text(`
    @page{
        @page {
            size: A5;
        }
    }
    .prints_tables{
        font-size:10px;
    }
    .prints_tables tr:first-child td{
        border:none;
    }
    .pt_headerimg{
        width: 180pt;height: auto;position:relative;text-align:right;float:right;padding:1px
    }
    .pt_headermatn{
        padding-right:5px;float:left;text-align:right;
    }
    .pt_imp_td{
        border:1px solid black;
    }
    .pt_imp_span{
        text-align: center;
        font-weight:bold;
        font-size:10px;
        padding:2px;
    }
    .pt_nor_span{
        text-align: right;
        font-size:10px;
        padding-right:5px;
        padding-top:5px;
        padding-bottom:5px;
    }
    .pt_nor_span_leftalign{
        text-align: left;
        font-size:10px;
        padding-left:2px;
        padding-top:2px;
        padding-bottom:2px;
    }
    .border_lbr{
        border-left:1px solid black;
        border-bottom:1px solid black;
        border-right:1px solid black;
    }
    .border_lb{
        border-left:1px solid black;
        border-bottom:1px solid black;
    }
    `).appendTo(mywindow.document.head)
        mywindow.document.write('</head><body>');
        //mywindow.document.write('<h1>' + document.title  + '</h1>');
        mywindow.document.write(document.getElementById(elem).innerHTML);
        mywindow.document.write('</body></html>');
        //mywindow.document.close(); // necessary for IE >= 10
        mywindow.focus(); // necessary for IE >= 10*/
        mywindow.print();
        // mywindow.close();
        return true;
    } else return false;
}

function Print_Initialize(request, condition = '', callback) {
    $.ajax({
        type: "post",
        url: 'factors',
        //timeout: 5000,
        data: {
            print_initialize: request,
            condition: condition
        },
        success: function(response) {
            // response = JSON.parse(response);
            return callback(response);
        },
        error: function(req, res, status) {
            return callback(false);
        }
    });
}

function Factors_Initialize_Two_Params(request, condition1 = false, condition2 = false, callback) {
    $.ajax({
        type: "post",
        url: 'factors',
        //timeout: 5000,
        data: {
            factors_initialize: request,
            condition1: condition1,
            condition2: condition2
        },
        success: function(response) {
            response = JSON.parse(response);
            return callback(response);
        },
        error: function(req, res, status) {
            return callback(false);
        }
    });
}

function Factors_Initialize_Three_Params(request, condition1 = false, condition2 = false, condition3 = false, callback) {
    $.ajax({
        type: "post",
        url: 'factors',
        //timeout: 5000,
        data: {
            factors_initialize: request,
            condition1: condition1,
            condition2: condition2,
            condition3: condition3
        },
        success: function(response) {
            response = JSON.parse(response);
            return callback(response);
        },
        error: function(req, res, status) {
            return callback(false);
        }
    });
}

function Assign_Port(port_id, telephone = false, user_id, callback) {
    $.ajax({
        type: "post",
        url: 'factors',
        //timeout: 5000,
        data: {
            Assign_Port: port_id,
            telephone: telephone,
            user_id: user_id
        },
        success: function(response) {
            response = JSON.parse(response);
            return callback(response);
        },
        error: function(req, res, status) {
            return callback(false);
        }
    });
}

function Hard_Delete(data, param1 /*felan kari anjam nemide*/ , callback) {
    $.ajax({
        type: "post",
        url: "harddelete",
        //timeout: 5000,
        data: {
            harddelete: data,
            target: param1
        },
        success: function(response) {
            response = JSON.parse(response);
            return callback(response);
        },
        error: function(req, res, status) {
            return callback(false);
        }
    });
}

function getostannamebyid(data /*felan kari anjam nemide*/ , callback) {
    $.ajax({
        type: "post",
        url: "getostannamebyid",
        //timeout: 5000,
        data: { getostannamebyid: data },
        // dataType:'JSON',
        success: function(response) {
            //console.log(response);
            // put on console what server sent back...
            //console.log(response);
            response = JSON.parse(response);
            return callback(response);
        },
        error: function(req, res, status) {
            return callback(false);
        }
    });
}

function Float_Round(num, decimal = 2) {
    return (Math.round(num * 100) / 100).toFixed(decimal);
}

function Get_Maliat(condition1, callback) {
    $.ajax({
        type: "post",
        url: "get_maliat",
        //timeout: 5000,
        data: { get_maliat: condition1 },
        // dataType:'JSON',
        success: function(response) {
            //console.log(response);
            // put on console what server sent back...
            //console.log(response);
            response = JSON.parse(response);
            return callback(response);
        },
        error: function(req, res, status) {
            return callback(false);
        }
    });
}

function Get_Wirelessap_By_Popsite(condition1, callback) {
    $.ajax({
        type: "post",
        url: "get_wirelessap_by_popsite",
        //timeout: 5000,
        data: { get_wirelessap_by_popsite: condition1 },
        // dataType:'JSON',
        success: function(response) {
            //console.log(response);
            // put on console what server sent back...
            //console.log(response);
            response = JSON.parse(response);
            return callback(response);
        },
        error: function(req, res, status) {
            return callback(false);
        }
    });
}

function Get_Wireless_Station_By_Ap_Where_station_eshterak_null(condition1, callback) {
    $.ajax({
        type: "post",
        url: "get_wirelessap_by_popsite",
        //timeout: 5000,
        data: { get_wireless_station_by_ap_where_station_eshterak_null: condition1 },
        // dataType:'JSON',
        success: function(response) {
            //console.log(response);
            // put on console what server sent back...
            //console.log(response);
            response = JSON.parse(response);
            return callback(response);
        },
        error: function(req, res, status) {
            return callback(false);
        }
    });
}

function Get_Wireless_station_By_ap(condition1, callback) {
    $.ajax({
        type: "post",
        url: "get_wirelessap_by_popsite",
        //timeout: 5000,
        data: { get_wireless_station_by_ap: condition1 },
        // dataType:'JSON',
        success: function(response) {
            //console.log(response);
            // put on console what server sent back...
            //console.log(response);
            response = JSON.parse(response);
            return callback(response);
        },
        error: function(req, res, status) {
            return callback(false);
        }
    });
}

function GetProvinces(data /*felan kari anjam nemide*/ , callback) {
    $.ajax({
        type: "post",
        url: "GetProvinces",
        //timeout: 5000,
        data: { GetProvinces: data },
        // dataType:'JSON',
        success: function(response) {
            response = JSON.parse(response);
            return callback(response);
        },
        error: function(req, res, status) {
            return callback(false);
        }
    });
}

function Get_Tdlte_sims_unassigned(data /*felan kari anjam nemide*/ , callback) {
    $.ajax({
        type: "post",
        url: "Get_Tdlte_sims_unassigned",
        //timeout: 5000,
        data: { Get_Tdlte_sims_unassigned: data },
        // dataType:'JSON',
        success: function(response) {
            response = JSON.parse(response);
            return callback(response);
        },
        error: function(req, res, status) {
            return callback(false);
        }
    });
}

function GetEquipmentsBrands(data, callback) {
    $.ajax({
        type: "post",
        url: "GetEquipmentsBrands",
        //timeout: 5000,
        data: { GetEquipmentsBrands: data },
        success: function(response) {
            response = JSON.parse(response);
            return callback(response);
        },
        error: function(req, res, status) {
            return callback(false);
        }
    });
}

function GetEquipmetsModelsByBrand(data, callback) {
    $.ajax({
        type: "post",
        url: "GetEquipmetsModelsByBrand",
        //timeout: 5000,
        data: { GetEquipmetsModelsByBrand: data },
        // dataType:'JSON',
        success: function(response) {
            response = JSON.parse(response);
            return callback(response);
        },
        error: function(req, res, status) {
            return callback(false);
        }
    });
}

function GetCities(data /*felan kari anjam nemide*/ , callback) {
    $.ajax({
        type: "post",
        url: "GetCities",
        //timeout: 5000,
        data: { GetCities: data },
        // dataType:'JSON',
        success: function(response) {
            //console.log(response);
            // put on console what server sent back...
            //console.log(response);
            response = JSON.parse(response);
            return callback(response);
        },
        error: function(req, res, status) {
            return callback(false);
        }
    });
}

function GetCityByProvince(data /*felan kari anjam nemide*/ , callback) {
    $.ajax({
        type: "post",
        url: "getcitybyprovince",
        //timeout: 5000,
        data: { ostanid: data },
        // dataType:'JSON',
        success: function(response) {
            //console.log(response);
            // put on console what server sent back...
            //console.log(response);
            response = JSON.parse(response);
            return callback(response);
        },
        error: function(req, res, status) {
            return callback(false);
        }
    });
}

function GetHost(data, callback) {
    $.ajax({
        type: "post",
        url: "GetHost",
        //timeout: 5000,
        data: { gethost: data },
        // dataType:'JSON',
        success: function(response) {
            //console.log(response);
            // put on console what server sent back...
            //console.log(response);
            response = JSON.parse(response);
            return callback(response);
        },
        error: function(req, res, status) {
            return callback(false);
        }
    });
}

function Get_Wireless_AP(data, callback) {
    $.ajax({
        type: "post",
        url: "GetHost",
        //timeout: 5000,
        data: { get_wireless_ap: data },
        // dataType:'JSON',
        success: function(response) {
            //console.log(response);
            // put on console what server sent back...
            //console.log(response);
            response = JSON.parse(response);
            return callback(response);
        },
        error: function(req, res, status) {
            return callback(false);
        }
    });
}

function GetHost_BY_Gharardad(data, callback) {
    $.ajax({
        type: "post",
        url: "GetHost",
        //timeout: 5000,
        data: { gethost_by_gharardad: data },
        // dataType:'JSON',
        success: function(response) {
            //console.log(response);
            // put on console what server sent back...
            //console.log(response);
            response = JSON.parse(response);
            return callback(response);
        },
        error: function(req, res, status) {
            return callback(false);
        }
    });
}

function Get_Mizban_Noe_Gharardad_BY_id(data, callback) {
    $.ajax({
        type: "post",
        url: "GetHost",
        //timeout: 5000,
        data: { get_mizban_noe_gharardad_by_id: data },
        // dataType:'JSON',
        success: function(response) {
            //console.log(response);
            // put on console what server sent back...
            //console.log(response);
            response = JSON.parse(response);
            return callback(response);
        },
        error: function(req, res, status) {
            return callback(false);
        }
    });
}

function Get_Noe_Terminal(data, callback) {
    $.ajax({
        type: "post",
        url: "GetNoeTerminal",
        //timeout: 5000,
        data: { getnoeterminal: data },
        // dataType:'JSON',
        success: function(response) {
            //console.log(response);
            // put on console what server sent back...
            //console.log(response);
            response = JSON.parse(response);
            return callback(response);
        },
        error: function(req, res, status) {
            return callback(false);
        }
    });
}

function Check_Noe_Terminal_with_Shoroe_Etesali(shoroe_etesali, noe_terminal, callback) {
    $.ajax({
        type: "post",
        url: "Checknoeterminal_With_Shoroeetesali",
        //timeout: 5000,
        data: {
            checknoeterminalwithshoroeetesali: 'asd',
            shoroeetesali: shoroe_etesali,
            noeterminal: noe_terminal,
        },
        // dataType:'JSON',
        success: function(response) {
            response = JSON.parse(response);
            return callback(response);
        },
        error: function(req, res, status) {
            return callback(false);
        }
    });
}

function Get_Noe_terminal(callback) {
    $.ajax({
        type: "post",
        url: "Get_Noe_terminal",
        //timeout: 5000,
        data: {
            Get_Noe_terminal: 'asd',
        },
        // dataType:'JSON',
        success: function(response) {
            response = JSON.parse(response);
            return callback(response);
        },
        error: function(req, res, status) {
            return callback(false);
        }
    });
}

function Get_all_Terminal(callback) {
    $.ajax({
        type: "post",
        url: "get_terminal",
        //timeout: 5000,
        data: {
            get_all_terminal: '',
        },
        // dataType:'JSON',
        success: function(response) {
            response = JSON.parse(response);
            return callback(response);
        },
        error: function(req, res, status) {
            return callback(false);
        }
    });
}

function Get_terminal_by_markazid(markaz_id, callback) {
    $.ajax({
        type: "post",
        url: "get_terminal",
        //timeout: 5000,
        data: {
            get_terminal_by_markazid: markaz_id,
        },
        // dataType:'JSON',
        success: function(response) {
            response = JSON.parse(response);
            return callback(response);
        },
        error: function(req, res, status) {
            return callback(false);
        }
    });
}

function GetPopsite(data, callback) {
    $.ajax({
        type: "post",
        url: "GetPopsite",
        //timeout: 5000,
        data: { getpopsite: data },
        // dataType:'JSON',
        success: function(response) {
            //console.log(response);
            // put on console what server sent back...
            //console.log(response);
            response = JSON.parse(response);
            return callback(response);
        },
        error: function(req, res, status) {
            return callback(false);
        }
    });
}

function Get_Telecommunications_center(data, callback) {
    $.ajax({
        type: "post",
        url: "get_telecommunications_center",
        //timeout: 5000,
        data: { get_telecommunications_center: data },
        // dataType:'JSON',
        success: function(response) {
            //console.log(response);
            // put on console what server sent back...
            //console.log(response);
            response = JSON.parse(response);
            return callback(response);
        },
        error: function(req, res, status) {
            return callback(false);
        }
    });
}

function Get_Branch_Info(data /*felan kari anjam nemide*/ , callback) {
    $.ajax({
        type: "post",
        url: "Get-branch",
        //timeout: 5000,
        data: { get_branch_info: data },
        success: function(response) {
            response = JSON.parse(response);
            return callback(response);
        },
        error: function(req, res, status) {
            return callback(false);
        }
    });
}

function Get_Branch_by_id(id /*felan kari anjam nemide*/ , callback) {
    $.ajax({
        type: "post",
        url: "Get-branch-byid",
        //timeout: 5000,
        data: { Get_Branch_by_id: id },
        success: function(response) {
            response = JSON.parse(response);
            return callback(response);
        },
        error: function(req, res, status) {
            return callback(false);
        }
    });
}

function Get_Telecenter_Bycity(shahr, callback) {
    $.ajax({
        type: "post",
        url: "get_telecenter_bycity",
        //timeout: 5000,
        data: {
            get_telecenter_bycity: 'asd',
            shahr: shahr,
        },
        success: function(response) {
            response = JSON.parse(response);
            return callback(response);
        },
        error: function(req, res, status) {
            return callback(false);
        }
    });
}

function Get_Popsite_Bycity(shahr, callback) {
    $.ajax({
        type: "post",
        url: "get_telecenter_bycity",
        //timeout: 5000,
        data: {
            get_popsite_bycity: 'asd',
            shahr: shahr,
        },
        success: function(response) {
            response = JSON.parse(response);
            return callback(response);
        },
        error: function(req, res, status) {
            return callback(false);
        }
    });
}

function Get_organization_levels(data /*felan kari anjam nemide*/ , callback) {
    $.ajax({
        type: "post",
        url: "GetProvinces",
        //timeout: 5000,
        data: { Get_organization_levels: data },
        // dataType:'JSON',
        success: function(response) {
            //console.log(response);
            // put on console what server sent back...
            //console.log(response);
            response = JSON.parse(response);
            return callback(response);
        },
        error: function(req, res, status) {
            return callback(false);
        }
    });
}

function DataTable(selector = 'view_table', path, type = "POST", cols, callback) {
    var table;
    table = $(selector).DataTable({
        sPaginationType: "full_numbers",
        processing: true,
        serverSide: true,
        ajax: {
            url: path,
            type: type,
            timeout: 6000
        },
        columns: cols,

        fixedHeader: true,
        dom: 'flrtip',
        select: 'single',

        responsive: true,
        //altEditor: true,      // Enable altEditor ****
        /*dom: 'Bflrtip',        // element order: NEEDS BUTTON CONTAINER (B) ****
        buttons: [
            {
                extend: 'copy',footer: true, text: 'کپی' , attr:  {title: 'copy', id: 'copybtn', class:'btn btn-secondary col-lg-auto float-lg-right'}
            },
            {
                extend: 'csv', text: 'خروجی csv' , attr:  {title: 'csv', id: 'csvbtn', class:'btn btn-secondary col-lg-auto float-lg-right'}
            },
            {
                extend: 'print', text: 'پرینت', attr:  {title: 'Copy',id: 'printbtn',class:'btn btn-secondary col-lg-auto float-lg-right'}
            }
        ],*/
        //order: [[0, "asc"]],
        scrollY: 450,
        scrollX: true,
        scrollCollapse: true,
        scroller: true,
        paging: true,
        fixedColumns: false,
        "bDestroy": true, //zamani ke chandta datatable dakhele tab dashte bashim age in nabashe error mide
        oLanguage: {
            select: {
                rows: {
                    _: "شما %d خط را انتخاب کرده ایید",
                    0: "برای انتخاب کلیک کنید",
                    1: "1 آیتم انتخاب شده",
                    2: "2 آیتم انتخاب شده",
                    3: "3 آیتم انتخاب شده",
                    4: "4 آیتم انتخاب شده",
                    5: "5 آیتم انتخاب شده",
                    6: "6 آیتم انتخاب شده",
                    7: "7 آیتم انتخاب شده",
                    8: "8 آیتم انتخاب شده",
                    9: "9 آیتم انتخاب شده",
                    10: "10 آیتم انتخاب شده",
                }
            },
            sSearch: "جستجو : ",
            oPaginate: {
                sPrevious: "قبلی",
                sNext: "بعدی",
                sLast: "آخر",
                sEmptyTable: "موردی یافت نشد!",
                sFirst: "ابتدا"
            },
            sLoadingRecords: "درحال بارگزاری...",
            sZeroRecords: "رکوردی یافت نشد!",
            sProcessing: "لطفا صبر کنید...",
            sInfo: "_TOTAL_ رکورد یافت شده (_START_ تا _END_)",
            sInfoFiltered: "فیلتر شده از _MAX_ رکورد",
            sInfoThousands: "K",
            sLengthMenu: 'نمایش <select id="datatable_rownum">' +
                '<option value="10">10</option>' +
                '<option value="20">20</option>' +
                '<option value="50">50</option>' +
                '<option value="100">100</option>' +
                '<option value="200">200</option>' +
                '<option value="500">500</option>' +
                '<option value="1000">1000</option>' +
                
                '</select> رکورد',

        },
        emptyTable: "موردی برای نمایش وجود نداشت.",
        autoWidth: false
    });
    callback(table);
}

function DataTable_Render(selector = 'view_table', path, type = "POST", cols, render1, callback) {

    var table;
    table = $(selector).DataTable({
        sPaginationType: "full_numbers",
        processing: true,
        serverSide: true,
        ajax: {
            url: path,
            type: type,
            timeout: 6000
        },
        columns: cols,
        fixedHeader: true,
        dom: 'flrtip',
        select: 'single',
        responsive: true,
        //altEditor: true,      // Enable altEditor ****
        /*dom: 'Bflrtip',        // element order: NEEDS BUTTON CONTAINER (B) ****
        buttons: [
            {
                extend: 'copy',footer: true, text: 'کپی' , attr:  {title: 'copy', id: 'copybtn', class:'btn btn-secondary col-lg-auto float-lg-right'}
            },
            {
                extend: 'csv', text: 'خروجی csv' , attr:  {title: 'csv', id: 'csvbtn', class:'btn btn-secondary col-lg-auto float-lg-right'}
            },
            {
                extend: 'print', text: 'پرینت', attr:  {title: 'Copy',id: 'printbtn',class:'btn btn-secondary col-lg-auto float-lg-right'}
            }
        ],*/
        //order: [[0, "asc"]],
        scrollY: 450,
        scrollX: true,
        scrollCollapse: true,

        paging: true,
        fixedColumns: false,
        "bDestroy": true, //zamani ke chandta datatable dakhele tab dashte bashim age in nabashe error mide
        oLanguage: {
            select: {
                rows: {
                    _: "شما %d خط را انتخاب کرده ایید",
                    0: "برای انتخاب کلیک کنید",
                    1: "1 آیتم انتخاب شده",
                    2: "2 آیتم انتخاب شده",
                    3: "3 آیتم انتخاب شده",
                    4: "4 آیتم انتخاب شده",
                    5: "5 آیتم انتخاب شده",
                    6: "6 آیتم انتخاب شده",
                    7: "7 آیتم انتخاب شده",
                    8: "8 آیتم انتخاب شده",
                    9: "9 آیتم انتخاب شده",
                    10: "10 آیتم انتخاب شده",
                }
            },
            sSearch: "جستجو : ",
            oPaginate: {
                sPrevious: "قبلی",
                sNext: "بعدی",
                sLast: "آخر",
                sEmptyTable: "موردی یافت نشد!",
                sFirst: "ابتدا"
            },
            sLoadingRecords: "درحال بارگزاری...",
            sZeroRecords: "رکوردی یافت نشد!",
            sProcessing: "لطفا صبر کنید...",
            sInfo: "_TOTAL_ رکورد یافت شده (_START_ تا _END_)",
            sInfoFiltered: "فیلتر شده از _MAX_ رکورد",
            sInfoThousands: "K",
            sLengthMenu: 'نمایش <select id="datatable_rownum">' +
            '<option value="10">10</option>' +
            '<option value="20">20</option>' +
            '<option value="50">50</option>' +
            '<option value="100">100</option>' +
            '<option value="200">200</option>' +
            '<option value="500">500</option>' +
            '<option value="1000">1000</option>' +
                '</select> رکورد',

        },

        emptyTable: "موردی برای نمایش وجود نداشت.",
        autoWidth: false
    });
    callback(table);
}

function DataTable2(selector = 'view_table', path, type = "POST", cols, condition, callback) {
    var table;
    table = $(selector).DataTable({
        sPaginationType: "full_numbers",
        processing: true,
        serverSide: true,
        ajax: {
            url: path,
            type: type,
            data: { filter: condition },
            timeout: 6000
        },
        columns: cols,
        dom: 'flrtip',
        select: 'single',
        responsive: true,
        //altEditor: true,      // Enable altEditor ****
        /*dom: 'Bflrtip',        // element order: NEEDS BUTTON CONTAINER (B) ****
        buttons: [
            {
                extend: 'copy',footer: true, text: 'کپی' , attr:  {title: 'copy', id: 'copybtn', class:'btn btn-secondary col-lg-auto float-lg-right'}
            },
            {
                extend: 'csv', text: 'خروجی csv' , attr:  {title: 'csv', id: 'csvbtn', class:'btn btn-secondary col-lg-auto float-lg-right'}
            },
            {
                extend: 'print', text: 'پرینت', attr:  {title: 'Copy',id: 'printbtn',class:'btn btn-secondary col-lg-auto float-lg-right'}
            }
        ],*/
        //order: [[0, "asc"]],
        scrollY: 450,
        scrollX: true,
        scrollCollapse: true,
        paging: true,
        fixedColumns: false,
        "bDestroy": true, //zamani ke chandta datatable dakhele tab dashte bashim age in nabashe error mide
        oLanguage: {
            select: {
                rows: {
                    _: "شما %d خط را انتخاب کرده ایید",
                    0: "برای انتخاب کلیک کنید",
                    1: "1 آیتم انتخاب شده",
                    2: "2 آیتم انتخاب شده",
                    3: "3 آیتم انتخاب شده",
                    4: "4 آیتم انتخاب شده",
                    5: "5 آیتم انتخاب شده",
                    6: "6 آیتم انتخاب شده",
                    7: "7 آیتم انتخاب شده",
                    8: "8 آیتم انتخاب شده",
                    9: "9 آیتم انتخاب شده",
                    10: "10 آیتم انتخاب شده",
                }
            },
            sSearch: "جستجو : ",
            oPaginate: {
                sPrevious: "قبلی",
                sNext: "بعدی",
                sLast: "آخر",
                sEmptyTable: "موردی یافت نشد!",
                sFirst: "ابتدا"
            },
            sLoadingRecords: "درحال بارگزاری...",
            sZeroRecords: "رکوردی یافت نشد!",
            sProcessing: "لطفا صبر کنید...",
            sInfo: "_TOTAL_ رکورد یافت شده (_START_ تا _END_)",
            sInfoFiltered: "فیلتر شده از _MAX_ رکورد",
            sInfoThousands: "K",
            sLengthMenu: 'نمایش <select id="datatable_rownum">' +
            '<option value="10">10</option>' +
            '<option value="20">20</option>' +
            '<option value="50">50</option>' +
            '<option value="100">100</option>' +
            '<option value="200">200</option>' +
            '<option value="500">500</option>' +
            '<option value="1000">1000</option>' +
                '</select> رکورد',

        },

        emptyTable: "موردی برای نمایش وجود نداشت.",
        autoWidth: false
    });
    callback(table);
}

function DataTable3(selector = 'view_table', path, request, request2, type = "POST", cols, callback) {
    let ptest = false;
    var table;
    table = $(selector).DataTable({
        sPaginationType: "full_numbers",
        processing: true,
        serverSide: true,
        ajax: {
            data: {
                [request]: request, //datatable_request
                'request': request2
            },
            url: path,
            type: type,
            timeout: 6000
        },

        columns: cols,
        fixedHeader: true,
        dom: 'flrtip',
        select: 'single',
        responsive: true,
        //altEditor: true,      // Enable altEditor ****
        /*dom: 'Bflrtip',        // element order: NEEDS BUTTON CONTAINER (B) ****
        buttons: [
            {
                extend: 'copy',footer: true, text: 'کپی' , attr:  {title: 'copy', id: 'copybtn', class:'btn btn-secondary col-lg-auto float-lg-right'}
            },
            {
                extend: 'csv', text: 'خروجی csv' , attr:  {title: 'csv', id: 'csvbtn', class:'btn btn-secondary col-lg-auto float-lg-right'}
            },
            {
                extend: 'print', text: 'پرینت', attr:  {title: 'Copy',id: 'printbtn',class:'btn btn-secondary col-lg-auto float-lg-right'}
            }
        ],*/
        order: [
            ['0', 'desc']
        ],
        scrollY: 450,
        scrollX: true,
        scrollCollapse: true,
        scroller: true,
        paging: true,
        fixedColumns: false,
        "bDestroy": true, //zamani ke chandta datatable dakhele tab dashte bashim age in nabashe error mide
        oLanguage: {
            select: {
                rows: {
                    _: "شما %d خط را انتخاب کرده ایید",
                    0: "برای انتخاب کلیک کنید",
                    1: "1 آیتم انتخاب شده",
                    2: "2 آیتم انتخاب شده",
                    3: "3 آیتم انتخاب شده",
                    4: "4 آیتم انتخاب شده",
                    5: "5 آیتم انتخاب شده",
                    6: "6 آیتم انتخاب شده",
                    7: "7 آیتم انتخاب شده",
                    8: "8 آیتم انتخاب شده",
                    9: "9 آیتم انتخاب شده",
                    10: "10 آیتم انتخاب شده",
                }
            },
            sSearch: "جستجو : ",
            oPaginate: {
                sPrevious: "قبلی",
                sNext: "بعدی",
                sLast: "آخر",
                sEmptyTable: "موردی یافت نشد!",
                sFirst: "ابتدا"
            },
            sLoadingRecords: "درحال بارگزاری...",
            sZeroRecords: "رکوردی یافت نشد!",
            sProcessing: "لطفا صبر کنید...",
            sInfo: "_TOTAL_ رکورد یافت شده (_START_ تا _END_)",
            sInfoFiltered: "فیلتر شده از _MAX_ رکورد",
            sInfoThousands: "K",
            sLengthMenu: 'نمایش <select id="datatable_rownum">' +
            '<option value="10">10</option>' +
            '<option value="20">20</option>' +
            '<option value="50">50</option>' +
            '<option value="100">100</option>' +
            '<option value="200">200</option>' +
            '<option value="500">500</option>' +
            '<option value="1000">1000</option>' +
                '</select> رکورد',

        },
        emptyTable: "موردی برای نمایش وجود نداشت.",
        autoWidth: false
    });
    callback(table);
}

function DataTable4(selector = 'view_table', path, request, request2, request3, type = "POST", cols, callback) {
    var table;
    table = $(selector).DataTable({
        sPaginationType: "full_numbers",
        processing: true,
        serverSide: true,
        ajax: {
            data: {
                [request]: request,
                'request': request2,
                'filter': request3,
            },
            url: path,
            type: type,
            timeout: 6000
        },

        columns: cols,
        fixedHeader: true,
        dom: 'flrtip',
        select: 'single',
        responsive: true,
        //altEditor: true,      // Enable altEditor ****
        /*dom: 'Bflrtip',        // element order: NEEDS BUTTON CONTAINER (B) ****
        buttons: [
            {
                extend: 'copy',footer: true, text: 'کپی' , attr:  {title: 'copy', id: 'copybtn', class:'btn btn-secondary col-lg-auto float-lg-right'}
            },
            {
                extend: 'csv', text: 'خروجی csv' , attr:  {title: 'csv', id: 'csvbtn', class:'btn btn-secondary col-lg-auto float-lg-right'}
            },
            {
                extend: 'print', text: 'پرینت', attr:  {title: 'Copy',id: 'printbtn',class:'btn btn-secondary col-lg-auto float-lg-right'}
            }
        ],*/
        // order: [
        //     [0, "desc"]
        // ],
        scrollY: 450,
        scrollX: true,
        scrollCollapse: true,
        scroller: true,
        paging: true,
        fixedColumns: false,
        "bDestroy": true, //zamani ke chandta datatable dakhele tab dashte bashim age in nabashe error mide
        oLanguage: {
            select: {
                rows: {
                    _: "شما %d خط را انتخاب کرده ایید",
                    0: "برای انتخاب کلیک کنید",
                    1: "1 آیتم انتخاب شده",
                    2: "2 آیتم انتخاب شده",
                    3: "3 آیتم انتخاب شده",
                    4: "4 آیتم انتخاب شده",
                    5: "5 آیتم انتخاب شده",
                    6: "6 آیتم انتخاب شده",
                    7: "7 آیتم انتخاب شده",
                    8: "8 آیتم انتخاب شده",
                    9: "9 آیتم انتخاب شده",
                    10: "10 آیتم انتخاب شده",
                }
            },
            sSearch: "جستجو : ",
            oPaginate: {
                sPrevious: "قبلی",
                sNext: "بعدی",
                sLast: "آخر",
                sEmptyTable: "موردی یافت نشد!",
                sFirst: "ابتدا"
            },
            sLoadingRecords: "درحال بارگزاری...",
            sZeroRecords: "رکوردی یافت نشد!",
            sProcessing: "لطفا صبر کنید...",
            sInfo: "_TOTAL_ رکورد یافت شده (_START_ تا _END_)",
            sInfoFiltered: "فیلتر شده از _MAX_ رکورد",
            sInfoThousands: "K",
            sLengthMenu: 'نمایش <select id="datatable_rownum">' +
            '<option value="10">10</option>' +
            '<option value="20">20</option>' +
            '<option value="50">50</option>' +
            '<option value="100">100</option>' +
            '<option value="200">200</option>' +
            '<option value="500">500</option>' +
            '<option value="1000">1000</option>' +
                '</select> رکورد',

        },
        emptyTable: "موردی برای نمایش وجود نداشت.",
        autoWidth: false
    });
    callback(table);
}

function DataTable5(selector = 'view_table', path, request, request2, filter1 = '', filter2 = '', filter3 = '', type = "POST", cols, callback) {
    var table;
    table = $(selector).DataTable({
        sPaginationType: "full_numbers",
        processing: true,
        serverSide: true,
        ajax: {
            data: {
                [request]: request,
                'request': request2,
                'filter': filter1,
                'filter2': filter2,
                'filter3': filter3
            },
            url: path,
            type: type,
            timeout: 6000
        },

        columns: cols,
        fixedHeader: true,
        dom: 'flrtip',
        select: 'single',
        responsive: true,
        //altEditor: true,      // Enable altEditor ****
        dom: 'Bflrtip', // element order: NEEDS BUTTON CONTAINER (B) ****
        buttons: [{
                extend: 'copy',
                footer: true,
                text: 'کپی',
                attr: { title: 'copy', id: 'copybtn', class: 'btn btn-secondary col-lg-auto float-lg-right' }
            },
            {
                extend: 'csv',
                text: 'خروجی csv',
                charset: 'UTF-8',
                fieldSeparator: ';',
                bom: true,
                filename: 'CsvReport',
                title: 'CsvReport',
                attr: { title: 'csv', id: 'csvbtn', class: 'btn btn-secondary col-lg-auto float-lg-right' },
            },
            {
                extend: 'print',
                text: 'پرینت',
                attr: { title: 'Copy', id: 'printbtn', class: 'btn btn-secondary col-lg-auto float-lg-right' }
            }
        ],
        order: [
            [0, "desc"]
        ],
        scrollY: 450,
        scrollX: true,
        scrollCollapse: true,
        scroller: true,
        paging: true,
        fixedColumns: false,
        "bDestroy": true, //zamani ke chandta datatable dakhele tab dashte bashim age in nabashe error mide
        oLanguage: {
            select: {
                rows: {
                    _: "شما %d خط را انتخاب کرده ایید",
                    0: "برای انتخاب کلیک کنید",
                    1: "1 آیتم انتخاب شده",
                    2: "2 آیتم انتخاب شده",
                    3: "3 آیتم انتخاب شده",
                    4: "4 آیتم انتخاب شده",
                    5: "5 آیتم انتخاب شده",
                    6: "6 آیتم انتخاب شده",
                    7: "7 آیتم انتخاب شده",
                    8: "8 آیتم انتخاب شده",
                    9: "9 آیتم انتخاب شده",
                    10: "10 آیتم انتخاب شده",
                }
            },
            sSearch: "جستجو : ",
            oPaginate: {
                sPrevious: "قبلی",
                sNext: "بعدی",
                sLast: "آخر",
                sEmptyTable: "موردی یافت نشد!",
                sFirst: "ابتدا"
            },
            sLoadingRecords: "درحال بارگزاری...",
            sZeroRecords: "رکوردی یافت نشد!",
            sProcessing: "لطفا صبر کنید...",
            sInfo: "_TOTAL_ رکورد یافت شده (_START_ تا _END_)",
            sInfoFiltered: "فیلتر شده از _MAX_ رکورد",
            sInfoThousands: "K",
            sLengthMenu: 'نمایش <select id="datatable_rownum">' +
                '<option value="10">10</option>' +
                '<option value="20">20</option>' +
                '<option value="50">50</option>' +
                '<option value="100">100</option>' +
                '<option value="200">200</option>' +
                '<option value="500">500</option>' +
                '<option value="1000">1000</option>' +
                '</select> رکورد',

        },
        emptyTable: "موردی برای نمایش وجود نداشت.",
        autoWidth: false
    });
    callback(table);
}

function DT6_noebutton(selector = 'view_table', path, request, request2, filter1 = '', filter2 = '', filter3 = '', type = "POST", cols, callback) {
    var table;
    table = $(selector).DataTable({
        sPaginationType: "full_numbers",
        processing: true,
        serverSide: true,
        ajax: {
            data: {
                [request]: request,
                'request': request2,
                'filter': filter1,
                'filter2': filter2,
                'filter3': filter3
            },
            url: path,
            type: type,
            timeout: 6000
        },

        columns: cols,
        fixedHeader: true,
        dom: 'flrtip',
        select: 'single',
        responsive: true,
        //altEditor: true,      // Enable altEditor ****
        // dom: 'Bflrtip',        // element order: NEEDS BUTTON CONTAINER (B) ****
        // buttons: [
        //     {
        //         extend: 'copy',footer: true, text: 'کپی' , attr:  {title: 'copy', id: 'copybtn', class:'btn btn-secondary col-lg-auto float-lg-right'}
        //     },
        //     {
        //         extend: 'csv', text: 'خروجی csv' , attr:  {title: 'csv', id: 'csvbtn', class:'btn btn-secondary col-lg-auto float-lg-right'}
        //     },
        //     {
        //         extend: 'print', text: 'پرینت', attr:  {title: 'Copy',id: 'printbtn',class:'btn btn-secondary col-lg-auto float-lg-right'}
        //     }
        // ],
        order: [
            [0, "desc"]
        ],
        scrollY: 450,
        scrollX: true,
        scrollCollapse: true,
        scroller: true,
        paging: true,
        fixedColumns: false,
        "bDestroy": true, //zamani ke chandta datatable dakhele tab dashte bashim age in nabashe error mide
        oLanguage: {
            select: {
                rows: {
                    _: "شما %d خط را انتخاب کرده ایید",
                    0: "برای انتخاب کلیک کنید",
                    1: "1 آیتم انتخاب شده",
                    2: "2 آیتم انتخاب شده",
                    3: "3 آیتم انتخاب شده",
                    4: "4 آیتم انتخاب شده",
                    5: "5 آیتم انتخاب شده",
                    6: "6 آیتم انتخاب شده",
                    7: "7 آیتم انتخاب شده",
                    8: "8 آیتم انتخاب شده",
                    9: "9 آیتم انتخاب شده",
                    10: "10 آیتم انتخاب شده",
                }
            },
            sSearch: "جستجو : ",
            oPaginate: {
                sPrevious: "قبلی",
                sNext: "بعدی",
                sLast: "آخر",
                sEmptyTable: "موردی یافت نشد!",
                sFirst: "ابتدا"
            },
            sLoadingRecords: "درحال بارگزاری...",
            sZeroRecords: "رکوردی یافت نشد!",
            sProcessing: "لطفا صبر کنید...",
            sInfo: "_TOTAL_ رکورد یافت شده (_START_ تا _END_)",
            sInfoFiltered: "فیلتر شده از _MAX_ رکورد",
            sInfoThousands: "K",
            sLengthMenu: 'نمایش <select id="datatable_rownum">' +
            '<option value="10">10</option>' +
            '<option value="20">20</option>' +
            '<option value="50">50</option>' +
            '<option value="100">100</option>' +
            '<option value="200">200</option>' +
            '<option value="500">500</option>' +
            '<option value="1000">1000</option>' +
                '</select> رکورد',

        },
        emptyTable: "موردی برای نمایش وجود نداشت.",
        autoWidth: false
    });
    callback(table);
}

function DataTable6(selector = 'view_table', path, request, request2, filter1 = '', filter2 = '', filter3 = '', type = "POST", cols, callback) {
    var table;
    table = $(selector).DataTable({
        sPaginationType: "full_numbers",
        processing: true,
        serverSide: true,
        ajax: {
            data: {
                [request]: request,
                'request': request2,
                'filter': filter1,
                'filter2': filter2,
                'filter3': filter3
            },
            url: path,
            type: type,
            timeout: 6000
        },

        columns: cols,
        fixedHeader: true,
        dom: 'flrtip',
        select: 'single',
        responsive: true,
        //altEditor: true,      // Enable altEditor ****
        /*dom: 'Bflrtip',        // element order: NEEDS BUTTON CONTAINER (B) ****
        buttons: [
            {
                extend: 'copy',footer: true, text: 'کپی' , attr:  {title: 'copy', id: 'copybtn', class:'btn btn-secondary col-lg-auto float-lg-right'}
            },
            {
                extend: 'csv', text: 'خروجی csv' , attr:  {title: 'csv', id: 'csvbtn', class:'btn btn-secondary col-lg-auto float-lg-right'}
            },
            {
                extend: 'print', text: 'پرینت', attr:  {title: 'Copy',id: 'printbtn',class:'btn btn-secondary col-lg-auto float-lg-right'}
            }
        ],*/
        //order: [[0, "asc"]],
        scrollY: 450,
        scrollX: true,
        scrollCollapse: true,
        scroller: true,
        paging: true,
        fixedColumns: false,
        "bDestroy": true, //zamani ke chandta datatable dakhele tab dashte bashim age in nabashe error mide
        oLanguage: {
            select: {
                rows: {
                    _: "شما %d خط را انتخاب کرده ایید",
                    0: "برای انتخاب کلیک کنید",
                    1: "1 آیتم انتخاب شده",
                    2: "2 آیتم انتخاب شده",
                    3: "3 آیتم انتخاب شده",
                    4: "4 آیتم انتخاب شده",
                    5: "5 آیتم انتخاب شده",
                    6: "6 آیتم انتخاب شده",
                    7: "7 آیتم انتخاب شده",
                    8: "8 آیتم انتخاب شده",
                    9: "9 آیتم انتخاب شده",
                    10: "10 آیتم انتخاب شده",
                }
            },
            sSearch: "جستجو : ",
            oPaginate: {
                sPrevious: "قبلی",
                sNext: "بعدی",
                sLast: "آخر",
                sEmptyTable: "موردی یافت نشد!",
                sFirst: "ابتدا"
            },
            sLoadingRecords: "درحال بارگزاری...",
            sZeroRecords: "رکوردی یافت نشد!",
            sProcessing: "لطفا صبر کنید...",
            sInfo: "_TOTAL_ رکورد یافت شده (_START_ تا _END_)",
            sInfoFiltered: "فیلتر شده از _MAX_ رکورد",
            sInfoThousands: "K",
            sLengthMenu: 'نمایش <select id="datatable_rownum">' +
            '<option value="10">10</option>' +
            '<option value="20">20</option>' +
            '<option value="50">50</option>' +
            '<option value="100">100</option>' +
            '<option value="200">200</option>' +
            '<option value="500">500</option>' +
            '<option value="1000">1000</option>' +
                '</select> رکورد',

        },
        emptyTable: "موردی برای نمایش وجود نداشت.",
        autoWidth: false
    });
    callback(table);
}

function Getor_String(data, param = '') {
    if (data && data !== '' && data !== null && data !== 'Null' && data !== 'NULL' && data !== 'null' && data !== undefined && data !== 'undefined' && data !== 'Undefined') {
        return data;
    } else {
        return param;
    }
}

function DataTable_array_datasource(selector, dataset, cols, callback, custombutton=false, ctext='Kill User', ctitle='killuser', cid='killuser') {
    var table;
    if (selector != '') {
        if(custombutton){
            table = $(selector).DataTable({
                sPaginationType: "full_numbers",
                data: dataset,
                columns: cols,
                fixedHeader: true,
                dom: 'flrtip',
                select: 'single',
                responsive: true,
                //altEditor: true,      // Enable altEditor ****
                dom: 'Bflrtip', // element order: NEEDS BUTTON CONTAINER (B) ****
                buttons: [
                    {
                        extend: 'copy',
                        footer: true,
                        text: 'کپی',
                        attr: { title: 'copy', id: 'copybtn', class: 'btn btn-secondary col-lg-auto float-lg-right' }
                    },
                    {
                        extend: 'csv',
                        text: 'خروجی csv',
                        charset: 'UTF-8',
                        fieldSeparator: ';',
                        bom: true,
                        filename: 'CsvReport',
                        title: 'CsvReport',
                        attr: { title: 'csv', id: 'csvbtn', class: 'btn btn-secondary col-lg-auto float-lg-right' },
                    },
                    {
                        extend: 'print',
                        text: 'پرینت',
                        attr: { title: 'Copy', id: 'printbtn', class: 'btn btn-secondary col-lg-auto float-lg-right' }
                    },
                    {
                        text: ctext,
                        attr: { title: ctitle, id: cid, class: 'btn btn-warning col-lg-auto float-lg-right' },
                    },
                ],
                //order: [[0, "asc"]],
                scrollY: 450,
                scrollX: true,
                scrollCollapse: true,
                scroller: true,
                paging: true,
                fixedColumns: false,
                "bDestroy": true, //zamani ke chandta datatable dakhele tab dashte bashim age in nabashe error mide
                oLanguage: {
                    select: {
                        rows: {
                            _: "شما %d خط را انتخاب کرده ایید",
                            0: "برای انتخاب کلیک کنید",
                            1: "1 آیتم انتخاب شده",
                            2: "2 آیتم انتخاب شده",
                            3: "3 آیتم انتخاب شده",
                            4: "4 آیتم انتخاب شده",
                            5: "5 آیتم انتخاب شده",
                            6: "6 آیتم انتخاب شده",
                            7: "7 آیتم انتخاب شده",
                            8: "8 آیتم انتخاب شده",
                            9: "9 آیتم انتخاب شده",
                            10: "10 آیتم انتخاب شده",
                        }
                    },
                    sSearch: "جستجو : ",
                    oPaginate: {
                        sPrevious: "قبلی",
                        sNext: "بعدی",
                        sLast: "آخر",
                        sEmptyTable: "موردی یافت نشد!",
                        sFirst: "ابتدا"
                    },
                    sLoadingRecords: "درحال بارگزاری...",
                    sZeroRecords: "رکوردی یافت نشد!",
                    sProcessing: "لطفا صبر کنید...",
                    sInfo: "_TOTAL_ رکورد یافت شده (_START_ تا _END_)",
                    sInfoFiltered: "فیلتر شده از _MAX_ رکورد",
                    sInfoThousands: "K",
                    sLengthMenu: 'نمایش <select id="datatable_rownum">' +
                        '<option value="10">10</option>' +
                        '<option value="20">20</option>' +
                        '<option value="50">50</option>' +
                        '<option value="100">100</option>' +
                        '<option value="200">200</option>' +
                        '<option value="500">500</option>' +
                        '<option value="1000">1000</option>' +
                        '</select> رکورد',

                },
                emptyTable: "موردی برای نمایش وجود نداشت.",
                autoWidth: false
            });
        }else{
            table = $(selector).DataTable({
                sPaginationType: "full_numbers",
                data: dataset,
                columns: cols,
                fixedHeader: true,
                dom: 'flrtip',
                select: 'single',
                responsive: true,
                //altEditor: true,      // Enable altEditor ****
                dom: 'Bflrtip', // element order: NEEDS BUTTON CONTAINER (B) ****
                buttons: [
                    {
                        extend: 'copy',
                        footer: true,
                        text: 'کپی',
                        attr: { title: 'copy', id: 'copybtn', class: 'btn btn-secondary col-lg-auto float-lg-right' }
                    },
                    {
                        extend: 'csv',
                        text: 'خروجی csv',
                        charset: 'UTF-8',
                        fieldSeparator: ';',
                        bom: true,
                        filename: 'CsvReport',
                        title: 'CsvReport',
                        attr: { title: 'csv', id: 'csvbtn', class: 'btn btn-secondary col-lg-auto float-lg-right' },
                    },
                    {
                        extend: 'print',
                        text: 'پرینت',
                        attr: { title: 'Copy', id: 'printbtn', class: 'btn btn-secondary col-lg-auto float-lg-right' }
                    },
                ],
                //order: [[0, "asc"]],
                scrollY: 450,
                scrollX: true,
                scrollCollapse: true,
                scroller: true,
                paging: true,
                fixedColumns: false,
                "bDestroy": true, //zamani ke chandta datatable dakhele tab dashte bashim age in nabashe error mide
                oLanguage: {
                    select: {
                        rows: {
                            _: "شما %d خط را انتخاب کرده ایید",
                            0: "برای انتخاب کلیک کنید",
                            1: "1 آیتم انتخاب شده",
                            2: "2 آیتم انتخاب شده",
                            3: "3 آیتم انتخاب شده",
                            4: "4 آیتم انتخاب شده",
                            5: "5 آیتم انتخاب شده",
                            6: "6 آیتم انتخاب شده",
                            7: "7 آیتم انتخاب شده",
                            8: "8 آیتم انتخاب شده",
                            9: "9 آیتم انتخاب شده",
                            10: "10 آیتم انتخاب شده",
                        }
                    },
                    sSearch: "جستجو : ",
                    oPaginate: {
                        sPrevious: "قبلی",
                        sNext: "بعدی",
                        sLast: "آخر",
                        sEmptyTable: "موردی یافت نشد!",
                        sFirst: "ابتدا"
                    },
                    sLoadingRecords: "درحال بارگزاری...",
                    sZeroRecords: "رکوردی یافت نشد!",
                    sProcessing: "لطفا صبر کنید...",
                    sInfo: "_TOTAL_ رکورد یافت شده (_START_ تا _END_)",
                    sInfoFiltered: "فیلتر شده از _MAX_ رکورد",
                    sInfoThousands: "K",
                    sLengthMenu: 'نمایش <select id="datatable_rownum">' +
                        '<option value="10">10</option>' +
                        '<option value="20">20</option>' +
                        '<option value="50">50</option>' +
                        '<option value="100">100</option>' +
                        '<option value="200">200</option>' +
                        '<option value="500">500</option>' +
                        '<option value="1000">1000</option>' +
                        '</select> رکورد',

                },
                emptyTable: "موردی برای نمایش وجود نداشت.",
                autoWidth: false
            });
        }
        callback(table);
    }else{
        return false;
    }
}

function DataTable_array_datasource2(selector = '', dataset, cols, callback) {
    var table;
    if (selector != '') {
        table = $(selector).DataTable({
            sPaginationType: "full_numbers",
            data: dataset,
            columns: cols,
            fixedHeader: true,
            dom: 'flrtip',
            select: 'single',
            responsive: true,
            //altEditor: true,      // Enable altEditor ****
            dom: 'Bflrtip', // element order: NEEDS BUTTON CONTAINER (B) ****
            buttons: [{
                extend: 'print',
                text: 'پرینت',
                attr: { title: 'Print', id: 'printbtn', class: 'btn btn-primary col-lg-auto float-lg-right' }
            }],
            //order: [[0, "asc"]],
            scrollY: 2000,
            scrollX: true,
            scrollCollapse: true,
            scroller: true,
            paging: true,
            fixedColumns: false,
            "bDestroy": true, //zamani ke chandta datatable dakhele tab dashte bashim age in nabashe error mide
            oLanguage: {
                select: {
                    rows: {
                        _: "شما %d خط را انتخاب کرده ایید",
                        0: "برای انتخاب کلیک کنید",
                        1: "1 آیتم انتخاب شده",
                        2: "2 آیتم انتخاب شده",
                        3: "3 آیتم انتخاب شده",
                        4: "4 آیتم انتخاب شده",
                        5: "5 آیتم انتخاب شده",
                        6: "6 آیتم انتخاب شده",
                        7: "7 آیتم انتخاب شده",
                        8: "8 آیتم انتخاب شده",
                        9: "9 آیتم انتخاب شده",
                        10: "10 آیتم انتخاب شده",
                    }
                },
                sSearch: "جستجو : ",
                oPaginate: {
                    sPrevious: "قبلی",
                    sNext: "بعدی",
                    sLast: "آخر",
                    sEmptyTable: "موردی یافت نشد!",
                    sFirst: "ابتدا"
                },
                sLoadingRecords: "درحال بارگزاری...",
                sZeroRecords: "رکوردی یافت نشد!",
                sProcessing: "لطفا صبر کنید...",
                sInfo: "_TOTAL_ رکورد یافت شده (_START_ تا _END_)",
                sInfoFiltered: "فیلتر شده از _MAX_ رکورد",
                sInfoThousands: "K",
                sLengthMenu: 'نمایش <select id="datatable_rownum">' +
                    '<option value="10">10</option>' +
                    '<option value="20">20</option>' +
                    '<option value="50">50</option>' +
                    '<option value="100">100</option>' +
                    '<option value="200">200</option>' +
                    '<option value="500">500</option>' +
                    '<option value="1000">1000</option>' +
                    '</select> رکورد',

            },
            emptyTable: "موردی برای نمایش وجود نداشت.",
            autoWidth: false
        });
        callback(table);
    }
}

function tarikhConvertOrSplit(date, seperator = '-', tabdil = false, noe_tabdil = 'gtj', result_seperator = '-') {
    let tarikh = date.split(seperator);
    if (tarikh.length > 2) {
        if (tabdil) {
            if (noe_tabdil === 'gtj') {
                return gregorian_to_jalali(parseInt(tarikh[0]), parseInt(tarikh[1]), parseInt(tarikh[2]), result_seperator);
            } else if (noe_tabdil === 'jtg') {
                return jalali_to_gregorian(parseInt(tarikh[0]), parseInt(tarikh[1]), parseInt(tarikh[2]), result_seperator);
            }
        } else {
            return tarikh;
        }
    } else {
        return false;
    }
}

function gregorian_to_jalali(gy, gm, gd, mod = '') {
    var g_d_m, jy, jm, jd, gy2, days;
    g_d_m = [0, 31, 59, 90, 120, 151, 181, 212, 243, 273, 304, 334];
    if (gy > 1600) {
        jy = 979;
        gy -= 1600;
    } else {
        jy = 0;
        gy -= 621;
    }
    gy2 = (gm > 2) ? (gy + 1) : gy;
    days = (365 * gy) + (parseInt((gy2 + 3) / 4)) - (parseInt((gy2 + 99) / 100)) + (parseInt((gy2 + 399) / 400)) - 80 + gd + g_d_m[gm - 1];
    jy += 33 * (parseInt(days / 12053));
    days %= 12053;
    jy += 4 * (parseInt(days / 1461));
    days %= 1461;
    if (days > 365) {
        jy += parseInt((days - 1) / 365);
        days = (days - 1) % 365;
    }
    jm = (days < 186) ? 1 + parseInt(days / 31) : 7 + parseInt((days - 186) / 30);
    jd = 1 + ((days < 186) ? (days % 31) : ((days - 186) % 30));
    if (mod === '') {
        return [jy, jm, jd];
    } else {
        return jy + mod + jm + mod + jd;
    }

}

function jalali_to_gregorian(jy, jm, jd, mod = '') {
    var sal_a, gy, gm, gd, days, v;
    if (jy > 979) {
        gy = 1600;
        jy -= 979;
    } else {
        gy = 621;
    }
    days = (365 * jy) + ((parseInt(jy / 33)) * 8) + (parseInt(((jy % 33) + 3) / 4)) + 78 + jd + ((jm < 7) ? (jm - 1) * 31 : ((jm - 7) * 30) + 186);
    gy += 400 * (parseInt(days / 146097));
    days %= 146097;
    if (days > 36524) {
        gy += 100 * (parseInt(--days / 36524));
        days %= 36524;
        if (days >= 365) days++;
    }
    gy += 4 * (parseInt(days / 1461));
    days %= 1461;
    if (days > 365) {
        gy += parseInt((days - 1) / 365);
        days = (days - 1) % 365;
    }
    gd = days + 1;
    sal_a = [0, 31, ((gy % 4 === 0 && gy % 100 !== 0) || (gy % 400 === 0)) ? 29 : 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
    for (gm = 0; gm < 13; gm++) {
        v = sal_a[gm];
        if (gd <= v) break;
        gd -= v;
    }
    if (mod === '') {
        return [gy, gm, gd];
    } else {
        return gy + mod + gm + mod + gd;
    }
    // return [gy, gm, gd];
}
String.prototype.toPersinaDigit = function() {
    var id = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
    return this.replace(/[0-9]/g, function(w) { return id[+w] });
    //    var en_number = "0123456789"; alert(en_number.toPersinaDigit());
}
String.prototype.toEnglishDigit = function() {
    var find = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
    var replace = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
    var replaceString = this;
    var regex;
    for (var i = 0; i < find.length; i++) {
        regex = new RegExp(find[i], "g");
        replaceString = replaceString.replace(regex, replace[i]);
    }
    return replaceString;
    // var fa_number = "۰۱۲۳۴۵۶۷۸۹";
    // alert(fa_number.toEnglishDigit());
};

function tabdile_tarikh_adad(shamsi, seperator = '-', noe_tabdil = 1) {
    //1=miladi be shamsi //2= shamsi be miladi
    if (!isEmpty(shamsi)) {
        let mydate = shamsi.split("-");
        if (mydate.length > 1) {
            let mydate_res = gregorian_to_jalali(parseInt(mydate[0]), parseInt(mydate[1]), parseInt(mydate[2]));
            mydate_res[0] = mydate_res[0].toString();
            mydate_res[1] = mydate_res[1].toString();
            mydate_res[2] = mydate_res[2].toString();
            console.log('---------');
            console.log(mydate_res);
            console.log('---------');
            return shamsi = mydate_res[0].toPersinaDigit() + '/' + mydate_res[1].toPersinaDigit() + '/' + mydate_res[2].toPersinaDigit();
        }
    } else {
        return false;
    }
}

function Copy_Redirect_To_Tactor_Tab(copy_target = '', click_target = '') {
    /* Get the text field */
    if (copy_target !== '' && click_target !== '') {
        var copyText = document.getElementById(copy_target);
        copyText.select();
        copyText.setSelectionRange(0, 99999)
        document.execCommand("copy");
        //alert("متن کپی شده: " + copyText.value);
        //var click_target = document.getElementById(copy_target);
        $(click_target).click();
    }
}

function page_requests(page, url = 'bootstrap', request1 = '', request2 = '', request3 = '', callback) {
    $.ajax({
        type: "post",
        url: url,
        //timeout: 7000,
        data: {
            [page]: page,
            'request1': request1,
            'request2': request2,
            'request3': request3
        },
        success: function(response) {
            response = JSON.parse(response);
            return callback(response);
        },
        error: function(req, res, status) {
            return callback(false);
        }
    });
}

function Timer(selector) {
    var dt = new Date()
    document.getElementById(selector).innerHTML = dt.getHours() + ":" + dt.getMinutes() + ":" + dt.getSeconds();
    setTimeout("Timer()", 1000);
}

function gettodaydate() {
    let today = new Date();
    let dd = String(today.getDate()).padStart(2, '0');
    let mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
    let yyyy = today.getFullYear();
    return today = mm + '/' + dd + '/' + yyyy;
}

function gettoday_seperated(params) {
    let today = new Date();
    let dd = String(today.getDate()).padStart(2, '0');
    let mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
    let yyyy = today.getFullYear();
    return Array(yyyy.toString(), mm, dd);
}

function bytesToSize(bytes) {
    var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
    if (bytes == 0) return '0 Byte';
    var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
    return Math.round(bytes / Math.pow(1024, i), 2) + ' ' + sizes[i];
}

function printDiv(divName) {
    var printContents = document.getElementById(divName).innerHTML;
    var originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;
}

function printClick() {
    var w = window.open('', 'printform', 'width=300,height=400');
    var html = $("#prntrForm").html();
    $(w.document.body).html(html);
    w.print();
}

// 'ADSL(Share)' 'ADSL(Transport)' 'VDSL(Share)' 
//'VDSL(Transport)' 'Wireless(Share)' 'Wireless(Transport)' 'Wireless(Hotspot)' 'TD-LTE(Share)' 'TD-LTE(Transport)'
// 'carti' 'etebari'