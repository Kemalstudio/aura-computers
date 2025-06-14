@foreach ($locales as $localeCode => $properties)
    @if ($currentLocale !== $localeCode)
        <li>
            <a class="dropdown-item d-flex align-items-center"
               href="{{ route('locale.switch', $localeCode) }}">
                <img src="{{ $properties['flag'] }}" width="20" alt="{{ $properties['name'] }}" class="me-2">
                {{ $properties['name'] }}
            </a>
        </li>
    @endif
@endforeach