var scrollpos = window.scrollY;
var header = document.getElementById("header");
var navcontent = document.getElementById("nav-content");
var navaction = document.getElementById("navAction");
var brandname = document.getElementById("brandname");
var toToggle = document.querySelectorAll(".toggleColour");

document.addEventListener("scroll", function () {
    /*Apply classes for slide in bar*/
    scrollpos = window.scrollY;

    if (scrollpos > 10 || !navMenuDiv.classList.contains("hidden")) {
        header.classList.add("bg-white");
        navaction.classList.remove("bg-white");
        navaction.classList.add("gradient");
        navaction.classList.remove("text-black");
        navaction.classList.add("text-black");
        // Use to switch toggleColour colours
        for (var i = 0; i < toToggle.length; i++) {
            toToggle[i].classList.add("text-black");
            toToggle[i].classList.remove("text-white");
        }
        header.classList.add("shadow");
        navcontent.classList.remove("bg-gray-100");
        navcontent.classList.add("bg-white");
    } else {
        header.classList.remove("bg-white");
        navaction.classList.remove("gradient");
        navaction.classList.add("bg-white");
        navaction.classList.remove("text-white");
        navaction.classList.add("text-gray-800");
        // Use to switch toggleColour colours
        for (var i = 0; i < toToggle.length; i++) {
            toToggle[i].classList.add("text-white");
            toToggle[i].classList.remove("text-gray-800");
        }

        header.classList.remove("shadow");
        navcontent.classList.remove("bg-white");
        navcontent.classList.add("bg-white");
    }
});

var navMenuDiv = document.getElementById("nav-content");
var navMenu = document.getElementById("nav-toggle");

document.onclick = check;
function check(e) {
    var target = (e && e.target) || (event && event.srcElement);

    // Nav Menu
    if (!checkParent(target, navMenuDiv)) {
        // Click NOT on the menu
        if (checkParent(target, navMenu)) {
            // Click on the link
            if (navMenuDiv.classList.contains("hidden")) {
                navMenuDiv.classList.remove("hidden");
                // Change text color to black and background to white when menu is open
                header.classList.add("bg-white");
                for (var i = 0; i < toToggle.length; i++) {
                    toToggle[i].classList.add("text-black");
                    toToggle[i].classList.remove("text-white");
                }
            } else {
                navMenuDiv.classList.add("hidden");
                // Revert text color and background when menu is closed
                if (scrollpos < 10) {
                    header.classList.remove("bg-white");
                }
                for (var i = 0; i < toToggle.length; i++) {
                    toToggle[i].classList.add("text-white");
                    toToggle[i].classList.remove("text-black");
                }
            }
        } else {
            // Click both outside link and outside menu, hide menu
            navMenuDiv.classList.add("hidden");
            // Revert text color and background when menu is closed
            if (scrollpos < 10) {
                header.classList.remove("bg-white");
            }
            for (var i = 0; i < toToggle.length; i++) {
                toToggle[i].classList.add("text-white");
                toToggle[i].classList.remove("text-black");
            }
        }
    }
}
function checkParent(t, elm) {
    while (t.parentNode) {
        if (t == elm) {
            return true;
        }
        t = t.parentNode;
    }
    return false;
}
