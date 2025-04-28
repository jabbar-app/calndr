@extends('layouts.app')

@section('content')
  <div class="max-w-4xl mx-auto py-10">
    <h1 class="text-2xl font-bold mb-6">Select a Date and Time</h1>

    @if ($errors->any())
      <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
        {{ $errors->first() }}
      </div>
    @endif

    <form action="{{ route('appointments.chooseSlot') }}" method="POST" class="space-y-6" id="slot-form">
      @csrf

      <!-- Calendar -->
      <div>
        <label class="block mb-2 text-gray-700 font-medium">Choose a Date</label>
        <input type="text" id="calendar" class="w-full p-2 border rounded" placeholder="Select a date" readonly>
      </div>

      <!-- Time Slots -->
      <div id="time-slots" class="space-y-4 hidden">
        <label class="block mb-2 text-gray-700 font-medium">Choose a Time</label>
        <div id="time-options" class="space-y-2">
          <!-- Dynamic Time Options -->
        </div>
      </div>

      <input type="hidden" name="slot_time" id="slot-time-input" required>

      <!-- Submit Button -->
      <div class="flex justify-end mt-6 hidden" id="continue-button-wrapper">
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
          Continue
        </button>
      </div>
    </form>
  </div>

  <script>
    const slots = @json($slots);

    const calendarInput = document.getElementById('calendar');
    const timeSlots = document.getElementById('time-slots');
    const timeOptions = document.getElementById('time-options');
    const slotTimeInput = document.getElementById('slot-time-input');
    const continueButtonWrapper = document.getElementById('continue-button-wrapper');

    flatpickr(calendarInput, {
      inline: true,
      minDate: "today",
      enable: [...new Set(slots.map(slot => slot.slot_time.split('T')[0]))], // unique dates
      onChange: function(selectedDates, dateStr, instance) {
        const availableTimes = slots.filter(slot => {
          const slotDate = new Date(slot.slot_time).toISOString().split('T')[0];
          return slotDate === dateStr;
        });

        timeOptions.innerHTML = '';

        if (availableTimes.length > 0) {
          timeSlots.classList.remove('hidden');

          availableTimes.forEach(slot => {
            const time = new Date(slot.slot_time).toLocaleTimeString([], {
              hour: '2-digit',
              minute: '2-digit'
            });
            const radioId = `time-${slot.id}`;

            const isDisabled = slot.quota <= 0;

            const option = `
                        <div class="${isDisabled ? 'opacity-50' : ''}">
                            <input
                                type="radio"
                                name="slot_option"
                                value="${slot.slot_time}"
                                id="${radioId}"
                                ${isDisabled ? 'disabled' : ''}
                                class="disabled:cursor-not-allowed"
                                required
                            >
                            <label for="${radioId}" class="ml-2 text-gray-700">
                                ${time} ${isDisabled ? '(Full)' : `(${slot.quota} available)`}
                            </label>
                        </div>
                    `;
            timeOptions.innerHTML += option;
          });

          continueButtonWrapper.classList.add('hidden');

          document.querySelectorAll('input[name="slot_option"]').forEach(radio => {
            radio.addEventListener('change', function() {
              slotTimeInput.value = this.value;
              continueButtonWrapper.classList.remove('hidden');
            });
          });

        } else {
          timeSlots.classList.add('hidden');
          continueButtonWrapper.classList.add('hidden');
        }
      }
    });
  </script>
@endsection
