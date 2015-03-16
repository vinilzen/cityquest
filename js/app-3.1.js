/*
 *  Document   : app.js
 *  Author     : pixelcave
 */
var App = function() {
    var a, e, i, s, t, n, l, o, r = function() {
            a = $("#page-container"), e = $("#page-content"), i = $("header"), s = $("#page-content + footer"), t = $("#sidebar"), n = $("#sidebar-scroll"), l = $("#sidebar-alt"), o = $("#sidebar-alt-scroll"), g("init"), h(), p(), m(), v(), b(), $(window).resize(function() {
                b()
            }), 
            $(window).bind("orientationchange", b);
            var r = $("#year-copy"),
                d = new Date;
            r.html(2014 === d.getFullYear() ? "2014" : "2014-" + d.getFullYear().toString().substr(2, 2)), f(), $('[data-toggle="tabs"] a, .enable-tabs a').click(function(a) {
                a.preventDefault(), $(this).tab("show")
            }), $('[data-toggle="tooltip"], .enable-tooltip').tooltip({
                container: "body",
                animation: !1
            }), $('[data-toggle="popover"], .enable-popover').popover({
                container: "body",
                animation: !0
            }), $('[data-toggle="lightbox-gallery"]').each(function() {
                $(this).magnificPopup({
                    delegate: "a.gallery-link",
                    type: "image",
                    gallery: {
                        enabled: !0,
                        navigateByImgClick: !0,
                        arrowMarkup: '<button type="button" class="mfp-arrow mfp-arrow-%dir%" title="%title%"></button>',
                        tPrev: "Previous",
                        tNext: "Next",
                        tCounter: '<span class="mfp-counter">%curr% of %total%</span>'
                    },
                    image: {
                        titleSrc: "title"
                    }
                })
            });
            var c = ["Afghanistan", "Albania", "Algeria", "American Samoa", "Andorra", "Angola", "Anguilla", "Antarctica", "Antigua and Barbuda", "Argentina", "Armenia", "Aruba", "Australia", "Austria", "Azerbaijan", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia", "Bosnia and Herzegovina", "Botswana", "Bouvet Island", "Brazil", "British Indian Ocean Territory", "British Virgin Islands", "Brunei", "Bulgaria", "Burkina Faso", "Burundi", "CΓ΄te d'Ivoire", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Cayman Islands", "Central African Republic", "Chad", "Chile", "China", "Christmas Island", "Cocos (Keeling) Islands", "Colombia", "Comoros", "Congo", "Cook Islands", "Costa Rica", "Croatia", "Cuba", "Cyprus", "Czech Republic", "Democratic Republic of the Congo", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "East Timor", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Faeroe Islands", "Falkland Islands", "Fiji", "Finland", "Former Yugoslav Republic of Macedonia", "France", "French Guiana", "French Polynesia", "French Southern Territories", "Gabon", "Georgia", "Germany", "Ghana", "Gibraltar", "Greece", "Greenland", "Grenada", "Guadeloupe", "Guam", "Guatemala", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Heard Island and McDonald Islands", "Honduras", "Hong Kong", "Hungary", "Iceland", "India", "Indonesia", "Iran", "Iraq", "Ireland", "Israel", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Kuwait", "Kyrgyzstan", "Laos", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libya", "Liechtenstein", "Lithuania", "Luxembourg", "Macau", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Martinique", "Mauritania", "Mauritius", "Mayotte", "Mexico", "Micronesia", "Moldova", "Monaco", "Mongolia", "Montserrat", "Morocco", "Mozambique", "Myanmar", "Namibia", "Nauru", "Nepal", "Netherlands", "Netherlands Antilles", "New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Niue", "Norfolk Island", "North Korea", "Northern Marianas", "Norway", "Oman", "Pakistan", "Palau", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Pitcairn Islands", "Poland", "Portugal", "Puerto Rico", "Qatar", "RΓ©union", "Romania", "Russia", "Rwanda", "SΓ£o TomΓ© and PrΓ­ncipe", "Saint Helena", "Saint Kitts and Nevis", "Saint Lucia", "Saint Pierre and Miquelon", "Saint Vincent and the Grenadines", "Samoa", "San Marino", "Saudi Arabia", "Senegal", "Seychelles", "Sierra Leone", "Singapore", "Slovakia", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Georgia and the South Sandwich Islands", "South Korea", "Spain", "Sri Lanka", "Sudan", "Suriname", "Svalbard and Jan Mayen", "Swaziland", "Sweden", "Switzerland", "Syria", "Taiwan", "Tajikistan", "Tanzania", "Thailand", "The Bahamas", "The Gambia", "Togo", "Tokelau", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan", "Turks and Caicos Islands", "Tuvalu", "US Virgin Islands", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States", "United States Minor Outlying Islands", "Uruguay", "Uzbekistan", "Vanuatu", "Vatican City", "Venezuela", "Vietnam", "Wallis and Futuna", "Western Sahara", "Yemen", "Yugoslavia", "Zambia", "Zimbabwe"];
            $(".input-datepicker, .input-daterange").datepicker({
                weekStart: 1
            }), $(".input-datepicker-close").datepicker({
                weekStart: 1
            }).on("changeDate", function() {
                $(this).datepicker("hide")
            })
        },
        d = function() {
            var a = $("#page-wrapper");
            a.hasClass("page-loading") && a.removeClass("page-loading")
        },
        c = function() {
            return window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth
        },
        h = function() {
            var e = 250,
                i = 250,
                s = $(".sidebar-nav-menu"),
                t = $(".sidebar-nav-submenu");
            s.click(function() {
                var s = $(this);
                return a.hasClass("sidebar-mini") && a.hasClass("sidebar-visible-lg-mini") && c() > 991 ? s.hasClass("open") ? s.removeClass("open") : ($(".sidebar-nav-menu.open").removeClass("open"), s.addClass("open")) : s.parent().hasClass("active") || (s.hasClass("open") ? (s.removeClass("open").next().slideUp(e, function() {
                    u(s, 200, 300)
                }), setTimeout(b, e)) : ($(".sidebar-nav-menu.open").removeClass("open").next().slideUp(e), s.addClass("open").next().slideDown(i, function() {
                    u(s, 150, 600)
                }), setTimeout(b, e > i ? e : i))), !1
            }), t.click(function() {
                var a = $(this);
                return a.parent().hasClass("active") !== !0 && (a.hasClass("open") ? (a.removeClass("open").next().slideUp(e, function() {
                    u(a, 200, 300)
                }), setTimeout(b, e)) : (a.closest("ul").find(".sidebar-nav-submenu.open").removeClass("open").next().slideUp(e), a.addClass("open").next().slideDown(i, function() {
                    u(a, 150, 600)
                }), setTimeout(b, e > i ? e : i))), !1
            })
        },
        u = function(e, s, t) {
            if (!a.hasClass("disable-menu-autoscroll")) {
                var n;
                if (i.hasClass("navbar-fixed-top") || i.hasClass("navbar-fixed-bottom")) {
                    var l = e.parents("#sidebar-scroll"),
                        o = e.offset().top + Math.abs($("div:first", l).offset().top);
                    n = o - s > 0 ? o - s : 0, l.animate({
                        scrollTop: n
                    }, t)
                } else {
                    var r = e.offset().top;
                    n = r - s > 0 ? r - s : 0, $("html, body").animate({
                        scrollTop: n
                    }, t)
                }
            }
        },
        g = function(e, i) {
            if ("init" === e) g("sidebar-scroll"), g("sidebar-alt-scroll"), $(".sidebar-partial #sidebar").mouseenter(function() {
                g("close-sidebar-alt")
            }), $(".sidebar-alt-partial #sidebar-alt").mouseenter(function() {
                g("close-sidebar")
            });
            else {
                var s = c();
                if ("toggle-sidebar" === e) s > 991 ? (a.toggleClass("sidebar-visible-lg"), a.hasClass("sidebar-mini") && a.toggleClass("sidebar-visible-lg-mini"), a.hasClass("sidebar-visible-lg") && g("close-sidebar-alt"), "toggle-other" === i && (a.hasClass("sidebar-visible-lg") || g("open-sidebar-alt"))) : (a.toggleClass("sidebar-visible-xs"), a.hasClass("sidebar-visible-xs") && g("close-sidebar-alt")), g("sidebar-scroll");
                else if ("toggle-sidebar-alt" === e) s > 991 ? (a.toggleClass("sidebar-alt-visible-lg"), a.hasClass("sidebar-alt-visible-lg") && g("close-sidebar"), "toggle-other" === i && (a.hasClass("sidebar-alt-visible-lg") || g("open-sidebar"))) : (a.toggleClass("sidebar-alt-visible-xs"), a.hasClass("sidebar-alt-visible-xs") && g("close-sidebar"));
                else if ("open-sidebar" === e) s > 991 ? (a.hasClass("sidebar-mini") && a.removeClass("sidebar-visible-lg-mini"), a.addClass("sidebar-visible-lg")) : a.addClass("sidebar-visible-xs"), g("close-sidebar-alt");
                else if ("open-sidebar-alt" === e) a.addClass(s > 991 ? "sidebar-alt-visible-lg" : "sidebar-alt-visible-xs"), g("close-sidebar");
                else if ("close-sidebar" === e) s > 991 ? (a.removeClass("sidebar-visible-lg"), a.hasClass("sidebar-mini") && a.addClass("sidebar-visible-lg-mini")) : a.removeClass("sidebar-visible-xs");
                else if ("close-sidebar-alt" === e) a.removeClass(s > 991 ? "sidebar-alt-visible-lg" : "sidebar-alt-visible-xs");
                else if ("sidebar-scroll" == e) {
                    if (a.hasClass("sidebar-mini") && a.hasClass("sidebar-visible-lg-mini") && s > 991) n.length && n.parent(".slimScrollDiv").length && (n.slimScroll({
                        destroy: !0
                    }), n.attr("style", ""));
                    else if (a.hasClass("header-fixed-top") || a.hasClass("header-fixed-bottom")) {
                        var t = $(window).height();
                        if (n.length && !n.parent(".slimScrollDiv").length) {
                            n.slimScroll({
                                height: t,
                                color: "#fff",
                                size: "3px",
                                touchScrollStep: 100
                            });
                            var l;
                            $(window).on("resize orientationchange", function() {
                                clearTimeout(l), l = setTimeout(function() {
                                    g("sidebar-scroll")
                                }, 150)
                            })
                        } else n.add(n.parent()).css("height", t)
                    }
                } else if ("sidebar-alt-scroll" == e && (a.hasClass("header-fixed-top") || a.hasClass("header-fixed-bottom"))) {
                    var r = $(window).height();
                    if (o.length && !o.parent(".slimScrollDiv").length) {
                        o.slimScroll({
                            height: r,
                            color: "#fff",
                            size: "3px",
                            touchScrollStep: 100
                        });
                        var d;
                        $(window).on("resize orientationchange", function() {
                            clearTimeout(d), d = setTimeout(function() {
                                g("sidebar-alt-scroll")
                            }, 150)
                        })
                    } else o.add(o.parent()).css("height", r)
                }
            }
            return !1
        },
        b = function() {
            var n = $(window).height(),
                o = t.outerHeight(),
                r = l.outerHeight(),
                d = i.outerHeight(),
                c = s.outerHeight();
            i.hasClass("navbar-fixed-top") || i.hasClass("navbar-fixed-bottom") || n > o && n > r ? a.hasClass("footer-fixed") ? e.css("min-height", n - d + "px") : e.css("min-height", n - (d + c) + "px") : a.hasClass("footer-fixed") ? e.css("min-height", (o > r ? o : r) - d + "px") : e.css("min-height", (o > r ? o : r) - (d + c) + "px")
        },
        p = function() {
            $('[data-toggle="block-toggle-content"]').on("click", function() {
                var a = $(this).closest(".block").find(".block-content");
                $(this).hasClass("active") ? a.slideDown() : a.slideUp(), $(this).toggleClass("active")
            }), $('[data-toggle="block-toggle-fullscreen"]').on("click", function() {
                var a = $(this).closest(".block");
                $(this).hasClass("active") ? a.removeClass("block-fullscreen") : a.addClass("block-fullscreen"), $(this).toggleClass("active")
            }), $('[data-toggle="block-hide"]').on("click", function() {
                $(this).closest(".block").fadeOut()
            })
        },
        m = function() {
            var a = $("#to-top");
            $(window).scroll(function() {
                $(this).scrollTop() > 150 && c() > 991 ? a.fadeIn(100) : a.fadeOut(100)
            }), a.click(function() {
                return $("html, body").animate({
                    scrollTop: 0
                }, 400), !1
            })
        },
        f = function() { },
        v = function() {
            var e, s = $(".sidebar-themes"),
                t = $("#theme-link"),
                n = t.length ? t.attr("href") : "default",
                l = a.hasClass("enable-cookies") ? !0 : !1;
            l && (e = $.cookie("optionThemeColor") ? $.cookie("optionThemeColor") : !1, e && ("default" === e ? t.length && (t.remove(), t = $("#theme-link")) : t.length ? t.attr("href", e) : ($('link[href="css/themes-3.1.css"]').before('<link id="theme-link" rel="stylesheet" href="' + e + '">'), t = $("#theme-link"))), n = e ? e : n), $('a[data-theme="' + n + '"]', s).parent("li").addClass("active"), $("a", s).click(function() {
                n = $(this).data("theme"), $("li", s).removeClass("active"), $(this).parent("li").addClass("active"), "default" === n ? t.length && (t.remove(), t = $("#theme-link")) : t.length ? t.attr("href", n) : ($('link[href="css/themes-3.1.css"]').before('<link id="theme-link" rel="stylesheet" href="' + n + '">'), t = $("#theme-link")), l && $.cookie("optionThemeColor", n, {
                    expires: 7
                })
            }), $(".dropdown-options a").click(function(a) {
                a.stopPropagation()
            });
            var o = $("#options-main-style"),
                r = $("#options-main-style-alt");
            a.hasClass("style-alt") ? r.addClass("active") : o.addClass("active"), o.click(function() {
                a.removeClass("style-alt"), $(this).addClass("active"), r.removeClass("active")
            }), r.click(function() {
                a.addClass("style-alt"), $(this).addClass("active"), o.removeClass("active")
            });
            var d = $("#options-header-default"),
                c = $("#options-header-inverse");
            i.hasClass("navbar-default") ? d.addClass("active") : c.addClass("active"), d.click(function() {
                i.removeClass("navbar-inverse").addClass("navbar-default"), $(this).addClass("active"), c.removeClass("active")
            }), c.click(function() {
                i.removeClass("navbar-default").addClass("navbar-inverse"), $(this).addClass("active"), d.removeClass("active")
            })
        },
        C = function() {
            $.extend(!0, $.fn.dataTable.defaults, {
                sDom: "<'row'<'col-sm-6 col-xs-5'l><'col-sm-6 col-xs-7'f>r>t<'row'<'col-sm-5 hidden-xs'i><'col-sm-7 col-xs-12 clearfix'p>>",
                sPaginationType: "bootstrap",
                oLanguage: {
                    sLengthMenu: "_MENU_",
                    sSearch: '<div class="input-group">_INPUT_<span class="input-group-addon"><i class="fa fa-search"></i></span></div>',
                    sInfo: "<strong>_START_</strong>-<strong>_END_</strong> of <strong>_TOTAL_</strong>",
                    oPaginate: {
                        sPrevious: "",
                        sNext: ""
                    }
                }
            }), $.extend($.fn.dataTableExt.oStdClasses, {
                sWrapper: "dataTables_wrapper form-inline",
                sFilterInput: "form-control",
                sLengthSelect: "form-control"
            })
        },
        k = function() {
            var e = a.prop("class");
            a.prop("class", ""), window.print(), a.prop("class", e)
        };
    return {
        init: function() {
            r(), d()
        },
        sidebar: function(a, e) {
            g(a, e)
        },
        datatables: function() {
            C()
        },
        pagePrint: function() {
            k()
        }
    }
}();
$(function() {
    App.init()
});