<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"> -->
    <title>Маршруты Удмуртии</title>
    <style>
        /* ДОПОЛНИТЕЛЬНЫЕ СТИЛИ ДЛЯ ПЛАВНОСТИ */
    <?php
    session_start();

    // Для отладки - выводим содержимое сессии (удалить после отладки)
    error_log('SESSION: ' . print_r($_SESSION, true));
    ?>
    </style>
</head>
<body>
    <div class="background">
        <header class="header">
            <div class="nav__header container">
                <a href="#" class="link__logo__nav__header"><img src="img/logo.caf05db1.gif" alt="" class="logo__nav__header"></a>
                <div class="nav__list__header__block">
                    <ul class="nav__list__header">
                        <li class="nav__item__list"><a href="#main" class="link__nav__list__header">Главная</a></li>
                        <li class="nav__item__list"><a href="#routes" class="link__nav__list__header">Маршруты</a></li>
                        <li class="nav__item__list"><a href="#rate" class="link__nav__list__header">Отзывы</a></li>
                        <li class="nav__item__list"><a href="#bron" class="link__nav__list__header">Оформить заявку</a></li>
                    </ul>
                </div>
                <div id="authSection" class="auth-buttons">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <div class="user-info">
                            <span class="user-name">👤 <?php echo htmlspecialchars($_SESSION['username']); ?></span>
                            <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1): ?>
                                <a href="/admin/index.php" class="admin-btn">👑 Админка</a>
                            <?php endif; ?>
                            <button class="logout-btn" onclick="logout()">Выйти</button>
                        </div>
                    <?php else: ?>
                        <button class="login-btn" onclick="openAuthModal('login')">Войти</button>
                        <button class="register-btn" onclick="openAuthModal('register')">Регистрация</button>
                    <?php endif; ?>
                </div>
            </div>
        </header>

        <!-- Модальное окно авторизации -->
        <div id="authModal" class="auth-modal">
            <div class="auth-modal-content">
                <div class="auth-close" onclick="closeAuthModal()">&times;</div>
                <div class="auth-tabs">
                    <div class="auth-tab active" data-tab="login" onclick="switchAuthTab('login')">Вход</div>
                    <div class="auth-tab" data-tab="register" onclick="switchAuthTab('register')">Регистрация</div>
                </div>
                
                <div id="loginForm" class="auth-form">
                    <div class="auth-form-group">
                        <label class="auth-label">Логин</label>
                        <input type="text" id="loginUsername" class="auth-input" placeholder="Введите логин">
                    </div>
                    <div class="auth-form-group">
                        <label class="auth-label">Пароль</label>
                        <input type="password" id="loginPassword" class="auth-input" placeholder="Введите пароль">
                    </div>
                    <button class="auth-submit-btn" onclick="login()">Войти</button>
                </div>
                
                <div id="registerForm" class="auth-form" style="display: none;">
                    <div class="auth-form-group">
                        <label class="auth-label">Логин</label>
                        <input type="text" id="regLogin" class="auth-input" placeholder="Придумайте логин">
                    </div>
                    <div class="auth-form-group">
                        <label class="auth-label">Email</label>
                        <input type="email" id="regEmail" class="auth-input" placeholder="Ваш email">
                    </div>
                    <div class="auth-form-group">
                        <label class="auth-label">Номер телефона</label>
                        <input type="tel" id="regPhone" class="auth-input" placeholder="+7 (999) 123-45-67">
                    </div>
                    <div class="auth-form-group">
                        <label class="auth-label">Пароль</label>
                        <input type="password" id="regPassword" class="auth-input" placeholder="Придумайте пароль">
                    </div>
                    <button class="auth-submit-btn" onclick="register()">Зарегистрироваться</button>
                </div>
            </div>
        </div>

        <!-- СЛАЙДЕР -->
        <section class="one__list container" id="main">
            <h1 class="header__one__list">Удмуртская Республика. Живи настоящим</h1>
            <div class="slider">
                <div class="slides">
                    <div class="slide"><img src="img/izevsk.png"><div class="info"><h1 class="city">Ижевск</h1><h4 class="information">Столица Удмуртии и оружейная столица России.</h4></div></div>
                    <div class="slide"><img src="img/votkinsk.png"><div class="info"><h1 class="city">Воткинск</h1><h4 class="information">Промышленный город в Удмуртии, место рождения П. И. Чайковского.</h4></div></div>
                    <div class="slide"><img src="img/sarapul.png"><div class="info"><h1 class="city">Сарапул</h1><h4 class="information">Город в Удмуртии на берегу Камы, третий по численности в республике.</h4></div></div>
                    <div class="slide"><img src="img/glazov.png"><div class="info"><h1 class="city">Глазов</h1><h4 class="information">Второй по значимости промышленный центр Удмуртии.</h4></div></div>
                    <div class="slide"><img src="img/mozga.png"><div class="info"><h1 class="city">Можга</h1><h4 class="information">Город в Удмуртской Республике, крупный индустриальный и культурный центр.</h4></div></div>
                    <div class="slide"><img src="img/kambarka.png"><div class="info"><h1 class="city">Камбарка</h1><h4 class="information">Город в Удмуртии, административный центр Камбарского района.</h4></div></div>
                </div>
                <button class="prev">&#10094;</button>
                <button class="next">&#10095;</button>
            </div>
        </section>




        
<!-- КОНФИГУРАТОР МАРШРУТОВ -->
<section class="configurator-section container">
    <div class="configurator-wrapper">
        <div class="configurator-header">
            <h2 class="configurator-title"><i class="fas fa-magic"></i> Конфигуратор маршрута</h2>
            <p class="configurator-subtitle">Ответьте на несколько вопросов, и мы подберём идеальный маршрут для вас!</p>
        </div>

        <div class="configurator-form">
            <div class="configurator-grid">
                <div class="configurator-field">
                    <label><i class="fas fa-clock"></i> Сколько времени есть?</label>
                    <select id="config-duration">
                        <option value="all">Любая длительность</option>
                        <option value="1">1 день или полдня</option>
                        <option value="2">2-3 дня</option>
                        <option value="3">3+ дней</option>
                    </select>
                </div>

                <div class="configurator-field">
                    <label><i class="fas fa-car"></i> Как предпочитаете путешествовать?</label>
                    <select id="config-type">
                        <option value="all">Любой способ</option>
                        <option value="Автомобильный">На автомобиле</option>
                        <option value="Автобусный">На автобусе</option>
                        <option value="Пеший">Пешком</option>
                        <option value="Водный">По воде</option>
                    </select>
                </div>

                <div class="configurator-field">
                    <label><i class="fas fa-tag"></i> Какая тематика интересна?</label>
                    <select id="config-category">
                        <option value="all">Любая</option>
                        <option value="Исторический">Исторический</option>
                        <option value="Природный">Природный</option>
                        <option value="Этнографический">Этнографический</option>
                        <option value="Гастрономический">Гастрономический</option>
                        <option value="Волонтёрский">Волонтёрский</option>
                        <option value="Культурный">Культурный</option>
                        <option value="Архитектурный">Архитектурный</option>
                        <option value="Экологический">Экологический</option>
                    </select>
                </div>

                <div class="configurator-field">
                    <label><i class="fas fa-coins"></i> Бюджет поездки?</label>
                    <select id="config-budget">
                        <option value="all">Любой</option>
                        <option value="Эконом">Эконом</option>
                        <option value="Средний">Средний</option>
                    </select>
                </div>

                <div class="configurator-field">
                    <label><i class="fas fa-child"></i> Путешествуете с детьми?</label>
                    <select id="config-kids">
                        <option value="all">Не важно</option>
                        <option value="true">Да, с детьми</option>
                        <option value="false">Только взрослые</option>
                    </select>
                </div>

                <div class="configurator-field">
                    <label><i class="fas fa-paw"></i> Берёте питомцев?</label>
                    <select id="config-pets">
                        <option value="all">Не важно</option>
                        <option value="true">Да, с животными</option>
                        <option value="false">Без животных</option>
                    </select>
                </div>
            </div>

            <div class="configurator-buttons">
                <button class="config-find-btn" id="configFindBtn"><i class="fas fa-search"></i> Найти маршрут</button>
                <button class="config-random-btn" id="configRandomBtn" style="display: none;"><i class="fas fa-random"></i> Другой вариант</button>
                <button class="config-reset-btn" id="configResetBtn"><i class="fas fa-undo-alt"></i> Сбросить</button>
            </div>
        </div>

        <div class="configurator-result" id="configResult" style="display: none;">
            <div class="config-loader" id="configLoader" style="display: none;">
                <i class="fas fa-spinner fa-pulse"></i> Подбираем идеальный маршрут...
            </div>
            <div class="config-result-card" id="configResultCard"></div>
            <div class="config-no-results" id="configNoResults" style="display: none;">
                <i class="fas fa-sad-tear"></i>
                <h3>Маршрутов не найдено</h3>
                <p>К сожалению, нет маршрутов, соответствующих вашим критериям.<br>Попробуйте изменить параметры поиска.</p>
                <button class="config-change-btn" onclick="resetConfigFilters(); setTimeout(() => findRoutes(), 100);">📝 Изменить критерии</button>
            </div>
        </div>
    </div>
</section>


        <!-- МАРШРУТЫ С ПОИСКОМ И ФИЛЬТРАМИ -->
        <section class="t2-routes" id="routes">
            <div class="t2-routes-container">
                <div class="t2-routes-header">
                    <h2 class="t2-routes-title"><i class="fas fa-map-marked-alt"></i> Маршруты по Удмуртии</h2>
                    <p class="t2-routes-subtitle">Исторические, гастрономические, природные и волонтёрские путешествия по родному краю</p>
                    
                    <div class="search-container">
                        <div class="search-wrapper">
                            <i class="fas fa-search search-icon"></i>
                            <input type="text" class="search-input" id="searchInput" placeholder="Поиск по названию маршрута или городу...">
                            <button class="search-clear" id="searchClearBtn"><i class="fas fa-times"></i></button>
                        </div>
                        <div class="search-history" id="searchHistory">
                            <div class="search-history-header">
                                <span><i class="fas fa-history"></i> Недавние поиски</span>
                                <button class="clear-history-btn" id="clearHistoryBtn">Очистить историю</button>
                            </div>
                            <div class="search-history-list" id="historyList"></div>
                            <div class="search-suggestions" id="searchSuggestions" style="display: none;">
                                <div class="search-history-header">
                                    <span><i class="fas fa-lightbulb"></i> Подсказки</span>
                                </div>
                                <div id="suggestionsList"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="t2-filters">
                    <div class="t2-filters-grid">
                        <div class="t2-filter-item"><label class="t2-filter-label"><i class="fas fa-clock"></i> Длительность</label><select class="t2-filter-select" id="t2-filter-duration"><option value="all">Все</option><option value="1">1 день</option><option value="2">2 дня</option><option value="3">3+ дней</option></select></div>
                        <div class="t2-filter-item"><label class="t2-filter-label"><i class="fas fa-car"></i> Тип</label><select class="t2-filter-select" id="t2-filter-type"><option value="all">Все</option><option value="Автомобильный">Автомобильный</option><option value="Автобусный">Автобусный</option><option value="Пеший">Пеший</option><option value="Водный">Водный</option></select></div>
                        <div class="t2-filter-item"><label class="t2-filter-label"><i class="fas fa-tag"></i> Категория</label><select class="t2-filter-select" id="t2-filter-category"><option value="all">Все</option><option value="Волонтёрский">Волонтёрский</option><option value="Исторический">Исторический</option><option value="Природный">Природный</option><option value="Экологический">Экологический</option><option value="Этнографический">Этнографический</option><option value="Гастрономический">Гастрономический</option><option value="Культурный">Культурный</option><option value="Архитектурный">Архитектурный</option></select></div>
                        <div class="t2-filter-item"><label class="t2-filter-label"><i class="fas fa-child"></i> Дети</label><select class="t2-filter-select" id="t2-filter-kids"><option value="all">Все</option><option value="true">Можно с детьми</option><option value="false">Только взрослые</option></select></div>
                        <div class="t2-filter-item"><label class="t2-filter-label"><i class="fas fa-paw"></i> Животные</label><select class="t2-filter-select" id="t2-filter-pets"><option value="all">Все</option><option value="true">Можно с животными</option><option value="false">Нельзя</option></select></div>
                        <div class="t2-filter-item"><label class="t2-filter-label"><i class="fas fa-coins"></i> Бюджет</label><select class="t2-filter-select" id="t2-filter-budget"><option value="all">Все</option><option value="Эконом">Эконом</option><option value="Средний">Средний</option></select></div>
                        <div class="t2-filter-item t2-filter-action"><button class="t2-reset-btn" id="t2-reset-filters"><i class="fas fa-undo-alt"></i> Сбросить</button></div>
                    </div>
                </div>

                <div class="t2-counter"><span id="t2-count">0</span> маршрутов найдено</div>

                <div class="t2-grid-container">
                    <div class="t2-grid" id="t2-grid">
                        <div class="t2-loader"><i class="fas fa-spinner fa-pulse"></i> Загрузка маршрутов...</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- МОДАЛЬНОЕ ОКНО С ГАЛЕРЕЕЙ -->
        <div id="routeModal" class="modal">
            <div class="modal-content">
                <div class="modal-close" onclick="closeModal()">&times;</div>
                <div class="modal-header">
                    <h2 id="modalTitle"></h2>
                    <div class="modal-price" id="modalPrice"></div>
                </div>
                
                <div class="modal-gallery" id="modalGallery">
                    <div class="gallery-slides" id="gallerySlides">
                        <div class="gallery-slide"><img id="galleryImage" src="" alt=""></div>
                    </div>
                    <button class="gallery-prev" id="galleryPrevBtn"><i class="fas fa-chevron-left"></i></button>
                    <button class="gallery-next" id="galleryNextBtn"><i class="fas fa-chevron-right"></i></button>
                    <div class="gallery-dots" id="galleryDots"></div>
                    <div class="gallery-counter" id="galleryCounter">1 / 1</div>
                </div>
                
                <div class="modal-body">
                    <div class="modal-info-grid">
                        <div class="modal-info-item"><i class="fas fa-clock"></i> <strong>Длительность:</strong> <span id="modalDuration"></span></div>
                        <div class="modal-info-item"><i class="fas fa-car"></i> <strong>Тип:</strong> <span id="modalType"></span></div>
                        <div class="modal-info-item"><i class="fas fa-map-marker-alt"></i> <strong>Локация:</strong> <span id="modalCoords"></span></div>
                        <div class="modal-info-item"><i class="fas fa-child"></i> <strong>Дети:</strong> <span id="modalKids"></span></div>
                        <div class="modal-info-item"><i class="fas fa-paw"></i> <strong>Животные:</strong> <span id="modalPets"></span></div>
                        <div class="modal-info-item"><i class="fas fa-coins"></i> <strong>Бюджет:</strong> <span id="modalBudget"></span></div>
                    </div>
                    <div class="modal-description" id="modalDescription"></div>
                    <div class="modal-categories" id="modalCategories"></div>
                    <button class="modal-book-btn" onclick="bookRoute()"><i class="fas fa-calendar-check"></i> Забронировать маршрут</button>
                </div>
            </div>
        </div>

        <!-- ОТЗЫВЫ -->
        <section class="rate__three__list container" id="rate">
            <h1 class="header__rate__three">Отзывы клиентов</h1>
            <div class="reviews-wrapper" id="reviews-container"></div>
        </section>
<!-- ФОРМА ДОБАВЛЕНИЯ ОТЗЫВА -->
<section class="review-form-section container" id="reviewFormSection">
    <div class="review-form-wrapper">
        <div class="review-form-header">
            <h2 class="review-form-title"><i class="fas fa-pen-fancy"></i> Оставить отзыв</h2>
            <p class="review-form-subtitle">Поделитесь впечатлениями о путешествии по Удмуртии</p>
        </div>
        
        <form id="reviewForm" class="review-form" onsubmit="submitReview(event)">
            <div class="review-form-grid">
                <div class="review-form-group full-width">
                    <label class="review-label"><i class="fas fa-user"></i> Ваше имя</label>
                    <input type="text" id="reviewAuthor" class="review-input" placeholder="Как вас зовут?" required>
                </div>
                
                <div class="review-form-group full-width">
                    <label class="review-label"><i class="fas fa-route"></i> Какой маршрут выбрали?</label>
                    <select id="reviewRoute" class="review-select" required>
                        <option value="">Выберите маршрут</option>
                    </select>
                </div>
                
                <div class="review-form-group">
                    <label class="review-label"><i class="fas fa-star"></i> Оценка</label>
                    <div class="rating-stars" id="ratingStars">
                        <span class="rating-star" data-value="1">★</span>
                        <span class="rating-star" data-value="2">★</span>
                        <span class="rating-star" data-value="3">★</span>
                        <span class="rating-star" data-value="4">★</span>
                        <span class="rating-star" data-value="5">★</span>
                    </div>
                    <input type="hidden" id="reviewRating" value="5">
                </div>
                
                <div class="review-form-group">
                    <label class="review-label"><i class="fas fa-calendar-alt"></i> Дата поездки</label>
                    <input type="date" id="reviewDate" class="review-input" required>
                </div>
                
                <div class="review-form-group full-width">
                    <label class="review-label"><i class="fas fa-comment"></i> Ваш отзыв</label>
                    <textarea id="reviewText" class="review-textarea" rows="4" placeholder="Расскажите о своих впечатлениях, что понравилось, что запомнилось..." required></textarea>
                </div>
                
            </div>
            
            <div class="review-form-buttons">
                <button type="submit" class="review-submit-btn" id="reviewSubmitBtn">
                    <i class="fas fa-paper-plane"></i> Отправить отзыв
                </button>
                <button type="button" class="review-reset-btn" onclick="resetReviewForm()">
                    <i class="fas fa-eraser"></i> Очистить
                </button>
            </div>
            <div id="reviewStatus" class="review-status"></div>
        </form>
    </div>
</section>
        <!-- ФОРМА БРОНИРОВАНИЯ -->
        <section class="registra container" id="bron">
            <h1 class="header__reg">Подать заявку на маршрут</h1>
            <form id="bookingForm" class="ishak" onsubmit="submitBooking(event)">
                <div class="udmurtFormGroup">
                    <label class="udmurtLabel" for="fullName">ФИО</label>
                    <input class="udmurtInput" type="text" id="fullName" name="fullName" required />
                </div>
                <div class="udmurtFormGroup">
                    <label class="udmurtLabel" for="phone">Телефон</label>
                    <input class="udmurtInput" type="tel" id="phone" name="phone" required placeholder="+7 (999) 123-45-67" />
                </div>
                <div class="udmurtFormGroup">
                    <label class="udmurtLabel" for="email">Email</label>
                    <input class="udmurtInput" type="email" id="email" name="email" required placeholder="example@mail.ru" />
                </div>
                <div class="udmurtFormGroup">
                    <label class="udmurtLabel" for="routeName">Маршрут</label>
                    <select class="udmurtSelect" id="routeName" name="routeName" required>
                        <option value="">Выберите маршрут</option>
                    </select>
                </div>
                <div class="udmurtFormGroup">
                    <label class="udmurtLabel" for="date">Желаемая дата поездки</label>
                    <input class="udmurtInput" type="date" id="date" name="date" required />
                    <small class="date-hint"><i class="fas fa-exclamation-triangle"></i> ⚠️ ВНИМАНИЕ! Приём заявок ТОЛЬКО на даты после 11 апреля 2026 года. Даты раньше 12.04.2026 запрещены!</small>
                </div>
                <div class="udmurtFormGroup">
                    <label class="udmurtLabel" for="passengers">Количество человек</label>
                    <input class="udmurtInput" type="number" id="passengers" name="passengers" min="1" max="50" value="1" required />
                </div>
                <div class="udmurtFormGroup">
                    <label class="udmurtLabel" for="comment">Комментарий / пожелания</label>
                    <textarea class="udmurtTextarea" id="comment" name="comment" placeholder="Ваши пожелания..."></textarea>
                </div>
                <button class="udmurtButton" type="submit">Отправить заявку</button>
                <div id="status" style="margin-top: 15px;"></div>
            </form>
        </section>

        <!-- ФУТЕР -->
        <footer class="footer">
            <div class="footer-container">
                <div class="footer-grid">
                    <div class="footer-col">
                        <h4>ТУРАГЕНТСТВО «t2-TRAVEL»</h4>
                        <p class="travel">Откройте для себя удмуртскую природу, архитектуру и легенды. Индивидуальные и групповые туры по республике.</p>
                    </div>
                    <div class="footer-col">
                        <h4>КОНТАКТЫ</h4>
                        <div class="contact-line"><i class="fas fa-phone-alt"></i> <a href="tel:+73412556677">+7 (999) 918-24-60</a></div>
                        <div class="contact-line"><i class="fas fa-envelope"></i> <a href="mailto:udm-travel@example.ru">udm-travel@example.ru</a></div>
                        <div class="contact-line"><i class="fas fa-map-marker-alt"></i> <span>г. Ижевск, ул. Советская, 12</span></div>
                    </div>
                    <div class="footer-col">
                        <h4>МЫ В СЕТИ</h4>
                        <div class="social-row">
                            <a href="#" class="social-icon" aria-label="Одноклассники"><img src="img/odnoklasniki.png" alt="odno" class="odnoklasniki"></a>
                            <a href="#" class="social-icon" aria-label="ВКонтакте"><img src="img/vk.png" alt="vk" class="vk"></a>
                        </div>
                        <h4>ПОДЕЛИТЬСЯ</h4>
                        <div class="social-row">
                            <a href="#" class="social-icon" aria-label="Одноклассники"><img src="img/odnoklasniki.png" alt="odno" class="odnoklasniki"></a>
                            <a href="#" class="social-icon" aria-label="ВКонтакте"><img src="img/vk.png" alt="vk" class="vk"></a>
                        </div>
                    </div>
                </div>
                <div class="footer-bottom">
                    <div class="copyright"><i class="far fa-copyright"></i> 2026 Турагентство «t2-Travel». Все права защищены.</div>
                    <div class="legal-links"><a href="#">Политика конфиденциальности</a><a href="#">Оферта</a><a href="#">Карта сайта</a></div>
                </div>
            </div>
        </footer>
    </div>

    <script>
        // ========== СЛАЙДЕР ==========
        let slideIndex = 0;
        const slides = document.querySelector('.slides');
        const totalSlides = document.querySelectorAll('.slide').length;
        function updateSlider() { if (slides) slides.style.transform = `translateX(-${slideIndex * 100}%)`; }
        function nextSlide() { slideIndex = slideIndex < totalSlides - 1 ? slideIndex + 1 : 0; updateSlider(); }
        function prevSlide() { slideIndex = slideIndex > 0 ? slideIndex - 1 : totalSlides - 1; updateSlider(); }
        
        // Автоматическое переключение слайдера каждые 5 секунд
        let sliderInterval = setInterval(nextSlide, 5000);
        
        // Остановка авто-переключения при наведении на слайдер
        const sliderContainer = document.querySelector('.slider');
        if (sliderContainer) {
            sliderContainer.addEventListener('mouseenter', () => clearInterval(sliderInterval));
            sliderContainer.addEventListener('mouseleave', () => {
                sliderInterval = setInterval(nextSlide, 5000);
            });
        }
        
        // ========== АВТОРИЗАЦИЯ ==========
        window.openAuthModal = function(tab) {
            const modal = document.getElementById('authModal');
            modal.classList.add('active');
            document.body.style.overflow = 'hidden';
            switchAuthTab(tab);
        }

        window.closeAuthModal = function() {
            const modal = document.getElementById('authModal');
            modal.classList.remove('active');
            document.body.style.overflow = '';
        }

        window.switchAuthTab = function(tab) {
            const loginTab = document.querySelector('.auth-tab[data-tab="login"]');
            const registerTab = document.querySelector('.auth-tab[data-tab="register"]');
            const loginForm = document.getElementById('loginForm');
            const registerForm = document.getElementById('registerForm');
            
            if (tab === 'login') {
                loginTab.classList.add('active');
                registerTab.classList.remove('active');
                loginForm.style.display = 'block';
                registerForm.style.display = 'none';
            } else {
                registerTab.classList.add('active');
                loginTab.classList.remove('active');
                registerForm.style.display = 'block';
                loginForm.style.display = 'none';
            }
        }

        window.register = async function() {
            const username = document.getElementById('regLogin').value.trim();
            const email = document.getElementById('regEmail').value.trim();
            const phone = document.getElementById('regPhone').value.trim();
            const password = document.getElementById('regPassword').value;
            
            if (!username || !email || !phone || !password) {
                alert('Пожалуйста, заполните все поля');
                return;
            }
            if (!email.includes('@')) {
                alert('Введите корректный email');
                return;
            }
            try {
                const response = await fetch('api.php?action=register', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ username, email, phone, password })
                });
                const data = await response.json();
                if (data.success) {
                    alert('Регистрация успешна! Теперь войдите.');
                    switchAuthTab('login');
                    document.getElementById('loginUsername').value = username;
                } else {
                    alert(data.message);
                }
            } catch (error) {
                alert('Ошибка соединения с сервером');
            }
        }

        window.login = async function() {
            const username = document.getElementById('loginUsername').value.trim();
            const password = document.getElementById('loginPassword').value;
            if (!username || !password) {
                alert('Пожалуйста, заполните все поля');
                return;
            }
            try {
                const response = await fetch('api.php?action=login', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ username, password })
                });
                const data = await response.json();
                if (data.success) {
                    closeAuthModal();
                    location.reload();
                } else {
                    alert(data.message);
                }
            } catch (error) {
                alert('Ошибка соединения с сервером');
            }
        }

        window.logout = async function() {
            try {
                await fetch('api.php?action=logout');
                location.reload();
            } catch (error) {
                alert('Ошибка');
            }
        }

        document.getElementById('authModal')?.addEventListener('click', function(e) {
            if (e.target === this) closeAuthModal();
        });




        // ========== ФОРМА ОТЗЫВОВ ==========
let currentImageFile = null;

// Инициализация звёзд рейтинга
function initRatingStars() {
    const stars = document.querySelectorAll('.rating-star');
    const ratingInput = document.getElementById('reviewRating');
    
    stars.forEach(star => {
        star.addEventListener('click', function() {
            const value = parseInt(this.dataset.value);
            ratingInput.value = value;
            
            stars.forEach(s => {
                const starValue = parseInt(s.dataset.value);
                if (starValue <= value) {
                    s.classList.add('active');
                } else {
                    s.classList.remove('active');
                }
            });
        });
        
        star.addEventListener('mouseenter', function() {
            const value = parseInt(this.dataset.value);
            stars.forEach(s => {
                const starValue = parseInt(s.dataset.value);
                if (starValue <= value) {
                    s.style.color = '#FF00A0';
                } else {
                    s.style.color = '#CCCCCC';
                }
            });
        });
        
        star.addEventListener('mouseleave', function() {
            const currentRating = parseInt(ratingInput.value);
            stars.forEach(s => {
                const starValue = parseInt(s.dataset.value);
                if (starValue <= currentRating) {
                    s.style.color = '#FF00A0';
                } else {
                    s.style.color = '#CCCCCC';
                }
            });
        });
    });
}

// Загрузка маршрутов в селект отзыва
function loadRoutesToReviewSelect() {
    const reviewRouteSelect = document.getElementById('reviewRoute');
    if (!reviewRouteSelect || !routesData.length) return;
    
    reviewRouteSelect.innerHTML = '<option value="">Выберите маршрут</option>';
    routesData.forEach(route => {
        const option = document.createElement('option');
        option.value = route.title;
        option.textContent = route.title;
        reviewRouteSelect.appendChild(option);
    });
}

// Область загрузки фото
function initUploadArea() {
    const uploadArea = document.getElementById('uploadArea');
    const fileInput = document.getElementById('reviewImage');
    
    if (!uploadArea || !fileInput) return;
    
    uploadArea.addEventListener('click', () => fileInput.click());
    
    fileInput.addEventListener('change', function(e) {
        if (this.files && this.files[0]) {
            const file = this.files[0];
            
            // Проверка размера (до 5MB)
            if (file.size > 5 * 1024 * 1024) {
                showReviewStatus('Файл слишком большой! Максимум 5MB', 'error');
                return;
            }
            
            // Проверка типа
            if (!file.type.match('image.*')) {
                showReviewStatus('Пожалуйста, выберите изображение', 'error');
                return;
            }
            
            currentImageFile = file;
            
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('imagePreview');
                const previewImg = document.getElementById('previewImg');
                previewImg.src = e.target.result;
                preview.style.display = 'block';
                uploadArea.style.display = 'none';
            };
            reader.readAsDataURL(file);
        }
    });
    
    // Drag & drop
    uploadArea.addEventListener('dragover', (e) => {
        e.preventDefault();
        uploadArea.style.background = '#FFF0F7';
        uploadArea.style.borderColor = '#ff66b5';
    });
    
    uploadArea.addEventListener('dragleave', (e) => {
        e.preventDefault();
        uploadArea.style.background = '#FAFAFA';
        uploadArea.style.borderColor = '#FF00A0';
    });
    
    uploadArea.addEventListener('drop', (e) => {
        e.preventDefault();
        uploadArea.style.background = '#FAFAFA';
        uploadArea.style.borderColor = '#FF00A0';
        
        const file = e.dataTransfer.files[0];
        if (file && file.type.match('image.*')) {
            if (file.size <= 5 * 1024 * 1024) {
                currentImageFile = file;
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById('imagePreview');
                    const previewImg = document.getElementById('previewImg');
                    previewImg.src = e.target.result;
                    preview.style.display = 'block';
                    uploadArea.style.display = 'none';
                };
                reader.readAsDataURL(file);
            } else {
                showReviewStatus('Файл слишком большой! Максимум 5MB', 'error');
            }
        } else {
            showReviewStatus('Пожалуйста, загрузите изображение', 'error');
        }
    });
}

window.removeImage = function() {
    currentImageFile = null;
    const preview = document.getElementById('imagePreview');
    const uploadArea = document.getElementById('uploadArea');
    const fileInput = document.getElementById('reviewImage');
    
    preview.style.display = 'none';
    uploadArea.style.display = 'block';
    fileInput.value = '';
};

function showReviewStatus(message, type) {
    const statusDiv = document.getElementById('reviewStatus');
    statusDiv.innerHTML = `<div class="${type}">${message}</div>`;
    setTimeout(() => {
        statusDiv.innerHTML = '';
    }, 5000);
}

// Валидация даты
function validateReviewDate(dateString) {
    if (!dateString) return false;
    const selectedDate = new Date(dateString);
    const today = new Date();
    today.setHours(0, 0, 0, 0);
    return selectedDate <= today;
}

// Отправка отзыва
window.submitReview = async function(event) {
    event.preventDefault();
    
    <?php if (!isset($_SESSION['user_id'])): ?>
        showReviewStatus('Пожалуйста, войдите в аккаунт, чтобы оставить отзыв', 'error');
        openAuthModal('login');
        return;
    <?php endif; ?>
    
    const author = document.getElementById('reviewAuthor').value.trim();
    const route = document.getElementById('reviewRoute').value;
    const rating = document.getElementById('reviewRating').value;
    const travelDate = document.getElementById('reviewDate').value;
    const text = document.getElementById('reviewText').value.trim();
    
    // Валидация
    if (!author) {
        showReviewStatus('Пожалуйста, укажите ваше имя', 'error');
        return;
    }
    
    if (!route) {
        showReviewStatus('Пожалуйста, выберите маршрут', 'error');
        return;
    }
    
    if (!travelDate) {
        showReviewStatus('Пожалуйста, укажите дату поездки', 'error');
        return;
    }
    
    if (!validateReviewDate(travelDate)) {
        showReviewStatus('Дата поездки не может быть в будущем', 'error');
        return;
    }
    
    if (!text) {
        showReviewStatus('Пожалуйста, напишите ваш отзыв', 'error');
        return;
    }
    
    if (text.length < 10) {
        showReviewStatus('Отзыв должен содержать минимум 10 символов', 'error');
        return;
    }
    
    // Анимация кнопки
    const submitBtn = document.getElementById('reviewSubmitBtn');
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-pulse"></i> Отправка...';
    submitBtn.disabled = true;
    
    try {
        // Создаём FormData для отправки с файлом
        const formData = new FormData();
        formData.append('action', 'add_review');
        formData.append('author', author);
        formData.append('route', route);
        formData.append('rating', rating);
        formData.append('travel_date', travelDate);
        formData.append('text', text);
        if (currentImageFile) {
            formData.append('image', currentImageFile);
        }
        
        const response = await fetch('api.php', {
            method: 'POST',
            body: formData
        });
        
        const data = await response.json();
        
        if (data.success) {
            showReviewStatus('✅ Спасибо! Ваш отзыв успешно добавлен и появится после модерации.', 'success');
            resetReviewForm();
            
            // Обновляем отзывы на странице
            const allReviews = await loadReviews();
            const reviewsContainer = document.getElementById("reviews-container");
            if (reviewsContainer && allReviews.length) {
                renderCards(reviewsContainer, getRandomItems(allReviews, 3), false);
            }
        } else {
            showReviewStatus(data.message || 'Ошибка при отправке отзыва', 'error');
        }
    } catch (error) {
        console.error('Error:', error);
        showReviewStatus('Ошибка соединения с сервером', 'error');
    } finally {
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    }
};

function resetReviewForm() {
    document.getElementById('reviewForm').reset();
    document.getElementById('reviewRating').value = '5';
    
    // Сброс звёзд
    const stars = document.querySelectorAll('.rating-star');
    stars.forEach((star, index) => {
        if (index < 5) {
            star.classList.add('active');
        } else {
            star.classList.remove('active');
        }
    });
    
    // Сброс изображения
    removeImage();
    
    // Убираем статус
    document.getElementById('reviewStatus').innerHTML = '';
}

// Инициализация формы отзывов
function initReviewForm() {
    initRatingStars();
    initUploadArea();
    
    // Ждём загрузки маршрутов
    const checkRoutesInterval = setInterval(() => {
        if (routesData && routesData.length) {
            clearInterval(checkRoutesInterval);
            loadRoutesToReviewSelect();
        }
    }, 500);
    setTimeout(() => clearInterval(checkRoutesInterval), 10000);
}

// Запуск инициализации после загрузки DOM
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initReviewForm);
} else {
    initReviewForm();
}
        // ========== ПОИСК С ИСТОРИЕЙ ==========
        const SEARCH_HISTORY_KEY = 'route_search_history';
        const MAX_HISTORY_ITEMS = 10;
        
        function getSearchHistory() {
            const history = localStorage.getItem(SEARCH_HISTORY_KEY);
            return history ? JSON.parse(history) : [];
        }
        
        function saveSearchHistory(history) {
            localStorage.setItem(SEARCH_HISTORY_KEY, JSON.stringify(history.slice(0, MAX_HISTORY_ITEMS)));
        }
        
        function addToSearchHistory(query) {
            if (!query || query.trim().length < 2) return;
            let history = getSearchHistory();
            const normalizedQuery = query.trim().toLowerCase();
            history = history.filter(item => item.toLowerCase() !== normalizedQuery);
            history.unshift(query.trim());
            if (history.length > MAX_HISTORY_ITEMS) history = history.slice(0, MAX_HISTORY_ITEMS);
            saveSearchHistory(history);
            renderHistoryList();
        }
        
        function removeFromHistory(query) {
            let history = getSearchHistory();
            history = history.filter(item => item !== query);
            saveSearchHistory(history);
            renderHistoryList();
        }
        
        function clearSearchHistory() {
            saveSearchHistory([]);
            renderHistoryList();
            hideSearchHistory();
        }
        
        function getSuggestions(input, routes, limit = 5) {
            if (!input || input.length < 1) return [];
            const lowerInput = input.toLowerCase();
            const suggestionsSet = new Set();
            routes.forEach(route => {
                if (route.title.toLowerCase().includes(lowerInput)) suggestionsSet.add(route.title);
                if (route.coords && route.coords.toLowerCase().includes(lowerInput)) {
                    const cities = route.coords.split(/[—–-]|,\s*/);
                    cities.forEach(city => {
                        const trimmedCity = city.trim();
                        if (trimmedCity.toLowerCase().includes(lowerInput) && trimmedCity.length > 1) suggestionsSet.add(trimmedCity);
                    });
                }
            });
            return Array.from(suggestionsSet).slice(0, limit);
        }
        
        function renderHistoryList() {
            const historyList = document.getElementById('historyList');
            const history = getSearchHistory();
            if (!historyList) return;
            if (history.length === 0) {
                historyList.innerHTML = '<div style="padding: 12px 16px; color: #999; text-align: center;">История поиска пуста</div>';
                return;
            }
            historyList.innerHTML = history.map(item => `
                <div class="history-item" data-query="${escapeHtml(item)}">
                    <i class="fas fa-history"></i>
                    <span class="history-text">${escapeHtml(item)}</span>
                    <span class="history-delete" data-query="${escapeHtml(item)}"><i class="fas fa-times"></i></span>
                </div>
            `).join('');
            
            document.querySelectorAll('.history-item').forEach(el => {
                el.addEventListener('click', (e) => {
                    if (e.target.closest('.history-delete')) return;
                    const query = el.dataset.query;
                    if (query) {
                        document.getElementById('searchInput').value = query;
                        performSearch(query);
                        hideSearchHistory();
                    }
                });
            });
            document.querySelectorAll('.history-delete').forEach(el => {
                el.addEventListener('click', (e) => {
                    e.stopPropagation();
                    const query = el.dataset.query;
                    if (query) removeFromHistory(query);
                });
            });
        }
        
        function renderSuggestions(suggestions, searchQuery) {
            const suggestionsDiv = document.getElementById('searchSuggestions');
            const suggestionsList = document.getElementById('suggestionsList');
            if (!suggestionsDiv || !suggestionsList) return;
            if (suggestions.length === 0) {
                suggestionsDiv.style.display = 'none';
                return;
            }
            suggestionsDiv.style.display = 'block';
            suggestionsList.innerHTML = suggestions.map(suggestion => {
                const lowerSuggestion = suggestion.toLowerCase();
                const lowerQuery = searchQuery.toLowerCase();
                const index = lowerSuggestion.indexOf(lowerQuery);
                let highlightedText;
                if (index !== -1 && searchQuery.length > 0) {
                    highlightedText = suggestion.substring(0, index) + 
                        `<span class="suggestion-highlight">${suggestion.substring(index, index + searchQuery.length)}</span>` + 
                        suggestion.substring(index + searchQuery.length);
                } else {
                    highlightedText = suggestion;
                }
                return `<div class="suggestion-item" data-suggestion="${escapeHtml(suggestion)}"><i class="fas fa-search"></i><span>${highlightedText}</span></div>`;
            }).join('');
            document.querySelectorAll('.suggestion-item').forEach(el => {
                el.addEventListener('click', () => {
                    const suggestion = el.dataset.suggestion;
                    if (suggestion) {
                        document.getElementById('searchInput').value = suggestion;
                        performSearch(suggestion);
                        hideSearchHistory();
                    }
                });
            });
        }
    
        
        function showSearchHistory() {
            const searchHistoryDiv = document.getElementById('searchHistory');
            const searchInput = document.getElementById('searchInput');
            const suggestionsDiv = document.getElementById('searchSuggestions');
            if (!searchHistoryDiv) return;
            const currentValue = searchInput.value.trim();
            if (currentValue.length > 0) {
                const suggestions = getSuggestions(currentValue, routesData, 5);
                renderSuggestions(suggestions, currentValue);
                suggestionsDiv.style.display = suggestions.length > 0 ? 'block' : 'none';
            } else {
                suggestionsDiv.style.display = 'none';
                renderHistoryList();
            }
            searchHistoryDiv.classList.add('active');
        }
        
        function hideSearchHistory() {
            const searchHistoryDiv = document.getElementById('searchHistory');
            if (searchHistoryDiv) searchHistoryDiv.classList.remove('active');
        }
        
        let currentSearchQuery = '';
        
        function performSearch(query) {
            if (!query || query.trim().length === 0) {
                currentSearchQuery = '';
                filterAndRender();
                return;
            }
            currentSearchQuery = query.trim().toLowerCase();
            if (currentSearchQuery.length >= 2) addToSearchHistory(query.trim());
            filterAndRender();
        }
        
        function matchesSearchQuery(route, searchQuery) {
            if (!searchQuery) return true;
            const lowerQuery = searchQuery.toLowerCase();
            if (route.title && route.title.toLowerCase().includes(lowerQuery)) return true;
            if (route.coords && route.coords.toLowerCase().includes(lowerQuery)) return true;
            if (route.description && route.description.toLowerCase().includes(lowerQuery)) return true;
            if (route.category && route.category.toLowerCase().includes(lowerQuery)) return true;
            return false;
        }

        // ========== МАРШРУТЫ И ГАЛЕРЕЯ ==========
        let routesData = [];
        let currentRoute = null;
        
        let currentGalleryImages = [];
        let currentGalleryIndex = 0;
        let galleryInterval = null;

        function getPrice(route) {
            const basePrices = {
                'Эконом': { 'Полдня': 1500, '1 день': 2500, '2 дня': 4500, '2-3 дня': 5500, '3 дня': 6500, '3-4 дня': 7500 },
                'Средний': { 'Полдня': 3000, '1 день': 5000, '2 дня': 9000, '2-3 дня': 11000, '3 дня': 13000, '3-4 дня': 15000 }
            };
            const budgetType = route.budget;
            const duration = route.duration;
            let price = basePrices[budgetType]?.[duration] || (budgetType === 'Эконом' ? 3000 : 6000);
            if (route.category && route.category.includes('Волонтёрский')) price = 0;
            return price;
        }

        function escapeHtml(str) {
            if (!str) return '';
            return str.replace(/[&<>]/g, function(m) {
                if (m === '&') return '&amp;';
                if (m === '<') return '&lt;';
                if (m === '>') return '&gt;';
                return m;
            });
        }

        function formatPrice(price) {
            if (price === 0) return 'Бесплатно (волонтёрство)';
            return price.toLocaleString() + ' ₽';
        }
        
        function updateGallery() {
            const gallerySlides = document.getElementById('gallerySlides');
            const galleryCounter = document.getElementById('galleryCounter');
            const dotsContainer = document.getElementById('galleryDots');
            
            if (!gallerySlides) return;
            
            gallerySlides.innerHTML = '';
            
            if (currentGalleryImages.length === 0) {
                gallerySlides.innerHTML = `<div class="gallery-slide"><img src="${currentRoute?.image || 'img/routes/default.jpg'}" alt=""></div>`;
                if (galleryCounter) galleryCounter.textContent = `1 / 1`;
                if (dotsContainer) dotsContainer.innerHTML = '';
                return;
            }
            
            currentGalleryImages.forEach((img, idx) => {
                const slide = document.createElement('div');
                slide.className = 'gallery-slide';
                slide.innerHTML = `<img src="${img}" alt="Фото ${idx + 1}" onerror="this.src='img/routes/default.jpg'">`;
                gallerySlides.appendChild(slide);
            });
            
            if (galleryCounter) {
                galleryCounter.textContent = `${currentGalleryIndex + 1} / ${currentGalleryImages.length}`;
            }
            
            if (dotsContainer) {
                dotsContainer.innerHTML = '';
                currentGalleryImages.forEach((_, idx) => {
                    const dot = document.createElement('button');
                    dot.className = 'gallery-dot' + (idx === currentGalleryIndex ? ' active' : '');
                    dot.addEventListener('click', () => goToGallerySlide(idx));
                    dotsContainer.appendChild(dot);
                });
            }
            
            gallerySlides.style.transform = `translateX(-${currentGalleryIndex * 100}%)`;
        }
        
        function goToGallerySlide(index) {
            if (index < 0) index = 0;
            if (index >= currentGalleryImages.length) index = currentGalleryImages.length - 1;
            if (index === currentGalleryIndex) return;
            
            currentGalleryIndex = index;
            const gallerySlides = document.getElementById('gallerySlides');
            const galleryCounter = document.getElementById('galleryCounter');
            const dots = document.querySelectorAll('.gallery-dot');
            
            if (gallerySlides) {
                gallerySlides.style.transform = `translateX(-${currentGalleryIndex * 100}%)`;
            }
            if (galleryCounter && currentGalleryImages.length > 0) {
                galleryCounter.textContent = `${currentGalleryIndex + 1} / ${currentGalleryImages.length}`;
            }
            
            dots.forEach((dot, idx) => {
                if (idx === currentGalleryIndex) dot.classList.add('active');
                else dot.classList.remove('active');
            });
        }
        
        function nextGallerySlide() {
            if (currentGalleryImages.length === 0) return;
            if (currentGalleryIndex < currentGalleryImages.length - 1) {
                goToGallerySlide(currentGalleryIndex + 1);
            } else {
                goToGallerySlide(0);
            }
        }
        
        function prevGallerySlide() {
            if (currentGalleryImages.length === 0) return;
            if (currentGalleryIndex > 0) {
                goToGallerySlide(currentGalleryIndex - 1);
            } else {
                goToGallerySlide(currentGalleryImages.length - 1);
            }
        }
        
        function startGalleryAutoPlay() {
            if (galleryInterval) clearInterval(galleryInterval);
            galleryInterval = setInterval(() => {
                nextGallerySlide();
            }, 5000);
        }
        
        function stopGalleryAutoPlay() {
            if (galleryInterval) {
                clearInterval(galleryInterval);
                galleryInterval = null;
            }
        }

        window.showModal = function(routeId) {
            const route = routesData.find(r => r.id === routeId);
            if (!route) return;
            
            currentRoute = route;
            
            if (route.gallery && route.gallery.length > 0) {
                currentGalleryImages = [...route.gallery];
            } else if (route.image) {
                currentGalleryImages = [route.image];
            } else {
                currentGalleryImages = ['img/routes/default.jpg'];
            }
            currentGalleryIndex = 0;
            
            const modal = document.getElementById('routeModal');
            document.getElementById('modalTitle').textContent = route.title;
            document.getElementById('modalPrice').textContent = formatPrice(route.price);
            document.getElementById('modalDuration').textContent = route.duration;
            document.getElementById('modalType').textContent = route.type;
            document.getElementById('modalCoords').textContent = route.coords;
            document.getElementById('modalKids').textContent = route.kids ? '✅ Можно с детьми' : '❌ Без детей';
            document.getElementById('modalPets').textContent = route.pets ? '✅ Можно с животными' : '❌ Без животных';
            document.getElementById('modalBudget').textContent = route.budget + ' (' + formatPrice(route.price) + ')';
            document.getElementById('modalDescription').textContent = route.description;
            
            const categoriesContainer = document.getElementById('modalCategories');
            categoriesContainer.innerHTML = '';
            if (route.category) {
                const categories = route.category.split(', ');
                categories.forEach(cat => {
                    const span = document.createElement('span');
                    span.className = 'modal-category' + (cat === 'Волонтёрский' ? ' volunteer' : '');
                    span.textContent = cat;
                    categoriesContainer.appendChild(span);
                });
            }
            
            updateGallery();
            
            modal.classList.add('active');
            document.body.style.overflow = 'hidden';
            
            startGalleryAutoPlay();
        };

        window.closeModal = function() {
            const modal = document.getElementById('routeModal');
            modal.classList.remove('active');
            document.body.style.overflow = '';
            stopGalleryAutoPlay();
        };

        window.bookRoute = function() {
            <?php if (!isset($_SESSION['user_id'])): ?>
                alert('Пожалуйста, войдите в аккаунт для бронирования');
                closeModal();
                openAuthModal('login');
                return;
            <?php else: ?>
                if (currentRoute) {
                    const routeSelect = document.getElementById('routeName');
                    if (routeSelect) {
                        for (let i = 0; i < routeSelect.options.length; i++) {
                            if (routeSelect.options[i].text === currentRoute.title) {
                                routeSelect.selectedIndex = i;
                                break;
                            }
                        }
                    }
                    closeModal();
                    document.getElementById('bookingForm').scrollIntoView({ behavior: 'smooth' });
                }
            <?php endif; ?>
        };

        function filterAndRender() {
            const container = document.getElementById('t2-grid');
            const countSpan = document.getElementById('t2-count');
            if (!routesData.length) return;
            let filtered = [...routesData];
            if (currentSearchQuery) filtered = filtered.filter(route => matchesSearchQuery(route, currentSearchQuery));
            
            const durationVal = document.getElementById('t2-filter-duration')?.value || 'all';
            const typeVal = document.getElementById('t2-filter-type')?.value || 'all';
            const categoryVal = document.getElementById('t2-filter-category')?.value || 'all';
            const kidsVal = document.getElementById('t2-filter-kids')?.value || 'all';
            const petsVal = document.getElementById('t2-filter-pets')?.value || 'all';
            const budgetVal = document.getElementById('t2-filter-budget')?.value || 'all';

            if (durationVal !== 'all') {
                filtered = filtered.filter(route => {
                    const dur = route.duration;
                    if (durationVal === '1') return dur === '1 день' || dur === 'Полдня';
                    if (durationVal === '2') return dur === '2 дня' || dur === '2-3 дня';
                    if (durationVal === '3') return dur === '3 дня' || dur === '3-4 дня';
                    return false;
                });
            }
            if (typeVal !== 'all') filtered = filtered.filter(route => route.type && route.type.includes(typeVal));
            if (categoryVal !== 'all') filtered = filtered.filter(route => route.category && route.category.includes(categoryVal));
            if (kidsVal !== 'all') filtered = filtered.filter(route => route.kids === (kidsVal === 'true'));
            if (petsVal !== 'all') filtered = filtered.filter(route => route.pets === (petsVal === 'true'));
            if (budgetVal !== 'all') filtered = filtered.filter(route => route.budget === budgetVal);
            
            filtered.sort((a, b) => {
                const aIsVol = a.category && a.category.includes('Волонтёрский');
                const bIsVol = b.category && b.category.includes('Волонтёрский');
                if (aIsVol && !bIsVol) return -1;
                if (!aIsVol && bIsVol) return 1;
                return a.id - b.id;
            });
            
            if (countSpan) countSpan.textContent = filtered.length;
            if (filtered.length === 0) {
                container.innerHTML = `<div class="t2-no-results"><i class="fas fa-map-marked-alt"></i><br><strong>Ничего не найдено</strong><br><span style="font-size: 14px;">Попробуйте изменить параметры поиска</span></div>`;
                return;
            }
            
            container.innerHTML = filtered.map(route => {
                const budgetClass = route.budget === 'Эконом' ? 't2-badge-budget-econom' : 't2-badge-budget-medium';
                const categories = route.category ? route.category.split(', ').map(cat => cat === 'Волонтёрский' ? '<span class="t2-badge t2-badge-volunteer"><i class="fas fa-heart"></i> Волонтёрский</span>' : `<span class="t2-badge">${escapeHtml(cat)}</span>`).join('') : '';
                const imagePath = route.image ? route.image : 'img/routes/default.jpg';
                const priceDisplay = route.price === 0 ? 'Бесплатно' : route.price.toLocaleString() + ' ₽';
                return `
                    <div class="t2-card">
                        <img class="t2-card-img" src="${escapeHtml(imagePath)}" alt="${escapeHtml(route.title)}" onerror="this.src='img/routes/default.jpg'">
                        <div class="t2-card-header">
                            <h3 class="t2-card-title">${escapeHtml(route.title)}</h3>
                            <div class="t2-card-badges">
                                <span class="t2-badge ${budgetClass}">${route.budget} (${priceDisplay})</span>
                                ${categories}
                            </div>
                        </div>
                        <div class="t2-card-body">
                            <p class="t2-card-desc">${escapeHtml(route.description.substring(0, 100))}...</p>
                            <div class="t2-card-meta">
                                <span class="t2-meta-item"><i class="fas fa-clock"></i> ${route.duration}</span>
                                <span class="t2-meta-item"><i class="fas fa-car"></i> ${route.type}</span>
                                ${route.kids ? '<span class="t2-meta-item"><i class="fas fa-child"></i> С детьми</span>' : '<span class="t2-meta-item"><i class="fas fa-user-slash"></i> Без детей</span>'}
                                ${route.pets ? '<span class="t2-meta-item"><i class="fas fa-paw"></i> С питомцами</span>' : '<span class="t2-meta-item"><i class="fas fa-ban"></i> Без животных</span>'}
                            </div>
                        </div>
                        <div class="t2-card-footer">
                            <div class="t2-coords"><i class="fas fa-map-marker-alt"></i> ${escapeHtml(route.coords)}</div>
                            <button class="t2-btn" onclick="showModal(${route.id})"><i class="fas fa-info-circle"></i> Подробнее</button>
                        </div>
                    </div>
                `;
            }).join('');
        }

        async function loadData() {
            const container = document.getElementById('t2-grid');
            try {
                const response = await fetch('routes.json');
                if (!response.ok) throw new Error('HTTP ' + response.status);
                let data = await response.json();
                routesData = data.map(route => ({ ...route, price: getPrice(route) }));
                const routeSelect = document.getElementById('routeName');
                if (routeSelect) {
                    routesData.forEach(route => {
                        const option = document.createElement('option');
                        option.value = route.title;
                        option.textContent = route.title;
                        routeSelect.appendChild(option);
                    });
                }
                filterAndRender();
            } catch (error) {
                console.error('Ошибка:', error);
                if (container) container.innerHTML = '<div class="t2-no-results"><i class="fas fa-exclamation-triangle"></i><br>Ошибка загрузки маршрутов</div>';
            }
        }

        // ========== ОТЗЫВЫ С ПЛАВНОЙ СМЕНОЙ ==========
        function renderStars(rating) {
            let html = "";
            for (let i = 1; i <= 5; i++) html += i <= rating ? '<span class="star filled">★</span>' : '<span class="star">★</span>';
            return html;
        }
        
        async function loadReviews() {
            try {
                const response = await fetch("reviews.json");
                if (!response.ok) throw new Error('HTTP ' + response.status);
                return await response.json();
            } catch(e) { return []; }
        }
        
        function getRandomItems(arr, count) {
            if (!arr.length) return [];
            const shuffled = [...arr].sort(() => Math.random() - 0.5);
            return shuffled.slice(0, count);
        }
        
        function renderCards(container, reviews, isInitial = false) {
            if (!container) return;
            
            if (!isInitial) {
                // Плавное исчезновение старых карточек
                const oldCards = container.querySelectorAll(".review-card");
                oldCards.forEach(card => card.classList.add("fade-out"));
            }
            
            setTimeout(() => {
                container.innerHTML = "";
                reviews.forEach((review, index) => {
                    const card = document.createElement("div");
                    card.className = "review-card";
                    card.style.animationDelay = `${index * 0.1}s`;
                    card.innerHTML = `
                        <div class="review-author">${escapeHtml(review.author)}</div>
                        <div class="review-rating">Рейтинг: <span class="stars">${renderStars(review.rating)}</span></div>
                        <div class="review-text">${escapeHtml(review.text)}</div>
                    `;
                    container.appendChild(card);
                    
                    // Плавное появление новой карточки
                    if (!isInitial) {
                        card.style.opacity = '0';
                        card.style.transform = 'translateY(20px)';
                        setTimeout(() => {
                            card.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                            card.style.opacity = '1';
                            card.style.transform = 'translateY(0)';
                        }, 50);
                    }
                });
            }, isInitial ? 0 : 400);
        }


        // ========== КОНФИГУРАТОР МАРШРУТОВ (РАБОТАЕТ С routes.json) ==========
let currentFilteredRoutes = [];
let currentRandomIndex = 0;

// Функция фильтрации маршрутов по критериям конфигуратора
function filterRoutesByConfig(routes) {
    const duration = document.getElementById('config-duration').value;
    const type = document.getElementById('config-type').value;
    const category = document.getElementById('config-category').value;
    const budget = document.getElementById('config-budget').value;
    const kids = document.getElementById('config-kids').value;
    const pets = document.getElementById('config-pets').value;
    
    return routes.filter(route => {
        // Фильтр по длительности
        if (duration !== 'all') {
            const dur = route.duration;
            if (duration === '1' && !(dur === '1 день' || dur === 'Полдня')) return false;
            if (duration === '2' && !(dur === '2 дня' || dur === '2-3 дня')) return false;
            if (duration === '3' && !(dur === '3 дня' || dur === '3-4 дня')) return false;
        }
        
        // Фильтр по типу
        if (type !== 'all' && route.type && !route.type.includes(type)) return false;
        
        // Фильтр по категории
        if (category !== 'all' && route.category && !route.category.includes(category)) return false;
        
        // Фильтр по бюджету (только сравнение строк, без цен)
        if (budget !== 'all' && route.budget !== budget) return false;
        
        // Фильтр по детям
        if (kids !== 'all' && route.kids !== (kids === 'true')) return false;
        
        // Фильтр по животным
        if (pets !== 'all' && route.pets !== (pets === 'true')) return false;
        
        return true;
    });
}

    // Отображение случайного маршрута из отфильтрованного списка
    function displayRandomRoute() {
        const resultDiv = document.getElementById('configResult');
        const resultCard = document.getElementById('configResultCard');
        const noResultsDiv = document.getElementById('configNoResults');
        const randomBtn = document.getElementById('configRandomBtn');
        
        if (!currentFilteredRoutes || currentFilteredRoutes.length === 0) {
            resultDiv.style.display = 'block';
            if (resultCard) resultCard.style.display = 'none';
            if (noResultsDiv) noResultsDiv.style.display = 'block';
            if (randomBtn) randomBtn.style.display = 'none';
            return;
        }
        
        // Выбираем случайный маршрут
        currentRandomIndex = Math.floor(Math.random() * currentFilteredRoutes.length);
        const route = currentFilteredRoutes[currentRandomIndex];
        
        // Получаем основное изображение (если gallery есть - берем первое, иначе image)
        let mainImage = route.image;
        if (route.gallery && route.gallery.length > 0) {
            mainImage = route.gallery[0];
        }
        
        // Определяем класс бюджета для бейджа
        const budgetClass = route.budget === 'Эконом' ? 'config-detail-budget-econom' : 'config-detail-budget-medium';
        
        // Формируем HTML карточки (без цены)
        resultCard.innerHTML = `
            <img class="config-result-img" src="${mainImage || 'img/routes/default.jpg'}" alt="${escapeHtml(route.title)}" onerror="this.src='img/routes/default.jpg'">
            <div class="config-result-info">
                <h3 class="config-result-title"><i class="fas fa-map-marked-alt"></i> ${escapeHtml(route.title)}</h3>
                <p class="config-result-desc">${escapeHtml(route.description)}</p>
                <div class="config-result-details">
                    <span class="config-detail"><i class="fas fa-clock"></i> ${route.duration}</span>
                    <span class="config-detail"><i class="fas fa-car"></i> ${route.type}</span>
                    <span class="config-detail"><i class="fas fa-map-marker-alt"></i> ${escapeHtml(route.coords)}</span>
                    <span class="config-detail ${budgetClass}" style="background: ${route.budget === 'Эконом' ? '#a7fc00' : '#00BFFF'}">💰 ${route.budget}</span>
                    ${route.kids ? '<span class="config-detail"><i class="fas fa-child"></i> С детьми</span>' : '<span class="config-detail"><i class="fas fa-user-slash"></i> Без детей</span>'}
                    ${route.pets ? '<span class="config-detail"><i class="fas fa-paw"></i> С питомцами</span>' : '<span class="config-detail"><i class="fas fa-ban"></i> Без животных</span>'}
                </div>
                <div>
                    <button class="config-result-book" onclick="bookConfigRoute(${route.id})"><i class="fas fa-calendar-check"></i> Забронировать</button>
                </div>
            </div>
        `;
        
        resultDiv.style.display = 'block';
        if (resultCard) resultCard.style.display = 'flex';
        if (noResultsDiv) noResultsDiv.style.display = 'none';
        if (randomBtn) randomBtn.style.display = currentFilteredRoutes.length > 1 ? 'flex' : 'none';
    }

    // Функция для бронирования из конфигуратора
    window.bookConfigRoute = function(routeId) {
        const route = routesData.find(r => r.id === routeId);
        if (!route) return;
        
        <?php if (!isset($_SESSION['user_id'])): ?>
            alert('Пожалуйста, войдите в аккаунт для бронирования');
            openAuthModal('login');
            return;
        <?php else: ?>
            const routeSelect = document.getElementById('routeName');
            if (routeSelect) {
                for (let i = 0; i < routeSelect.options.length; i++) {
                    if (routeSelect.options[i].text === route.title) {
                        routeSelect.selectedIndex = i;
                        break;
                    }
                }
            }
            document.getElementById('bookingForm').scrollIntoView({ behavior: 'smooth' });
            // Небольшая подсветка формы
            const form = document.getElementById('bookingForm');
            form.style.transition = 'box-shadow 0.3s';
            form.style.boxShadow = '0 0 0 3px #FF00A0';
            setTimeout(() => {
                form.style.boxShadow = '';
            }, 1500);
        <?php endif; ?>
    };

    // Основная функция поиска (использует routesData из основного скрипта)
    function findRoutes() {
        if (!routesData || routesData.length === 0) {
            console.warn('routesData не загружен');
            return;
        }
        
        currentFilteredRoutes = filterRoutesByConfig(routesData);
        displayRandomRoute();
    }

    // Сброс фильтров конфигуратора
    function resetConfigFilters() {
        document.getElementById('config-duration').value = 'all';
        document.getElementById('config-type').value = 'all';
        document.getElementById('config-category').value = 'all';
        document.getElementById('config-budget').value = 'all';
        document.getElementById('config-kids').value = 'all';
        document.getElementById('config-pets').value = 'all';
        
        // Скрываем результат
        const resultDiv = document.getElementById('configResult');
        if (resultDiv) resultDiv.style.display = 'none';
        
        currentFilteredRoutes = [];
    }

    // Инициализация конфигуратора
    function initConfigurator() {
        const findBtn = document.getElementById('configFindBtn');
        const randomBtn = document.getElementById('configRandomBtn');
        const resetBtn = document.getElementById('configResetBtn');
        
        if (findBtn) {
            findBtn.addEventListener('click', findRoutes);
        }
        
        if (randomBtn) {
            randomBtn.addEventListener('click', () => {
                if (currentFilteredRoutes && currentFilteredRoutes.length > 1) {
                    // Выбираем другой случайный маршрут (не тот же самый)
                    let newIndex = currentRandomIndex;
                    while (newIndex === currentRandomIndex && currentFilteredRoutes.length > 1) {
                        newIndex = Math.floor(Math.random() * currentFilteredRoutes.length);
                    }
                    currentRandomIndex = newIndex;
                    const route = currentFilteredRoutes[currentRandomIndex];
                    
                    // Получаем основное изображение
                    let mainImage = route.image;
                    if (route.gallery && route.gallery.length > 0) {
                        mainImage = route.gallery[0];
                    }
                    
                    const budgetClass = route.budget === 'Эконом' ? 'config-detail-budget-econom' : 'config-detail-budget-medium';
                    const resultCard = document.getElementById('configResultCard');
                    
                    resultCard.innerHTML = `
                        <img class="config-result-img" src="${mainImage || 'img/routes/default.jpg'}" alt="${escapeHtml(route.title)}" onerror="this.src='img/routes/default.jpg'">
                        <div class="config-result-info">
                            <h3 class="config-result-title"><i class="fas fa-map-marked-alt"></i> ${escapeHtml(route.title)}</h3>
                            <p class="config-result-desc">${escapeHtml(route.description)}</p>
                            <div class="config-result-details">
                                <span class="config-detail"><i class="fas fa-clock"></i> ${route.duration}</span>
                                <span class="config-detail"><i class="fas fa-car"></i> ${route.type}</span>
                                <span class="config-detail"><i class="fas fa-map-marker-alt"></i> ${escapeHtml(route.coords)}</span>
                                <span class="config-detail ${budgetClass}" style="background: ${route.budget === 'Эконом' ? '#a7fc00' : '#00BFFF'}">💰 ${route.budget}</span>
                                ${route.kids ? '<span class="config-detail"><i class="fas fa-child"></i> С детьми</span>' : '<span class="config-detail"><i class="fas fa-user-slash"></i> Без детей</span>'}
                                ${route.pets ? '<span class="config-detail"><i class="fas fa-paw"></i> С питомцами</span>' : '<span class="config-detail"><i class="fas fa-ban"></i> Без животных</span>'}
                            </div>
                            <div>
                                <button class="config-result-book" onclick="bookConfigRoute(${route.id})"><i class="fas fa-calendar-check"></i> Забронировать</button>
                            </div>
                        </div>
                    `;
                }
            });
        }
        
        if (resetBtn) {
            resetBtn.addEventListener('click', resetConfigFilters);
        }
    }

    // Ждем загрузки routesData и запускаем конфигуратор
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => {
            // Ждем загрузки данных (таймаут для уверенности)
            setTimeout(() => {
                if (typeof routesData !== 'undefined' && routesData.length) {
                    initConfigurator();
                } else {
                    // Повторная попытка через интервал
                    const checkInterval = setInterval(() => {
                        if (typeof routesData !== 'undefined' && routesData.length) {
                            clearInterval(checkInterval);
                            initConfigurator();
                        }
                    }, 500);
                    setTimeout(() => clearInterval(checkInterval), 10000);
                }
            }, 500);
        });
    } else {
        setTimeout(() => {
            if (typeof routesData !== 'undefined' && routesData.length) {
                initConfigurator();
            }
        }, 500);
    }
        // ========== ОТПРАВКА БРОНИРОВАНИЯ ==========
        window.submitBooking = async function(event) {
            event.preventDefault();
            
            <?php if (!isset($_SESSION['user_id'])): ?>
                alert('Пожалуйста, войдите в аккаунт для бронирования');
                openAuthModal('login');
                return;
            <?php endif; ?>
            
            const fullName = document.getElementById('fullName').value.trim();
            const phone = document.getElementById('phone').value.trim();
            const email = document.getElementById('email').value.trim();
            const routeName = document.getElementById('routeName').value;
            const travelDate = document.getElementById('date').value;
            const passengers = document.getElementById('passengers').value;
            const comment = document.getElementById('comment').value;
            
            if (!fullName || !phone || !email || !routeName || !travelDate) {
                document.getElementById('status').innerHTML = '<div class="udmurtError">❌ Заполните все обязательные поля</div>';
                return;
            }
            
            const minDateStr = '2026-04-12';
            if (travelDate < minDateStr) {
                document.getElementById('status').innerHTML = '<div class="udmurtError">❌ ОШИБКА! Приём заявок только на даты после 11 апреля 2026 года. Вы выбрали: ' + travelDate + '</div>';
                return;
            }
            
            const dateRegex = /^\d{4}-\d{2}-\d{2}$/;
            if (!dateRegex.test(travelDate)) {
                document.getElementById('status').innerHTML = '<div class="udmurtError">❌ Неверный формат даты</div>';
                return;
            }
            
            const phoneRegex = /^[\+\d][\d\(\)\-\s]{9,20}$/;
            if (!phoneRegex.test(phone)) {
                document.getElementById('status').innerHTML = '<div class="udmurtError">❌ Введите корректный номер телефона</div>';
                return;
            }
            
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                document.getElementById('status').innerHTML = '<div class="udmurtError">❌ Введите корректный email адрес</div>';
                return;
            }
            
            const passengersNum = parseInt(passengers);
            if (isNaN(passengersNum) || passengersNum < 1 || passengersNum > 50) {
                document.getElementById('status').innerHTML = '<div class="udmurtError">❌ Количество пассажиров должно быть от 1 до 50</div>';
                return;
            }
            
            document.getElementById('status').innerHTML = '<div style="color: #ff3495;"><i class="fas fa-spinner fa-pulse"></i> Отправка...</div>';
            
            try {
                const response = await fetch('api.php?action=booking', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        full_name: fullName,
                        phone: phone,
                        email: email,
                        route_name: routeName,
                        travel_date: travelDate,
                        passengers: passengersNum,
                        comment: comment
                    })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    document.getElementById('status').innerHTML = '<div class="udmurtSuccess">✅ ' + data.message + '</div>';
                    document.getElementById('bookingForm').reset();
                    setTimeout(() => {
                        document.getElementById('status').innerHTML = '';
                    }, 3000);
                } else {
                    document.getElementById('status').innerHTML = '<div class="udmurtError">❌ ' + data.message + '</div>';
                }
            } catch (error) {
                console.error('Error:', error);
                document.getElementById('status').innerHTML = '<div class="udmurtError">❌ Ошибка соединения с сервером</div>';
            }
        };


// ========== ОТПРАВКА ОТЗЫВА ==========
window.submitReview = async function(event) {
    event.preventDefault();
    
    <?php if (!isset($_SESSION['user_id'])): ?>
        alert('Пожалуйста, войдите в аккаунт, чтобы оставить отзыв');
        openAuthModal('login');
        return;
    <?php endif; ?>
    
    const author = document.getElementById('reviewAuthor').value.trim();
    const route = document.getElementById('reviewRoute').value;
    const rating = document.getElementById('reviewRating').value;
    const travelDate = document.getElementById('reviewDate').value;
    const text = document.getElementById('reviewText').value.trim();
    
    // Валидация
    if (!author) {
        alert('Пожалуйста, укажите ваше имя');
        return;
    }
    
    if (!route) {
        alert('Пожалуйста, выберите маршрут');
        return;
    }
    
    if (!travelDate) {
        alert('Пожалуйста, укажите дату поездки');
        return;
    }
    
    if (!text) {
        alert('Пожалуйста, напишите ваш отзыв');
        return;
    }
    
    if (text.length < 10) {
        alert('Отзыв должен содержать минимум 10 символов');
        return;
    }
    
    // Анимация кнопки
    const submitBtn = document.getElementById('reviewSubmitBtn');
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-pulse"></i> Отправка...';
    submitBtn.disabled = true;
    
    try {
        const response = await fetch('api.php?action=add_review', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                author: author,
                route: route,
                rating: parseInt(rating),
                travel_date: travelDate,
                text: text
            })
        });
        
        const data = await response.json();
        
        if (data.success) {
            alert('✅ ' + data.message);
            resetReviewForm();
            
            // Обновляем отзывы на странице
            const allReviews = await loadReviews();
            const reviewsContainer = document.getElementById("reviews-container");
            if (reviewsContainer && allReviews.length) {
                renderCards(reviewsContainer, getRandomItems(allReviews, 3), false);
            }
        } else {
            alert('❌ ' + data.message);
        }
    } catch (error) {
        console.error('Error:', error);
        alert('❌ Ошибка соединения с сервером');
    } finally {
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    }
};

// ========== СБРОС ФОРМЫ ОТЗЫВА ==========
function resetReviewForm() {
    document.getElementById('reviewForm').reset();
    document.getElementById('reviewRating').value = '5';
    
    // Сброс звёзд
    const stars = document.querySelectorAll('.rating-star');
    stars.forEach((star, index) => {
        if (index < 5) {
            star.classList.add('active');
        } else {
            star.classList.remove('active');
        }
    });
}

// ========== ЗАГРУЗКА ОТЗЫВОВ ИЗ БД ==========
async function loadReviews() {
    try {
        const response = await fetch('api.php?action=get_reviews');
        if (!response.ok) throw new Error('HTTP ' + response.status);
        const data = await response.json();
        if (Array.isArray(data)) {
            return data.map(review => ({
                id: review.id,
                author: review.author,
                route: review.route_name,
                rating: review.rating,
                travel_date: review.travel_date,
                text: review.text,
                created_at: review.created_at
            }));
        }
        return [];
    } catch(e) {
        console.error('Ошибка загрузки отзывов:', e);
        return [];
    }
}



        // ========== ИНИЦИАЛИЗАЦИЯ ==========
        document.addEventListener("DOMContentLoaded", async () => {
            await loadData();
            
            const filters = ['t2-filter-duration', 't2-filter-type', 't2-filter-category', 't2-filter-kids', 't2-filter-pets', 't2-filter-budget'];
            filters.forEach(id => { const el = document.getElementById(id); if (el) el.addEventListener('change', filterAndRender); });
            
            const resetBtn = document.getElementById('t2-reset-filters');
            if (resetBtn) {
                resetBtn.addEventListener('click', () => {
                    filters.forEach(id => { const el = document.getElementById(id); if (el) el.value = 'all'; });
                    const searchInput = document.getElementById('searchInput');
                    if (searchInput) { searchInput.value = ''; currentSearchQuery = ''; }
                    filterAndRender();
                });
            }
            
            const galleryPrevBtn = document.getElementById('galleryPrevBtn');
            const galleryNextBtn = document.getElementById('galleryNextBtn');
            const galleryContainer = document.querySelector('.modal-gallery');
            
            if (galleryPrevBtn) {
                galleryPrevBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    prevGallerySlide();
                    stopGalleryAutoPlay();
                    startGalleryAutoPlay();
                });
            }
            if (galleryNextBtn) {
                galleryNextBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    nextGallerySlide();
                    stopGalleryAutoPlay();
                    startGalleryAutoPlay();
                });
            }
            if (galleryContainer) {
                galleryContainer.addEventListener('mouseenter', stopGalleryAutoPlay);
                galleryContainer.addEventListener('mouseleave', startGalleryAutoPlay);
            }
            
            const searchInput = document.getElementById('searchInput');
            const searchClearBtn = document.getElementById('searchClearBtn');
            const clearHistoryBtn = document.getElementById('clearHistoryBtn');
            
            if (searchInput) {
                let searchTimeout;
                searchInput.addEventListener('input', (e) => {
                    const clearBtn = document.getElementById('searchClearBtn');
                    if (clearBtn) clearBtn.style.display = e.target.value.length > 0 ? 'block' : 'none';
                    clearTimeout(searchTimeout);
                    searchTimeout = setTimeout(() => {
                        performSearch(e.target.value);
                        if (e.target.value.length > 0) showSearchHistory();
                        else hideSearchHistory();
                    }, 300);
                });
                searchInput.addEventListener('focus', () => showSearchHistory());
                searchInput.addEventListener('keypress', (e) => { if (e.key === 'Enter') hideSearchHistory(); });
            }
            if (searchClearBtn) {
                searchClearBtn.addEventListener('click', () => {
                    if (searchInput) {
                        searchInput.value = '';
                        currentSearchQuery = '';
                        filterAndRender();
                        searchClearBtn.style.display = 'none';
                        hideSearchHistory();
                        searchInput.focus();
                    }
                });
            }
            if (clearHistoryBtn) clearHistoryBtn.addEventListener('click', () => clearSearchHistory());
            document.addEventListener('click', (e) => { const searchContainer = document.querySelector('.search-container'); if (searchContainer && !searchContainer.contains(e.target)) hideSearchHistory(); });
            
            const reviewsContainer = document.getElementById("reviews-container");
            if (reviewsContainer) {
                const allReviews = await loadReviews();
                if (allReviews.length) {
                    // Первоначальный рендер без анимации исчезновения
                    renderCards(reviewsContainer, getRandomItems(allReviews, 3), true);
                    // Плавная смена каждые 5 секунд
                    setInterval(() => { 
                        renderCards(reviewsContainer, getRandomItems(allReviews, 3), false);
                    }, 5000);
                }
            }
            
            document.querySelector('.next')?.addEventListener('click', nextSlide);
            document.querySelector('.prev')?.addEventListener('click', prevSlide);
            document.getElementById('routeModal')?.addEventListener('click', function(e) { if (e.target === this) closeModal(); });
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    if (document.getElementById('routeModal')?.classList.contains('active')) closeModal();
                    if (document.getElementById('authModal')?.classList.contains('active')) closeAuthModal();
                    hideSearchHistory();
                }
            });
        });
    </script>
</body>
</html>