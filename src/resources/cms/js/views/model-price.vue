<template>
  <c-portlet>
    <template v-slot:header>
      <c-module-header title="Holiday Park Module" />
    </template>
    <template v-slot:body>
      <c-module-sub-header class="mt-5 mb-4" :title="'Update Pricing Option'" />
      <b-form-group>
        <div class="row">
          <div class="col col-md-3">
            <div class="mb-1 col">Price 💵</div>
            <div class="col">
              <b-form-input name="filter" placeholder="200.00" v-model="price.price" type="text"></b-form-input>
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
        </div>
      </b-form-group>
      <c-form-submit
        class="mt-5"
        @save="submit('save')"
        @apply="submit('apply')"
        :validator="$validator"
      ></c-form-submit>
    </template>
  </c-portlet>
</template>

<script>
import slug from "cmsNode/slug"

export default {
  name: "model-price",
  props: {
    accommodation_id: {
      default: 0,
    },
    price_id: {
      default: 0,
    },
  },
  data() {
    return {
      price: {
        id: this.price_id,
        accommodation_id: this.accommodation_id,
        price: "",
        guests: "",
        nights: "",
        active: 1,
        sort_order: 0,
      },
      serverErrors: [],
      ready: false,
      failed: false,
    }
  },
  computed: {
    isNewRecord: function () {
      return this.price.id == 0 && this.id == 0 ? true : false
    },
  },
  methods: {
    submit(event) {
      ;(async () => {
        try {
          //clear errors before attempting save
          this.$root.serverErrors = []

          // Update Model
          let response = await this.$http.post("accommodation/price/" + this.price_id, {
            _method: "PUT",
            model: this.price,
          })

          if (event == "save") {
            this.$router.push("holiday-park/park-accommodation/model/" + this.accommodation_id)
          }

          this.$bvToast.toast("Pricing option updated", this.$root.toastSettings.success)
        } catch (error) {
          console.error(error)
        }
      })()
    },
  },
  mounted() {
    if (!this.isNewRecord) {
      ;(async () => {
        try {
          const response = await this.$http.get("accommodation/price/" + this.price_id)
          this.price = response.data.price
          this.ready = true
        } catch (error) {
          console.error(error)
          this.failed = false
        }
      })()
    } else {
      this.ready = true
    }
  },
}
</script>
