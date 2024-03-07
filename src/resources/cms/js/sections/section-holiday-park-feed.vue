<template>
  <div>
    <template v-if="errors.any()">
      <b-alert show variant="danger">
        <p>There are some problems with this record:</p>
        <ul class="m-0">
          <li v-for="error in errors.all()">{{ error }}</li>
        </ul>
      </b-alert>
    </template>

    <b-form>
      <b-form-group
        label="Title"
        label-for="title"
        description="The title of this page section"
        :invalid-feedback="errors.first('fields.title')"
      >
        <b-form-input
          name="title"
          type="text"
          v-model="fields.title"
          v-validate="{ required: true }"
          :state="errors.has('fields.title') ? false : null"
        />
      </b-form-group>

      <b-form-group
        label="Show Title"
        label-for="display_title"
        description="Whether the title is shown on the website"
      >
        <b-form-checkbox switch name="display_title" v-model="fields.display_title" :value="1" :unchecked-value="0" />
      </b-form-group>

      <b-form-group
        label="Mode"
        label-for="mode"
        description="Controls which testimonials display on the front-end"
        :invalid-feedback="errors.first('fields.mode')"
      >
        <b-form-select name="mode" v-model="fields.mode" :options="options" />
      </b-form-group>

      <b-form-group
        v-if="fields.mode == 1 || fields.mode == 3"
        label="Category"
        label-for="category"
        description="Pick the category to display testimonials from"
        :invalid-feedback="errors.first('fields.category')"
      >
        <b-form-select name="category" v-model="fields.category" :options="categories" />
      </b-form-group>

      <b-form-group
        v-if="fields.category == 0 && fields.mode != 0 && fields.mode != 2"
        label="Show Category Filter Buttons"
        label-for="active"
        description="Show category buttons at the top?"
      >
        <b-form-checkbox switch name="filter" v-model="fields.showFilter" :value="1" :unchecked-value="0" />
      </b-form-group>

      <b-form-group
        v-if="$root.getSetting('accommodation_has_info_bar') == 1"
        label="Show Info Bar"
        label-for="info-bar"
        description="Show info bar at the top?"
      >
        <b-form-checkbox switch name="inf-bar" v-model="fields.showInfoBar" :value="1" :unchecked-value="0" />
      </b-form-group>

      <b-form-group
        v-if="$root.getSetting('accommodation_has_tags')"
        label="Show Tag Filter Buttons"
        label-for="tags"
        description="Show tag buttons at the top?"
      >
        <b-form-checkbox switch name="tags" v-model="fields.showTags" :value="1" :unchecked-value="0" />
      </b-form-group>

      <b-form-group label="Enabled" label-for="active" description="Whether this section is enabled or not">
        <b-form-checkbox switch name="active" v-model="fields.active" :value="1" :unchecked-value="0" />
      </b-form-group>

      <c-page-section-device-picker v-model="fields.devices" />
    </b-form>
  </div>
</template>

<script>
export default {
  name: "section-holiday-park-feed",
  props: ["title", "display_title", "mode", "showFilter", "showTags", "showInfoBar", "category", "devices", "active"],

  data() {
    return {
      fields: null,
      options: [
        {
          value: 1,
          text: "Grid View: Accommodation",
        },
      ],
      categories: [],
    }
  },
  watch: {
    fields: {
      deep: true,
      handler: function (newValue, oldValue) {
        this.$emit("saved", newValue)
      },
    },
  },
  methods: {
    categoriesToDropDown(data) {
      let temp = [
        {
          value: 0,
          text: "All Accommodation (no category)",
        },
      ]

      for (let item of data) {
        temp.push({
          value: item.id,
          text: item.base.title,
        })
      }
      return temp
    },
  },
  beforeMount() {
    this.fields = Object.assign({}, this.$props)
  },
  mounted() {
    ;(async () => {
      try {
        const response = await this.$http.get("accommodation/category")
        this.categories = this.categoriesToDropDown(response.data)
      } catch (error) {
        console.log("No categories: ", error)
      }
    })()
  },
}
</script>
