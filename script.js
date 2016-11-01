/**
 * Javascript functionality for the filter by date plugin
 */

function plugin_filterByDate() {
	jQuery('.filterbydate_start').each(function() {
	    var fs = jQuery(this);
	    var gr = fs.nextUntil('.filterbydate_end');
	    if (gr.length == 0) { // Support for include plugin
			gr = fs.parent().nextUntil(':has(.filterbydate_end)');
		}
		var d = new Date();
		var base =  fs.attr('data-base');
		if (base == 'week') {
			d = d.getDay();
		} else if (base == 'year') {
			var y = new Date(d.getFullYear(), 0, 0);
			d = Math.ceil((d-y)/(1000*60*60*24)); 
		} else {
			d = d.getDate();
		}
		var li = gr.find("li");
		if (li.length != 0) {
			var o = parseInt(fs.attr('data-offset'));
			if (!isNaN(o)) {
				d += o;
			}
			if (fs.attr('data-repeat') != 'false') {
				d = (d-1) % li.length;
			}
			gr.find("li").each(function (k,v) {
				if (d==k) {
					if (jQuery(v).parent().prop('tagName') == 'OL') {
						jQuery(v).parent().attr('start', (d+1).toString());
					}
				} else {
					jQuery(v).hide();
				}
			});
		}
	});
};

jQuery(plugin_filterByDate);
