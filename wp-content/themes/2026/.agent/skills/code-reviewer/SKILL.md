---
name: code-reviewer
description: Triggers when the user asks to review, audit, or check code before committing. Scans for performance bottlenecks, Technical SEO issues, and security vulnerabilities.
---

# Code Review & Performance Audit Standards

## When to use this skill
- Khi người dùng yêu cầu: "Review file này", "Kiểm tra code", "Audit trước khi commit".

## Instructions
1. **Phân tích Hiệu suất & TTFB (PHP/WordPress):** Quét các vòng lặp, phát hiện lỗi N+1 query. Kiểm tra xem các hàm query database đã ứng dụng Transient API hoặc Object Cache chưa.
2. **Tối ưu LCP & Rendering (Frontend):** Bắt lỗi thiếu `fetchpriority="high"` cho ảnh đầu tiên (hero image), lỗi nesting SCSS quá 3 cấp làm chậm parse CSSOM, hoặc React component thiếu `useMemo`/`useCallback` gây re-render vô ích.
3. **Bảo mật:** Đảm bảo 100% data output được escape (`esc_html`, `esc_attr`, `wp_kses_post`) và query SQL bắt buộc dùng `$wpdb->prepare()`.
4. **Output Báo cáo:** 
   - TRƯỚC KHI sinh báo cáo, chạy lệnh hệ thống lấy ngày hiện hành.
   - Trình bày trực tiếp vào vấn đề, không giải thích dài dòng.
   - Cung cấp ngay đoạn code đã fix lỗi kèm comment chuẩn: `// [YYYY-MM-DD] - @author: Kelvin - [Giải pháp fix bug]`.

## Expected Output Example
```text
// 2026-06-17 - Reviewer: Kelvin - Code Audit Report

**Issues Detected:**
1. [TTFB/Performance]: Vòng lặp `foreach` đang gọi `get_post_meta()` trực tiếp, gây lỗi N+1 query làm chậm thời gian phản hồi máy chủ.
2. [Security]: Biến `$user_input` in ra view nhưng chưa được escape.

**Fixed Code:**
\```php
// 2026-06-17 - @author: Kelvin - Cập nhật cache meta data một lần (tránh N+1) và escape output an toàn
update_post_meta_cache($post_ids);
foreach ($post_ids as $id) {
    $meta = get_post_meta($id, 'custom_key', true);
    echo esc_html($meta);
}
\```