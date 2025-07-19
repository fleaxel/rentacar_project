document.addEventListener('DOMContentLoaded', () => {
    const carRows = document.querySelectorAll('.car-row');

    carRows.forEach(row => {
        row.addEventListener('click', () => {
            const nextRow = row.nextElementSibling;
            if (nextRow && nextRow.classList.contains('details')) {
                nextRow.style.display = nextRow.style.display === 'none' ? 'table-row' : 'none';
            }
        });
    });
});
