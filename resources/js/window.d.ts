interface Window {
    username: string;
    products: {
        id: number;
        price: number;
        name: string;
        icon: string;
    }[];
}

declare module "*.css" {
    export default {};
}
