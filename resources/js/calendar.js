import { Calendar } from "@fullcalendar/core";
import interactionPlugin, { Draggable } from "@fullcalendar/interaction";
import dayGridPlugin from "@fullcalendar/daygrid";
import timeGridPlugin from "@fullcalendar/timegrid";
import listPlugin from "@fullcalendar/list";
import axios from 'axios';

function formatDate(dt, pos) {
    var date = new Date(dt);
    var year_str = date.getFullYear();
    //月だけ+1すること
    var month_str = 1 + date.getMonth();
    var day_str = date.getDate();
    if (pos == "end") {
        day_str--;
    }

    let format_str = 'YYYY-MM-DD';
    format_str = format_str.replace(/YYYY/g, year_str);
    format_str = format_str.replace(/MM/g, ('00' + month_str).slice(-2));
    format_str = format_str.replace(/DD/g, ('00' + day_str).slice(-2));

    return format_str;
}

var calendarEl = document.getElementById("calendar");

let calendar = new Calendar(calendarEl, {
    plugins: [interactionPlugin, dayGridPlugin, timeGridPlugin, listPlugin],
    initialView: "dayGridMonth",
    customButtons: {
        createEvent: {
            text: '+',
            click: function() {
                document.getElementById("create-id").value = "";
                document.getElementById("create-name").value = "";
                document.getElementById("create-start_date").value = "";
                document.getElementById("create-end_date").value = "";

                document.getElementById('modal-create').style.display = 'flex';
            }
        }
    },
    headerToolbar: {
        left: "prev,next today createEvent",
        center: "title",
        right: "dayGridMonth,timeGridWeek,listWeek",
    },

    // 日付をクリック、または範囲を選択したイベント
    selectable: true,
    editable: true,

    height: "auto",

    select: function(info) {
        document.getElementById("create-id").value = "";
        document.getElementById("create-name").value = "";
        document.getElementById("create-start_date").value = formatDate(info.start);
        if (!info.end) {
            document.getElementById("create-end_date").value = formatDate(info.start);
        }
        else {
            document.getElementById("create-end_date").value = formatDate(info.end, "end");
        }

        document.getElementById('modal-create').style.display = 'flex';
    },

    events: function(info, successCallback, failureCallback) {
        // Laravelのイベント取得処理の呼び出し
        axios
            .post("/calendar/get", {
                start_date: info.start.valueOf(),
                end_date: info.end.valueOf(),
            })
            .then((response) => {
                // 追加したイベントを削除
                calendar.removeAllEvents();
                // カレンダーに読み込み
                successCallback(response.data);
            })
            .catch(() => {
                // バリデーションエラーなど
                alert("読み込みに失敗しました");
            });
    },

    eventClick: function(info) {
        document.getElementById("edit-id").value = info.event.id;
        document.getElementById("delete-id").value = info.event.id;
        document.getElementById("edit-name").value = info.event.title;
        document.getElementById("edit-start_date").value = formatDate(info.event.start);
        if (!info.event.end) {
            document.getElementById("edit-end_date").value = formatDate(info.event.start);
        }
        else {
            document.getElementById("edit-end_date").value = formatDate(info.event.end, "end");
        }
        document.getElementById('modal-edit').style.display = 'flex';
    },

    eventDrop: function(info) {
        document.getElementById("edit-id").value = info.event.id;
        document.getElementById("delete-id").value = info.event.id;
        document.getElementById("edit-name").value = info.event.title;
        document.getElementById("edit-start_date").value = formatDate(info.event.start);
        if (!info.event.end) {
            document.getElementById("edit-end_date").value = formatDate(info.event.start);
        }
        else {
            document.getElementById("edit-end_date").value = formatDate(info.event.end, "end");
        }
        
        var form_edit=document.getElementById("form-edit");
        form_edit.submit();
        
    },

});
calendar.render();

window.closeCreateModal = function() {
    document.getElementById('modal-create').style.display = 'none';
}

window.closeEditModal = function() {
    document.getElementById('modal-edit').style.display = 'none';
}

window.deleteConfirm = function() {
    'use strict'

    document.getElementById('modal-edit').style.display = 'none';

    if (confirm('本当に削除しますか？')) {
        document.getElementById('delete-form').submit();
    }
}
