@extends('layouts.app') {{-- Assuming you are using the main app layout --}}

@section('title', 'My Calendar')

@push('styles')
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css' rel='stylesheet' />
<style>
    :root {
        --main-color: #2c3e50;
        --accent-color: #e67e22;
        --hover-color: #d35400;
        --light-bg: #f8f9fa;
        --fc-event-bg-color: var(--accent-color);
        --fc-event-border-color: var(--hover-color);
        --fc-event-text-color: white;
    }

    body {
        background-color: var(--light-bg);
    }

    .calendar-sidebar-fixed {
        position: fixed;
        top: 100px;
        left: 30px;
        width: 210px;
        height: 420px;
        background: #fff;
        border-radius: 18px;
        box-shadow: 0 8px 32px rgba(44,62,80,0.10);
        padding: 1.5rem 1rem 1.5rem 1.5rem;
        z-index: 1050;
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        overflow-y: auto;
        border-left: 6px solid var(--accent-color);
        border-top: 2px solid #eee;
        border-bottom: 2px solid #eee;
        transition: box-shadow 0.2s;
    }
    .calendar-sidebar-fixed h6 {
        color: var(--main-color);
        margin-bottom: 0.5rem;
        font-size: 1.08rem;
        font-weight: 600;
        letter-spacing: 0.5px;
    }
    .calendar-sidebar-fixed ul.user-courses-list {
        list-style: none;
        padding-left: 0;
        margin-bottom: 0;
        width: 100%;
    }
    .calendar-sidebar-fixed ul.user-courses-list li {
        margin-bottom: 0.6em;
        font-size: 0.97em;
        display: flex;
        align-items: center;
        gap: 7px;
    }
    .calendar-sidebar-fixed ul.user-courses-list li i {
        color: var(--accent-color);
        font-size: 1.1em;
    }
    .calendar-sidebar-fixed ul.user-courses-list li a {
        color: var(--main-color);
        text-decoration: none;
        transition: color 0.2s;
        font-weight: 500;
    }
    .calendar-sidebar-fixed ul.user-courses-list li a:hover {
        color: var(--hover-color);
        text-decoration: underline;
    }
    .calendar-sidebar-fixed .btn-back-profile {
        background: var(--main-color);
        color: #fff;
        border-radius: 25px;
        padding: 8px 22px;
        border: none;
        font-weight: 500;
        margin-bottom: 1.2rem;
        width: 100%;
        transition: background 0.2s;
        text-align: left;
    }
    .calendar-sidebar-fixed .btn-back-profile:hover {
        background: var(--hover-color);
        color: #fff;
    }
    @media (max-width: 1100px) {
        .calendar-sidebar-fixed {
            display: none;
        }
    }

    .calendar-content-area {
        background-color: #fff;
        padding: 1.5rem;
        border-radius: 15px;
        box-shadow: 0 6px 12px rgba(0,0,0,0.1);
        min-height: 80vh;
        margin-bottom: 32px;
        width: 120%;
        max-width: 120%;
        flex: 2 1 0%;
    }

    #calendar {
        min-height: 700px;
        height: 80vh;
        width: 100%;
    }

    .fc .fc-button-primary {
        background-color: var(--main-color);
        border-color: var(--main-color);
    }
    .fc .fc-button-primary:hover,
    .fc .fc-button-primary:active,
    .fc .fc-button-primary:focus {
        background-color: var(--hover-color);
        border-color: var(--hover-color);
    }
    .fc .fc-daygrid-day.fc-day-today {
        background-color: rgba(230, 126, 34, 0.15);
    }
    .fc-event {
        background-color: var(--fc-event-bg-color) !important;
        border-color: var(--fc-event-border-color) !important;
        color: var(--fc-event-text-color) !important;
        padding: 3px 5px;
        border-radius: 4px;
        font-size: 0.85em;
    }
    .fc-event:hover {
        opacity: 0.85;
    }
    .fc-toolbar-title {
        color: var(--main-color);
    }
    .fc .fc-toolbar.fc-header-toolbar {
        margin-bottom: 1.5em;
        padding: 0 10px;
    }

    /* Responsiveness */
    @media (max-width: 900px) {
        .calendar-sidebar {
            display: none;
        }
        .calendar-content-area {
            padding: 0.5rem;
        }
        #calendar {
            min-height: 400px;
            height: 60vh;
        }
    }

    /* MODAL STYLING */
    .modal-content {
        border-radius: 18px;
        border: 2px solid var(--accent-color);
        box-shadow: 0 8px 32px rgba(44,62,80,0.18);
        background: #fff;
    }
    .modal-header {
        background: linear-gradient(45deg, var(--main-color), var(--accent-color));
        color: #fff;
        border-radius: 16px 16px 0 0;
        border-bottom: none;
    }
    .modal-title {
        font-weight: 600;
        font-size: 1.25rem;
    }
    .modal-body {
        color: var(--main-color);
        font-size: 1.05rem;
    }
    .modal-footer {
        border-top: none;
        background: #f8f9fa;
        border-radius: 0 0 16px 16px;
    }
    .btn-close, .btn-close:focus {
        background: none;
        border: none;
        font-size: 1.5rem;
        color: #fff;
        opacity: 1;
        box-shadow: none;
    }
    .btn-close:hover {
        color: var(--accent-color);
        opacity: 0.8;
    }
    .btn-modal-close {
        background: var(--main-color);
        color: #fff;
        border-radius: 25px;
        padding: 8px 22px;
        border: none;
        font-weight: 500;
        transition: background 0.2s;
    }
    .btn-modal-close:hover {
        background: var(--hover-color);
        color: #fff;
    }
</style>
@endpush

@section('content')
<div class="calendar-sidebar-fixed">
    <a href="{{ route('user.profile') }}" class="btn btn-back-profile btn-block mb-4">
        <i class="fas fa-arrow-left mr-2"></i>Wróć
    </a>
    @if(isset($userCourses) && $userCourses->isNotEmpty())
    <div>
        <h6>Twoje kursy:</h6>
        <ul class="user-courses-list">
            @foreach($userCourses as $course)
                <li>
                    <i class="fas fa-book-open"></i>
                    <a href="{{ route('course.show', $course->id) }}" title="{{ $course->name }}"><span>{{ $course->name }}</span></a>
                </li>
            @endforeach
        </ul>
    </div>
    @endif

    @if(isset($nextLessonDate) && $nextLessonDate)
        <button id="goToNextLesson" class="btn-back-profile mt-4" style="font-size: 0.95rem; padding: 8px 15px; width: 100%;">
            <i class="fas fa-forward mr-1"></i> To the nearest lesson
        </button>
    @endif
</div>
<div class="container-fluid py-2">
    <div class="row g-0 d-flex align-items-start">
        <div class="col d-flex" style="padding-left: 15px; padding-right: 15px;">
            <div class="calendar-content-area flex-grow-1">
                <div class="calendar-title-area">
                    <div class="d-flex justify-content-center align-items-center w-100 position-relative">
                        <h2 class="mb-0" style="font-size: 1.75rem;"><i class="fas fa-calendar-alt mr-2"></i>My Lesson Calendar</h2>
                        <div class="position-absolute" style="right: 0;">
                            
                        </div>
                    </div>
                </div>
                <div id="calendar"></div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js'></script>
<script src="https://unpkg.com/tippy.js@6/dist/tippy-bundle.umd.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var events = @json($events ?? []);
        var nextLessonDate = @json($nextLessonDate ?? null);

        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            slotMinTime: "08:00:00",
            slotMaxTime: "20:00:00",
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
            },
            events: events,
            editable: false,
            selectable: false,
            eventTimeFormat: {
                hour: '2-digit',
                minute: '2-digit',
                hourCycle: 'h23',
                meridiem: false
                
            },
            slotLabelFormat: {
                hour: '2-digit',
                minute: '2-digit',
                hourCycle: 'h23',
                meridiem: false
                

            },
            displayEventEnd: true,
            aspectRatio: 2.2, 
            dayMaxEvents: true,
            eventDidMount: function(info) {
                let tooltipContent = `<strong>Lesson: ${info.event.extendedProps.lessonTitle || 'No title'}</strong><br>Course: ${info.event.extendedProps.courseName || 'N/A'}`;
                if (info.event.extendedProps.instructorName) {
                    tooltipContent += `<br>Instructor: ${info.event.extendedProps.instructorName}`;
                }
                tippy(info.el, {
                    content: tooltipContent,
                    allowHTML: true,
                });
            },
            eventClick: function(info) {
                const oldModal = document.getElementById('lessonDetailModal');
                if (oldModal) oldModal.remove();

                const event = info.event;
                const modalHtml = `
                    <div class="modal fade show" id="lessonDetailModal" tabindex="-1" aria-labelledby="lessonDetailModalLabel" aria-modal="true" style="display:block;">
                      <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="lessonDetailModalLabel">${event.extendedProps.lessonTitle || event.title}</h5>
                            <button type="button" class="btn-close" id="closeLessonModal" aria-label="Zamknij"></button>
                          </div>
                          <div class="modal-body">
                            ${event.extendedProps.courseName ? `<p><strong>Kurs:</strong> ${event.extendedProps.courseName}</p>` : ''}
                            <p><strong>Data:</strong> ${event.start ? event.start.toLocaleString() : ''}${event.end ? ' - ' + event.end.toLocaleString() : ''}</p>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-modal-close" id="closeLessonModalFooter">Zamknij</button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="modal-backdrop fade show"></div>
                `;
                document.body.insertAdjacentHTML('beforeend', modalHtml);

                // Zamknięcie modala
                function closeModal() {
                    const modal = document.getElementById('lessonDetailModal');
                    const backdrop = document.querySelector('.modal-backdrop');
                    if (modal) modal.remove();
                    if (backdrop) backdrop.remove();
                }
                document.getElementById('closeLessonModal').onclick = closeModal;
                document.getElementById('closeLessonModalFooter').onclick = closeModal;
                document.querySelector('.modal-backdrop').onclick = closeModal;
                document.addEventListener('keydown', function escListener(e) {
                    if (e.key === "Escape") {
                        closeModal();
                        document.removeEventListener('keydown', escListener);
                    }
                });
            }
        });
        calendar.render();

        const goToNextLessonButton = document.getElementById('goToNextLesson');
        if (goToNextLessonButton && nextLessonDate) {
            goToNextLessonButton.addEventListener('click', function() {
                calendar.gotoDate(nextLessonDate);
                calendar.changeView('timeGridDay', nextLessonDate);
            });
        }
    });
</script>
@endpush