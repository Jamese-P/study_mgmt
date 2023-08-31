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
            <div class="w-full h-auto">
                <div id='calendar'></div>
            </div>

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
                                <div class="form-element">
                                    <label for="name" class="modal-label">タイトル</label>
                                    <input type="text" class="modal-input"/>
                                </div>
                                <div class="modal-grid">
                                    <div class="modal-element">
                                        <label for="start" class="modal-label">開始日</label>
                                        <input type="date" class="modal-input" id="start"/>
                                    </div>
                                    <div class="modal-element">
                                        <label for="end" class="modal-label">終了日</label>
                                        <input type="date" class="modal-input" id="end"/>
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

        </body>

    </x-app-layout>
</html>