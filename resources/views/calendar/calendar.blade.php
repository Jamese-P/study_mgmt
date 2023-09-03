<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <x-app-layout>
        <head>
            <meta charset="utf-8">
            <title>Today</title>
            <!-- Fonts -->
            <link rel="preconnect" href="https://fonts.bunny.net">
            <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

            <!-- Scripts -->
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        </head>
        <body>
                <div id='calendar'></div>

            <div id="modal-create" class="modal-layer">
                <div class="modal">
                    <div class="modal-inner">
                        <button type="button" class="modal-btn-close" onclick="closeCreateModal()">
                            <svg class="h-3 w-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                        <div class="px-6 py-6 lg:px-8">
                            <h3 class="modal-title">予定登録</h3>
                            <form action="{{route('calendar.create')}}" method="POST">
                                @csrf
                                <input type="hidden" id="create-id" name="id" value="" />
                                <div class="form-element">
                                    <label for="create-name" class="modal-label">タイトル</label>
                                    <input type="text" class="modal-input" name="schedule[name]" id="create-name" value="" required/>
                                </div>
                                <div class="modal-grid">
                                    <div class="modal-element">
                                        <label for="create-start_date" class="modal-label">開始日</label>
                                        <input type="date" class="modal-input" id="create-start_date" name="schedule[start_date]" value="" required/>
                                    </div>
                                    <div class="modal-element">
                                        <label for="create-end_date" class="modal-label">終了日</label>
                                        <input type="date" class="modal-input" id="create-end_date" name="schedule[end_date]" value="" required/>
                                    </div>
                                </div>
                                <div class="modal-element">
                                    <input type="submit" class="modal-btn-submit" value="登録">
                                </div>

                            </form>

                        </div>

                    </div>
                </div>
            </div>

            <div id="modal-edit" class="modal-layer">
                <div class="modal">
                    <div class="modal-inner">
                        <button type="button" class="modal-btn-close" onclick="closeEditModal()">
                            <svg class="h-3 w-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                        <div class="px-6 py-6 lg:px-8">
                            <h3 class="modal-title">予定編集</h3>
                            <form action="{{route('calendar.update')}}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" id="edit-id" name="id" value="" />
                                <div class="form-element">
                                    <label for="edit-name" class="modal-label">タイトル</label>
                                    <input type="text" class="modal-input" name="schedule[name]" id="edit-name" value=""/>
                                </div>
                                <div class="modal-grid">
                                    <div class="modal-element">
                                        <label for="edit-start_date" class="modal-label">開始日</label>
                                        <input type="date" class="modal-input" id="edit-start_date" name="schedule[start_date]" value=""/>
                                    </div>
                                    <div class="modal-element">
                                        <label for="edit-end_date" class="modal-label">終了日</label>
                                        <input type="date" class="modal-input" id="edit-end_date" name="schedule[end_date]" value=""/>
                                    </div>
                                </div>
                                <div class="modal-element">
                                    <input type="submit" class="modal-btn-submit" value="登録">
                                </div>
                            </form>

                            <form id="delete-form" action="{{route('calendar.delete')}}" method="POST">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" id="delete-id" name="id" value="" />
                                <div class="modal-element">
                                    <button type="button" class="modal-btn-submit" onclick="deleteConfirm()">削除</button>
                                </div>

                            </form>

                        </div>

                    </div>
                </div>
            </div>

        </body>

    </x-app-layout>
</html>