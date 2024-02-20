import viewIndex from "./views/index";
import viewModelParkAccommodation from "./views/model-park-accommodation";

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
    path: "/holiday-park/park-accommodation/:id",
    component: viewModelParkAccommodation,
    props: true,
    meta: {
      breadcrumbs: {
        label: "Park Accommodation",
        parent: "holiday-park",
      },
    },
  },
  // {
  //   path: "/holiday-park/park-accommodation/:id",
  //   component: viewModelParkAccommodationCategory,
  //   props: true,
  //   meta: {
  //     breadcrumbs: {
  //       label: "Category",
  //       parent: "holiday-park",
  //     },
  //   },
  // },
];

const cmsMenus = [
  {
    label: "Park Accommodation",
    icon: "bed-front",
    route: "/park-accommodation",
    phpNamespace: "clockwork\\holidaypark",
  },
];

export { routes, cmsMenus };
