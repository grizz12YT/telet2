// Слайдер с кнопками на каждом слайде
document.addEventListener('DOMContentLoaded', function() {
    const slides = document.querySelector('.slides');
    const slider = document.querySelector('.slider');
    
    if (!slides) return;
    
    const slideCount = document.querySelectorAll('.slide').length;
    let currentIndex = 0;
    let autoPlayInterval;
    
    // Функция переключения слайда
    function goToSlide(index) {
        if (index < 0) {
            index = slideCount - 1;
        } else if (index >= slideCount) {
            index = 0;
        }
        currentIndex = index;
        slides.style.transform = 'translateX(' + (-currentIndex * 100) + '%)';
    }
    
    // Назначаем обработчики для всех кнопок на всех слайдах
    function bindButtons() {
        const allPrevButtons = document.querySelectorAll('.slide .prev');
        const allNextButtons = document.querySelectorAll('.slide .next');
        
        allPrevButtons.forEach(btn => {
            btn.removeEventListener('click', handlePrev);
            btn.addEventListener('click', handlePrev);
        });
        
        allNextButtons.forEach(btn => {
            btn.removeEventListener('click', handleNext);
            btn.addEventListener('click', handleNext);
        });
    }
    
    function handlePrev(e) {
        e.stopPropagation();
        goToSlide(currentIndex - 1);
    }
    
    function handleNext(e) {
        e.stopPropagation();
        goToSlide(currentIndex + 1);
    }
    
    // Автопрокрутка
    function startAutoPlay() {
        if (autoPlayInterval) clearInterval(autoPlayInterval);
        autoPlayInterval = setInterval(() => {
            goToSlide(currentIndex + 1);
        }, 10000);
    }
    
    function stopAutoPlay() {
        if (autoPlayInterval) clearInterval(autoPlayInterval);
    }
    
    // Останавливаем автопрокрутку при наведении на слайдер
    if (slider) {
        slider.addEventListener('mouseenter', stopAutoPlay);
        slider.addEventListener('mouseleave', startAutoPlay);
    }
    
    // Инициализация
    bindButtons();
    startAutoPlay();
    
    // При каждом переключении слайда обновляем привязку кнопок
    const observer = new MutationObserver(function() {
        bindButtons();
    });
    
    observer.observe(slides, { childList: true, subtree: true });
});