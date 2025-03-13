interface Window {
    username: string;
    categories: {
        [name: string]: {
            id: number;
            price: number;
            name: string;
            icon: string;
        }[];
    };
}

declare module "*.css" {
    export default {};
}
