//get table content
function getTableContent() {
    var table_data = [];
    var rows = document.getElementById('tBody').rows;

    for (i = 0; i < rows.length; i++) {
        row = rows[i];
        row_data = getRowContent(row);

        // add order_number to row  
        row_data['order_number'] = rows.length - i;
        table_data.push(row_data);
    }
    // console.log(table_data);
    return table_data;
} 

function getRowContent(row) {
    var row_data = {
        'start_place': getCellContent(row, 0),
        'start_time': getCellContent(row, 1),
        'end_place': getCellContent(row, 2),
        'end_time': getCellContent(row, 3),
        'vehicle': getCellContent(row, 4),
        'action': getCellContent(row, 5),
    };
    return row_data;
}

function getCellContent(row, index) {
    return row.cells[index].innerHTML;
}

function removeAllRoads() {
    document.getElementById("tBody").innerHTML='';
}

function removeLastRoad() {
    document.getElementById("tBody").deleteRow(0);
}

