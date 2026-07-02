jQuery(function($) {
    const articleList = $('.article-list');
    if (!articleList.length) return;

    let isLoading = false;
    const bottomOffset = 20;

    // Lấy các tham số từ PHP
    const initialPosts = parseInt(news_load_params.initial_posts, 10);
    const postsPerPage = parseInt(news_load_params.posts_per_page, 10);
    const totalPosts = parseInt(news_load_params.total_posts, 10);

    let currentPostCount = initialPosts; // Bắt đầu đếm từ số bài đã tải ban đầu

    // Nếu tất cả bài viết đã được tải ban đầu, không cần làm gì thêm.
    if (currentPostCount >= totalPosts) {
        return;
    }

    // Định nghĩa hàm duy nhất để kiểm tra và tải bài viết
    const checkAndLoad = function() {
        // Thoát nếu đang trong quá trình tải hoặc đã tải hết bài
        if (isLoading || currentPostCount >= totalPosts) {
            return;
        }

        const lastArticle = articleList.children('.article_item').last();
        if (!lastArticle.length) return;

        const lastArticleRect = lastArticle[0].getBoundingClientRect();
        const windowHeight = $(window).height();

        let categorySlug = articleList.data('category');
        if (categorySlug === undefined || categorySlug === '') {
            categorySlug = news_load_params.category_slug !== undefined ? news_load_params.category_slug : 'news';
        }
        const postType = articleList.data('type') || news_load_params.post_type || 'post';

        // Kiểm tra nếu điều kiện tải được đáp ứng
        if (lastArticleRect.bottom <= windowHeight + bottomOffset) {
            isLoading = true; // Đặt cờ đang tải để chặn các yêu cầu khác
            $('.loading-indicator').show();

            $.ajax({
                url: news_load_params.ajax_url,
                type: 'POST',
                data: {
                    action: 'load_more_news_posts',
                    offset: currentPostCount, // Gửi số bài đã có
                    limit: postsPerPage, // Gửi số lượng cần tải
                    nonce: news_load_params.nonce,
                    category_slug: categorySlug,
                    post_type: postType
                },
                success: function(response) {
                    if (response.trim() !== '') {
                        // [15/06/2026] Thêm độ trễ 1.5 giây để thấy rõ hiệu ứng loading tin tức
                        setTimeout(function() {
                            // Gán class 'reveal' để kích hoạt hiệu ứng slide-up và fade-in từ CSS
                            const newItems = $(response).addClass('reveal');
                            articleList.append(newItems);
                            
                            // [15/06/2026] Xóa bỏ class 'reveal' sau khi hiệu ứng kết thúc (800ms) để khôi phục hiệu ứng hover bình thường
                            setTimeout(function() {
                                newItems.removeClass('reveal');
                            }, 800);
                            
                            // Cập nhật lại số lượng bài viết một cách chính xác
                            currentPostCount += newItems.filter('.article_item').length;
                            
                            $('.loading-indicator').hide();
                            isLoading = false;

                            if (currentPostCount >= totalPosts) {
                                // Đã tải hết, gỡ bỏ sự kiện scroll
                                $(window).off('scroll.infinite', checkAndLoad);
                            } else {
                                // Gọi lại hàm kiểm tra sau một khoảng trễ ngắn
                                setTimeout(checkAndLoad, 100);
                            }
                        }, 500);
                    } else {
                        $('.loading-indicator').hide();
                        isLoading = false;
                        currentPostCount = totalPosts;
                        $(window).off('scroll.infinite', checkAndLoad);
                    }
                },
                error: function() {
                    $('.loading-indicator').html('<p>Đã có lỗi xảy ra. Vui lòng thử lại.</p>').show();
                    isLoading = false;
                }
            });
        }
    };

    // Gán hàm vào sự kiện scroll
    $(window).on('scroll.infinite', checkAndLoad);

    // Chạy kiểm tra lần đầu khi tải trang, phòng trường hợp trang ban đầu không có thanh cuộn
    // Dùng setTimeout để đảm bảo trang đã render xong hoàn toàn
    setTimeout(checkAndLoad, 500);
});
