jQuery(function($) {
    const relatedGrid = $('.related-posts-grid');
    if (!relatedGrid.length) return;

    let isLoading = false;
    const bottomOffset = 5; // 5px from bottom of the last item

    // Get parameters from PHP localized object
    const initialPosts = parseInt(related_load_params.initial_posts, 10);
    const postsPerPage = parseInt(related_load_params.posts_per_page, 10);
    const totalPosts = parseInt(related_load_params.total_posts, 10);
    const categorySlug = related_load_params.category_slug;
    const excludePostId = parseInt(related_load_params.exclude_post_id, 10);

    let currentPostCount = initialPosts;

    if (currentPostCount >= totalPosts) {
        return;
    }

    const checkAndLoad = function() {
        if (isLoading || currentPostCount >= totalPosts) {
            return;
        }

        const lastCard = relatedGrid.children('.related-post-card').last();
        if (!lastCard.length) return;

        const lastCardRect = lastCard[0].getBoundingClientRect();
        const windowHeight = $(window).height();

        // Check if conditions for loading are met (last card bottom is <= window height + 5px)
        if (lastCardRect.bottom <= windowHeight + bottomOffset) {
            isLoading = true;
            $('.related-loading-indicator').show();

            $.ajax({
                url: related_load_params.ajax_url,
                type: 'POST',
                data: {
                    action: 'load_more_related_posts',
                    offset: currentPostCount,
                    limit: postsPerPage,
                    category_slug: categorySlug,
                    exclude_post_id: excludePostId,
                    nonce: related_load_params.nonce
                },
                success: function(response) {
                    if (response.trim() !== '') {
                        setTimeout(function() {
                            const newItems = $(response);
                            relatedGrid.append(newItems);
                            
                            // Remove reveal class after animation ends to restore normal hover style
                            setTimeout(function() {
                                newItems.removeClass('reveal');
                            }, 800);
                            
                            currentPostCount += newItems.filter('.related-post-card').length;
                            
                            $('.related-loading-indicator').hide();
                            isLoading = false;

                            if (currentPostCount >= totalPosts) {
                                $(window).off('scroll.related', checkAndLoad);
                            } else {
                                setTimeout(checkAndLoad, 100);
                            }
                        }, 500);
                    } else {
                        $('.related-loading-indicator').hide();
                        isLoading = false;
                        currentPostCount = totalPosts;
                        $(window).off('scroll.related', checkAndLoad);
                    }
                },
                error: function() {
                    $('.related-loading-indicator').html('<p>An error occurred. Please try again.</p>').show();
                    isLoading = false;
                }
            });
        }
    };

    $(window).on('scroll.related', checkAndLoad);
    setTimeout(checkAndLoad, 500);
});
