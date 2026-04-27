"use strict";
let isRtl = window.Helpers.isRtl(),
    isDarkStyle = window.Helpers.isDarkStyle(),
    menu, animate, isHorizontalLayout = !1;
document.getElementById("layout-menu") && (isHorizontalLayout = document.getElementById("layout-menu").classList.contains("menu-horizontal")),
    function() {
        let d = document.querySelectorAll("#layout-menu"),
            u = (d.forEach(function(e) {
                menu = new Menu(e, {
                    orientation: isHorizontalLayout ? "horizontal" : "vertical",
                    closeChildren: !!isHorizontalLayout,
                    showDropdownOnHover: localStorage.getItem("templateCustomizer-" + 'templateName' + "--ShowDropdownOnHover") ? "true" === localStorage.getItem("templateCustomizer-" + 'templateName' + "--ShowDropdownOnHover") : void 0 === window.templateCustomizer || window.templateCustomizer.settings.defaultShowDropdownOnHover
                }), window.Helpers.scrollToActive(animate = !1), window.Helpers.mainMenu = menu
            }), document.querySelectorAll(".layout-menu-toggle"));
        u.forEach(e => {
            e.addEventListener("click", e => {
                if (e.preventDefault(), window.Helpers.toggleCollapsed(), !window.Helpers.isSmallScreen()) try {
                    localStorage.setItem("templateCustomizer-" + 'templateName' + "--LayoutCollapsed", String(window.Helpers.isCollapsed()))
                } catch (e) {}
            })
        });
        if (document.getElementById("layout-menu")) {
            var t = document.getElementById("layout-menu");
            var o = function() {
                Helpers.isSmallScreen() || document.querySelector(".layout-menu-toggle").classList.add("d-block")
            };
            let e = null;
            t.onmouseenter = function() {
                e = Helpers.isSmallScreen() ? setTimeout(o, 0) : setTimeout(o, 300)
            }, t.onmouseleave = function() {
                document.querySelector(".layout-menu-toggle").classList.remove("d-block"), clearTimeout(e)
            }
        }
        window.Helpers.swipeIn(".drag-target", function(e) {
            window.Helpers.setCollapsed(!1)
        }), window.Helpers.swipeOut("#layout-menu", function(e) {
            window.Helpers.isSmallScreen() && window.Helpers.setCollapsed(!0)
        });
        let e = document.getElementsByClassName("menu-inner"),
            n = document.getElementsByClassName("menu-inner-shadow")[0],
            s = (0 < e.length && n && e[0].addEventListener("ps-scroll-y", function() {
                this.querySelector(".ps__thumb-y").offsetTop ? n.style.display = "block" : n.style.display = "none"
            }), document.querySelector(".style-switcher-toggle"));

        function a(o) {
            const e = [].slice.call(document.querySelectorAll("[data-app-" + o + "-img]"));
            e.map(function(e) {
                var t = e.getAttribute("data-app-" + o + "-img");
                e.src = assetsPath + "img/" + t
            })
        }
        window.templateCustomizer && (s && s.addEventListener("click", function() {
            window.Helpers.isLightStyle() ? window.templateCustomizer.setStyle("dark") : window.templateCustomizer.setStyle("light")
        }), window.Helpers.isLightStyle() ? (s && (s.querySelector("i").classList.add("bx-moon"), new bootstrap.Tooltip(s, {
            title: "Dark mode",
            fallbackPlacements: ["bottom"]
        })), a("light")) : (s && (s.querySelector("i").classList.add("bx-sun"), new bootstrap.Tooltip(s, {
            title: "Light mode",
            fallbackPlacements: ["bottom"]
        })), a("dark"))), "undefined" != typeof i18next && "undefined" != typeof i18nextXHRBackend && i18next.use(i18nextXHRBackend).init({
            lng: "en",
            debug: !1,
            fallbackLng: "en",
            backend: {
                loadPath: assetsPath + "json/locales/{{lng}}.json"
            },
            returnObjects: !0
        }).then(function(e) {
            i()
        });
        let l = document.getElementsByClassName("dropdown-language");
        if (l.length) {
            let t = l[0].querySelectorAll(".dropdown-item");
            for (let e = 0; e < t.length; e++) t[e].addEventListener("click", function() {
                let e = this.getAttribute("data-language"),
                    t = this.querySelector(".flag-icon").getAttribute("class"),
                    o = t.split(" ").filter(function(e) {
                        return 0 !== e.lastIndexOf("fs-", 0)
                    });
                t = o.join(" ").trim() + " fs-3";
                for (var n of this.parentNode.children) n.classList.remove("selected");
                this.classList.add("selected"), l[0].querySelector(".dropdown-toggle .flag-icon").className = t, i18next.changeLanguage(e, (e, t) => {
                    if (e) return console.log("something went wrong loading", e);
                    i()
                })
            })
        }

        function i() {
            let e = document.querySelectorAll("[data-i18n]"),
                t = document.querySelector('.dropdown-item[data-language="' + i18next.language + '"]');
            t && t.click(), e.forEach(function(e) {
                e.innerHTML = i18next.t(e.dataset.i18n)
            })
        }

        function r(e) {
            "show.bs.collapse" == e.type || "show.bs.collapse" == e.type ? e.target.closest(".accordion-item").classList.add("active") : e.target.closest(".accordion-item").classList.remove("active")
        }
        const m = document.querySelector(".dropdown-notifications-all"),
            c = document.querySelectorAll(".dropdown-notifications-read"),
            p = (m && m.addEventListener("click", e => {
                c.forEach(e => {
                    e.closest(".dropdown-notifications-item").classList.add("marked-as-read")
                })
            }), c && c.forEach(t => {
                t.addEventListener("click", e => {
                    t.closest(".dropdown-notifications-item").classList.toggle("marked-as-read")
                })
            }), document.querySelectorAll(".dropdown-notifications-archive")),
            g = (p.forEach(t => {
                t.addEventListener("click", e => {
                    t.closest(".dropdown-notifications-item").remove()
                })
            }), [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))),
            w = (g.map(function(e) {
                return new bootstrap.Tooltip(e)
            }), [].slice.call(document.querySelectorAll(".accordion")));
        w.map(function(e) {
            e.addEventListener("show.bs.collapse", r), e.addEventListener("hide.bs.collapse", r)
        });
        if (isRtl && Helpers._addClass("dropdown-menu-end", document.querySelectorAll("#layout-navbar .dropdown-menu")), window.Helpers.setAutoUpdate(!0), window.Helpers.initPasswordToggle(), window.Helpers.initSpeechToText(), window.Helpers.initNavbarDropdownScrollbar(), window.addEventListener("resize", function(e) {
                window.innerWidth >= window.Helpers.LAYOUT_BREAKPOINT && document.querySelector(".search-input-wrapper") && (document.querySelector(".search-input-wrapper").classList.add("d-none"), document.querySelector(".search-input").value = ""), document.querySelector("[data-template^='horizontal-menu']") && setTimeout(function() {
                    window.innerWidth < window.Helpers.LAYOUT_BREAKPOINT ? document.getElementById("layout-menu").classList.contains("menu-horizontal") && menu.switchMenu("vertical") : document.getElementById("layout-menu").classList.contains("menu-vertical") && menu.switchMenu("horizontal")
                }, 100)
            }, !0), !isHorizontalLayout && !window.Helpers.isSmallScreen() && ("undefined" != typeof TemplateCustomizer && window.templateCustomizer.settings.defaultMenuCollapsed && window.Helpers.setCollapsed(!0, !1), "undefined" != typeof config && config.enableMenuLocalStorage)) try {
            null !== localStorage.getItem("templateCustomizer-" + 'templateName' + "--LayoutCollapsed") && "false" !== localStorage.getItem("templateCustomizer-" + 'templateName' + "--LayoutCollapsed") && window.Helpers.setCollapsed("true" === localStorage.getItem("templateCustomizer-" + 'templateName' + "--LayoutCollapsed"), !1)
        } catch (e) {}
    }(), "undefined" != typeof $ && $(function() {
		
	});