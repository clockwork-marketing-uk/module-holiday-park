
<section class="holiday-park-list">
    <div class="accommodation-list">
        @foreach ($accommodation as $card)
            @php
                if (!empty($card->accommodation) && $card->accommodation->count() > 0) {
                    $parkAccommodation = $card;
                    $card = $card->accommodation->first();
                    $card->parkAccommodation = $parkAccommodation;
                }

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



            @include('holidaypark::holiday-park.properties.property')
        @endforeach
    </div>
</section>