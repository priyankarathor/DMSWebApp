document.addEventListener('DOMContentLoaded', () => {
    
    const amountRowsContainer = document.getElementById('amount-rows');
    const addRowButton = document.getElementById('add-row');

    function cloneRow(row) {
        const newRow = row.cloneNode(true);
        const inputs = newRow.querySelectorAll('input, select, textarea');
        inputs.forEach(input => input.value = '');

        const removeButton = newRow.querySelector('.remove-row');
        if (removeButton) {
            removeButton.style.display = 'inline-block'; // Show 'Remove' button
        }
        return newRow;
    }

    // Add event listener to the 'Add Row' button
    addRowButton.addEventListener('click', () => {
        const firstRow = amountRowsContainer.querySelector('.amount-row');
        if (firstRow) {
            const newRow = cloneRow(firstRow);
            amountRowsContainer.appendChild(newRow);

            // Ensure the 'Remove' button is hidden only for the first row
            const firstRemoveButton = firstRow.querySelector('.remove-row');
            if (firstRemoveButton) {
                firstRemoveButton.style.display = 'none'; // Hide 'Remove' button on first row
            }
        }
    });

    // Add event delegation to handle 'Remove' button clicks
    amountRowsContainer.addEventListener('click', (event) => {
        if (event.target.classList.contains('remove-row')) {
            const row = event.target.closest('.amount-row');
            if (row && amountRowsContainer.children.length > 1) {
                row.remove();
            }
        }

        // Ensure the 'Remove' button is hidden for the first row after a row is removed
        const firstRow = amountRowsContainer.querySelector('.amount-row');
        if (firstRow) {
            const firstRemoveButton = firstRow.querySelector('.remove-row');
            if (firstRemoveButton) {
                firstRemoveButton.style.display = 'none'; // Always hide 'Remove' button on the first row
            }
        }
    });

    // Hide 'Remove' button for the first row on page load
    const firstRemoveButton = amountRowsContainer.querySelector('.amount-row .remove-row');
    if (firstRemoveButton) {
        firstRemoveButton.style.display = 'none'; // Hide 'Remove' button on the first row initially
    }
});


//pagination
// let current_page = 1;
// let records_per_page = 5;

// const table = document.getElementById('myTable');
// const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
// const totalRows = rows.length;

// function changePage(page) {
//     const pageInfo = document.getElementById('page-info');
//     const btn_next = document.getElementById("btn_next");
//     const btn_prev = document.getElementById("btn_prev");

//     // Validate page
//     if (page < 1) page = 1;
//     if (page > numPages()) page = numPages();

//     // Hide all rows, then display only the rows for the current page
//     for (let i = 0; i < rows.length; i++) {
//         rows[i].style.display = 'none';
//     }

//     // Display rows based on pagination
//     for (let i = (page - 1) * records_per_page; i < (page * records_per_page) && i < rows.length; i++) {
//         rows[i].style.display = '';
//     }

//     // Update page information
//     pageInfo.textContent = `Page ${page} of ${numPages()}`;

//     // Disable Prev/Next buttons when on the first/last page
//     btn_prev.disabled = (page == 1);
//     btn_next.disabled = (page == numPages());
// }

// function prevPage() {
//     if (current_page > 1) {
//         current_page--;
//         changePage(current_page);
//     }
// }

// function nextPage() {
//     if (current_page < numPages()) {
//         current_page++;
//         changePage(current_page);
//     }
// }

// function numPages() {
//     return Math.ceil(totalRows / records_per_page);
// }

// // Initialize table with the first page of rows
// window.onload = function() {
//     changePage(1);
// };
document.addEventListener('DOMContentLoaded', () => {
    const table = document.getElementById('myTable');
    if (table) {
        const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
        const totalRows = rows.length;

        let current_page = 1;
        let records_per_page = 10;

        function changePage(page) {
            const pageInfo = document.getElementById('page-info');
            const btn_next = document.getElementById("btn_next");
            const btn_prev = document.getElementById("btn_prev");

            if (page < 1) page = 1;
            if (page > numPages()) page = numPages();

            for (let i = 0; i < rows.length; i++) {
                rows[i].style.display = 'none';
            }

            for (let i = (page - 1) * records_per_page; i < (page * records_per_page) && i < rows.length; i++) {
                rows[i].style.display = '';
            }

            pageInfo.textContent = `Page ${page} of ${numPages()}`;
            btn_prev.disabled = (page == 1);
            btn_next.disabled = (page == numPages());
        }

        function prevPage() {
            if (current_page > 1) {
                current_page--;
                changePage(current_page);
            }
        }

        function nextPage() {
            if (current_page < numPages()) {
                current_page++;
                changePage(current_page);
            }
        }

        function numPages() {
            return Math.ceil(totalRows / records_per_page);
        }

        changePage(1);
        
        document.getElementById('btn_prev').addEventListener('click', prevPage);
        document.getElementById('btn_next').addEventListener('click', nextPage);
    }
});


// Search functionality remains unchanged
document.addEventListener('DOMContentLoaded', () => {
    const table = document.getElementById('myTable');
    if (table) {
        const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
        const totalRows = rows.length;

        let current_page = 1;
        let records_per_page = 10;

        function changePage(page) {
            const pageInfo = document.getElementById('page-info');
            const btn_next = document.getElementById("btn_next");
            const btn_prev = document.getElementById("btn_prev");

            if (page < 1) page = 1;
            if (page > numPages()) page = numPages();

            for (let i = 0; i < rows.length; i++) {
                rows[i].style.display = 'none';
            }

            for (let i = (page - 1) * records_per_page; i < (page * records_per_page) && i < rows.length; i++) {
                rows[i].style.display = '';
            }

            pageInfo.textContent = `Page ${page} of ${numPages()}`;
            btn_prev.disabled = (page == 1);
            btn_next.disabled = (page == numPages());
        }

        function prevPage() {
            if (current_page > 1) {
                current_page--;
                changePage(current_page);
            }
        }

        function nextPage() {
            if (current_page < numPages()) {
                current_page++;
                changePage(current_page);
            }
        }

        function numPages() {
            return Math.ceil(totalRows / records_per_page);
        }

        changePage(1);

        document.getElementById('btn_prev').addEventListener('click', prevPage);
        document.getElementById('btn_next').addEventListener('click', nextPage);

        
        // Search functionality
        document.getElementById('search').addEventListener('keyup', function() {
            let input = document.getElementById('search').value.toLowerCase();
            for (let i = 0; i < rows.length; i++) {
                let cells = rows[i].getElementsByTagName('td');
                let match = false;
                for (let j = 0; j < cells.length; j++) {
                    if (cells[j].textContent.toLowerCase().indexOf(input) > -1) {
                        match = true;
                        break;
                    }
                }
                rows[i].style.display = match ? '' : 'none';
            }
        });
    }
});

//excel data
function exportTableToExcel(tableID, filename = '') {
    var table = document.getElementById(tableID);
    if (!table) {
        alert("Table not found!");
        return;
    }

    // Create a workbook from the table
    var wb = XLSX.utils.table_to_book(table, { sheet: "Sheet1" });

    // Filename handling
    filename = filename ? filename : 'ExcelData';
    
    // Write the workbook to an Excel file
    XLSX.writeFile(wb, filename + ".xlsx");
}

//PDF Download
function downloadPDF() {
    var { jsPDF } = window.jspdf;
    var doc = new jsPDF();

    doc.autoTable({ 
        html: '#myTable', 
        theme: 'grid', // You can change the theme to 'striped' or 'plain'
        headStyles: { fillColor: [22, 82, 12] } // Optional: Set header background color
    });

    doc.save('ProductDetails.pdf'); // Specify the name of the PDF
}