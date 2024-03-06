<template>
  <c-portlet :ready="ready">
    <template v-slot:header>
      <c-module-header title="Holiday Park Module" />
    </template>
    <template v-slot:body>
      <c-module-sub-header v-if="isNewRecord" title="Create new category" />
      <c-module-sub-header v-if="!isNewRecord" :title="'Update category ' + model.base.title" />
      <b-tabs>
        <b-tab title="Content">
          <b-form @submit="submit">
            <b-form-group label="Title *" :invalid-feedback="errors.first('title')">
              <b-form-input
                name="title"
                type="text"
                v-model="model.base.title"
                v-validate="'required'"
                :state="errors.has('title') ? false : null"
              />
            </b-form-group>
            <b-form-group label="Tagline">
              <b-form-input type="text" v-model="model.tagline" />
            </b-form-group>
            <b-form-group label="Excerpt">
              <c-text-editor v-model="model.text" />
            </b-form-group>
            <b-form-group label="Category image">
              <c-media-image-picker
                :width="$root.getSetting('accommodation_category_crop_x')"
                :height="$root.getSetting('accommodation_category_crop_y')"
                v-model="model.image"
              />
            </b-form-group>
            <b-form-group label="Enabled" label-for="active" description="Whether this category is enabled or not">
              <b-form-checkbox switch name="active" v-model="model.base.active" :value="1" :unchecked-value="0" />
            </b-form-group>
          </b-form>
        </b-tab>
        <b-tab title="Page Content">
          <b-form-group label="Page Sections Enabled?">
            <b-form-checkbox switch v-model="model.page_sections_enabled" :value="1" :unchecked-value="0" />
          </b-form-group>
          <b-card v-if="model.page_sections_enabled">
            <template #header> Additional Page Content </template>
            <c-page-section-builder v-model="model.sections" />
          </b-card>
        </b-tab>
        <b-tab title="SEO">
          <c-seo-form v-model="model.base" @touched:url_slug="flags.touchedSlug = true" />
        </b-tab>
      </b-tabs>
      <c-form-submit @save="submit('save')" @apply="submit('apply')" :validator="$validator" />
    </template>
  </c-portlet>
</template>

<script>
import slug from "cmsNode/slug"

export default {
  name: "model-category",
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
          meta_title: "",
          meta_description: "",
          header_scripts: "",
          body_scripts: "",
          og_image: "",
          active: 1,
          url: "/" + this.$root.getSetting("accommodation_route") + "/category/<slug>",
          url_slug: "",
        },
        id: 0,
        tagline: "",
        text: "",
        page_sections_enabled: 0,
        sections: null,
      },
      ready: false,
      failed: false,

      flags: {
        touchedSlug: false,
      },
    }
  },
  watch: {
    "model.base.title": function (newValue, oldValue) {
      if (!this.flags.touchedSlug && this.isNewRecord) {
        this.model.base.url_slug = slug(this.model.base.title)
      }
    },
  },
  computed: {
    isNewRecord: function () {
      return this.model.id == 0 && this.id == 0 ? true : false
    },
  },
  methods: {
    submit(event) {
      ;(async () => {
        try {
          if (this.isNewRecord) {
            let response = await this.$http.post("accommodation/category", {
              _method: "POST",
              model: this.model,
            })

            if (event == "save") {
              this.$router.push("/holiday-park")
            } else {
              this.$router.push("/holiday-park/park-accommodation/category/" + response.data.id)
              this.model.id = response.data.id
              this.$bvToast.toast(this.model.base.title + " has been created.", this.$root.toastSettings.success)
            }
          } else {
            //clear errors before attempting save
            this.$root.serverErrors = []

            // Update Model
            let response = await this.$http.post("accommodation/category/" + this.model.id, {
              _method: "POST",
              model: this.model,
            })

            if (event == "save") {
              this.$router.push("/holiday-park")
            } else {
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
    this.$nextTick(() => {
      if (!this.isNewRecord) {
        ;(async () => {
          try {
            const response = await this.$http.get("accommodation/category/" + this.id)
            this.model = response.data.category
            this.ready = true
          } catch (error) {
            console.error(error)
            this.failed = true
            this.ready = true
          }
        })()
      } else {
        this.ready = true
      }
    })
  },
}
</script>
