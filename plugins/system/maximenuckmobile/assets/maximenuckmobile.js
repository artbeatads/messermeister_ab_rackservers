var MobileMaxiMenu = new Class({
        Implements: Options,
        options: { 	
            resolution : 640,
            useimages : false,
            usemodules : false //div.maximenuck_mod
        },
        initialize: function(element,options) {
            if (!element) return false;

			/*window.onresize = function() { 
                console.log(!$('mobilemaximenuck'));
                if (document.body.offsetWidth < 640) createMobileMenuck(); 
            }*/
            // if (document.body.offsetWidth < 640) this.createMobileMenuck(element); 
            // this.createMobileMenuck(element);
			//window.onresize = resize;

            this.setOptions(options); //enregistre les options utilisateur

            var resolution = this.options.resolution;
            var useimages = this.options.useimages;
            var usemodules = this.options.usemodules;

            var activeitem;
            if (document.getElement('#mobilemaximenuck')) return;
            var menuitems = element.getElements('ul.maximenuck li');
            var mobilemenu = new Element('div', {'id':'mobilemaximenuck'});
            mobilemenu.adopt(new Element('div',{
                'class' : 'topbar'
            }).set('html','<span id="mobilemaximenucktitle">'+Joomla.JText._('PLG_MAXIMENUCK_MENU', 'Menu')+'</span><span id="mobilemaximenuckclose"></span>'));
            menuitems.each(function(item) {
                if (item.getElement('a.maximenuck') && 
                (item.getElement('a.maximenuck').getElement('span.titreck') || useimages)
                || (item.getElement('div.maximenuck_mod') && usemodules)
                ) {
                    itemanchor = item.getElement('a.maximenuck');
                    if (useimages && item.getElement('a.maximenuck > img')) {
                        datatocopy = itemanchor.innerHTML;
                        mobilemenu.adopt(new Element('div',{
                            'class' : item.className
                        }).set('html','<a href="'+itemanchor.href+'">'+datatocopy+'</a>'));
                    } else if (usemodules && item.getElement('div.maximenuck_mod')) {
                        datatocopy = item.getElement('div.maximenuck_mod').innerHTML;
                        mobilemenu.adopt(new Element('div',{
                            'class' : item.className
                        }).set('html',datatocopy));
                    } else {
                        datatocopy = itemanchor.getElement('span.titreck').innerHTML;
                        mobilemenu.adopt(new Element('div',{
                            'class' : item.className
                        }).set('html','<a href="'+itemanchor.href+'">'+datatocopy+'</a>'));
                    }
                    

                    if (item.hasClass('current')) activeitem = item;
                }
            });
            mobilemenu.setStyles({
                'position': 'absolute',
                'z-index': '100000',
                'top': '0',
                'left': '0',
            });
            if (activeitem) {
                if (useimages) {
                    activeitemtext = activeitem.getElement('a.maximenuck').get('html');
                } else {
                    activeitemtext = activeitem.getElement('span.titreck').get('html');
                }
                
            } else {
                activeitemtext = Joomla.JText._('PLG_MAXIMENUCK_MENU', 'Menu');
            }
            document.body.adopt(mobilemenu);
            mobilemenu.setStyles({'opacity': '0', 'display': 'none'});
            var mobilebutton = new Element('div', {
                    'id': 'mobilebarmenuck'
                }).set('html','<span class="mobilebarmenutitleck">'+activeitemtext+'</span>')
                .adopt(new Element('div', {
                    'id': 'mobilebuttonmenuck'
                }).addEvent('click', function() {
                    mobilemenu.setStyle('display', 'block').fade('in');
                }));

            document.id('mobilemaximenuckclose').addEvent('click', function() {
                mobilemenu.fade('out').setStyle('display', 'block');
            });;
            document.body.adopt(mobilebutton);
    }
});
MobileMaxiMenu.implement(new Options); //ajoute les options utilisateur