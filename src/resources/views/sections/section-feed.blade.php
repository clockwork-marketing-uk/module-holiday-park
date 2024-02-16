@inject('xs', 'Mobile_Detect')

@php
    use Clockwork\Accommodation\Contracts\AccommodationInterface;
    use Clockwork\Accommodation\Contracts\AccommodationCategoryInterface;
    $CATEGORY_GRID_MODE = 0;
    $GRID_MODE = 1;
    $CATEGORY_SLIDER_MODE = 2;
    $SLIDER_MODE = 3;
    
    $accommodation_repository = app(AccommodationInterface::class);
    $accommodation_categories_repository = app(AccommodationCategoryInterface::class);
    $categories = $accommodation_categories_repository->allWithAccommodation();
    
    $showFilter = empty($showFilter) ? 0 : $showFilter;
    $category = empty($category) ? 0 : $category;
    $mode = empty($mode) ? 0 : $mode;
    
    $accommodation = $accommodation_repository->allActive();
    
    if ($category && in_array($mode, [$GRID_MODE, $SLIDER_MODE])) {
        $singleCategory = $accommodation_categories_repository->find($category);
        $accommodation = $singleCategory->activeAccommodation;
        $categories = $singleCategory;
    }
    
    $detect = new Mobile_Detect();
    $splideOption = [];
    $splideOption['perPage'] = 3;
    $splideOption['gap'] = '1rem';
    
    if ($detect->isMobile() && !$detect->isTablet()) {
        $splideOption['perPage'] = 1;
        $splideOption['gap'] = '0rem';
    } elseif ($detect->isTablet()) {
        $splideOption['perPage'] = 1;
        $splideOption['gap'] = '0.5rem';
    }
    
@endphp

<section class="accommodation add-space">

    @if (!empty($title) && !empty($display_title))
        @if ($display_title)
            <div class="accommodation-title">
                {{ $title }}
            </div>
        @endif
    @endif

    @if ($mode == $CATEGORY_GRID_MODE)
        @include('accommodation::accommodation.category-grid')
    @elseif ($mode == $GRID_MODE)
        @include('accommodation::accommodation.list')
    @elseif ($mode == $CATEGORY_SLIDER_MODE || $mode == $SLIDER_MODE)
        @include('accommodation::accommodation.partials.slider')
    @endif
</section>
