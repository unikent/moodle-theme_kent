window._kentbar = {basedir: false};

!function(){var a=function(){this.dom="",this.basedir="//static.kent.ac.uk/navbar/",this.services=[{name:"Student email",url:"https://live.kent.ac.uk",icon:"kf-email"},{name:"Timetables",url:"https://www.kent.ac.uk/student/my-study/",icon:"kf-timetables"},{name:"Moodle",url:"https://moodle.kent.ac.uk",icon:"kf-moodle"},{name:"Student SDS",url:"https://sds.kent.ac.uk",icon:"kf-sds"},{name:"Catalogue",url:"https://catalogue.kent.ac.uk/",icon:"kf-book"},{name:"Staff/PGR email",url:"https://owa.connect.kent.ac.uk",icon:"kf-email"}],this.init=function(){if("undefined"!=typeof window._kentbar){var a=window._kentbar;"undefined"!=typeof a.basedir&&(this.basedir=a.basedir)}this.basedir!==!1&&this.insertStylesheet(),this.createKentBar()},this.insertStylesheet=function(){var a=document.createElement("link");a.setAttribute("rel","stylesheet"),a.setAttribute("type","text/css"),a.href=this.basedir+"kent-header-light.css",document.getElementsByTagName("head")[0].appendChild(a)},this.createKentBar=function(){this.dom=this.buildHeaderBar();var a=this.dom.firstChild;a.appendChild(this.createServicesDropdown());var b=a.children[1],c=a.querySelector(".menu-link");this.addEvent(c,"click",function(a){a.preventDefault?a.preventDefault():a.returnValue=!1,"block"==b.style.display?(b.style.display="none",c.parentNode.className="systems-services"):(b.style.display="block",c.parentNode.className="systems-services open")}),this.addEvent(document,"click",function(a){var d="undefined"!=typeof a.target?a.target:a.srcElement;"menu-link"!=d.className&&"block"==b.style.display&&(b.style.display="none",c.parentNode.className="systems-services")}),document.body.insertBefore(this.dom,document.body.childNodes[0])},this.createServicesDropdown=function(){var a='<div id="khl-service-list" class="service-list" style="display:none;">';a+='<span class="menu-arrow"></span>',a+='<ul class="top-links">',a+='<li><a href="http://www.kent.ac.uk/student/" target="_blank" aria-label="Go to Student guide">Student Guide</a></li>',a+='<li><a href="http://www.kent.ac.uk/campusonline/" target="_blank" aria-label="Go to Campus online">Staff homepage</a></li>',a+="</ul>",a+='<ul class="key-links">';for(var b=0;b<this.services.length;b++)a+='<li><a target="_blank" href="'+this.services[b].url+'" aria-label="Go to '+this.services[b].name+'"><span class="'+this.services[b].icon+'"></span>'+this.services[b].name+(this.services[b].info?' <span class="system-info">('+this.services[b].info+")</span>":"")+"</a></li>";return a+="</ul>",a+='<a class="more-link" aria-label="More systems and services are available on the Student Guide" target="_blank" href="http://www.kent.ac.uk/student#more-systems">More systems and services</a>',a+="</div>",this.createFragment(a)},this.buildHeaderBar=function(){var a='<div id="kent-bar">';return a+="<div>",a+='<a href="http://www.kent.ac.uk" target="_blank" class="khl-logo" title="University of Kent website homepage"><span>University of Kent</span></a>',a+='<ul class="khl-nav">',a+='<li class="systems-services"><a role="button" aria-label="View Systems and Services" aria-controls="khl-service-list" href="#" class="menu-link">Kent systems and services <span></span></a></li>',a+="</ul>",a+="</div>",a+="</div>",this.createFragment(a)},this.createFragment=function(a){var b=document.createDocumentFragment(),c=document.createElement("div");for(c.innerHTML=a;c.firstChild;)b.appendChild(c.firstChild);return b},this.addEvent=function(a,b,c){a.addEventListener?a.addEventListener(b,c,!1):a.attachEvent?a.attachEvent("on"+b,c):a[b]=c},this.initAnalytics=function(){!function(a,b,c,d,e,f,g){a.GoogleAnalyticsObject=e,a[e]=a[e]||function(){(a[e].q=a[e].q||[]).push(arguments)},a[e].l=1*new Date,f=b.createElement(c),g=b.getElementsByTagName(c)[0],f.async=1,f.src=d,g.parentNode.insertBefore(f,g)}(window,document,"script","//www.google-analytics.com/analytics.js","kb_ga"),kb_ga("create","UA-54179016-2","auto"),kb_ga("require","displayfeatures"),kb_ga("send","pageview");for(var a=document.getElementById("kent-bar").getElementsByTagName("a"),b=0;b<a.length;b++)this.sendAnalyticsClickEvent(a[b])},this.sendAnalyticsClickEvent=function(a){this.addEvent(a,"click",function(){if(this.href)try{kb_ga("send","event","button","click",this.innerHTML+": "+this.href)}catch(a){}})}},b=new a;b.init()}();