const statsSection = document.querySelector('.stats');

const savedFigureCountup = new countUp.CountUp('saved-figure', 1000);
const helpedClientFigureCountup = new countUp.CountUp('helped-clients-figure', 100);

new Swiper('.swiper', {
    loop: true,
    autoplay: true,
    slidesPerView: 1,
    centeredSlides: true,
    autoHeight: true
});

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if(entry.isIntersecting){
            savedFigureCountup.start();
            helpedClientFigureCountup.start();
        }
    })
});

observer.observe(statsSection);
AOS.init();