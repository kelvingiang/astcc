---
name: react-performance-hooks
description: Triggers when writing React functional components or Custom Hooks. Enforces strict memoization and prevents memory leaks.
---

# ReactJS Performance Standards

## Instructions
1. **Memoization:** Hàm xử lý logic nặng BẮT BUỘC bọc trong `useMemo`. Các function pass xuống component con BẮT BUỘC dùng `useCallback`.
2. **Cleanup:** Bất kỳ `useEffect` nào có event listener, timeout, interval, hoặc API call đều phải có cleanup function.
3. **Tránh Prop Drilling:** Ưu tiên cấu trúc Component Composition hoặc Context API nếu pass prop quá 3 cấp.
4. **Chuẩn Format:** 
   `// [YYYY-MM-DD] - @author:  Kelvin- [Giải thích cơ chế chống re-render của hook/component]`

## Expected Output Example
```javascript
// 2026-06-17 - @author: Kelvin - Custom hook debounce giá trị input, sử dụng useEffect cleanup để tránh memory leak và giảm request thừa
import { useState, useEffect } from 'react';

export const useDebounce = (value, delay = 500) => {
    const [debouncedValue, setDebouncedValue] = useState(value);

    useEffect(() => {
        const handler = setTimeout(() => {
            setDebouncedValue(value);
        }, delay);

        // Cleanup function hủy timeout cũ nếu user tiếp tục gõ
        return () => {
            clearTimeout(handler);
        };
    }, [value, delay]);

    return debouncedValue;
};