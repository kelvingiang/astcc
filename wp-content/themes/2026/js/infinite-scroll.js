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
                    nonce: news_load_params.nonce
                },
                success: function(response) {
                    if (response.trim() !== '') {
                        const newItems = $(response);
                        articleList.append(newItems);
                        // Cập nhật lại số lượng bài viết một cách chính xác
                        currentPostCount += newItems.filter('.article_item').length;
                    } else {
                        // Không còn bài viết, đánh dấu là đã tải hết
                        currentPostCount = totalPosts;
                    }
                },
                error: function() {
                    $('.loading-indicator').html('<p>Đã có lỗi xảy ra. Vui lòng thử lại.</p>').show();
                },
                complete: function() {
                    isLoading = false; // Hoàn tất, cho phép yêu cầu tiếp theo

                    if (currentPostCount >= totalPosts) {
                        // Đã tải hết, ẩn chỉ báo và gỡ bỏ sự kiện scroll
                        $('.loading-indicator').hide();
                        $(window).off('scroll.infinite', checkAndLoad);
                    } else {
                        $('.loading-indicator').hide();
                        // **QUAN TRỌNG**: Gọi lại hàm để kiểm tra sau một khoảng trễ ngắn.
                        // Điều này giải quyết "tình trạng tranh chấp" (race condition) bằng cách cho trình duyệt
                        // thời gian để render các mục mới. Do đó, lần kiểm tra tiếp theo sẽ có được
                        // vị trí chính xác của `article_item` cuối cùng và tránh tải trùng lặp.
                        setTimeout(checkAndLoad, 100);
                    }
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
