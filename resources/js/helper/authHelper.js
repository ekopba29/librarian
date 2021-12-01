const itemSanc = () => localStorage.getItem("Sanc");
export const getUser = () => JSON.parse(itemSanc())?.user;
export const token = () => JSON.parse(itemSanc())?.token;
export const getToken = () => 'Bearer ' + JSON.parse(itemSanc())?.token;
export const getRole = () => getUser()?.role;

