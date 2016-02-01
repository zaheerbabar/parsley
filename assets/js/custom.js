$(function() {
    if ($("#header").length) {
        //$Nav = $("header nav");
        var a = $("#header");
        var b = $("#logo", a);
        b.before('<div id="menu-toggle"><a href="#navigation"><svg id="menu-svg" xmlns="http://www.w3.org/2000/svg" width="24px" height="16px" viewBox="0 0 24 16" role="img" aria-labelledby="menu-title"><title id="menu-title">Menu</title><rect fill="#3686BE" width="24" height="16"/><g><g id="menu-path"><path fill="#FFFFFF" d="M0.7,15.4h22.5V13H0.7V15.4z M0.7,9.3h22.5V6.8H0.7V9.3z M0.7,0.7v2.4h22.5V0.7H0.7z"/></g></g></svg></a></div>');
        var c = $("#nav-container");
        var d = $("#navigation");
        c.addClass("hide-section");
        a.find("#menu-toggle").find("a").click(function(b) {
            b.preventDefault();
            if (c.hasClass("hide-section")) {
                c.removeClass("hide-section");
                //c.slideDown( "slow" );
                d.focus();
            } else c.addClass("hide-section")
        });
    }
});


$(function() {
    if ($("#profile-switch").length) {
        var a = $("#profile-switch");
        var b = $("#profile-link");
        var c = $("#profiles-container");
        var d = $("li a.active");
        var e = $("#profiles");
        c.addClass("hide-section");
        a.click(function(b) {
            b.preventDefault();
            if (c.hasClass("hide-section")) {
                d.addClass("active");
                c.removeClass("hide-section");
                //c.slideDown( "slow" );
                e.focus();
            } else {
                c.addClass("hide-section");
                d.removeClass("active");
            }    
        });
    }
});

$(function() {
    if ($("#template-switch").length) {
        var a = $("#template-switch");
        var b = $("#template-link");
        var c = $("#templates-container");
        var d = $("li a.active");
        var e = $("#templates");
        c.addClass("hide-section");
        a.click(function(b) {
            b.preventDefault();
            if (c.hasClass("hide-section")) {
                d.addClass("active");
                c.removeClass("hide-section");
                //c.slideDown( "slow" );
                e.focus();
            } else {
                c.addClass("hide-section");
                d.removeClass("active");
            }    
        });
    }
});

$(function() {
    if ($(".template-actions").length) {
        var a = $(".template-actions");
        var b = $(".template-actions-link");
        var c = $(".template-actions-container");
        var d = $("li a.active");
        var e = $(".template-actions-list");
        c.addClass("hide-section");
        a.click(function(b) {
            b.preventDefault();
            if (c.hasClass("hide-section")) {
                d.addClass("active");
                c.removeClass("hide-section");
                //c.slideDown( "slow" );
                e.focus();
            } else {
                c.addClass("hide-section");
                d.removeClass("active");
            }    
        });
    }
});
/*
$(function() {
    if ($("#header").length) {
        var a = $("#header");
        var b = $("#logo", a);
        b.wrap('<div id="logo-container" class="end"></div>');
        var c = $("#logo-container", a);
        b.before('<div id="menu-toggle"><a href="#navigation"><img src="/images/site/menu.png" alt="Go to menu" /></a></div>');
    }
});
*/
$(function() {
    if ($("#q").length) {
        $("#q").focus(function() {
            if ($("#q").val() == "Search") {
                $("#q").val("")
            }
        });
        $("#q").blur(function() {
            if ($("#q").val() == "") {
                $("#q").val("Search")
            }
        })
    }
});

/*
$(function() {
    if ($("#main").length) {
        $("#main").attr("tabindex", -1);
        $("#search").attr("tabindex", -1);
        $("a[href^='#']").not("a[href='#']").click(function() {
            $("#" + $(this).attr("href").slice(1) + "").focus()
        })
    }
});

$(function() {
    if ($("#search-form").length) {
        $("#search-form").addClass("hide-search");
    }
});
*/

$(function() {
// If there is a '#' in the URL (someone linking directly to a page with an anchor), highlight that section and set focus to it.
    // The tabindex attribute is removed AFTER the user navigates away from the element to help address a nasty VoiceOver bug.
    
    if (document.location.hash) {
        var myAnchor = document.location.hash;
        $(myAnchor).attr('tabindex', -1).on('blur focusout', function () {
            $(this).removeAttr('tabindex');
        }).focus().yellowFade();
    }
    
    /* This function looks for a change in the hash (activation of an in-page link) and sets focus to and 
    highlights the target element. This is necessary because webkit does not set focus as it should. If 
    the hash is empty (the user hit the back button after activating an in-page link) focus is set to body.
    */
    $(window).bind('hashchange', function() {
        var hash = "#"+window.location.hash.replace(/^#/,'');
        if (hash!="#") {
            $(hash).attr('tabindex', -1).on('blur focusout', function () {
                $(this).removeAttr('tabindex');
            }).focus().yellowFade();
        }
        else {
            $("#header-container").attr('tabindex', -1).on('blur focusout', function () {
                $(this).removeAttr('tabindex');
            }).focus();
        }
    });


});   
/*
$.fn.yellowFade = function() {
        return (this.css({backgroundColor: "#ffff66"}).animate(
        {backgroundColor: "#ffffff"}, 1000));
    } 

    */