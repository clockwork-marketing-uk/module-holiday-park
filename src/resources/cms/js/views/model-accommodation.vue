<template>
  <c-portlet :ready="ready">
    <template v-slot:header>
      <c-module-header title="Holiday Park Module" />
    </template>
    <template v-slot:body>
      <c-module-sub-header v-if="isNewRecord" title="Create new accommodation" />
      <c-module-sub-header v-if="!isNewRecord" :title="'Update accommodation ' + model.base.title" />
      <div>
        <b-tabs>
          <b-tab title="Listing">
            <b-form-group label="Title *" :invalid-feedback="errors.first('title')">
              <b-form-input
                type="text"
                v-model="model.base.title"
                name="title"
                data-vv-as="Title"
                v-validate="'required'"
                :state="errors.has('title') ? false : null"
                required
              />
            </b-form-group>
            <b-form-group label="Tagline">
              <b-form-input type="text" v-model="model.tagline" />
            </b-form-group>
            <b-form-group
              v-if="
                $root.getSetting('accommodation_pricing_options_enabled') &&
                $root.getSetting('accommodation_pricing_options_enabled') == 1
              "
              label="From Price"
            >
              <b-form-input type="number" v-model="model.price" name="price" data-vv-as="Price" />
            </b-form-group>
            <b-form-group label="Category *" :invalid-feedback="errors.first('category')">
              <multiselect
                v-if="categoriesLoaded"
                :multiple="true"
                placeholder="Select Categories"
                v-model="model.categories"
                :options="allCategories"
                label="base"
                track-by="id"
                data-vv-as="Category"
                v-validate="'required'"
                :state="errors.has('category') ? false : null"
              >
                <template slot="tag" slot-scope="props">
                  <b-badge variant="secondary" class="mr-1">{{ props.option.base.title }}</b-badge>
                </template>
                <template slot="option" slot-scope="props">
                  {{ props.option.base.title }}
                </template>
              </multiselect>
              <b-form-input v-else type="text" placeholder="Select Categories" disabled />
            </b-form-group>
            <b-form-group label="Excerpt">
              <c-text-editor v-model="model.text" />
            </b-form-group>
            <b-form-group label="Virtual Tour" label-for="virtual_tour_code" description="The virtual tour content">
              <b-form-textarea v-model="model.virtual_tour_code" />
            </b-form-group>
            <template v-if="$root.getSetting('accommodation_has_extra_text')">
              <b-form-group :label="$root.getSetting('accommodation_extra_text_label')">
                <c-text-editor v-model="model.extra_text" />
              </b-form-group>
            </template>
            <b-form-group label="Booking URL">
              <b-form-input type="text" v-model="model.booking_url" />
            </b-form-group>
            <b-form-group
              v-if="
                $root.getSetting('accommodation_floor_plan_enabled') &&
                $root.getSetting('accommodation_floor_plan_enabled') == 1
              "
              label="Floor Plan"
            >
              <c-media-document-picker v-model="model.floor_plan" />
            </b-form-group>
            <b-form-group label="Enabled" label-for="active" description="Whether this accommodation is enabled or not">
              <b-form-checkbox switch name="active" v-model="model.base.active" :value="1" :unchecked-value="0" />
            </b-form-group>
          </b-tab>
          <template v-if="$root.getSetting('accommodation_has_tags')">
            <b-tab title="Filters">
              <b-form-group label="Tags">
                <multiselect
                  :multiple="true"
                  name="tags"
                  v-model="model.tags"
                  :options="tags"
                  label="tag"
                  :taggable="true"
                  track-by="id"
                  placeholder="Search or add new tag"
                  @tag="addNewTag"
                  v-validate="'required'"
                />
              </b-form-group>
            </b-tab>
          </template>
          <b-tab title="Images">
            <c-media-multi-image-picker
              :width="$root.getSetting('accommodation_crop_x')"
              :height="$root.getSetting('accommodation_crop_y')"
              v-model="model.images"
            />
          </b-tab>

          <b-tab title="Facilities">
            <b-form-group
              label="Enable Facilities?"
              label-for="facilities_enabled"
              description="Whether facilities are enabled"
            >
              <b-form-checkbox
                switch
                name="facilities_enabled"
                v-model="model.facilities_enabled"
                :value="1"
                :unchecked-value="0"
              />
            </b-form-group>

            <b-form-group v-if="model.facilities_enabled == 1" label="Choose Facilities">
              <multiselect
                v-if="facilities.length > 0"
                :multiple="true"
                placeholder="Search Facilities"
                v-model="model.facilities"
                :options="facilities"
                label="title"
                :taggable="true"
                track-by="id"
              />
            </b-form-group>
          </b-tab>

          <b-tab title="Additional Page">
            <b-form-group label="Additional Page Enabled?">
              <b-form-checkbox switch v-model="model.page_enabled" :value="1" :unchecked-value="0" />
            </b-form-group>
            <b-card v-if="model.page_enabled">
              <template #header> Additional Page Content </template>
              <c-page-section-builder v-model="model.sections" />
            </b-card>
          </b-tab>

          <b-tab title="Prices" v-if="pricingEnabled == 1">
            <template>
              <b-form-group v-if="!isNewRecord" class="mb-4">
                <div class="mb-4 col h5">Create a new pricing option</div>

                <div class="row">
                  <div class="col col-md-3">
                    <div class="mb-1 col">Price 💵</div>
                    <div class="col">
                      <b-form-input name="filter" placeholder="0.00" v-model="price.price" type="text"></b-form-input>
                    </div>
                  </div>
                  <div class="col col-md-3">
                    <div class="mb-1 col">No. of Guests🧍</div>
                    <div class="col">
                      <b-form-input name="filter" placeholder="0" v-model="price.guests" type="text"></b-form-input>
                    </div>
                  </div>
                  <div class="col col-md-3">
                    <div class="mb-1 col">No. of Nights 🛌</div>
                    <div class="col">
                      <b-form-input name="filter" placeholder="0" v-model="price.nights" type="text"></b-form-input>
                    </div>
                  </div>

                  <div class="mt-auto col-md-2">
                    <b-button variant="dark" @click="addPrice">Add Item</b-button>
                  </div>
                </div>
              </b-form-group>

              <c-listgrid
                ref="listgridItems"
                v-if="pricesReady && !isNewRecord"
                :baseRoute="String(model.id)"
                itemRoute="price/model"
                :itemData="prices"
                noDataMessage="No pricing options found for this accommodation"
                @deleteItem="deletePrice"
                @orderChanged="orderPrices"
                :can-reorder="true"
              ></c-listgrid>
            </template>

            <template v-if="isNewRecord">
              <p>You'll need to save this section before you can add items.</p>
            </template>
          </b-tab>

          <b-tab title="SEO">
            <c-seo-form v-model="model.base" :sections="model.sections" @touched:url_slug="flags.touchedSlug = true" />
          </b-tab>
        </b-tabs>
      </div>
      <c-form-submit @save="submit('save')" @apply="submit('apply')" :validator="$validator"></c-form-submit>
    </template>
  </c-portlet>
</template>

<script>
import slug from "cmsNode/slug"

export default {
  name: "model-accommodation",
  props: {
    id: {
      default: 0,
    },
  },
  data() {
    return {
      model: {
        base: {
          title: "",
          price: "",
          meta_title: "",
          meta_description: "",
          header_scripts: "",
          body_scripts: "",
          og_image: "",
          active: 1,
          url: "/" + this.$root.getSetting("accommodation_route") + "/accommodation/<slug>",
          url_slug: "",
        },
        id: 0,
        text: "",
        tagline: "",
        tags: [],
        page_enabled: 0,
        sections: null,
        extra_text: "",
        booking_url: "",
        sort_order: 0,
        categories: [],
        images: [],
        facilities_enabled: 0,
        facilities: [],
        virtual_tour_code: "",
      },
      tags: [], //all tags
      allCategories: [],
      ready: false,
      failed: false,
      facilities: [],
      price: {
        accommodation_id: this.id,
        price: "",
        guests: "",
        nights: "",
        active: 1,
        sort_order: 0,
      },
      pricesReady: false,
      pricingEnabled: false,

      flags: {
        touchedSlug: false,
      },

      parkAccommodationModel: {
        api_accommodation_code: 0,
        accommodation_id: this.id,
      },
    }
  },
  watch: {
    "model.base.title": function (newValue, oldValue) {
      if (this.flags.touchedSlug == false && this.isNewRecord) {
        this.model.base.url_slug = slug(this.model.base.title)
      }
    },
  },
  computed: {
    isNewRecord() {
      return this.model.id == 0 && this.id == 0 ? true : false
    },
    categoriesLoaded() {
      return this.allCategories && this.allCategories.length
    },
  },
  methods: {
    addNewTag(tag) {
      let tagItem = {
        id: "new-" + new Date().valueOf(),
        tag: tag,
      }
      this.tags.push(tagItem)
      this.model.tags.push(tagItem)
    },
    buildListForDropDown(data) {
      let temp = []
      for (let item of data) {
        temp.push({
          id: item.id,
          tag: item.tag,
        })
      }
      return temp
    },
    addPrice() {
      ;(async () => {
        if (this.price.price) {
          try {
            console.log("adding price")
            if (!this.price.guests) {
              this.price.guests = 0
            }
            if (!this.price.nights) {
              this.price.nights = 0
            }

            this.pricesReady = false

            let response = await this.$http.post("accommodation/price", {
              _method: "POST",
              model: this.price,
            })
            console.log("finished adding price")
            console.log(this.price)
            this.price = {
              accommodation_id: this.id,
              price: "",
              guests: "",
              nights: "",
              active: 1,
            }
            this.getPrices()
          } catch (error) {
            console.error(error)
          }
        }
      })()
    },
    deletePrice(price) {
      this.$http
        .delete("accommodation/price/" + price.id)
        .then((response) => {
          this.pricesReady = false
          this.getPrices()
        })
        .catch((error) => {
          console.error(error)
        })
    },
    orderPrices(prices) {
      ;(async () => {
        try {
          let response = await this.$http.post("accommodation/price/reorder", {
            _method: "POST",
            prices: prices,
          })
        } catch (error) {
          console.error(error)
        }
      })()
    },
    async getPrices() {
      console.log("fetching prices")
      const response = await this.$http.get("accommodation/price/accommodationPrices/" + this.id)
      this.prices = response.data
      if (this.prices) {
        this.prices.forEach((price) => {
          price.title = `£${price.price}  -  ${price.guests} Guests  -   ${price.nights} Nights`
        })
        this.pricesReady = true
        console.log("fetched prices")
      }

      console.log(this.prices)
    },
    async updateOrCreateParkAccommodation() {
      let response = await this.$http.post("holiday-park/park-accommodation/model", {
        _method: "POST",
        model: this.parkAccommodationModel,
      })
      console.log(response.data)
      if (response.data.parkAccommodation) {
        this.parkAccommodationModel = response.data.parkAccommodation
      }
      
      
    },
    submit(event) {
      ;(async () => {
        try {
          if (this.isNewRecord) {
            // Create Model
            let response = await this.$http.post("accommodation/model", {
              _method: "POST",
              model: this.model,
            })
            this.parkAccommodationModel.accommodation_id = response.data.id

            this.updateOrCreateParkAccommodation(response.data)

            if (event == "save") {
              this.$router.push("/holiday-park")
            } else {
              this.$router.push("/holiday-park/park-accommodation/model/" + response.data.id)
              this.model.id = response.data.id
              this.price.accommodation_id = response.data.id

              this.getPrices()
              this.$bvToast.toast(this.model.base.title + " has been created.", this.$root.toastSettings.success)
            }
          } else {
            //clear errors before attempting save
            this.$root.serverErrors = []

            // Update Model
            let response = await this.$http.post("accommodation/model/" + this.model.id, {
              _method: "POST",
              model: this.model,
            })

            this.updateOrCreateParkAccommodation(response.data)

            if (event == "save") {
              this.$router.push("/holiday-park")
            } else {
              this.model = response.data.accommodation
              this.$bvToast.toast(this.model.base.title + " has been saved.", this.$root.toastSettings.success)
            }
          }
        } catch (error) {
          console.error(error)
        }
      })()
    },
  },
  mounted() {
    /**
     * Fetch tags for tag dropdown
     */
    this.pricingEnabled = this.$root.getSetting("accommodation_pricing_options_enabled")

    if (this.pricingEnabled == 1) {
      this.getPrices()
    }

    ;(async () => {
      try {
        const response = await this.$http.get("accommodation/tag")
        this.tags = this.buildListForDropDown(response.data)
      } catch (error) {
        console.error(error)
        this.failed = true
      }
    })()
    /**
     * Fetch categories
     */
    ;(async () => {
      try {
        // Fetch model data
        const response = await this.$http.get("accommodation/category")
        this.allCategories = response.data
      } catch (error) {
        console.log("No categories: ", error)
      }
    })()
    /**
     * Fetch property facilities
     */
    ;(async () => {
      try {
        const response = await this.$http.get("accommodation/facility")
        this.facilities = response.data
      } catch (error) {
        console.error(error)
        this.failed = true
      }
    })()
    /**
     * Fetch model
     */
    if (!this.isNewRecord) {
      ;(async () => {
        try {
          // Fetch model data
          const response = await this.$http.get("accommodation/model/" + this.id)
          this.model = response.data.accommodation

          this.ready = true
        } catch (error) {
          console.error(error)
          this.failed = true
        }
      })()
      ;(async () => {
        try {
          const response = await this.$http.get("holiday-park/park-accommodation/findByAccommodationId/" + this.id)

          if (response.data.parkAccommodation) {
            this.parkAccommodationModel = response.data.parkAccommodation
          }
        } catch (error) {
          console.error(error)
          this.failed = true
        }
      })()
    } else {
      this.ready = true
    }
  },
}
</script>
