import { Calendar } from "@fullcalendar/core";
import interactionPlugin from "@fullcalendar/interaction";
import dayGridPlugin from "@fullcalendar/daygrid";
import timeGridPlugin from "@fullcalendar/timegrid";
import listPlugin from "@fullcalendar/list";
import axios from 'axios';

function formatDate(date, pos) {
    var dt = new Date(date);
    if(pos==="end"){
        dt.setDate(dt.getDate() - 1);
    }
    return dt.getFullYear() + '-' +('0' + (dt.getMonth()+1)).slice(-2)+ '-' +  ('0' + dt.getDate()).slice(-2);
}

var calendarEl = document.getElementById("calendar");

let calendar = new Calendar(calendarEl, {
    plugins: [interactionPlugin, dayGridPlugin, timeGridPlugin, listPlugin],
    initialView: "dayGridMonth",
    headerToolbar: {
        left: "prev,next today",
        center: "title",
        right: "dayGridMonth,timeGridWeek,listWeek",
    },

    // 日付をクリック、または範囲を選択したイベント
    selectable: true,
    
    height: "auto",
    
    select: function (info) {
        document.getElementById("create-id").value = "";
        document.getElementById("create-name").value = "";
        document.getElementById("create-start_date").value = formatDate(info.start);
        document.getElementById("create-end_date").value = formatDate(info.end, "end");

        document.getElementById('modal-create').style.display = 'flex';
    },

    events: function (info, successCallback, failureCallback) {
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
                alert("登録に失敗しました");
            });
    },
    
    eventClick:function(info){
        document.getElementById("edit-id").value = info.event.id;
        document.getElementById("delete-id").value = info.event.id;
        document.getElementById("edit-name").value = info.event.title;
        document.getElementById("edit-start_date").value = formatDate(info.event.start);
        document.getElementById("edit-end_date").value = formatDate(info.event.end, "end");

        document.getElementById('modal-edit').style.display = 'flex';
    }

});
calendar.render();

window.closeCreateModal = function (){
    document.getElementById('modal-create').style.display = 'none';
}

window.closeEditModal = function (){
    document.getElementById('modal-edit').style.display = 'none';
}

window.deleteConfirm = function(){
    'use strict'
    
    document.getElementById('modal-edit').style.display = 'none';

    if (confirm('本当に削除しますか？')) {
        document.getElementById('delete-form').submit();
    }
}