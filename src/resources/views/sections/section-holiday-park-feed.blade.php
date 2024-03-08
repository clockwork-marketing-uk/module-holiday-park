@inject('setting', '\Clockwork\Settings\Helpers\Setting')

@php
    use Clockwork\Accommodation\Contracts\AccommodationInterface;
    $accommodation_repository = app(AccommodationInterface::class);
    $accommodation = $accommodation_repository->allActive();

@endphp
<section>
    <div class='accommodation-grid-view' x-data="{ filter: 'false', tag: 'false' }">
        @if (!empty($setting::get('accommodation_has_info_bar')) && !empty($showInfoBar) && !empty($accommodation_category))
            @include('accommodation::accommodation.partials.info-bar')
        @endif
        @if (!empty($showFilter) && $showFilter)
            @include('accommodation::accommodation.partials.filters')
        @endif
        @if (!empty($setting::get('accommodation_has_tags')) && !empty($showTags))
            @include('accommodation::accommodation.partials.tags')
        @endif

        @include('holidaypark::holiday-park.properties.property-list', ['section' => true])
    </div>
</section>