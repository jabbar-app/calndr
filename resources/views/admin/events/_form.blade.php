@props(['event' => null])

@csrf

<div>
  <label class="block text-gray-700 font-semibold">Title</label>
  <input type="text" name="title" value="{{ old('title', $event->title ?? '') }}"
    class="w-full mt-1 p-3 border rounded" required>
</div>

<div>
  <label class="block text-gray-700 font-semibold mb-1">Description</label>
  <input id="description" type="hidden" name="description" value="{{ old('description', $event->description ?? '') }}">
  <trix-editor input="description" class="trix-content bg-white p-3 border rounded"></trix-editor>
</div>

<div>
  <label class="block text-gray-700 font-semibold">URL (Webhook Target)</label>
  <input type="url" name="url" value="{{ old('url', $event->url ?? '') }}"
    class="w-full mt-1 p-3 border rounded" placeholder="https://yourtarget.com/api/endpoint">
</div>

<div>
  <label class="block text-gray-700 font-semibold">PIN Code (Optional)</label>
  <input type="text" name="pin_code" value="{{ old('pin_code', $event->pin_code ?? '') }}"
    class="w-full mt-1 p-3 border rounded" maxlength="10" placeholder="Enter PIN if you want to protect event">
  <small class="text-gray-500">Leave empty if you want this event public without PIN.</small>
</div>

<div class="flex items-center space-x-2">
  <input type="checkbox" name="is_login_required" value="1" id="is_login_required"
    {{ old('is_login_required', $event->is_login_required ?? false) ? 'checked' : '' }}>
  <label for="is_login_required" class="text-gray-700 font-semibold">
    Require Login to Book Slot
  </label>
</div>

<div class="flex justify-end pt-6">
  <button id="submit-button" type="submit"
    class="px-6 py-3 bg-blue-600 text-white font-semibold rounded hover:bg-blue-700">
    Save Event
  </button>
</div>

@push('styles')
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/trix@2.1.13/dist/trix.min.css">

  <style>
    trix-toolbar [data-trix-button-group="file-tools"] {
      display: none !important;
    }
  </style>
@endpush

@push('scripts')
  <script src="https://cdn.jsdelivr.net/npm/trix@2.1.13/dist/trix.umd.min.js"></script>

  <script>
    document.addEventListener("trix-file-accept", function(event) {
      event.preventDefault(); // Disable attachment
    });
  </script>
@endpush
