$(document).ready(function() {
    (function(b) {
        ///////clock//////
        function a(n, q, i) {
            var h = b(n)[0];
            var r = h.getContext("2d");
            var d = h.height;
            var s = 0;
            if (q.hasShadow) { s = q.shadowBlur }
            var j = h.height / 2 - s;
            var f = 2 * Math.PI / 60;
            var c = 2 * Math.PI / 12;
            var e = function() {
                b(h).css("max-width", "100%");
                b(h).css("width", b(h).css("height"));
                h.width = h.height;
                if (q.hasShadow) {
                    r.shadowOffsetX = 0;
                    r.shadowOffsetY = 0;
                    r.shadowBlur = q.shadowBlur;
                    r.shadowColor = q.shadowColor
                }
                l()
            };
            var m = function(x) { return x / 100 * j };
            var o = function() {
                r.lineWidth = m(q.majorTicksLength);
                r.strokeStyle = q.majorTicksColor;
                for (var x = 1; x <= 12; x++) {
                    r.beginPath();
                    r.arc(j + s, j + s, j - r.lineWidth / 2, x * c - m(q.majorTicksWidth) / 2, x * c + m(q.majorTicksWidth) / 2);
                    r.stroke()
                }
            };
            var w = function() {
                r.lineWidth = m(q.minorTicksLength);
                r.strokeStyle = q.minorTicksColor;
                for (var x = 1; x <= 60; x++) {
                    r.beginPath();
                    r.arc(j + s, j + s, j - r.lineWidth / 2, x * f - m(q.minorTicksWidth) / 2, x * f + m(q.minorTicksWidth) / 2);
                    r.stroke()
                }
            };
            var p = function() {
                r.strokeStyle = q.borderColor;
                r.lineWidth = m(q.borderWidth);
                r.beginPath();
                r.arc(j + s, j + s, j - r.lineWidth / 2, 0, 2 * Math.PI);
                r.stroke()
            };
            var t = function() {
                r.fillStyle = q.fillColor;
                r.lineWidth = m(q.borderWidth);
                r.beginPath();
                r.arc(j + s, j + s, j - r.lineWidth, 0, 2 * Math.PI);
                r.fill()
            };
            var u = function(E, D, C, B) {
                var z = E - Math.PI / 2;
                z = Math.cos(z) * m(D);
                var A = E - Math.PI / 2;
                var F = Math.sin(A) * m(D);
                r.lineWidth = m(C);
                r.strokeStyle = B;
                r.beginPath();
                r.moveTo(j + s, j + s);
                r.lineTo(j + s + z, j + s + F);
                r.stroke()
            };
            var g = function() {
                for (var B = 1; B <= 12; B++) {
                    var C = B * c;
                    var z = C - Math.PI / 2;
                    z = Math.cos(z) * m(80);
                    var A = C - Math.PI / 2;
                    var D = Math.sin(A) * m(80);
                    r.textAlign = "center";
                    r.textBaseline = "middle";
                    r.font = m(q.fontSize).toString() + "px " + q.fontName;
                    r.fillStyle = q.fontColor;
                    r.beginPath();
                    r.fillText(B.toString(), j + s + z, j + s + D);
                    r.stroke()
                }
            };
            var k = function() {
                r.fillStyle = q.pinColor;
                r.beginPath();
                r.arc(j + s, j + s, m(q.pinRadius), 0, 2 * Math.PI);
                r.fill()
            };
            var v = function(y, x) { var A = new Date(y.toLocaleString("en-US", { timeZone: x })); var z = y.getTime() - A.getTime(); return new Date(y.getTime() - z) };
            var l = function() {
                r.clearRect(0, 0, d, d);
                r.lineCap = "butt";
                if (q.drawFill) { t() }
                if (q.drawMinorTicks) { w() }
                if (q.drawMajorTicks) { o() }
                if (q.drawBorder) { p() }
                if (q.drawTexts) { g() }
                var y = new Date();
                if (i.timezone) { y = v(y, i.timezone) }
                var A = y.getSeconds();
                var x = y.getMinutes();
                var z = y.getHours();
                x += A / 60;
                z += x / 60;
                r.lineCap = "round";
                u(z * c, q.hourHandLength, q.hourHandWidth, q.hourHandColor);
                u(x * f, q.minuteHandLength, q.minuteHandWidth, q.minuteHandColor);
                if (q.drawSecondHand) { u(A * f, q.secondHandLength, q.secondHandWidth, q.secondHandColor) }
                if (q.drawPin) { k() }
                window.requestAnimationFrame(function() { l(this) })
            };
            e()
        }
        b.fn.htAnalogClock = function(d, c) {
            return this.each(function() {
                var f = b.extend({}, htAnalogClock.preset_default, d || {});
                var e = b.extend({}, b.fn.htAnalogClock.defaultOptions, c || {});
                a(this, f, e)
            })
        };
        b.fn.htAnalogClock.defaultOptions = { timezone: null }
    }(jQuery));

    function htAnalogClock() {}
    htAnalogClock.preset_default = { hasShadow: true, shadowColor: "#000", shadowBlur: 10, drawSecondHand: true, drawMajorTicks: true, drawMinorTicks: true, drawBorder: true, drawFill: true, drawTexts: true, drawPin: true, majorTicksColor: "#f88", minorTicksColor: "#fa0", majorTicksLength: 10, minorTicksLength: 7, majorTicksWidth: 0.005, minorTicksWidth: 0.0025, fillColor: "#333", pinColor: "#f88", pinRadius: 5, borderColor: "#000", borderWidth: 2, secondHandColor: "#f00", minuteHandColor: "#fff", hourHandColor: "#fff", fontColor: "#fff", fontName: "Tahoma", fontSize: 10, secondHandLength: 90, minuteHandLength: 70, hourHandLength: 50, secondHandWidth: 1, minuteHandWidth: 2, hourHandWidth: 3 };
    htAnalogClock.preset_gray_fantastic = { minorTicksLength: 100, minorTicksColor: "rgba(255, 255, 255, 0.2)", majorTicksLength: 100, majorTicksColor: "rgba(255, 255, 255, 0.6)", pinColor: "#aaa", pinRadius: 5, hourHandColor: "#fff", hourHandWidth: 5, minuteHandColor: "#eee", minuteHandWidth: 3, secondHandLength: 95 };
    htAnalogClock.preset_black_bolded = { drawBorder: false, majorTicksColor: "rgba(255, 150, 150, 0.8)", majorTicksWidth: 0.05, drawMinorTicks: false, fillColor: "#000" };
    htAnalogClock.preset_white_nice = { fillColor: "#fff", hourHandColor: "#000", minuteHandColor: "#000", fontColor: "#333", majorTicksColor: "#222", minorTicksColor: "#555" };
    htAnalogClock.preset_ocean_blue = { fillColor: "#4460cb", hourHandColor: "#fff", minuteHandColor: "#fff", fontColor: "#ddd", majorTicksColor: "#bbb", minorTicksColor: "#aaa", fontName: "Sahel FD", fontSize: 15, secondHandColor: "#f80" };
    htAnalogClock.preset_nice_bolded = { secondHandWidth: 5, hourHandWidth: 10, minuteHandWidth: 7, pinRadius: 10, pinColor: "#fff", fillColor: "#444", drawTexts: false, majorTicksWidth: 0.07, minorTicksWidth: 0.03, majorTicksLength: 50, minorTicksLength: 25, majorTicksColor: "rgba(255, 150, 0, 0.6)", minorTicksColor: "rgba(0, 150, 250, 0.5)" };
    htAnalogClock.preset_modern_dark = { majorTicksLength: 50, minorTicksLength: 50, majorTicksWidth: 0.02, minorTicksWidth: 0.0075, fillColor: "#333", pinColor: "#000", pinRadius: 90, borderColor: "transparent", secondHandColor: "#0f0", minuteHandColor: "#fff", hourHandColor: "#fff", secondHandLength: 100, minuteHandLength: 100, hourHandLength: 97, secondHandWidth: 5, minuteHandWidth: 3, hourHandWidth: 10 };

    function htAnalogClock() {}
    htAnalogClock.preset_default = {
        hasShadow: true,
        shadowColor: "#000",
        shadowBlur: 10,

        drawSecondHand: true,
        drawMajorTicks: true,
        drawMinorTicks: true,
        drawBorder: true,
        drawFill: true,
        drawTexts: true,
        drawPin: true,

        majorTicksColor: "#f88",
        minorTicksColor: "#fa0",

        majorTicksLength: 10.0,
        minorTicksLength: 7.0,
        majorTicksWidth: 0.005,
        minorTicksWidth: 0.0025,

        fillColor: "#333",
        pinColor: "#f88",
        pinRadius: 5.0,

        borderColor: "#000",
        borderWidth: 2.0,

        secondHandColor: "#f00",
        minuteHandColor: "#fff",
        hourHandColor: "#fff",

        fontColor: "#fff",
        fontName: "Tahoma",
        fontSize: 10.0,

        secondHandLength: 90.0,
        minuteHandLength: 70.0,
        hourHandLength: 50.0,

        secondHandWidth: 1.0,
        minuteHandWidth: 2.0,
        hourHandWidth: 3.0
    };

    let today = gettoday_seperated();
    today = tabdile_tarikh_adad(today[0] + '-' + today[1] + '-' + today[2]);
    $('#today_date').text(today);


    htAnalogClock.preset_gray_fantastic = {
        minorTicksLength: 100.0,
        minorTicksColor: "rgba(255, 255, 255, 0.2)",
        majorTicksLength: 100.0,
        majorTicksColor: "rgba(255, 255, 255, 0.6)",
        pinColor: "#aaa",
        pinRadius: 5.0,
        hourHandColor: "#fff",
        hourHandWidth: 5.0,
        minuteHandColor: "#eee",
        minuteHandWidth: 3.0,
        secondHandLength: 95.0
    };


    htAnalogClock.preset_black_bolded = {
        drawBorder: false,
        majorTicksColor: "rgba(255, 150, 150, 0.8)",
        majorTicksWidth: 0.05,
        drawMinorTicks: false,
        fillColor: "#000"
    };


    htAnalogClock.preset_white_nice = {
        fillColor: "#fff",
        hourHandColor: "#000",
        minuteHandColor: "#000",
        fontColor: "#333",
        majorTicksColor: "#222",
        minorTicksColor: "#555"
    };


    htAnalogClock.preset_ocean_blue = {
        fillColor: "#4460cb",
        hourHandColor: "#fff",
        minuteHandColor: "#fff",
        fontColor: "#ddd",
        majorTicksColor: "#bbb",
        minorTicksColor: "#aaa",
        fontName: "Sahel FD",
        fontSize: 15.0,
        secondHandColor: "#f80"
    };


    htAnalogClock.preset_nice_bolded = {
        secondHandWidth: 5.0,
        hourHandWidth: 10.0,
        minuteHandWidth: 7.0,
        pinRadius: 10.0,
        pinColor: "#fff",
        fillColor: "#444",
        drawTexts: false,
        majorTicksWidth: 0.07,
        minorTicksWidth: 0.03,
        majorTicksLength: 50.0,
        minorTicksLength: 25.0,
        majorTicksColor: "rgba(255, 150, 0, 0.6)",
        minorTicksColor: "rgba(0, 150, 250, 0.5)"
    };

    htAnalogClock.preset_modern_dark = {
        majorTicksLength: 50.0,
        minorTicksLength: 50.0,
        majorTicksWidth: 0.02,
        minorTicksWidth: 0.0075,

        fillColor: "#333",
        pinColor: "#000",
        pinRadius: 90.0,

        borderColor: "transparent",

        secondHandColor: "#0f0",
        minuteHandColor: "#fff",
        hourHandColor: "#fff",

        secondHandLength: 100.0,
        minuteHandLength: 100.0,
        hourHandLength: 97.0,

        secondHandWidth: 5.0,
        minuteHandWidth: 3.0,
        hourHandWidth: 10.0
    };
    $("#basic").htAnalogClock();


    ///INTERNET
    page_requests('dashboard', window.location.href, 'online_users', 'internet', '', function(data) {

        let online_user_count_internet = $("#online_user_count_internet");
        if (online_user_count_internet) {
            if (data) {
                online_user_count_internet.text(data);
            } else {
                online_user_count_internet.text('مشکل در برنامه');
            }
        }
    });
    page_requests('dashboard', window.location.href, 'expired_users', 'internet', '', function(data) {
        let expired_user_count_internet = $("#expired_user_count_internet");
        if (expired_user_count_internet) {
            if (data) {
                expired_user_count_internet.text(data[0]);
            } else {
                expired_user_count_internet.text('مشکل در برنامه');
            }
        }
    });
    page_requests('dashboard', window.location.href, 'seven_days_expired', 'internet', '', function(data) {
        let seven_days_expired_user_count_internet = $("#seven_days_expired_user_count_internet");
        if (seven_days_expired_user_count_internet) {
            if (data) {
                seven_days_expired_user_count_internet.text(data[0]);
            } else {
                seven_days_expired_user_count_internet.text('مشکل در برنامه');
            }
        }
    });
    ///VOIP
    page_requests('dashboard', window.location.href, 'online_users', 'voip', '', function(data) {
        let online_user_count_voip = $("#online_user_count_voip");
        if (online_user_count_voip) {
            if (data) {
                online_user_count_voip.text(0);
            } else {
                online_user_count_voip.text('مشکل در برنامه');
            }
        }
    });
    page_requests('dashboard', window.location.href, 'expired_users', 'voip', '', function(data) {
        let expired_user_count_voip = $("#expired_user_count_voip");
        if (expired_user_count_voip) {
            if (data) {
                expired_user_count_voip.text(data[0]);
            } else {
                expired_user_count_voip.text('مشکل در برنامه');
            }
        }
    });
    page_requests('dashboard', window.location.href, 'seven_days_expired', 'voip', '', function(data) {
        let seven_days_expired_user_count_voip = $("#seven_days_expired_user_count_voip");
        if (seven_days_expired_user_count_voip) {
            if (data) {
                seven_days_expired_user_count_voip.text(data[0]);
            } else {
                seven_days_expired_user_count_voip.text('مشکل در برنامه');
            }
        }
    });
    // page_requests('dashboard', window.location.href, 'subscriber_request', '', '', function(data) {
    //     console.log(data);
    // });

    ajaxRequest('currentuserestauth',{'userid':1},window.location.href,function(res){
        console.log(123);
        console.log(res);
        console.log(123);
        let subscriber_ehraze_hoviat= $("#subscriber_ehraze_hoviat");
            // subscriber_ehraze_hoviat.text(res[0]['comment']);
        subscriber_ehraze_hoviat.text(res['Message']);
        
    });

    ajaxRequest('currentuserecredit',{'userid':1},window.location.href,function(res){
        console.log(res);
        let subscriber_etebare_mali= $("#subscriber_etebare_mali");
        if(! check_isset_message(res)){
            subscriber_etebare_mali.text(numberWithCommas(res[0]['credit'])+" "+"ریال");
        }else{
            subscriber_etebare_mali.text("حسابی برای کاربر ساخته نشده");
        }
    });
    ajaxRequest('currentuserservicesinfo',{'userid':1},window.location.href,function(res){
        console.log(res);
        let services_tbody= $("#services_tbody");
        let si="";//service_info
        if(res){
            for (let i = 0; i < res.length; i++) {
                if(res[i]['ibsinfo']){
                    si+="<tr>";
                        si+="<td>";
                           si+="<span class='text-default font-weight-semibold' id='serviceinfo'>";
                            si+=res[i]['ibsusername'];
                            si+="</span>";
                        si+="</td>"; 
                        si+="<td>";
                           si+="<span class='text-default font-weight-semibold' id='servicetype'>";
                            si+=res[i]['sertype'];
                            si+="</span>";
                        si+="</td>"; 
                        si+="<td style='direction:ltr;'>";
                            si+="<span class='text-default font-weight-semibold' id='tarikhe_payan'>";
                            si+=res[i]['ibsinfo']['basic_info']['nearest_exp_date'];
                            si+="</span>";
                        si+="</td>";
                        si+="<td>";
                            si+="<span class='text-default font-weight-semibold' id='credit'>";
                            si+=res[i]['ibsinfo']['basic_info']['credit'];
                            si+="</span>";
                        si+="</td>";
                    si+="</tr>";
                }else{
                    //no ibsinfo
                    si+="<tr>";
                        si+="<td>";
                            si+="<span class='text-default font-weight-semibold' id='serviceinfo'>";
                            si+=res[i]['ibsusername'];
                            si+="</span>";
                        si+="</td>";
                        si+="<td>";
                           si+="<span class='text-default font-weight-semibold' id='servicetype'>";
                            si+=res[i]['sertype'];
                            si+="</span>";
                        si+="</td>"; 
                        si+="<td>";
                            si+="<span class='text-default font-weight-semibold' id='tarikhe_payan'>";
                            si+="---";
                            si+="</span>";
                        si+="</td>";
                        si+="<td>";
                            si+="<span class='text-default font-weight-semibold' id='credit'>";
                            si+="---";
                            si+="</span>";
                        si+="</td>";
                    si+="</tr>";
                }
            }
            
        }else{
            //add a row and write you have no service
            si+="<tr>";
                        si+="<td>";
                            si+="<span class='text-default font-weight-semibold' id='serviceinfo'>";
                            si+="سرویسی یافت نشد";
                            si+="</span>";
                        si+="</td>";
                        si+="<td>";
                           si+="<span class='text-default font-weight-semibold' id='servicetype'>";
                            si+='---';
                            si+="</span>";
                        si+="</td>"; 
                        si+="<td>";
                            si+="<span class='text-default font-weight-semibold' id='tarikhe_payan'>";
                            si+="---";
                            si+="</span>";
                        si+="</td>";
                        si+="<td>";
                            si+="<span class='text-default font-weight-semibold' id='credit'>";
                            si+="---";
                            si+="</span>";
                        si+="</td>";
                    si+="</tr>";
        }
        $(si).appendTo(services_tbody);
        
    });
});