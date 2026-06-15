function animateValue(element, start, end, duration) {
    const suffix = element.innerText.replace(/[0-9]/g, '');
    let startTimestamp = null;
    const step = (timestamp) => {
        if (!startTimestamp) startTimestamp = timestamp;
        const progress = Math.min((timestamp - startTimestamp) / duration, 1);
        const currentValue = Math.floor(progress * (end - start) + start);
        element.innerText = currentValue + suffix;
        if (progress < 1) {
            window.requestAnimationFrame(step);
        }
    };
    window.requestAnimationFrame(step);
}

document.addEventListener('DOMContentLoaded', function() {
    // Danh sách các ID của các phần tử bạn muốn áp dụng hiệu ứng xuất hiện khi cuộn
    const elementsToAnimate = ['footer', 'news-home', 'home-slider-section', 'hero-stats'];

    // Cấu hình cho Intersection Observer
    const observerOptions = {
        threshold: 0.1 // Kích hoạt khi 10% của phần tử được nhìn thấy
    };

    // Callback function sẽ được thực thi khi phần tử cắt qua viewport
    const observerCallback = (entries, observer) => {
        entries.forEach(entry => {
            // Nếu phần tử đang hiển thị trong viewport
            if (entry.isIntersecting) {
                // Thêm class 'is-visible' để kích hoạt animation
                entry.target.classList.add('is-visible');

                // Nếu là hero-stats, kích hoạt hiệu ứng đếm số
                if (entry.target.id === 'hero-stats') {
                    const statNumbers = entry.target.querySelectorAll('.stat-info h3');
                    statNumbers.forEach(statNumber => {
                        const target = parseInt(statNumber.innerText, 10);
                        if (!isNaN(target)) {
                            animateValue(statNumber, 0, target, 2000); // Đếm trong 2 giây
                        }
                    });
                }

                // Ngừng theo dõi phần tử này để tiết kiệm tài nguyên
                observer.unobserve(entry.target);
            }
        });
    };

    // Tạo một đối tượng IntersectionObserver
    const observer = new IntersectionObserver(observerCallback, observerOptions);

    // Lặp qua danh sách các ID và bắt đầu theo dõi từng phần tử
    elementsToAnimate.forEach(id => {
        const element = document.getElementById(id);
        if (element) {
            observer.observe(element);
        }
    });
});
