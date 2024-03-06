<template>
  <c-portlet>
    <template v-slot:header>
      <c-module-header title="Holiday Park Module" />
    </template>
    <template v-slot:body>
      <c-module-sub-header v-if="isNewRecord" title="Create new facility" />
      <c-module-sub-header v-if="!isNewRecord" :title="'Update facility ' + facility.title" />
      <b-form>
        <b-form-group label="Facility Name *" label-for="title" :invalid-feedback="errors.first('title')">
          <b-form-input
            name="title"
            type="text"
            v-model="facility.title"
            v-validate="{ required: true }"
            :state="errors.has('title') ? false : null"
          />
        </b-form-group>
        <b-form-group label="Enabled" label-for="enabled" description="Whether this facility is enabled or not">
          <b-form-checkbox switch name="enabled" v-model="facility.active" :value="1" :unchecked-value="0" />
        </b-form-group>
        <c-form-submit @save="submit('save')" @apply="submit('apply')" :validator="$validator" />
      </b-form>
    </template>
  </c-portlet>
</template>

<script>
import slug from "cmsNode/slug"

export default {
  name: "model-facility",
  props: {
    id: {
      default: 0,
    },
  },
  data() {
    return {
      facility: {
        id: 0,
        title: "",
        active: 1,
      },
      serverErrors: [],
      ready: false,
      failed: false,
    }
  },
  computed: {
    isNewRecord: function () {
      return this.facility.id == 0 && this.id == 0 ? true : false
    },
  },
  methods: {
    submit(event) {
      ;(async () => {
        try {
          if (this.isNewRecord) {
            // Create Model
            let response = await this.$http.post("accommodation/facility", {
              _method: "POST",
              model: this.facility,
            })

            if (event == "save") {
              this.$router.push("/holiday-park?tab=facility")
            } else {
              this.$router.push("/holiday-park/facility/" + response.data.id)
              this.facility.id = response.data.id
              this.$bvToast.toast(this.facility.title + " has been created.", this.$root.toastSettings.success)
            }
          } else {
            this.$root.serverErrors = []
            let response = await this.$http.post("accommodation/facility/" + this.facility.id, {
              _method: "POST",
              model: this.facility,
            })
            if (event == "save") {
              this.$router.push("/holiday-park")
            } else {
              this.$bvToast.toast(this.facility.title + " has been saved.", this.$root.toastSettings.success)
            }
          }
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
          const response = await this.$http.get("accommodation/facility/" + this.id)
          this.facility = response.data.facility
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
