import { Calendar } from "@fullcalendar/core";
import interactionPlugin from "@fullcalendar/interaction";
import dayGridPlugin from "@fullcalendar/daygrid";
import timeGridPlugin from "@fullcalendar/timegrid";
import listPlugin from "@fullcalendar/list";
import axios from 'axios';

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
        //alert("selected " + info.startStr + " to " + info.endStr);

        document.getElementById('modal-create').style.display = 'flex';
        
        var eventName="";

        if (eventName) {
            // Laravelの登録処理の呼び出し
            axios
                .post("/calendar/store", {
                    start_date: info.start.valueOf(),
                    end_date: info.end.valueOf(),
                    name: eventName,
                })
                .then(() => {
                    // イベントの追加
                    calendar.addEvent({
                        title: eventName,
                        start: info.start,
                        end: info.end,
                        allDay: true,
                    });
                })
                .catch(() => {
                    // バリデーションエラーなど
                    alert("登録に失敗しました");
                });
        }
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

});
calendar.render();

window.closeCreateModal = function (){
    document.getElementById('modal-create').style.display = 'none';
}

window.closeEditModal = function (){
    document.getElementById('modal-edit').style.display = 'none';
}