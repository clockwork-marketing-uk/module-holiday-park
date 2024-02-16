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
    path: "/park-accommodation/model/:id",
    component: viewModelParkAccommodation,
    props: true,
    meta: {
      breadcrumbs: {
        label: "Park Accommodation",
        parent: "park-accommodation",
      },
    },
  },
  // {
  //   path: "/park-accommodation/category/:id",
  //   component: viewModelCategory,
  //   props: true,
  //   meta: {
  //     breadcrumbs: {
  //       label: "Category",
  //       parent: "accommodation",
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
