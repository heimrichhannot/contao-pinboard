(function ($) {
	var PINBOARD = {
		init: function ()
		{
			this.initPagination();
			this.initAlerts();
		},
		initAlerts: function () {
			$('.pinboard .delete').on('click', function(event) {
				if (typeof Bootstrapper !== 'undefined')
				{
					var $this = $(this);

					event.preventDefault();

					Bootstrapper.confirm($this.data('message'), function() {
						window.location.href = $this.attr('href');
					});
				}
			});
		},
		initPagination: function()
		{
			$('.pinboard .ajax-pagination').each(function() {
				var $list = $(this).closest('.pinboard'),
					$items = $list.find('.items'),
					id = '#' + $list.attr('id');

				$list.jscroll({
					loadingHtml: '<div class="loading"></div>',
					nextSelector: '.ajax-pagination a.next',
					autoTrigger: $list.data('infinitescroll') == 1,
					contentSelector: id,
					callback: function()
					{
						var $jscrollAdded = $(this),
							$newItems = $jscrollAdded.find('.item');

						$newItems.hide();

						$jscrollAdded.imagesLoaded( function() {
							$items.append($newItems.fadeIn(300)).masonry('appended', $newItems);

							// remove item counters...
							$items.find('.item').removeClass(function(index, cssClass) {
								var matches = cssClass.match(/item_\d+/g);

								if (matches.length > 0)
									return matches[0];
							});

							//... and readd them again
							$items.find('.item').each(function(index) {
								var $item = $(this);

								$(this).addClass('item_' + index).removeClass('odd even first last');

								// odd/even
								if (index % 2 == 0)
								{
									$item.addClass('even');
								}
								else
								{
									$item.addClass('odd');
								}

								// add first and last
								if (index == 0)
								{
									$item.addClass('first');
								}

								if (index == $items.find('.item').length - 1)
								{
									$item.addClass('last');
								}
							});

							$jscrollAdded.find('.ajax-pagination').appendTo($jscrollAdded.closest('.jscroll-inner'));
							$jscrollAdded.remove();
						});
					}
				});
			});
		}
	};

	$(document).ready(function () {
		PINBOARD.init();
	});
})(jQuery);