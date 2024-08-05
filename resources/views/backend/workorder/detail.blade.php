<style>
    /* Style for the button */
    .icon-button {
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #000;
        padding: 8px 12px;
        border-radius: 5px;
        background-color: #fff;
        cursor: pointer;
        transition: background-color 0.3s, color 0.3s;
    }

    /* Hover effect */
    .icon-button:hover {
        background-color: #007bff;
        color: #fff;
    }

    /* Active button styles */
    .icon-button.active {
        background-color: #007bff;
        color: #fff;
    }

    table {
        width: 80%;
        table-layout: fixed;
    }

    table th,
    table td {
        word-wrap: break-word;
    }

    .priorityDot {
        display: inline-block;
        border-radius: 100%;
        width: 8px;
        height: 8px;
        margin-right: 2px;
    }
</style>
@isset($workOrder)
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-end">
               @if ($workOrder->created_by == Auth::id() || Auth::user()->user_type == 'admin' || Auth::user()->user_type == 'Super Admin')
                    @if ($workOrder->status != 'completed')
                        <button id="formbutton" data-url="{{ route('work-order.edit', $workOrder->id) }}"
                            class="btn btn-sm btn-primary">
                            <i class="fe fe-edit"></i>
                        </button>
                    @endif
                    <button id="deleteButton" style="margin-left:5px;"
                        data-url="{{ route('work-order.destroy', $workOrder->id) }}" class="btn btn-sm btn-danger">
                        <i class="fe fe-trash"></i>
                    </button>
                @endif
            </div>
            <div class="row">
                <div class="col-md-9">
                    <label for="time_schedule" class="mr-3">Status</label>
                    <div class="form-group d-flex flex-wrap gap-2 align-items-center mt-3 status_buttons">
                        @if ($workOrder->status === 'completed')
                            <div class="mr-2">
                                <button
                                    style="display: flex; flex-direction: column; align-items: center; justify-content: center; border: 1px solid #000; padding: 8px 12px; border-radius: 5px; cursor: pointer; transition:  text-align: center;"
                                    class="icon-button" disabled>
                                    <i class="fa fa-unlock-alt" style="margin-bottom: 8px;"></i>
                                    <span>Offen</span>
                                </button>
                            </div>
                            <div class="mr-2">
                                <button
                                    style="display: flex; flex-direction: column; align-items: center; justify-content: center; border: 1px solid #000; padding: 8px 12px; border-radius: 5px; cursor: pointer; transition:  text-align: center;"
                                    class="icon-button mx-2" disabled>
                                    <i class="fa fa-pause-circle-o" style="margin-bottom: 8px;"></i>
                                    <span>In Wartestellung</span>
                                </button>
                            </div>
                            <div class="mr-2">
                                <button
                                    style="display: flex; flex-direction: column; align-items: center; justify-content: center; border: 1px solid #000; padding: 8px 12px; border-radius: 5px; cursor: pointer; transition:  text-align: center;"
                                    class="icon-button" disabled>
                                    <i class="fa fa-refresh" style="margin-bottom: 8px;"></i>
                                    <span>In Bearbeitung</span>
                                </button>
                            </div>
                            <div class="mr-2">
                                <button
                                    style="display: flex; flex-direction: column; align-items: center; justify-content: center; border: 1px solid #000; padding: 8px 12px; border-radius: 5px; cursor: pointer; transition:  text-align: center;"
                                    class="icon-button mx-2  {{ $workOrder->status === 'completed' ? 'bg-success text-light' : '' }}"
                                    disabled>
                                    <i class="fa fa-check" style="margin-bottom: 8px;"></i>
                                    <span>Abgeschlossen</span>
                                </button>
                            </div>
                        @else
                            <div class="mr-2">
                                <button onclick="confirmStatusChange('open', this)"
                                    data-work-order-id="{{ $workOrder->id }}"
                                    style="display: flex; flex-direction: column; align-items: center; justify-content: center; border: 1px solid #000; padding: 8px 12px; border-radius: 5px; cursor: pointer; transition:  text-align: center;"
                                    class="icon-button {{ $workOrder->status === 'open' ? 'bg-info text-light' : '' }}">
                                    <i class="fa fa-unlock-alt" style="margin-bottom: 8px;"></i>
                                    <span>Offen</span>
                                </button>
                            </div>
                            <div class="mr-2">
                                <button onclick="confirmStatusChange('onhold', this)"
                                    data-work-order-id="{{ $workOrder->id }}"
                                    style="display: flex; flex-direction: column; align-items: center; justify-content: center; border: 1px solid #000; padding: 8px 12px; border-radius: 5px; cursor: pointer; transition:  text-align: center;"
                                    class="icon-button mx-2  {{ $workOrder->status === 'onhold' ? 'bg-warning text-light' : '' }}">
                                    <i class="fa fa-pause-circle-o" style="margin-bottom: 8px;"></i>
                                    <span>In Wartestellung</span>
                                </button>
                            </div>
                            <div class="mr-2">
                                <button onclick="confirmStatusChange('in_progress', this)"
                                    data-work-order-id="{{ $workOrder->id }}"
                                    style="display: flex; flex-direction: column; align-items: center; justify-content: center; border: 1px solid #000; padding: 8px 12px; border-radius: 5px; cursor: pointer; transition:  text-align: center;"
                                    class="icon-button  {{ $workOrder->status === 'in_progress' ? 'bg-primary text-light' : '' }}">
                                    <i class="fa fa-refresh" style="margin-bottom: 8px;"></i>
                                    <span>In Bearbeitung</span>
                                </button>
                            </div>
                            <div class="mr-2">
                                <button onclick="confirmStatusChange('completed', this)"
                                    data-work-order-id="{{ $workOrder->id }}"
                                    style="display: flex; flex-direction: column; align-items: center; justify-content: center; border: 1px solid #000; padding: 8px 12px; border-radius: 5px; cursor: pointer; transition:  text-align: center;"
                                    class="icon-button mx-2  {{ $workOrder->status === 'completed' ? 'bg-success text-light' : '' }}">
                                    <i class="fa fa-check" style="margin-bottom: 8px;"></i>
                                    <span>Abgeschlossen</span>
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
                <dl class="d-flex">
                    <dt class="mx-1">Titel:</dt>
                    <dd>{{ $workOrder->name }}</dd>
                </dl>
				 <dl class="d-flex">
                    <dt class="mx-1">Beschreibung:</dt>
                    <dd>{{ $workOrder->description }}</dd>
                </dl>
                <dl class="d-flex">
                    <dt class="mx-1">Startzeit:</dt>
                    <dd>
                       @if ($workOrder->schedule_period_time)
    {{ $workOrder->schedule_period_time }} Uhr
@else
                            Nicht für diesen Arbeitsauftrag festgelegt
                        @endif
                    </dd>
                </dl>
            </div>
         <hr class="startdate_table_hr">
<table style="border-collapse: collapse;" class="start_date_table">
    <thead>
        <tr>
            <th>Priorität</th>
            <th class="spacer"></th>
            <th>Startdatum</th>
            <th class="spacer"></th>
            <th>Endtermin</th>
        </tr>
    </thead>
    <tbody>
        @php
            $dateRange = $workOrder->schedule_period;
            $dates = explode(' to ', $dateRange);
            $startDate = $dates[0];
            $endDate = $dates[1] ?? $startDate;
        @endphp
        <tr>
            <td>
                <span class="priorityDot {{ $workOrder->priority === 'low' ? 'bg-success' : '' }}
    {{ $workOrder->priority === 'high' ? 'bg-danger' : '' }}
    {{ $workOrder->priority === 'medium' ? 'bg-warning' : '' }}">
</span>
@if ($workOrder->priority === 'low')
    {{ trans('Niedrig') }}
@elseif ($workOrder->priority === 'high')
    {{ trans('Hoch') }}
@elseif ($workOrder->priority === 'medium')
    {{ trans('Mittel') }}
@endif
            </td>
            <td class="spacer"></td>
            <td>{{ $startDate }}</td>
            <td class="spacer"></td>
            <td>{{ $endDate }}</td>
        </tr>
    </tbody>
</table>
<div class="start_date_list">
    <dl class="d-flex">
        <dt class="mx-1">Priorität:</dt>
        <dd>
            <span
                class="priorityDot  {{ $workOrder->priority === 'low' ? 'bg-success' : '' }}
                {{ $workOrder->priority === 'high' ? 'bg-danger' : '' }}
                {{ $workOrder->priority === 'medium' ? 'bg-warning' : '' }}"></span>
            {{ ucfirst($workOrder->priority) }}
        </dd>
    </dl>
    <dl class="d-flex">
        <dt class="mx-1">Startdatum:</dt>
        <dd>{{ $startDate }}</dd>
    </dl>
    <dl class="d-flex">
        <dt class="mx-1">Endtermin: </dt>
        <dd>{{ $endDate }}</dd>
    </dl>
</div>
<hr>


<div class="info-section">
                <dl>
                    <dt>Zugewiesene Mitarbeiter:</dt>
                    <dd>
                        @if (isset($userNames) && count($userNames) > 0)
                            <ul>
                                @foreach ($userNames as $userName)
                                    <span class="badge fs-7 bg-dark bg-gradient">{{ ucfirst($userName) }}</span>
                                @endforeach
                            </ul>
                        @else
                            <p>No user IDs found for this work order.</p>
                        @endif
                    </dd>
                </dl>
            </div>
            <hr>
            <div class="description">
                <dl>
                    <dt>Beschreibung:</dt>
                    <dd>{{ $workOrder->description }}</dd>
                </dl>
            </div>
            <div class="image-container">
<img src="{{ asset('storage/' . $workOrder->image_url) }}" width="30%" height="30%" alt="Image" style="border-radius: 5px;">
            </div>

        </div>
    </div>
@endisset

@push('scripts')
    <script>
        function confirmStatusChange(status, btn) {
            Swal.fire({
                title: 'Bist du dir sicher?',
                text: 'Du bist dabei, den Status zu ändern. Möchtest du fortfahren?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ja, ändern!',
                cancelButtonText: 'Nein, abbrechen',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    updateStatus(status, btn);
                    // const workOrderId = btn.getAttribute('data-work-order-id');
                    // if (status == "completed") {
                    //     window.location.reload();
                    //     return;
                    // }

                    // fetch(`/work-order-details/${workOrderId}`)
                    //     .then(response => {
                    //         if (!response.ok) {
                    //             throw new Error('Work order not found.');
                    //         }
                    //         return response.text();
                    //     })
                    //     .then(data => {
                    //         // If modal open it closes it for calender edit
                    //         const modelElement = $('#workOrderDetailsModal');
                    //         if (modelElement.is(':visible')) {
                    //             modelElement.modal('hide'); // Hide #model using Bootstrap modal method
                    //         }

                    //         document.getElementById('createWorkOrder').style.display = 'none';
                    //         document.getElementById('editFormContainer').style.display = 'none';
                    //         document.getElementById('workOrderDetails').innerHTML = data;
                    //         document.getElementById('workOrderDetails').style.display = 'block';
                    //         // console.log(data);
                    //     })
                    //     .catch(error => {
                    //         console.error(error.message);
                    //     });
                }
            });

        }

        function updateStatus(status, btn) {
            const workOrderId = btn.getAttribute('data-work-order-id');
            const selectedStatus = status; // This should be the value you're passing
            fetch(`/update-work-order/${workOrderId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        status: selectedStatus
                    })
                })
                .then(response => {
                    if (!response.status) {
                        throw new Error('Die Aktualisierung des Arbeitsauftragsstatus ist fehlgeschlagen.');
                    }
                    return response.json();
                })
                .then(data => {
                    const statusParagraph = document.querySelector(`#status_${workOrderId}`);
                    const statusIconMap = {
                        open: 'fa fa-unlock-alt text-primary',
                        onhold: 'fa-pause-circle-o text-warning',
                        in_progress: 'fa-refresh text-primary',
                        completed: 'fa-check text-success',
                    };

                    const selectedStatus = status; // Ensure 'status' is the value you're passing

                    // Retrieve the icon class based on the selected status
                    const iconClass = statusIconMap[selectedStatus];
                    // let bg = '';

                    // if (selectedStatus === 'completed') {
                    //     bg = 'rgba(141,217,194,0.18)';
                    // } else if (selectedStatus === 'onhold') {
                    //     bg = 'rgba(247,203,54,0.18)';
                    // } else if (selectedStatus === 'in_progress') {
                    //     bg = 'rgba(33, 155, 236, 0.18)';
                    // } else {
                    //     bg = 'white';
                    // }
                    // Update the HTML of the status paragraph to include the icon and selected status text
                    // statusParagraph.innerHTML = `<i class="fa ${iconClass}"></i> ${selectedStatus}`;
                    // statusParagraph.style.backgroundColor = bg; // Adjust color and opacity as needed


                    toastMessage('Arbeitsauftragsstatus erfolgreich aktualisiert', 'success');
                    window.location.reload();

                })

                .catch(error => {
                    toastMessage('Error occurred while processing data.', 'error');
                    // Handle errors or display messages accordingly
                });
        }
        $(document).on('click', '#formbutton', function() {
            var url = $(this).data('url');
            $.ajax({
                url: url,
                type: 'GET',
                success: function(response) {
                    $('#createWorkOrder').hide();
                    document.getElementById('workOrderDetails').style.display = 'none';
                    $('#editFormContainer').html(response)
                        .slideDown();
                    $('#user_id').select2({
                        width: '100%', // Set the width to 100%
                        placeholder: 'Select User', // Set a placeholder text
                    });
                    $(function() {
                        const datePicker = flatpickr("#schedule_period_range_input", {
                            mode: "range",
                            dateFormat: "Y-m-d",
                            onClose: function(selectedDates, dateStr, instance) {
                                document.getElementById("dateRangeInput").value =
                                    dateStr;

                                const weeklyButton = document.querySelector(
                                    '[data-value="weekly"]');
                                const monthlyButton = document.querySelector(
                                    '[data-value="monthly"]');
                                const yearlyButton = document.querySelector(
                                    '[data-value="yearly"]');
                                const dailyButton = document.querySelector(
                                    '[data-value="daily"]');

                                if (dateStr.includes("to")) {
                                    weeklyButton.style.display = 'inline-block';
                                    monthlyButton.style.display = 'inline-block';
                                    yearlyButton.style.display = 'inline-block';
                                    // dailyButton.style.display = 'none';

                                } else {
                                    weeklyButton.style.display = 'none';
                                    monthlyButton.style.display = 'none';
                                    yearlyButton.style.display = 'none';
                                    // dailyButton.style.display = 'inline-block';
                                }
                            }
                        });

                        document.getElementById("addTimeLink").addEventListener("click",
                            function(event) {
                                event.preventDefault();
                                // Your logic for adding time here...
                                datePicker.set("mode", "range");
                            });
                    });
                    const buttons = document.querySelectorAll('.toggle-color');
                    const selectedTime = document.getElementById('selected-time');

                    buttons.forEach(button => {
                        button.addEventListener('click', function() {
                            buttons.forEach(btn => btn.classList.remove('active'));
                            this.classList.add('active');
                            selectedTime.value = this.getAttribute('data-value');
                        });
                    });
                    const priorityButtons = document.querySelectorAll('.toggle-priority');
                    const priorityInput = document.getElementById('priorityInput');

                    priorityButtons.forEach(button => {
                        button.addEventListener('click', function() {
                            priorityButtons.forEach(btn => {
                                btn.classList.remove('active');
                            });
                            this.classList.add('active');
                            priorityInput.value = this.getAttribute('data-value');
                        });
                    });
                },
                error: function(error) {
                    console.log(error);
                }
            });
        });
        $(document).on('click', '#deleteButton', function() {
            const deleteUrl = this.getAttribute('data-url');

            // Show a confirmation dialog using SweetAlert2
            Swal.fire({
                title: 'Sind Sie sicher?',
                text: 'Sie können diesen Eintrag nicht wiederherstellen!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ja, löschen',
                cancelButtonText: 'Abbrechen',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // If confirmed, proceed with the deletion via AJAX
                    fetch(deleteUrl, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
                        }
                    }).then(response => {
                        if (response.ok) {
                            location.reload();
                            toastMessage('Erfolgreich gelöscht!');
                        } else {
                            throw new Error('Etwas ist schief gelaufen');
                        }
                    }).catch(error => {
                        console.error(error);
                        toastMessage('Der Eintrag konnte nicht gelöscht werden!', 'error');
                    });
                }
            });
        });
        $(document).on('click', '#addTimeLink', function() {
            // Hide the text element
            $(this).hide();

            // Show the input field in its place
            $('#timeField').show();
        });
    </script>
@endpush
