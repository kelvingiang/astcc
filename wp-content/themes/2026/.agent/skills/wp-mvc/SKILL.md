# WordPress MVC Development Standards
## Instructions
- Mọi logic xử lý (query, tính toán, xử lý input) bắt buộc nằm ở `Controller` hoặc `Model`.
- Không viết code SQL hoặc truy vấn trực tiếp (`$wpdb`) trong file template (View).
- View chỉ chứa mã HTML và các hàm hiển thị (e.g., `esc_html`, `esc_url`).
- Sử dụng Namespace cho tất cả các Class.

## Expected Output Example
```text
// 2026-06-26 - Developer: [Tên của bạn] - MVC Refactor Report

**Components Created:**
1. [Model]: `app/Models/Product.php` - Chứa logic lấy dữ liệu `WP_Query`.
2. [Controller]: `app/Controllers/ProductController.php` - Điều phối dữ liệu từ Model sang View.
3. [View]: `app/Views/product-list.php` - Template hiển thị sản phẩm.

**Implementation:**
```php
// Controller: Lấy dữ liệu an toàn
namespace App\Controllers;
use App\Models\Product;

class ProductController {
    public function render() {
        $model = new Product();
        $data = $model->getAll();
        require_once 'Views/product-list.php';
    }
}