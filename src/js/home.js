const statsSection = document.querySelector('.stats');

const savedFigureCountup = new countUp.CountUp('saved-figure', 1000);
const helpedClientFigureCountup = new countUp.CountUp('helped-clients-figure', 100);

const nancyTestimonialMoreBtn = document.querySelector('.nancy-testimonial-more-btn');
const nancyTestimonialExpansion = document.querySelector('.nancy-testimonial-expansion');

new Swiper('.swiper', {
    loop: true,
    autoplay: {
        disableOnInteraction: true,
        pauseOnMouseEnter: true
    },
    slidesPerView: 1
});

nancyTestimonialMoreBtn.addEventListener('click', () => {
    nancyTestimonialExpansion.style.display = 'block';
    nancyTestimonialMoreBtn.style.display = 'none';
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