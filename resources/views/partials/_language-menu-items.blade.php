@foreach ($locales as $localeCode => $properties)
    <li>
        <a class="dropdown-item d-flex align-items-center @if($currentLocale == $localeCode) active @endif" href="{{ route('locale.switch', $localeCode) }}">
            <img src="{{ $properties['flag'] }}" width="20" alt="{{ $properties['name'] }}" class="me-2">
            {{ $properties['name'] }}
        </a>
    </li>
@endforeach