$.extend({
autocompleter : function(callback) {
		var id = "form-customername";
		var defaultText = "Search Customer...";
		var suggestion = true;

		//var suggestionText = "";//"above the fold, absolute link, accessibility, address bar, affordance, alt text, alt tag, anchor, animated GIF, anti-alias, applet, assumed knowledge, authoring, automagically, autoresponder, back end/front end, backup, bandwidth, banner ad, banner blindness, belt-and-suspenders, bitmap, blog, blogger, blogging, bookmark, breadcrumb, broadband, browser, cache, cached files, call to action, Cascading Style Sheets , chatroom, chrome, click-through rate, client-side/server-side, closure, compatibility mode, data compression, content management system , contextual menu, convergence, cookie, cost-per-clickthrough, cost-per-thousand, crawler, cross-browser compatibility, cybersquatter, deep-linking, default, degrade gracefully, deprecated, design pattern, directory, disjointed rollover, dither, div, div-i-tis, divitis, document type declaration, doctype, document type definition, Domain Name System, DNS server, domain name, DomaiNZ, doorway/gateway page, dots-per-inch, download, Dublin Core metadata, dynamic HTML, e-commerce, email, element, encryption, favicon.ico, File Transfer Protocol, FTP client, firewall, Fireworks, Flash, Flash Generator, flow chart, fold, above-the-fold, footer navigation, form, folksonomy, frame, frameset, front end/back end, gateway page, global navigation, granularity, Graphic Interchange Format, Graphical User Interface, hack, handle, haptics, hexadecimal colours, hits, host, hosting, hotspot, HyperText Markup Language, HyperText Transfer Protocol, HTML markup, HTML-text, hyperlink, iframes, i-mode, image map, impression, include, information architecture, information foraging, initialism, integration, interactive television, interface, internet, interstitial, intranet, Initial Public Offering, Internet Protocol, IP address, IP number, Internet Service Provider, JavaScript, Joint Photographers Expert Group, label, landing page, legacy content, link: absolute, relative, root, link farm, link rot, definition, ordered, unordered, listserv, logfiles, logfile analysis, look-and-feel, lossless compression, lossy compression, macron, mailing lists, markup, meta element, metadata, meta tag, mine-sweeping, MP3, MySQL, natural language, navigation, open source, optimise, optimisation, opt-in/opt-out, PageRank (PR), parasite economy, design pattern, perceived affordance, permission-based marketing, phishing, PHP: Hypertext Preprocessor, Portable Document Format, web portal, Pretty Good Privacy, pixel, plug-in, pop-up window, pop-under, Portable Network Graphic, prosumer, QuickTime, quirks mode, reciprocal links, referrer, referrer log, Really Simple Syndication, relative link, Realtime Transport Protocol, robot, robots file, robots.txt, rollover, disjointed rollover, root, root directory, root link, scan, scanning, schematic, SCM, SCP, search engine, search engine marketing, search engine optimisation, Section 508, Secure Sockets Certificate, semantic markup, server, sever-side/client-side, server-side include, session, session tracking, Shockwave, shopping-cart, shortcut icon, Simple Object Access Protocol, site feed, sitemap, smart tags, Synchronised Multimedia Integration Language, sniffer, spam, spim, spider, splash page, splash screen, spyware, standardista, standards-compliant/strict mode, status bar, sticky, streaming, streaming media, structured query language, stylesheet, system font, tags, tags/tagging, target, template, top-level navigation, topic path, traffic, transform gracefully, transparent GIF, trackback, typosquatter, Unicode, Unicode Transformation Format, Unified Modeling Language, Uniform Resource Identifier, Uniform Resource Locator, uploading, usability, user session, code standards, form input, vector, vector-based file, version control, viral marketing, virus, visual editor, web, Web 2.0, web accessibility, web-authoring, web browser, web font, typeface, web-log, web server logs, websafe colours, palette, web standards, WebTV, what-you-see-is-what-you-get, wireframe, Wireless Application Protocol, Wireless Markup Language, Worldwide Web, eXtensible Markup Language, XML schema";

		var field = document.getElementById(id);
		var classInactive = "sf_inactive";
		var classActive = "sf_active";
		var classText = "sf_text";
		var classSuggestion = "sf_suggestion";
		//this.safari = ((parseInt(navigator.productSub)>=20020000)&&(navigator.vendor.indexOf("Apple Computer")!=-1));

		if(field){
			field.value = defaultText;
			field.c = field.className;
			field.className = field.c + " " + classInactive;
			field.onfocus = function(){
				this.className = this.c + " "  + classActive;
				this.value = (this.value == "" || this.value == defaultText) ?  "" : this.value;
			};
			field.onblur = function(){
				this.className = (this.value != "" && this.value != defaultText) ? this.c + " " +  classText : this.c + " " +  classInactive;
				this.value = (this.value != "" && this.value != defaultText) ?  this.value : defaultText;
				clearList();
			};

			if (suggestion){

				var selectedIndex = 0;

				field.setAttribute("autocomplete", "off");
				var div = document.createElement("div");
				var list = document.createElement("ul");
				list.style.display = "none";
				div.className = classSuggestion;
				list.style.width = field.offsetWidth + "px";
				div.appendChild(list);
				field.parentNode.appendChild(div);

				field.onkeypress = function(e){

					var key = getKeyCode(e);

					if(key == 13){ // enter
						selectList();
						selectedIndex = 0;
						return false;
					};
				};

				field.onkeyup = function(e){

					var key = getKeyCode(e);

					switch(key){
					case 13:
						searchsubcampaignbyagent();
						clearList();
						return false;
						break;
					case 27:  // esc
						field.value = "";
						selectedIndex = 0;
						clearList();
						break;
					case 38: // up
						navList("up");
						break;
					case 40: // down
						navList("down");
						break;
					default:
						startList();
						break;
					};
				};

				function startList(){
					var fieldvalue = field.value;
					if(fieldvalue.length > 2){
						$.post('./functions/orders/search_customer.php', { keyword : field.value }, function(data){

							var suggestionText = "";
							if(data.status == true){
								$.each(data.data, function(i){
									suggestionText = this.customername;
								});
							}
							else{
								suggestionText = data.error;
							}
							
							var arr = getListItems(field.value, suggestionText);
							if(field.value.length > 0){
								createList(arr);
							}
							else {
								clearList();
							};
						},'json');
					}
					else{
						clearList();
					}
				};

				function getListItems(value, text){
					var arr = new Array();
					arr.push(text);
					//var src = text;

					//src = src.replace(/, /g, ",");
                    //arr = src.split("|");
                    //arr = src;

					//for(i=0;i<arrSrc.length;i++){
						//if(arrSrc[i].substring(0,value.length).toLowerCase() == value.toLowerCase()){
							//alert();
							//arr.push(arrSrc[i]);
						//};
					//};
					return arr;
				};

				function createList(arr){
					resetList();
					if(arr.length > 0) {
						for(i=0;i<arr.length;i++){
							li = document.createElement("li");
							a = document.createElement("a");
							a.href = "javascript:void(0);";
							a.i = i+1;
							a.innerHTML = arr[i];
							li.i = i+1;
							li.onmouseover = function(){
								navListItem(this.i);
							};
							a.onmousedown = function(){
								selectedIndex = this.i;
								selectList(this.i);
								return false;
							};
							li.appendChild(a);
							list.setAttribute("tabindex", "-1");
							list.appendChild(li);
						};
						list.style.display = "block";
					} else {
						clearList();
					};
				};

				function resetList(){
					var li = list.getElementsByTagName("li");
					var len = li.length;
					for(var i=0;i<len;i++){
						list.removeChild(li[0]);
					};
				};

				function navList(dir){
					selectedIndex += (dir == "down") ? 1 : -1;
					li = list.getElementsByTagName("li");
					if (selectedIndex < 1) selectedIndex =  li.length;
					if (selectedIndex > li.length) selectedIndex =  1;
					navListItem(selectedIndex);
				};

				function navListItem(index){
					selectedIndex = index;
					li = list.getElementsByTagName("li");
					for(var i=0;i<li.length;i++){
						li[i].className = (i==(selectedIndex-1)) ? "selected" : "";
					};
				};

				function selectList(){
					li = list.getElementsByTagName("li");
					if(li[selectedIndex-1] != undefined){
						a = li[selectedIndex-1].getElementsByTagName("a")[0];

						i = a.innerHTML;
						if(i != "Not Found"){
							//var value = i.split(" - ");
                            //field.value = value[1];
                            field.value = i;
                            //searchsubcampaignbyagent();
						}
					}
					clearList();
				};

			};
		};

		function clearList(){
			if(list){
				list.style.display = "none";
				selectedIndex = 0;
			};
		};

		function getKeyCode(e){
			var code;
			if (!e) var e = window.event;
			if (e.keyCode) code = e.keyCode;
			return code;
		};

		if(typeof callback == "function"){
			callback.call(this, { data : Date() });
		}
	}
});
