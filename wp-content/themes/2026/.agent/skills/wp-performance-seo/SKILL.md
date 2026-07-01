---
name: wp-performance-seo
description: Triggers when writing WordPress database queries, loop templates, or handling heavy data operations. Focuses on TTFB reduction and LCP optimization.
---

# WordPress Performance & SEO Standards

## Instructions
1. **Caching Đầu Tiên:** Khi viết query lấy danh sách bài viết/sản phẩm (WP_Query, get_posts), BẮT BUỘC sử dụng WordPress Transient API hoặc kiểm tra Object Cache (như LiteSpeed Cache) trước khi hit database.
2. **Tối ưu Query:** Tuyệt đối không dùng `posts_per_page => -1`. Chỉ select các field cần thiết.
3. **Lazy Load & LCP:** Khi render ảnh Thumbnail, ảnh đầu tiên (hero image) BẮT BUỘC có thuộc tính `fetchpriority="high"` và bỏ `loading="lazy"` để tối ưu LCP. Các ảnh bên dưới giữ nguyên lazy load.
4. **Chuẩn Format:** 
   `// [YYYY-MM-DD] - @author: Kelvin - [Giải thích cách query này tối ưu TTFB/LCP]`

## Expected Output Example
```php
<?php
declare(strict_types=1);

// 2026-06-17 - @author: Kelvin - Lấy danh sách bài viết nổi bật, sử dụng Transient API để giảm TTFB xuống dưới 200ms
function get_featured_posts_optimized(): array {
    $transient_key = 'featured_posts_data';
    $posts = get_transient($transient_key);

    if (false === $posts) {
        $query = new WP_Query([
            'post_type'      => 'post',
            'posts_per_page' => 5,
            'no_found_rows'  => true, // Bỏ qua đếm tổng số trang để query nhanh hơn
            'update_post_meta_cache' => false,
            'update_post_term_cache' => false,
        ]);

        $posts = $query->posts;
        set_transient($transient_key, $posts, 12 * HOUR_IN_SECONDS);
    }

    return $posts;
}