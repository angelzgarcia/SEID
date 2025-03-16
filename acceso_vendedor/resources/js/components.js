

document.addEventListener('DOMContentLoaded', () => {
    //  <!-- R E S I Z I N G    S I D E B A R -->
    const minimizeBtns = document.querySelectorAll('.minimize-btn');
    const sidebarFull = document.querySelector('.sidebar-full');
    const sidebarMinimized = document.querySelector('.sidebar-minimized');

    minimizeBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            if (sidebarMinimized.classList.contains('minimized')) {
                document.documentElement.style.setProperty('--sidebar-width', '70px');
                sidebarMinimized.classList.remove('minimized');
                sidebarFull.classList.remove('visible');
            } else {
                document.documentElement.style.setProperty('--sidebar-width', '250px');
                sidebarFull.classList.add('visible');
                sidebarMinimized.classList.add('minimized');
            }
        });
    });

    const sidebarContainer = document.querySelector('.sidebar-content');
    //  <!-- O P E N   S I D E B A R -->
    const sidebarOpenButton = document.getElementById('sidebar-open-button') || '';
    sidebarOpenButton.addEventListener('click', () => sidebarContainer.style.display = 'flex');

    //  <!-- C L O S E   S I D E B A R -->
    const sidebarCloseButtons = document.querySelectorAll('.sidebar-close-button') || '';
    sidebarCloseButtons.forEach(b => b.addEventListener('click', () => sidebarContainer.style.display = 'none'));

});
