(function() {

    // the root url for this project
    var URLDirectory = ""; 

    // the services in the header bar
    var services = [
        {
            name: "Student email",
            url: "https://live.kent.ac.uk",
            icon: "ico-email"
        },
        {
            name: "Timetables",
            url: "https://www.kent.ac.uk/student/my-study/",
            icon: "ico-timetable"
        },
        {
            name: "Moodle",
            url: "https://moodle.kent.ac.uk",
            icon: "ico-moodle"
        },
        {
            name: "SDS",
            url: "https://sds.kent.ac.uk",
            icon: "ico-sds"
        },
        {
            name: "LibrarySearch",
            url: "http://librarysearch.kent.ac.uk",
            icon: "ico-book"
        },
        {
            name: "Connect mail",
            url: "https://owa.connect.kent.ac.uk",
            icon: "ico-email"
        }
    ];

    var init = function() {
        document.body.insertBefore(createFragment(buildHeader()), document.body.childNodes[0]);

        addEvent(document.getElementsByClassName("menu-link")[0], "click", function(e) {
            e.preventDefault();
            showHideMenu();
        });

        window.onclick = function(e) {
            var list = document.getElementsByClassName("service-list")[0];
            if (e.toElement.className !== "menu-link") {
                if (list.style.display !== "none") {
                    list.style.display = "none";
                }
            }
        };
    };

    var addEvent = function(elem, evnt, func) {
        if (elem.addEventListener) { // W3C DOM
            elem.addEventListener(evnt,func,false);
        } else if (elem.attachEvent) { // IE DOM
            elem.attachEvent("on" + evnt, func);
        } else {
            elem[evnt] = func;
        }
    };

    var createFragment = function(htmlStr) {
        var frag = document.createDocumentFragment(),
            temp = document.createElement('div');
        temp.innerHTML = htmlStr;
        while (temp.firstChild) {
            frag.appendChild(temp.firstChild);
        }
        return frag;
    };


    var addEventListenerList = function(list, event, fn) {
        for (var i = 0, len = list.length; i < len; i++) {
            list[i].addEventListener(event, fn, false);
        }
    };

    var isBreakPoint = function (bp) {
        var bps = [300, 500, 768, 1024],
            w = window.innerWidth,
            min, max;

        for (var i = 0, l = bps.length; i < l; i++) {
            if (bps[i] === bp) {
                min = bps[i-1] || 0;
                max = bps[i];
                break;
            }
        }

        return w > min && w <= max;
    };


    var buildHeader = function() {
        var kentHeaderHorizontal = "";

        var kentHeaderServices  = '<div id="khl-service-list" class="service-list">';
        kentHeaderServices += '<span class="menu-arrow"></span>';
        kentHeaderServices += '<ul class="link-list key-links">';

        for (var i = 0; i < services.length; i++) {
            kentHeaderServices += '<li><a target="_blank" href="' + services[i].url + 
                                '" class="' + services[i].icon + '">' + 
                                services[i].name + 
                                (services[i].info ? ' <span class="system-info">(' + services[i].info + ')</span>' : '') + 
                                '</a></li>';
        }
            
        kentHeaderServices += '</ul>';
        kentHeaderServices += '</div>';

        if (isBreakPoint(500)) {
            kentHeaderHorizontal = kentHeaderServices.replace("khl-service-list", "khl-service-list-horizontal");
            kentHeaderServices = "";
        } else {
            kentHeaderHorizontal="";
        }

        var kentHeader = '<div id="kent-header-light">';
            kentHeader += '<div id="khl-header-strip">';
            kentHeader += '<a href="http://www.kent.ac.uk" id="khl-logo" title="University of Kent website">University of Kent</a>';
            kentHeader += '<ul id="khl-nav">';
            kentHeader += '<li><a href="http://www.kent.ac.uk/student/">Student Guide</a></li>';
            kentHeader += '<li class="systems-services"><a href="#" class="menu-link">Systems and services</a>';
            kentHeader += kentHeaderServices;
            kentHeader += '</li>';
            kentHeader += '</ul>';
            kentHeader += '</div>';
            kentHeader += kentHeaderHorizontal;
            kentHeader += '</div>';

        return kentHeader;
    };


    var showHideMenu = function() {
        var list = document.getElementsByClassName("service-list")[0];
        if (list.style.display !== "block") {
            list.style.display = "block";
        } else {
            list.style.display = "none";
        }
    };


    /*
     * Call init() on doc.ready() equivalent...
     */

    var span = document.createElement('span'),
        backupLoader,
        ms = 1,
        loader = window.setTimeout(function() {
            try {
                document.body.appendChild(span);

                document.body.removeChild(span);

                // Still here? Then document is ready
                window.clearTimeout(loader);
                window.clearTimeout(backupLoader);
                init();
            } catch(e) {
                // Whoops, document is not ready yet, try again...

                backupLoader = window.setTimeout(arguments.callee, ms);
            }
        }, ms);

})();
