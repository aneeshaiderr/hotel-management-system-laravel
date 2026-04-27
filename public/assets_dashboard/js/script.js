document.addEventListener('DOMContentLoaded', function () {
    const sidebar = document.getElementById('sidebar');
    const content = document.querySelector('.main-content');
    const navbar = document.querySelector('.navbar');
    const overlay = document.querySelector('.overlay');
    const sidebarToggle = document.querySelector('.sidebar-toggle');
    const fsBtn = document.querySelector('.js-fullscreen');

    if (sidebarToggle && sidebar && content && navbar && overlay) {
        sidebarToggle.addEventListener('click', function () {
            sidebar.classList.toggle('active');
            content.classList.toggle('active');
            navbar.classList.toggle('active');

            if (window.innerWidth <= 768) {
                overlay.classList.toggle('active');
            }
        });

        overlay.addEventListener('click', function () {
            sidebar.classList.remove('active');
            content.classList.remove('active');
            navbar.classList.remove('active');
            overlay.classList.remove('active');
        });
    }

    if (fsBtn) {
        fsBtn.addEventListener('click', function (event) {
            event.preventDefault();
            if (!document.fullscreenElement) {
                document.documentElement.requestFullscreen();
                fsBtn.innerHTML = '<i class="fas fa-compress"></i>';
            } else if (document.exitFullscreen) {
                document.exitFullscreen();
                fsBtn.innerHTML = '<i class="fas fa-expand"></i>';
            }
        });
    }

    if (window.jQuery) {
        const $filterContainer = jQuery('.filter-container');
        if ($filterContainer.length > 0) {
            $filterContainer.html(
                '<div class="dropdown d-inline-block ms-2">' +
                '<button class="btn btn-outline-secondary dropdown-toggle" type="button" id="filterMenu" data-bs-toggle="dropdown" aria-expanded="false">' +
                '<i class="bi bi-sliders"></i></button>' +
                '<ul class="dropdown-menu" aria-labelledby="filterMenu">' +
                '<li><a class="dropdown-item filter-option" href="#" data-value="">All</a></li>' +
                '<li><a class="dropdown-item filter-option" href="#" data-value="available">Available</a></li>' +
                '<li><a class="dropdown-item filter-option" href="#" data-value="occupied">Occupied</a></li>' +
                '<li><a class="dropdown-item filter-option" href="#" data-value="maintenance">Maintenance</a></li>' +
                '</ul></div>'
            );
        }
    }
});
