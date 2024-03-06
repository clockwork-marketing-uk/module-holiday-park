<template>
  <c-portlet>
    <template v-slot:header>
      <c-module-header title="Holiday Park Module" />
    </template>
    <template v-slot:body>
      <b-tabs>
        <b-tab title="Park Accommodation" :active="activeTab == 'accommodation'">
          <c-module-sub-header title="Categories">
            <b-button to="/holiday-park/park-accommodation/category/0" variant="dark">Create category</b-button>
          </c-module-sub-header>

          <c-listgrid
            ref="listgridCategories"
            baseRoute="holiday-park/park-accommodation"
            itemRoute="category"
            dataSource="accommodation/category"
            @deleteItem="deleteCategory"
            @orderChanged="orderChangedCategory"
            :can-reorder="true"
          />

          <c-module-sub-header title="Accommodation" class="mt-4">
            <b-button to="/holiday-park/park-accommodation/model/0" variant="dark">Create Accommodation</b-button>
          </c-module-sub-header>

          <c-listgrid
            ref="listgridCategoriesAccommodation"
            baseRoute="holiday-park/park-accommodation"
            itemRoute="category"
            dataSource="accommodation/category/accommodation"
            :can-reorder="false"
            @orderChanged="orderChangedCategory"
            :can-edit="false"
            :can-delete="false"
          >
            <template v-slot:default="item">
              <c-listgrid
                baseRoute="holiday-park/park-accommodation"
                itemRoute="model"
                :itemData="item.item.accommodation"
                :canReorder="true"
                @deleteItem="deleteAccommodation"
                @orderChanged="orderChangedAccommodation"
                no-data-message="No accommodation within this category"
              />
            </template>
          </c-listgrid>
        </b-tab>
        <b-tab title="Facilities" :active="activeTab == 'facilities'">
          <c-module-sub-header title="Facilities" class="mt-4">
            <b-button to="/holiday-park/park-accommodation/facility/0" variant="dark">Create facility</b-button>
          </c-module-sub-header>

          <c-listgrid
            ref="listgridFacilities"
            baseRoute="holiday-park/park-accommodation"
            itemRoute="facility"
            dataSource="accommodation/facility"
            @deleteItem="deleteFacility"
            @orderChanged="orderChangedFacility"
            :can-reorder="true"
            :can-delete="true"
          />
        </b-tab>
      </b-tabs>
    </template>
  </c-portlet>
</template>

<script>
export default {
  name: "view-index",
  data() {
    return {
      activeTab: "accommodation",
    }
  },
  methods: {
    refresh() {
      this.$refs["listgridCategories"].refresh()
      this.$refs["listgridCategoriesAccommodation"].refresh()
      this.$refs["listgridFacilities"].refresh()
    },
    deleteCategory(category) {
      this.$http
        .delete("accommodation/category/" + category.id)
        .then((response) => {
          this.refresh()
        })
        .catch((error) => {
          console.error(error)
        })
    },
    deleteAccommodation(accommodation) {
      this.$http
        .delete("accommodation/model/" + accommodation.id)
        .then((response) => {
          this.refresh()
        })
        .catch((error) => {
          console.error(error)
        })

      this.$http
        .delete("holiday-park/park-accommodation/model/" + accommodation.id)
        .then((response) => {
        })
        .catch((error) => {
          console.error(error)
        })
    },
    orderChangedCategory(items) {
      ;(async () => {
        try {
          let response = await this.$http.post("accommodation/category/reorder", {
            _method: "POST",
            items: items,
          })
        } catch (error) {
          console.error(error)
        }
      })()
    },
    orderChangedAccommodation(accommodation) {
      ;(async () => {
        try {
          let response = await this.$http.post("accommodation/accommodation/reorder", {
            _method: "POST",
            items: accommodation,
          })
        } catch (error) {
          console.error(error)
        }
      })()
    },

    // facility functions
    deleteFacility(facility) {
      this.$http
        .delete("accommodation/facility/" + facility.id)
        .then((response) => {
          this.refresh()
        })
        .catch((error) => {
          console.error(error)
        })
    },

    orderChangedFacility(items) {
      ;(async () => {
        try {
          let response = await this.$http.post("accommodation/facility/reorder", {
            _method: "POST",
            items: items,
          })
        } catch (error) {
          console.error(error)
        }
      })()
    },
  },
  mounted() {
    const queryString = window.location.search

    const urlParams = new URLSearchParams(queryString)

    if (urlParams.get("tab")) {
      this.activeTab = urlParams.get("tab")
    }
  },
}
</script>
