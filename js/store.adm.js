$(function() {
	var wHeight = $(window).height();
	$('.content').css({height:wHeight+'px'});	
	$('.close').click(function(e) {
		e.preventDefault();	
		e.stopPropagation();		
		$(this).parents('.confirm').fadeOut(400, function() {
			$('.cover').hide();
		});
	});
	$('table').each(function() {
		var confirmMessage = $(this).hasClass('users')
							? 'All related records (orders, etc) will also be deleted'
							: 'Please, confirm the operation';
		$(this).find('.del').click(function(e) {
			e.preventDefault();	
			e.stopPropagation();
			$('.confirm')
				.children('p')
				.first()
				.text(confirmMessage)
				.next()
				.children('a')
				.first()
				.attr({href:this.href});
			$('.cover').fadeIn(200, function() {
				$('.confirm').show().animate({top: (wHeight-$('.confirm').outerHeight())/2}, 200);
			});
		});
    });
});