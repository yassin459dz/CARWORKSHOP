{{-- resources/views/components/select.blade.php --}}
<select id="{{ $id }}" name="{{ $name }}" class="form-select {{ $class }}">
    @foreach ($options as $value => $label)
        <option value="{{ $value }}" data-related="{{ $related[$value] ?? '' }}">
            {{ $label }}
        </option>
    @endforeach
</select>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const clientSelect = document.querySelector('#client_id');
        const carSelect = document.querySelector('#car_id');

        function updateCarOptions() {
            const selectedClient = clientSelect.value;
            const options = carSelect.querySelectorAll('option');

            options.forEach(option => {
                if (option.dataset.related === selectedClient) {
                    option.style.color = 'blue';
                } else {
                    option.style.color = 'black';
                }
            });
        }

        clientSelect.addEventListener('change', updateCarOptions);
        updateCarOptions(); // Initial call to apply styles
    });
</script>
