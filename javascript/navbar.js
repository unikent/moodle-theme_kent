(function() {

   var kentbar = new function(){

        // Container for node
        this.dom = '';

        // the services in the header bar
        this.services = [
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
                icon: "ico-library"
            },
            {
                name: "Staff/PGR mail",
                url: "https://owa.connect.kent.ac.uk",
                icon: "ico-email"
            }
        ];

        // Init object
        this.init = function() {
            // Check for "window._kentbar" config (can override base dir to set alternative css)
            if(typeof window._kentbar !== 'undefined'){
                var conf =  window._kentbar;
            }

            this.createKentBar();
        };

        // Create kent Bar
        this.createKentBar = function(){
            // Create bar
            this.dom = this.buildHeaderBar();

            // Get bar
            var bar = this.dom.firstChild;
            // Add services menu to bar
            bar.appendChild(this.createServicesDropdown());
            // Get menu
            var menu = bar.children[1];
            var button = bar.querySelector(".menu-link");
            // Show/hide menu
            this.addEvent(button, "click", function(event){

                if(event.preventDefault){ event.preventDefault(); } else { event.returnValue = false; }

                if(menu.style.display == "block"){
                    menu.style.display = 'none';
                    button.parentNode.className = "systems-services";
                }else{
                    menu.style.display = 'block';
                    button.parentNode.className = "systems-services open";
                }
            });

            // Hide menu when user clicks off of it
            this.addEvent(document, "click", function(event){
                var target = (typeof event.target !== 'undefined') ? event.target : event.srcElement;
                if(target.className != "menu-link" && menu.style.display == "block"){
                    menu.style.display =  'none';
                    button.parentNode.className = "systems-services";
                }
            });

            // Add to real world
           document.body.insertBefore(this.dom, document.body.childNodes[0]);
        }

        // Create services drop down menu
        this.createServicesDropdown = function(){
            var kentHeaderServices  = '<div id="khl-service-list" class="service-list" style="display:none;">';
                kentHeaderServices += '<span class="menu-arrow"></span>';

                kentHeaderServices += '<ul class="top-links">';
                kentHeaderServices += '<li><a href="http://www.kent.ac.uk/student/" aria-label="Go to Student guide">Student guide</a></li>';
                kentHeaderServices += '<li><a href="http://www.kent.ac.uk/campusonline/" aria-label="Go to Campus online">Campus online</a></li>';
                kentHeaderServices += '</ul>';

                kentHeaderServices += '<ul class="link-list key-links">';

                for (var i = 0; i < this.services.length; i++) {
                    kentHeaderServices += '<li><a target="_blank" href="' + this.services[i].url +
                                        '" aria-label="Go to ' + this.services[i].name +
                                        '">' +
                                        '<span class="'+this.services[i].icon+'"></span>'+
                                        this.services[i].name +
                                        (this.services[i].info ? ' <span class="system-info">(' + this.services[i].info + ')</span>' : '') +
                                        '</a></li>';
                }

                kentHeaderServices += '</ul>';

                kentHeaderServices += '<a class="more-link" aria-label="More systems and services are available on the Student Guide" target="_blank" href="http://www.kent.ac.uk/student#more-systems">More systems and services</a>';
                kentHeaderServices += '</div>';

            return this.createFragment(kentHeaderServices);
        }

        // Build primary header bar
        this.buildHeaderBar = function( services ){
             var kentHeader = '<div id="kent-bar">';
                kentHeader += '<div>';
                kentHeader += '<a href="http://www.kent.ac.uk" class="khl-logo" title="University of Kent website homepage">University of Kent</a>';
                kentHeader += '<ul class="khl-nav">';
                kentHeader += '<li class="systems-services"><a role="button" aria-label="View Systems and Services" aria-controls="khl-service-list" href="#" class="menu-link">Kent systems and services</a></li>';
                kentHeader += '</ul>';
                kentHeader += '</div>';
                kentHeader += '</div>';


            return this.createFragment(kentHeader);
        }

        // Convert markup to DOM elements
        this.createFragment = function(htmlStr) {
            var frag = document.createDocumentFragment(),
                temp = document.createElement('div');
            temp.innerHTML = htmlStr;
            while (temp.firstChild) {
                frag.appendChild(temp.firstChild);
            }
            return frag;
        };

        // Add event (ie compatible)
        this.addEvent = function(elem, evnt, func) {
            if (elem.addEventListener) { // W3C DOM
                elem.addEventListener(evnt,func,false);
            } else if (elem.attachEvent) { // IE DOM
                elem.attachEvent("on" + evnt, func);
            } else {
                elem[evnt] = func;
            }
        };

    }

    // Init bar
    kentbar.init();
})();
