import getByJSON from "./modules/getByJSON";
import calcCartPriceAndDelivery from "./modules/calcCartPrice";
import toggleCartStatus from "./modules/toggleCartStatus";
import getCartInfo from "./modules/cart";

getByJSON();
calcCartPriceAndDelivery();
toggleCartStatus();
getCartInfo();
