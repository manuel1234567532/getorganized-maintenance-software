<div class="card">
    <div class="card-header justify-content-between">
        <h3 class="card-title font-weight-bold">Kalenderansicht</h3>
    </div>
    <div class="card-body">
        <div id="calendar"></div>
    </div>
</div>
<div class="modal fade" id="workOrderDetailsModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Arbeitsauftrag Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
            </div>
            <div class="modal-body">
                <!-- Display the fetched work order details in a form -->

            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>
    <script>
        var calendar = new FullCalendar.Calendar(document.getElementById("calendar"), {
        locale: 'de',  // Setze die Sprache auf Deutsch
        headerToolbar: {
            left: "prev,next today",
            center: "title",
            right: "dayGridMonth,dayGridWeek,dayGridDay"
        },
        buttonText: {  // Eigene Texte für Schaltflächen definieren
            today: 'Heute',
            month: 'Monat',
            week: 'Woche',
            day: 'Tag',
            list: 'Liste'
        },
            navLinks: true,
            selectable: true,
            selectMirror: true,
            editable: false,
            contentHeight: "auto",
            events: function(fetchInfo, successCallback, failureCallback) {
                fetch('/calendar')
                    .then(function(response) {
                        return response.json();
                    })
                    .then(function(data) {
                        var events = data.map(function(event) {
                            return {
                                id: event.id,
                                title: event.title,
                                start: event.start_date,
                                end: event.end_date,
                                location: event.location,
                                machine: event.machine,
                                priority: event.priority,
                                time: event.time,
                            };
                        });
                        successCallback(events);
                    })

                    .catch(function(error) {
                        failureCallback(error);
                    });
            },
            eventClick: function(info) {
                var event_route = '/celender-detail';
                var csrftoken = $('meta[name=csrf-token]').attr('content');
                $.ajax({
                    url: event_route,
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrftoken
                    },
                    data: {
                        id: info.event.id
                    },
                    success: function(response) {
                        $('#workOrderDetailsModal .modal-body').html(response);
                        $('#workOrderDetailsModal').modal('show');
                        $('#user__assign').select2({
                            width: '100%', // Set the width to 100%
                            placeholder: 'Select User', // Set a placeholder text
                        });
                        $(function() {
                            const datePicker = flatpickr("#schedule_period_range", {
                                mode: "range",
                                dateFormat: "Y-m-d",
                                onClose: function(selectedDates, dateStr,
                                    instance) {
                                    document.getElementById("dateRange")
                                        .value =
                                        dateStr;

                                    const weeklyButton = document.querySelector(
                                        '[data-value-time="weekly"]');
                                    const monthlyButton = document
                                        .querySelector(
                                            '[data-value-time="monthly"]');
                                    const yearlyButton = document.querySelector(
                                        '[data-value-time="yearly"]');
                                    const dailyButton = document.querySelector(
                                        '[data-value-time="daily"]');

                                    if (dateStr.includes("to")) {
                                        weeklyButton.style.display =
                                            'inline-block';
                                        monthlyButton.style.display =
                                            'inline-block';
                                        yearlyButton.style.display =
                                            'inline-block';
                                        // dailyButton.style.display = 'none';

                                    } else {
                                        weeklyButton.style.display = 'none';
                                        monthlyButton.style.display = 'none';
                                        yearlyButton.style.display = 'none';
                                        // dailyButton.style.display =
                                        //     'inline-block';
                                    }
                                }
                            });

                            document.getElementById("addTime").addEventListener("click",
                                function(event) {
                                    event.preventDefault();
                                    datePicker.set("mode", "range");
                                });
                        });
                        const buttons = document.querySelectorAll('.toggle-color');
                        const selectedTime = document.getElementById('selected-value');

                        buttons.forEach(button => {
                            button.addEventListener('click', function() {
                                buttons.forEach(btn => btn.classList.remove(
                                    'active'));
                                this.classList.add('active');
                                selectedTime.value = this.getAttribute(
                                    'data-value-time');

                            });
                        });
                        const priorityButtons = document.querySelectorAll('.toggle-priority');
                        const priorityInput = document.getElementById('priorityvalue');

                        priorityButtons.forEach(button => {
                            button.addEventListener('click', function() {
                                priorityButtons.forEach(btn => {
                                    btn.classList.remove('active');
                                });
                                this.classList.add('active');
                                priorityInput.value = this.getAttribute(
                                    'data-value');
                            });
                        });
                        $(document).on('click', '#addTime', function() {
                            // Hide the text element
                            $(this).hide();

                            // Show the input field in its place
                            $('#time').show();
                        });

                    }
                });
            },
            eventDidMount: function(info) {
                var el = info.el;
                var event = info.event;

                var location = event.extendedProps.location;
                var machineName = event.extendedProps.machine;
                var startDate = event.startStr;
                var endDate = event.endStr;
                var priority = event.extendedProps.priority;
                var time = event.extendedProps.time;

                var content = '<div>Standort:' + location + '</div>';
                if (machineName) {
                    content += '<div>Maschine:' + machineName + '</div>';
                }
                if (startDate && endDate) {
                    content += '<div>Start: ' + startDate + '</div>';
                    content += '<div>Ende: ' + endDate + '</div>';
                }
                if (time) {
                    content += '<div>Uhrzeit: ' + time + '</div>';
                }

                $(el).addClass('event-class');
                $(el).attr('data-title', event.title);
                $(el).attr('data-content', content);
                // setting the bg-color of workorder stip

                var cr_date = new Date();
                cr_date.setHours(0, 0, 0, 0);

                var formatted_cr_date = cr_date.toISOString().split('T')[0];

                var end_date = new Date(endDate);
                var date_cur = new Date(formatted_cr_date);


                if (end_date < date_cur && priority !== "completed") {
                    $(el).addClass('bg-danger');
                } else if (priority === "in_progress") {
                    $(el).addClass('bg-primary');
                } else if (priority === "onhold") {
                    $(el).addClass('bg-warning');
                } else if (priority === "completed") {
                    $(el).addClass('bg-success');
                } else if (priority === "open") {
                    $(el).addClass('bg-gray');
                }

                // console.log(priority);


                $(el).popover({
                    title: function() {
                        return $(this).data('title');
                    },
                    trigger: 'hover',
                    placement: 'top',
                    content: function() {
                        return $(this).data('content');
                        // return "hello";
                    },
                    html: true
                });
                if (priority) {
                    var dateCell = document.querySelector('.fc-daygrid-day[data-date="' + event.startStr +
                        '"]');
                    var existingPriority = dateCell.querySelector('.priority-item');

                    if (!existingPriority) {
                        var dateCellTop = dateCell.querySelector('.fc-daygrid-day-top');
                        if (!dateCellTop) {
                            dateCellTop = document.createElement('div');
                            dateCellTop.className = 'fc-daygrid-day-top';
                            dateCell.appendChild(dateCellTop);
                        }

                        var priorityElement = document.createElement('div');
                        priorityElement.className = 'priority-item';

                        var iconElement = document.createElement('i');
                        iconElement.style.marginTop = '12px';
                        // iconElement.style.position = 'relative';
                        iconElement.style.left = '-96px';

                        switch (priority) {
                            case 'open':
                                iconElement.className = 'fa fa-unlock-alt';
                                break;
                            case 'onhold':
                                iconElement.className = 'fa fa-pause-circle-o';
                                break;
                            case 'in_progress':
                                iconElement.className = 'fa fa-refresh';
                                break;
                            case 'completed':
                                iconElement.className = 'fa fa-check';
                                break;
                            default:
                                iconElement.className = 'default-icon';
                                break;
                        }
                        priorityElement.appendChild(iconElement);
                        // setting the icon-color of workorder
                        if (priority === "open") {
                            // iconElement.style.color = '#007bff';
                            $(iconElement).addClass('text-gray');
                        } else if (priority === "in_progress") {
                            $(iconElement).addClass('text-primary');
                        } else if (priority === "onhold") {
                            $(iconElement).addClass('text-warning');
                        } else if (priority === "completed") {
                            $(iconElement).addClass('text-success');
                        }
                        dateCellTop.appendChild(priorityElement);
                    }
                }
            }
        });
        calendar.render();
    </script>
@endpush
