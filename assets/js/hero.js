document.addEventListener('DOMContentLoaded', function() {
    // Video Slider functionality ONLY
    const videos = document.querySelectorAll('.hero-bg-video');
    const prevButton = document.querySelector('.prev-button');
    const nextButton = document.querySelector('.next-button');
    let current = 0;
    let videoInterval;

    function showVideo(index) {
        videos.forEach((vid, i) => {
            vid.classList.toggle('active', i === index);
            if (i === index) {
                vid.currentTime = 0;
                vid.play();
            } else {
                vid.pause();
            }
        });
    }

    function nextVideo() {
        current = (current + 1) % videos.length;
        showVideo(current);
    }

    function prevVideo() {
        current = (current - 1 + videos.length) % videos.length;
        showVideo(current);
    }

    function startVideoSlider() {
        if (videoInterval) clearInterval(videoInterval);
        videoInterval = setInterval(nextVideo, 7000); // 7 seconds
    }

    // Pause on hover
    const heroSection = document.querySelector('.hero-section');
    if (heroSection) {
        heroSection.addEventListener('mouseenter', () => clearInterval(videoInterval));
        heroSection.addEventListener('mouseleave', startVideoSlider);
    }

    if (prevButton && nextButton) {
        prevButton.addEventListener('click', () => {
            prevVideo();
            startVideoSlider();
        });
        nextButton.addEventListener('click', () => {
            nextVideo();
            startVideoSlider();
        });
    }

    showVideo(current);
    startVideoSlider();
}); 