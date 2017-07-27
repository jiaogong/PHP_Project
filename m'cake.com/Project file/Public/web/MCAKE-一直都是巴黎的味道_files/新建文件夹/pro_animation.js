(function($) {
	$.fn.sorted = function(customOptions) {
		var options = {
			reversed: false,
			by: function(a) {
				return a.text();
			}
		};
		$.extend(options, customOptions);
	
		$data = $(this);
		arr = $data.get();
		arr.sort(function(a, b) {
			
		   	var valA = options.by($(a));
		   	var valB = options.by($(b));
			if (options.reversed) {
				return (valA < valB) ? 1 : (valA > valB) ? -1 : 0;				
			} else {		
				return (valA < valB) ? -1 : (valA > valB) ? 1 : 0;	
			}
		});
		return $(arr);
	};

})(jQuery);


$(function() {
	
	 
  
  var read_button = function(class_names) {
    var r = {
      selected: false,
      type: 0
    };
    for (var i=0; i < class_names.length; i++) {
      if (class_names[i].indexOf('selected-') == 0) {
        r.selected = true;
      }
      if (class_names[i].indexOf('segment-') == 0) {
        r.segment = class_names[i].split('-')[1];
      }
    };
    return r;
  };
  
  var determine_sort = function($buttons) {
    var $selected = $buttons.parent().filter('[class*="selected-"]');
    return $selected.find('a').attr('data-value');
  };
  
  var determine_kind = function($buttons) {
    var $selected = $buttons.parent().filter('[class*="selected-"]');
    return $selected.find('a').attr('data-value');
  };
  
  var $preferences = {
    duration: 800,
    easing: 'easeInOutQuad'
  };
  
  var $list = $('#list');
  var $data = $list.clone();
  var $list_o = $('#list_other');
  $list_o.html($list.html());
  var $data_o = $list_o.clone();
  
  var $controls = $('ul.splitter ul');
  
  $controls.each(function(i) {
    
    var $control = $(this);
    var $buttons = $control.find('a');
    
    $buttons.bind('click', function(e) {
      
      var $button = $(this);
      var $button_container = $button.parent();
	  var b_class=$button_container.attr('class')+"";
      var button_properties = read_button(b_class.split(' '));      
      var selected = button_properties.selected;
      var button_segment = button_properties.segment;

      if (!selected) {

        $buttons.parent().removeClass('selected-0').removeClass('selected-1').removeClass('selected-2');
        $button_container.addClass('selected-' + button_segment);
        
        var sorting_type = determine_sort($controls.eq(1).find('a'));
        var sorting_kind = determine_kind($controls.eq(0).find('a'));
        



		 
		  if (sorting_kind == 'all') {
			  $(".other_box").hide();
			  var $filtered_data = $data.children('li');
			  var $sorted_data = $filtered_data.sorted({
				by: function(v) {
				  return $(v).attr("data-id").replace(/[^-^0-9]/ig, "").toLowerCase();
				  
				}
			  });
			} else {
				
			  $(".other_box").show();
			  var $filtered_data = $data.find('li.' + sorting_kind);
              var $filtered_data_o = $data_o.children('li').not('li.' + sorting_kind);
			  var $sorted_data = $filtered_data.sorted({
				by: function(v) {
				  return $(v).find('strong').text().toLowerCase();
				}
			  });
			  
		      var $sorted_data_o = $filtered_data_o.sorted({
				by: function(v) {
				  return $(v).find('strong').text().toLowerCase();
				}
			  });
			}


        
        $list.quicksand($sorted_data, $preferences);
		$list_o.quicksand($sorted_data_o, $preferences);
        
      }
      
      e.preventDefault();
    });
    
  }); 

  var high_performance = true;  
  var $performance_container = $('#performance-toggle');
  var $original_html = $performance_container.html();
  
  $performance_container.find('a').bind('click', function(e) {
    if (high_performance) {
      $preferences.useScaling = false;
      $performance_container.html('CSS3 scaling turned off. Try the demo again. <a href="#toggle">Reverse</a>.');
      high_performance = false;
    } else {
      $preferences.useScaling = true;
      $performance_container.html($original_html);
      high_performance = true;
    }
    e.preventDefault();
  });
});


