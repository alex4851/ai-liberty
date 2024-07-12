function toggleFavorite(div) {
    const icon = div.querySelector('.favorite-icon');
    if (icon.src.includes('not_favorite.png')) {
        icon.src = 'img/favorite.png';
    } else {
        icon.src = 'img/not_favorite.png';
    }
}