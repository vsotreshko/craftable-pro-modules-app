import { transChoice, trans } from "craftable-pro/plugins/laravel-vue-i18n";
import route from "ziggy-js";

declare module "vue" {
  interface ComponentCustomProperties {
    $t: typeof trans;
    $tChoice: typeof transChoice;
    route: typeof route;
  }
}
