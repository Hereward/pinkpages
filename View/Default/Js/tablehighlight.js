window.onload = function () {
  //document.getElementById("xytble").onclick = mouse_event_handler;
  document.getElementById("xytble").onmouseover = mouse_event_handler;           
  document.getElementById("xytble").onmouseout = mouse_event_handler;
};


function mouse_event_handler(e) {

    e = e ||  window.event;
    var cell = e.srcElement || e.target;

    var tname = (cell.nodeType == 1) ? cell.tagName.toLowerCase() : '';

    while(tname != "table" && tname !="td" && tname != "th"){
            cell= cell.parentNode || cell.parentElement;
            tname = cell.tagName.toLowerCase();
    }

    if (tname == "td" || tname == "th") {
        var newClass;

        var cellIdx = _getCellIndex(cell);
        var row = cell.parentNode || cell.parentElement;
        var rowIdx = _getRowIndex(row);

        if (cellIdx == 0 && rowIdx == 0) {
            _clearHighlight();
        }
        else if (cellIdx == 0) {
            _setRow();
        }
        else if (rowIdx == 0) {
            _setCol();
        }
        else {
            _setRow();
            _setCol();
        }
    }

    function _getTable() {
        var tbleObj;

        if (mouse_event_handler.previous.table)
            return;
        else {
            tbleObj = row.parentNode || row.parentElement; //tbody
            var tn = tbleObj.tagName.toLowerCase();
            while (tn != "table" && tn != "html") {
                tbleObj = tbleObj.parentNode || tbleObj.parentElement;
                tn = tbleObj.tagName.toLowerCase();
            }
            mouse_event_handler.previous.table = tbleObj;
        }
    }//eof _getTable

    function _clearHighlight() {
        _clearRow();
        _clearCol();

        mouse_event_handler.previous.row = null;
        mouse_event_handler.previous.cellIdx = null;
    }//eof clearHighlight

    function _clearRow() {
        if (mouse_event_handler.previous.row) {
            mouse_event_handler.previous.row.className = "";
            mouse_event_handler.previous.row.cells[0].className = "";
        }
    }//eof clearRow

    function _setRow() {
        _clearRow();
        if (tname == 'td' || mouse_event_handler.previous.row != row) {
            row.className = 'hlt';
            row.cells[0].className = 'hlt';
            mouse_event_handler.previous.row = row;
        }
        else {
            mouse_event_handler.previous.row = null;
        }
    }//eof setRow

    function _clearCol() {
        _getTable();
        if (mouse_event_handler.previous.cellIdx != null) {
            var table = mouse_event_handler.previous.table;
            var cell = mouse_event_handler.previous.cellIdx;
            for (var i = 0; i < table.rows.length; i++) {
                table.rows[i].cells[cell].className = '';
            }
        }
    }//eof clearCol

    function _setCol () {
        _clearCol();
        if (tname == 'td' || mouse_event_handler.previous.cellIdx != cellIdx) {
            mouse_event_handler.previous.table.rows[0].cells[cellIdx].className = 'hlt';
            var trs = mouse_event_handler.previous.table.rows;
            for (var i = 1; i < trs.length; i++) {
                trs[i].cells[cellIdx].className = 'hlt-col';
            }
            mouse_event_handler.previous.cellIdx = cellIdx;
        }
        else {
            mouse_event_handler.previous.cellIdx = null;
        }
    }//eof setCol

    function _getCellIndex(cell) {
        var rtrn = cell.cellIndex || 0;

        if (rtrn == 0) {
            do{
                if (cell.nodeType == 1) rtrn++;
                cell = cell.previousSibling;
            } while (cell);
            --rtrn;
        }
        return rtrn;
    }//eof getCellIndex

    function _getRowIndex(row) {
        var rtrn = row.rowIndex || 0;

        if (rtrn == 0) {
            do{
                if (row.nodeType == 1) rtrn++;
                row = row.previousSibling;
            } while (row);
            --rtrn;
        }
        return rtrn;
    }//eof getRowIndex

}//eof mouse_event

mouse_event_handler.previous = {cellIdx: null, row: null, table: null};

function addEvent(obj, event_name, fnc) {

    if (typeof obj == "undefined")
        return;
    else if (obj.attachEvent)
        obj.attachEvent("on"+event_name, fnc);
    else if (obj.addEventListener && !browser.isKHTML)
        obj.addEventListener(event_name, fnc, false);
    else
        obj["on" + event_name] = fnc;

}//eof addEvent

/*
window.onload = function () {
          addEvent(document.getElementById("xytble"), "click", mouse_event_handler);
       };
*/	   

window.onunload = function () {
    mouse_event_handler.previous = null;
}
