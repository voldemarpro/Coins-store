$(function() {
	var wHeight = $(window).height();
	var autocomplete = {
		author_id: {source: '/data/books/authors/', error: 'Автор не найден'}
	};
	$('.content').css({height:wHeight+'px'});
	$('.autocomplete').each(function() {
		if (autocomplete.hasOwnProperty(this.id)) {
			var errBox = $(this).siblings().last().children();
			var errMessage = autocomplete[this.id]['error'];
			$(this).autocomplete({
				source: autocomplete[this.id]['source'],
				messages: {
					noResults: function(){errBox.text(errMessage).show()},
					results: function(){errBox.text('')}
				},
				change: function(e, ui) {
					$(this).siblings(':hidden').val(ui.item ? ui.item.id : '');
				}
			});
		}
	});	
	
	$('.close').click(function(e) {
		e.preventDefault();	
		e.stopPropagation();		
		$(this).parents('.confirm').fadeOut(400, function() {
			$('.cover').hide();
		});
	});
	
	$('table').each(function() {
		var confirmMessage = $(this).hasClass('authors')
							? 'Автор и все его книги будут удалены из каталога'
							: 'Пожалуйста, подтвердите удаление записи';
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
			$('.cover').fadeIn(400, function() {
				$('.confirm').show().animate({top: (wHeight-$('.confirm').outerHeight())/2});
			});
		});
    });
});