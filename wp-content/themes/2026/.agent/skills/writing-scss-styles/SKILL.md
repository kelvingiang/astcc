---
name: writing-scss-styles
description: Triggers whenever the user asks to write, generate, or refactor SCSS/CSS code. Enforces BEM methodology, performance constraints, and standardized comments.
---

# Writing SCSS Styles Standards

## When to use this skill
- Bất cứ khi nào tạo mới hoặc chỉnh sửa file `.scss` trong thư mục `style/` hoặc các component.

## Instructions
1. **Lấy ngày tháng:** TRƯỚC KHI sinh code, Agent chạy lệnh hệ thống (ví dụ `date +%Y-%m-%d`) để lấy ngày hiện hành.
2. **Comment chuẩn:** Ghi chú chức năng và ngày tháng ở ngay trên đoạn block SCSS theo format:
   `// [YYYY-MM-DD]: [Mô tả chức năng block/module]`
3. **Quy tắc BEM:** BẮT BUỘC dùng phương pháp BEM (`.block__element--modifier`) để cấu trúc class.
4. **Giới hạn Nesting:** Tuyệt đối KHÔNG nest code SCSS quá 3 cấp. Selector quá sâu làm chậm quá trình parse CSSOM của trình duyệt.
5. **Mobile-First & Variables:** Sử dụng variables cho màu sắc/font chữ và viết media queries theo hướng Mobile-first để tối ưu tốc độ load trên di động.

## Expected Output Format
```scss
// 2026-06-17: Styling cho component hiển thị danh sách bài viết (Archive)
$text-color: #333;
$hover-color: #0056b3;

.post-list {
  display: grid;
  grid-template-columns: 1fr;
  gap: 20px;

  &__item {
    background: #fff;
    padding: 15px;
  }

  &__title {
    color: $text-color;
    font-size: 1.25rem;

    &:hover {
      color: $hover-color;
    }
  }

  &--highlight {
    border-left: 4px solid $hover-color;
  }
}