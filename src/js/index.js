import getByJSON from './modules/getByJSON';
import getCartInfo from './modules/cart';
import calcCartPriceAndDelivery from './modules/calcCartPrice';

getByJSON();
calcCartPriceAndDelivery();
getCartInfo();