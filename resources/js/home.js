document.addEventListener('DOMContentLoaded', function () {
    const filterButton = document.getElementById('filterButton');
    const filterMenu = document.getElementById('filterMenu');

    filterButton.addEventListener('click', () => {
        // Toggle the visibility of the dropdown menu
        filterMenu.classList.toggle('hidden');
    });

    // Optional: Close dropdown if clicked outside
    document.addEventListener('click', function (e) {
        if (!filterButton.contains(e.target) && !filterMenu.contains(e.target)) {
            filterMenu.classList.add('hidden');
        }
    });
});
