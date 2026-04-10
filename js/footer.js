    // Текст, которым хотим поделиться (можно менять)
    const SHARE_TEXT = 'Я прошёл испытание и набрал 1240 очков! 🔥 А ты сможешь лучше?';
    // Ссылка на текущую страницу (или можно указать конкретную)
    const PAGE_URL = window.location.href;

    // Функция открытия окна соцсети
    function shareToVK() {
        const vkUrl = `https://vk.com/share.php?url=${encodeURIComponent(PAGE_URL)}&title=${encodeURIComponent('Мой результат')}&description=${encodeURIComponent(SHARE_TEXT)}`;
        window.open(vkUrl, '_blank', 'width=600,height=450');
        showToast('Открыть ВКонтакте');
    }

    function shareToOK() {
        const okUrl = `https://connect.ok.ru/offer?url=${encodeURIComponent(PAGE_URL)}&title=${encodeURIComponent('Мой результат')}&description=${encodeURIComponent(SHARE_TEXT)}`;
        window.open(okUrl, '_blank', 'width=600,height=450');
        showToast('Открыть Одноклассники');
    }

    document.getElementById('shareVk').addEventListener('click', shareToVK);
    document.getElementById('shareOk').addEventListener('click', shareToOK);