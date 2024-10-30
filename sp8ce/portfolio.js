(function($) {
	$(document).ready(function() {
		$(document).on('click', '.sp8ce-portfolio .pagination-button', function() {
			var page = $(this).attr('data-page');
			Sp8ceGallery.pageNumber = page;
			Sp8ceGallery.loadPage();
		});
		
		$(document).on('click', '.sp8ce-portfolio div.filter-category', function() {
			var category = $(this).attr('data-category');
			Sp8ceGallery.pageNumber = 1;
			Sp8ceGallery.category = category;
			Sp8ceGallery.loadPage();
		});
		
		var Sp8ceGallery = {
		
			username: '',
			
			pageNumber: 1,
			
			category: '',
			
			displayCategories: false,
			
			elem: null,
			
			init: function(elem) {
				this.elem = elem;
				
				$(this.elem).html('');
				
				// Add category button, default to "Filter Categories"
				if (this.displayCategories == 'true') {
					var markup = [
						'<div class="filter-container">',
						'<div class="category-filter"><span class="category-filter-button-text">Filter Categories</span> <i class="fa fa-chevron-down" aria-hidden="true"></i>',
						'<div class="category-filter-dropdown"></div></div></div>'
					];
					$(this.elem).append(markup.join("\n"));
				}
				
				$(this.elem).append('<div class="loading"><div class="loading-inner"></div></div>');
				
				$(this.elem).append('<div class="gallery"></div>');
				
				$(this.elem).append('<div class="sp8ce-pagination"></div>');
			},

			loadPage: function() {
				
				var that = this;
				var url = 'https://sp8ce.design/wp-json/datafeed/get_list?username='+this.username+'&page='+this.pageNumber;
				
				if (this.category != '') {
					url = url + '&category=' + this.category;
				}
				
				$(this.elem).find('.gallery, .pagination').slideUp();
				$(this.elem).find('.gallery, .pagination').html('');
				$(this.elem).find('.loading').fadeIn();
				$.get(url, '', function(response) {
					$(that.elem).find('.loading').hide();
					
					if (response.success == false || response.data == 'undefined') {
						$(that.elem).html('<p>Failed to retrieve portfolio from Sp8ce.Design</p>');
						return;
					}

					if (that.displayCategories == 'true' && 
						typeof response.categories != 'undefined' && 
						response.categories.length > 0
					) {
						var buttonText = 'Filter Categories';
						if (that.category != '' && response.categories.indexOf(that.category) != -1) {
							buttonText = that.prettifyCategorySlug(that.category);
						}
						$(that.elem)
							.find('.filter-container .category-filter .category-filter-button-text')
							.html(buttonText);
									
						var markup = [];
						var selected = '';
						if (that.category == '') {
							selected = 'selected';
						}
						markup.push('<div data-category=""class="filter-category ' + selected + '">All</div>');
						
						$.each(response.categories, function(idx, category) {
							var selected = '';
							if (that.category == category) {
								selected = 'selected';
							}
							markup.push('<div data-category="' + category + '" class="filter-category ' + selected + '">' + that.prettifyCategorySlug(category) + '</div>');
						});
						
						$(that.elem).find('.filter-container .category-filter-dropdown').html(markup.join('\n'));
					}
					
					$.each(response.data, function(index, item) {
						
						var firstImage = item.images.shift();
						
						var imageMarkup = [];
						$.each(item.images, function(index, image) {
							imageMarkup.push('<a rel="prettyPhoto[item-'+item.id+']" style="display: none" href="'+image+'"></a>');
						});
					
						var markup = [
							'<div class="item" id="item-'+item.id+'">',
								'<div class="item-media-wrapper">',
									'<div class="item-media">',
										'<div class="background-image" style="background-image: url(\''+firstImage+'\')" />',
									'</div>',
								'</div>',
								'<div class="item-cover-background"></div>',
								'<div class="item-cover-wrapper">',
									'<div class="item-cover">',
										'<div class="sp8ce-row item-title-row">',
										'<p class="item-title">'+item.title+'</p>',
										'</div>',
										'<div class="sp8ce-row item-date-row">',
										'<p class="item-date">'+item.formatted_date+'</p>',
										'</div>',
										'<div class="item-images sp8ce-row">',
											'<a rel="prettyPhoto[item-'+item.id+']" href="'+firstImage+'" class="images-button"><i class="fa fa-camera camera-icon" aria-hidden="true"></i></a>',
											imageMarkup.join('\n'),
										'</div>',
									'</div>',
								'</div>',
							'</div>'
						];
						
						$(that.elem).find('.gallery').append(markup.join('\n'));	
					});
					
					if (response.total != 'undefined' && response.total > 9) {
						var pages = Math.ceil(response.total / 9);
						
						var paginationMarkup = [];
						
						for (var i = 1; i <= pages; i++) {
							var cls = 'pagination-button';
							if (that.pageNumber == i) {
								cls = 'pagination-button selected';
							}
							paginationMarkup.push('<button class="'+cls+'" data-page="'+i+'">'+i+'</button>');
						}
						
						$(that.elem).find('.sp8ce-pagination').html(paginationMarkup.join('\n'));
					
					}
					
					$(that.elem).find("a[rel^='prettyPhoto']").prettyPhoto({
						social_tools: false,
						horizontal_padding: 20,
						opacity: .8,
						deeplinking: false,
						theme: 'pp_woocommerce',
						overlay_gallery: false,
						allow_expand: false
					});
					
					$(that.elem).find('.gallery, .sp8ce-pagination').slideDown();
				});	
			},
			
			prettifyCategorySlug: function(slug) {
				var ret = '';
				
				ret = (slug + '').replace(/[_-]/g, ' ');
				
				ret = (ret + '').replace(/^([a-z])|\s+([a-z])/g, function ($1) {
					return $1.toUpperCase();
				});
				
				return ret;
			}
			
		};
		
		$('.sp8ce-portfolio').each(function() {
			var username = $(this).attr('data-username');
			var showCategories = $(this).attr('data-show-categories');

			Sp8ceGallery.username = username;
			
			Sp8ceGallery.displayCategories = showCategories;
			
			Sp8ceGallery.init($(this).find('.content'));
			
			Sp8ceGallery.loadPage(1);
		
		});

	});
})(jQuery);