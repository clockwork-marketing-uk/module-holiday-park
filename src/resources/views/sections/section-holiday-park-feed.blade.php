@inject('setting', '\Clockwork\Settings\Helpers\Setting')

@php
    use Clockwork\Accommodation\Contracts\AccommodationInterface;
    $accommodation_repository = app(AccommodationInterface::class);
    $accommodation = $accommodation_repository->allActive();

@endphp
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
    <div class="accommodation-list">
        @foreach ($accommodation as $card)
            @php
                $category_items = [];
                foreach ($card->categories as $category) {
                    $category_items[] = Str::slug($category->base->title);
                }
                $categories_string = implode(',', $category_items);

                $showTabs =
                    ($card->facilities->count() > 0 && !empty($card->text)) ||
                    (!empty($card->text) && !empty($card->virtual_tour_code));

                $tags = [];
                if (!empty($card->tags)) {
                    foreach ($card->tags as $tag) {
                        $tags[] = $tag->tag;
                    }
                }
                $tags = implode(',', $tags);
            @endphp



            <div class="accommodation-item" x-data="{ currentFilter: '{!! $categories_string !!}', currentTags: '{!! $tags !!}' }"
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
                    @if (($card->page_enabled && $card->getActivePageSections()) || $card->booking_url)
                        <div class="ctas">
                            @if ($card->page_enabled)
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
                            @if (empty($card->booking_url))
                                <a class="btn secondary-btn" href="{{ route('park-accommodation.book', ['title' => Str::slug($card->base->title), 'id' => $card->id]) }}">
                                    Book Now
                                </a>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>
