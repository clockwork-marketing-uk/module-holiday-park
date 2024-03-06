import viewIndex from "./views/index";
import viewModelParkAccommodation from "./views/model-accommodation";
import viewModelParkAccommodationCategory from "./views/model-category";
import viewModelFacility from "./views/model-facility";
import viewModelPrice from "./views/model-price";

const routes = [
  {
    path: "/holiday-park",
    component: viewIndex,
    name: "holiday-park",
    meta: {
      breadcrumbs: {
        label: "Holiday Park",
      },
    },
  },
  {
    path: "/holiday-park/park-accommodation/model/:id",
    component: viewModelParkAccommodation,
    props: true,
    meta: {
      breadcrumbs: {
        label: "Park Accommodation",
        parent: "holiday-park",
      },
    },
  },
  {
    path: "/holiday-park/park-accommodation/category/:id",
    component: viewModelParkAccommodationCategory,
    props: true,
    meta: {
      breadcrumbs: {
        label: "Accommodation Category",
        parent: "holiday-park",
      },
    },
  },
  {
    path: "/holiday-park/park-accommodation/facility/:id",
    component: viewModelFacility,
    props: true,
    meta: {
      breadcrumbs: {
        label: "Facility",
        parent: "holiday-park",
      },
    },
  },
  {
    path: "holiday-park/park-accommodation/model/:accommodation_id/price/model/:price_id",
    component: viewModelPrice,
    props: true,
    meta: {
      breadcrumbs: {
        label: "Price Option",
        parent: "holiday-park",
      },
    },
  },
];

const cmsMenus = [
  {
    label: "Holiday Park",
    icon: "caravan",
    route: "/holiday-park",
    phpNamespace: "clockwork\\holidaypark",
  },
];

export { routes, cmsMenus };

