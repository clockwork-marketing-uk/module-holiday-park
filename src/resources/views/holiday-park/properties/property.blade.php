@php
    $gradeCode = null;
    if (!empty($card?->parkAccommodation?->property?->first())) {
        $gradeCode = $card->parkAccommodation?->property?->first()?->code ?? null;
    }
@endphp

<div class="accommodation-item" data-accommodation_id="{{ $card->id }}" {{ $gradeCode ? "data-grade_code=$gradeCode" : "" }} x-data="{ currentFilter: '{!! $categories_string !!}', currentTags: '{!! $tags !!}' }"
            x-show='(filter === "false" || currentFilter.includes(filter)) && (tag === "false" || currentTags.includes(tag))'>

            <div class="image-container">
                <x-splide :data="[
                    'type' => 'slide',
                    'autoWidth' => false,
                    'autoplay' => false,
                    'pagination' => false,
                    'arrows' => $card->images->count() > 1,
                    'perPage' => 1,
                    'gap' => 0,
                    'perMove' => 1,
                    'width' => '100vw',
                ]" :cards="$card->images" :view="'accommodation::accommodation.partials.image'"></x-splide>
            </div>
            <div class="right-container">
                <div class="text-container" x-data="{ currentTab: 'description' }">
                    @if ($showTabs)
                        @include('accommodation::accommodation.partials.tabs', ['room' => $card])
                    @else
                        <div class="description">
                            <div class="inner-description">
                                @if (!empty($card->base->title))
                                    <h3 class="h3">
                                        {{ $card->base->title }}
                                    </h3>
                                @endif
                                @if (!empty($card->tagline))
                                    <h4 class="h4">
                                        {{ $card->tagline }}
                                    </h4>
                                @endif

                                @tagParse($card->text)
                                @if ($card->tags->isNotEmpty())
                                    <div class="tags">
                                        {{ $card->tags->pluck('tag')->join(',') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
                <div class="ctas">
                    @if ($card->page_enabled && $card->getActivePageSections())
                        <a class="btn primary-btn" href="{{ $card->base->url }}">
                            More Details
                        </a>
                    @endif
                    @if (!empty($setting::get('accommodation_floor_plan_enabled')) && !empty($card->floorPlan->url))
                        <a class="btn primary-btn" href="{{ $card->floorPlan->url }}">
                            Floor Plans
                        </a>
                    @endif
                    @if (!empty($card->booking_url))
                        <a class="btn secondary-btn" href="{{ $card->booking_url }}">
                            Book Now
                        </a>
                    @endif
                    @if (!empty($card->parkAccommodation))
                        <a class="btn secondary-btn booking-button" href="{{ route('park-accommodation.book', ['title' => Str::slug($card->base->title), 'id' => $card->id]) }}">
                            Book Now
                        </a>
                    @endif
                </div>
                
            </div>
        </div>